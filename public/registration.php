<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
    <style>
        .container {
            margin-top: 30px;
            background-color: rgba(255, 255, 255, 0.9);
            padding: 30px;
            border-radius: 20px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
       .btn-custom {
            background: linear-gradient(to right, #43A047, #66BB6A);
            color: white;
            border: none;
            transition: transform 0.3s ease, background 0.3s ease, box-shadow 0.3s ease;
        }
        .btn-custom:hover {
            background: linear-gradient(to right, #388E3C, #4CAF50);
            transform: scale(1.05);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }
        .btn-secondary {
            background: linear-gradient(to right, #9E9E9E, #BDBDBD);
            transition: transform 0.3s ease, background 0.3s ease, box-shadow 0.3s ease;
        }
        .btn-secondary:hover {
            background: linear-gradient(to right, #757575, #9E9E9E);
            transform: scale(1.05);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }
    </style>
</head>
<body>
    <?php include 'header.php'?>
    <div class="container col-md-6">
        <h2>Register New Account</h2>
        <form action="process_register.php" method="POST" onsubmit="validateForm(event)" novalidate>
            <div class="row">
                <div class="form-group col-md-6 mb-3">
                    <div class="form-floating">
                        <input type="text" name="first_name" class="form-control" id="first_name" placeholder="First Name">
                        <label for="first_name">First Name</label>
                    </div>
                </div>
                <div class="form-group col-md-6">
                    <div class="form-floating">
                        <input type="text" name="last_name" class="form-control" id="last_name" placeholder="Last Name">
                        <label for="last_name">Last Name</label>
                    </div>
                </div>
            </div>
            <div class="form-group col-md-12 mb-3">
                <div class="form-floating mb-3">
                    <input type="date" name="dob" class="form-control" id="dob" placeholder="Date of Birth">
                    <label for="dob">Date of Birth</label>
                </div>
                <div class="form-floating mb-3">
                    <select name="gender" class="form-select" id="gender">
                        <option value="Female" selected>Female</option>
                        <option value="Male">Male</option>
                    </select>
                    <label for="gender">Gender</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="email" name="email" class="form-control" id="email" placeholder="Email">
                    <label for="email">Email</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" name="hometown" class="form-control" id="hometown" placeholder="Hometown">
                    <label for="hometown">Hometown</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="password" name="password" class="form-control" id="password" placeholder="Password">
                    <label for="password">Password</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="password" name="confirm_password" class="form-control" id="confirm_password" placeholder="Confirm Password">
                    <label for="confirm_password">Confirm Password</label>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <button type="submit" class="btn btn-custom w-100">Register</button>
                </div>
                <div class="col-md-6">
                    <button type="reset" class="btn btn-secondary w-100">Reset</button>
                </div>
            </div>
        </form>
        <div class="text-center mt-3">
            <p>Already have an account? <a href="login.php">Login here</a></p>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>
    
    <script>
    function validateForm(event) {
        let firstName = document.getElementById('first_name').value.trim();
        let lastName = document.getElementById('last_name').value.trim();
        let dob = document.getElementById('dob').value;
        let email = document.getElementById('email').value.trim();
        let hometown = document.getElementById('hometown').value.trim();
        let password = document.getElementById('password').value;
        let confirmPassword = document.getElementById('confirm_password').value;

        if (!firstName || !lastName || !dob || !email || !hometown || !password || !confirmPassword) {
            event.preventDefault();
            swal("Oops!", "Please fill in all fields.", "error");
        } else if (password !== confirmPassword) {
            event.preventDefault();
            swal("Oops!", "Passwords do not match.", "error");
        }
    }
    </script>
</body>
</html>
