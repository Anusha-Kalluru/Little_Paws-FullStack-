<?php
session_start();
require_once 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$category_id = isset($_GET['category']) ? (int)$_GET['category'] : 0;

$sql = "SELECT * FROM products WHERE category_id = $category_id";
$result = mysqli_query($conn, $sql);
$products = mysqli_fetch_all($result, MYSQLI_ASSOC);

$category_sql = "SELECT category_name FROM categories WHERE category_id = $category_id";
$category_result = mysqli_query($conn, $category_sql);
$category = mysqli_fetch_assoc($category_result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Little Paws - Products</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a6c57d1253.js" crossorigin="anonymous"></script>
    <style>
        body {
            background-color: #f8f9fa;
        }
        
        .product-card {
            transition: transform 0.3s;
            border-radius: 10px;
            overflow: hidden;
            width: 350px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            height: 100%;
            display: flex;
            flex-direction: column;
        }
        .product-card:hover {
            transform: scale(1.02);
            box-shadow: 0 8px 16px rgba(0,0,0,0.2);
            box-shadow: 0 8px 16px #FF991C ;
        }
        .product-card img {
            height: 200px;
            object-fit: cover;
            width: 100%;
            transition: transform 0.5s;
        }
        .product-card:hover img {
            transform: scale(1.05);
            
        }
        .product-card .card-body {
            flex: 1;
            display: flex;
            flex-direction: column;
            background-color: rgba(255, 255, 255, 0.9);
            border-top: 1px solid rgba(0,0,0,0.1);
            
        }
        .product-card .card-text {
            flex-grow: 1;
        }
        .product-card .btn {
            margin-top: auto;
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
        .btn-add-to-cart {
    background-color: #FF991C;
    border-color: #FF991C;
    color: white;
}

.btn-add-to-cart:hover {
    background-color: #e4810b;
    border-color: #e4810b;
    
}
i{
            margin-right:5px;
        }
.navbar {
    position: sticky;
    top: 0;
    z-index: 1000;
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
        <h2 class="text-center mb-4"><?php echo htmlspecialchars($category['category_name']); ?></h2>
        <div class="row">
            <?php foreach ($products as $product): ?>
                <div class="col-md-4 mb-5">
                    <div class="card product-card">
                        <?php if (!empty($product['image_url'])): ?>
                            <img src="<?php echo htmlspecialchars($product['image_url']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($product['product_name']); ?>" style="height: 200px; object-fit: cover;">
                        <?php endif; ?>
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($product['product_name']); ?></h5>
                            <p class="card-text"><?php echo htmlspecialchars($product['description']); ?></p>
                            <p class="card-text"><strong>₹ <?php echo number_format($product['price'], 2); ?></strong></p>
                            <form method="POST" action="add_to_cart.php">
                                <input type="hidden" name="product_id" value="<?php echo $product['product_id']; ?>">
                                <button type="submit" class="btn btn-add-to-cart w-100">Add to Cart</button>

                            </form>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 