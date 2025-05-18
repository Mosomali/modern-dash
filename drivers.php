<?php include 'connection.php'; ?>
<!-- Drivers Table -->
<section class="p-8">
    <div class="bg-white rounded-2xl shadow-2xl p-8 w-full">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-bold text-blue-700 flex items-center gap-2"><i class="fa-solid fa-users"></i> Drivers</h2>
            <a href="index.php?view=drivers&add_driver=1" class="px-4 py-2 rounded-lg bg-blue-600 text-white font-semibold shadow hover:bg-blue-700 transition flex items-center gap-2"><i class="fa fa-plus"></i> Add New Driver</a>
        </div>
        <?php if (isset($_GET['add_driver'])): ?>
        <form method="post" class="mb-8 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 bg-blue-50 p-6 rounded-xl shadow">
            <input type="text" name="full_name" placeholder="Full Name" required class="px-3 py-2 rounded border focus:ring-2 focus:ring-blue-400">
            <input type="number" name="age" placeholder="Age" min="18" required class="px-3 py-2 rounded border focus:ring-2 focus:ring-blue-400">
            <input type="tel" name="phone_number" placeholder="Phone Number" pattern="[0-9]+" title="Please enter numbers only" required class="px-3 py-2 rounded border focus:ring-2 focus:ring-blue-400">
            <input type="text" name="license_number" placeholder="License Number" required class="px-3 py-2 rounded border focus:ring-2 focus:ring-blue-400">
            <select name="status" required class="px-3 py-2 rounded border focus:ring-2 focus:ring-blue-400">
                <option value="available">Available</option>
                <option value="busy">Busy</option>
                <option value="inactive">Inactive</option>
            </select>
            <div class="col-span-full flex gap-3 mt-2">
                <button type="submit" name="add_driver_submit" class="px-4 py-2 rounded bg-green-600 text-white font-semibold hover:bg-green-700 transition"><i class="fa fa-check"></i> Save</button>
                <a href="index.php?view=drivers" class="px-4 py-2 rounded bg-gray-300 text-gray-700 font-semibold hover:bg-gray-400 transition"><i class="fa fa-times"></i> Cancel</a>
            </div>
        </form>
        <?php elseif (isset($_GET['edit_driver'])): ?>
        <?php 
        $driver_id = intval($_GET['edit_driver']);
        $driver_query = $conn->query("SELECT driver_id, full_name, age, phone_number, license_number, status, created_at FROM drivers WHERE driver_id = $driver_id");
        if ($driver_query && $driver_query->num_rows > 0):
            $driver = $driver_query->fetch_assoc();
        ?>
        <div class="mb-6">
            <a href="index.php?view=drivers" class="px-4 py-2 rounded-lg bg-gray-200 text-gray-700 font-semibold shadow hover:bg-gray-300 transition flex items-center gap-2 w-fit"><i class="fa fa-arrow-left"></i> Back to Drivers</a>
        </div>
        <form method="post" class="mb-8 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 bg-blue-50 p-6 rounded-xl shadow">
            <div class="col-span-full mb-4">
                <h3 class="text-xl font-bold text-blue-700 flex items-center gap-2"><i class="fa-solid fa-edit"></i> Edit Driver: <?php echo htmlspecialchars($driver['full_name']); ?></h3>
            </div>
            
            <div class="flex flex-col">
                <label class="mb-1 text-sm text-gray-600">Full Name</label>
                <input type="text" name="full_name" value="<?php echo htmlspecialchars($driver['full_name']); ?>" required class="px-3 py-2 rounded border focus:ring-2 focus:ring-blue-400">
            </div>
            
            <div class="flex flex-col">
                <label class="mb-1 text-sm text-gray-600">Age</label>
                <input type="number" name="age" value="<?php echo htmlspecialchars($driver['age']); ?>" min="18" required class="px-3 py-2 rounded border focus:ring-2 focus:ring-blue-400">
            </div>
            
            <div class="flex flex-col">
                <label class="mb-1 text-sm text-gray-600">Phone Number</label>
                <input type="tel" name="phone_number" value="<?php echo htmlspecialchars($driver['phone_number']); ?>" pattern="[0-9]+" title="Please enter numbers only" required class="px-3 py-2 rounded border focus:ring-2 focus:ring-blue-400">
            </div>
            
            <div class="flex flex-col">
                <label class="mb-1 text-sm text-gray-600">License Number</label>
                <input type="text" name="license_number" value="<?php echo htmlspecialchars($driver['license_number']); ?>" required class="px-3 py-2 rounded border focus:ring-2 focus:ring-blue-400">
            </div>
            
            <div class="flex flex-col">
                <label class="mb-1 text-sm text-gray-600">Status</label>
                <select name="status" required class="px-3 py-2 rounded border focus:ring-2 focus:ring-blue-400">
                    <option value="available" <?php if($driver['status']==='available') echo 'selected'; ?>>Available</option>
                    <option value="busy" <?php if($driver['status']==='busy') echo 'selected'; ?>>Busy</option>
                    <option value="inactive" <?php if($driver['status']==='inactive') echo 'selected'; ?>>Inactive</option>
                </select>
            </div>
            
            <div class="flex flex-col">
                <label class="mb-1 text-sm text-gray-600">Created At</label>
                <input type="text" value="<?php echo htmlspecialchars($driver['created_at']); ?>" disabled class="px-3 py-2 rounded border bg-gray-100 text-gray-600">
            </div>
            
            <div class="col-span-full flex gap-3 mt-6">
                <input type="hidden" name="edit_driver_id" value="<?php echo $driver['driver_id']; ?>">
                <button type="submit" name="edit_driver_submit" class="px-4 py-2 rounded bg-green-600 text-white font-semibold hover:bg-green-700 transition"><i class="fa fa-check"></i> Save Changes</button>
                <a href="index.php?view=drivers" class="px-4 py-2 rounded bg-gray-300 text-gray-700 font-semibold hover:bg-gray-400 transition"><i class="fa fa-times"></i> Cancel</a>
            </div>
        </form>
        <?php else: ?>
            <div class="p-6 bg-red-100 text-red-700 rounded-xl mb-6">
                <p>Driver not found. <a href="index.php?view=drivers" class="underline">Return to drivers list</a></p>
            </div>
        <?php endif; ?>
        <?php else: ?>
        <div class="overflow-x-auto rounded-xl">
            <table class="min-w-full text-left border-separate border-spacing-y-2">
                <thead class="bg-blue-50">
                    <tr>
                        <th class="py-3 px-4 rounded-l-xl font-bold">Full Name</th>
                        <th class="py-3 px-4 font-bold">Age</th>
                        <th class="py-3 px-4 font-bold">Phone</th>
                        <th class="py-3 px-4 font-bold">License Number</th>
                        <th class="py-3 px-4 font-bold">Status</th>
                        <th class="py-3 px-4 font-bold">Created At</th>
                        <th class="py-3 px-4 rounded-r-xl font-bold">Action</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                $drivers = $conn->query("SELECT driver_id, full_name, age, phone_number, license_number, status, created_at FROM drivers ORDER BY created_at DESC");
                if ($drivers && $drivers->num_rows > 0):
                    $i = 0;
                    while($driver = $drivers->fetch_assoc()): $i++; ?>
                    <tr class="<?php echo $i % 2 == 0 ? 'bg-blue-50' : 'bg-white'; ?> hover:bg-blue-100 transition">
                        <td class="py-2 px-4 font-semibold text-blue-700"><?php echo htmlspecialchars($driver['full_name']); ?></td>
                        <td class="py-2 px-4"><?php echo htmlspecialchars($driver['age']); ?></td>
                        <td class="py-2 px-4"><?php echo htmlspecialchars($driver['phone_number']); ?></td>
                        <td class="py-2 px-4"><?php echo htmlspecialchars($driver['license_number']); ?></td>
                        <td class="py-2 px-4"><span class="px-2 py-1 rounded bg-green-100 text-green-700 font-semibold"><?php echo htmlspecialchars($driver['status']); ?></span></td>
                        <td class="py-2 px-4"><?php echo htmlspecialchars($driver['created_at']); ?></td>
                        <td class="py-2 px-4 flex gap-2">
                            <a href="index.php?view=drivers&edit_driver=<?php echo $driver['driver_id']; ?>" class="px-3 py-1 rounded bg-yellow-400 text-white font-semibold hover:bg-yellow-500 transition text-sm"><i class="fa fa-edit"></i> Edit</a>
                            <form method="post" style="display:inline" onsubmit="return confirm('Are you sure you want to delete this driver?');">
                                <input type="hidden" name="delete_driver_id" value="<?php echo $driver['driver_id']; ?>">
                                <button type="submit" class="px-3 py-1 rounded bg-red-600 text-white font-semibold hover:bg-red-700 transition text-sm"><i class="fa fa-trash"></i> Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile;
                else: ?>
                    <tr><td colspan="7" class="py-2 px-4 text-center">No drivers found</td></tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
        <?php endif; ?>
    </div>
</section>

<script>
// JavaScript to prevent non-numeric input in phone number fields
document.addEventListener('DOMContentLoaded', function() {
    const phoneInputs = document.querySelectorAll('input[name="phone_number"]');
    
    phoneInputs.forEach(function(input) {
        input.addEventListener('keypress', function(e) {
            // Allow only numeric input (0-9)
            if (e.which < 48 || e.which > 57) {
                e.preventDefault();
            }
        });
        
        // Also prevent paste of non-numeric values
        input.addEventListener('paste', function(e) {
            const pastedText = (e.clipboardData || window.clipboardData).getData('text');
            if (!/^\d+$/.test(pastedText)) {
                e.preventDefault();
            }
        });
    });
});
</script> 