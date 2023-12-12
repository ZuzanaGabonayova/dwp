<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Interactive Filters</title>
    <link rel="stylesheet" href="../../../assets/css/output.css">
    <style>
        /* Additional styles if needed */
        .hidden { display: none; }
    </style>
</head>
<body>
<div class="bg-white">
    <!-- Mobile filter dialog -->
    <div class="relative z-40 lg:hidden" role="dialog" aria-modal="true" id="mobileFilters">
        <div class="fixed inset-0 bg-black bg-opacity-25"></div>

        <div class="fixed inset-0 z-40 flex">
            <div class="relative ml-auto flex h-full w-full max-w-xs flex-col overflow-y-auto bg-white py-4 pb-12 shadow-xl">
                <div class="flex items-center justify-between px-4">
                    <h2 class="text-lg font-medium text-gray-900">Filters</h2>
                    <button
                      type="button"
                      class="-mr-2 flex h-10 w-10 items-center justify-center rounded-md bg-white p-2 text-gray-400"
                      id="closeMobileFilters"
                    >
                      <span class="sr-only">Close menu</span>
                      <!-- SVG for close icon -->
                    </button>
                </div>

                <!-- Filters (Add your filter structure here) -->
            </div>
        </div>
    </div>

    <main class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <!-- Main content including filters for larger screens and product grid -->
    </main>
</div>

<script>
</script>
</body>
</html>
