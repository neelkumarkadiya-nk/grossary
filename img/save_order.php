<?php
// save_order.php
header('Content-Type: application/json');

$host     = "localhost";
$username = "root";
$password = "";
$dbname   = "gross_db";

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    echo json_encode(["status" => "error", "message" => "Connection failed: " . $conn->connect_error]);
    exit;
}

// Read JSON body
$input = file_get_contents('php://input');
if (empty($input)) {
    $input = $_POST['data'];
}

$data = json_decode($input, true);

if (!$data) {
    echo json_encode(["status" => "error", "message" => "No data received"]);
    exit;
}

$customerName   = mysqli_real_escape_string($conn, $data['customerName'] );
$email          = mysqli_real_escape_string($conn, $data['email'] );
$phone          = mysqli_real_escape_string($conn, $data['phone'] );
$address        = mysqli_real_escape_string($conn, $data['address'] );
$payment_method = mysqli_real_escape_string($conn, $data['paymentMethod'] );
$total_amount   = floatval($data['total']  );
$items          = $data['items'] ;

$items          = $data['items'] ;
$sql_order = "INSERT INTO orders (customerName, email, phone, address, payment_method, total_amount,items) 
              VALUES ('$customerName', '$email', '$phone', '$address', '$payment_method', $total_amount,'$items')";

if ($conn->query($sql_order) === TRUE) {
    $order_id = $conn->insert_id;

    foreach ($items as $item) {
        $p_name  = mysqli_real_escape_string($conn, $item['name']);
        $p_price = floatval($item['price'] );
        $p_qty   = intval($item['quantity'] );

        $sql_items = "INSERT INTO order_items (order_id, product_name, price, quantity) 
                      VALUES ('$order_id', '$p_name', '$p_price', '$p_qty')";
        $conn->query($sql_items);
    }

    echo json_encode(["status" => "success", "order_id" => $order_id]);
} else {
    echo json_encode(["status" => "error", "message" => $conn->error]);
}

$conn->close();

?>