<?php
session_start();
include("../connection.php");
$connect=connection();
if(!isset($_SESSION['email_admin'])&&!isset($_SESSION['username'])){
        echo "<script>
            alert('Please login first!');
            window.location.href='login.php';
          </script>";
  exit();
}
if(isset($_POST['logout'])){
    unset($_SESSION['email_admin']);
    unset($_SESSION['username']);
    echo"<script> alert('You have been logged out successfully!');
    window.location.href='login.php';
    </script>
    ";
}
$select_admin=mysqli_query($connect,"SELECT * FROM `admin`");
$row_admin=mysqli_fetch_assoc($select_admin);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Profile - Mehdi Mart</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
</head>
<body class="bg-gray-100">

<!-- SIDEBAR -->
<aside class="fixed top-0 left-0 h-full w-64 bg-white shadow-md hidden md:block">
  <div class="p-6">
    <a href="index.php" class="text-2xl font-bold text-orange-600">Mehdi Mart</a>
  </div>

  <div class="h-[calc(100%-80px)] overflow-y-auto">
          <nav class="mt-2">
        <a href="index.php" class="block py-3 px-6 hover:bg-orange-100 rounded flex items-center gap-3"><i class="fas fa-chart-line w-5"></i> Dashboard</a>
        <a href="all-products.php" class="block py-3 px-6 hover:bg-orange-100 rounded flex items-center gap-3"><i class="fas fa-box w-5"></i> Products</a>
        <a href="add-product.php" class="block py-3 px-6 hover:bg-orange-100 rounded flex items-center gap-3"><i class="fas fa-plus w-5"></i> Add Product</a>
        <a href="slider.php" class="block py-3 px-6 hover:bg-orange-100 rounded flex items-center gap-3"><i class="fas fa-image w-5"></i> Add Slider</a><a href="add-category.php" class="block py-3 px-6 hover:bg-orange-100 rounded flex items-center gap-3"><i class="fas fa-folder"></i> Add Category</a>
        <a href="sub_category.php" class="block py-3 px-6 hover:bg-orange-100 rounded flex items-center gap-3"><i class="fas fa-folder-open w-5"></i> Sub Categories</a>
        <a href="orders.php" class="block py-3 px-6 hover:bg-orange-100 rounded flex items-center gap-3"><i class="fas fa-shopping-cart w-5"></i> Orders</a>
        <a href="customers.php" class="block py-3 px-6 hover:bg-orange-100 rounded flex items-center gap-3"><i class="fas fa-users w-5"></i> Customers</a>
        <a href="messages.php" class="block py-3 px-6 hover:bg-orange-100 rounded flex items-center gap-3"><i class="fas fa-envelope w-5"></i> Messages</a>
      </nav>
  </div>
</aside>

<!-- MAIN CONTENT -->
<div class="md:ml-64 p-6">

  <!-- HEADER -->
  <header class="flex justify-between items-center mb-6">
    <h1 class="text-3xl font-bold text-gray-800">Admin Profile</h1>
    <div class="flex items-center gap-4">
      <div class="flex items-center gap-2 cursor-pointer">
          <a href="profile.php">

          <img src="../images/<?php echo $row_admin['image']?>" class="w-8 h-8 rounded-full" alt="Admin"></a><a href="profile.php">
          <span class="hidden sm:inline"><?php echo $row_admin['name']?></span></a>
        </div><form method="POST">
                  <button name="logout" type="submit" class="relative">
            <i class="fas fa-sign-out-alt text-xl"></i>

            <span class="hidden sm:inline">LOGOUT</span>
          </button></form>
    </div>
  </header>

  <!-- PROFILE CARD -->
  <div class="bg-white shadow rounded-lg p-8 max-w-3xl mx-auto">
    <div class="flex flex-col md:flex-row items-center gap-6">
      <img src="../images/<?php echo $row_admin['image']?>" class="w-32 h-32 rounded-full border-4 border-orange-500" alt="Profile Picture">

      <div class="flex-1 w-full">
        <h2 class="text-2xl font-bold text-gray-800 mb-4">Profile Details</h2>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
          <div>
            <label class="text-sm font-semibold text-gray-600">Full Name</label>
            <p class="mt-1 bg-gray-50 border rounded-lg px-4 py-2 text-gray-800"><?php echo $row_admin['name']?></p>
          </div>
          
          <div>
            <label class="text-sm font-semibold text-gray-600">Username</label>
            <p class="mt-1 bg-gray-50 border rounded-lg px-4 py-2 text-gray-800"><?php echo $row_admin['username']?></p>
          </div>
        </div>
        <div class="mt-6 border-t pt-4">
            <label class="text-sm font-semibold text-gray-600">Email Address</label>
            <p class="mt-1 bg-gray-50 border rounded-lg px-4 py-2 text-gray-800"><?php echo $row_admin['email']?></p>
          </div>
      </div>
    </div>
  </div>

</div>

</body>
</html>
