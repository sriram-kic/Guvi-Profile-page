<?php
include "config.php";
session_start();
if (isset($_SESSION['login_user'])) {
    $id = $_SESSION['login_user'];
    $sql = "SELECT * FROM users WHERE id ='$id';";
    $run = mysqli_query($db, $sql);

    if ($run) {
        if (mysqli_num_rows($run) > 0) {
            $val = mysqli_fetch_assoc($run);
            $name = $val['name'];
            $uname = $val['username'];
            $dob = $val['dob'];
            $email = $val['email'];
            $pw = $val['pass'];
            $gen = $val['gender'];
            $cont = $val['contact'];
            $city = $val['city'];
            $state = $val['state'];
            $zip = $val['zip'];
            $pic = $val['profilepic'];

                $birthYear = new DateTime($dob);
                $today = new DateTime();
                $age = $birthYear->diff($today);
                $ag=$age->y;
        }
    }
}

?>




<!doctype html>
<html lang="en" data-bs-theme="auto">

<head>
    <script src="../assets/js/color-modes.js"></script>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.115.4">
    <title>Dashboard Template · Bootstrap v5.3</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.min.js"
        integrity="sha384-Rx+T1VzGupg4BHQYs2gCW9It+akI2MM/mndMCy36UVfodzcJcF0GGLxZIzObiEfa" crossorigin="anonymous">
    </script>
    <link rel="canonical" href="https://getbootstrap.com/docs/5.3/examples/dashboard/">



    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@docsearch/css@3">

    <link href="../assets/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
    .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        user-select: none;
    }

    @media (min-width: 768px) {
        .bd-placeholder-img-lg {
            font-size: 3.5rem;
        }
    }

    .b-example-divider {
        width: 100%;
        height: 3rem;
        background-color: rgba(0, 0, 0, .1);
        border: solid rgba(0, 0, 0, .15);
        border-width: 1px 0;
        box-shadow: inset 0 .5em 1.5em rgba(0, 0, 0, .1), inset 0 .125em .5em rgba(0, 0, 0, .15);
    }

    .b-example-vr {
        flex-shrink: 0;
        width: 1.5rem;
        height: 100vh;
    }

    .bi {
        vertical-align: -.125em;
        fill: currentColor;
    }

    .nav-scroller {
        position: relative;
        z-index: 2;
        height: 2.75rem;
        overflow-y: hidden;
    }

    .nav-scroller .nav {
        display: flex;
        flex-wrap: nowrap;
        padding-bottom: 1rem;
        margin-top: -1px;
        overflow-x: auto;
        text-align: center;
        white-space: nowrap;
        -webkit-overflow-scrolling: touch;
    }

    .btn-bd-primary {
        --bd-violet-bg: #712cf9;
        --bd-violet-rgb: 112.520718, 44.062154, 249.437846;

        --bs-btn-font-weight: 600;
        --bs-btn-color: var(--bs-white);
        --bs-btn-bg: var(--bd-violet-bg);
        --bs-btn-border-color: var(--bd-violet-bg);
        --bs-btn-hover-color: var(--bs-white);
        --bs-btn-hover-bg: #6528e0;
        --bs-btn-hover-border-color: #6528e0;
        --bs-btn-focus-shadow-rgb: var(--bd-violet-rgb);
        --bs-btn-active-color: var(--bs-btn-hover-color);
        --bs-btn-active-bg: #5a23c8;
        --bs-btn-active-border-color: #5a23c8;
    }

    .bd-mode-toggle {
        z-index: 1500;
    }
    </style>


    <!-- Custom styles for this template -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="dashboard.css" rel="stylesheet">
</head>

<body>


    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="update" enctype="multipart/form-data" method="POST">
                    <!-- Form tag surrounds the entire modal -->
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Update user details</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div id="errorMessagei" class="alert alert-warning d-none"></div>
                        <div class="card text-center">
                            <div class="card-body">
                                <div class="col-auto mb-2">
                                    <label class="visually-hidden" for="nameInput">Name</label>
                                    <input type="text" class="form-control" id="nameInput" name="name"
                                        value="<?php echo $name; ?>" disabled readonly>
                                </div>

                                <div class="col-auto mb-2">
                                    <label class="visually-hidden" for="usernameInput">Username</label>
                                    <div class="input-group">
                                        <div class="input-group-text">@</div>
                                        <input type="text" class="form-control" name="username" id="usernameInput"
                                            value="<?php echo $uname; ?>" disabled readonly>
                                    </div>
                                </div>

                                <div class="col-auto mb-2">
                                    <label class="visually-hidden" for="dobInput">DOB</label>
                                    <input type="date" class="form-control" id="dobInput" name="dob"
                                        value="<?php echo $dob; ?>">
                                </div>

                                <div class="mb-2">
                                    <input type="email" class="form-control" id="emailInput" name="email"
                                        value="<?php echo $email; ?>">
                                </div>

                                <div class="mb-2">
                                    <input type="password" class="form-control" id="passwordInput" name="pass"
                                        value="<?php echo $pw; ?>">
                                </div>


                                <div class="mb-2">
                                    <label class="visually-hidden" for="contactInput">Contact</label>
                                    <input type="text" class="form-control" id="contactInput" name="contact"
                                        value="<?php echo $cont; ?>">
                                </div>

                                <div class="mb-2">
                                    <label class="visually-hidden" for="cityInput">City</label>
                                    <input type="text" class="form-control" id="cityInput" name="city"
                                        value="<?php echo $city; ?>">
                                </div>

                                <select class="form-select" id="stateSelect" name="state"
                                    aria-label="Floating label select example">
                                    <option value="Tamilnadu" <?php if ($state==="Tamilnadu" ) echo "selected" ; ?>>
                                        Tamilnadu</option>
                                    <option value="Kerala" <?php if ($state==="Kerala" ) echo "selected" ; ?>>Kerala
                                    </option>
                                </select>

                                <div class="mb-2">
                                    <label class="visually-hidden" for="zipInput">Zip Code</label>
                                    <input type="text" class="form-control" id="zipInput" name="zip"
                                        value="<?php echo $zip; ?>">
                                </div>
                                <div class="mb-3">
                                    <input type="file" name="profilepic" accept="image/*" class="form-control"
                                        id="profilePicInput">
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary" name="update">Save changes</button>
                    </div>
                </form> <!-- Form tag ends here -->
            </div>
        </div>
    </div>

    <!-- End of Modal -->


    <svg xmlns="http://www.w3.org/2000/svg" class="d-none">
        <symbol id="check2" viewBox="0 0 16 16">
            <path
                d="M13.854 3.646a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L6.5 10.293l6.646-6.647a.5.5 0 0 1 .708 0z" />
        </symbol>
        <symbol id="circle-half" viewBox="0 0 16 16">
            <path d="M8 15A7 7 0 1 0 8 1v14zm0 1A8 8 0 1 1 8 0a8 8 0 0 1 0 16z" />
        </symbol>
        <symbol id="moon-stars-fill" viewBox="0 0 16 16">
            <path
                d="M6 .278a.768.768 0 0 1 .08.858 7.208 7.208 0 0 0-.878 3.46c0 4.021 3.278 7.277 7.318 7.277.527 0 1.04-.055 1.533-.16a.787.787 0 0 1 .81.316.733.733 0 0 1-.031.893A8.349 8.349 0 0 1 8.344 16C3.734 16 0 12.286 0 7.71 0 4.266 2.114 1.312 5.124.06A.752.752 0 0 1 6 .278z" />
            <path
                d="M10.794 3.148a.217.217 0 0 1 .412 0l.387 1.162c.173.518.579.924 1.097 1.097l1.162.387a.217.217 0 0 1 0 .412l-1.162.387a1.734 1.734 0 0 0-1.097 1.097l-.387 1.162a.217.217 0 0 1-.412 0l-.387-1.162A1.734 1.734 0 0 0 9.31 6.593l-1.162-.387a.217.217 0 0 1 0-.412l1.162-.387a1.734 1.734 0 0 0 1.097-1.097l.387-1.162zM13.863.099a.145.145 0 0 1 .274 0l.258.774c.115.346.386.617.732.732l.774.258a.145.145 0 0 1 0 .274l-.774.258a1.156 1.156 0 0 0-.732.732l-.258.774a.145.145 0 0 1-.274 0l-.258-.774a1.156 1.156 0 0 0-.732-.732l-.774-.258a.145.145 0 0 1 0-.274l.774-.258c.346-.115.617-.386.732-.732L13.863.1z" />
        </symbol>
        <symbol id="sun-fill" viewBox="0 0 16 16">
            <path
                d="M8 12a4 4 0 1 0 0-8 4 4 0 0 0 0 8zM8 0a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 0zm0 13a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 13zm8-5a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2a.5.5 0 0 1 .5.5zM3 8a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2A.5.5 0 0 1 3 8zm10.657-5.657a.5.5 0 0 1 0 .707l-1.414 1.415a.5.5 0 1 1-.707-.708l1.414-1.414a.5.5 0 0 1 .707 0zm-9.193 9.193a.5.5 0 0 1 0 .707L3.05 13.657a.5.5 0 0 1-.707-.707l1.414-1.414a.5.5 0 0 1 .707 0zm9.193 2.121a.5.5 0 0 1-.707 0l-1.414-1.414a.5.5 0 0 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .707zM4.464 4.465a.5.5 0 0 1-.707 0L2.343 3.05a.5.5 0 1 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .708z" />
        </symbol>
    </svg>




    <svg xmlns="http://www.w3.org/2000/svg" class="d-none">
        <symbol id="calendar3" viewBox="0 0 16 16">
            <path
                d="M14 0H2a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2zM1 3.857C1 3.384 1.448 3 2 3h12c.552 0 1 .384 1 .857v10.286c0 .473-.448.857-1 .857H2c-.552 0-1-.384-1-.857V3.857z" />
            <path
                d="M6.5 7a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm-9 3a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm-9 3a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2z" />
        </symbol>
        <symbol id="cart" viewBox="0 0 16 16">
            <path
                d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .49.598l-1 5a.5.5 0 0 1-.465.401l-9.397.472L4.415 11H13a.5.5 0 0 1 0 1H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5zM3.102 4l.84 4.479 9.144-.459L13.89 4H3.102zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2z" />
        </symbol>
        <symbol id="chevron-right" viewBox="0 0 16 16">
            <path fill-rule="evenodd"
                d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708z" />
        </symbol>
        <symbol id="door-closed" viewBox="0 0 16 16">
            <path d="M3 2a1 1 0 0 1 1-1h8a1 1 0 0 1 1 1v13h1.5a.5.5 0 0 1 0 1h-13a.5.5 0 0 1 0-1H3V2zm1 13h8V2H4v13z" />
            <path d="M9 9a1 1 0 1 0 2 0 1 1 0 0 0-2 0z" />
        </symbol>
        <symbol id="file-earmark" viewBox="0 0 16 16">
            <path
                d="M14 4.5V14a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2h5.5L14 4.5zm-3 0A1.5 1.5 0 0 1 9.5 3V1H4a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V4.5h-2z" />
        </symbol>
        <symbol id="file-earmark-text" viewBox="0 0 16 16">
            <path
                d="M5.5 7a.5.5 0 0 0 0 1h5a.5.5 0 0 0 0-1h-5zM5 9.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm0 2a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5z" />
            <path
                d="M9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V4.5L9.5 0zm0 1v2A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h5.5z" />
        </symbol>
        <symbol id="gear-wide-connected" viewBox="0 0 16 16">
            <path
                d="M7.068.727c.243-.97 1.62-.97 1.864 0l.071.286a.96.96 0 0 0 1.622.434l.205-.211c.695-.719 1.888-.03 1.613.931l-.08.284a.96.96 0 0 0 1.187 1.187l.283-.081c.96-.275 1.65.918.931 1.613l-.211.205a.96.96 0 0 0 .434 1.622l.286.071c.97.243.97 1.62 0 1.864l-.286.071a.96.96 0 0 0-.434 1.622l.211.205c.719.695.03 1.888-.931 1.613l-.284-.08a.96.96 0 0 0-1.187 1.187l.081.283c.275.96-.918 1.65-1.613.931l-.205-.211a.96.96 0 0 0-1.622.434l-.071.286c-.243.97-1.62.97-1.864 0l-.071-.286a.96.96 0 0 0-1.622-.434l-.205.211c-.695.719-1.888.03-1.613-.931l.08-.284a.96.96 0 0 0-1.186-1.187l-.284.081c-.96.275-1.65-.918-.931-1.613l.211-.205a.96.96 0 0 0-.434-1.622l-.286-.071c-.97-.243-.97-1.62 0-1.864l.286-.071a.96.96 0 0 0 .434-1.622l-.211-.205c-.719-.695-.03-1.888.931-1.613l.284.08a.96.96 0 0 0 1.187-1.186l-.081-.284c-.275-.96.918-1.65 1.613-.931l.205.211a.96.96 0 0 0 1.622-.434l.071-.286zM12.973 8.5H8.25l-2.834 3.779A4.998 4.998 0 0 0 12.973 8.5zm0-1a4.998 4.998 0 0 0-7.557-3.779l2.834 3.78h4.723zM5.048 3.967c-.03.021-.058.043-.087.065l.087-.065zm-.431.355A4.984 4.984 0 0 0 3.002 8c0 1.455.622 2.765 1.615 3.678L7.375 8 4.617 4.322zm.344 7.646.087.065-.087-.065z" />
        </symbol>
        <symbol id="graph-up" viewBox="0 0 16 16">
            <path fill-rule="evenodd"
                d="M0 0h1v15h15v1H0V0Zm14.817 3.113a.5.5 0 0 1 .07.704l-4.5 5.5a.5.5 0 0 1-.74.037L7.06 6.767l-3.656 5.027a.5.5 0 0 1-.808-.588l4-5.5a.5.5 0 0 1 .758-.06l2.609 2.61 4.15-5.073a.5.5 0 0 1 .704-.07Z" />
        </symbol>
        <symbol id="house-fill" viewBox="0 0 16 16">
            <path
                d="M8.707 1.5a1 1 0 0 0-1.414 0L.646 8.146a.5.5 0 0 0 .708.708L8 2.207l6.646 6.647a.5.5 0 0 0 .708-.708L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293L8.707 1.5Z" />
            <path d="m8 3.293 6 6V13.5a1.5 1.5 0 0 1-1.5 1.5h-9A1.5 1.5 0 0 1 2 13.5V9.293l6-6Z" />
        </symbol>
        <symbol id="list" viewBox="0 0 16 16">
            <path fill-rule="evenodd"
                d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z" />
        </symbol>


    </svg>

    <header class="navbar sticky-top bg-dark flex-md-nowrap p-0 shadow" data-bs-theme="dark">
        <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3 fs-6 text-white" href="#">Profile details</a>

        <ul class="navbar-nav flex-row d-md-none">
            <li class="nav-item text-nowrap">
                <button class="nav-link px-3 text-white" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSearch" aria-controls="navbarSearch" aria-expanded="false"
                    aria-label="Toggle search">
                    <svg class="bi">
                        <use xlink:href="#search" />
                    </svg>
                </button>
            </li>
            <li class="nav-item text-nowrap">
                <button class="nav-link px-3 text-white" type="button" data-bs-toggle="offcanvas"
                    data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <svg class="bi">
                        <use xlink:href="#list" />
                    </svg>
                </button>
            </li>
        </ul>

        <div id="navbarSearch" class="navbar-search w-100 collapse">
            <input class="form-control w-100 rounded-0 border-0" type="text" placeholder="Search" aria-label="Search">
        </div>
    </header>

    <div class="container-fluid">
        <div class="row">
            <div class="sidebar border border-right col-md-3 col-lg-2 p-0 bg-body-tertiary">
                <div class="offcanvas-md offcanvas-end bg-body-tertiary" tabindex="-1" id="sidebarMenu"
                    aria-labelledby="sidebarMenuLabel">
                    <div class="offcanvas-header">
                        <h5 class="offcanvas-title" id="sidebarMenuLabel">Profile</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="offcanvas"
                            data-bs-target="#sidebarMenu" aria-label="Close"></button>
                    </div>
                    <div class="offcanvas-body d-md-flex flex-column p-0 pt-lg-3 overflow-y-auto">
                        <ul class="nav flex-column">
                            <li class="nav-item">
                                <a class="nav-link d-flex align-items-center gap-2 active" aria-current="page" href="#">
                                    <svg class="bi">
                                        <use xlink:href="#house-fill" />
                                    </svg>
                                    Dashboard
                                </a>
                            </li>

                            <ul class="nav flex-column mb-auto">

                                <li class="nav-item">
                                    <a class="nav-link d-flex align-items-center gap-2" href="logout.php">
                                        <!-- Replace 'home.html' with your home page URL -->
                                        <svg class="bi">
                                            <use xlink:href="#door-closed" />
                                        </svg>
                                        Sign out
                                    </a>
                                </li>


                            </ul>
                    </div>
                </div>
            </div>

            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div
                    class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Dashboard</h1>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <div class="btn-group me-2">
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#exampleModal">
                                Edit Profile
                            </button>
                        </div>

                    </div>
                </div>
                <div class="row">
                    <!-- Single Advisor-->
                    <div class="col-12 col-sm-6 col-lg-3">
                        <div class="single_advisor_profile wow fadeInUp" data-wow-delay="0.2s"
                            style="visibility: visible; animation-delay: 0.2s; animation-name: fadeInUp;">
                            <!-- Team Thumb-->
                            <div class="advisor_thumb"><img src="<?php
                            if ($pic==NULL){  echo "img/avatar7.png"; }
                            else
                            echo $pic; ?>" alt="" width="130%" height="50%">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-8">
                        <div class="card-block">
                            <div class="row">
                                <div class="col-sm-6">
                                    <p class="m-b-10 f-w-600">Name</p>
                                    <h6 class="text-muted f-w-400"><?php echo $name; ?></h6>
                                </div>
                                <hr>
                                <div class="col-sm-6">
                                    <p class="m-b-10 f-w-600">Username</p>
                                    <h6 class="text-muted f-w-400"><?php echo $uname; ?></h6>
                                </div>
                                <hr>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <p class="m-b-10 f-w-600">Date of Birth</p>
                                    <h6 class="text-muted f-w-400"><?php echo $dob; ?></h6>
                                </div>
                                <hr>
                                <div class="col-sm-6">
                                    <p class="m-b-10 f-w-600">Age</p>
                                    <h6 class="text-muted f-w-400"><?php echo $ag; ?></h6>
                                </div>
                                <hr>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <p class="m-b-10 f-w-600">Email</p>
                                    <h6 class="text-muted f-w-400"><?php echo $email; ?></h6>
                                </div>
                                <hr>
                                <div class="col-sm-6">
                                    <p class="m-b-10 f-w-600">Password</p>
                                    <h6 class="text-muted f-w-400"><?php echo $pw; ?></h6>
                                </div>
                                <hr>
                            </div>

                            <div class="row">
                                <div class="col-sm-6">
                                    <p class="m-b-10 f-w-600">Gender</p>
                                    <h6 class="text-muted f-w-400"><?php echo $gen; ?></h6>
                                </div>
                                <hr>
                                <div class="col-sm-6">
                                    <p class="m-b-10 f-w-600">Contact</p>
                                    <h6 class="text-muted f-w-400"><?php echo $cont; ?></h6>
                                </div>
                                <hr>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <p class="m-b-10 f-w-600">City</p>
                                    <h6 class="text-muted f-w-400"><?php echo $city; ?></h6>
                                </div>
                                <hr>
                                <div class="col-sm-6">
                                    <p class="m-b-10 f-w-600">State</p>
                                    <h6 class="text-muted f-w-400"><?php echo $state; ?></h6>
                                </div>
                                <hr>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <p class="m-b-10 f-w-600">Zip</p>
                                    <h6 class="text-muted f-w-400"><?php echo $zip; ?></h6>
                                </div>

                            </div>
                        </div>
                    </div>

                </div>
                <canvas class="my-4 w-100" id="myChart" width="900" height="380"></canvas>


            </main>
        </div>
    </div>




    <!-- Include jQuery and SweetAlert2 -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
    $(document).ready(function() {
        // Submit form via AJAX
        $('#update').on('submit', function(e) {
            e.preventDefault(); // Prevent the default form submission

            // Serialize the form data
            var formData = new FormData(this);

            $.ajax({
                type: 'POST',
                url: 'update.php', // Replace with the correct PHP script URL
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    // Parse the JSON response
                    var data = JSON.parse(response);

                    if (data.status === 300) {
                        Swal.fire(
                            'Good job!',
                            'Updated successfully',
                            'success'
                        )
                        window.location.href = "profile.php";
                    } else {
                        // Error: Display an error message
                        alert(data.message);
                    }
                },
            });
        });
    });
    </script>

</body>

</html>