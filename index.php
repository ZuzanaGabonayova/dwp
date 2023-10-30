<!doctype html>
<html>
<head>
  <!-- Include the Tailwind JS file -->
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
    <div class="mx-auto  px-6 pb-24 pt-20 sm:pb-32 lg:px-8 lg:py-24 flex flex-col md:flex-row">
    <form class="mx-auto" action="add_product.php" method="post" enctype="multipart/form-data">
        <div class="mx-auto max-w-xl lg:max-w-lg">
            <div class="mb-10">
                <h1 class="text-4xl font-bold text-neutral-800">Shoes Webshop Admin</h1>
                <h2 class="text-3xl">Add a Product</h2>
            </div>
            <div class="grid grid-cols-1 gap-x-8 gap-y-6">
                <div>
                    <label for="first-name" class="block text-sm font-semibold leading-6 text-gray-900">Product Name</label>
                    <div class="mt-2.5">
                        <input class="block w-full rounded-md border-0 px-3.5 py-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" type="text" name="name" required><br>
                    </div>
                </div>
                <div>
                    <label for="description" class="block text-sm font-semibold leading-6 text-gray-900">Description</label>
                    <div class="mt-2.5">
                        <textarea name="description" id="description" rows="4" class="block w-full rounded-md border-0 px-3.5 py-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"></textarea>
                    </div>
                </div>
                <div>
                    <label for="price" class="block text-sm font-semibold leading-6 text-gray-900">Price</label>
                    <div class="mt-2.5">
                        <input class="block w-full rounded-md border-0 px-3.5 py-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" type="number" name="price" required><br>
                    </div>
                </div>
                  <div>
                    <label for="image" class="block text-sm font-semibold leading-6 text-gray-900">Upload image</label>
                    <div class="mt-2.5">
                        <input class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50  focus:outline-none  p-1" aria-describedby="file_input_help" id="file_input" name="image" type="file" accept="image/*">
                        <p class="mt-1 text-sm text-gray-500 " id="file_input_help">SVG, PNG, JPG (MAX. 800x400px).</p>
                    </div>
                </div>
            <div class="mt-8 flex justify-end">
                <button type="submit" value="Add Product" class="rounded-md bg-[#FF8C42] px-3.5 py-2.5 text-center text-sm font-semibold text-white shadow-sm hover:bg-[#FF8C42]/80 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Upload product</button>
            </div>
            </div>
        </div>
    </form>
    <div class="mx-auto max-w-4xl">
        <h2 class="text-2xl">Product List</h2>
    <div class="w-full overflow-x-auto mt-4">
    <table class="min-w-full divide-y divide-gray-200">
        <thead>
            <tr>
                <th class="px-6 py-3 bg-gray-100 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                    ID
                </th>
                <th class="px-6 py-3 bg-gray-100 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                    Name
                </th>
                <th class="px-6 py-3 bg-gray-100 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                    Description
                </th>
                <th class="px-6 py-3 bg-gray-100 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                    Price
                </th>
                <th class="px-6 py-3 bg-gray-100 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                    Image
                </th>
                <th class="px-6 py-3 bg-gray-100 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                    Actions
                </th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            <?php
            require('./model/config.php');
            $sql = "SELECT * FROM products";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td class='px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900'>{$row['id']}</td>";
                    echo "<td class='px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900'>{$row['name']}</td>";
                    echo "<td class='px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900'>{$row['description']}</td>";
                    echo "<td class='px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900'>{$row['price']}</td>";
                    echo "<td class='px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900'><img src='{$row['image']}' width='100'></td>";
                    echo "<td class='px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900'><a href='edit_product.php?id={$row['id']}' class='text-indigo-600 hover:text-indigo-900'>Edit</a> | <a href='delete_product.php?id={$row['id']}' class='text-red-600 hover:text-red-900'>Delete</a></td>";
                    echo "</tr>";
                }
            }
            ?>
        </tbody>
    </table>
</div>

    </div>
    
    </div>
    
</body>
</html>


