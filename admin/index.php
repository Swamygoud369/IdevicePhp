
<?php
session_start();
// include("includes/db_connection.php");

// if (isset($_COOKIE['user_email'])) {
//     header("Location: dashboard.php");
//     exit();
// }



if (isset($_SESSION['email'])) {
    header("Location: dashboard.php");
    exit();
}



?>
<?php include("includes/header.php");

//  session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE email = ? AND password = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $email, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Login successful
        session_start();
        $_SESSION['email'] = $email;
        
        // Set a cookie
        setcookie('user_email', $email, time() + (86400 * 30), "/"); // Cookie expires in 30 days
        
        header("Location: dashboard.php");
        exit();
    } else {
        // Login failed
        echo "Invalid email or password.";
    }

    $stmt->close();
    $conn->close();
}
 ?>

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
                    <form action="index.php" method="post">
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