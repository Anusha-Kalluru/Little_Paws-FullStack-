<?php
session_start();
require_once 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$sql = "SELECT * FROM categories";
$result = mysqli_query($conn, $sql);
$categories = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Little Paws - Home</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a6c57d1253.js" crossorigin="anonymous"></script>
    <style>
        body {
            background-color:rgb(254, 254, 255);

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
        .slider {
            position: relative;
            width: 100%;
            max-width: 100%;
            margin: auto;
            overflow: hidden;}
        .slides {
            display: flex;
            transition: transform 0.8s ease-out;
            margin-bottom: 15px;
        }
        .slide {
            min-width: 100%;
            box-sizing: border-box;
        }
        .slide img {
            width: 100%;
            display: block;
            object-fit: cover;
            pointer-events: none;
        }
        .prev, .next {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background-color: rgba(0, 0, 0, 0.5);
            color: white;
            border: none;
            padding: 10px;
            cursor: pointer;
            z-index: 10;
        }
        .prev {
            left: 10px; 
        }
        .next {
            right: 10px; 
        }
       .row{
        margin-left:40px;
        

       }
        .category-card {
            transition: transform 0.3s;
            background-color:#FF991C;
            display:flex;
            padding:10px;
            width: 300px;
            height: 350px;
            cursor: pointer;
            border-radius: 10px;
            box-shadow: 0 4px 8px #FF991C;
        }
        h2{
            box-shadow: 3px 3px 20px #FF991C ;
        }
        .category-card:hover {
            transform: scale(1.05);
            box-shadow: 0 8px 16px #FF991C ;
        }
        .category-card img {
            height: 200px;
            object-fit: cover;
            position: relative;
            overflow: hidden;
            width: 100%;
            /* border-radius:10px; */
            transition: transform 0.5s;
        }
        /* .category-card:hover img {
            transform: scale(1.1);
        } */
        .category-card .card-body {
            background-color: rgba(255, 255, 255, 0.9);
            border-top: 1px solid #FF991C;
        }
        
        .brands{
            display: flex;
            justify-content: space-evenly;
            flex-wrap: wrap;
            gap: 70px;
            margin: 15px;
        }
        .b{
            position: relative;
            display: inline-block;
            margin-left: 15px;}
        .b img{
            border-radius: 30px;
            height: 100px;
            width: 100px;
            display: block;}
        .b p {
            position: absolute; 
        
            left: 50%;
            top: 90%; 
            transform: translateX(-50%); 
            border: 1px solid black;
            border-radius: 10px;
            background-color: #FF991C;
            padding: 5px 10px;
            color: black;
            font-weight: bold;
            text-align: center;
            width: 150px;
        }
        .catmeal{
            display: flex;
            justify-content: space-evenly;
            flex-wrap: wrap;
            gap: 70px;
            margin: 15px;
        }
        .meal{
            position: relative;
            display: inline-block;
            margin-left: 15px;
        }
        .meal img{
            border-radius: 30px;
            height: 198px;
            width: 198px;
            display: block;
        }
        .meal p {
            position: absolute; 
        
            left: 50%;
            top: 80%; 
            transform: translateX(-50%); 
            /* border: 1px solid black; */
            border-radius: 10px;
            background-color: #FF991C;
            padding: 5px 10px;
            color: white;
            font-size: 13px;
            text-align: center;
            width: 180px;
        }
        .footer {
            background-color: #f8f8f8;
            padding: 20px;
            display: flex;
            justify-content: center;
        }
        .footer-section {
            width: 24%;
            min-width: 200px;
        }
        .footer-section h3 {
            margin-bottom: 10px;
            font-size: 16px;
            font-weight:900;
            margin-left:20px;
        }
        .footer-section ul {
            list-style: none;
        }
        .footer-section ul li {
            margin-bottom: 8px;
            font-size: 13px;
            font-weight:600;
        }
        .footer-section ul li a {
            text-decoration: none;
            color: #333;
        }
        .download-buttons img {
            width: 120px;
            margin: 5px 0;
        }
        .download-buttons{
            margin-bottom: 20px;
        }
        .email-box {
            display: flex;
        }
        .email-box input {
            flex: 1;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .email-box button {
            background-color: orange;
            border: none;
            padding: 8px 12px;
            cursor: pointer;
            border-radius: 4px;
        }
        .bottom-info {
            display: flex;
            justify-content: space-around;
            padding: 10px;
            background-color: #eee;
        }
        #aa{
            font-size: 13px;
        }
        #bb{
            font-size: 20px;
            font-weight: 700;
        }
        #flexs{
            display: flex;
            align-items: center;
        }
        .nav-link{
            border
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
            <div class="logo"  >
            <a href="./home.php" target="_self"><img src="LITTLE PAWS.png" alt="logo" height="70px" width="400px"></a>
                <path d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .49.598l-1 5a.5.5 0 0 1-.465.401l-9.397.472L4.415 11H13a.5.5 0 0 1 0 1H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5M3.102 4l.84 4.479 9.144-.459L13.89 4zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4m7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4m-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2m7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2"/>
            </svg>
        </div>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="cart.php"><i class="fa-solid fa-cart-shopping"></i>CART</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php"><i class="fa-solid fa-right-from-bracket"></i>LOGOUT</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    
        <h2 id="welcome" class="text-center mb-4">Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h2>
        <div>
            <div class="slider">
                <div class="slides">
                    <div class="slide"><img src="paws_banner.jpg" alt="Slide 1"></div>
                    <div class="slide"><img src="paws_banner (1).jpg" alt="Slide 2"></div>
                    <div class="slide"><img src="paws_banner (2).jpg" alt="Slide 3"></div>
                    <div class="slide"><img src="paws_banner (3).jpg" alt="Slide 3"></div>
                </div>
                <button class="prev" onclick="moveSlide(-1)">&#10094;</button>
                <button class="next" onclick="moveSlide(1)">&#10095;</button>
            </div>
        </div>
        <div class="row">
            <?php foreach ($categories as $category): ?>
                <div class="col-md-3 mb-5 ">
                    <div class="card category-card" onclick="window.location.href='products.php?category=<?php echo $category['category_id']; ?>'">
                        <?php if (!empty($category['image_url'])): ?>
                            <img src="<?php echo htmlspecialchars($category['image_url']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($category['category_name']); ?>" style="height: 200px; position: relative;">
                        <?php endif; ?>
                        <div class="card-body text-center">
                            <h5 class="card-title"><?php echo htmlspecialchars($category['category_name']); ?></h5>
                            <p class="card-text"><?php echo htmlspecialchars($category['description']); ?></p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <div>
            <h3 style="margin: 15px; margin-top:30px;">Brands You Love</h3>
            <p style="font-size: 20px; margin-left: 15px; margin-bottom: 15px;">All at HUFT!</p>

            <div class="brands">
                <div class="b">
                    <img src="https://headsupfortails.com/cdn/shop/files/royal_canin_01_c3e51f1d-aa41-45f6-bfa7-8cb934371490.png?v=1742385524" alt="">
                    <p>FLAT <b>50% Off</b></p>
                </div>
                <div class="b">
                    <img src="https://headsupfortails.com/cdn/shop/files/hearty_02_dbbb321a-7dd8-4aaa-a0e3-b361845468f5.png?v=1742385549" alt="">
                    <p>UP To <b>12% Off</b></p>
                </div>
                <div class="b">
                    <img src="https://headsupfortails.com/cdn/shop/files/for_website.png?v=1742475085" alt="">
                    <p>STARTS AT <b>Rs.99</b></p>
                </div>
                <div class="b">
                    <img src="https://headsupfortails.com/cdn/shop/files/farmina_04_bce70e70-63bd-4b16-bbad-acb61847c4b3.png?v=1742385812" alt="">
                    <p>UP TO <b>9% Off</b></p>
                </div>
                <div class="b">
                    <img src="https://headsupfortails.com/cdn/shop/files/ekm6f2hszouxdqy0bpnm.webp?v=1741089198" alt="">
                    <p>EXTRA <b>6% Off</b></p>
                </div>
                <div class="b">
                    <img src="https://headsupfortails.com/cdn/shop/files/yhodykviepuynk453lbu.webp?v=1741089198" alt="">
                    <p>EXTRA <b>5% Off</b></p>
                </div>
            </div>
        </div>
        <br>
        <hr>
        <br>
        <div>
            <h3 style="margin: 15px;">Introducing Meowsi - Complete Meal for Cats</h3>
            <p style="font-size: 20px; margin-left: 15px; margin-bottom: 15px;">Available in Broth, Mousse and Pate</p>

            <div class="catmeal">
                <div class="meal">
                    <img src="https://headsupfortails.com/cdn/shop/files/WEB_01_e438d2d7-c52c-4a21-9194-f7ef0515c705.webp?v=1742986951" alt="">
                    <p><b>Wet Food for Cats</b> <br>Starting at Rs.99 only!</p>
                </div>
                <div class="meal">
                    <img src="https://headsupfortails.com/cdn/shop/files/WEB_02_7dd23a71-73e2-4d82-bcf3-7c86decc6edc.webp?v=1742986952" alt="">
                    <p><b>Hydrating Broth</b> <br>Boosts their water intake!</p>
                </div>
                <div class="meal">
                    <img src="https://headsupfortails.com/cdn/shop/files/WEB_03_51f991de-e8da-48a2-8564-a7b0ed673821.webp?v=1742986952" alt="">
                    <p><b>Silky Mousse</b> <br>Easy to eat, easy to digest!</p>
                </div>
                <div class="meal">
                    <img src="https://headsupfortails.com/cdn/shop/files/WEB_04_187e1afb-578d-4a17-b162-0ee39271bb46.webp?v=1742986952" alt="">
                    <p><b>Dense Pate</b> <br>Perfect pick for picky ones!</p>
                </div>
            </div>
        </div>
        <br>
        <hr>
        <br>
        <footer class="footer">
        <div class="footer-section">
            <h3>Online Shopping</h3>
            <ul>
                <li><a href="#">Dogs</a></li>
                <li><a href="#">Cats</a></li>
                <li><a href="#">Small Animals</a></li>
                <li><a href="#">Personalised Items</a></li>
                <li><a href="#">HUFT Blog</a></li>
            </ul>
        </div>
        <div class="footer-section">
            <h3>Quick Links</h3>
            <ul>
                <li><a href="#">Contact Us</a></li>
                <li><a href="#">FAQs & Exchange Policy</a></li>
                <li><a href="#">Terms of Use</a></li>
                <li><a href="#">Privacy Policy</a></li>
                <li><a href="#">Franchise</a></li>
                <li><a href="#">Singapore</a></li>
            </ul>
        </div>
        <div class="footer-section">
            <h3>Explore</h3>
            <ul>
                <li><a href="#">About Us</a></li>
                <li><a href="#">Careers</a></li>
                <li><a href="#">Awards</a></li>
                <li><a href="#">Store Locator</a></li>
                <li><a href="#">Pet Spa</a></li>
                <li><a href="#">Birthday Club</a></li>
                <li><a href="#">HUFT Foundation</a></li>
                <li><a href="#">Customer Love</a></li>
                <li><a href="#">Community</a></li>
            </ul>
        </div>
        <div class="footer-section">
            <h3>Download HUFT App</h3>
            <div class="download-buttons">
                <img src="https://cdn.shopify.com/s/files/1/0086/0795/7054/files/play_store.png?v=1683527854" alt="Google Play">
                <img src="https://cdn.shopify.com/s/files/1/0086/0795/7054/files/app_store.png?v=1683527854" alt="App Store">
            </div>
            <h3>Leave Your Email and Get Offers</h3>
            <div class="email-box">
                <input type="email" placeholder="Enter Your Email Address">
                <button>→</button>
            </div>
        </div>
    </footer>
    <div class="bottom-info">
        <div id="flexs">
            <img src="https://cdn.shopify.com/s/files/1/0086/0795/7054/files/Group_150_2d42796c-3277-4c85-b41b-3a76d5cf6321.png?v=1653568401" width="60" height="60" alt="">
            <p><span id="bb">Free Shipping</span> <br> <span id="aa">on all orders above ₹699</span> </p>
        </div>
        <div id="flexs">
            <img src="https://cdn.shopify.com/s/files/1/0086/0795/7054/files/Group_151_cd7ef98c-0d0b-4ea2-af76-4f33e990e8f8.png?v=1653568412" width="60" height="60"  alt="">
            <p><span id="bb">Free Returns</span> <br> <span id="aa"> within 7 days</span></p>
        </div>
        <div id="flexs">
            <img src="https://cdn.shopify.com/s/files/1/0086/0795/7054/files/Group_152_82b7d0d9-ba2c-4d1a-8c3a-2cad0ec1a0bc.png?v=1653568427" width="60" height="60"  alt="">
            <p><span id="bb">Best Deals</span> <br> <span id="aa">on Pet Products</span></p>
        </div>
        <div id="flexs">
            <img src="https://cdn.shopify.com/s/files/1/0086/0795/7054/files/Group_153_983329f5-dbb5-4893-8254-404de44f0486.png?v=1653568437" width="60" height="60"  alt="">
            <p><span id="bb">We Support</span> <br> <span id="aa" >Monday-Saturday, 9am to 9pm</span></p>
        </div>
    </div>
   
    <script>
        let slideIndex = 0;

function moveSlide(step) {
    const slides = document.querySelectorAll('.slide');
    slideIndex += step;
    
    if (slideIndex < 0) {
        slideIndex = slides.length - 1;
    } else if (slideIndex >= slides.length) {
        slideIndex = 0;
    }
    
    const newTransform = -100 * slideIndex + '%';
    document.querySelector('.slides').style.transform = 'translateX(' + newTransform + ')';
}
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>