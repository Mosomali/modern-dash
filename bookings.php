<?php include 'connection.php'; ?>
<!-- Bookings Table -->
<section class="p-8">
    <div class="bg-white rounded-2xl shadow-lg p-6">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-bold text-blue-700 flex items-center gap-2"><i class="fa-solid fa-calendar-check"></i> Bookings</h2>
            <a href="index.php?view=bookings&add_booking=1" class="px-4 py-2 rounded-lg bg-blue-600 text-white font-semibold shadow hover:bg-blue-700 transition flex items-center gap-2"><i class="fa fa-plus"></i> Add New Booking</a>
        </div>
        
        <?php if (isset($_GET['add_booking'])): ?>
        <form method="post" class="mb-8 grid grid-cols-1 md:grid-cols-2 gap-4 bg-blue-50 p-6 rounded-xl shadow">
            <div class="flex flex-col">
                <label class="mb-1 text-sm text-gray-600">Customer</label>
                <select name="user_id" required class="px-3 py-2 rounded border focus:ring-2 focus:ring-blue-400">
                    <option value="">Select Customer</option>
                    <?php
                    $users = $conn->query("SELECT user_id, full_name FROM users ORDER BY full_name");
                    if ($users && $users->num_rows > 0):
                        while($user = $users->fetch_assoc()): ?>
                            <option value="<?php echo $user['user_id']; ?>"><?php echo htmlspecialchars($user['full_name']); ?></option>
                        <?php endwhile;
                    endif; ?>
                </select>
            </div>
            
            <div class="flex flex-col">
                <label class="mb-1 text-sm text-gray-600">Car</label>
                <select name="car_id" required class="px-3 py-2 rounded border focus:ring-2 focus:ring-blue-400">
                    <option value="">Select Car</option>
                    <?php
                    $cars = $conn->query("SELECT car_id, car_name, daily_rate FROM cars WHERE status='available' ORDER BY car_name");
                    if ($cars && $cars->num_rows > 0):
                        while($car = $cars->fetch_assoc()): ?>
                            <option value="<?php echo $car['car_id']; ?>" data-rate="<?php echo $car['daily_rate']; ?>"><?php echo htmlspecialchars($car['car_name']); ?> ($<?php echo $car['daily_rate']; ?>/day)</option>
                        <?php endwhile;
                    endif; ?>
                </select>
            </div>
            
            <div class="flex flex-col">
                <label class="mb-1 text-sm text-gray-600">Pickup Date</label>
                <input type="date" name="pickup_date" required class="px-3 py-2 rounded border focus:ring-2 focus:ring-blue-400">
            </div>
            
            <div class="flex flex-col">
                <label class="mb-1 text-sm text-gray-600">Return Date</label>
                <input type="date" name="return_date" required class="px-3 py-2 rounded border focus:ring-2 focus:ring-blue-400">
            </div>
            
            <div class="col-span-full flex gap-3 mt-2">
                <button type="submit" name="add_booking_submit" class="px-4 py-2 rounded bg-green-600 text-white font-semibold hover:bg-green-700 transition"><i class="fa fa-check"></i> Save</button>
                <a href="index.php?view=bookings" class="px-4 py-2 rounded bg-gray-300 text-gray-700 font-semibold hover:bg-gray-400 transition"><i class="fa fa-times"></i> Cancel</a>
            </div>
        </form>
        
        <?php elseif (isset($_GET['edit_booking'])): ?>
        <?php 
        $booking_id = intval($_GET['edit_booking']);
        $booking_query = $conn->query("SELECT rb.*, u.full_name 
                                      FROM rental_bookings rb 
                                      LEFT JOIN users u ON rb.user_id = u.user_id 
                                      WHERE rb.booking_id = $booking_id");
        if ($booking_query && $booking_query->num_rows > 0):
            $booking = $booking_query->fetch_assoc();
        ?>
        <div class="mb-6">
            <a href="index.php?view=bookings" class="px-4 py-2 rounded-lg bg-gray-200 text-gray-700 font-semibold shadow hover:bg-gray-300 transition flex items-center gap-2 w-fit"><i class="fa fa-arrow-left"></i> Back to Bookings</a>
        </div>
        <form method="post" class="mb-8 grid grid-cols-1 md:grid-cols-2 gap-4 bg-blue-50 p-6 rounded-xl shadow">
            <div class="col-span-full mb-4">
                <h3 class="text-xl font-bold text-blue-700 flex items-center gap-2"><i class="fa-solid fa-edit"></i> Edit Booking #<?php echo $booking_id; ?></h3>
            </div>
            
            <div class="flex flex-col">
                <label class="mb-1 text-sm text-gray-600">Customer</label>
                <select name="user_id" required class="px-3 py-2 rounded border focus:ring-2 focus:ring-blue-400">
                    <?php
                    $users = $conn->query("SELECT user_id, full_name FROM users ORDER BY full_name");
                    if ($users && $users->num_rows > 0):
                        while($user = $users->fetch_assoc()): ?>
                            <option value="<?php echo $user['user_id']; ?>" <?php if($user['user_id'] == $booking['user_id']) echo 'selected'; ?>><?php echo htmlspecialchars($user['full_name']); ?></option>
                        <?php endwhile;
                    endif; ?>
                </select>
            </div>
            
            <div class="flex flex-col">
                <label class="mb-1 text-sm text-gray-600">Car Name</label>
                <input type="text" name="car_name" value="<?php echo htmlspecialchars($booking['car_name']); ?>" required class="px-3 py-2 rounded border focus:ring-2 focus:ring-blue-400">
            </div>
            
            <div class="flex flex-col">
                <label class="mb-1 text-sm text-gray-600">Pickup Date</label>
                <input type="date" name="pickup_date" value="<?php echo date('Y-m-d', strtotime($booking['pickup_date'])); ?>" required class="px-3 py-2 rounded border focus:ring-2 focus:ring-blue-400">
            </div>
            
            <div class="flex flex-col">
                <label class="mb-1 text-sm text-gray-600">Return Date</label>
                <input type="date" name="return_date" value="<?php echo date('Y-m-d', strtotime($booking['return_date'])); ?>" required class="px-3 py-2 rounded border focus:ring-2 focus:ring-blue-400">
            </div>
            
            <div class="flex flex-col">
                <label class="mb-1 text-sm text-gray-600">Total Cost</label>
                <input type="number" step="0.01" name="total_cost" value="<?php echo $booking['total_cost']; ?>" required class="px-3 py-2 rounded border focus:ring-2 focus:ring-blue-400">
            </div>
            
            <div class="flex flex-col">
                <label class="mb-1 text-sm text-gray-600">Status</label>
                <select name="booking_status" required class="px-3 py-2 rounded border focus:ring-2 focus:ring-blue-400">
                    <option value="pending" <?php if($booking['booking_status']=='pending') echo 'selected'; ?>>Pending</option>
                    <option value="active" <?php if($booking['booking_status']=='active') echo 'selected'; ?>>Active</option>
                    <option value="returned" <?php if($booking['booking_status']=='returned') echo 'selected'; ?>>Returned</option>
                    <option value="canceled" <?php if($booking['booking_status']=='canceled') echo 'selected'; ?>>Canceled</option>
                </select>
            </div>
            
            <div class="col-span-full flex gap-3 mt-6">
                <input type="hidden" name="edit_booking_id" value="<?php echo $booking_id; ?>">
                <button type="submit" name="edit_booking_submit" class="px-4 py-2 rounded bg-green-600 text-white font-semibold hover:bg-green-700 transition"><i class="fa fa-check"></i> Save Changes</button>
                <a href="index.php?view=bookings" class="px-4 py-2 rounded bg-gray-300 text-gray-700 font-semibold hover:bg-gray-400 transition"><i class="fa fa-times"></i> Cancel</a>
            </div>
        </form>
        <?php else: ?>
            <div class="p-6 bg-red-100 text-red-700 rounded-xl mb-6">
                <p>Booking not found. <a href="index.php?view=bookings" class="underline">Return to bookings list</a></p>
            </div>
        <?php endif; ?>
        
        <?php else: ?>
        <div class="overflow-x-auto rounded-xl">
            <table class="min-w-full text-left border-separate border-spacing-y-2">
                <thead class="bg-blue-50">
                    <tr>
                        <th class="py-3 px-4 rounded-l-xl">Customer Name</th>
                        <th class="py-3 px-4">Car Rented</th>
                        <th class="py-3 px-4">Rent Duration</th>
                        <th class="py-3 px-4">Total Cost</th>
                        <th class="py-3 px-4">Status</th>
                        <th class="py-3 px-4 rounded-r-xl">Action</th>
                    </tr>
                </thead>
                <?php
                $bookings = $conn->query("SELECT rb.booking_id, u.full_name, rb.car_name, rb.pickup_date, rb.return_date, rb.total_cost, rb.booking_status FROM rental_bookings rb LEFT JOIN users u ON rb.user_id = u.user_id ORDER BY rb.booking_id DESC LIMIT 10");
                ?>
                <tbody>
                <?php if ($bookings && $bookings->num_rows > 0): ?>
                    <?php while($row = $bookings->fetch_assoc()): ?>
                    <tr class="bg-blue-100/50 hover:bg-blue-200 transition">
                        <td class="py-2 px-4 font-semibold text-blue-900"><?php echo htmlspecialchars($row['full_name']); ?></td>
                        <td class="py-2 px-4"><?php echo htmlspecialchars($row['car_name']); ?></td>
                        <td class="py-2 px-4 text-center">
                            <?php
                            $pickup = new DateTime($row['pickup_date']);
                            $return = new DateTime($row['return_date']);
                            $days = $pickup->diff($return)->days + 1;
                            ?>
                            <div class="flex flex-col items-center gap-2">
                                <button type="button" class="flex items-center gap-2 px-3 py-1 rounded-full bg-blue-500 text-white font-semibold shadow hover:scale-105 transition text-xs cursor-default" title="Rent Duration" style="display:inline-flex;">
                                    <i class="fa fa-calendar-alt"></i>
                                    <?php echo htmlspecialchars($row['pickup_date']) . ' - ' . htmlspecialchars($row['return_date']); ?>
                                </button>
                                <button type="button" class="flex items-center gap-2 px-3 py-1 rounded-full bg-green-500 text-white font-semibold shadow hover:scale-105 transition text-xs cursor-default" title="Days" style="display:inline-flex;">
                                    <i class="fa fa-calendar-day"></i>
                                    <?php echo $days; ?> days
                                </button>
                            </div>
                        </td>
                        <td class="py-2 px-4">$
                            <?php echo number_format($row['total_cost'], 2); ?>
                        </td>
                        <td class="py-2 px-4">
                            <?php if($row['booking_status'] == 'active'): ?>
                                <span class="px-2 py-1 rounded bg-green-100 text-green-700">Active</span>
                            <?php elseif($row['booking_status'] == 'returned'): ?>
                                <span class="px-2 py-1 rounded bg-blue-100 text-blue-700">Returned</span>
                            <?php elseif($row['booking_status'] == 'pending'): ?>
                                <span class="px-2 py-1 rounded bg-yellow-100 text-yellow-700">Pending</span>
                            <?php else: ?>
                                <span class="px-2 py-1 rounded bg-gray-100 text-gray-700"><?php echo htmlspecialchars($row['booking_status']); ?></span>
                            <?php endif; ?>
                        </td>
                        <td class="py-2 px-4">
                            <div class="flex gap-2">
                                <a href="index.php?view=bookings&edit_booking=<?php echo $row['booking_id']; ?>" class="px-3 py-1 rounded bg-yellow-400 text-white font-semibold hover:bg-yellow-500 transition text-sm"><i class="fa fa-edit"></i> Edit</a>
                                
                                <?php if($row['booking_status'] == 'pending'): ?>
                                    <form method="post" style="display:inline">
                                        <input type="hidden" name="mark_active_id" value="<?php echo $row['booking_id']; ?>">
                                        <button type="submit" class="px-3 py-1 rounded bg-blue-600 text-white hover:bg-blue-700 transition text-sm font-semibold"><i class="fa fa-check"></i> Activate</button>
                                    </form>
                                    <form method="post" style="display:inline" onsubmit="return confirm('Are you sure you want to cancel this booking?');">
                                        <input type="hidden" name="cancel_booking_id" value="<?php echo $row['booking_id']; ?>">
                                        <button type="submit" class="px-3 py-1 rounded bg-red-600 text-white hover:bg-red-700 transition text-sm font-semibold"><i class="fa fa-times"></i> Cancel</button>
                                    </form>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr><td colspan="6" class="py-2 px-4 text-center">No bookings found</td></tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
        <?php endif; ?>
    </div>
</section>

<script>
// Calculate total cost when dates or car change
document.addEventListener('DOMContentLoaded', function() {
    // Only run this if we're on the add/edit booking page
    const pickupDateField = document.querySelector('input[name="pickup_date"]');
    const returnDateField = document.querySelector('input[name="return_date"]');
    const carSelect = document.querySelector('select[name="car_id"]');
    const totalCostField = document.querySelector('input[name="total_cost"]');
    
    if (pickupDateField && returnDateField && carSelect) {
        const calculateTotal = function() {
            const pickupDate = new Date(pickupDateField.value);
            const returnDate = new Date(returnDateField.value);
            
            if (pickupDate && returnDate && !isNaN(pickupDate) && !isNaN(returnDate)) {
                // Calculate number of days
                const timeDiff = returnDate.getTime() - pickupDate.getTime();
                const days = Math.ceil(timeDiff / (1000 * 3600 * 24)) + 1; // +1 because both pickup and return days are counted
                
                if (days > 0) {
                    // Get daily rate from selected car
                    const selectedOption = carSelect.options[carSelect.selectedIndex];
                    const dailyRate = selectedOption ? parseFloat(selectedOption.dataset.rate) : 0;
                    
                    if (dailyRate && !isNaN(dailyRate)) {
                        const total = days * dailyRate;
                        if (totalCostField) {
                            totalCostField.value = total.toFixed(2);
                        }
                    }
                }
            }
        };
        
        // Add event listeners
        pickupDateField.addEventListener('change', calculateTotal);
        returnDateField.addEventListener('change', calculateTotal);
        carSelect.addEventListener('change', calculateTotal);
    }
});
</script> 