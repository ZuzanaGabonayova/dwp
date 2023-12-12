<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Interactive Filters</title>
    <link rel="stylesheet" href="path-to-your-tailwindcss.css">
    <link rel="stylesheet" href="../../../assets/css/output.css">
</head>
<body>
<div class="bg-white">
    <!-- Mobile filter dialog -->
    <div class="relative z-40 lg:hidden" role="dialog" aria-modal="true">
        <div class="fixed inset-0 bg-black bg-opacity-25"></div>

        <div class="fixed inset-0 z-40 flex">
            <div class="relative ml-auto flex h-full w-full max-w-xs flex-col overflow-y-auto bg-white py-4 pb-12 shadow-xl">
                <div class="flex items-center justify-between px-4">
                    <h2 class="text-lg font-medium text-gray-900">Filters</h2>
                    <button type="button" class="-mr-2 flex h-10 w-10 items-center justify-center rounded-md bg-white p-2 text-gray-400">
                        <span class="sr-only">Close menu</span>
                        <!-- SVG for close icon -->
                    </button>
                </div>

                <!-- Filters -->
                <form class="mt-4 border-t border-gray-200">
                    <h3 class="sr-only">Categories</h3>
                    <ul role="list" class="px-2 py-3 font-medium text-gray-900">
                        <!-- Category items here -->
                    </ul>

                    <!-- Repeat similar structure for other filter sections like Color, Size, etc. -->
                </form>
            </div>
        </div>
    </div>

    <main class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <!-- Main content here -->
    </main>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Toggle filter sections
        document.querySelectorAll('button[aria-controls]').forEach(button => {
            button.addEventListener('click', function () {
                const sectionId = this.getAttribute('aria-controls');
                const section = document.getElementById(sectionId);
                const isExpanded = this.getAttribute('aria-expanded') === 'true';
                section.style.display = isExpanded ? 'none' : 'block';
                this.setAttribute('aria-expanded', !isExpanded);
            });
        });

        // Close menu functionality
        document.querySelectorAll('.close-menu').forEach(button => {
            button.addEventListener('click', function () {
                document.querySelector('div[role="dialog"]').style.display = 'none';
            });
        });

        // Optional: Clicking outside the off-canvas menu closes it
        document.getElementById('backdrop').addEventListener('click', function() {
            document.querySelector('div[role="dialog"]').style.display = 'none';
        });
    });
</script>
</body>
</html>
</body>
</html>
