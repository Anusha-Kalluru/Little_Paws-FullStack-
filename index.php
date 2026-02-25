<?php
session_start();
require_once 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['register'])) {
        $username = mysqli_real_escape_string($conn, $_POST['username']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        
        $sql = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$password')";
        
        if (mysqli_query($conn, $sql)) {
            $success_message = "Registration successful! Please login.";
        } else {
            $error_message = "Error: " . mysqli_error($conn);
        }
    }
    
    if (isset($_POST['login'])) {
        $username = mysqli_real_escape_string($conn, $_POST['username']);
        $password = $_POST['password'];
        
        $sql = "SELECT * FROM users WHERE username = '$username'";
        $result = mysqli_query($conn, $sql);
        
        if (mysqli_num_rows($result) == 1) {
            $row = mysqli_fetch_assoc($result);
            if (password_verify($password, $row['password'])) {
                $_SESSION['user_id'] = $row['user_id'];
                $_SESSION['username'] = $row['username'];
                header("Location: home.php");
                exit();
            } else {
                $error_message = "Invalid password!";
            }
        } else {
            $error_message = "Invalid username!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Little Paws - Login/Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            max-width: 400px;
            margin-top: 100px;
        }
        .card {
            border-radius: 15px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
        }
        .card-header {
            background-color:#FF991C;
            color: white;
            border-radius: 15px 15px 0 0 !important;
        }
.btn-primary {
    background-color: #FF991C !important;
    border-color: #FF991C !important;
}

.btn-primary:hover, 
.btn-primary:focus, 
.btn-primary:active {
    background-color: #e68a1a !important;
    border-color: #e68a1a !important;
}


.nav-tabs .nav-link {
    color: #FF991C;
}

.nav-tabs .nav-link.active {
    background-color: #FF991C;
    color: #fff;
    border-color: #FF991C #FF991C #fff;
}

.nav-tabs .nav-link:hover {
    color: #e68a1a;
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
    <div class="container">
        <div class="card">
            <div class="card-header text-center">
                <h3>LITTLE PAWS</h3>
            </div>
            <div class="card-body">
                <?php if (isset($success_message)): ?>
                    <div class="alert alert-success"><?php echo $success_message; ?></div>
                <?php endif; ?>
                <?php if (isset($error_message)): ?>
                    <div class="alert alert-danger"><?php echo $error_message; ?></div>
                <?php endif; ?>
                
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="login-tab" data-bs-toggle="tab" data-bs-target="#login" type="button" role="tab">Login</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="register-tab" data-bs-toggle="tab" data-bs-target="#register" type="button" role="tab">Register</button>
                    </li>
                </ul>
                
                <div class="tab-content mt-3" id="myTabContent">
                    <div class="tab-pane fade show active" id="login" role="tabpanel">
                        <form method="POST" action="">
                            <div class="mb-3">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" class="form-control" id="username" name="username" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            <button type="submit" name="login" class="btn btn-primary w-100">Login</button>
                        </form>
                    </div>
                    
                    <div class="tab-pane fade" id="register" role="tabpanel">
                        <form method="POST" action="">
                            <div class="mb-3">
                                <label for="reg_username" class="form-label">Username</label>
                                <input type="text" class="form-control" id="reg_username" name="username" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                            <div class="mb-3">
                                <label for="reg_password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="reg_password" name="password" required>
                            </div>
                            <button type="submit" name="register" class="btn btn-primary w-100">Register</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 