<?php 
require_once '../../admin_authentication/loggedin.php';
// Call the function to update last activity time
updateLastActivityTime();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create News Post</title>
    <link rel="stylesheet" href="../../../assets/css/output.css">
</head>
<body>
    <div class="bg-white">
        <div class="px-6 py-6 lg:px-8">
            <div class="max-w-2xl mx-auto ring-1 ring-gray-900/10 p-4 rounded-md shadow-sm">
                <form action="../../actions/handle_create_news_post.php" method="post" enctype="multipart/form-data" class="space-y-4">
                    <h1 class="mb-6 text-xl font-semibold text-gray-500 uppercase">Create news post</h1>
                    <div class="sm:col-span-2">
                        <label for="title" class="block mb-2 text-sm font-medium text-gray-900">Title:</label>
                        <input type="text" id="title" name="title" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5">
                    </div>
                     <div class="sm:col-span-2">
                        <label for="short_description" class="block mb-2 text-sm font-medium text-gray-900">Short Description:</label>
                        <input type="text" id="short_description" name="short_description" class="g-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5">
                    </div>
                    <div class="sm:col-span-2">
                        <label for="content" class="block mb-2 text-sm font-medium text-gray-900">Content</label>
                        <textarea id="content" rows="8" name="content" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-primary-500 focus:border-primary-500" required></textarea>
                    </div>
                    <div class="col-span-full">
                        <label for="image" class="block mb-2 text-sm font-medium text-gray-900">Main image</label>
                        <div class="mt-2 flex justify-center rounded-lg border border-dashed border-gray-900/25 px-6 py-10">
                            <div class="text-center">
                                <div class="mt-4 flex text-sm leading-6 text-gray-600">
                                    <label for="image" class="relative cursor-pointer rounded-md bg-white font-semibold text-indigo-600 focus-within:outline-none focus-within:ring-2 focus-within:ring-indigo-600 focus-within:ring-offset-2 hover:text-indigo-500">
                                        <span>Upload a file</span>
                                        <input id="image" name="image" type="file" class="sr-only">
                                    </label>
                                    <p class="pl-1">or drag and drop</p>
                                </div>
                                <p class="text-xs leading-5 text-gray-600">PNG, JPG, GIF, WEBP up to 10MB</p>
                            </div>
                        </div>
                    </div>
                    <label for="image_alt">Image Alt Text:</label>
                    <input type="text" id="image_alt" name="image_alt">

                    <button type="submit">Create News Post</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
