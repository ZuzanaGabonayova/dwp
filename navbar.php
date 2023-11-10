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

    <div class="flex justify-center items-center bg-[url('assets/images/front_image.jpg')] h-[1200px] bg-contain bg-center bg-no-repeat">
        <div class="flex flex-col justify-end items-end w-3/4">
            <span class="text-[#FF8C42]">designed for all sneakerheads out there.</span>
            <span class="text-[#4E598C]">designed for all sneakerheads out there.</span>
        </div>

    </div>

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

</body>

</html>