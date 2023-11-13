<?php
require 'db.php'; // Make sure this path is correct
require 'crud_operations.php'; // This should contain a function to read news posts

// Get the list of news posts
$newsPosts = readNewsPosts();
?>
<?php
include 'navbar.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>News</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

<div class="container mx-auto p-6">
    <div class="flex justify-between items-center pb-6">
        <div>
            <h2 class="text-4xl font-semibold">Latest News</h2>
        </div>
    </div>

    <!-- News Grid -->
    <div class="grid md:grid-cols-3 gap-6">
        <?php if ($newsPosts && $newsPosts->num_rows > 0): ?>
            <?php while ($newsPost = $newsPosts->fetch_assoc()): ?>
                <div class="max-w-sm rounded overflow-hidden shadow-lg bg-white">
                    <img class="w-full" src="<?php echo htmlspecialchars($newsPost['image']); ?>" alt="<?php echo htmlspecialchars($newsPost['image_alt']); ?>">
                    <div class="px-6 py-4">
                        <div class="font-bold text-xl mb-2"><?php echo htmlspecialchars($newsPost['title']); ?></div>
                        <p class="text-gray-700 text-base">
                            <?php echo htmlspecialchars($newsPost['short_description']); ?>
                        </p>
                    </div>
                    <div class="px-6 py-4">
                        <?php echo nl2br(htmlspecialchars($newsPost['content'])); ?>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p class="text-center">No news posts found.</p>
        <?php endif; ?>
    </div>
</div>


<div class="bg-white py-24 sm:py-32">
  <div class="mx-auto max-w-7xl px-6 lg:px-8">
    <div class="mx-auto max-w-2xl text-center">
      <h2 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">From the blog</h2>
      <p class="mt-2 text-lg leading-8 text-gray-600">Learn how to grow your business with our expert advice.</p>
    </div>
    <div class="mx-auto mt-16 grid max-w-2xl grid-cols-1 gap-x-8 gap-y-20 lg:mx-0 lg:max-w-none lg:grid-cols-3">
      <?php if ($newsPosts && $newsPosts->num_rows > 0): ?>
            <?php while ($newsPost = $newsPosts->fetch_assoc()): ?>      
      <article class="flex flex-col items-start justify-between">
        <div class="relative w-full">
          <img src="<?php echo htmlspecialchars($newsPost['image']); ?>" alt="<?php echo htmlspecialchars($newsPost['image_alt']); ?>" class="aspect-[16/9] w-full rounded-2xl bg-gray-100 object-cover sm:aspect-[2/1] lg:aspect-[3/2]">
          <div class="absolute inset-0 rounded-2xl ring-1 ring-inset ring-gray-900/10"></div>
        </div>
        <div class="max-w-xl">
          <div class="mt-8 flex items-center gap-x-4 text-xs">
            <time datetime="2020-03-16" class="text-gray-500">Mar 16, 2020</time>
            <a href="#" class="relative z-10 rounded-full bg-gray-50 px-3 py-1.5 font-medium text-gray-600 hover:bg-gray-100">Marketing</a>
          </div>
          <div class="group relative">
            <h3 class="mt-3 text-lg font-semibold leading-6 text-gray-900 group-hover:text-gray-600">
              <a href="#">
                <span class="absolute inset-0"></span>
                <?php echo htmlspecialchars($newsPost['title']); ?>
              </a>
            </h3>
            <p class="mt-5 line-clamp-3 text-sm leading-6 text-gray-600"><?php echo htmlspecialchars($newsPost['short_description']); ?></p>
          </div>
          <div class="relative mt-8 flex items-center gap-x-4">
            <img src="https://images.unsplash.com/photo-1519244703995-f4e0f30006d5?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="" class="h-10 w-10 rounded-full bg-gray-100">
            <div class="text-sm leading-6">
              <p class="font-semibold text-gray-900">
                <a href="#">
                  <span class="absolute inset-0"></span>
                  Laszlo
                </a>
              </p>
              <p class="text-gray-600">Co-Founder / CTO</p>
            </div>
          </div>
        </div>
      </article>
      <?php endwhile; ?>
        <?php else: ?>
            <p class="text-center">No news posts found.</p>
        <?php endif; ?>
    </div>
  </div>
</div>

</body>
</html>
