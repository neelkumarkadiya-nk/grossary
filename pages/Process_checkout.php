<?php
// ✅ MUST BE FIRST - suppress all PHP warnings/notices that break JSON
error_reporting(0);
ini_set('display_errors', 0);
ob_start(); // buffer any accidental output

session_start();

// Always return JSON
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

// Clear any buffered output before sending JSON
ob_clean();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    echo json_encode(array('success' => false, 'message' => 'Not logged in.'));
    exit();
}

$host    = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "gross_db";

$conn = mysqli_connect($host, $db_user, $db_pass, $db_name);
if (!$conn) {
    echo json_encode(array('success' => false, 'message' => 'DB Error: ' . mysqli_connect_error()));
    exit();
}
// Read JSON or fallback to POST
$raw  = file_get_contents('php://input');
$data = json_decode($raw, true);

// Fallback: if JSON failed, try reading from $_POST
if (!$data && !empty($_POST)) {
    $data = $_POST;
    // $_POST cart comes as JSON string if sent via FormData
    if (isset($data['cart']) && is_string($data['cart'])) {
        $data['cart'] = json_decode($data['cart'], true);
    }
}

if (!$data) {
    echo json_encode(array('success' => false, 'message' => 'Invalid data received. Raw: ' . substr($raw, 0, 200)));
    exit();
}

function clean($conn, $val) {
    $val = isset($val) ? $val : '';
    return mysqli_real_escape_string($conn, trim((string)$val));
}

$username       = clean($conn, isset($data['username'])  ? $data['username']  : '');
$phone          = clean($conn, isset($data['phone'])     ? $data['phone']     : '');
$email          = clean($conn, isset($data['email'])     ? $data['email']     : '');
$address        = clean($conn, isset($data['address'])   ? $data['address']   : '');
$city           = clean($conn, isset($data['city'])      ? $data['city']      : '');
$state          = clean($conn, isset($data['state'])     ? $data['state']     : '');
$pincode        = clean($conn, isset($data['pincode'])   ? $data['pincode']   : '');
$slot           = clean($conn, isset($data['slot'])      ? $data['slot']      : '');
$notes          = clean($conn, isset($data['notes'])     ? $data['notes']     : '');
$payment_method = clean($conn, isset($data['payment'])   ? $data['payment']   : '');
$total_amount   = floatval(isset($data['total'])         ? $data['total']     : 0);
$cart           = isset($data['cart'])                   ? $data['cart']      : array();

if (!$username || !$phone || !$address || !$city || !$state || !$pincode) {
    echo json_encode(array('success' => false, 'message' => 'Please fill all required fields.'));
    exit();
}

if (empty($cart)) {
    echo json_encode(array('success' => false, 'message' => 'Cart is empty.'));
    exit();
}

$sql = "INSERT INTO orders (username, phone, email, address, city, state, pincode, delivery_slot, notes, payment_method, total_amount)
        VALUES ('$username','$phone','$email','$address','$city','$state','$pincode','$slot','$notes','$payment_method','$total_amount')";

if (!mysqli_query($conn, $sql)) {
    echo json_encode(array('success' => false, 'message' => 'DB insert failed: ' . mysqli_error($conn)));
    exit();
}

$order_id = mysqli_insert_id($conn);

foreach ($cart as $item) {
    $pid  = intval(isset($item['id'])       ? $item['id']       : 0);
    $name = clean($conn, isset($item['name'])   ? $item['name']     : 'Item');
    $price= floatval(isset($item['price'])  ? $item['price']    : 0);
    $qty  = intval(isset($item['quantity']) ? $item['quantity']  : 1);
    mysqli_query($conn, "INSERT INTO order_items (order_id, product_id, name, price, quantity)
                         VALUES ('$order_id','$pid','$name','$price','$qty')");
}

mysqli_close($conn);

echo json_encode(array('success' => true, 'order_id' => $order_id, 'message' => 'Order placed!'));
exit();
?>