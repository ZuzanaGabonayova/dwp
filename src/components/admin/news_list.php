<?php
require_once '../../config/db.php';
require_once '../../news/ReadNewsCrud.php';

$readNewsCrud = new ReadNewsCrud($conn);
$newsPosts = $readNewsCrud->readAllNewsPosts();
?>

<div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 ">
        <div class="mx-auto max-w-2xl lg:mx-0 lg:max-w-none">
            <div class="flex items-center justify-between">
                <h2 class="text-base font-semibold text-gray-900">News posts</h2>
                <a href="<?php echo baseUrl(); ?>src/views/admin/add_news_post.php" class="flex items-center gap-x-1 rounded-md bg-blue-500 hover:bg-blue-700 text-white px-3 py-2 text-sm font-semibold shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 -ml-1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m6-6H6" />
                    </svg>
                    Add news post
                </a>
            </div>
        </div>
        <div class="mt-8 flow-root">
            <div class="mx-4 -my-2 overflow-x-auto sm:mx-6 lg:-mx-8">
                <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                    <div class="overflow-hidden border border-gray-300 sm:rounded-lg">
                        <table class="min-w-full">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">Title</th>
                                    <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6">
                                        <span class="sr-only">Actions</span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-300">
                                <?php while($post = $newsPosts->fetch_assoc()): ?>
                                    <tr>
                                    <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">
                                        <?php echo htmlspecialchars($post['title']); ?>
                                    </td>
                                    <td class="relative whitespace-nowrap pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                                        <a href="<?php echo baseUrl(); ?>src/views/admin/edit_news_post.php?id=<?php echo $post['id']; ?>" class="bg-green-500 text-white py-1 px-3 rounded hover:bg-green-600">Edit</a>
                                        <a href="<?php echo baseUrl(); ?>src/actions/handle_delete_news_post.php?id=<?php echo $post['id']; ?>" class="bg-red-500 text-white py-1 px-3 rounded hover:bg-red-600" onclick="return confirm('Are you sure you want to delete this post?');">Delete</a>
                                    </td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>