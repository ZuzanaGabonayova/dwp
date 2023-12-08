<?php
include_once '../components/sidebar.php';
?>

<div class="lg:pl-72">
<?php
include_once '../components/mobile_menu_backend.php';
?>
<main class="py-10">
  <div class="px-4 sm:px-6 lg:px-8">
    <div id="content-wrapper" class="relative overflow-hidden border border-dashed border-gray-400 opacity-75 content-area">
      <?php include $content; ?>
    </div>
  </div>
</main>
</div>

