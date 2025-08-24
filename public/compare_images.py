import sys
import json
import cv2
import pymysql

def compare_images(query_image_path):
    sift = cv2.SIFT_create()

    query_image = cv2.imread(query_image_path, cv2.IMREAD_GRAYSCALE)
    if query_image is None:
        return {"success": False, "error": "Unable to load query image"}

    query_keypoints, query_descriptors = sift.detectAndCompute(query_image, None)
    if query_keypoints is None or query_descriptors is None:
        return {"success": False, "error": "Failed to compute descriptors"}

    try:
        conn = pymysql.connect(
            host="localhost", user="root", password="", database="plantbiodiversity"
        )
        cursor = conn.cursor(pymysql.cursors.DictCursor)
    except Exception as e:
        return {"success": False, "error": "Database connection failed"}

    try:
        cursor.execute("SELECT * FROM plant_table")
        plants = cursor.fetchall()
    except Exception as e:
        conn.close()
        return {"success": False, "error": "Database fetch error"}

    best_match = None
    highest_matches = 0

    for plant in plants:
        try:
            image_paths = json.loads(plant["plants_image"])
        except json.JSONDecodeError:
            continue

        for reference_image_path in image_paths:
            reference_image = cv2.imread(reference_image_path, cv2.IMREAD_GRAYSCALE)
            if reference_image is None:
                continue

            ref_keypoints, ref_descriptors = sift.detectAndCompute(reference_image, None)
            if ref_keypoints is None or ref_descriptors is None:
                continue

            bf = cv2.BFMatcher(cv2.NORM_L2, crossCheck=True)
            matches = bf.match(query_descriptors, ref_descriptors)
            good_matches = len(matches)

            if good_matches > highest_matches:
                highest_matches = good_matches
                best_match = plant

    conn.close()

    if best_match:
        return {
            "success": True,
            "match": True,
            "Scientific_Name": best_match["Scientific_Name"],
            "Common_Name": best_match["Common_Name"],
            "family": best_match["family"],
            "genus": best_match["genus"],
            "species": best_match["species"],
            "description": best_match["description"],
            "plants_image": best_match["plants_image"]
        }
    else:
        return {"success": True, "match": False}

if __name__ == "__main__":
    query_image_path = sys.argv[1]
    result = compare_images(query_image_path)
    print(json.dumps(result))
