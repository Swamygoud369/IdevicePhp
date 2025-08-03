
<?php
include("includes/db_connection.php");

if (isset($_COOKIE['user_email'])) {
    header("Location: dashboard.php");
    exit();
}
?>
<?php include("includes/header.php");
include("includes/login.php");  ?>

<div class="main-wrapper">
    <div class="account-content">
        <div class="login-wrapper login-new">
            <div class="login-shapes">
                <div class="login-right-shape">
                    <img src="images/authentication/shape-01.png" alt="Shape">
                </div>
                <div class="login-left-shape">
                    <img src="images/authentication/shape-02.png" alt="Shape">
                </div>
            </div>
            <div class="container">
                <div class="login-content user-login">
                    <div class="login-logo">
                        <img src="images/logo.png" class="img-fluid" alt="Logo">
                    </div>
                    <form action="login.php" method="post">
                        <div class="login-user-info">
                            <div class="login-heading">
                                <h4>Sign In</h4>
                                <p>Access the CRMS panel using your email and passcode.</p>
                            </div>
                            <div class="form-wrap">
                                <label class="col-form-label">Email Address</label>
                                <div class="form-wrap-icon">
                                    <input type="text" class="form-control" name="email">
                                    <i class="ti ti-mail"></i>
                                </div>
                            </div>
                            <div class="form-wrap">
                                <label class="col-form-label">Password</label>
                                <div class="pass-group">
                                    <input type="password" class="pass-input form-control" name="password">
                                    <span class="ti toggle-password ti-eye-off"></span>
                                </div>
                            </div>
                            <div class="form-wrap form-wrap-checkbox">
                                <div class="custom-control custom-checkbox">
                                    <label class="check">
                                        <input type="checkbox" name="remember">
                                        <span class="box"></span> Remember Me
                                    </label>
                                </div>
                                <div class="text-end">
                                    <a href="forgotpassword" class="forgot-link">Forgot Password?</a>
                                </div>
                            </div>
                            <div class="form-wrap">
                                <button type="submit" class="btn btn-primary">Sign In</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="copyright-text">
                    <p>Copyright &copy;2024 - NXGN</p>
                </div>
            </div>
        </div>
    </div>
</div>
    <?php include("includes/footer.php");  ?>