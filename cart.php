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
$email=$_SESSION['email'];
$subtotal = 0;
$shiping = 0;


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart - Mehdi Mart</title>
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
        <div class="max-w-6xl mx-auto p-6">
            <h1 class="text-2xl font-bold mb-6">Shopping Cart</h1>

            <div class="overflow-x-auto bg-white rounded-lg shadow">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-100 text-gray-600 uppercase text-sm">
                            <th class="p-3">Product Name</th>
                            <th class="p-3">Product ID</th>
                            <th class="p-3">Price</th>
                            <th class="p-3">Quantity</th>
                            <th class="p-3">Total</th>
                            <th class="p-3">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Normal Product -->
                        <?php
         $select_cart_none=mysqli_query($connect,"SELECT * FROM cart WHERE email='$email'");
         while($row_cart_none=mysqli_fetch_assoc($select_cart_none)){
          $select_product=mysqli_query($connect,"SELECT * FROM product WHERE id='{$row_cart_none['product_id']}' AND discount_type='0'");
          $row_product=mysqli_fetch_assoc($select_product);
          if($row_product){
         ?>
                        <tr class="border-b">
                            <td class="p-3 flex items-center space-x-3">
                                <img src="images/<?php echo $row_product['image']?>" class="w-16 h-16 rounded">
                                <span><?php echo $row_product['name']?></span>
                            </td>
                            <td class="p-3 text-gray-600"><?php echo $row_product['id']?></td>
                            <td class="p-3 text-orange-600 font-semibold">PKR: <?php echo $row_product['price'] ?></td>
                            <td class="p-3">
                                <div class="flex items-center space-x-2">
                                    <form method="POST" action="cart-add.php">
                                        <button type="submit" name="pro_id" value="<?php echo $row_product['id']?>"
                                            class="px-2 py-1 bg-gray-200 rounded">-</button>
                                    </form>
                                    <input type="text" value="<?php echo $row_cart_none['quantity']?>" readonly
                                        class="w-12 text-center bg-gray-100 cursor-not-allowed border rounded">
                                    <form method="POST" action="cart-add.php">
                                        <button type="submit" value="<?php echo $row_product['id']?>" name="pr_id"
                                            class="px-2 py-1 bg-gray-200 rounded">+</button>
                                    </form>
                                </div>
                            </td>
                            <?php
          $price=$row_product['price'];
          $quantity=$row_cart_none['quantity'];
          $final_price=$price*$quantity;
          $subtotal+=$final_price;
          $shiping += '50' * $quantity;
          ?>
                            <td class="p-3 font-semibold">PKR <?php echo $final_price?></td>
                            <td class="p-3">
                                <form method="POST" action="cart-add.php">
                                    <button type="submit" name="product_id" class="text-red-600 hover:text-red-800"
                                        value="<?php echo $row_product['id']?>"><i class="fas fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                        <?php } } ?>
                        <!-- Percentage Discount Product -->
                        <?php
            $select_cart_per=mysqli_query($connect,"SELECT * FROM cart WHERE email='$email'");
            while($row_cart_per=mysqli_fetch_assoc($select_cart_per)){
              $select_product_per=mysqli_query($connect,"SELECT * FROM product WHERE id='{$row_cart_per['product_id']}' AND discount_type='1'");
              $row_product_per=mysqli_fetch_assoc($select_product_per);
              if($row_product_per){
            ?>

                        <tr class="border-b">
                            <td class="p-3 flex items-center space-x-3">
                                <img src="images/<?php echo $row_product_per['image']?>" class="w-16 h-16 rounded">
                                <span><?php echo $row_product_per['name']?></span>
                            </td>
                            <td class="p-3 text-gray-600"><?php echo $row_product_per['id']?></td>
                            <?php
          $price=$row_product_per['price'];
          $discount=$row_product_per['discount_value'];
          $discount_amount=($price*$discount)/100;
          $final=$price-$discount_amount;
          
          ?>
                            <td class="p-3 text-orange-600 font-semibold">PKR:
                                <?php echo $final?>
                                <span
                                    class="line-through text-gray-400 text-xs ml-1">PKR-<?php echo $row_product_per['price']?></span>
                                <span
                                    class="ml-2 bg-orange-100 text-orange-600 px-2 py-0.5 rounded text-sm"><?php echo $row_product_per['discount_value']?>%</span>
                                <span class="ml-2 line-through text-green-600 text-sm">OFF
                                    PKR:<?php echo $discount_amount?></span>
                            </td>

                            <td class="p-3">
                                <div class="flex items-center space-x-2">
                                    <form method="POST" action="cart-add.php">
                                        <button type="submit" name="pro_id" value="<?php echo $row_product_per['id']?>"
                                            class="px-2 py-1 bg-gray-200 rounded">-</button>
                                    </form>
                                    <input type="text" value="<?php echo $row_cart_per['quantity']?>" readonly
                                        class="w-12 text-center bg-gray-100 cursor-not-allowed border rounded">
                                    <form method="POST" action="cart-add.php">
                                        <button type="submit" value="<?php echo $row_product_per['id']?>" name="pr_id"
                                            class="px-2 py-1 bg-gray-200 rounded">+</button>
                                    </form>
                                </div>
                            </td>
                            <?php 
          $quantity=$row_cart_per['quantity'];
          $final_plus=$final*$quantity;
          $subtotal+=$final_plus;
          $shiping += '50' * $quantity;
          ?>
                            <td class="p-3 font-semibold">PKR <?php echo $final_plus?></td>
                            <td class="p-3">
                                <form method="POST" action="cart-add.php">
                                    <button name="product_id" type="submit" value="<?php echo $row_product_per['id']?>"
                                        class="text-red-600 hover:text-red-800"><i class="fas fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                        <?php } } ?>

                        <?php 
$select_cart_fix=mysqli_query($connect,"SELECT * FROM cart WHERE email='$email'");
while($row_cart_fix=mysqli_fetch_assoc($select_cart_fix)){
  $select_product_fix=mysqli_query($connect,"SELECT * FROM product WHERE id='{$row_cart_fix['product_id']}' AND discount_type='2'");
  $row_product_fix=mysqli_fetch_assoc($select_product_fix);
  if($row_product_fix){
?>

                        <!-- Fixed Discount Product -->
                        <tr class="border-b">
                            <td class="p-3 flex items-center space-x-3">
                                <img src="images/<?php echo $row_product_fix['image']?>" class="w-16 h-16 rounded">
                                <span><?php echo $row_product_fix['name']?></span>
                            </td>
                            <td class="p-3 text-gray-600"><?php echo $row_product_fix['id']?></td>
                            <?php
          $price_fix=$row_product_fix['price'];
          $discount_fix=$row_product_fix['discount_value'];
          $final_fix=$price_fix-$discount_fix;
          
          ?>
                            <td class="p-3 text-orange-600 font-semibold">PKR:
                                <?php echo $final_fix?>
                                <span
                                    class="line-through text-gray-400 text-xs ml-1">PKR-<?php echo $row_product_fix['price']?></span>
                                <span
                                    class="ml-2 bg-orange-100 text-orange-600 px-2 py-0.5 rounded text-sm">PKR-<?php echo $row_product_fix['discount_value']?></span>
                                <span class="ml-2 line-through text-green-600 text-sm">OFF
                                    PKR:<?php echo $discount_fix?></span>
                            </td>

                            <td class="p-3">
                                <div class="flex items-center space-x-2">
                                    <form method="POST" action="cart-add.php">
                                        <button type="submit" name="pro_id" value="<?php echo $row_product_fix['id']?>"
                                            class="px-2 py-1 bg-gray-200 rounded">-</button>
                                    </form>
                                    <input type="text" value="<?php echo $row_cart_fix['quantity']?>" readonly
                                        class="w-12 text-center bg-gray-100 cursor-not-allowed border rounded">
                                    <form method="POST" action="cart-add.php">
                                        <button type="submit" value="<?php echo $row_product_fix['id']?>" name="pr_id"
                                            class="px-2 py-1 bg-gray-200 rounded">+</button>
                                    </form>
                                </div>
                            </td>
                            <?php 
          $quantity=$row_cart_fix['quantity'];
          $final_fix_result=$final_fix*$quantity;
          $subtotal+=$final_fix_result;
          $shiping += '50' * $quantity;

          ?>
                            <td class="p-3 font-semibold">PKR <?php echo $final_fix_result?></td>
                            <td class="p-3">
                                <form method="POST" action="cart-add.php">
                                    <button name="product_id" type="submit" value="<?php echo $row_product_fix['id']?>"
                                        class="text-red-600 hover:text-red-800"><i class="fas fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                        <?php } } ?>
                    </tbody>
                </table>
            </div>

            <!-- Cart Summary -->
            <div class="mt-6 w-full md:w-1/3 ml-auto bg-white p-6 rounded-lg shadow">
                <h2 class="text-lg font-bold mb-4">Cart Summary</h2>
                <div class="flex justify-between mb-2">
                    <span>Subtotal</span>
                    <span><?php echo $subtotal?></span>
                </div>
                <div class="flex justify-between mb-2">
                    <span>Shipping</span>
                    <span><?php echo $shiping?></span>
                </div>
                <div class="flex justify-between font-bold text-lg">
                    <span>Total</span>
                    <span><?php echo $subtotal+$shiping?></span>
                </div>
                <button class="mt-4 w-full bg-orange-600 text-white py-2 rounded-lg hover:bg-orange-700">
                    <a href="checkout.php"> Proceed to Checkout</a>
                </button>
            </div>
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