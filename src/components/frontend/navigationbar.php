<?php
require_once __DIR__ . '/../../utils/url_helpers.php';
?>

<header class="bg-white">  
  <nav class="mx-auto flex max-w-7xl items-center justify-between p-4 border-b border-gray-200" aria-label="Global">
    <div class="flex lg:flex-1">
      <a href="<?php echo baseUrl(); ?>index.php" class="-m-1.5 p-1.5">
        <span class="sr-only">Your Company</span>
        <img class="h-8 w-auto" src="https://tailwindui.com/img/logos/mark.svg?color=amber&shade=500" alt="">
      </a>
    </div>
    <div class="flex items-center lg:hidden">
      <div class="flex lg:ml-6">
                <a href="#" class="p-2 text-gray-400 hover:text-gray-500">
                  <span class="sr-only">Search</span>
                  <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"></path>
                  </svg>
                </a>
              </div>
        <div class="mx-4 flow-root lg:ml-6">
                <a href="<?php echo baseUrl(); ?>src/views/cart.php" class="group -m-2 flex items-center p-2">
                  <svg class="h-6 w-6 flex-shrink-0 text-gray-400 group-hover:text-gray-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007zM8.625 10.5a.375.375 0 11-.75 0 .375.375 0 01.75 0zm7.5 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z"></path>
                 </svg>
                    <?php
                      // Calculate the cart count in PHP
                      $cartCount = 0;
                      if (!empty($_SESSION["shopping_cart"])) {
                          foreach ($_SESSION["shopping_cart"] as $item) {
                              $cartCount += $item['item_quantity'];
                          }
                      }
                    ?>
                  <span class="ml-2 text-sm font-medium text-gray-700 group-hover:text-gray-800"><?= $cartCount ?></span>
                  <span class="sr-only">items in cart, view bag</span>
                </a>
        </div>
      <button id="menu-open-button" type="button" class="-m-2.5 inline-flex items-center justify-center rounded-md p-2.5 text-gray-700">
        <span class="sr-only">Open main menu</span>
        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
          <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
        </svg>
      </button>
    </div>
    <div class="hidden lg:flex lg:gap-x-12">
      <a href="<?php echo baseUrl(); ?>src/views/frontend/products_category_women.php" class="text-sm font-semibold leading-6 text-gray-900 hover:bg-gray-50">Women</a>
      <a href="<?php echo baseUrl(); ?>src/views/frontend/products_category_men.php" class="text-sm font-semibold leading-6 text-gray-900 hover:bg-gray-50">Men</a>
      <a href="<?php echo baseUrl(); ?>src/views/frontend/products_category_kids.php" class="text-sm font-semibold leading-6 text-gray-900 hover:bg-gray-50">Kids</a>
      <a href="<?php echo baseUrl(); ?>src/views/frontend/news.php" class="text-sm font-semibold leading-6 text-gray-900 hover:bg-gray-50">News</a>
      <a href="<?php echo baseUrl(); ?>src/views/frontend/company.php" class="text-sm font-semibold leading-6 text-gray-900 hover:bg-gray-50">Company</a>
    </div>
    <div class="hidden lg:flex lg:flex-1 lg:justify-end items-center">
        <div class="flex lg:ml-6">
                <a href="#" class="p-2 text-gray-400 hover:text-gray-500">
                  <span class="sr-only">Search</span>
                  <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"></path>
                  </svg>
                </a>
              </div>
              <div class="ml-4 flow-root lg:ml-6">
                <a href="<?php echo baseUrl(); ?>src/views/cart.php" class="group -m-2 flex items-center p-2">
                    <svg class="h-6 w-6 flex-shrink-0 text-gray-400 group-hover:text-gray-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007zM8.625 10.5a.375.375 0 11-.75 0 .375.375 0 01.75 0zm7.5 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z"></path>
                    </svg>
                    <?php
                      // Calculate the cart count in PHP
                      $cartCount = 0;
                      if (!empty($_SESSION["shopping_cart"])) {
                          foreach ($_SESSION["shopping_cart"] as $item) {
                              $cartCount += $item['item_quantity'];
                          }
                      }
                    ?>
                    <span class="ml-2 text-sm font-medium text-gray-700 group-hover:text-gray-800"><?= $cartCount ?></span>
                    <span class="sr-only">items in cart, view bag</span>
                </a>
            </div>
    </div>
  </nav>
  <!-- Mobile menu, show/hide based on menu open state. -->
  <div id="mobile-menu" class="hidden lg:hidden" role="dialog" aria-modal="true">
    <!-- Background backdrop, show/hide based on slide-over state. -->
    <div class="fixed inset-0 z-10"></div>
    <div class="fixed inset-y-0 right-0 z-10 w-full overflow-y-auto bg-white px-6 py-6 sm:max-w-sm sm:ring-1 sm:ring-gray-900/10">
      <div class="flex items-center justify-between">
        <a href="<?php echo baseUrl(); ?>index.php" class="-m-1.5 p-1.5">
          <span class="sr-only">Your Company</span>
          <img class="h-8 w-auto" src="https://tailwindui.com/img/logos/mark.svg?color=amber&shade=500" alt="">
        </a>
        <button id="menu-close-button" type="button" class="-m-2.5 rounded-md p-2.5 text-gray-700">
          <span class="sr-only">Close menu</span>
          <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
          </svg>
        </button>
      </div>
      <div class="mt-6 flow-root">
        <div class="-my-6 divide-y divide-gray-500/10">
          <div class="space-y-2 py-6">
            <a href="<?php echo baseUrl(); ?>src/views/frontend/products_category_women.php" class="-mx-3 block rounded-lg px-3 py-2 text-base font-semibold leading-7 text-gray-900 hover:bg-gray-50">Women</a>
            <a href="<?php echo baseUrl(); ?>src/views/frontend/products_category_men.php" class="-mx-3 block rounded-lg px-3 py-2 text-base font-semibold leading-7 text-gray-900 hover:bg-gray-50">Men</a>
            <a href="<?php echo baseUrl(); ?>src/views/frontend/products_category_kids.php" class="-mx-3 block rounded-lg px-3 py-2 text-base font-semibold leading-7 text-gray-900 hover:bg-gray-50">Kids</a>
            <a href="<?php echo baseUrl(); ?>src/views/frontend/news.php" class="-mx-3 block rounded-lg px-3 py-2 text-base font-semibold leading-7 text-gray-900 hover:bg-gray-50">News</a>
            <a href="<?php echo baseUrl(); ?>src/views/frontend/company.php" class="-mx-3 block rounded-lg px-3 py-2 text-base font-semibold leading-7 text-gray-900 hover:bg-gray-50">Company</a>
          </div>
          <div class="py-6">
            <a href="<?php echo baseUrl(); ?>src/views/admin/admin_login.php" class="-mx-3 block rounded-lg px-3 py-2.5 text-base font-semibold leading-7 text-gray-900 hover:bg-gray-50">Log in</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</header>

<script>

 document.addEventListener('DOMContentLoaded', function() {
    const menuOpenButton = document.getElementById('menu-open-button');
    const menuCloseButton = document.getElementById('menu-close-button');
    const mobileMenu = document.getElementById('mobile-menu');

    menuOpenButton.addEventListener('click', function() {
        mobileMenu.classList.remove('hidden');
    });

    menuCloseButton.addEventListener('click', function() {
        mobileMenu.classList.add('hidden');
    });
});
</script>