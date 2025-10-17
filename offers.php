<?php
session_start();
if(!isset($_SESSION['email'])){
    echo "<script>
            alert('Please login first!');
            window.location.href='login.php';
          </script>";
    exit();
}
if(isset($_POST['logout'])){
unset($_SESSION['email']);
  echo "<script>
        alert('You have been logged out successfully!');
        window.location.href='login.php';
      </script>";
}
include("connection.php");
$connect=connection();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mehdi Mart - Offers</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
    .slide {
        display: none;
    }

    .active {
        display: block;
    }
    </style>
</head>

<body class="bg-gray-50 text-gray-900">

    <body class="bg-gray-50 text-gray-900">

        <!-- HEADER -->
        <header class="sticky top-0 bg-white shadow z-50">
            <!-- TOP NAV -->
            <div class="max-w-7xl mx-auto flex items-center justify-between px-4 py-3">
                <!-- Logo -->
                <a href="index.php" class="text-2xl font-bold text-orange-600">Mehdi Mart</a>

                <!-- Desktop Search bar -->
                <form method="GET" action="shop.php" class="flex flex-1 mx-6">
                    <div class="hidden md:flex flex-1 mx-6">

                        <input type="text" name="search" placeholder="Search products..."
                            class="w-full border border-gray-300 rounded-l px-3 py-2 text-sm md:text-base focus:outline-none">
                        <button type="submit" class="bg-orange-600 text-white px-4 rounded-r hover:bg-orange-700">
                            <i class="fas fa-search"></i>
                        </button>

                    </div>
                </form>

                <!-- Right Icons -->
                <div class="flex items-center space-x-4">
                    <a href="wishlist.php" class="relative hover:text-orange-600"><i
                            class="fas fa-heart text-lg sm:text-xl"></i>
                        <?php 
        $wishlist_count_query = mysqli_query($connect, 
    "SELECT COUNT(*) AS total FROM wishlist WHERE email='".$_SESSION['email']."'");
    
$row_wish= mysqli_fetch_assoc($wishlist_count_query);
$wishlist_count = $row_wish['total'];

        ?>
                        <span
                            class="absolute -top-2 -right-2 bg-orange-600 text-white text-xs w-5 h-5 flex items-center justify-center rounded-full"><?php echo $wishlist_count?></span>
                    </a>
                    <a href="cart.php" class="relative hover:text-orange-600">
                        <i class="fas fa-shopping-cart text-lg sm:text-xl"></i>
                        <?php
          $cart_count_1=mysqli_query($connect,"SELECT COUNT(*) AS total FROM cart WHERE email='".$_SESSION['email']."'");
          $row_cart=mysqli_fetch_assoc($cart_count_1);
          $cart_count=$row_cart['total'];
          ?>
                        <span
                            class="absolute -top-2 -right-2 bg-orange-600 text-white text-xs w-5 h-5 flex items-center justify-center rounded-full"><?php echo $cart_count?></span>
                    </a>
                    <div class="relative">
                        <button id="profileBtn" class="hover:text-orange-600 flex items-center">
                            <i class="fas fa-user text-lg sm:text-xl mr-1"></i> <span
                                class="hidden sm:inline">Profile</span>
                        </button>
                        <div id="profileMenu"
                            class="absolute right-0 mt-2 w-40 bg-white border rounded shadow-md hidden">
                            <<a href="profile.php" class="block px-4 py-2 hover:bg-gray-100">My Profile</a>
                                <a href="login.php" class="block px-4 py-2 hover:bg-gray-100">Login</a>
                                <a href="signup.php" class="block px-4 py-2 hover:bg-gray-100">Signup</a>
                                <form method="POST">
                                    <button type="submit" name="logout"
                                        class="block px-4 py-2 hover:bg-gray-100">Logout</button>
                                </form>
                        </div>
                    </div>
                    <!-- Mobile Menu -->
                    <button id="menuBtn" class="md:hidden text-2xl"><i class="fas fa-bars"></i></button>
                </div>
            </div>

            <!-- MAIN NAV (Desktop) -->
            <nav class="hidden md:flex bg-orange-600 text-white px-6 py-2 space-x-6 text-sm md:text-base">
                <a href="index.php" class="hover:underline">Home</a>
                <a href="shop.php" class="hover:underline">Shop</a>
                <a href="offers.php" class="hover:underline">Offers</a>
                <a href="about.php" class="hover:underline">About</a>
                <a href="contact.php" class="hover:underline">Contact</a>
            </nav>

            <!-- MOBILE DROPDOWN MENU -->
            <div id="mobileMenu" class="hidden bg-orange-50 border-t border-gray-200 p-4 md:hidden">
                <!-- Mobile Search -->
                <form method="GET" action="shop.php">
                    <div class="flex mb-3">

                        <input type="text" name="search" placeholder="Search..."
                            class="w-full border border-gray-300 rounded-l px-3 py-2 text-sm focus:outline-none">
                        <button type="submit" class="bg-orange-600 text-white px-4 rounded-r hover:bg-orange-700">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </form>
                <!-- Mobile Links -->
                <a href="index.php" class="block py-2 hover:text-orange-600">Home</a>
                <a href="shop.php" class="block py-2 hover:text-orange-600">Shop</a>
                <a href="offers.php" class="block py-2 hover:text-orange-600">Offers</a>
                <a href="about.php" class="block py-2 hover:text-orange-600">About</a>
                <a href="contact.php" class="block py-2 hover:text-orange-600">Contact</a>
            </div>
        </header>

        <!-- CATEGORY SECTION -->
        

        <!-- OFFERS PRODUCTS -->
        <div class="max-w-7xl mx-auto px-4 mt-6">
            <main>
                <h2 class="text-lg sm:text-xl md:text-2xl font-bold mb-6">Current Offers</h2>
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-6">
                    <!-- Sample product card -->

                    <?php 
        $select_product_per=mysqli_query($connect,"SELECT * FROM product WHERE status='1' AND discount_type='1'");
        while($row_product_per=mysqli_fetch_assoc($select_product_per)){
        ?>
                    <?php
          $product_id=$row_product_per['id'];
              $check = mysqli_query($connect, "SELECT * FROM wishlist WHERE email='".$_SESSION['email']."' AND product_id='$product_id'");
              $inWishlist = mysqli_num_rows($check) > 0;
          ?>
                    <div class="bg-white p-4 shadow rounded text-center relative hover:shadow-lg transition">
                        <a href="product.php?id=<?php echo $row_product_per['id']?>">
                            <img src="images/<?php echo $row_product_per['image']?>"
                                class="mx-auto mb-3 w-full h-48 object-cover">
                            <?php 
          $price=$row_product_per['price'];
          $value=$row_product_per['discount_value'];
          $value_pr=($price*$value)/100;
          $final=$price-$value_pr;
          ?>
                            <h3 class="font-semibold text-sm md:text-base"><?php echo $row_product_per['name']?></h3>
                            <p class="text-orange-600 font-bold text-sm md:text-base">PKR: <?php echo $final?> <span
                                    class="line-through text-gray-400 text-xs">PKR-<?php echo $price?></span>
                                <span
                                    class="ml-2 bg-orange-100 text-orange-600 px-2 py-0.5 rounded text-sm">-<?php echo $row_product_per['discount_value']?>%</span>
                            </p>
                        </a>
                        <div class="absolute top-2 right-2 flex flex-col space-y-2">
                            <form method="POST" action="wishlist-add.php">
                                <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
                                <button
                                    class="bg-white p-2 rounded-full shadow <?php echo $inWishlist ? 'text-orange-600' : 'text-black hover:text-orange-600'; ?>">
                                    <i class="fas fa-heart"></i>
                                </button>
                            </form>
                            <?php 
          $product_id=$row_product_per['id'];
          $check_cart=mysqli_query($connect, "SELECT * FROM cart WHERE email='".$_SESSION['email']."' AND product_id='$product_id'");
          $check_cart_c=mysqli_num_rows($check_cart)>0;
          ?>
                            <form method="POST" action="cart-add.php">

                                <input type="hidden" name="product_id" value="<?php echo $row_product_per['id']; ?>">
                                <button
                                    class="bg-white p-2 rounded-full shadow <?php echo $check_cart_c?'text-orange-600' : 'text_black hover:text-orange-600';?>"><i
                                        class="fas fa-cart-plus"></i></button>
                            </form>
                        </div>
                    </div>
                    <?php } ?>



                    <?php 
        $select_product_per1=mysqli_query($connect,"SELECT * FROM product WHERE status='1' AND discount_type='2'");
        while($row_product_per1=mysqli_fetch_assoc($select_product_per1)){
        ?>
                    <?php
          $product_id=$row_product_per1['id'];
              $check = mysqli_query($connect, "SELECT * FROM wishlist WHERE email='".$_SESSION['email']."' AND product_id='$product_id'");
              $inWishlist = mysqli_num_rows($check) > 0;
          ?>
                    <div class="bg-white p-4 shadow rounded text-center relative hover:shadow-lg transition">
                        <a href="product.php?id=<?php echo $row_product_per1['id']?>">
                            <img src="images/<?php echo $row_product_per1['image']?>"
                                class="mx-auto mb-3 w-full h-48 object-cover">
                            <?php 
          $price=$row_product_per1['price'];
          $value=$row_product_per1['discount_value'];
          
          $final=$price-$value;
          ?>
                            <h3 class="font-semibold text-sm md:text-base"><?php echo $row_product_per1['name']?></h3>
                            <p class="text-orange-600 font-bold text-sm md:text-base">PKR: <?php echo $final?> <span
                                    class="line-through text-gray-400 text-xs">PKR-<?php echo $price?></span>
                                <span
                                    class="ml-2 bg-orange-100 text-orange-600 px-2 py-0.5 rounded text-sm">PKR-<?php echo $row_product_per1['discount_value']?></span>
                            </p>
                        </a>
                        <div class="absolute top-2 right-2 flex flex-col space-y-2">
                            <form method="POST" action="wishlist-add.php">
                                <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
                                <button
                                    class="bg-white p-2 rounded-full shadow <?php echo $inWishlist ? 'text-orange-600' : 'text-black hover:text-orange-600'; ?>">
                                    <i class="fas fa-heart"></i>
                                </button>
                            </form>
                            <?php 
          $product_id=$row_product_per1['id'];
          $check_cart=mysqli_query($connect, "SELECT * FROM cart WHERE email='".$_SESSION['email']."' AND product_id='$product_id'");
          $check_cart_c=mysqli_num_rows($check_cart)>0;
          ?>
                            <form method="POST" action="cart-add.php">

                                <input type="hidden" name="product_id" value="<?php echo $row_product_per1['id']; ?>">
                                <button
                                    class="bg-white p-2 rounded-full shadow <?php echo $check_cart_c?'text-orange-600' : 'text_black hover:text-orange-600';?>"><i
                                        class="fas fa-cart-plus"></i></button>
                            </form>
                        </div>
                    </div>
                    <?php } ?>



                    <!-- Add more products similarly -->
                </div>
            </main>
        </div>

        <!-- FOOTER -->
        <footer class="bg-gray-900 text-gray-300 py-10 mt-12">
            <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-4 gap-6 px-4 text-sm sm:text-base">
                <div>
                    <h4 class="font-bold mb-3 text-white">Quick Links</h4>
                    <a href="index.php" class="block hover:underline">Home</a>
                    <a href="category.php" class="block hover:underline">Shop</a>
                    <a href="offers.php" class="block hover:underline">Offers</a>
                </div>
                <div>
                    <h4 class="font-bold mb-3 text-white">Customer Service</h4>
                    <a href="contact.php" class="block hover:underline">Contact Us</a>
                    <a href="terms.php" class="block hover:underline">Terms</a>
                    <a href="privacy.php" class="block hover:underline">Privacy Policy</a>
                </div>
                <div>
                    <h4 class="font-bold mb-3 text-white">Follow Us</h4>
                    <div class="flex space-x-3">
                        <a href="https://www.facebook.com/azadbacha555/"><i
                                class="fab fa-facebook text-xl hover:text-white"></i></a>
                        <a href="https://www.linkedin.com/in/muhammad-mehdi-7a487435a/"><i
                                class="fab fa-linkedin text-xl hover:text-white"></i></a>
                        <a href="https://github.com/MuhammadMehdi555"><i
                                class="fab fa-github text-xl hover:text-white"></i></a>
                    </div>
                </div>
                <div>
                    <h4 class="font-bold mb-3 text-white">Newsletter</h4>
                    <form class="flex" method="POST" action="newsletter.php">
                        <input type="email" name="email" placeholder="Enter your email"
                            class="w-full px-3 py-2 rounded-l bg-gray-800 border border-gray-700 text-white focus:outline-none text-sm sm:text-base">
                        <button class="bg-orange-600 px-4 rounded-r hover:bg-orange-700">
                            <i class="fas fa-paper-plane text-white"></i>
                        </button>
                    </form>
                </div>
            </div>
            <p class="text-center text-xs sm:text-sm text-gray-500 mt-6">© 2025 Mehdi Mart. All rights reserved.</p>
        </footer>

        <!-- JS -->
        <script>
        // Profile toggle
        document.getElementById('profileBtn').addEventListener('click', () => {
            document.getElementById('profileMenu').classList.toggle('hidden');
        });

        // Mobile menu toggle
        const menuBtn = document.getElementById('menuBtn');
        const mobileMenu = document.getElementById('mobileMenu');
        menuBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            mobileMenu.classList.toggle('hidden');
        });
        document.body.addEventListener('click', (e) => {
            if (!mobileMenu.contains(e.target) && !menuBtn.contains(e.target)) {
                mobileMenu.classList.add('hidden');
            }
        });

        </script>

    </body>

</html>