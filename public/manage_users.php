    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Manage User Accounts</title>
        <!-- Bootstrap CSS for a modern look -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <!-- DataTables CSS with Bootstrap integration -->
        <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap4.min.css">
        <!-- jQuery -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <!-- Bootstrap JS for better styling -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <!-- DataTables JS with Bootstrap integration -->
        <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap4.min.js"></script>
    </head>
    <body>
    <?php include 'admin-header.php'; ?>

    <div class="container">
        <h2 class="text-center">Manage User Accounts</h2>
        <table id="userTable" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                    <th>Date of Birth</th>
                    <th>Gender</th>
                    <th>Contact Number</th>
                    <th>Hometown</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                require_once 'db_connection.php';
                $result = $conn->query("SELECT * FROM user_table");

                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td class='editable' data-column='first_name'>" . htmlspecialchars($row['first_name']) . "</td>";
                    echo "<td class='editable' data-column='last_name'>" . htmlspecialchars($row['last_name']) . "</td>";
                    echo "<td class='editable' data-column='email'>" . htmlspecialchars($row['email']) . "</td>";
                    echo "<td class='editable' data-column='dob'>" . htmlspecialchars($row['dob']) . "</td>";
                    echo "<td class='editable' data-column='gender'>" . htmlspecialchars($row['gender']) . "</td>";
                    echo "<td class='editable' data-column='contact_number'>" . htmlspecialchars($row['contact_number']) . "</td>";
                    echo "<td class='editable' data-column='hometown'>" . htmlspecialchars($row['hometown']) . "</td>";
                    echo "<td>
                        <button style = 'margin-bottom:10px; width:80px;' class='btn btn-success btn-sm saveBtn' data-id='" . $row['email'] . "'><i class='fas fa-save'></i>Save</button>
                        <button class='deleteBtn' data-id='" . $row['email'] . "'>Delete</button>
                        </td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
    <!-- Add New User Button -->
    <div class="container">
        <button class="btn btn-primary" data-toggle="modal" data-target="#addUserModal">Add New User</button>
    </div>

    <!-- Modal for Adding New User -->
    <div class="modal fade" id="addUserModal" tabindex="-1" role="dialog" aria-labelledby="addUserModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 style="color:black" class="modal-title" id="addUserModalLabel">Add New User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form style="color:black" id="addUserForm">
                        <div class="form-group">
                            <label for="firstName">First Name</label>
                            <input type="text" class="form-control" id="firstName" required>
                        </div>
                        <div class="form-group">
                            <label for="lastName">Last Name</label>
                            <input type="text" class="form-control" id="lastName" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" required>
                        </div>
                        <div class="form-group">
                            <label for="dob">Date of Birth</label>
                            <input type="date" class="form-control" id="dob" required>
                        </div>
                        <div class="form-group">
                            <label for="gender">Gender</label>
                            <select class="form-control" id="gender" required>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="contactNumber">Contact Number</label>
                            <input type="text" class="form-control" id="contactNumber" required>
                        </div>
                        <div class="form-group">
                            <label for="hometown">Hometown</label>
                            <input type="text" class="form-control" id="hometown" required>
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" id="password" required>
                        </div>
                        <div class="form-group">
                            <label for="accountType">Account Type</label>
                            <select class="form-control" id="accountType" required>
                                <option value="user">User</option>
                                <option value="admin">Admin</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Save User</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <script>
    $(document).ready(function() {
        // Initialize DataTable
        $('#userTable').DataTable({
            "paging": true,
            "ordering": true,
            "info": true,
            "searching": true,
            "language": {
                "search": "Filter records:"
            }
        });

        // Enable inline editing on table cells
        $('.editable').on('click', function() {
            var $cell = $(this);
            if ($cell.attr('contenteditable') === 'true') return; // If already editable, do nothing

            // Make the clicked cell editable
            $cell.attr('contenteditable', 'true');
            $cell.focus();
        });

        // Handle the save functionality
        $('.saveBtn').on('click', function() {
            var row = $(this).closest('tr');
            var email = row.find('.editable[data-column="email"]').text();  // Get the email to identify the user
            var updatedData = {};

            // Get the edited data from each cell
            row.find('.editable').each(function() {
                var column = $(this).data('column');
                var value = $(this).text().trim();  // Trim any whitespace
                updatedData[column] = value;
                $(this).attr('contenteditable', 'false');  // Disable further editing on this cell
            });

            // Send the updated data to the server
            $.ajax({
                url: 'update_user.php', // Create this PHP script to handle the update
                type: 'POST',
                data: {
                    email: email,
                    updatedData: updatedData
                },
                success: function(response) {
                    alert(response); // Show server response
                    location.reload(); // Reload the page to reflect changes
                },
                error: function() {
                    alert('Error updating data.');
                }
            });
        });

        // Delete functionality
        $('.deleteBtn').on('click', function() {
            const userEmail = $(this).data('id'); // Get the email from the data-id attribute
            if (confirm('Are you sure you want to delete this user?')) {
                $.ajax({
                    url: 'delete_user.php', // The delete script URL
                    type: 'POST',
                    data: { id: userEmail }, // Send the email to delete
                    success: function(response) {
                        if (response === 'success') {
                            alert('User deleted successfully');
                            location.reload(); // Reload the page after deletion
                        } else {
                            alert('Failed to delete user: ' + response);
                        }
                    },
                    error: function() {
                        alert('There was an error with the delete request.');
                    }
                });
            }
        });
    });
    // Handle the form submission for adding a new user
    $('#addUserForm').on('submit', function(event) {
        event.preventDefault();

        var newUserData = {
            firstName: $('#firstName').val(),
            lastName: $('#lastName').val(),
            email: $('#email').val(),
            dob: $('#dob').val(),
            gender: $('#gender').val(),
            contactNumber: $('#contactNumber').val(),
            hometown: $('#hometown').val(),
            password: $('#password').val(), // Collect the password
            accountType: $('#accountType').val() // Collect the account type
        };

        // Send the new user data to the server
        $.ajax({
            url: 'add_user.php', // PHP script that handles adding the user
            type: 'POST',
            data: newUserData,
            success: function(response) {
                alert(response); // Show server response
                if (response === 'User added successfully') {
                    $('#addUserModal').modal('hide'); // Close the modal
                    location.reload(); // Reload the page to show the new user
                }
            },
            error: function() {
                alert('Error adding user.');
            }
        });
    });
    </script>

    </body>
    </html>
