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
$connect = connection();
$email=$_SESSION['email'];
$select_wishlist = mysqli_query($connect,"SELECT product_id FROM wishlist WHERE email='$email'");

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wishlist - Mehdi Mart</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>

<body class="bg-gray-50 text-gray-900">

    <!-- HEADER -->
    <header class="sticky top-0 bg-white shadow z-50">
        <div class="max-w-7xl mx-auto flex items-center justify-between px-4 py-3">
            <a href="index.php" class="text-2xl font-bold text-orange-600">Mehdi Mart</a>

            <form method="GET" action="shop.php" class="flex flex-1 mx-6">
                <div class="hidden md:flex flex-1 mx-6">
                    <input type="text" name="search" placeholder="Search products..."
                        class="w-full border border-gray-300 rounded-l px-3 py-2 text-sm md:text-base focus:outline-none">
                    <button type="submit" class="bg-orange-600 text-white px-4 rounded-r hover:bg-orange-700">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </form>

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
                    <div id="profileMenu" class="absolute right-0 mt-2 w-40 bg-white border rounded shadow-md hidden">
                        <a href="profile.php" class="block px-4 py-2 hover:bg-gray-100">My Profile</a>
                        <a href="login.php" class="block px-4 py-2 hover:bg-gray-100">Login</a>
                        <a href="signup.php" class="block px-4 py-2 hover:bg-gray-100">Signup</a>
                        <form method="POST">
                            <button type="submit" name="logout"
                                class="block px-4 py-2 hover:bg-gray-100">Logout</button>
                        </form>
                    </div>
                </div>
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
            <form method="GET" action="shop.php">
                <div class="flex mb-3">
                    <input type="text" name="search" placeholder="Search..."
                        class="w-full border border-gray-300 rounded-l px-3 py-2 text-sm focus:outline-none">
                    <button type="submit" class="bg-orange-600 text-white px-4 rounded-r hover:bg-orange-700">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </form>
            <a href="index.php" class="block py-2 hover:text-orange-600">Home</a>
            <a href="shop.php" class="block py-2 hover:text-orange-600">Shop</a>
            <a href="offers.php" class="block py-2 hover:text-orange-600">Offers</a>
            <a href="about.php" class="block py-2 hover:text-orange-600">About</a>
            <a href="contact.php" class="block py-2 hover:text-orange-600">Contact</a>
        </div>
    </header>

    <!-- WISHLIST SECTION -->
    <main class="max-w-7xl mx-auto px-4 py-10">
        <h1 class="text-2xl md:text-3xl font-bold mb-8">My Wishlist</h1>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Wishlist Item -->
            <?php
       while($row_wishlist = mysqli_fetch_assoc($select_wishlist)){
    $product_id = $row_wishlist['product_id'];
    $select_product = mysqli_query($connect,"SELECT * FROM product WHERE id='$product_id'");
    $row_product = mysqli_fetch_assoc($select_product);
       ?>
            <div class="bg-white shadow rounded-lg p-4 flex flex-col items-center">
                <img src="images/<?php echo $row_product['image']?>" class="w-40 h-40 mb-3 rounded">
                <h3 class="font-semibold text-lg mb-1"><?php echo $row_product['name']?></h3>
                <?php if($row_product['discount_type'] == 0){ ?>
                <p class="text-orange-600 font-bold text-sm md:text-base">PKR: <?php echo $row_product['price'];?></p>
                <?php } else if($row_product['discount_type']==1){
        $price=$row_product['price'];
        $dis=$row_product['discount_value'];
        $res=($price * $dis)/100;
        $final=$price-$dis;
        ?>
                <p class="text-orange-600 font-bold text-sm md:text-base">PKR: <?php echo $final;?> <span
                        class="line-through text-gray-400 text-xs">PKR-<?php echo $row_product['price']?></span><span
                        class="ml-2 bg-orange-100 text-orange-600 px-2 py-0.5 rounded text-sm">-<?php echo $row_product['discount_value']?>%</span>
                </p>
                <?php } else{
              $price=$row_product['price'];
              $dis=$row_product['discount_value'];
              $final=$price-$dis;
              ?>
                <p class="text-orange-600 font-bold text-sm md:text-base">PKR: <?php echo $final;?> <span
                        class="line-through text-gray-400 text-xs">PKR-<?php echo $row_product['price']?></span><span
                        class="ml-2 bg-orange-100 text-orange-600 px-2 py-0.5 rounded text-sm">PKR-<?php echo $row_product['discount_value']?></span>
                </p>
                <?php } ?>
                <div class="flex space-x-2">

                    <form method="POST" action="wishlist-add.php">
                        <input type="hidden" name="product_id" value="<?php echo $row_product['id']; ?>">
                        <button type="submit"
                            class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700">Remove</button>
                    </form>
                    <form method="POST" action="cart-add.php">
                        <input type="hidden" name="product_id" value="<?php echo $row_product['id']; ?>">
                        <button class="px-3 py-1 bg-green-600 text-white rounded hover:bg-green-700">Move to
                            Cart</button>
                    </form>
                </div>
            </div>
            <?php } ?>



            <!-- Wishlist Summary -->
    </main>

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
    // Profile dropdown
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