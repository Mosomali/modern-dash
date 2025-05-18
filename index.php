<?php include 'connection.php'; ?>
<?php
$show_available_cars = isset($_GET['view']) && $_GET['view'] === 'available_cars';
function active_link($view) {
    return (isset($_GET['view']) && $_GET['view'] === $view) ? 'bg-blue-100 text-blue-700' : '';
}
// Add these variables at the top, after connection and before any HTML output
$total_users = $conn->query("SELECT COUNT(*) as total FROM users")->fetch_assoc()['total'];
$total_cars = $conn->query("SELECT COUNT(*) as total FROM cars")->fetch_assoc()['total'];
$total_bookings = $conn->query("SELECT COUNT(*) as total FROM rental_bookings")->fetch_assoc()['total'];
$active_bookings = $conn->query("SELECT COUNT(*) as total FROM rental_bookings WHERE booking_status='active'")->fetch_assoc()['total'];
$pending_bookings = $conn->query("SELECT COUNT(*) as total FROM rental_bookings WHERE booking_status='pending'")->fetch_assoc()['total'];
$canceled_bookings = $conn->query("SELECT COUNT(*) as total FROM rental_bookings WHERE booking_status='canceled'")->fetch_assoc()['total'];
$total_income = $conn->query("SELECT SUM(total_cost) as total FROM rental_bookings WHERE booking_status IN ('active','returned')")->fetch_assoc()['total'] ?? 0;
// Top 3 rented cars
$top_cars = $conn->query("SELECT car_name, COUNT(*) as count FROM rental_bookings GROUP BY car_name ORDER BY count DESC LIMIT 3");
// Top 3 customers
$top_customers = $conn->query("SELECT u.full_name, COUNT(*) as count FROM rental_bookings rb LEFT JOIN users u ON rb.user_id = u.user_id GROUP BY rb.user_id, u.full_name ORDER BY count DESC LIMIT 3");
// Add this after $total_cars
$car_makes = $conn->query("SELECT make, COUNT(*) as count FROM cars GROUP BY make");
// Add queries for breakdowns for each booking status
$total_bookings_breakdown = $conn->query("SELECT car_name, COUNT(*) as count FROM rental_bookings GROUP BY car_name ORDER BY count DESC LIMIT 10");
$active_bookings_breakdown = $conn->query("SELECT car_name, COUNT(*) as count FROM rental_bookings WHERE booking_status='active' GROUP BY car_name ORDER BY count DESC LIMIT 10");
$pending_bookings_breakdown = $conn->query("SELECT car_name, COUNT(*) as count FROM rental_bookings WHERE booking_status='pending' GROUP BY car_name ORDER BY count DESC LIMIT 10");
$canceled_bookings_breakdown = $conn->query("SELECT car_name, COUNT(*) as count FROM rental_bookings WHERE booking_status='canceled' GROUP BY car_name ORDER BY count DESC LIMIT 10");
// Add query for top users by booking count
$top_users = $conn->query("SELECT u.full_name, COUNT(rb.booking_id) as count FROM users u LEFT JOIN rental_bookings rb ON u.user_id = rb.user_id GROUP BY u.user_id, u.full_name ORDER BY count DESC LIMIT 10");
// Add after $total_users
$total_drivers = $conn->query("SELECT COUNT(*) as total FROM drivers")->fetch_assoc()['total'];

// Include the functions file
include 'functions.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SOMCARS</title>
    <link rel="shortcut icon" href="car1.jpg" type="image/x-icon">


    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
</head>
<body class="bg-gradient-to-br from-blue-50 to-blue-100 min-h-screen flex">
    <!-- Sidebar -->
    <aside class="w-72 bg-white shadow-xl h-screen flex flex-col fixed z-20">
        <div class="p-6 font-extrabold text-2xl text-blue-700 flex items-center gap-2">
            <img src="car1.jpg" alt="Car Rental Logo" class="w-10 h-10 rounded-full"> SOM CARS
        </div>
        <nav class="flex-1">
            <ul class="space-y-2 p-4">
                <li><a href="index.php" class="flex items-center gap-3 py-2 px-4 rounded-lg hover:bg-blue-100 transition <?php echo !isset($_GET['view']) ? 'bg-blue-100 text-blue-700' : ''; ?>"><i class="fa-solid fa-gauge"></i> Dashboard</a></li>
                <li><a href="index.php?view=bookings" class="flex items-center gap-3 py-2 px-4 rounded-lg hover:bg-blue-100 transition <?php echo active_link('bookings'); ?>"><i class="fa-solid fa-calendar-check"></i> Bookings</a></li>
                <li><a href="index.php?view=available_cars" class="flex items-center gap-3 py-2 px-4 rounded-lg hover:bg-blue-100 transition <?php echo active_link('available_cars'); ?>"><i class="fa-solid fa-car"></i> Available Cars</a></li>
                <li><a href="index.php?view=users" class="flex items-center gap-3 py-2 px-4 rounded-lg hover:bg-blue-100 transition <?php echo active_link('users'); ?>"><i class="fa-solid fa-users"></i> Users</a></li>
                <li><a href="index.php?view=drivers" class="flex items-center gap-3 py-2 px-4 rounded-lg hover:bg-blue-100 transition <?php echo active_link('drivers'); ?>"><i class="fa-solid fa-users"></i> Drivers</a></li>
                <li><a href="index.php?view=reports" class="flex items-center gap-3 py-2 px-4 rounded-lg hover:bg-blue-100 transition <?php echo active_link('reports'); ?>"><i class="fa-solid fa-chart-line"></i> Reports</a></li>
                <li><a href="index.php?view=settings" class="flex items-center gap-3 py-2 px-4 rounded-lg hover:bg-blue-100 transition <?php echo active_link('settings'); ?>"><i class="fa-solid fa-gear"></i> Settings</a></li>
            </ul>
        </nav>
    </aside>
    <!-- Main Content -->
    <div class="flex-1 flex flex-col ml-72 min-h-screen">
        <!-- Topbar -->
        <header class="flex items-center justify-between bg-white shadow p-4 sticky top-0 z-10">
            <div class="flex items-center gap-2">
                <input type="text" placeholder="Search..." class="border rounded-lg px-3 py-1 focus:outline-none focus:ring-2 focus:ring-blue-400 bg-blue-50">
            </div>
            <div class="flex items-center gap-6">
                
                <div class="flex items-center gap-2 cursor-pointer group">
                    <!-- // sawiro  -->
                    <img src="22.jpg" alt="" class="w-9 h-9 rounded-full border-2 border-blue-200">
                    <span class="font-semibold text-gray-700">Admin</span>
                    <!-- <i class="fa-solid fa-chevron-down text-gray-400 group-hover:text-blue-600 transition"></i> -->
                </div>
            </div>
        </header>
        <?php
        // Dashboard Cards
        $cars_available = $conn->query("SELECT COUNT(*) as total FROM cars WHERE status='available'")->fetch_assoc()['total'];
        ?>
        <?php if (!$show_available_cars && (!isset($_GET['view']) || $_GET['view'] === '')): ?>
            <!-- Include Dashboard Page -->
            <?php include 'dashboard.php'; ?>
        <?php endif; ?>
        <?php if (isset($_GET['view']) && $_GET['view'] === 'users'): ?>
            <!-- Include Users Page -->
            <?php include 'users.php'; ?>
        <?php endif; ?>

        <!-- Available Cars Table -->
        <?php if ($show_available_cars): ?>
            <!-- Include Cars Page -->
            <?php include 'cars.php'; ?>
        <?php elseif (isset($_GET['view']) && $_GET['view'] === 'bookings'): ?>
            <!-- Include Bookings Page -->
            <?php include 'bookings.php'; ?>
        <?php elseif (isset($_GET['view']) && $_GET['view'] === 'reports'): ?>
            <!-- Include Reports Page -->
            <?php include 'reports.php'; ?>
        <?php endif; ?>
        <?php if (isset($_GET['view']) && $_GET['view'] === 'drivers'): ?>
            <!-- Include Drivers Page -->
            <?php include 'drivers.php'; ?>
        <?php endif; ?>
        <?php if (isset($_GET['view']) && $_GET['view'] === 'settings'): ?>
            <!-- Include Settings Page -->
            <?php include 'settings.php'; ?>
        <?php endif; ?>
    </div>
</body>
</html> 