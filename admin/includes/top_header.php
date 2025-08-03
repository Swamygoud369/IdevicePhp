


<div class="main-wrapper">

<div class="preloader">
    <span class="loader">
        <div class="ball"></div>
        <div class="ball"></div>
        <div class="ball"></div>
    </span>
</div>

<!-- Header -->
<div class="header">

    <!-- Logo -->
    <div class="header-left active">
        <a href="index.html" class="logo logo-normal">
            <img src="images/logo.png" alt="Logo">
            <img src="images/logo.png" class="white-logo" alt="Logo">
        </a>
        <a href="index.html" class="logo-small">
            <img src="images/logo.png" alt="Logo">
        </a>
        <a id="toggle_btn" href="javascript:void(0);">
            <i class="ti ti-arrow-bar-to-left"></i>
        </a>
    </div>
    <!-- /Logo -->

    <a id="mobile_btn" class="mobile_btn" href="#sidebar">
        <span class="bar-icon">
            <span></span>
            <span></span>
            <span></span>
        </span>
    </a>

    <div class="header-user">
        <ul class="nav user-menu">

            <!-- Search -->
            <li class="nav-item nav-search-inputs me-auto">
                <div class="top-nav-search">
                    <a href="javascript:void(0);" class="responsive-search">
                        <i class="fa fa-search"></i>
                    </a>
                    <form action="#" class="dropdown">
                        <div class="searchinputs" id="dropdownMenuClickable">
                            <input type="text" placeholder="Search">
                            <div class="search-addon">
                                <button type="submit"><i class="ti ti-command"></i></button>
                            </div>
                        </div>
                    </form>
                </div>
            </li>
            <!-- /Search -->
          
            <!-- Profile Dropdown -->
            <li class="nav-item dropdown has-arrow main-drop">
                <a href="javascript:void(0);" class="nav-link userset" data-bs-toggle="dropdown">
                    <span class="user-info">
                        <span class="user-letter">
                            <img src="images/profile.png" alt="Profile">
                        </span>
                        <span class="badge badge-success rounded-pill"></span>
                    </span>
                </a>
                <div class="dropdown-menu menu-drop-user">
                    <div class="profilename">
                        <a class="dropdown-item" href="#">
                            <i class="ti ti-layout-2"></i> Dashboard
                        </a>
                        <a class="dropdown-item" href="#">
                            <i class="ti ti-user-pin"></i> My Profile
                        </a>
                        <a class="dropdown-item" href="logout.php">
                            <i class="ti ti-lock"></i> Logout
                        </a>
                    </div>
                </div>
            </li>
            <!-- /Profile Dropdown -->

        </ul>
    </div>

    <!-- Mobile Menu -->
    <div class="dropdown mobile-user-menu">
        <a href="javascript:void(0);" class="nav-link dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
        <div class="dropdown-menu">
            <a class="dropdown-item" href="#">
                <i class="ti ti-layout-2"></i> Dashboard
            </a>
            <a class="dropdown-item" href="#">
                <i class="ti ti-user-pin"></i> My Profile
            </a>
            <a class="dropdown-item" href="logout.php">
                <i class="ti ti-lock"></i> Logout
            </a>
        </div>
    </div>
    <!-- /Mobile Menu -->

</div>
<!-- /Header -->