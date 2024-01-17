<?php
require_once '../../config/db.php';
require_once '../../product/ReadProductCrud.php';
require_once '../../utils/url_helpers.php';

$readProductCrud = new ReadProductCrud($conn);
$womenProducts = $readProductCrud->readProductsByCategory('women');

// Populate color and brand dropdowns
$colors = $readProductCrud->getColors(); // Assuming this method exists
$brands = $readProductCrud->getBrands(); // Assuming this method exists

// Handle filtering
if (isset($_GET['color']) && isset($_GET['brand'])) {
    $color = $_GET['color'];
    $brand = $_GET['brand'];
    $products = $readProductCrud->readProductsByColorAndBrand($color, $brand, 'women');
} else {
    $products = $readProductCrud->readProductsByCategory('women');
}
    
?>

    <main class="mx-auto max-w-2xl px-4 lg:max-w-7xl lg:px-8">
        <div class="border-b border-gray-200 pb-10 pt-24">
            <h1 class="text-4xl font-bold tracking-tight text-gray-900">Women Category</h1>
            <p class="mt-4 text-base text-gray-500">Explore our wide range of women's products. From classic designs to the latest trends, we have it all.</p>
        </div>

        <form action="products_category_women.php" method="get">
            <label for="color">Color:</label>
            <select name="color" id="color">
                <?php foreach ($colors as $color) : ?>
                    <option value="<?php echo htmlspecialchars($color); ?>"><?php echo htmlspecialchars($color); ?></option>
                <?php endforeach; ?>
            </select>

            <label for="brand">Brand:</label>
            <select name="brand" id="brand">
                <?php foreach ($brands as $brand) : ?>
                    <option value="<?php echo htmlspecialchars($brand); ?>"><?php echo htmlspecialchars($brand); ?></option>
                <?php endforeach; ?>
            </select>

            <input type="submit" value="Filter">
        </form>

        <div class="mt-6 grid grid-cols-1 gap-x-6 gap-y-10 sm:grid-cols-2 lg:grid-cols-4 xl:gap-x-8">
            <?php if ($womenProducts) : ?>
                <?php while ($product = $womenProducts->fetch_assoc()) : ?>
                    <div class="group relative">
                        <div class="aspect-h-1 aspect-w-1 w-full overflow-hidden rounded-md bg-gray-200 lg:aspect-none group-hover:opacity-75 lg:h-80">
                            <img src="../<?= htmlspecialchars($product['ProductMainImage']) ?>" alt="<?= htmlspecialchars($product['Model']) ?>" class="h-full w-full object-cover object-center lg:h-full lg:w-full">
                        </div>
                        <div class="mt-4 flex justify-between">
                            <div>
                                <h3 class="text-sm text-gray-700">
                                    <a href="<?php echo baseUrl(); ?>src/views/frontend/single_product.php?ProductID=<?php echo $product['ProductID']; ?>">
                                        <span aria-hidden="true" class="absolute inset-0"></span>
                                        <?= htmlspecialchars($product['Model']) ?>
                                    </a>
                                </h3>
                            </div>
                            <p class="text-sm font-medium text-gray-900"><?= htmlspecialchars(number_format($product['Price'], 2)) ?></p>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else : ?>
                <p>No women's products found.</p>
            <?php endif; ?>
        </div>
    </main>
