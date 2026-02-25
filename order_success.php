<?php
session_start();
require_once 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$order_id = isset($_GET['order_id']) ? (int)$_GET['order_id'] : 0;

$sql = "SELECT o.*, oi.*, p.product_name 
        FROM orders o 
        JOIN order_items oi ON o.order_id = oi.order_id 
        JOIN products p ON oi.product_id = p.product_id 
        WHERE o.order_id = $order_id AND o.user_id = {$_SESSION['user_id']}";
$result = mysqli_query($conn, $sql);
$order_items = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Little Paws - Order Success</title>
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
        i{
            margin-right:5px;
        }
        .navbar {
    position: sticky;
    top: 0;
    z-index: 1000; /* Ensure it stays above other elements */
    background-color: #FF991C;
}
html, body {
      height: 100%;
      margin: 0;
      padding: 0;
      overflow: auto;
      -ms-overflow-style: none;  
      scrollbar-width: none;     
    }

   
    body::-webkit-scrollbar {
      display: none;
    }

    .content {
      width: 3000px;
      height: 3000px;
      background: linear-gradient(to bottom right, #f06, #4a90e2);
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
        <div class="card">
            <div class="card-header bg-success text-white text-center">
                <h3>Order Successful!</h3>
            </div>
            <div class="card-body">
                <h4 class="text-center mb-4">Order Details</h4>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($order_items as $item): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($item['product_name']); ?></td>
                                    <td>₹ <?php echo number_format($item['price'], 2); ?></td>
                                    <td><?php echo $item['quantity']; ?></td>
                                    <td>₹ <?php echo number_format($item['price'] * $item['quantity'], 2); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="3" class="text-end"><strong>Total Amount:</strong></td>
                                <td><strong>₹ <?php echo number_format($order_items[0]['total_amount'], 2); ?></strong></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <div class="text-center mt-4">
                    <a href="home.php" class="btn btn-primary">Continue Shopping</a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 