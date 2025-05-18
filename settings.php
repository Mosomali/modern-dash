<?php include 'connection.php'; ?>
<!-- Redesigned Settings Page with Tabs -->
<section class="p-8">
    <div class="max-w-3xl mx-auto bg-white rounded-2xl shadow-2xl overflow-hidden">
        <div class="p-6 bg-gradient-to-r from-blue-600 to-blue-800 text-white">
            <h2 class="text-2xl font-bold flex items-center gap-2"><i class="fa-solid fa-gear"></i> Settings</h2>
            <p class="text-blue-100 mt-1">Manage your account preferences and security</p>
        </div>
        
        <!-- Settings Content with Tabs -->
        <div class="flex flex-col md:flex-row">
            <!-- Settings Sidebar -->
            <aside class="bg-blue-50 w-full md:w-56 flex-shrink-0 flex flex-row md:flex-col border-r border-blue-100">
                <a href="#profile" onclick="showTab('profile')" id="tablink-profile" class="settings-tablink flex-1 px-6 py-4 text-blue-700 font-semibold flex items-center gap-2 border-b border-blue-100 hover:bg-blue-100 cursor-pointer"><i class="fa-solid fa-user"></i> Profile</a>
                <a href="#security" onclick="showTab('security')" id="tablink-security" class="settings-tablink flex-1 px-6 py-4 text-blue-700 font-semibold flex items-center gap-2 border-b border-blue-100 hover:bg-blue-100 cursor-pointer"><i class="fa-solid fa-lock"></i> Security</a>
                <a href="#notifications" onclick="showTab('notifications')" id="tablink-notifications" class="settings-tablink flex-1 px-6 py-4 text-blue-700 font-semibold flex items-center gap-2 border-b border-blue-100 hover:bg-blue-100 cursor-pointer"><i class="fa-solid fa-bell"></i> Notifications</a>
                <a href="#logout" onclick="showTab('logout')" id="tablink-logout" class="settings-tablink flex-1 px-6 py-4 text-blue-700 font-semibold flex items-center gap-2 hover:bg-blue-100 cursor-pointer"><i class="fa-solid fa-right-from-bracket"></i> Logout</a>
            </aside>
            
            <!-- Settings Content -->
            <div class="flex-1 p-8">
                <!-- Profile Tab -->
                <div id="tab-profile" class="settings-tab">
                    <h2 class="text-2xl font-bold text-blue-700 mb-6 flex items-center gap-2"><i class="fa-solid fa-user"></i> Profile Settings</h2>
                    
                    <form method="post" class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="col-span-full flex flex-col items-center gap-4 bg-blue-50 p-6 rounded-xl mb-6">
                            <div class="relative">
                                <img src="22.jpg" alt="" class="w-24 h-24 rounded-full border-4 border-blue-200 shadow">
                                <button type="button" class="absolute bottom-0 right-0 bg-blue-600 text-white p-2 rounded-full shadow hover:bg-blue-700 transition">
                                    <i class="fa-solid fa-camera"></i>
                                </button>
                            </div>
                            <div class="text-center">
                                <div class="font-bold text-xl text-blue-700">Admin</div>
                                <div class="text-gray-500 text-sm">MoSomali@example.com</div>
                            </div>
                        </div>
                        
                        <div class="flex flex-col">
                            <label class="mb-1 text-sm text-gray-600 font-medium">Full Name</label>
                            <input type="text" name="full_name" value="Admin" class="px-3 py-2 rounded border focus:ring-2 focus:ring-blue-400">
                        </div>
                        
                        <div class="flex flex-col">
                            <label class="mb-1 text-sm text-gray-600 font-medium">Email Address</label>
                            <input type="email" name="email" value="MoSomali@example.com" class="px-3 py-2 rounded border focus:ring-2 focus:ring-blue-400">
                        </div>
                        
                        <div class="flex flex-col">
                            <label class="mb-1 text-sm text-gray-600 font-medium">Phone Number</label>
                            <input type="tel" name="phone_number" value="615555123" pattern="[0-9]+" title="Please enter numbers only" class="px-3 py-2 rounded border focus:ring-2 focus:ring-blue-400">
                        </div>
                        
                        <div class="flex flex-col">
                            <label class="mb-1 text-sm text-gray-600 font-medium">Role</label>
                            <input type="text" value="Administrator" disabled class="px-3 py-2 rounded border bg-gray-100 text-gray-600">
                        </div>
                        
                        <div class="col-span-full mt-4">
                            <button type="submit" name="update_profile" class="px-4 py-2 rounded bg-blue-600 text-white font-semibold hover:bg-blue-700 transition"><i class="fa fa-check"></i> Save Changes</button>
                        </div>
                    </form>
                </div>
                
                <!-- Security Tab -->
                <div id="tab-security" class="settings-tab hidden">
                    <h2 class="text-2xl font-bold text-blue-700 mb-6 flex items-center gap-2"><i class="fa-solid fa-lock"></i> Security Settings</h2>
                    
                    <form method="post" class="bg-blue-50 p-6 rounded-xl shadow flex flex-col gap-4 max-w-md mx-auto">
                        <div class="mb-4">
                            <h3 class="text-lg font-semibold text-blue-800 mb-1">Change Password</h3>
                            <p class="text-sm text-gray-600">Update your password to keep your account secure</p>
                        </div>
                        
                        <div class="flex flex-col">
                            <label class="mb-1 text-sm text-gray-600 font-medium">Current Password</label>
                            <input type="password" name="old_password" placeholder="Enter current password" class="px-3 py-2 rounded border focus:ring-2 focus:ring-blue-400">
                        </div>
                        
                        <div class="flex flex-col">
                            <label class="mb-1 text-sm text-gray-600 font-medium">New Password</label>
                            <input type="password" name="new_password" placeholder="Enter new password" class="px-3 py-2 rounded border focus:ring-2 focus:ring-blue-400">
                        </div>
                        
                        <div class="flex flex-col">
                            <label class="mb-1 text-sm text-gray-600 font-medium">Confirm New Password</label>
                            <input type="password" name="confirm_password" placeholder="Confirm new password" class="px-3 py-2 rounded border focus:ring-2 focus:ring-blue-400">
                        </div>
                        
                        <button type="submit" name="change_password" class="px-4 py-2 rounded bg-blue-600 text-white font-semibold hover:bg-blue-700 transition mt-2"><i class="fa fa-check"></i> Update Password</button>
                    </form>
                    
                    <div class="mt-8 bg-blue-50 p-6 rounded-xl shadow max-w-md mx-auto">
                        <div class="mb-4">
                            <h3 class="text-lg font-semibold text-blue-800 mb-1">Two-Factor Authentication</h3>
                            <p class="text-sm text-gray-600">Add an extra layer of security to your account</p>
                        </div>
                        
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-700 font-medium">2FA Status: <span class="text-red-600">Disabled</span></p>
                            </div>
                            <button type="button" class="px-4 py-2 rounded bg-blue-600 text-white font-semibold hover:bg-blue-700 transition"><i class="fa-solid fa-shield"></i> Enable</button>
                        </div>
                    </div>
                </div>
                
                <!-- Notifications Tab -->
                <div id="tab-notifications" class="settings-tab hidden">
                    <h2 class="text-2xl font-bold text-blue-700 mb-6 flex items-center gap-2"><i class="fa-solid fa-bell"></i> Notification Settings</h2>
                    
                    <form method="post" class="bg-blue-50 p-6 rounded-xl shadow">
                        <div class="mb-6">
                            <h3 class="text-lg font-semibold text-blue-800 mb-1">Email Notifications</h3>
                            <p class="text-sm text-gray-600">Choose which notifications you want to receive via email</p>
                        </div>
                        
                        <div class="space-y-4">
                            <div class="flex items-center justify-between p-3 bg-white rounded border">
                                <div>
                                    <p class="font-medium text-gray-800">New Bookings</p>
                                    <p class="text-sm text-gray-600">Receive notifications for new car bookings</p>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" name="notify_bookings" class="sr-only peer" checked>
                                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                                </label>
                            </div>
                            
                            <div class="flex items-center justify-between p-3 bg-white rounded border">
                                <div>
                                    <p class="font-medium text-gray-800">System Updates</p>
                                    <p class="text-sm text-gray-600">Receive notifications about system updates</p>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" name="notify_updates" class="sr-only peer" checked>
                                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                                </label>
                            </div>
                            
                            <div class="flex items-center justify-between p-3 bg-white rounded border">
                                <div>
                                    <p class="font-medium text-gray-800">Marketing Communications</p>
                                    <p class="text-sm text-gray-600">Receive promotional materials and offers</p>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" name="notify_marketing" class="sr-only peer">
                                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                                </label>
                            </div>
                        </div>
                        
                        <div class="mt-6">
                            <button type="submit" name="update_notifications" class="px-4 py-2 rounded bg-blue-600 text-white font-semibold hover:bg-blue-700 transition"><i class="fa fa-check"></i> Save Preferences</button>
                        </div>
                    </form>
                </div>
                
                <!-- Logout Tab -->
                <div id="tab-logout" class="settings-tab hidden">
                    <h2 class="text-2xl font-bold text-blue-700 mb-6 flex items-center gap-2"><i class="fa-solid fa-right-from-bracket"></i> Logout</h2>
                    <div class="bg-blue-50 p-6 rounded-xl shadow flex flex-col items-center gap-4 max-w-md mx-auto">
                        <div class="text-center mb-4">
                            <i class="fa-solid fa-right-from-bracket text-red-500 text-5xl mb-4"></i>
                            <h3 class="text-lg font-semibold">Ready to sign out?</h3>
                            <p class="text-gray-600 mt-2">You will be securely logged out of the system</p>
                        </div>
                        <form method="post" class="w-full">
                            <button type="submit" name="logout" class="w-full px-6 py-3 rounded-lg bg-red-600 text-white font-bold shadow hover:bg-red-700 transition flex items-center justify-center gap-2"><i class="fa-solid fa-right-from-bracket"></i> Logout from System</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        function showTab(tab) {
            // Hide all tabs
            document.querySelectorAll('.settings-tab').forEach(e => e.classList.add('hidden'));
            // Show the selected tab
            document.getElementById('tab-' + tab).classList.remove('hidden');
            // Reset all tab links
            document.querySelectorAll('.settings-tablink').forEach(e => e.classList.remove('bg-white', 'font-bold'));
            // Highlight the active tab link
            document.getElementById('tablink-' + tab).classList.add('bg-white', 'font-bold');
        }
        
        // Default tab
        document.addEventListener('DOMContentLoaded', function() {
            showTab('profile');
            
            // JavaScript to prevent non-numeric input in phone number fields
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
</section> 