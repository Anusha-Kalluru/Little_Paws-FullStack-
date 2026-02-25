<?php
session_start();
require_once 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$user_id = $_SESSION['user_id'];

if (isset($_GET['remove']) && is_numeric($_GET['remove'])) {
    $remove_id = (int)$_GET['remove'];
    $remove_sql = "DELETE FROM cart WHERE cart_id = $remove_id AND user_id = $user_id";
    mysqli_query($conn, $remove_sql);
}

if (isset($_POST['checkout'])) {
   
    $order_sql = "INSERT INTO orders (user_id, total_amount) VALUES ($user_id, 0)";
    mysqli_query($conn, $order_sql);
    $order_id = mysqli_insert_id($conn);
    
    $cart_sql = "SELECT c.*, p.price FROM cart c JOIN products p ON c.product_id = p.product_id WHERE c.user_id = $user_id";
    $cart_result = mysqli_query($conn, $cart_sql);
    $total_amount = 0;
    
    while ($item = mysqli_fetch_assoc($cart_result)) {
        $item_total = $item['price'] * $item['quantity'];
        $total_amount += $item_total;
        
        $order_item_sql = "INSERT INTO order_items (order_id, product_id, quantity, price) 
                          VALUES ($order_id, {$item['product_id']}, {$item['quantity']}, {$item['price']})";
        mysqli_query($conn, $order_item_sql);
    }
    
    $update_order_sql = "UPDATE orders SET total_amount = $total_amount WHERE order_id = $order_id";
    mysqli_query($conn, $update_order_sql);
    
    $clear_cart_sql = "DELETE FROM cart WHERE user_id = $user_id";
    mysqli_query($conn, $clear_cart_sql);
    
    header("Location: order_success.php?order_id=$order_id");
    exit();
}

$sql = "SELECT c.*, p.product_name, p.price, p.image_url 
        FROM cart c 
        JOIN products p ON c.product_id = p.product_id 
        WHERE c.user_id = $user_id";
$result = mysqli_query($conn, $sql);
$cart_items = mysqli_fetch_all($result, MYSQLI_ASSOC);

$total = 0;
foreach ($cart_items as $item) {
    $total += $item['price'] * $item['quantity'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Little Paws - Cart</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a6c57d1253.js" crossorigin="anonymous"></script>
    <style>
    body {
        background-color: #f8f9fa;
    }
    .navbar{
            background-color: #FF991C ;
            
        }
        .navbar-brand, .nav-link {
            color: white !important;
        }
        .navbar a{
            font-size:20px;
        }
        .nav-item{
            padding-right:20px;
        }
        
        .logo{
            display: flex;
            align-items: center; 
            gap: 20px;
            position: sticky;
            top: 0;
        }
        .logo svg{
            background-color: rgba(208, 205, 205, 0.206);
           
        }
        nav .logo{
            border-radius: 30px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 10px;
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
    .cart-item-image {
        width: 80px;
        height: 80px;
        object-fit: cover;
        border-radius: 5px;
    }
    .cart-item-name {
        display: flex;
        align-items: center;
    }
    .cart-item-name img {
        margin-right: 15px;
    }
    .btn-primary {
        background-color: #FF991C;
        border-color: #FF991C;
    }
    .btn-primary:hover {
        background-color: #e88011;
        border-color: #e88011;
    }
    .table thead {
        background-color: #FF991C;
        color: white;
    }
    .table tfoot {
        background-color: #fff3e0;
    }
    i{
            margin-right:5px;
        }
</style>

</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark mb-4">
        <div class="container">
            <div class="logo">
            <a href="./home.php" target="_self"><img src="LITTLE PAWS.png" alt="logo" height="70px" width="400px"></a>
                <path d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .49.598l-1 5a.5.5 0 0 1-.465.401l-9.397.472L4.415 11H13a.5.5 0 0 1 0 1H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5M3.102 4l.84 4.479 9.144-.459L13.89 4zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4m7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4m-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2m7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2"/>
            </svg>
        </div>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="cart.php"><i class="fa-solid fa-cart-shopping"></i>Cart</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php"><i class="fa-solid fa-right-from-bracket"></i>Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        <h2 class="text-center mb-4">Your Cart</h2>
        <?php if (empty($cart_items)): ?>
            <div class="alert alert-info text-center">
                Your cart is empty. <a href="home.php">Continue shopping</a>
            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Total</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($cart_items as $item): ?>
                            <tr>
                                <td class="cart-item-name">
                                    <?php if (!empty($item['image_url'])): ?>
                                        <img src="<?php echo htmlspecialchars($item['image_url']); ?>" alt="<?php echo htmlspecialchars($item['product_name']); ?>" class="cart-item-image">
                                    <?php endif; ?>
                                    <?php echo htmlspecialchars($item['product_name']); ?>
                                </td>
                                <td>₹ <?php echo number_format($item['price'], 2); ?></td>
                                <td><?php echo $item['quantity']; ?></td>
                                <td>₹ <?php echo number_format($item['price'] * $item['quantity'], 2); ?></td>
                                <td>
                                    <a href="cart.php?remove=<?php echo $item['cart_id']; ?>" class="btn btn-danger btn-sm">Remove</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="3" class="text-end"><strong>Total:</strong></td>
                            <td colspan="2"><strong>₹ <?php echo number_format($total, 2); ?></strong></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
            
            <div class="text-center mt-4">
                <form method="POST" action="">
                    <button type="submit" name="checkout" class="btn btn-primary btn-lg">Proceed to Checkout</button>
                </form>
            </div>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 