<?php
session_start();

header("Content-Type: application/json");

$data = json_decode(file_get_contents("php://input"), true);
$book_id = isset($data['book_id']) ? intval($data['book_id']) : null;

if ($book_id === null || !isset($_SESSION['cart'])) {
    echo json_encode(["success" => false]);
    exit();
}

if (($key = array_search($book_id, $_SESSION['cart'])) !== false) {
    unset($_SESSION['cart'][$key]);
}

$_SESSION['cart'] = array_values($_SESSION['cart']);

echo json_encode(["success" => true, "cart_count" => count($_SESSION['cart'])]);
