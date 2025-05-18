<section class="p-8">
    <div class="bg-gradient-to-tr from-blue-600 to-blue-400 rounded-2xl shadow-xl p-8 mb-8">
        <h2 class="text-3xl font-extrabold text-white mb-2 flex items-center gap-2"><i class="fa-solid fa-chart-line"></i> Reports Overview</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="bg-white/90 rounded-xl p-6 flex flex-col items-center shadow relative group">
                <i class="fa fa-users text-3xl text-blue-600 mb-2"></i>
                <span class="text-lg text-gray-700">Total Users</span>
                <span class="text-2xl font-bold text-blue-700"><?php echo $total_users; ?></span>
                <div class="absolute left-1/2 -translate-x-1/2 top-full mt-2 z-30 hidden group-hover:block bg-white/95 border border-blue-200 rounded-2xl shadow-2xl p-5 min-w-[220px] text-sm text-gray-700 transition-all backdrop-blur-lg">
                    <div class="font-bold text-blue-700 mb-3 flex items-center gap-2 text-base"><i class='fa fa-list'></i> Top Users</div>
                    <?php if ($top_users && $top_users->num_rows > 0): ?>
                        <div class="grid grid-cols-1 gap-2">
                            <?php while($user = $top_users->fetch_assoc()): ?>
                                <div class="flex items-center gap-3 px-3 py-2 rounded-xl bg-gradient-to-r from-blue-100 to-blue-50 shadow-sm border border-blue-200 hover:scale-105 transition">
                                    <span class="w-7 h-7 flex items-center justify-center rounded-full bg-blue-400 text-white shadow"><i class="fa fa-user"></i></span>
                                    <span class="font-semibold text-blue-800 flex-1"><?php echo htmlspecialchars($user['full_name']); ?></span>
                                    <span class="font-bold text-blue-600 text-sm bg-blue-100 px-2 py-1 rounded-lg">x<?php echo $user['count']; ?></span>
                                </div>
                            <?php endwhile; ?>
                        </div>
                    <?php else: ?>
                        <div class="italic text-gray-400">No users found</div>
                    <?php endif; ?>
                </div>
            </div>
            <div class="bg-white/90 rounded-xl p-6 flex flex-col items-center shadow relative group">
                <i class="fa fa-car text-3xl text-green-600 mb-2"></i>
                <span class="text-lg text-gray-700">Total Cars</span>
                <span class="text-2xl font-bold text-green-700"><?php echo $total_cars; ?></span>
                <div class="absolute left-1/2 -translate-x-1/2 top-full mt-2 z-30 hidden group-hover:block bg-white/95 border border-blue-200 rounded-2xl shadow-2xl p-5 min-w-[220px] text-sm text-gray-700 transition-all backdrop-blur-lg">
                    <div class="font-bold text-blue-700 mb-3 flex items-center gap-2 text-base"><i class='fa fa-list'></i> Car Categories</div>
                    <?php if ($car_makes && $car_makes->num_rows > 0): ?>
                        <div class="grid grid-cols-1 gap-2">
                            <?php while($make = $car_makes->fetch_assoc()): ?>
                                <div class="flex items-center gap-3 px-3 py-2 rounded-xl bg-gradient-to-r from-blue-100 to-blue-50 shadow-sm border border-blue-200 hover:scale-105 transition">
                                    <span class="w-7 h-7 flex items-center justify-center rounded-full bg-blue-400 text-white shadow"><i class="fa fa-car"></i></span>
                                    <span class="font-semibold text-blue-800 flex-1"><?php echo htmlspecialchars($make['make']); ?></span>
                                    <span class="font-bold text-blue-600 text-sm bg-blue-100 px-2 py-1 rounded-lg">x<?php echo $make['count']; ?></span>
                                </div>
                            <?php endwhile; ?>
                        </div>
                    <?php else: ?>
                        <div class="italic text-gray-400">No categories found</div>
                    <?php endif; ?>
                </div>
            </div>
            <div class="bg-white/90 rounded-xl p-6 flex flex-col items-center shadow relative group">
                <i class="fa fa-calendar-check text-3xl text-purple-600 mb-2"></i>
                <span class="text-lg text-gray-700">Total Bookings</span>
                <span class="text-2xl font-bold text-purple-700"><?php echo $total_bookings; ?></span>
                <div class="absolute left-1/2 -translate-x-1/2 top-full mt-2 z-30 hidden group-hover:block bg-white/95 border border-purple-200 rounded-2xl shadow-2xl p-5 min-w-[220px] text-sm text-gray-700 transition-all backdrop-blur-lg">
                    <div class="font-bold text-purple-700 mb-3 flex items-center gap-2 text-base"><i class='fa fa-list'></i> Top Booked Cars</div>
                    <?php if ($total_bookings_breakdown && $total_bookings_breakdown->num_rows > 0): ?>
                        <div class="grid grid-cols-1 gap-2">
                            <?php while($item = $total_bookings_breakdown->fetch_assoc()): ?>
                                <div class="flex items-center gap-3 px-3 py-2 rounded-xl bg-gradient-to-r from-purple-100 to-purple-50 shadow-sm border border-purple-200 hover:scale-105 transition">
                                    <span class="w-7 h-7 flex items-center justify-center rounded-full bg-purple-400 text-white shadow"><i class="fa fa-car"></i></span>
                                    <span class="font-semibold text-purple-800 flex-1"><?php echo htmlspecialchars($item['car_name']); ?></span>
                                    <span class="font-bold text-purple-600 text-sm bg-purple-100 px-2 py-1 rounded-lg">x<?php echo $item['count']; ?></span>
                                </div>
                            <?php endwhile; ?>
                        </div>
                    <?php else: ?>
                        <div class="italic text-gray-400">No data found</div>
                    <?php endif; ?>
                </div>
            </div>
            <div class="bg-white/90 rounded-xl p-6 flex flex-col items-center shadow relative group">
                <i class="fa fa-bolt text-3xl text-yellow-500 mb-2"></i>
                <span class="text-lg text-gray-700">Active Bookings</span>
                <span class="text-2xl font-bold text-yellow-600"><?php echo $active_bookings; ?></span>
                <div class="absolute left-1/2 -translate-x-1/2 top-full mt-2 z-30 hidden group-hover:block bg-white/95 border border-yellow-200 rounded-2xl shadow-2xl p-5 min-w-[220px] text-sm text-gray-700 transition-all backdrop-blur-lg">
                    <div class="font-bold text-yellow-700 mb-3 flex items-center gap-2 text-base"><i class='fa fa-list'></i> Active Bookings by Car</div>
                    <?php if ($active_bookings_breakdown && $active_bookings_breakdown->num_rows > 0): ?>
                        <div class="grid grid-cols-1 gap-2">
                            <?php while($item = $active_bookings_breakdown->fetch_assoc()): ?>
                                <div class="flex items-center gap-3 px-3 py-2 rounded-xl bg-gradient-to-r from-yellow-100 to-yellow-50 shadow-sm border border-yellow-200 hover:scale-105 transition">
                                    <span class="w-7 h-7 flex items-center justify-center rounded-full bg-yellow-400 text-white shadow"><i class="fa fa-car"></i></span>
                                    <span class="font-semibold text-yellow-800 flex-1"><?php echo htmlspecialchars($item['car_name']); ?></span>
                                    <span class="font-bold text-yellow-600 text-sm bg-yellow-100 px-2 py-1 rounded-lg">x<?php echo $item['count']; ?></span>
                                </div>
                            <?php endwhile; ?>
                        </div>
                    <?php else: ?>
                        <div class="italic text-gray-400">No data found</div>
                    <?php endif; ?>
                </div>
            </div>
            <div class="bg-white/90 rounded-xl p-6 flex flex-col items-center shadow">
                <i class="fa fa-clock text-3xl text-orange-500 mb-2"></i>
                <span class="text-lg text-gray-700">Pending Bookings</span>
                <span class="text-2xl font-bold text-orange-600"><?php echo $pending_bookings; ?></span>
                <div class="absolute left-1/2 -translate-x-1/2 top-full mt-2 z-30 hidden group-hover:block bg-white/95 border border-orange-200 rounded-2xl shadow-2xl p-5 min-w-[220px] text-sm text-gray-700 transition-all backdrop-blur-lg">
                    <div class="font-bold text-orange-700 mb-3 flex items-center gap-2 text-base"><i class='fa fa-list'></i> Pending Bookings by Car</div>
                    <?php if ($pending_bookings_breakdown && $pending_bookings_breakdown->num_rows > 0): ?>
                        <div class="grid grid-cols-1 gap-2">
                            <?php while($item = $pending_bookings_breakdown->fetch_assoc()): ?>
                                <div class="flex items-center gap-3 px-3 py-2 rounded-xl bg-gradient-to-r from-orange-100 to-orange-50 shadow-sm border border-orange-200 hover:scale-105 transition">
                                    <span class="w-7 h-7 flex items-center justify-center rounded-full bg-orange-400 text-white shadow"><i class="fa fa-car"></i></span>
                                    <span class="font-semibold text-orange-800 flex-1"><?php echo htmlspecialchars($item['car_name']); ?></span>
                                    <span class="font-bold text-orange-600 text-sm bg-orange-100 px-2 py-1 rounded-lg">x<?php echo $item['count']; ?></span>
                                </div>
                            <?php endwhile; ?>
                        </div>
                    <?php else: ?>
                        <div class="italic text-gray-400">No data found</div>
                    <?php endif; ?>
                </div>
            </div>
            <div class="bg-white/90 rounded-xl p-6 flex flex-col items-center shadow">
                <i class="fa fa-ban text-3xl text-red-500 mb-2"></i>
                <span class="text-lg text-gray-700">Canceled Bookings</span>
                <span class="text-2xl font-bold text-red-600"><?php echo $canceled_bookings; ?></span>
                <div class="absolute left-1/2 -translate-x-1/2 top-full mt-2 z-30 hidden group-hover:block bg-white/95 border border-red-200 rounded-2xl shadow-2xl p-5 min-w-[220px] text-sm text-gray-700 transition-all backdrop-blur-lg">
                    <div class="font-bold text-red-700 mb-3 flex items-center gap-2 text-base"><i class='fa fa-list'></i> Canceled Bookings by Car</div>
                    <?php if ($canceled_bookings_breakdown && $canceled_bookings_breakdown->num_rows > 0): ?>
                        <div class="grid grid-cols-1 gap-2">
                            <?php while($item = $canceled_bookings_breakdown->fetch_assoc()): ?>
                                <div class="flex items-center gap-3 px-3 py-2 rounded-xl bg-gradient-to-r from-red-100 to-red-50 shadow-sm border border-red-200 hover:scale-105 transition">
                                    <span class="w-7 h-7 flex items-center justify-center rounded-full bg-red-400 text-white shadow"><i class="fa fa-car"></i></span>
                                    <span class="font-semibold text-red-800 flex-1"><?php echo htmlspecialchars($item['car_name']); ?></span>
                                    <span class="font-bold text-red-600 text-sm bg-red-100 px-2 py-1 rounded-lg">x<?php echo $item['count']; ?></span>
                                </div>
                            <?php endwhile; ?>
                        </div>
                    <?php else: ?>
                        <div class="italic text-gray-400">No data found</div>
                    <?php endif; ?>
                </div>
            </div>
            <div class="bg-white/90 rounded-xl p-6 flex flex-col items-center shadow">
                <i class="fa fa-dollar-sign text-3xl text-green-500 mb-2"></i>
                <span class="text-lg text-gray-700">Total Income</span>
                <span class="text-2xl font-bold text-green-700">$
                    <?php echo number_format($total_income, 2); ?>
                </span>
            </div>
        </div>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <div class="bg-white rounded-2xl shadow-lg p-6">
            <h3 class="text-xl font-bold text-blue-700 mb-4 flex items-center gap-2"><i class="fa fa-star"></i> Top 3 Rented Cars</h3>
            <ol class="space-y-2">
                <?php if ($top_cars && $top_cars->num_rows > 0): $i=0; while($car = $top_cars->fetch_assoc()): $i++; ?>
                <li class="flex items-center gap-3"><span class="w-8 h-8 flex items-center justify-center rounded-full bg-blue-100 text-blue-700 font-bold"><?php echo $i; ?></span> <span class="font-semibold"><?php echo htmlspecialchars($car['car_name']); ?></span> <span class="ml-auto text-gray-500"><?php echo $car['count']; ?> times</span></li>
                <?php endwhile; else: ?>
                <li>No data</li>
                <?php endif; ?>
            </ol>
        </div>
        <div class="bg-white rounded-2xl shadow-lg p-6">
            <h3 class="text-xl font-bold text-blue-700 mb-4 flex items-center gap-2"><i class="fa fa-user"></i> Top 3 Customers</h3>
            <ol class="space-y-2">
                <?php if ($top_customers && $top_customers->num_rows > 0): $i=0; while($cust = $top_customers->fetch_assoc()): $i++; ?>
                <li class="flex items-center gap-3"><span class="w-8 h-8 flex items-center justify-center rounded-full bg-green-100 text-green-700 font-bold"><?php echo $i; ?></span> <span class="font-semibold"><?php echo htmlspecialchars($cust['full_name']); ?></span> <span class="ml-auto text-gray-500"><?php echo $cust['count']; ?> bookings</span></li>
                <?php endwhile; else: ?>
                <li>No data</li>
                <?php endif; ?>
            </ol>
        </div>
    </div>
</section> 