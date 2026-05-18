<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

// ── DB CONFIG ──────────────────────────────────────
$host    = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "gross_db";

$conn = mysqli_connect($host, $db_user, $db_pass, $db_name);
if (!$conn) {
    die("DB Connection failed: " . mysqli_connect_error());
}

// ── AUTO-CREATE users TABLE ────────────────────────
mysqli_query($conn, "CREATE TABLE IF NOT EXISTS users (
    id         INT AUTO_INCREMENT PRIMARY KEY,
    username   VARCHAR(100) NOT NULL UNIQUE,
    email      VARCHAR(150),
    password   VARCHAR(255) NOT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
)");

// ════════════════════════════════════════════════════
//  HANDLE LOGIN
// ════════════════════════════════════════════════════
if (isset($_POST['login'])) {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if (!$username || !$password) {
        header("Location: login.php?error=Please+fill+in+all+fields");
        exit();
    }

    $safe_user = mysqli_real_escape_string($conn, $username);
    $result = mysqli_query($conn, "SELECT * FROM users WHERE username='$safe_user'");

    if (!$result || mysqli_num_rows($result) === 0) {
        header("Location: login.php?error=Username+not+found");
        exit();
    }

    $user = mysqli_fetch_assoc($result);

    // Support both hashed and plain-text passwords
    $pass_ok = false;
    if (strlen($user['password']) === 60 && substr($user['password'], 0, 4) === '$2y$') {
        // bcrypt hash
        $pass_ok = password_verify($password, $user['password']);
    } else {
        // plain text (old accounts)
        $pass_ok = ($password === $user['password']);
    }

    if (!$pass_ok) {
        header("Location: login.php?error=Incorrect+password");
        exit();
    }

    // ✅ Login success — set session
    $_SESSION['loggedin'] = true;
    $_SESSION['username'] = $user['username'];
    $_SESSION['user_id']  = $user['id'];

    mysqli_close($conn);
    header("Location: index.php");
    exit();
}

// ════════════════════════════════════════════════════
//  HANDLE REGISTER
// ════════════════════════════════════════════════════
if (isset($_POST['register'])) {
    $username = trim(isset($_POST['username']) ? $_POST['username'] : '');
    $email    = trim(isset($_POST['email'])    ? $_POST['email']    : '');
    $password = trim(isset($_POST['password']) ? $_POST['password'] : '');

    if (!$username || !$password) {
        header("Location: login.php?tab=register&error=Username+and+password+are+required");
        exit();
    }

    $safe_user  = mysqli_real_escape_string($conn, $username);
    $safe_email = mysqli_real_escape_string($conn, $email);
    $hashed     = password_hash($password, PASSWORD_BCRYPT);

    // Check if username already taken
    $check = mysqli_query($conn, "SELECT id FROM users WHERE username='$safe_user'");
    if ($check && mysqli_num_rows($check) > 0) {
        header("Location: login.php?tab=register&error=Username+already+taken");
        exit();
    }

    $sql = "INSERT INTO users (username, email, password)
            VALUES ('$safe_user','$safe_email','$hashed')";

    if (!mysqli_query($conn, $sql)) {
        header("Location: login.php?tab=register&error=Registration+failed:+" . urlencode(mysqli_error($conn)));
        exit();
    }

    mysqli_close($conn);

    // ✅ Redirect to login with success message
    header("Location: login.php?registered=1");
    exit();
}

// If someone opens this file directly
header("Location: login.php");
exit();
?>
