 <?php
    require_once '../daily_special_offer/DailySpecialOfferCrud.php';
    require_once '../product/ReadProductCrud.php';

    $specialOfferCrud = new DailySpecialOfferCrud($conn);
    $currentOffer = $specialOfferCrud->getCurrentSpecialOffer();
    $productDetails = null;

    if ($currentOffer) {
        $productId = $currentOffer['ProductID'];
        $readProductCrud = new ReadProductCrud($conn);
        $productDetails = $readProductCrud->readProduct($productId);
    }
?>





    <?php if ($productDetails): ?>
        <section aria-labelledby="daily-special-offer-heading" class="bg-white">
            <div class="mx-auto grid max-w-2xl grid-cols-1 items-center gap-x-8 gap-y-16 px-4 py-24 sm:px-6 sm:py-32 lg:max-w-7xl lg:grid-cols-2 lg:px-8">
                <div class="max-w-xl">
                    <h2 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">Daily Special Offer</h2>
                    <h3 class="text-2xl font-bold tracking-tight text-gray-900 sm:text-3xl"><?= htmlspecialchars($productDetails['Model']) ?></h3>
                    <p class="mt-4 text-gray-500">The walnut wood card tray is precision milled to perfectly fit a stack of Focus cards. The powder coated steel divider separates active cards from new ones, or can be used to archive important task lists.</p>
                    <p class="mt-4 text-gray-500"> <?= htmlspecialchars($productDetails['Description']) ?></p>
                    <p class="mt-3"><strong>Price:</strong> <?= htmlspecialchars($productDetails['Price']) ?></p>
                    <div class="mt-6">
                            <a href="<?php echo baseUrl(); ?>src/views/single_product.php?ProductID=<?= $productDetails['ProductID'] ?>"  class="inline-block rounded-md border border-transparent bg-orange-500 px-8 py-3 font-medium text-white">
                                Read More
                            </a>
                        </div>
                </div>
                <div class="aspect-w-1 aspect-h-1">
                    <?php if (!empty($productDetails['ProductMainImage'])): ?>
                        <img class="h-full w-full object-cover object-center" src="<?= htmlspecialchars($productDetails['ProductMainImage']) ?>" alt="<?= isset($productDetails['Model']) ? htmlspecialchars($productDetails['Model']) : 'Product image' ?>">
                    <?php endif; ?>
                </div>
            </div>
            <?php else: ?>
                 <p>No special offer available at the moment.</p>
            <?php endif; ?>
        </section>
       
    

