<?php
// Handle Mark as Active action
if (isset($_POST['mark_active_id'])) {
    $booking_id = intval($_POST['mark_active_id']);
    $conn->query("UPDATE rental_bookings SET booking_status='active' WHERE booking_id=$booking_id");
    echo "<script>location.href=location.href;</script>"; // Refresh page
    exit;
}

// Handle Cancel Booking action
if (isset($_POST['cancel_booking_id'])) {
    $booking_id = intval($_POST['cancel_booking_id']);
    $conn->query("UPDATE rental_bookings SET booking_status='canceled' WHERE booking_id=$booking_id");
    echo "<script>location.href=location.href;</script>"; // Refresh page
    exit;
}

// Handle Add New Booking form submission
if (isset($_POST['add_booking_submit'])) {
    $user_id = intval($_POST['user_id']);
    
    // Get the car name from the database using car_id
    $car_id = intval($_POST['car_id']);
    $car_result = $conn->query("SELECT car_name FROM cars WHERE car_id = $car_id");
    if ($car_result && $car_result->num_rows > 0) {
        $car = $car_result->fetch_assoc();
        $car_name = $conn->real_escape_string($car['car_name']);
    } else {
        $car_name = "Unknown";
    }
    
    $pickup_date = $conn->real_escape_string($_POST['pickup_date']);
    $return_date = $conn->real_escape_string($_POST['return_date']);
    
    // Calculate total cost based on daily rate and days
    $car_daily_rate = 0;
    $car_rate_result = $conn->query("SELECT daily_rate FROM cars WHERE car_id = $car_id");
    if ($car_rate_result && $car_rate_result->num_rows > 0) {
        $car_rate = $car_rate_result->fetch_assoc();
        $car_daily_rate = floatval($car_rate['daily_rate']);
    }
    
    $pickup = new DateTime($pickup_date);
    $return = new DateTime($return_date);
    $days = $pickup->diff($return)->days + 1;
    $total_cost = $car_daily_rate * $days;
    
    // Insert booking
    $conn->query("INSERT INTO rental_bookings (user_id, car_name, pickup_date, return_date, total_cost, booking_status, created_at) 
                 VALUES ($user_id, '$car_name', '$pickup_date', '$return_date', $total_cost, 'pending', NOW())");
    
    echo "<script>location.href='index.php?view=bookings';</script>";
    exit;
}

// Handle Edit Booking form submission
if (isset($_POST['edit_booking_submit'])) {
    $booking_id = intval($_POST['edit_booking_id']);
    $user_id = intval($_POST['user_id']);
    $car_name = $conn->real_escape_string($_POST['car_name']);
    $pickup_date = $conn->real_escape_string($_POST['pickup_date']);
    $return_date = $conn->real_escape_string($_POST['return_date']);
    $total_cost = floatval($_POST['total_cost']);
    $booking_status = $conn->real_escape_string($_POST['booking_status']);
    
    $conn->query("UPDATE rental_bookings SET 
                 user_id = $user_id,
                 car_name = '$car_name',
                 pickup_date = '$pickup_date',
                 return_date = '$return_date',
                 total_cost = $total_cost,
                 booking_status = '$booking_status'
                 WHERE booking_id = $booking_id");
    
    echo "<script>location.href='index.php?view=bookings';</script>";
    exit;
}

// Handle Add New Car form submission
if (isset($_POST['add_car_submit'])) {
    $car_name = $conn->real_escape_string($_POST['car_name']);
    $model = $conn->real_escape_string($_POST['model']);
    $year = intval($_POST['year']);
    $color = $conn->real_escape_string($_POST['color']);
    $license_plate = $conn->real_escape_string($_POST['license_plate']);
    $daily_rate = floatval($_POST['daily_rate']);
    $category = $conn->real_escape_string($_POST['category']);
    $status = $conn->real_escape_string($_POST['status']);
    $image_url = trim($conn->real_escape_string($_POST['image_url']));
    if (empty($image_url)) {
        $image_url = 'default_car.png'; // Make sure this file exists in your project
    }
    $doors = $conn->real_escape_string($_POST['doors']);
    $passenger_capacity = intval($_POST['passenger_capacity']);
    $conn->query("INSERT INTO cars (car_name, model, year, color, license_plate, daily_rate, status, image_url, doors, passenger_capacity, category) VALUES ('$car_name', '$model', $year, '$color', '$license_plate', $daily_rate, '$status', '$image_url', '$doors', $passenger_capacity, '$category')");
    echo "<script>location.href='index.php?view=available_cars';</script>";
    exit;
}

// Handle Edit Car form submission
if (isset($_POST['edit_car_submit'])) {
    $car_id = intval($_POST['edit_car_id']);
    $car_name = $conn->real_escape_string($_POST['car_name']);
    $model = $conn->real_escape_string($_POST['model']);
    $year = intval($_POST['year']);
    $color = $conn->real_escape_string($_POST['color']);
    $license_plate = $conn->real_escape_string($_POST['license_plate']);
    $daily_rate = floatval($_POST['daily_rate']);
    $category = $conn->real_escape_string($_POST['category']);
    $status = $conn->real_escape_string($_POST['status']);
    $image_url = $conn->real_escape_string($_POST['image_url']);
    $doors = $conn->real_escape_string($_POST['doors']);
    $passenger_capacity = intval($_POST['passenger_capacity']);
    $conn->query("UPDATE cars SET car_name='$car_name', model='$model', year=$year, color='$color', license_plate='$license_plate', daily_rate=$daily_rate, status='$status', image_url='$image_url', doors='$doors', passenger_capacity=$passenger_capacity, category='$category' WHERE car_id=$car_id");
    echo "<script>location.href='index.php?view=available_cars';</script>";
    exit;
}

// Handle Save Car form submission
if (isset($_POST['save_car_submit'])) {
    $car_id = intval($_POST['edit_car_id']);
    $car_name = $conn->real_escape_string($_POST['car_name']);
    $model = $conn->real_escape_string($_POST['model']);
    $year = intval($_POST['year']);
    $color = $conn->real_escape_string($_POST['color']);
    $license_plate = $conn->real_escape_string($_POST['license_plate']);
    $daily_rate = floatval($_POST['daily_rate']);
    $category = $conn->real_escape_string($_POST['category']);
    $status = $conn->real_escape_string($_POST['status']);
    $image_url = $conn->real_escape_string($_POST['image_url']);
    $doors = $conn->real_escape_string($_POST['doors']);
    $passenger_capacity = intval($_POST['passenger_capacity']);
    $conn->query("UPDATE cars SET car_name='$car_name', model='$model', year=$year, color='$color', license_plate='$license_plate', daily_rate=$daily_rate, status='$status', image_url='$image_url', doors='$doors', passenger_capacity=$passenger_capacity, category='$category' WHERE car_id=$car_id");
    // Return to the same edit page instead of redirecting to the cars list
    echo "<script>alert('Car details saved successfully!');location.href='index.php?view=available_cars&edit_car=$car_id';</script>";
    exit;
}

// Handle Add New Driver form submission
if (isset($_POST['add_driver_submit'])) {
    $full_name = $conn->real_escape_string($_POST['full_name']);
    $age = intval($_POST['age']);
    $phone_number = $conn->real_escape_string($_POST['phone_number']);
    $license_number = $conn->real_escape_string($_POST['license_number']);
    $status = $conn->real_escape_string($_POST['status']);
    $conn->query("INSERT INTO drivers (full_name, age, phone_number, license_number, status, created_at) VALUES ('$full_name', $age, '$phone_number', '$license_number', '$status', NOW())");
    echo "<script>location.href='index.php?view=drivers';</script>";
    exit;
}

// Handle Edit Driver form submission
if (isset($_POST['edit_driver_submit'])) {
    $driver_id = intval($_POST['edit_driver_id']);
    $full_name = $conn->real_escape_string($_POST['full_name']);
    $age = intval($_POST['age']);
    $phone_number = $conn->real_escape_string($_POST['phone_number']);
    $license_number = $conn->real_escape_string($_POST['license_number']);
    $status = $conn->real_escape_string($_POST['status']);
    $conn->query("UPDATE drivers SET full_name='$full_name', age=$age, phone_number='$phone_number', license_number='$license_number', status='$status' WHERE driver_id=$driver_id");
    echo "<script>location.href='index.php?view=drivers';</script>";
    exit;
}

// Handle Delete Driver
if (isset($_POST['delete_driver_id'])) {
    $driver_id = intval($_POST['delete_driver_id']);
    $conn->query("DELETE FROM drivers WHERE driver_id=$driver_id");
    echo "<script>location.href='index.php?view=drivers';</script>";
    exit;
}

// Handle Delete Car
if (isset($_POST['delete_car_id'])) {
    $car_id = intval($_POST['delete_car_id']);
    $conn->query("DELETE FROM cars WHERE car_id=$car_id");
    echo "<script>location.href='index.php?view=available_cars';</script>";
    exit;
}

// Handle Delete User
if (isset($_POST['delete_user_id'])) {
    $user_id = intval($_POST['delete_user_id']);
    $conn->query("DELETE FROM users WHERE user_id=$user_id");
    echo "<script>location.href='index.php?view=users';</script>";
    exit;
}

// Handle Edit User form submission
if (isset($_POST['edit_user_submit'])) {
    $user_id = intval($_POST['edit_user_id']);
    $full_name = $conn->real_escape_string($_POST['full_name']);
    $email = $conn->real_escape_string($_POST['email']);
    $phone_number = $conn->real_escape_string($_POST['phone_number']);
    $role = $conn->real_escape_string($_POST['role']);
    $conn->query("UPDATE users SET full_name='$full_name', email='$email', phone_number='$phone_number', role='$role' WHERE user_id=$user_id");
    echo "<script>location.href='index.php?view=users';</script>";
    exit;
}

// Handle Contact Message Submission
if (isset($_POST['send_contact_message'])) {
    $full_name = $conn->real_escape_string($_POST['contact_full_name']);
    $email = $conn->real_escape_string($_POST['contact_email']);
    $message = $conn->real_escape_string($_POST['contact_message']);
    $conn->query("INSERT INTO contact_messages (full_name, email, message, created_at) VALUES ('$full_name', '$email', '$message', NOW())");
    echo "<script>alert('Message sent successfully!');location.href=location.href;</script>";
    exit;
}

// Handle Add New User form submission
if (isset($_POST['add_user_submit'])) {
    $full_name = $conn->real_escape_string($_POST['full_name']);
    $email = $conn->real_escape_string($_POST['email']);
    $phone_number = $conn->real_escape_string($_POST['phone_number']);
    $role = $conn->real_escape_string($_POST['role']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $conn->query("INSERT INTO users (full_name, email, phone_number, role, password, created_at) VALUES ('$full_name', '$email', '$phone_number', '$role', '$password', NOW())");
    echo "<script>location.href='index.php?view=users';</script>";
    exit;
} 