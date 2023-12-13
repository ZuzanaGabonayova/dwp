<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
error_reporting(E_ALL);


//session_start(); // Initialize the session for counting the cart items

require_once __DIR__ . '../../../config/db.php'; 
require_once __DIR__ . '../../../news/ReadNewsCrud.php'; 
require_once __DIR__ . '../../../utils/url_helpers.php'; 

// Get the list of news posts
$readNewsCrud = new ReadNewsCrud($conn);
$newsPosts = $readNewsCrud->readAllNewsPosts();

?>


<section id="news-section" class="bg-white py-24 sm:py-32">
  <div class="mx-auto max-w-7xl px-6 lg:px-8">
    <div class="mx-auto max-w-2xl text-center">
      <h2 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">From the blog</h2>
      <p class="mt-2 text-lg leading-8 text-gray-600">Learn about the newest trends in the world of sneakers.</p>
    </div>
    <div class="mx-auto mt-16 grid max-w-2xl grid-cols-1 gap-x-8 gap-y-20 lg:mx-0 lg:max-w-none lg:grid-cols-3">
      <?php if ($newsPosts && $newsPosts->num_rows > 0): ?>
            <?php while ($newsPost = $newsPosts->fetch_assoc()): ?>      
      <article class="flex flex-col items-start justify-between">
        <div class="relative w-full">
          <img src="../<?php echo htmlspecialchars($newsPost['image']); ?>" alt="<?php echo htmlspecialchars($newsPost['image_alt']); ?>" class="aspect-[16/9] w-full rounded-2xl bg-gray-100 object-cover sm:aspect-[2/1] lg:aspect-[3/2]">
          <div class="absolute inset-0 rounded-2xl ring-1 ring-inset ring-gray-900/10"></div>
        </div>
        <div class="max-w-xl">
          <div class="mt-8 flex items-center gap-x-4 text-xs">
            <time datetime="<?php echo date('M d Y', strtotime($newsPost['created_at'])); ?>" class="text-gray-500"><?php echo date('M d, Y', strtotime($newsPost['created_at'])); ?></time>
          </div>
          <div class="group relative">
            <h3 class="mt-3 text-lg font-semibold leading-6 text-gray-900 group-hover:text-gray-600">
              <a href="single_news.php?id=<?php echo $newsPost['id']; ?>">
                <span class="absolute inset-0"></span>
                <?php echo htmlspecialchars($newsPost['title']); ?>
              </a>
            </h3>
            <p class="mt-5 line-clamp-3 text-sm leading-6 text-gray-600"><?php echo htmlspecialchars($newsPost['short_description']); ?></p>
          </div>
        </div>
      </article>
      <?php endwhile; ?>
        <?php else: ?>
            <p class="text-center">No news posts found.</p>
        <?php endif; ?>
    </div>
  </div>
</section>
