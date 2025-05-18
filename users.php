<?php include 'connection.php'; ?>
<!-- Add User Button and Form -->
<section class="p-8">
    <div class="bg-white rounded-2xl shadow-2xl p-8 w-full">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-bold text-blue-700 flex items-center gap-2"><i class="fa-solid fa-users"></i> Users</h2>
            <a href="index.php?view=users&add_user=1" class="px-4 py-2 rounded-lg bg-blue-600 text-white font-semibold shadow hover:bg-blue-700 transition flex items-center gap-2"><i class="fa fa-plus"></i> Add User</a>
        </div>
        <?php if (isset($_GET['add_user'])): ?>
        <form method="post" class="mb-8 grid grid-cols-1 md:grid-cols-2 gap-4 bg-blue-50 p-6 rounded-xl shadow" enctype="multipart/form-data">
            <input type="text" name="full_name" placeholder="Full Name" required class="px-3 py-2 rounded border focus:ring-2 focus:ring-blue-400">
            <input type="email" name="email" placeholder="Email" required class="px-3 py-2 rounded border focus:ring-2 focus:ring-blue-400">
            <input type="tel" name="phone_number" placeholder="Phone Number" pattern="[0-9]+" title="Please enter numbers only" required class="px-3 py-2 rounded border focus:ring-2 focus:ring-blue-400">
            <select name="role" required class="px-3 py-2 rounded border focus:ring-2 focus:ring-blue-400">
                <option value="user">User</option>
                <option value="admin">Admin</option>
            </select>
            <input type="password" name="password" placeholder="Password" required class="px-3 py-2 rounded border focus:ring-2 focus:ring-blue-400">
            
            <div class="flex flex-col">
                <label class="mb-1 text-sm text-gray-600">Profile Image</label>
                <input type="file" name="profile_image" accept="image/*" class="px-3 py-2 rounded border focus:ring-2 focus:ring-blue-400">
            </div>
            
            <div class="col-span-full flex gap-3 mt-2">
                <button type="submit" name="add_user_submit" class="px-4 py-2 rounded bg-green-600 text-white font-semibold hover:bg-green-700 transition"><i class="fa fa-check"></i> Save</button>
                <a href="index.php?view=users" class="px-4 py-2 rounded bg-gray-300 text-gray-700 font-semibold hover:bg-gray-400 transition"><i class="fa fa-times"></i> Cancel</a>
            </div>
        </form>
        <?php elseif (isset($_GET['edit_user'])): ?>
        <?php 
        $user_id = intval($_GET['edit_user']);
        $user_query = $conn->query("SELECT user_id, full_name, email, phone_number, role, created_at, profile_image FROM users WHERE user_id = $user_id");
        if ($user_query && $user_query->num_rows > 0):
            $user = $user_query->fetch_assoc();
        ?>
        <div class="mb-6">
            <a href="index.php?view=users" class="px-4 py-2 rounded-lg bg-gray-200 text-gray-700 font-semibold shadow hover:bg-gray-300 transition flex items-center gap-2 w-fit"><i class="fa fa-arrow-left"></i> Back to Users</a>
        </div>
        <form method="post" class="mb-8 grid grid-cols-1 md:grid-cols-2 gap-4 bg-blue-50 p-6 rounded-xl shadow" enctype="multipart/form-data">
            <div class="col-span-full mb-4">
                <h3 class="text-xl font-bold text-blue-700 flex items-center gap-2"><i class="fa-solid fa-edit"></i> Edit User: <?php echo htmlspecialchars($user['full_name']); ?></h3>
            </div>
            
            <div class="flex flex-col">
                <label class="mb-1 text-sm text-gray-600">Full Name</label>
                <input type="text" name="full_name" value="<?php echo htmlspecialchars($user['full_name']); ?>" required class="px-3 py-2 rounded border focus:ring-2 focus:ring-blue-400">
            </div>
            
            <div class="flex flex-col">
                <label class="mb-1 text-sm text-gray-600">Email</label>
                <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required class="px-3 py-2 rounded border focus:ring-2 focus:ring-blue-400">
            </div>
            
            <div class="flex flex-col">
                <label class="mb-1 text-sm text-gray-600">Phone Number</label>
                <input type="tel" name="phone_number" value="<?php echo htmlspecialchars($user['phone_number']); ?>" pattern="[0-9]+" title="Please enter numbers only" required class="px-3 py-2 rounded border focus:ring-2 focus:ring-blue-400">
            </div>
            
            <div class="flex flex-col">
                <label class="mb-1 text-sm text-gray-600">Role</label>
                <select name="role" required class="px-3 py-2 rounded border focus:ring-2 focus:ring-blue-400">
                    <option value="admin" <?php if($user['role']==='admin') echo 'selected'; ?>>Admin</option>
                    <option value="user" <?php if($user['role']==='user') echo 'selected'; ?>>User</option>
                </select>
            </div>
            
            <div class="flex flex-col">
                <label class="mb-1 text-sm text-gray-600">Created At</label>
                <input type="text" value="<?php echo htmlspecialchars($user['created_at']); ?>" disabled class="px-3 py-2 rounded border bg-gray-100 text-gray-600">
            </div>
            
            <div class="flex flex-col">
                <label class="mb-1 text-sm text-gray-600">New Password (leave empty to keep current)</label>
                <input type="password" name="password" placeholder="New password" class="px-3 py-2 rounded border focus:ring-2 focus:ring-blue-400">
            </div>
            
            <div class="flex flex-col col-span-full">
                <label class="mb-1 text-sm text-gray-600">Profile Image</label>
                <?php if(!empty($user['profile_image'])): ?>
                <div class="mb-3 flex items-center gap-4">
                    <img src="<?php echo htmlspecialchars($user['profile_image']); ?>" alt="Profile" class="w-16 h-16 rounded-full object-cover border-2 border-blue-300">
                    <span class="text-sm text-gray-600">Current image</span>
                </div>
                <?php endif; ?>
                <input type="file" name="profile_image" accept="image/*" class="px-3 py-2 rounded border focus:ring-2 focus:ring-blue-400">
                <p class="text-sm text-gray-500 mt-1">Leave empty to keep current image</p>
            </div>
            
            <div class="col-span-full flex gap-3 mt-6">
                <input type="hidden" name="edit_user_id" value="<?php echo $user['user_id']; ?>">
                <button type="submit" name="edit_user_submit" class="px-4 py-2 rounded bg-green-600 text-white font-semibold hover:bg-green-700 transition"><i class="fa fa-check"></i> Save Changes</button>
                <a href="index.php?view=users" class="px-4 py-2 rounded bg-gray-300 text-gray-700 font-semibold hover:bg-gray-400 transition"><i class="fa fa-times"></i> Cancel</a>
            </div>
        </form>
        <?php else: ?>
            <div class="p-6 bg-red-100 text-red-700 rounded-xl mb-6">
                <p>User not found. <a href="index.php?view=users" class="underline">Return to users list</a></p>
            </div>
        <?php endif; ?>
        <?php else: ?>
        <div class="overflow-x-auto rounded-xl">
            <table class="min-w-full text-left border-separate border-spacing-y-2">
                <thead class="bg-blue-50">
                    <tr>
                        <th class="py-3 px-4 rounded-l-xl font-bold">Image</th>
                        <th class="py-3 px-4 font-bold">Full Name</th>
                        <th class="py-3 px-4 font-bold">Email</th>
                        <th class="py-3 px-4 font-bold">Phone</th>
                        <th class="py-3 px-4 font-bold">Role</th>
                        <th class="py-3 px-4 font-bold">Created At</th>
                        <th class="py-3 px-4 font-bold">Action</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                $users = $conn->query("SELECT user_id, full_name, email, phone_number, role, created_at, profile_image FROM users ORDER BY created_at DESC");
                if ($users && $users->num_rows > 0):
                    $i = 0;
                    while($user = $users->fetch_assoc()): $i++; ?>
                    <tr class="<?php echo $i % 2 == 0 ? 'bg-blue-50' : 'bg-white'; ?> hover:bg-blue-100 transition">
                        <td class="py-2 px-4">
                            <?php if(!empty($user['profile_image'])): ?>
                                <img src="<?php echo htmlspecialchars($user['profile_image']); ?>" alt="Profile" class="w-10 h-10 rounded-full object-cover border-2 border-blue-300">
                            <?php else: ?>
                                <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center">
                                    <i class="fa fa-user text-blue-400"></i>
                                </div>
                            <?php endif; ?>
                        </td>
                        <td class="py-2 px-4 font-semibold text-blue-700"><a href="#" class="hover:underline"><?php echo htmlspecialchars($user['full_name']); ?></a></td>
                        <td class="py-2 px-4"><?php echo htmlspecialchars($user['email']); ?></td>
                        <td class="py-2 px-4"><?php echo htmlspecialchars($user['phone_number']); ?></td>
                        <td class="py-2 px-4">
                            <?php if($user['role'] == 'admin'): ?>
                                <span class="px-2 py-1 rounded bg-green-100 text-green-700 font-semibold">admin</span>
                            <?php else: ?>
                                <span class="px-2 py-1 rounded bg-blue-100 text-blue-700 font-semibold">user</span>
                            <?php endif; ?>
                        </td>
                        <td class="py-2 px-4"><?php echo htmlspecialchars($user['created_at']); ?></td>
                        <td class="py-2 px-4">
                            <div class="flex gap-2">
                                <a href="index.php?view=users&edit_user=<?php echo $user['user_id']; ?>" class="px-3 py-1 rounded bg-yellow-400 text-white font-semibold hover:bg-yellow-500 transition text-sm"><i class="fa fa-edit"></i> Edit</a>
                                <form method="post" style="display:inline" onsubmit="return confirm('Are you sure you want to delete this user?');">
                                    <input type="hidden" name="delete_user_id" value="<?php echo $user['user_id']; ?>">
                                    <button type="submit" class="px-3 py-1 rounded bg-red-600 text-white font-semibold hover:bg-red-700 transition text-sm"><i class="fa fa-trash"></i> Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                <?php endwhile;
                else: ?>
                    <tr><td colspan="7" class="py-2 px-4 text-center">No users found</td></tr>
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