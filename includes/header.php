<!doctype html>
<html lang="en">
<?php
// header("Access-Control-Allow-Origin: *");
// header("Access-Control-Allow-Methods: POST, OPTIONS");
// header("Access-Control-Allow-Headers: Content-Type, Authorization");
ini_set('display_errors', 1);
error_reporting(E_ALL);




//local
$servername = "localhost"; // Replace with your database host
$username = "root"; // Replace with your database username
$password = ""; // Replace with your database password
$dbname = "swamy"; 


//server 

// $servername = "localhost";
// $username = "u111310158_Idevice";
// $password = "I@Device123";
// $dbname = "u111310158_Idevice";



$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
<head>
    <title>Title</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <link
        href="https://fonts.googleapis.com/css2?family=Nunito+Sans:ital,opsz,wght@0,6..12,200..1000;1,6..12,200..1000&family=Urbanist:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">
    <!-- Bootstrap CSS v5.2.1 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
    <link rel='stylesheet' href="./css/style.css" type='text/css' />
    <link rel='stylesheet' href="./css/newstyles.css" type='text/css' />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.6.0/remixicon.min.css"
        integrity="sha512-XcIsjKMcuVe0Ucj/xgIXQnytNwBttJbNjltBV18IOnru2lDPe9KRRyvCXw6Y5H415vbBLRm8+q6fmLUU7DfO6Q=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
 <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Icons" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined"
          rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.2.0/magnific-popup.min.css"
        integrity="sha512-lvaVbvmbHhG8cmfivxLRhemYlTT60Ly9Cc35USrpi8/m+Lf/f/T8x9kEIQq47cRj1VQIFuxTxxCcvqiQeQSHjQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/simple-line-icons/2.5.5/css/simple-line-icons.min.css"
        integrity="sha512-QKC1UZ/ZHNgFzVKSAhV5v5j73eeL9EEN289eKAEFaAjgAiobVAnVv/AGuPbXsKl1dNoel3kNr6PYnSiTzVVBCw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">


</head>

<body>
        <div class="top-bg-white">
            <div class="container mw-1820">
                <div class="border-bottom-f5f5f5 d-md-flex align-items-center justify-content-between">
                    <ul class="ps-0 mb-0 d-md-flex align-items-center list-unstyled header-left-content">
                        <li>
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <i class="ri-map-pin-line"></i>
                                </div>
                                <div class="flex-grow-1 ms-2">
                                    <p>Location:</p>
                                    <span>Survey No 43,Merix Square Bajaj Electronics, Kompally, Hyderabad</span>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <i class="ri-timer-flash-line"></i>
                                </div>
                                <div class="flex-grow-1 ms-2">
                                    <p>Working Hours:</p>
                                    <span>Mon-Fri: 8:00am-7:00pm, Sat-Sun: 10:00am-5:00pm</span>
                                </div>
                            </div>
                        </li>
                        <li class="urgent">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <i class="ri-phone-line"></i>
                                </div>
                                <div class="flex-grow-1 ms-2">
                                    <p>Urgent Need Support?</p>
                                    <div class="mb-mimus-8"><a href="tel:+919676492221">+91 96764 92221</a></div>
                                </div>
                            </div>
                        </li>
                    </ul>

                    <ul
                        class="ps-0 mb-0 list-unstyled d-flex align-items-center header-right-content justify-content-center">
                        <li>
                            <span>Follow us on:</span>
                        </li>

                        <li>
                            <a target="_blank" href="#" class="facebook"> <i class="ri-facebook-fill"></i></a>
                        </li>

                        <li>
                            <a target="_blank" href="#" class="twitter"><i class="ri-twitter-x-line"></i></a>
                        </li>

                        <li>
                            <a target="_blank" href="#" class="instagram"> <i class="ri-instagram-line"></i></a>
                        </li>

                        <li>
                            <a target="_blank" href="#"> <i class="ri-linkedin-fill"></i></a>
                        </li>
                           <button id="toggle-theme" class="btn btn-light ms-2">
                        <span class="material-symbols-outlined"  id="theme-icon">
light_mode
</span>

</button>
                    </ul>
                 

                </div>
            </div>

        </div>
        <nav class="navbar navbar-expand-lg" id="navbar">
            <div class="container mw-1820">
                <a class="navbar-brand me-90 p-0" href="#">
                    <img src="images/idevicelogo.png" alt="Fixo" class="main-logo dark-logo">
                    <img src="images/idevicelogo-white.png" alt="Fixo" class="main-logo white-logo">
                </a>
                <!-- <a class="navbar-toggler" data-bs-toggle="offcanvas" data-bs-target="#navbarSupportedContent" href="#navbarOffcanvas" role="button"
                     aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation" data-bs-backdrop="false" data-bs-scroll="true">
                    <span class="burger-menu">
                        <span class="top-bar"></span>
                        <span class="middle-bar"></span>
                        <span class="bottom-bar"></span>
                    </span>
                </a> -->

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
    aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
</button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul id="menu-primary-menu" class="navbar-nav mx-auto">
                        <li id="menu-item-61"
                            class="menu-item menu-item-type-custom menu-item-object-custom current-menu-ancestor current-menu-parent  active menu-item-61 nav-item">
                            <a title="HOME" href="#" aria-haspopup="true" aria-expanded="false" class="nav-link"
                                id="menu-item-dropdown-61">HOME</a>

                        </li>
                       
                        <li id="menu-item-69"
                            class="menu-item menu-item-type-custom menu-item-object-custom  menu-item-69 nav-item"><a
                                title="SERVICES" href="#" aria-haspopup="true" aria-expanded="false" class="nav-link"
                                id="menu-item-dropdown-69">SERVICES</a>

                        </li>
                        <li id="menu-item-72"
                            class="menu-item menu-item-type-custom menu-item-object-custom   menu-item-72 nav-item"><a
                                title="COMPANY" href="#" aria-haspopup="true" aria-expanded="false" class="nav-link"
                                id="menu-item-dropdown-72">PRODUCTS</a>

                        </li>
                        <li id="menu-item-75"
                            class="menu-item menu-item-type-custom menu-item-object-custom   menu-item-75 nav-item"><a
                                title="SHOP" href="#" aria-haspopup="true" aria-expanded="false" class="nav-link"
                                id="menu-item-dropdown-75">OFFERS</a>

                        </li>
                        <li id="menu-item-80"
                            class="menu-item menu-item-type-custom menu-item-object-custom  menu-item-80 nav-item"><a
                                title="BLOG" href="#" aria-haspopup="true" aria-expanded="false" class="nav-link"
                                id="menu-item-dropdown-80">BLOG</a>

                        </li>
                        <li id="menu-item-82"
                            class="menu-item menu-item-type-post_type menu-item-object-page menu-item-82 nav-item"><a
                                title="CONTACT" href="#" class="nav-link">CONTACT</a></li>
                    </ul>
                </div>
                <div class="others-options">
                    <ul class="d-flex align-items-center ps-0 mb-0 list-unstyled">
                        <li>
                            <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#schedulemeeting">GET A SCHEDULE</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
      