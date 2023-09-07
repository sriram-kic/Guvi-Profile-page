<?php
include("config.php");
session_start();

if (isset($_SESSION['login_user'])) {
    $id = $_SESSION['login_user'];
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $dob = $_POST['dob'];
        $email = $_POST['email'];
        $pw = $_POST['pass'];
        $cont = $_POST['contact'];
        $city = $_POST['city'];
        $state = $_POST['state'];
        $zip = $_POST['zip'];

        // Check if a new image is uploaded
        if (!empty($_FILES['profilepic']['name'])) {
            $file_name = $_FILES['profilepic']['name'];
            $file_tmp = $_FILES['profilepic']['tmp_name'];
            $ext = pathinfo($file_name, PATHINFO_EXTENSION);
            $filePath = "" . $file_name;
            move_uploaded_file($file_tmp, "" . $file_name);

            // Update the profile picture in the database
            $updatePictureQuery = "UPDATE users SET profilepic='$filePath' WHERE id='$id'";
            $updatePictureResult = mysqli_query($db, $updatePictureQuery);

            if (!$updatePictureResult) {
                // Handle the error if updating the profile picture fails
                $response = [
                    'status' => 500,
                    'message' => 'Failed to update profile picture'
                ];
                echo json_encode($response);
                exit; // Exit the script
            }
        }

        // Update the other user information in the database
        $updateQuery = "UPDATE users SET dob='$dob', email='$email' , pass='$pw' , contact='$cont' , city='$city', state='$state',zip='$zip' WHERE id='$id'";
        $updateResult = mysqli_query($db, $updateQuery);

        if ($updateResult) {
            // Load existing data from data.json file
            $jsonData = file_get_contents('data.json');
            $data = json_decode($jsonData, true);

            // Check if data needs to be updated
            if (!isset($data['0']) || $data['0']['dob'] !== $dob || $data['0']['email'] !== $email || $data['0']['contact'] !== $cont || $data['0']['city'] !== $city || $data['0']['state'] !== $state || $data['0']['zip'] !== $zip) {
                // Update the user data in the array
                $data['0']['dob'] = $dob;
                $data['0']['email'] = $email;
                $data['0']['contact'] = $cont;
                $data['0']['city'] = $city;
                $data['0']['state'] = $state;
                $data['0']['zip'] = $zip;

                // Write the updated data back to data.json file
                file_put_contents('data.json', json_encode($data, JSON_PRETTY_PRINT));
            }

            $response = [
                'status' => 300,
                'message' => 'Profile updated successfully'
            ];
        } else {
            $response = [
                'status' => 500,
                'message' => 'Failed to update profile'
            ];
        }

        echo json_encode($response);
    }
}
?>
