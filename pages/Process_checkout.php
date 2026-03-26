<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit();
}

// ── DB CONFIG ──────────────────────────────────────
$host    = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "gross_db";

$conn = mysqli_connect($host, $db_user, $db_pass, $db_name);
if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}


// ── READ POST DATA ─────────────────────────────────
function clean($conn, $val) {
    return mysqli_real_escape_string($conn, trim(strval($val)));
}

$username  = clean($conn, isset($_SESSION['username']) ? $_SESSION['username'] : '');
$full_name = clean($conn, isset($_POST['fullName'])  ? $_POST['fullName']  : '');
$phone     = clean($conn, isset($_POST['phone'])     ? $_POST['phone']     : '');
$email     = clean($conn, isset($_POST['email'])     ? $_POST['email']     : '');
$address   = clean($conn, isset($_POST['address'])   ? $_POST['address']   : '');
$city      = clean($conn, isset($_POST['city'])      ? $_POST['city']      : '');
$state     = clean($conn, isset($_POST['state'])     ? $_POST['state']     : '');
$pincode   = clean($conn, isset($_POST['pincode'])   ? $_POST['pincode']   : '');
$notes     = clean($conn, isset($_POST['notes'])     ? $_POST['notes']     : '');
$payment   = clean($conn, isset($_POST['payment'])   ? $_POST['payment']   : 'Cash on Delivery');
$total     = floatval(isset($_POST['total'])         ? $_POST['total']     : 0);

$cart_json = isset($_POST['cart']) ? $_POST['cart'] : '[]';
$cart      = json_decode($cart_json, true);

// ── VALIDATE ───────────────────────────────────────
if (!$full_name || !$phone || !$address || !$city || !$state || !$pincode) {
    die("Error: Please fill in all required fields. <a href='javascript:history.back()'>Go back</a>");
}

if (empty($cart)) {
    die("Error: Cart is empty. <a href='javascript:history.back()'>Go back</a>");
}

// ── INSERT ORDER ───────────────────────────────────
$sql = "INSERT INTO orders (username, full_name, phone, email, address, city, state, pincode, notes, payment_method, total_amount)
        VALUES ('$username','$full_name','$phone','$email','$address','$city','$state','$pincode','$notes','$payment','$total')";

if (!mysqli_query($conn, $sql)) {
    die("DB Error (orders): " . mysqli_error($conn));
}

$order_id = mysqli_insert_id($conn);

// ── INSERT ORDER ITEMS ─────────────────────────────
foreach ($cart as $item) {
    $pid   = intval(isset($item['id'])       ? $item['id']       : 0);
    $name  = clean($conn, isset($item['name'])   ? $item['name']   : 'Item');
    $price = floatval(isset($item['price'])  ? $item['price']    : 0);
    $qty   = intval(isset($item['quantity']) ? $item['quantity']  : 1);

    $sql2 = "INSERT INTO order_items (order_id, product_id, name, price, quantity)
             VALUES ('$order_id','$pid','$name','$price','$qty')";
    if (!mysqli_query($conn, $sql2)) {
        die("DB Error (order_items): " . mysqli_error($conn));
    }
}

mysqli_close($conn);

// ── SUCCESS — redirect to success page ────────────
// Both files are in /pages/ so just use filename
header("Location: orders.php?order_id=" . $order_id);
exit();
?>