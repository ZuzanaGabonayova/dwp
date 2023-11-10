<?php
session_start(); // Start the session or resume an existing one
$cartItemCount = isset($_SESSION['cart']) ? array_sum(array_column($_SESSION['cart'], 'quantity')) : 0;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Shop</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
</head>

<body>
    <nav class="p-3 flex items-center justify-center w-full h-32">
        <div class="w-5/6 h-full flex flex-wrap">
            <div class="w-full flex items-center justify-between border-solid border-b-2">
                <div class="w-[335px] flex justify-between items-center">
                    <div>
                        <i class="fas fa-phone fa-flip-horizontal text-[#FF8C42]"></i>
                        <span>+45 52 22 40 73</span>

                    </div>
                    <div>
                        <i class=" fas fa-envelope text-[#FF8C42]"></i>
                        <span>info@sneakerheads.dk</span>

                    </div>
                </div>
                <div class="w-fit text-[#FF8C42]">
                    <i class="fab fa-facebook"></i>
                    <i class="fab fa-instagram"></i>
                </div>
            </div>
            <div class="w-full flex justify-between">
                <div class="w-52 flex items-center">
                    <span>missing logo here</span>
                </div>
                <div class="w-5/12 flex items-center justify-between">
                    <a href="#"> About </a>
                    <a href="news.php"> News </a>
                    <a href="product_list.php"> Sneakers </a>
                    <div class="w-3/12 flex justify-between items-center">
                        <a href="view_cart.php" class="relative inline-block">
                            <i class="fas fa-shopping-cart"></i>
                            <span class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-red-100 transform translate-x-1/2 -translate-y-1/2 bg-red-600 rounded-full">
                                <?php echo $cartItemCount; ?>
                            </span>
                        </a>
                        <a href="contact.php" class="p-2 text-white bg-[#FF8C42] rounded-md"> Contact Me</a>
                    </div>

                </div>



            </div>
        </div>
        <!-- <div class="container mx-auto flex items-center justify-between">
            <a href="/" class="text-xl font-bold">My Shop</a>
            <div class="flex gap-6">
                <a href="news.php">News</a>
                <a href="visitor_product_page.php">Products</a>
            </div>
            <div>
                <a href="view_cart.php" class="relative inline-block">
                    <i class="fas fa-shopping-cart"></i>
                    <span class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-red-100 transform translate-x-1/2 -translate-y-1/2 bg-red-600 rounded-full">
                        <?php echo $cartItemCount; ?>
                    </span>
                </a>
            </div>
        </div>-->
    </nav>



    <!-- Your page content goes here -->

    <div class="flex justify-center items-center">
        <div class="w-10/12">
            <div>

                <h1 class="font-bold text-4xl">
                    OUR TOP CATEGORIES
                </h1>
                <h3>
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse varius enim
                </h3>
            </div>
            <div class="w-full flex justify-center">
                <div class="w-9/12 flex items-center justify-between">
                    <a href="#"> NIKE DUNK </a>
                    <a href="news.php"> AIR FORCE 1 </a>
                    <a href="product_list.php"> JORDAN 1 LOW </a>
                    <a href="product_list.php"> JORDAN 1 MID </a>
                    <a href="product_list.php"> JORDAN 1 HIGH </a>
                    <a href="product_list.php"> YEEZY </a>


                </div>




            </div>

            <div class="w-full grid grid-cols-3 gap-20">
                <div class="border-2 border-solid rounded-3xl shadow-lg h-[500px]

">
                    <div class="flex justify-center border-b-2 border-solid shadow-lg 

">
                        <img class="object-cover h-72 w-[450px]" src="assets/images/prod_654698358ed90.png" />
                    </div>
                    <div class="flex justify-center align-center w-full">
                        <div class="my-4 w-10/12">
                            <p class="font-bold">Nike Dunk Low Arizona State</p>

                            <div class="mt-10 flex flex-col border-b-2 border-solid border-[#FF8C42] w-24 items-center">
                                <div class="my-2">
                                    <p class="py-2">250 €</p>
                                    <span class="text-[#FF8C42] font-bold ">DETAILS</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>


    <nav class="flex justify-between items-center px-10 py-5 relative">
        <a class="font-black text-xl" href="">LOGO</a>

        <div class="hidden sm:flex gap-16">
            <ul class="flex gap-10 items-center">
                <li>
                    <a href="">About</a>
                </li>
                <li>
                    <a href="">Services</a>
                </li>
                <li>
                    <a href="">Pricing</a>
                </li>
            </ul>

            <button class="bg-blue-700 text-white py-2 px-5">Get Started</button>
        </div>

        <button id="menu_btn" class="w-10 sm:hidden">
            <svg id="menu_bars" xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-list" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z" />
            </svg>

            <svg id="menu_close" xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-x hidden" viewBox="0 0 16 16">
                <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z" />
            </svg>
        </button>

        <!-- mobile menu -->
        <div id="mobile_menu" class="absolute top-full bg-gray-100 right-10 left-10 hidden">
            <div class="flex flex-col gap-10 p-5 sm:hidden">
                <ul class="flex flex-col gap-2 items-center text-center">
                    <li class="w-full">
                        <a class="py-5 block" href="">About</a>
                    </li>
                    <li class="w-full">
                        <a class="py-5 block" href="">Services</a>
                    </li>
                    <li class="w-full">
                        <a class="py-5 block" href="">Pricing</a>
                    </li>
                </ul>

                <button class="bg-blue-700 text-white py-2 px-5">Get Started</button>
            </div>
        </div>

    </nav>

</body>

</html>