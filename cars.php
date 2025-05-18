<?php include 'connection.php'; ?>
<section class="p-8">
    <div class="bg-white rounded-2xl shadow-lg p-6">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-bold text-blue-700 flex items-center gap-2"><i class="fa-solid fa-car"></i> Available Cars</h2>
            <a href="index.php?view=available_cars&add_car=1" class="px-4 py-2 rounded-lg bg-blue-600 text-white font-semibold shadow hover:bg-blue-700 transition flex items-center gap-2"><i class="fa fa-plus"></i> Add New Car</a>
        </div>
        <?php if (isset($_GET['add_car'])): ?>
        <form method="post" class="mb-8 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 bg-blue-50 p-6 rounded-xl shadow">
            <input type="text" name="car_name" placeholder="Car Name" required class="px-3 py-2 rounded border focus:ring-2 focus:ring-blue-400">
            <input type="text" name="model" placeholder="Model" required class="px-3 py-2 rounded border focus:ring-2 focus:ring-blue-400">
            <input type="number" name="year" placeholder="Year" required class="px-3 py-2 rounded border focus:ring-2 focus:ring-blue-400">
            <input type="text" name="color" placeholder="Color" required class="px-3 py-2 rounded border focus:ring-2 focus:ring-blue-400">
            <input type="text" name="license_plate" placeholder="License Plate" required class="px-3 py-2 rounded border focus:ring-2 focus:ring-blue-400">
            <input type="number" step="0.01" name="daily_rate" placeholder="Daily Rate" required class="px-3 py-2 rounded border focus:ring-2 focus:ring-blue-400">
            <select name="category" required class="px-3 py-2 rounded border focus:ring-2 focus:ring-blue-400">
                <option value="Raaxo">Raaxo</option>
                <option value="Family">Family</option>
            </select>
            <input type="text" name="image_url" placeholder="Image URL (optional)" class="px-3 py-2 rounded border focus:ring-2 focus:ring-blue-400">
            <input type="text" name="doors" placeholder="Doors (e.g. 4, Sliding, etc.)" class="px-3 py-2 rounded border focus:ring-2 focus:ring-blue-400">
            <input type="number" name="passenger_capacity" placeholder="Passenger Capacity" min="1" class="px-3 py-2 rounded border focus:ring-2 focus:ring-blue-400">
            <select name="status" required class="px-3 py-2 rounded border focus:ring-2 focus:ring-blue-400">
                <option value="available">Available</option>
                <option value="rented">Rented</option>
                <option value="maintenance">Maintenance</option>
            </select>
            <div class="col-span-full flex gap-3 mt-2">
                <button type="submit" name="add_car_submit" class="px-4 py-2 rounded bg-green-600 text-white font-semibold hover:bg-green-700 transition"><i class="fa fa-check"></i> Save</button>
                <a href="index.php?view=available_cars" class="px-4 py-2 rounded bg-gray-300 text-gray-700 font-semibold hover:bg-gray-400 transition"><i class="fa fa-times"></i> Cancel</a>
            </div>
        </form>
        <?php elseif (isset($_GET['edit_car'])): ?>
        <?php 
        $car_id = intval($_GET['edit_car']);
        $car_query = $conn->query("SELECT * FROM cars WHERE car_id = $car_id");
        if ($car_query && $car_query->num_rows > 0):
            $car = $car_query->fetch_assoc();
        ?>
        <div class="mb-6">
            <a href="index.php?view=available_cars" class="px-4 py-2 rounded-lg bg-gray-200 text-gray-700 font-semibold shadow hover:bg-gray-300 transition flex items-center gap-2 w-fit"><i class="fa fa-arrow-left"></i> Back to Cars</a>
        </div>
        <form method="post" class="mb-8 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 bg-blue-50 p-6 rounded-xl shadow">
            <div class="col-span-full mb-4">
                <h3 class="text-xl font-bold text-blue-700 flex items-center gap-2"><i class="fa-solid fa-edit"></i> Edit Car: <?php echo htmlspecialchars($car['car_name']); ?></h3>
            </div>
            
            <div class="flex flex-col">
                <label class="mb-1 text-sm text-gray-600">Car Name</label>
                <input type="text" name="car_name" value="<?php echo htmlspecialchars($car['car_name']); ?>" required class="px-3 py-2 rounded border focus:ring-2 focus:ring-blue-400">
            </div>
            
            <div class="flex flex-col">
                <label class="mb-1 text-sm text-gray-600">Model</label>
                <input type="text" name="model" value="<?php echo htmlspecialchars($car['model']); ?>" required class="px-3 py-2 rounded border focus:ring-2 focus:ring-blue-400">
            </div>
            
            <div class="flex flex-col">
                <label class="mb-1 text-sm text-gray-600">Year</label>
                <input type="number" name="year" value="<?php echo htmlspecialchars($car['year']); ?>" required class="px-3 py-2 rounded border focus:ring-2 focus:ring-blue-400">
            </div>
            
            <div class="flex flex-col">
                <label class="mb-1 text-sm text-gray-600">Color</label>
                <input type="text" name="color" value="<?php echo htmlspecialchars($car['color']); ?>" required class="px-3 py-2 rounded border focus:ring-2 focus:ring-blue-400">
            </div>
            
            <div class="flex flex-col">
                <label class="mb-1 text-sm text-gray-600">License Plate</label>
                <input type="text" name="license_plate" value="<?php echo htmlspecialchars($car['license_plate']); ?>" required class="px-3 py-2 rounded border focus:ring-2 focus:ring-blue-400">
            </div>
            
            <div class="flex flex-col">
                <label class="mb-1 text-sm text-gray-600">Daily Rate</label>
                <input type="number" step="0.01" name="daily_rate" value="<?php echo htmlspecialchars($car['daily_rate']); ?>" required class="px-3 py-2 rounded border focus:ring-2 focus:ring-blue-400">
            </div>
            
            <div class="flex flex-col">
                <label class="mb-1 text-sm text-gray-600">Category</label>
                <select name="category" required class="px-3 py-2 rounded border focus:ring-2 focus:ring-blue-400">
                    <option value="Raaxo" <?php if($car['category']==='Raaxo') echo 'selected'; ?>>Raaxo</option>
                    <option value="Family" <?php if($car['category']==='Family') echo 'selected'; ?>>Family</option>
                </select>
            </div>
            
            <div class="flex flex-col">
                <label class="mb-1 text-sm text-gray-600">Image URL</label>
                <input type="text" name="image_url" value="<?php echo htmlspecialchars($car['image_url']); ?>" class="px-3 py-2 rounded border focus:ring-2 focus:ring-blue-400">
            </div>
            
            <div class="flex flex-col">
                <label class="mb-1 text-sm text-gray-600">Doors</label>
                <input type="text" name="doors" value="<?php echo htmlspecialchars($car['doors']); ?>" class="px-3 py-2 rounded border focus:ring-2 focus:ring-blue-400">
            </div>
            
            <div class="flex flex-col">
                <label class="mb-1 text-sm text-gray-600">Passenger Capacity</label>
                <input type="number" name="passenger_capacity" value="<?php echo htmlspecialchars($car['passenger_capacity']); ?>" min="1" class="px-3 py-2 rounded border focus:ring-2 focus:ring-blue-400">
            </div>
            
            <div class="flex flex-col">
                <label class="mb-1 text-sm text-gray-600">Status</label>
                <select name="status" required class="px-3 py-2 rounded border focus:ring-2 focus:ring-blue-400">
                    <option value="available" <?php if($car['status']==='available') echo 'selected'; ?>>Available</option>
                    <option value="rented" <?php if($car['status']==='rented') echo 'selected'; ?>>Rented</option>
                    <option value="maintenance" <?php if($car['status']==='maintenance') echo 'selected'; ?>>Maintenance</option>
                </select>
            </div>
            
            <?php if (!empty($car['image_url'])): ?>
            <div class="col-span-full bg-white p-4 rounded-lg">
                <label class="mb-1 text-sm text-gray-600">Current Image</label>
                <img src="<?php echo htmlspecialchars($car['image_url']); ?>" alt="Car Image" class="h-32 object-contain rounded shadow mt-1">
            </div>
            <?php endif; ?>
            
            <div class="col-span-full flex gap-3 mt-6">
                <input type="hidden" name="edit_car_id" value="<?php echo $car['car_id']; ?>">
                <button type="submit" name="edit_car_submit" class="px-4 py-2 rounded bg-green-600 text-white font-semibold hover:bg-green-700 transition"><i class="fa fa-check"></i> Save Changes</button>
                <a href="index.php?view=available_cars" class="px-4 py-2 rounded bg-gray-300 text-gray-700 font-semibold hover:bg-gray-400 transition"><i class="fa fa-times"></i> Cancel</a>
                <button type="submit" name="save_car_submit" class="px-4 py-2 rounded bg-blue-600 text-white font-semibold hover:bg-blue-700 transition"><i class="fa fa-save"></i> Save</button>
            </div>
        </form>
        <?php else: ?>
            <div class="p-6 bg-red-100 text-red-700 rounded-xl mb-6">
                <p>Car not found. <a href="index.php?view=available_cars" class="underline">Return to cars list</a></p>
            </div>
        <?php endif; ?>
        <?php else: ?>
        <div class="overflow-x-auto rounded-xl">
            <table class="min-w-full text-left border-separate border-spacing-y-2">
                <thead class="bg-blue-50">
                    <tr>
                        <th class="py-3 px-4 rounded-l-xl">Image</th>
                        <th class="py-3 px-4">Car Name</th>
                        <th class="py-3 px-4">Model</th>
                        <th class="py-3 px-4">Year</th>
                        <th class="py-3 px-4">Color</th>
                        <th class="py-3 px-4">License Plate</th>
                        <th class="py-3 px-4">Daily Rate</th>
                        <th class="py-3 px-4">Category</th>
                        <th class="py-3 px-4">Doors</th>
                        <th class="py-3 px-4">Passengers</th>
                        <th class="py-3 px-4">Status</th>
                        <th class="py-3 px-4">Action</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                $cars = $conn->query("SELECT car_id, car_name, model, year, color, license_plate, daily_rate, status, image_url, doors, passenger_capacity, category FROM cars WHERE status='available'");
                if ($cars && $cars->num_rows > 0):
                    while($car = $cars->fetch_assoc()): ?>
                        <tr class="bg-blue-100/50 hover:bg-blue-200 transition">
                            <td class="py-2 px-4">
                                <img src="<?php echo htmlspecialchars(!empty($car['image_url']) ? $car['image_url'] : 'default_car.png'); ?>" alt="Car Image" class="w-16 h-12 object-cover rounded shadow">
                            </td>
                            <td class="py-2 px-4 font-semibold text-blue-900"><?php echo htmlspecialchars($car['car_name']); ?></td>
                            <td class="py-2 px-4"><?php echo htmlspecialchars($car['model']); ?></td>
                            <td class="py-2 px-4"><?php echo htmlspecialchars($car['year']); ?></td>
                            <td class="py-2 px-4"><?php echo htmlspecialchars($car['color']); ?></td>
                            <td class="py-2 px-4"><?php echo htmlspecialchars($car['license_plate']); ?></td>
                            <td class="py-2 px-4">$
                                <?php echo htmlspecialchars($car['daily_rate']); ?>
                            </td>
                            <td class="py-2 px-4">
                                <?php echo htmlspecialchars($car['category']); ?>
                            </td>
                            <td class="py-2 px-4"><?php echo htmlspecialchars($car['doors']); ?></td>
                            <td class="py-2 px-4"><?php echo htmlspecialchars($car['passenger_capacity']); ?></td>
                            <td class="py-2 px-4"><span class="px-2 py-1 rounded bg-green-100 text-green-700"><?php echo htmlspecialchars($car['status']); ?></span></td>
                            <td class="py-2 px-4">
                                <div class="flex gap-2">
                                    <a href="index.php?view=available_cars&edit_car=<?php echo $car['car_id']; ?>" class="px-3 py-1 rounded bg-yellow-400 text-white font-semibold hover:bg-yellow-500 transition text-sm"><i class="fa fa-edit"></i> Edit</a>
                                    <form method="post" style="display:inline" onsubmit="return confirm('Are you sure you want to delete this car?');">
                                        <input type="hidden" name="delete_car_id" value="<?php echo $car['car_id']; ?>">
                                        <button type="submit" class="px-3 py-1 rounded bg-red-600 text-white font-semibold hover:bg-red-700 transition text-sm"><i class="fa fa-trash"></i> Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endwhile;
                else: ?>
                    <tr><td colspan="12" class="py-2 px-4 text-center">No available cars found</td></tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
        <?php endif; ?>
    </div>
</section> 