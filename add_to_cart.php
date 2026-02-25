<?php
session_start();
require_once 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['product_id'])) {
    $user_id = $_SESSION['user_id'];
    $product_id = (int)$_POST['product_id'];
    
    $check_sql = "SELECT * FROM cart WHERE user_id = $user_id AND product_id = $product_id";
    $check_result = mysqli_query($conn, $check_sql);
    
    if (mysqli_num_rows($check_result) > 0) {
      
        $update_sql = "UPDATE cart SET quantity = quantity + 1 WHERE user_id = $user_id AND product_id = $product_id";
        mysqli_query($conn, $update_sql);
    } else {
        $insert_sql = "INSERT INTO cart (user_id, product_id, quantity) VALUES ($user_id, $product_id, 1)";
        mysqli_query($conn, $insert_sql);
    }
    
    header("Location: cart.php");
    exit();
}
?> 