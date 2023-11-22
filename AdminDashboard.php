<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Admin</title>
    <link rel="stylesheet" href="output.css">
  </head>
  <body>
    <div>
      <div
        id="menu"
        class="hidden lg:flex lg:flex-col lg:w-72 lg:z-50 lg:inset-y-0 lg:fixed"
      >
        <div
          class="flex flex-col flex-grow gap-y-5 overflow-y-auto bg-gray-600 px-6 pb-4"
        >
          <div class="flex h-16 flex-shrink-0 items-center">
            <img
              class="h-8 w-auto"
              src="https://tailwindui.com/img/logos/mark.svg?color=white"
              alt="Your Company"
            />
          </div>
          <nav class="flex flex-1 flex-col">
            <ul role="list" class="flex flex-1 flex-col gap-y-5">
              <li>
                <ul role="list" class="-my-2 space-y-1">
                  <li>
                    <a
                      href="#"
                      class="flex gap-x-3 rounded-md bg-gray-600 p-2 text-sm font-semibold leading-6 text-white"
                    >
                      <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.5"
                        stroke="currentColor"
                        aria-hidden="true"
                        class="h-6 w-6 flex-shrink-0 text-white"
                      >
                        <path
                          stroke-linecap="round"
                          stroke-linejoin="round"
                          d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25"
                        ></path>
                      </svg>
                      Dashboard
                    </a>
                  </li>
                  <li>
                    <a
                      href="#"
                      class="flex gap-x-3 rounded-md bg-gray-600 p-2 text-sm font-semibold leading-6 text-white"
                    >
                      <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.5"
                        stroke="currentColor"
                        class="h-6 w-6 flex-shrink-0 text-white"
                      >
                        <path
                          stroke-linecap="round"
                          stroke-linejoin="round"
                          d="M13.5 21v-7.5a.75.75 0 01.75-.75h3a.75.75 0 01.75.75V21m-4.5 0H2.36m11.14 0H18m0 0h3.64m-1.39 0V9.349m-16.5 11.65V9.35m0 0a3.001 3.001 0 003.75-.615A2.993 2.993 0 009.75 9.75c.896 0 1.7-.393 2.25-1.016a2.993 2.993 0 002.25 1.016c.896 0 1.7-.393 2.25-1.016a3.001 3.001 0 003.75.614m-16.5 0a3.004 3.004 0 01-.621-4.72L4.318 3.44A1.5 1.5 0 015.378 3h13.243a1.5 1.5 0 011.06.44l1.19 1.189a3 3 0 01-.621 4.72m-13.5 8.65h3.75a.75.75 0 00.75-.75V13.5a.75.75 0 00-.75-.75H6.75a.75.75 0 00-.75.75v3.75c0 .415.336.75.75.75z"
                        />
                      </svg>

                      Products
                    </a>
                  </li>
                  <li>
                    <a
                      href="#"
                      class="flex gap-x-3 rounded-md bg-gray-600 p-2 text-sm font-semibold leading-6 text-white"
                    >
                      <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.5"
                        stroke="currentColor"
                        class="h-6 w-6 flex-shrink-0 text-white"
                      >
                        <path
                          stroke-linecap="round"
                          stroke-linejoin="round"
                          d="M12 7.5h1.5m-1.5 3h1.5m-7.5 3h7.5m-7.5 3h7.5m3-9h3.375c.621 0 1.125.504 1.125 1.125V18a2.25 2.25 0 01-2.25 2.25M16.5 7.5V18a2.25 2.25 0 002.25 2.25M16.5 7.5V4.875c0-.621-.504-1.125-1.125-1.125H4.125C3.504 3.75 3 4.254 3 4.875V18a2.25 2.25 0 002.25 2.25h13.5M6 7.5h3v3H6v-3z"
                        />
                      </svg>

                      News
                    </a>
                  </li>
                  <li>
                    <a
                      href="#"
                      class="flex gap-x-3 rounded-md bg-gray-600 p-2 text-sm font-semibold leading-6 text-white"
                    >
                      <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.5"
                        stroke="currentColor"
                        class="h-6 w-6 flex-shrink-0 text-white"
                      >
                        <path
                          stroke-linecap="round"
                          stroke-linejoin="round"
                          d="M15.362 5.214A8.252 8.252 0 0112 21 8.25 8.25 0 016.038 7.048 8.287 8.287 0 009 9.6a8.983 8.983 0 013.361-6.867 8.21 8.21 0 003 2.48z"
                        />
                        <path
                          stroke-linecap="round"
                          stroke-linejoin="round"
                          d="M12 18a3.75 3.75 0 00.495-7.467 5.99 5.99 0 00-1.925 3.546 5.974 5.974 0 01-2.133-1A3.75 3.75 0 0012 18z"
                        />
                      </svg>

                      Daily special
                    </a>
                  </li>
                  <li>
                    <a
                      href="#"
                      class="flex gap-x-3 rounded-md bg-gray-600 p-2 text-sm font-semibold leading-6 text-white"
                    >
                      <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.5"
                        stroke="currentColor"
                        class="h-6 w-6 flex-shrink-0 text-white"
                      >
                        <path
                          stroke-linecap="round"
                          stroke-linejoin="round"
                          d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z"
                        />
                      </svg>

                      Company
                    </a>
                  </li>
                </ul>
              </li>
            </ul>
          </nav>
        </div>
      </div>
      <div class="lg:pl-72">
        <div
          class="lg:hidden top-0 flex h-16 items-center border-b border-gray-200 bg-white px-4 shadow-sm"
        >
          <button id="hamburger-menu" class="lg:hidden">
            <svg
              xmlns="http://www.w3.org/2000/svg"
              width="24"
              height="24"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
              stroke-width="2"
            >
              <path d="M4 6h16M4 12h16m-7 6h7" />
            </svg>
          </button>
          <!-- <div class="flex flex-1 gap-x-4 self-stretch lg:gap-x-6">
            <form class="relative flex flex-1" action="">
              <label for="search-field" class="sr-only">Search</label>
              <svg
                xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 20 20"
                fill="currentColor"
                aria-hidden="true"
                class="pointer-events-none absolute inset-y-0 left-0 h-full w-5 text-gray-400"
              >
                <path
                  fill-rule="evenodd"
                  d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z"
                  clip-rule="evenodd"
                ></path>
              </svg>
              <input
                id="search-field"
                class="block h-full w-full border-0 py-0 pl-8 text-gray-900 sm:text-sm"
                placeholder="Search..."
                type="search"
                name="search"
              />
            </form>

            <div class="flex items-center gap-x-4 lg:gap-x-6">
              <button type="button" class="-m-2.5 p-2.5 text-gray-400 bkx">
                <span class="sr-only">View notifications</span
                ><svg
                  xmlns="http://www.w3.org/2000/svg"
                  fill="none"
                  viewBox="0 0 24 24"
                  stroke-width="1.5"
                  stroke="currentColor"
                  aria-hidden="true"
                  class="w-6 h-6"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0"
                  ></path>
                </svg>
              </button>
              <div
                class="hidden lg:block lg:h-6 lg:w-px lg:bg-gray-900/10"
                aria-hidden="true"
              ></div>
              <div class="relative">
                <button class="-m-1.5 flex items-center p-1.5">
                  <span class="sr-only">Open user menu</span>
                  <img
                    class="h-8 w-8 rounded-full bg-gray-50"
                    src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&amp;ixid=eyJhcHBfaWQiOjEyMDd9&amp;auto=format&amp;fit=facearea&amp;facepad=2&amp;w=256&amp;h=256&amp;q=80"
                    alt=""
                  />
                  <span class="hidden lg:flex lg:items-center">
                    <span
                      class="ml-4 text-sm font-semibold leading-6 text-gray-900"
                      >Laszlo Vitkai</span
                    >
                    <svg
                      xmlns="http://www.w3.org/2000/svg"
                      viewBox="0 0 20 20"
                      fill="currentColor"
                      aria-hidden="true"
                      class="ml-2 h-5 w-5 text-gray-400"
                    >
                      <path
                        fill-rule="evenodd"
                        d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z"
                        clip-rule="evenodd"
                      ></path>
                    </svg>
                  </span>
                </button>
              </div>
            </div>
          </div> -->
        </div>
        <main class="py-10">
          <div class="px-4 sm:px-6 lg:px-8">
            <div
              id="content-wrapper"
              class="relative  overflow-hidden border border-dashed border-gray-400 opacity-75 content-area"
            >
              <svg
                class="absolute inset-0 h-full w-full stroke-green-200"
                fill="none"
              >
                <defs>
                  <pattern
                    id="pattern-1526ac66-f54a-4681-8fb8-0859d412f251"
                    x="0"
                    y="0"
                    width="10"
                    height="10"
                    patternUnits="userSpaceOnUse"
                  >
                    <path d="M-3 13 15-5M-5 5l18-18M-1 21 17 3"></path>
                  </pattern>
                </defs>
                <rect
                  stroke="none"
                  fill="url(#pattern-1526ac66-f54a-4681-8fb8-0859d412f251)"
                  width="100%"
                  height="100%"
                ></rect>
              </svg>
            </div>
          </div>
        </main>
      </div>
    </div>
    <script>
  document.addEventListener("DOMContentLoaded", function () {
    const hamburgerMenuButton = document.getElementById("hamburger-menu");
    const menu = document.getElementById("menu");

    hamburgerMenuButton.addEventListener("click", function () {
      menu.classList.toggle("hidden");
    });
  });

  // Function to load content from list_product.php
  function loadContent() {
    var xhr = new XMLHttpRequest();
    xhr.open("GET", "list_product.php", true);
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            document.getElementById("content-wrapper").innerHTML = xhr.responseText;
            reInitEventHandlers(); // Reinitialize event handlers
        }
    };
    xhr.send();
}


  // Select the 'Products' link and add event listener
  var productsLink = document
    .querySelectorAll("#menu a")
    .forEach(function (link) {
      if (link.textContent.trim() === "Products") {
        link.addEventListener("click", function (e) {
          e.preventDefault();
          loadContent();
        });
      }
    });

    
</script>
  </body>
</html>


