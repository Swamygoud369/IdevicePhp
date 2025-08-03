<?php
 session_start();
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