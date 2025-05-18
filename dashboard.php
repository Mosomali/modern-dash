<?php
// Dashboard Cards
$cars_available = $conn->query("SELECT COUNT(*) as total FROM cars WHERE status='available'")->fetch_assoc()['total'];

// Check if bookings table exists before querying
$table_exists = $conn->query("SHOW TABLES LIKE 'bookings'")->num_rows > 0;
$recent_notifications = [];
$notification_count = 0;

if ($table_exists) {
    // Get recent notifications (bookings in the last 24 hours)
    $recent_notifications = $conn->query("SELECT b.booking_id, b.created_at, u.full_name as user_name, c.model as car_model 
                                        FROM bookings b 
                                        JOIN users u ON b.user_id = u.user_id 
                                        JOIN cars c ON b.car_id = c.car_id 
                                        WHERE b.created_at >= DATE_SUB(NOW(), INTERVAL 24 HOUR) 
                                        ORDER BY b.created_at DESC 
                                        LIMIT 5");
    $notification_count = $recent_notifications ? $recent_notifications->num_rows : 0;
}
?>
<!-- Dashboard Cards -->
<section class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 p-8">
    <div class="bg-gradient-to-tr from-blue-500 to-blue-300 p-6 rounded-2xl shadow flex flex-col items-center text-white relative overflow-hidden">
        <i class="fa-solid fa-car-side text-4xl mb-2 opacity-80"></i>
        <span class="text-lg">Total Cars</span>
        <span class="text-3xl font-extrabold"><?php echo $total_cars; ?></span>
    </div>
    <div class="bg-gradient-to-tr from-green-500 to-green-300 p-6 rounded-2xl shadow flex flex-col items-center text-white relative overflow-hidden">
        <i class="fa-solid fa-calendar-check text-4xl mb-2 opacity-80"></i>
        <span class="text-lg">Total Bookings</span>
        <span class="text-3xl font-extrabold"><?php echo $total_bookings ?? 0; ?></span>
    </div>
    <div class="bg-gradient-to-tr from-yellow-500 to-yellow-300 p-6 rounded-2xl shadow flex flex-col items-center text-white relative overflow-hidden">
        <i class="fa-solid fa-car text-4xl mb-2 opacity-80"></i>
        <span class="text-lg">Cars Available</span>
        <span class="text-3xl font-extrabold"><?php echo $cars_available; ?></span>
    </div>
    <div class="bg-gradient-to-tr from-red-500 to-red-300 p-6 rounded-2xl shadow flex flex-col items-center text-white relative overflow-hidden">
        <i class="fa-solid fa-clock text-4xl mb-2 opacity-80"></i>
        <span class="text-lg">Pending Requests</span>
        <span class="text-3xl font-extrabold"><?php echo $pending_bookings ?? 0; ?></span>
    </div>
    <div class="bg-gradient-to-tr from-red-600 to-red-400 p-6 rounded-2xl shadow flex flex-col items-center text-white relative overflow-hidden">
        <i class="fa-solid fa-ban text-4xl mb-2 opacity-80"></i>
        <span class="text-lg">Canceled Bookings</span>
        <span class="text-3xl font-extrabold"><?php echo $canceled_bookings ?? 0; ?></span>
    </div>
    <div class="bg-gradient-to-tr from-indigo-500 to-indigo-300 p-6 rounded-2xl shadow flex flex-col items-center text-white relative overflow-hidden">
        <i class="fa-solid fa-id-badge text-4xl mb-2 opacity-80"></i>
        <span class="text-lg">Total Drivers</span>
        <span class="text-3xl font-extrabold"><?php echo $total_drivers ?? 0; ?></span>
    </div>
</section>

<!-- Notifications Section -->
<section class="p-8 pt-0">
    <div class="bg-white rounded-2xl shadow-lg p-6 mb-8">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-xl font-bold text-blue-700 flex items-center gap-2">
                <i class="fa-solid fa-bell"></i> Recent Notifications
                <?php if($notification_count > 0): ?>
                <span class="inline-flex items-center justify-center w-6 h-6 ml-2 text-xs font-semibold text-white bg-red-500 rounded-full"><?php echo $notification_count; ?></span>
                <?php endif; ?>
            </h2>
            <?php if($notification_count > 0): ?>
            <button class="text-blue-600 hover:text-blue-800 text-sm font-medium" onclick="markAllAsRead()">
                <i class="fa-solid fa-check-double"></i> Mark all as read
            </button>
            <?php endif; ?>
        </div>
        
        <div class="space-y-3 max-h-80 overflow-y-auto pr-2">
            <?php if($table_exists && $recent_notifications && $recent_notifications->num_rows > 0): 
                while($notification = $recent_notifications->fetch_assoc()): 
                    // Calculate time ago
                    $time_created = strtotime($notification['created_at']);
                    $time_diff = time() - $time_created;
                    
                    if($time_diff < 60) {
                        $time_ago = "Just now";
                    } elseif($time_diff < 3600) {
                        $time_ago = floor($time_diff / 60) . " min ago";
                    } elseif($time_diff < 86400) {
                        $time_ago = floor($time_diff / 3600) . " hours ago";
                    } else {
                        $time_ago = floor($time_diff / 86400) . " days ago";
                    }
            ?>
                <div class="flex items-start p-4 bg-blue-50 rounded-xl hover:bg-blue-100 transition notification-item unread">
                    <div class="flex-shrink-0 w-10 h-10 mr-3 bg-blue-100 rounded-full flex items-center justify-center text-blue-500">
                        <i class="fa-solid fa-car-side"></i>
                    </div>
                    <div class="flex-1">
                        <div class="font-medium">New Booking Alert</div>
                        <p class="text-sm text-gray-600">
                            <span class="font-semibold text-blue-700"><?php echo htmlspecialchars($notification['user_name']); ?></span> 
                            booked a <span class="font-semibold text-blue-700"><?php echo htmlspecialchars($notification['car_model']); ?></span>
                        </p>
                        <div class="flex items-center justify-between mt-1">
                            <span class="text-xs text-gray-500"><?php echo $time_ago; ?></span>
                            <a href="index.php?view=bookings&edit_booking=<?php echo $notification['booking_id']; ?>" class="text-xs text-blue-600 hover:underline">View details</a>
                        </div>
                    </div>
                    <button class="ml-2 text-gray-400 hover:text-gray-600 mark-read" data-id="<?php echo $notification['booking_id']; ?>">
                        <i class="fa-solid fa-times"></i>
                    </button>
                </div>
            <?php endwhile; 
            else: ?>
                <div class="text-center py-8 text-gray-500">
                    <?php if(!$table_exists): ?>
                    <i class="fa-solid fa-database text-4xl mb-2 opacity-30"></i>
                    <p>Bookings system is not set up yet</p>
                    <p class="text-sm mt-2">Notifications will appear here once bookings are available</p>
                    <?php else: ?>
                    <i class="fa-solid fa-bell-slash text-4xl mb-2 opacity-30"></i>
                    <p>No new notifications in the last 24 hours</p>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- Latest Contact Messages below the cards -->
<section class="p-8 pt-0">
    <div class="bg-white rounded-2xl shadow-lg p-6 mb-8">
        <h2 class="text-xl font-bold mb-4 text-blue-700 flex items-center gap-2"><i class="fa-solid fa-envelope"></i> Latest Contact Messages</h2>
        <div class="overflow-x-auto rounded-xl">
            <table class="min-w-full text-left border-separate border-spacing-y-2">
                <thead class="bg-blue-50">
                    <tr>
                        <th class="py-3 px-4 rounded-l-xl">Name</th>
                        <th class="py-3 px-4">Email</th>
                        <th class="py-3 px-4">Message</th>
                        <th class="py-3 px-4 rounded-r-xl">Date</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                $messages = $conn->query("SELECT full_name, email, message, created_at FROM contact_messages ORDER BY created_at DESC");
                if ($messages && $messages->num_rows > 0):
                    while($msg = $messages->fetch_assoc()): ?>
                    <tr class="bg-blue-100/50 hover:bg-blue-200 transition">
                        <td class="py-2 px-4 font-semibold text-blue-900"><?php echo htmlspecialchars($msg['full_name']); ?></td>
                        <td class="py-2 px-4"><?php echo htmlspecialchars($msg['email']); ?></td>
                        <td class="py-2 px-4"><?php echo htmlspecialchars($msg['message']); ?></td>
                        <td class="py-2 px-4"><?php echo htmlspecialchars($msg['created_at']); ?></td>
                    </tr>
                <?php endwhile;
                else: ?>
                    <tr><td colspan="4" class="py-2 px-4 text-center">No messages found</td></tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</section>

<script>
// Notification handling functions
function markAllAsRead() {
    document.querySelectorAll('.notification-item').forEach(item => {
        item.classList.remove('unread');
        item.classList.add('read', 'bg-gray-50');
    });
    
    // Update notification counter
    const counter = document.querySelector('h2 .rounded-full');
    if (counter) counter.style.display = 'none';
}

document.addEventListener('DOMContentLoaded', function() {
    // Individual notification dismiss
    document.querySelectorAll('.mark-read').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const notificationItem = this.closest('.notification-item');
            notificationItem.classList.add('fade-out');
            
            setTimeout(() => {
                notificationItem.remove();
                
                // Update count if needed
                const remainingUnread = document.querySelectorAll('.notification-item.unread').length;
                const counter = document.querySelector('h2 .rounded-full');
                
                if (counter) {
                    if (remainingUnread === 0) {
                        counter.style.display = 'none';
                    } else {
                        counter.textContent = remainingUnread;
                    }
                }
            }, 300);
        });
    });
});
</script>

<style>
.notification-item {
    position: relative;
    transition: all 0.3s ease;
}

.notification-item.unread {
    border-left: 3px solid #3b82f6;
}

.notification-item.fade-out {
    opacity: 0;
    transform: translateX(10px);
}

/* Custom scrollbar for notifications */
.overflow-y-auto::-webkit-scrollbar {
    width: 5px;
}

.overflow-y-auto::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 10px;
}

.overflow-y-auto::-webkit-scrollbar-thumb {
    background: #ccc;
    border-radius: 10px;
}

.overflow-y-auto::-webkit-scrollbar-thumb:hover {
    background: #3b82f6;
}
</style> 