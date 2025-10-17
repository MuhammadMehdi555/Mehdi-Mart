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
    <title>Privacy Policy - Mehdi Mart</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
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
                            <a href="profile.php" class="block px-4 py-2 hover:bg-gray-100">My Profile</a>
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

        <!-- CATEGORY SECTION SAME AS INDEX -->

        <!-- MAIN CONTENT PRIVACY POLICY -->
        <main class="max-w-4xl mx-auto px-4 py-16 bg-white shadow rounded-lg mt-6">
            <h1 class="text-3xl font-bold mb-6 text-gray-800">Privacy Policy</h1>

            <p class="mb-4 text-gray-700">
                Welcome to <span class="font-semibold text-orange-600">Mehdi Mart</span>.
                Please note that this website is created <strong>for educational and practice purposes only</strong>.
                The data entered here (such as names, emails, and orders) may not be real and will not be used for any
                commercial purpose.
            </p>

            <h2 class="text-xl font-semibold mb-2 text-gray-800">Important Notice</h2>
            <ul class="list-disc list-inside mb-4 text-gray-700 space-y-2">
                <li>This website is a demo project built by <strong>Muhammad Mehdi</strong> to practice frontend and
                    backend development.</li>
                <li>Any data you enter, such as email or contact information, will only be used for testing and will not
                    be shared or stored permanently.</li>
                <li>Fake or random email addresses may be used for demonstration.</li>
                <li>Do not enter any sensitive personal data such as real passwords, banking details, or confidential
                    information.</li>
            </ul>

            <h2 class="text-xl font-semibold mb-2 text-gray-800">Information We Collect (Demo Only)</h2>
            <ul class="list-disc list-inside mb-4 text-gray-700 space-y-2">
                <li>Sample personal data you enter (name, email, etc.) for testing.</li>
                <li>Temporary cart or checkout data to demonstrate e-commerce functionality.</li>
                <li>No real payment is processed on this website.</li>
            </ul>

            <h2 class="text-xl font-semibold mb-2 text-gray-800">Disclaimer</h2>
            <p class="mb-4 text-gray-700">
                Since this project is not a live store, <strong>Mehdi Mart does not guarantee data security or actual
                    order delivery</strong>.
                This platform is meant only for portfolio and learning display.
            </p>

            <h2 class="text-xl font-semibold mb-2 text-gray-800">Your Responsibility</h2>
            <p class="mb-4 text-gray-700">
                Please do not insert real or private data. If you use fake credentials, make sure they are not linked to
                any real account.
                The purpose is to test website functionality and improve development skills.
            </p>

            <h2 class="text-xl font-semibold mb-2 text-gray-800">Contact</h2>
            <p class="text-gray-700">
                For questions or to learn more about this project, contact the developer:
                <a href="mailto:muhammdmehdi0555@gmail.com" class="text-orange-600 hover:underline">
                    muhammdmehdi0555@gmail.com
                </a>.
            </p>
        </main>


        <!-- FOOTER SAME AS INDEX -->
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