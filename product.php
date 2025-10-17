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
$id=$_GET['id'];
$select_product=mysqli_query($connect,"SELECT * FROM product WHERE id='$id'");

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product - Mehdi Mart</title>
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

        <!-- FULL WIDTH CATEGORY SECTION SAME AS INDEX -->

        <!-- PRODUCT SECTION -->
        <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <?php 
    while($row_product=mysqli_fetch_assoc($select_product)){
      if($row_product['status']==1 && $row_product['discount_type']==0){
    ?>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Product Images -->
                <div class="md:col-span-2">
                    <img id="mainImg" class="w-full h-96 object-cover rounded"
                        src="images/<?php echo $row_product['image']?>" alt="product">
                    <div class="mt-3 grid grid-cols-4 gap-2">
                        <?php if(!empty($row_product['image1'])) { ?>
                        <img class="thumb cursor-pointer h-20 object-cover rounded"
                            data-src="images/<?php echo $row_product['image1']?>"
                            src="images/<?php echo $row_product['image1']?>">
                        <?php } ?>

                        <?php if(!empty($row_product['image2'])) { ?>
                        <img class="thumb cursor-pointer h-20 object-cover rounded"
                            data-src="images/<?php echo $row_product['image2']?>"
                            src="images/<?php echo $row_product['image2']?>">
                        <?php } ?>
                    </div>

                </div>

                <!-- Product Info -->
                <div>
                    <h1 class="text-3xl font-bold"><?php echo $row_product['name']?></h1>
                    <p class="text-sm text-gray-500 mt-1">Brand: <?php echo $row_product['subcategory']?></p>
                    <div class="mt-3">
                        <!-- <span class="line-through text-gray-400">$89.00</span> -->
                        <span class="text-orange-600 font-bold text-2xl ml-2">PKR:
                            <?php echo $row_product['price']?></span>
                        <!-- <span class="ml-2 bg-orange-100 text-orange-600 px-2 py-0.5 rounded text-sm">-34%</span> -->
                    </div>
                    <p class="mt-4 text-gray-700"><?php echo $row_product['short_description']?></p>
                    <!-- Quantity -->

                    <!-- Add to cart / wishlist / share -->
                    <div class="mt-4 flex gap-2 items-center">
                        <form method="POST" action="cart-add.php">
                            <input type="hidden" name="product_id" value="<?php echo $row_product['id']; ?>">
                            <button class="bg-orange-600 text-white px-6 py-2 rounded hover:bg-orange-700">Add to
                                cart</button>
                        </form>
                        <?php
          $product_id=$row_product['id'];
              $check = mysqli_query($connect, "SELECT * FROM wishlist WHERE email='".$_SESSION['email']."' AND product_id='$product_id'");
              $inWishlist = mysqli_num_rows($check) > 0;
          ?>
                        <form method="POST" action="wishlist-add.php">
                            <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
                            <button class="px-4 py-2 border rounded hover:bg-gray-100">Wishlist</button>
                        </form>

                    </div>

                </div>
            </div>
            <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 bg-white rounded shadow mt-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-4">Product Details</h2>
                <p class="text-gray-700 leading-relaxed">
                    <?php echo $row_product['description']?>
                </p>
            </section>
            <?php } } ?>





            <?php 
    $select_product1=mysqli_query($connect,"SELECT * FROM product WHERE id='$id'");
    while($row_product1=mysqli_fetch_assoc($select_product1)){
      if($row_product1['status']==1&&$row_product1['discount_type']==1){
    ?>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Product Images -->
                <div class="md:col-span-2">
                    <img id="mainImg" class="w-full h-96 object-cover rounded"
                        src="images/<?php echo $row_product1['image']?>" alt="product">
                    <div class="mt-3 grid grid-cols-4 gap-2">
                        <?php if(!empty($row_product1['image1'])) { ?>
                        <img class="thumb cursor-pointer h-20 object-cover rounded"
                            data-src="images/<?php echo $row_product1['image1']?>"
                            src="images/<?php echo $row_product1['image1']?>">
                        <?php } ?>

                        <?php if(!empty($row_product1['image2'])) { ?>
                        <img class="thumb cursor-pointer h-20 object-cover rounded"
                            data-src="images/<?php echo $row_product1['image2']?>"
                            src="images/<?php echo $row_product1['image2']?>">
                        <?php } ?>
                    </div>

                </div>
                <?php
      $price=$row_product1['price'];
      $per=$row_product1['discount_value'];
      $discount_price=($price*$per)/100;
      $final_price=$price-$discount_price;
?>

                <!-- Product Info -->
                <div>
                    <h1 class="text-3xl font-bold"><?php echo $row_product1['name']?></h1>
                    <p class="text-sm text-gray-500 mt-1">Brand: <?php echo $row_product1['subcategory']?></p>
                    <div class="mt-3">
                        <span class="line-through text-gray-400">PKR <?php echo $row_product1['price']?></span>
                        <span class="text-orange-600 font-bold text-2xl ml-2">PKR: <?php echo $final_price?></span>
                        <span
                            class="ml-2 bg-orange-100 text-orange-600 px-2 py-0.5 rounded text-sm">-<?php echo $row_product1['discount_value']?>%</span>
                    </div>
                    <p class="mt-4 text-gray-700"><?php echo $row_product1['short_description']?></p>




                    <!-- Add to cart / wishlist / share -->
                    <div class="mt-4 flex gap-2 items-center">
                        <form method="POST" action="cart-add.php">
                            <input type="hidden" name="product_id" value="<?php echo $row_product['id']; ?>">
                            <button class="bg-orange-600 text-white px-6 py-2 rounded hover:bg-orange-700">Add to
                                cart</button>
                        </form>
                        <?php
          $product_id=$row_product1['id'];
              $check = mysqli_query($connect, "SELECT * FROM wishlist WHERE email='".$_SESSION['email']."' AND product_id='$product_id'");
              $inWishlist = mysqli_num_rows($check) > 0;
          ?>
                        <form method="POST" action="wishlist-add.php">
                            <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
                            <button class="px-4 py-2 border rounded hover:bg-gray-100">Wishlist</button>
                        </form>
                    </div>
                </div>
            </div>
            <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 bg-white rounded shadow mt-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-4">Product Details</h2>
                <p class="text-gray-700 leading-relaxed">
                    <?php echo $row_product1['description']?>
                </p>
            </section>
            <?php } } ?>








            <?php 
    $select_product2=mysqli_query($connect,"SELECT * FROM product WHERE id='$id'");
    while($row_product2=mysqli_fetch_assoc($select_product2)){
      if($row_product2['status']==1&&$row_product2['discount_type']==2){
    ?>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Product Images -->
                <div class="md:col-span-2">
                    <img id="mainImg" class="w-full h-96 object-cover rounded"
                        src="images/<?php echo $row_product2['image']?>" alt="product">
                    <div class="mt-3 grid grid-cols-4 gap-2">
                        <?php if(!empty($row_product2['image1'])) { ?>
                        <img class="thumb cursor-pointer h-20 object-cover rounded"
                            data-src="images/<?php echo $row_product2['image1']?>"
                            src="images/<?php echo $row_product2['image1']?>">
                        <?php } ?>

                        <?php if(!empty($row_product2['image2'])) { ?>
                        <img class="thumb cursor-pointer h-20 object-cover rounded"
                            data-src="images/<?php echo $row_product2['image2']?>"
                            src="images/<?php echo $row_product2['image2']?>">
                        <?php } ?>
                    </div>

                </div>
                <?php
      $price=$row_product2['price'];
      $per=$row_product2['discount_value'];
      $offer=$price-$per;
      ?>

                <!-- Product Info -->
                <div>
                    <h1 class="text-3xl font-bold"><?php echo $row_product2['name']?></h1>
                    <p class="text-sm text-gray-500 mt-1">Brand: <?php echo $row_product2['subcategory']?></p>
                    <div class="mt-3">
                        <span class="line-through text-gray-400">PKR <?php echo $row_product2['price']?></span>
                        <span class="text-orange-600 font-bold text-2xl ml-2">PKR:<?php echo $offer?></span>
                        <span
                            class="ml-2 bg-orange-100 text-orange-600 px-2 py-0.5 rounded text-sm">-<?php echo $row_product2['discount_value']?></span>
                    </div>
                    <p class="mt-4 text-gray-700"><?php echo $row_product2['short_description']?></p>




                    <!-- Add to cart / wishlist / share -->
                    <div class="mt-4 flex gap-2 items-center">
                        <form method="POST" action="cart-add.php">
                            <input type="hidden" name="product_id" value="<?php echo $row_product['id']; ?>">
                            <button class="bg-orange-600 text-white px-6 py-2 rounded hover:bg-orange-700">Add to
                                cart</button>
                        </form>
                        <?php
          $product_id=$row_product2['id'];
              $check = mysqli_query($connect, "SELECT * FROM wishlist WHERE email='".$_SESSION['email']."' AND product_id='$product_id'");
              $inWishlist = mysqli_num_rows($check) > 0;
          ?>
                        <form method="POST" action="wishlist-add.php">
                            <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
                            <button class="px-4 py-2 border rounded hover:bg-gray-100">Wishlist</button>
                        </form>
                    </div>
                </div>
            </div>
            <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 bg-white rounded shadow mt-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-4">Product Details</h2>
                <p class="text-gray-700 leading-relaxed">
                    <?php echo $row_product2['description']?>
                </p>
            </section>
            <?php } } ?>








            <!-- Related Products SAME DESIGN AS INDEX -->
            <div class="mt-12">
                <h3 class="font-bold text-xl mb-4">Related Products</h3>
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                    <?php 
        $select_cate=mysqli_query($connect,"SELECT * FROM product WHERE id='$id'");
        $row_cate=mysqli_fetch_assoc($select_cate);
        $sub_category=$row_cate['subcategory'];
        $select_sub=mysqli_query($connect,"SELECT * FROM `sub-category` WHERE name_parentname='$sub_category' AND status='1' ORDER BY RAND()LIMIT 4");
        while($row_sub_cate=mysqli_fetch_assoc($select_sub)){
        ?>
                    <a href="shop.php?id=<?php echo $row_sub_cate['id']?>"
                        class="border rounded p-2 text-center hover:shadow">
                        <img src="images/<?php echo $row_sub_cate['image']?>" class="w-full h-28 object-cover rounded">
                        <p class="mt-2 text-sm"><?php echo $row_sub_cate['name']?></p>
                    </a>
                    <?php }?>

                </div>
            </div>
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

        <script>
        // Profile toggle
        document.getElementById('profileBtn').addEventListener('click', () => {
            document.getElementById('profileMenu').classList.toggle('hidden');
        });
        // Mobile menu toggle
        document.getElementById('menuBtn').addEventListener('click', () => {
            document.getElementById('mobileMenu').classList.toggle('hidden');
        });
        // Thumbnail gallery
        const thumbs = document.querySelectorAll('.thumb');
        const mainImg = document.getElementById('mainImg');
        thumbs.forEach(t => t.addEventListener('click', () => {
            mainImg.src = t.dataset.src;
        }));
        </script>
    </body>

</html>