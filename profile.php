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
$email=$_SESSION['email'];
include("connection.php");
$connect=connection();
$select_user=mysqli_query($connect,"SELECT * FROM `cu-signup` WHERE email='$email'");
$row_user=mysqli_fetch_assoc($select_user);
if(isset($_POST['save'])){
  $name=$_POST['name'];
  $user=str_replace(" ","_",strtolower($name));
  $rand_user=rand(100,999);
  $username=$user."_".$rand_user;
  $phone=$_POST['phone'];
  $dob=$_POST['dob'];
  $address=$_POST['address'];
  $city=$_POST['city'];
  $postal_code=$_POST['postal_code'];
  $id=$row_user['id'];
  $old_img=$row_user['image'];
  $select_phone=mysqli_query($connect,"SELECT * FROM `cu-signup` WHERE phone='$phone' AND id !='$id'");

  if(mysqli_num_rows($select_phone)>0){
    echo "<script>alert('Phone is already registered!');
    window.location.href='profile.php';
    </script>";
    exit();
  }
  else{
if(!empty($_POST['password'])){
    $password = $_POST['password'];
    $cpassword = $_POST['cpassword'];

    if(strlen($password) < 4 || strlen($password) > 8){
        echo "<script>alert('Password must be between 4 and 8 characters!'); window.location.href='profile.php';</script>";
        exit();
    }
    if($password !== $cpassword){
        echo "<script>alert('Password and Confirm Password do not match!'); window.location.href='profile.php';</script>";
        exit();
    }
    $passwordhash = password_hash($password, PASSWORD_DEFAULT);
} else {
    // agar password blank hai to DB me waise hi rahe
    $passwordhash = $row_user['password'];
}


    if(isset($_FILES['img'])&& $_FILES['img']['error']==0){
      $img_name=$_FILES['img']['name'];
      $img_tmp=$_FILES['img']['tmp_name'];
      $path=pathinfo($img_name,PATHINFO_EXTENSION);
      $rand=rand(100,999);
      $new_name=pathinfo($img_name,PATHINFO_FILENAME)."_".$rand.".".$path;
      $img="images/".$old_img;
      move_uploaded_file($img_tmp,"images/".$new_name);
      if(file_exists($img)){
        unlink($img);
      }
      $final_img=$new_name;
    }
    else{
      $final_img=$old_img;
    }
    $update=mysqli_query($connect,"UPDATE `cu-signup` SET  `name`='$name',`phone`='$phone',`dob`='$dob',`image`='$final_img',`password`='$passwordhash',`address`='$address',`city`='$city',`postal-code`='$postal_code',`username`='$username'  WHERE id='$id'");
    if($update){
      $_SESSION['email'] = $email;
      echo "<script>
        alert('Profile data updated successfully!');
        window.location.href='profile.php'; 
    </script>";
    }
    else{
      echo "<script>
        alert('Update failed! Please try again.');
        window.location.href='profile.php';
    </script>";
}
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mehdi Mart - Profile</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>

<body class="bg-gray-50 text-gray-900">

    <!-- HEADER -->

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

        <!-- MAIN CONTENT -->
        <main class="max-w-7xl mx-auto px-4 py-8 grid grid-cols-1 md:grid-cols-4 gap-6">

            <!-- SIDEBAR -->
            <aside class="md:col-span-1 bg-white p-4 rounded shadow">
                <div class="flex items-center gap-4">
                    <img src="images/<?php echo $row_user['image']?>" class="w-20 h-20 rounded-full">
                    <div>
                        <h3 class="font-bold"><?php echo $row_user['name']?></h3>
                        <p class="text-sm text-gray-500"><?php echo $row_user['username']?></p>
                    </div>
                </div>
                <div class="mt-4">
                    <button id="toggleEditSidebar"
                        class="w-full bg-orange-600 text-white py-2 rounded hover:bg-orange-700 text-sm">Update
                        Info</button>
                </div>

            </aside>

            <!-- PROFILE + ORDERS + WISHLIST -->
            <section class="md:col-span-3 space-y-8">

                <!-- PROFILE INFO -->
                <div id="profileSection" class="bg-white p-6 rounded shadow">
                    <h2 class="font-bold text-lg mb-2 flex justify-between items-center">
                        Profile Info
                        <button id="editToggle"
                            class="bg-orange-600 text-white px-3 py-1 rounded hover:bg-orange-700 text-sm">Update
                            Info</button>
                    </h2>

                    <!-- Edit Form -->
                    <div id="editForm" class="hidden mt-4 space-y-3">
                        <form method="POST" enctype="multipart/form-data">
                            <label class="flex items-center gap-2 cursor-pointer">
                                <span>Full Name</span></label>
                            <input type="text" value="<?php echo $row_user['name']?>"
                                class="w-full border rounded px-3 py-2" name="name">
                            <label class="flex items-center gap-2 cursor-pointer">
                                <span>E-mail</span></label>
                            <input type="email" readonly
                                class="w-full border rounded px-3 py-2 bg-gray-100 cursor-not-allowed"
                                value="<?php echo $row_user['email']?>" name="email">
                            <label class="flex items-center gap-2 cursor-pointer">
                                <span>Phone</span></label>
                            <input type="text" class="w-full border rounded px-3 py-2"
                                value="<?php echo $row_user['phone']?>" name="phone">

                            <label class="flex items-center gap-2 cursor-pointer">
                                <span>Date Of Birth</span></label>
                            <input type="date" value="<?php echo $row_user['dob']?>"
                                class="w-full border rounded px-3 py-2" value="Karachi, Pakistan" name="dob">
                            <label class="flex items-center gap-2 cursor-pointer">
                                <span>Address</span></label>
                            <input type="text" class="w-full border rounded px-3 py-2"
                                value="<?php echo $row_user['address']?>" name="address">
                            <label class="flex items-center gap-2 cursor-pointer">
                                <span>City</span></label>
                            <input type="text" class="w-full border rounded px-3 py-2"
                                value="<?php echo $row_user['city']?>" name="city">
                            <label class="flex items-center gap-2 cursor-pointer">
                                <span>Postal Code</span></label>
                            <input type="text" class="w-full border rounded px-3 py-2"
                                value="<?php echo $row_user['postal-code']?>" name="postal_code">
                            <label class="flex items-center gap-2 cursor-pointer">
                                <span>Password</span></label>
                            <input type="password" placeholder="••••••••" class="w-full border rounded px-3 py-2"
                                name="password">
                            <label class="flex items-center gap-2 cursor-pointer">
                                <span>Confirm Password</span></label>
                            <input type="password" placeholder="••••••••" class="w-full border rounded px-3 py-2"
                                name="cpassword">
                            <div class="flex items-center gap-3">
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <span>Profile Picture</span>
                                    <input type="file" name="img" class="hidden" id="profilePic">
                                </label>
                            </div>
                            <button type="submit" name="save"
                                class="bg-orange-600 text-white px-4 py-2 rounded hover:bg-orange-700">Save
                                Changes</button>
                    </div>
                    </form>
                    <!-- Display Info -->
                    <div id="displayInfo" class="mt-4 grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                        <div><strong>Full Name:</strong> <?php echo $row_user['name']?></div>
                        <div><strong>Email:</strong> <?php echo $row_user['email']?></div>
                        <div><strong>Phone:</strong> <?php echo $row_user['phone']?></div>
                        <div><strong>Address:</strong> <?php echo $row_user['address']?></div>
                        <div><strong>City:</strong> <?php echo $row_user['city']?></div>
                        <div><strong>Postal Code:</strong> <?php echo $row_user['postal-code']?></div>
                        <div><strong>Date Of Birth:</strong> <?php echo $row_user['dob']?></div>
                    </div>
                </div>

                <!-- ORDERS -->
                <div id="ordersSection" class="bg-white p-6 rounded shadow">
                    <h2 class="font-bold text-lg mb-4">Order History</h2>
                    <div class="space-y-4">


                        <?php
        $select_order=mysqli_query($connect,"SELECT * FROM  `order` WHERE useremail='$email'");
        while($row_order=mysqli_fetch_assoc($select_order)){
          if($row_order){
            $product_id=$row_order['product_id'];
            $select_order_product=mysqli_query($connect,"SELECT * FROM product WHERE id='$product_id'");
            $row_order_product=mysqli_fetch_assoc($select_order_product);
        ?>
                        <div class="border rounded-2xl p-5 bg-white shadow-md hover:shadow-lg transition mb-4">
                            <div class="flex flex-col md:flex-row gap-4">

                                <!-- Product Image -->
                                <img src="images/<?php echo $row_order_product['image']?>"
                                    class="w-28 h-28 object-cover rounded-lg border">

                                <!-- Order Details -->
                                <div class="flex-1">
                                    <!-- Order Header -->
                                    <div class="flex justify-between items-center mb-2">
                                        <p class="font-semibold text-gray-800 text-lg"><?php echo $row_order['id']?></p>
                                        <?php if($row_order['status']=='0'){
          ?>
                                        <span
                                            class="text-sm px-3 py-1 rounded-full bg-yellow-100 text-yellow-700 font-medium">
                                            Pending
                                        </span>
                                        <?php }else if($row_order['status']==1){?>
                                        <span
                                            class="text-sm px-3 py-1 rounded-full bg-green-100 text-green-700 font-medium">
                                            Confirmed
                                        </span>
                                        <?php } else if($row_order['status']==2){?>
                                        <span
                                            class="text-sm px-3 py-1 rounded-full bg-blue-100 text-blue-700 font-medium">
                                            Shipped
                                        </span>
                                        <?php } else if($row_order['status']==3){?>
                                        <span
                                            class="text-sm px-3 py-1 rounded-full bg-green-100 text-green-700 font-medium">
                                            Delivered
                                        </span>
                                        <?php } else if($row_order['status']==4){?>
                                        <span
                                            class="text-sm px-3 py-1 rounded-full bg-red-100 text-red-700 font-medium">
                                            Cancelled
                                        </span>
                                        <?php } else if($row_order['status']==5){?>
                                        <span
                                            class="text-sm px-3 py-1 rounded-full bg-gray-100 text-gray-700 font-medium">
                                            Delivery Failed
                                        </span>
                                        <?php } else{?>
                                        <span
                                            class="text-sm px-3 py-1 rounded-full bg-purple-100 text-purple-700 font-medium">
                                            Returned
                                        </span>
                                        <?php }?>
                                    </div>

                                    <!-- Product & Quantity -->
                                    <p class="text-sm text-gray-700"><strong>Product:</strong>
                                        <?php echo $row_order_product['name']?></p>
                                    <p class="text-sm text-gray-700"><strong>Quantity:</strong>
                                        <?php echo $row_order['quantity']?></p>
                                    <p class="text-sm text-gray-700"><strong>Total Price:</strong>
                                        <?php echo $row_order['totalprice']?></p>

                                    <!-- Payment & Shipping -->
                                    <?php if($row_order['peyment']==0){?>
                                    <p class="text-sm text-gray-700"><strong>Payment Method:</strong> Cash on Delivery
                                    </p>
                                    <?php } else if($row_order['peyment']==1){?>
                                    <p class="text-sm text-gray-700"><strong>Payment Method:</strong> Credit/Debit Card
                                    </p>
                                    <?php } else{?>
                                    <p class="text-sm text-gray-700"><strong>Payment Method:</strong> PayPal</p>
                                    <?php }?>
                                    <p class="text-sm text-gray-700"><strong>Shipping Address:</strong>
                                        <?php echo $row_order['address']?></p>

                                    <!-- Date -->
                                </div>

                                <!-- Action Section -->
                                <div class="flex flex-col justify-between items-end">
                                    <div class="flex flex-col justify-between items-end">
                                        <?php if ($row_order['status'] == 0 || $row_order['status'] == 1){ ?>
                                        <!-- Cancel Button (Only if pending or confirmed) -->
                                        <form method="POST" action="delete-order.php"
                                            onsubmit="return confirm('Are you sure you want to cancel this order?');">
                                            <button value="<?php echo $row_order['id']?>" type="submit" name="order_id"
                                                class="bg-orange-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg text-sm shadow">
                                                Cancel Order
                                            </button>
                                        </form>
                                        <?php } else { ?>
                                        <!-- Disabled Status Button -->
                                        <button
                                            class="bg-gray-400 text-white px-4 py-2 rounded-lg text-sm shadow cursor-not-allowed mb-2"
                                            disabled>
                                            <?php
        if ($row_order['status'] == 2) echo "Shipped";
        elseif ($row_order['status'] == 3) echo "Delivered";
        elseif ($row_order['status'] == 4) echo "Cancelled";
        elseif ($row_order['status'] == 5) echo "Failed";
        else echo "Returned";
      ?>
                                        </button>
                                        <?php } ?>
                                    </div>


                                </div>

                            </div>
                        </div>
                        <?php } } ?>

                    </div>
                </div>

                <!-- WISHLIST -->
                <div id="wishlistSection" class="bg-white p-6 rounded shadow">
                    <h2 class="font-bold text-lg mb-4">Wishlist</h2>
                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
                        <?php
            $select_wish=mysqli_query($connect,"SELECT * FROM wishlist WHERE email='".$_SESSION['email']."'");
            
            while($row_wish=mysqli_fetch_assoc($select_wish)){
              $select_product=mysqli_query($connect,"SELECT * FROM product WHERE id='{$row_wish['product_id']}'");
              if($row_product=mysqli_fetch_assoc($select_product)){
  ?>

                        <a href="wishlist.php" class="border rounded p-2 text-center hover:shadow">
                            <img src="images/<?php echo $row_product['image']?>"
                                class="w-full h-24 object-cover rounded">
                            <p class="mt-2 text-sm"><?php echo $row_product['name']?></p>
                        </a>
                        <?php } } ?>
                    </div>
                </div>

            </section>
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
        // Profile toggle
        const profileBtn = document.getElementById('profileBtn');
        const profileMenu = document.getElementById('profileMenu');
        profileBtn.addEventListener('click', () => {
            profileMenu.classList.toggle('hidden');
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

        // Profile edit form toggle
        const editToggle = document.getElementById('editToggle');
        const editForm = document.getElementById('editForm');
        editToggle.addEventListener('click', () => {
            editForm.classList.toggle('hidden');
        });

        // Sidebar update toggle
        const toggleEditSidebar = document.getElementById('toggleEditSidebar');
        toggleEditSidebar.addEventListener('click', () => {
            editForm.classList.toggle('hidden');
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
        </script>

    </body>

</html>