<?php
include 'connection.php';
session_start();

// Check if user is already logged in
if(isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

// Check if users table exists, if not create it with admin user
$check_table = $conn->query("SHOW TABLES LIKE 'users'");
if($check_table->num_rows == 0) {
    // Create users table
    $conn->query("CREATE TABLE IF NOT EXISTS users (
        user_id INT AUTO_INCREMENT PRIMARY KEY,
        full_name VARCHAR(100) NOT NULL,
        email VARCHAR(100) NOT NULL UNIQUE,
        phone_number VARCHAR(20) NOT NULL,
        role VARCHAR(20) NOT NULL DEFAULT 'user',
        password VARCHAR(255) NOT NULL,
        profile_image VARCHAR(255) NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )");
    
    // Create default admin user
    $admin_password = password_hash("admin123", PASSWORD_DEFAULT);
    $conn->query("INSERT INTO users (full_name, email, phone_number, role, password) 
                  VALUES ('Admin User', 'admin@somcars.com', '123456789', 'admin', '$admin_password')");
    
    // Show a message about the default admin credentials
    $admin_created = true;
}

// Login Processing
if(isset($_POST['login'])) {
    $email = $conn->real_escape_string($_POST['email']);
    $password = $_POST['password'];
    
    // Find user
    $query = "SELECT user_id, full_name, email, password, role FROM users WHERE email = '$email'";
    $result = $conn->query($query);
    
    if($result && $result->num_rows > 0) {
        $user = $result->fetch_assoc();
        
        // Verify password
        if(password_verify($password, $user['password'])) {
            // Check if user is admin
            if($user['role'] !== 'admin') {
                $error = "Access denied. Only administrators can log in.";
            } else {
                // Get user profile image if available
                $user_id = $user['user_id'];
                $profile_query = $conn->query("SELECT profile_image FROM users WHERE user_id = $user_id");
                $profile_image = null;
                if($profile_query && $profile_query->num_rows > 0) {
                    $profile_data = $profile_query->fetch_assoc();
                    $profile_image = $profile_data['profile_image'];
                }
                
                // Set session variables for admin users only
                $_SESSION['user_id'] = $user['user_id'];
                $_SESSION['full_name'] = $user['full_name'];
                $_SESSION['email'] = $user['email'];
                $_SESSION['role'] = $user['role'];
                $_SESSION['profile_image'] = $profile_image;
                
                // Redirect to dashboard
                header("Location: index.php");
                exit;
            }
        } else {
            $error = "Invalid password";
        }
    } else {
        $error = "User not found";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SOMCARS</title>
    <link rel="shortcut icon" href="car1.jpg" type="image/x-icon">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
</head>
<body class="bg-gradient-to-br from-blue-50 to-blue-100 min-h-screen flex items-center justify-center">
    <div class="bg-white p-8 rounded-2xl shadow-2xl w-full max-w-md">
        <div class="text-center mb-8">
            <div class="flex justify-center mb-4">
                <img src="car1.jpg" alt="SOMCARS Logo" class="w-20 h-20 rounded-full">
            </div>
            <h1 class="text-2xl font-bold text-blue-700">SOMCARS Dashboard</h1>
            <p class="text-gray-600">Admin Login Only</p>
        </div>
        
        <?php if(isset($admin_created)): ?>
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            <p>Default admin account created:</p>
            <p><strong>Email:</strong> admin@somcars.com</p>
            <p><strong>Password:</strong> admin123</p>
            <p class="text-sm mt-2">Please login and change this password immediately!</p>
        </div>
        <?php endif; ?>
        
        <?php if(isset($error)): ?>
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <p><?php echo $error; ?></p>
        </div>
        <?php endif; ?>
        
        <form method="post" action="">
            <div class="mb-4">
                <label for="email" class="block text-gray-700 font-medium mb-2">Email</label>
                <div class="relative">
                    <span class="absolute left-3 top-3 text-gray-400">
                        <i class="fa fa-envelope"></i>
                    </span>
                    <input type="email" id="email" name="email" required 
                           class="w-full py-2 pl-10 pr-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
            </div>
            
            <div class="mb-6">
                <label for="password" class="block text-gray-700 font-medium mb-2">Password</label>
                <div class="relative">
                    <span class="absolute left-3 top-3 text-gray-400">
                        <i class="fa fa-lock"></i>
                    </span>
                    <input type="password" id="password" name="password" required 
                           class="w-full py-2 pl-10 pr-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
            </div>
            
            <button type="submit" name="login" class="w-full bg-blue-600 text-white py-2 rounded-lg font-medium hover:bg-blue-700 transition duration-200">
                Login
            </button>
        </form>
    </div>
</body>
</html>
