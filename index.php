<?php
// login code
session_start();
include("config.php");
if(isset($_POST['save_login']))
{
    $mail = $_POST['email'];
    $passw = $_POST['pass'];

    if(empty($mail) || empty($passw))
    {
        $res = [
            'status' => 422,
            'message' => 'All fields are mandatory'
        ];
        echo json_encode($res);
        return;
    }

    // Use prepared statements to prevent SQL injection
    $query = "SELECT id FROM users WHERE email = ? AND pass = ?";
    $stmt = mysqli_prepare($db, $query);
    mysqli_stmt_bind_param($stmt, "ss", $mail, $passw);
    mysqli_stmt_execute($stmt);
    $query_run = mysqli_stmt_get_result($stmt);
    $count = mysqli_num_rows($query_run);

    if($count == 1)
    {
        $row = mysqli_fetch_assoc($query_run);
        $_SESSION['loggedin'] = true;
        $_SESSION['login_user'] = $row['id'];

        $res = [
            'status' => 300,
            'message' => 'Login Successfully'
        ];
        echo json_encode($res);
        return;
    }
    else
    {
        $res = [
            'status' => 500,
            'message' => 'Username/Password wrong'
        ];
        echo json_encode($res);
        return;
    }
}
?>


<?php
if (isset($_POST['saveuser'])) {
    // Include your config.php file here
    include("config.php");

    $name = mysqli_real_escape_string($db, $_POST['name']);
    $uname = mysqli_real_escape_string($db, $_POST['username']);
    $dob = mysqli_real_escape_string($db, $_POST['dob']);
    $email = mysqli_real_escape_string($db, $_POST['email']);
    $pass = mysqli_real_escape_string($db, $_POST['pass']);
    $gen = mysqli_real_escape_string($db, $_POST['gender']);
    $contact = mysqli_real_escape_string($db, $_POST['contact']);
    $city = mysqli_real_escape_string($db, $_POST['city']);
    $state = mysqli_real_escape_string($db, $_POST['state']);
    $zip = mysqli_real_escape_string($db, $_POST['zip']);

    if (empty($name) || empty($uname) || empty($dob) || empty($email) || empty($pass) || empty($gen) || empty($contact) || empty($city) || empty($state) || empty($zip)) {
        $res = [
            'status' => 422,
            'message' => 'All fields are mandatory'
        ];
        echo json_encode($res);
        return;
    }

    $query = "INSERT INTO users (name, username, dob, email, pass, gender, contact, city, state, zip) VALUES('$name', '$uname', '$dob', '$email', '$pass', '$gen', '$contact', '$city', '$state', '$zip')";
    $query_run = mysqli_query($db, $query);

    if ($query_run) {
        // Registration in the database successful

        // JSON file update
        $jsonFilePath = 'data.json';

        // Create an array with the user data to be added to the JSON file
        $newUserData = [
            'name' => $name,
            'username' => $uname,
            'dob' => $dob,
            'email' => $email,
            'pass' => $pass,
            'gender' => $gen,
            'contact' => $contact,
            'city' => $city,
            'state' => $state,
            'zip' => $zip,
        ];

        // Read existing JSON data
        $jsonString = file_get_contents($jsonFilePath);
        $jsonData = json_decode($jsonString, true);

        if ($jsonData === null) {
            $jsonData = [];
        }

        // Add new user data to the existing JSON data
        $jsonData[] = $newUserData;

        // Encode the updated data and write it back to the JSON file
        $updatedJsonString = json_encode($jsonData, JSON_PRETTY_PRINT);
        if (file_put_contents($jsonFilePath, $updatedJsonString)) {
            // JSON file updated successfully
            $res = [
                'status' => 200,
                'message' => 'Registration Successful'
            ];
            echo json_encode($res);
            return;
        } else {
            $res = [
                'status' => 500,
                'message' => 'Failed to update JSON file'
            ];
            echo json_encode($res);
            return;
        }
    } else {
        $res = [
            'status' => 500,
            'message' => 'Server Error. Registration Failed'
        ];
        echo json_encode($res);
        return;
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
    </script>
    <script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <title>Sign in</title>
</head>

<body>
    <!-- Modal -->
    <div class="modal fade exampleModal" id="adduser" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="fw-bolder" style="text-align: center; align-items: center; justify-content: center;">
                        REGISTER HERE !</h3>
                    <!-- form register section -->
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="saveuser" method="post">
                        <div id="errorMessagei" class="alert alert-warning d-none"></div>
                        <div class="card text-center">
                            <div class="card-body">
                                <div class="mb-2">
                                    <label class="visually-hidden" for="nameInput">Name</label>
                                    <input type="text" class="form-control" id="nameInput" name="name"
                                        placeholder="Name">
                                </div>

                                <div class="mb-2">
                                    <label class="visually-hidden" for="usernameInput">Username</label>
                                    <div class="input-group">
                                        <div class="input-group-text">@</div>
                                        <input type="text" class="form-control" name="username" id="usernameInput"
                                            placeholder="Username">
                                    </div>
                                </div>

                                <div class="mb-2">
                                    <label class="visually-hidden" for="dobInput">DOB</label>
                                    <input type="date" class="form-control" id="dobInput" name="dob" placeholder="dd-mm-yyy">
                                </div>

                                <div class="mb-2">
                                    <input type="email" class="form-control" id="emailInput" name="email"
                                        placeholder="example@gmail.com">
                                </div>

                                <div class="mb-2">
                                    <input type="password" class="form-control" id="passwordInput" name="pass"
                                        placeholder="Password">
                                    <span class="password__icon text-primary fs-4 fw-bold bi bi-eye-slash"></span>
                                </div>

                                <div class="d-md-flex justify-content-start align-items-left mb-2 py-2">
                                    <h6 class="mb-0 me-4">Gender: </h6>

                                    <div class="form-check form-check-inline mb-0 me-4">
                                        <input class="form-check-input" name="gender" type="radio" id="femaleGender"
                                            value="male" />
                                        <label class="form-check-label" for="femaleGender">Male</label>
                                    </div>

                                    <div class="form-check form-check-inline mb-0 me-4">
                                        <input class="form-check-input" name="gender" type="radio" id="maleGender"
                                            value="female" />
                                        <label class="form-check-label" for="maleGender">Female</label>
                                    </div>
                                </div>

                                <div class="mb-2">
                                    <label class="visually-hidden" for="contactInput">Contact</label>
                                    <input type="text" class="form-control" id="contactInput" name="contact"
                                        placeholder="Contact">
                                </div>

                                <div class="mb-2">
                                    <label class="visually-hidden" for="cityInput">City</label>
                                    <input type="text" class="form-control" id="cityInput" name="city"
                                        placeholder="City">
                                </div>

                                <select class="form-select" id="stateSelect" name="state"
                                    aria-label="Floating label select example">
                                    <option value="Tamilnadu">
                                        Tamilnadu</option>
                                    <option value="Kerala">Kerala
                                    </option>
                                </select>

                                <div class="mb-2">
                                    <label class="visually-hidden" for="zipInput">Zip Code</label>
                                    <input type="text" class="form-control" id="zipInput" name="zip"
                                        placeholder="Zip Code">
                                </div>

                            </div>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" name="saveuser">Signup</button>
                </div>
                </form>
            </div>
        </div>
    </div>


    <div class="container d-flex min-vh-100 align-items-center justify-content-center">
        <div class="row">
            <div class="col-lg-6 col-md-12">
                <img src="img/Mobile login.gif" alt="" class="img-fluid">
            </div>
            <!-- Login form -->
            <div class="col-lg-6 col-md-12">
                <h6 style="text-align: center;">WELCOME BACK!</h6>
                <form id="login" class="mt-1">
                    <div id="loginerrorMessage" class="alert alert-warning d-none"></div>
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Email address</label>
                        <div class="input-group">
                            <input type="email" class="form-control" name="email" placeholder="name@example.com"
                                aria-describedby="emailHelp">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputPassword1" class="form-label">Password</label>
                        <div class="input-group">
                            <input type="password" class="form-control" placeholder="Password" name="pass">
                        </div>
                    </div>


                    <div class="forgot mt-3">
                        <p style="text-align: end;">
                            <a href="#" class="link-offset-2 link-underline link-underline-opacity-0"
                                data-bs-toggle="modal" data-bs-target="#exampleModal">Forgotten password?</a>
                        </p>
                    </div>
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary" name="login">Login</button>
                    </div>
                </form>
                <!-- Button trigger modal -->
                <div class="d-grid gap-2 mt-3">
                    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target=".exampleModal">
                        Create account
                    </button>
                </div>
            </div>
        </div>
    </div>


    <!-- Register -->

    <script>
    $(document).on('submit', '#saveuser', function(e) {
        e.preventDefault();

        var formData = new FormData(this);
        formData.append("saveuser", true);
        $.ajax({
            type: "POST",
            url: "index.php", // Correct the URL if needed
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                var res = JSON.parse(response);

                if (res.status == 422) {
                    $('#errorMessagei').removeClass('d-none');
                    $('#errorMessagei').text(res.message);
                    alertify.set('notifier', 'position', 'top-right');
                    alertify.success(res.message);
                } else if (res.status == 200) {
                    Swal.fire(
                        'Congratulations!',
                        'your account has been successfully created',
                        'success'
                    )
                    window.location.href = "index.php";
                } else if (res.status == 400) {
                    $('#errorMessagei').addClass('d-none');
                    $('#saveuser')[0].reset();
                    alertify.set('notifier', 'position', 'top-right');
                    alertify.success(res.message);
                }
            },
        });
    });
    </script>

    <!--LOGIN SCRIPT-->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
    $('#login').on('submit', function(e) {
        e.preventDefault();

        var formData = new FormData(this);
        formData.append("save_login", true);

        $.ajax({
            type: "POST",
            url: "index.php",
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                var res = JSON.parse(response);
                if (res.status == 422 || res.status == 500) {
                    $('#loginerrorMessage').removeClass('d-none').text(res.message);
                } else if (res.status == 300) {
                    Swal.fire(
                        'Login successfully',
                        'success'
                    )
                    window.location.href = "profile.php";
                }
            },
            error: function() {
                console.log("An error occurred during the AJAX request.");
            }
        });
    });
    </script>



    <!--Forgot password Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="forgot-password-modal-label">Forgot Password</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </button>
                </div>
                <div class="modal-body">
                    <form id='reset' method="post">
                        <div class="form-group mb-2">
                            <label for="email">Email address</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Reset Password</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!--End Forgot password Modal -->

    <!-- Forgot password -->
    <script>
    $(document).ready(function() {
        $('#reset').on('submit', function(event) {
            event.preventDefault();

            // Get the email address from the form.
            var email = $('#email').val();

            // AJAX request to send the email.
            $.ajax({
                url: 'forgotpw.php',
                type: 'POST',
                data: {
                    email: email
                },
                success: function(data) {
                    if (data == 'success') {
                        // The email was sent successfully.
                        $('#exampleModal').modal('hide');
                        alert(
                            'An email has been sent to your email address with a link to reset your password.'
                            );
                    } else {
                        // The email was not sent successfully.
                        alert(
                            'There was an error sending the email. Please try again later.'
                            );
                    }
                }
            });
        });
    });
    </script>

</body>

</html>