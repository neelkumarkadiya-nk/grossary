<?php
session_start(); // Required for $_SESSION to work
$_SESSION['loggedin'] = false;

$host = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "gross_db";

$conn = mysqli_connect($host, $db_user, $db_pass, $db_name);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// --- REGISTRATION LOGIC ---
if (isset($_POST['register'])) {
    // Sanitize inputs to prevent SQL injection
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password']; 
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    // $user_type = $_POST['user_type'];

    // Hashing the password (CRITICAL for password_verify to work)
    // $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $checkEmail = "SELECT * FROM users WHERE email='$email'";
    $result = mysqli_query($conn, $checkEmail);

    if (mysqli_num_rows($result) > 0) {
        echo "Error: Email already registered!";
    } else {
        $sql = "INSERT INTO users (username, password, email) VALUES ('$username', '$password', '$email')";
        $result = mysqli_query($conn, $sql);
        
        if ($result) {
            // Redirect to login page with a success message in the URL
            header('location:login.php?registration=success');
            exit();
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    }
}

// --- LOGIN LOGIC ---

// session_start();
$_SESSION['loggedin'] = false;
if (isset($_POST['login'])) {
    // 1. Sanitize the username input
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password'];

    // 2. SEARCH BY USERNAME ONLY
    // Your old code tried: WHERE password='$password' (This is why it failed)
    $sql = "SELECT * FROM users WHERE username='$username' AND password='$password'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        


        // 3. VERIFY THE HASH
        // password_verify checks if the typed password matches the hash in the DB
        // if (password_verify($password, $row['password'])) {
            
            $_SESSION['loggedin'] = true;

            // if ($row['user_type'] == 'admin') {
            //     $_SESSION['admin'] = $row['username'];
            //     header('Location: profile.php');
            //     exit();
            // } else {
                $_SESSION['username'] = $row['username'];
                header('Location: index.php');
                exit();
            // }
        // }
        //  else {
        //     echo "Incorrect password!";
        // }
    } else {
        echo "Incorrect username or user does not exist.";
    }
}

mysqli_close($conn);
?>