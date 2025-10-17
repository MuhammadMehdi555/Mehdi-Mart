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
$select_total_order=mysqli_query($connect,"SELECT * FROM `order`");
$row_total_order=mysqli_num_rows($select_total_order);
$select_pending=mysqli_query($connect,"SELECT * FROM `order` WHERE status='0'");
$row_pending=mysqli_num_rows($select_pending);
$select_confirmed=mysqli_query($connect,"SELECT * FROM `order` WHERE status='1'");
$row_confirmed=mysqli_num_rows($select_confirmed);
$select_shipped=mysqli_query($connect,"SELECT * FROM `order` WHERE status='2'");
$row_shipped=mysqli_num_rows($select_shipped);
$select_delivered=mysqli_query($connect,"SELECT * FROM `order` WHERE status='3'");
$row_delivered=mysqli_num_rows($select_delivered);
$select_cancelled=mysqli_query($connect,"SELECT * FROM `order` WHERE status='4'");
$row_cancelled=mysqli_num_rows($select_cancelled);
$select_failed=mysqli_query($connect,"SELECT * FROM `order` WHERE status='5'");
$row_failed=mysqli_num_rows($select_failed);
$select_returned=mysqli_query($connect,"SELECT * FROM `order` WHERE status='6'");
$row_returned=mysqli_num_rows($select_returned);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Mehdi Mart - Orders</title>
<script src="https://cdn.tailwindcss.com"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
</head>
<body class="bg-gray-100">

<!-- SIDEBAR -->
<!-- SIDEBAR -->
<aside class="fixed top-0 left-0 h-full w-64 bg-white shadow-md hidden md:block">
  <div class="p-6">
    <a href="index.php" class="text-2xl font-bold text-orange-600">Mehdi Mart</a>
  </div>

  <!-- yaha scroll enable kiya -->
  <div class="h-[calc(100%-80px)] overflow-y-auto">
          <nav class="mt-2">
        <a href="index.php" class="block py-3 px-6 hover:bg-orange-100 rounded flex items-center gap-3"><i class="fas fa-chart-line w-5"></i> Dashboard</a>
        <a href="all-products.php" class="block py-3 px-6 hover:bg-orange-100 rounded flex items-center gap-3"><i class="fas fa-box w-5"></i> Products</a>
        <a href="add-product.php" class="block py-3 px-6 hover:bg-orange-100 rounded flex items-center gap-3"><i class="fas fa-plus w-5"></i> Add Product</a>
        <a href="slider.php" class="block py-3 px-6 hover:bg-orange-100 rounded flex items-center gap-3"><i class="fas fa-image w-5"></i> Add Slider</a><a href="add-category.php" class="block py-3 px-6 hover:bg-orange-100 rounded flex items-center gap-3"><i class="fas fa-folder"></i> Add Category</a>
        <a href="sub_category.php" class="block py-3 px-6 hover:bg-orange-100 rounded flex items-center gap-3"><i class="fas fa-folder-open w-5"></i> Sub Categories</a>
        <a href="orders.php" class="block py-3 px-6 bg-orange-100 rounded flex items-center gap-3"><i class="fas fa-shopping-cart w-5"></i> Orders</a>
        <a href="customers.php" class="block py-3 px-6 hover:bg-orange-100 rounded flex items-center gap-3"><i class="fas fa-users w-5"></i> Customers</a>
        <a href="messages.php" class="block py-3 px-6 hover:bg-orange-100 rounded flex items-center gap-3"><i class="fas fa-envelope w-5"></i> Messages</a>
      </nav>
  </div>
</aside>


<!-- MAIN CONTENT -->
<div class="md:ml-64 p-6">

  <!-- HEADER -->
<header class="flex justify-between items-center mb-6">
      <h1 class="text-3xl font-bold text-gray-800">Dashboard</h1>
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
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
      <div class="bg-white shadow rounded p-4">
        <h3 class="text-sm font-semibold text-gray-500">Total Orders</h3>
        <p class="text-2xl font-bold text-gray-800"><?php echo $row_total_order?></p>
      </div>
      <div class="bg-white shadow rounded p-4">
        <h3 class="text-sm font-semibold text-gray-500">Pending Orders</h3>
        <p class="text-2xl font-bold text-green-700"><?php echo $row_pending?></p>
      </div>
      <div class="bg-white shadow rounded p-4">
        <h3 class="text-sm font-semibold text-gray-500">Confirmed Orders</h3>
        <p class="text-2xl font-bold text-yellow-700"><?php echo $row_confirmed?></p>
      </div>
      <div class="bg-white shadow rounded p-4">
        <h3 class="text-sm font-semibold text-gray-500">Shipped Orders</h3>
        <p class="text-2xl font-bold text-red-700"><?php echo $row_shipped?></p>
      </div>
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
      <div class="bg-white shadow rounded p-4">
        <h3 class="text-sm font-semibold text-gray-500">Delivered Orders</h3>
        <p class="text-2xl font-bold text-gray-800"><?php echo $row_delivered?></p>
      </div>
      <div class="bg-white shadow rounded p-4">
        <h3 class="text-sm font-semibold text-gray-500">Cancelled Orders</h3>
        <p class="text-2xl font-bold text-green-700"><?php echo $row_cancelled?></p>
      </div>
      <div class="bg-white shadow rounded p-4">
        <h3 class="text-sm font-semibold text-gray-500">Failed Orders</h3>
        <p class="text-2xl font-bold text-yellow-700"><?php echo $row_failed?></p>
      </div>
      <div class="bg-white shadow rounded p-4">
        <h3 class="text-sm font-semibold text-gray-500">Returned Orders</h3>
        <p class="text-2xl font-bold text-red-700"><?php echo $row_returned?></p>
      </div>
    </div>
  <!-- pending-->
  <div class="bg-white shadow rounded p-4">
    <h2 class="text-xl font-bold mb-4">Pending Orders</h2>
    <div class="overflow-x-auto">
      <table class="min-w-full border">
        <thead class="bg-gray-100">
          <tr>
            <th class="px-4 py-2 text-left">Order ID</th>
            <th class="px-4 py-2 text-left">Customer</th>
            <th class="px-4 py-2 text-left">Customer ID</th>
            <th class="px-4 py-2 text-left">Products</th>
            <th class="px-4 py-2 text-left">Category</th>
            <th class="px-4 py-2 text-left">Total</th>
            <th class="px-4 py-2 text-left">Payment</th>
            <th class="px-4 py-2 text-left">Delivery</th>
            <th class="px-4 py-2 text-left">Actions</th>
          </tr>
        </thead>
        <tbody>
          <!-- Example Order Row -->
           <?php
           while($row_order_pending=mysqli_fetch_assoc($select_pending)){
            if($row_order_pending){
              $select_product_id=mysqli_query($connect,"SELECT * FROM `product` WHERE id='".$row_order_pending['product_id']."'");
              $row_product_id=mysqli_fetch_assoc($select_product_id);
              if($row_product_id){
              $select_customer_id=mysqli_query($connect,"SELECT * FROM `cu-signup` WHERE email='".$row_order_pending['useremail']."'");
              $row_customer_id=mysqli_fetch_assoc($select_customer_id);
              if($row_customer_id){
           ?>
          <tr class="hover:bg-gray-50">
            <td class="px-4 py-2"><?php echo $row_order_pending['id']?></td>
            <td class="px-4 py-2 flex items-center gap-2"><img src="../images/<?php echo $row_customer_id['image']?>" class="w-6 h-6 rounded-full"> <?php echo $row_customer_id['name']?></td>
            <td class="px-4 py-2"><?php echo $row_customer_id['id']?></td>
              <td class="px-4 py-2 flex items-center gap-2"><?php echo $row_product_id['name']?>
              <img src="../images/<?php echo $row_product_id['image']?>" class="w-6 h-6 rounded">
            </td>
            <td class="px-4 py-2"><?php echo $row_product_id['subcategory']?></td>
            <td class="px-4 py-2">PKR: <?php echo $row_order_pending['totalprice']?></td>
            <?php if($row_order_pending['peyment']==0){?>
            <td class="px-4 py-2"><span class="px-2 py-1 rounded text-xs bg-green-100 text-green-800">Cash on Delivery</span></td>
            <?php } else if($row_order_pending['peyment']==1){?>            
            <td class="px-4 py-2"><span class="px-2 py-1 rounded text-xs bg-green-100 text-green-800">Credit/Debit Card</span></td>
            <?php } else {?>
            <td class="px-4 py-2"><span class="px-2 py-1 rounded text-xs bg-green-100 text-green-800">PayPal</span></td>
            <?php }?>
            <td class="px-4 py-2"><span class="px-2 py-1 rounded text-xs bg-yellow-100 text-yellow-800">Pending</span></td>
            <td class="px-4 py-2 flex gap-2">
             <!-- 🟡 Pending -->
<button class="px-2 py-1 bg-yellow-500 text-white rounded text-xs hover:bg-yellow-600"><a href="status.php?id=<?php echo $row_order_pending['id']?>&status=0&type=order">Pending</a></button>

<!-- 🟢 Confirmed -->
<button class="px-2 py-1 bg-green-600 text-white rounded text-xs hover:bg-green-700"><a href="status.php?id=<?php echo $row_order_pending['id']?>&status=1&type=order">Confirmed</a></button>

<!-- 🔵 Shipped -->
<button class="px-2 py-1 bg-blue-600 text-white rounded text-xs hover:bg-blue-700"><a href="status.php?id=<?php echo $row_order_pending['id']?>&status=2&type=order">Shipped</a></button>

<!-- 🟢 Delivered -->
<button class="px-2 py-1 bg-green-500 text-white rounded text-xs hover:bg-green-600"><a href="status.php?id=<?php echo $row_order_pending['id']?>&status=3&type=order">Delivered</a></button>

<!-- 🔴 Cancelled -->
<button class="px-2 py-1 bg-red-600 text-white rounded text-xs hover:bg-red-700"><a href="status.php?id=<?php echo $row_order_pending['id']?>&status=4&type=order">Cancelled</a></button>

<!-- ⚫ Failed -->
<button class="px-2 py-1 bg-gray-700 text-white rounded text-xs hover:bg-gray-800"><a href="status.php?id=<?php echo $row_order_pending['id']?>&status=5&type=order">Failed</a></button>

<!-- 🟣 Returned -->
<button class="px-2 py-1 bg-purple-600 text-white rounded text-xs hover:bg-purple-700"><a href="status.php?id=<?php echo $row_order_pending['id']?>&status=6&type=order">Returned</a></button>

              <button class="px-2 py-1 bg-red-600 text-white rounded text-xs hover:bg-red-700"><a href="status.php?id=<?php echo $row_order_pending['id']?>&type=order_delete">Delete</button>
            </td>
          </tr>
          <?php }}} }?>
        </tbody>
      </table>
    </div>
  </div>

  <br>
  <div class="bg-white shadow rounded p-4">
    <h2 class="text-xl font-bold mb-4">Confirmed Orders</h2>
    <div class="overflow-x-auto">
      <table class="min-w-full border">
        <thead class="bg-gray-100">
          <tr>
            <th class="px-4 py-2 text-left">Order ID</th>
            <th class="px-4 py-2 text-left">Customer</th>
            <th class="px-4 py-2 text-left">Customer ID</th>
            <th class="px-4 py-2 text-left">Products</th>
            <th class="px-4 py-2 text-left">Category</th>
            <th class="px-4 py-2 text-left">Total</th>
            <th class="px-4 py-2 text-left">Payment</th>
            <th class="px-4 py-2 text-left">Delivery</th>
            <th class="px-4 py-2 text-left">Actions</th>
          </tr>
        </thead>
        <tbody>
          <!-- Example Order Row -->
           <?php
           while($row_order_confirmed=mysqli_fetch_assoc($select_confirmed)){
            if($row_order_confirmed){
              $select_product_id=mysqli_query($connect,"SELECT * FROM `product` WHERE id='".$row_order_confirmed['product_id']."'");
              $row_product_id=mysqli_fetch_assoc($select_product_id);
              if($row_product_id){
              $select_customer_id=mysqli_query($connect,"SELECT * FROM `cu-signup` WHERE email='".$row_order_confirmed['useremail']."'");
              $row_customer_id=mysqli_fetch_assoc($select_customer_id);
              if($row_customer_id){
           ?>
          <tr class="hover:bg-gray-50">
            <td class="px-4 py-2"><?php echo $row_order_confirmed['id']?></td>
            <td class="px-4 py-2 flex items-center gap-2"><img src="../images/<?php echo $row_customer_id['image']?>" class="w-6 h-6 rounded-full"> <?php echo $row_customer_id['name']?></td>
            <td class="px-4 py-2"><?php echo $row_customer_id['id']?></td>
              <td class="px-4 py-2 flex items-center gap-2"><?php echo $row_product_id['name']?>
              <img src="../images/<?php echo $row_product_id['image']?>" class="w-6 h-6 rounded">
            </td>
            <td class="px-4 py-2"><?php echo $row_product_id['subcategory']?></td>
            <td class="px-4 py-2">PKR: <?php echo $row_order_confirmed['totalprice']?></td>
            <?php if($row_order_confirmed['peyment']==0){?>
            <td class="px-4 py-2"><span class="px-2 py-1 rounded text-xs bg-green-100 text-green-800">Cash on Delivery</span></td>
            <?php } else if($row_order_confirmed['peyment']==1){?>            
            <td class="px-4 py-2"><span class="px-2 py-1 rounded text-xs bg-green-100 text-green-800">Credit/Debit Card</span></td>
            <?php } else {?>
            <td class="px-4 py-2"><span class="px-2 py-1 rounded text-xs bg-green-100 text-green-800">PayPal</span></td>
            <?php }?>
            <td class="px-4 py-2"><span class="px-2 py-1 rounded text-xs bg-yellow-100 text-yellow-800">Confirmed</span></td>
            <td class="px-4 py-2 flex gap-2">
             <!-- 🟡 Pending -->
<button class="px-2 py-1 bg-yellow-500 text-white rounded text-xs hover:bg-yellow-600"><a href="status.php?id=<?php echo $row_order_confirmed['id']?>&status=0&type=order">Pending</a></button>

<!-- 🟢 Confirmed -->
<button class="px-2 py-1 bg-green-600 text-white rounded text-xs hover:bg-green-700"><a href="status.php?id=<?php echo $row_order_confirmed['id']?>&status=1&type=order">Confirmed</a></button>

<!-- 🔵 Shipped -->
<button class="px-2 py-1 bg-blue-600 text-white rounded text-xs hover:bg-blue-700"><a href="status.php?id=<?php echo $row_order_confirmed['id']?>&status=2&type=order">Shipped</a></button>

<!-- 🟢 Delivered -->
<button class="px-2 py-1 bg-green-500 text-white rounded text-xs hover:bg-green-600"><a href="status.php?id=<?php echo $row_order_confirmed['id']?>&status=3&type=order">Delivered</a></button>

<!-- 🔴 Cancelled -->
<button class="px-2 py-1 bg-red-600 text-white rounded text-xs hover:bg-red-700"><a href="status.php?id=<?php echo $row_order_confirmed['id']?>&status=4&type=order">Cancelled</a></button>

<!-- ⚫ Failed -->
<button class="px-2 py-1 bg-gray-700 text-white rounded text-xs hover:bg-gray-800"><a href="status.php?id=<?php echo $row_order_confirmed['id']?>&status=5&type=order">Failed</a></button>

<!-- 🟣 Returned -->
<button class="px-2 py-1 bg-purple-600 text-white rounded text-xs hover:bg-purple-700"><a href="status.php?id=<?php echo $row_order_confirmed['id']?>&status=6&type=order">Returned</a></button>

              <button class="px-2 py-1 bg-red-600 text-white rounded text-xs hover:bg-red-700"><a href="status.php?id=<?php echo $row_order_confirmed['id']?>&type=order_delete">Delete</button>
            </td>
          </tr>
          <?php }}} }?>
        </tbody>
      </table>
    </div>
  </div>

  <br>
  <div class="bg-white shadow rounded p-4">
    <h2 class="text-xl font-bold mb-4">Shipped Orders</h2>
    <div class="overflow-x-auto">
      <table class="min-w-full border">
        <thead class="bg-gray-100">
          <tr>
            <th class="px-4 py-2 text-left">Order ID</th>
            <th class="px-4 py-2 text-left">Customer</th>
            <th class="px-4 py-2 text-left">Customer ID</th>
            <th class="px-4 py-2 text-left">Products</th>
            <th class="px-4 py-2 text-left">Category</th>
            <th class="px-4 py-2 text-left">Total</th>
            <th class="px-4 py-2 text-left">Payment</th>
            <th class="px-4 py-2 text-left">Delivery</th>
            <th class="px-4 py-2 text-left">Actions</th>
          </tr>
        </thead>
        <tbody>
          <!-- Example Order Row -->
           <?php
           while($row_order_shipped=mysqli_fetch_assoc($select_shipped)){
            if($row_order_shipped){
              $select_product_id=mysqli_query($connect,"SELECT * FROM `product` WHERE id='".$row_order_shipped['product_id']."'");
              $row_product_id=mysqli_fetch_assoc($select_product_id);
              if($row_product_id){
              $select_customer_id=mysqli_query($connect,"SELECT * FROM `cu-signup` WHERE email='".$row_order_shipped['useremail']."'");
              $row_customer_id=mysqli_fetch_assoc($select_customer_id);
              if($row_customer_id){
           ?>
          <tr class="hover:bg-gray-50">
            <td class="px-4 py-2"><?php echo $row_order_shipped['id']?></td>
            <td class="px-4 py-2 flex items-center gap-2"><img src="../images/<?php echo $row_customer_id['image']?>" class="w-6 h-6 rounded-full"> <?php echo $row_customer_id['name']?></td>
            <td class="px-4 py-2"><?php echo $row_customer_id['id']?></td>
              <td class="px-4 py-2 flex items-center gap-2"><?php echo $row_product_id['name']?>
              <img src="../images/<?php echo $row_product_id['image']?>" class="w-6 h-6 rounded">
            </td>
            <td class="px-4 py-2"><?php echo $row_product_id['subcategory']?></td>
            <td class="px-4 py-2">PKR: <?php echo $row_order_shipped['totalprice']?></td>
            <?php if($row_order_shipped['peyment']==0){?>
            <td class="px-4 py-2"><span class="px-2 py-1 rounded text-xs bg-green-100 text-green-800">Cash on Delivery</span></td>
            <?php } else if($row_order_shipped['peyment']==1){?>            
            <td class="px-4 py-2"><span class="px-2 py-1 rounded text-xs bg-green-100 text-green-800">Credit/Debit Card</span></td>
            <?php } else {?>
            <td class="px-4 py-2"><span class="px-2 py-1 rounded text-xs bg-green-100 text-green-800">PayPal</span></td>
            <?php }?>
            <td class="px-4 py-2"><span class="px-2 py-1 rounded text-xs bg-yellow-100 text-yellow-800">Shipped</span></td>
            <td class="px-4 py-2 flex gap-2">
             <!-- 🟡 Pending -->
<button class="px-2 py-1 bg-yellow-500 text-white rounded text-xs hover:bg-yellow-600"><a href="status.php?id=<?php echo $row_order_shipped['id']?>&status=0&type=order">Pending</a></button>

<!-- 🟢 Confirmed -->
<button class="px-2 py-1 bg-green-600 text-white rounded text-xs hover:bg-green-700"><a href="status.php?id=<?php echo $row_order_shipped['id']?>&status=1&type=order">Confirmed</a></button>

<!-- 🔵 Shipped -->
<button class="px-2 py-1 bg-blue-600 text-white rounded text-xs hover:bg-blue-700"><a href="status.php?id=<?php echo $row_order_shipped['id']?>&status=2&type=order">Shipped</a></button>

<!-- 🟢 Delivered -->
<button class="px-2 py-1 bg-green-500 text-white rounded text-xs hover:bg-green-600"><a href="status.php?id=<?php echo $row_order_shipped['id']?>&status=3&type=order">Delivered</a></button>

<!-- 🔴 Cancelled -->
<button class="px-2 py-1 bg-red-600 text-white rounded text-xs hover:bg-red-700"><a href="status.php?id=<?php echo $row_order_shipped['id']?>&status=4&type=order">Cancelled</a></button>

<!-- ⚫ Failed -->
<button class="px-2 py-1 bg-gray-700 text-white rounded text-xs hover:bg-gray-800"><a href="status.php?id=<?php echo $row_order_shipped['id']?>&status=5&type=order">Failed</a></button>

<!-- 🟣 Returned -->
<button class="px-2 py-1 bg-purple-600 text-white rounded text-xs hover:bg-purple-700"><a href="status.php?id=<?php echo $row_order_shipped['id']?>&status=6&type=order">Returned</a></button>

              <button class="px-2 py-1 bg-red-600 text-white rounded text-xs hover:bg-red-700"><a href="status.php?id=<?php echo $row_order_shipped['id']?>&type=order_delete">Delete</button>
            </td>
          </tr>
          <?php }}} }?>
        </tbody>
      </table>
    </div>
  </div>



  <br>
  <div class="bg-white shadow rounded p-4">
    <h2 class="text-xl font-bold mb-4">Delivered Orders</h2>
    <div class="overflow-x-auto">
      <table class="min-w-full border">
        <thead class="bg-gray-100">
          <tr>
            <th class="px-4 py-2 text-left">Order ID</th>
            <th class="px-4 py-2 text-left">Customer</th>
            <th class="px-4 py-2 text-left">Customer ID</th>
            <th class="px-4 py-2 text-left">Products</th>
            <th class="px-4 py-2 text-left">Category</th>
            <th class="px-4 py-2 text-left">Total</th>
            <th class="px-4 py-2 text-left">Payment</th>
            <th class="px-4 py-2 text-left">Delivery</th>
            <th class="px-4 py-2 text-left">Actions</th>
          </tr>
        </thead>
        <tbody>
          <!-- Example Order Row -->
           <?php
           while($row_order_delivered=mysqli_fetch_assoc($select_delivered)){
            if($row_order_delivered){
              $select_product_id=mysqli_query($connect,"SELECT * FROM `product` WHERE id='".$row_order_delivered['product_id']."'");
              $row_product_id=mysqli_fetch_assoc($select_product_id);
              if($row_product_id){
              $select_customer_id=mysqli_query($connect,"SELECT * FROM `cu-signup` WHERE email='".$row_order_delivered['useremail']."'");
              $row_customer_id=mysqli_fetch_assoc($select_customer_id);
              if($row_customer_id){
           ?>
          <tr class="hover:bg-gray-50">
            <td class="px-4 py-2"><?php echo $row_order_delivered['id']?></td>
            <td class="px-4 py-2 flex items-center gap-2"><img src="../images/<?php echo $row_customer_id['image']?>" class="w-6 h-6 rounded-full"> <?php echo $row_customer_id['name']?></td>
            <td class="px-4 py-2"><?php echo $row_customer_id['id']?></td>
              <td class="px-4 py-2 flex items-center gap-2"><?php echo $row_product_id['name']?>
              <img src="../images/<?php echo $row_product_id['image']?>" class="w-6 h-6 rounded">
            </td>
            <td class="px-4 py-2"><?php echo $row_product_id['subcategory']?></td>
            <td class="px-4 py-2">PKR: <?php echo $row_order_delivered['totalprice']?></td>
            <?php if($row_order_delivered['peyment']==0){?>
            <td class="px-4 py-2"><span class="px-2 py-1 rounded text-xs bg-green-100 text-green-800">Cash on Delivery</span></td>
            <?php } else if($row_order_delivered['peyment']==1){?>            
            <td class="px-4 py-2"><span class="px-2 py-1 rounded text-xs bg-green-100 text-green-800">Credit/Debit Card</span></td>
            <?php } else {?>
            <td class="px-4 py-2"><span class="px-2 py-1 rounded text-xs bg-green-100 text-green-800">PayPal</span></td>
            <?php }?>
            <td class="px-4 py-2"><span class="px-2 py-1 rounded text-xs bg-yellow-100 text-yellow-800">Delivered</span></td>
            <td class="px-4 py-2 flex gap-2">
             <!-- 🟡 Pending -->
<button class="px-2 py-1 bg-yellow-500 text-white rounded text-xs hover:bg-yellow-600"><a href="status.php?id=<?php echo $row_order_delivered['id']?>&status=0&type=order">Pending</a></button>

<!-- 🟢 Confirmed -->
<button class="px-2 py-1 bg-green-600 text-white rounded text-xs hover:bg-green-700"><a href="status.php?id=<?php echo $row_order_delivered['id']?>&status=1&type=order">Confirmed</a></button>

<!-- 🔵 Shipped -->
<button class="px-2 py-1 bg-blue-600 text-white rounded text-xs hover:bg-blue-700"><a href="status.php?id=<?php echo $row_order_delivered['id']?>&status=2&type=order">Shipped</a></button>

<!-- 🟢 Delivered -->
<button class="px-2 py-1 bg-green-500 text-white rounded text-xs hover:bg-green-600"><a href="status.php?id=<?php echo $row_order_delivered['id']?>&status=3&type=order">Delivered</a></button>

<!-- 🔴 Cancelled -->
<button class="px-2 py-1 bg-red-600 text-white rounded text-xs hover:bg-red-700"><a href="status.php?id=<?php echo $row_order_delivered['id']?>&status=4&type=order">Cancelled</a></button>

<!-- ⚫ Failed -->
<button class="px-2 py-1 bg-gray-700 text-white rounded text-xs hover:bg-gray-800"><a href="status.php?id=<?php echo $row_order_delivered['id']?>&status=5&type=order">Failed</a></button>

<!-- 🟣 Returned -->
<button class="px-2 py-1 bg-purple-600 text-white rounded text-xs hover:bg-purple-700"><a href="status.php?id=<?php echo $row_order_delivered['id']?>&status=6&type=order">Returned</a></button>

              <button class="px-2 py-1 bg-red-600 text-white rounded text-xs hover:bg-red-700"><a href="status.php?id=<?php echo $row_order_delivered['id']?>&type=order_delete">Delete</button>
            </td>
          </tr>
          <?php }}} }?>
        </tbody>
      </table>
    </div>
  </div>



  <br>
  <div class="bg-white shadow rounded p-4">
    <h2 class="text-xl font-bold mb-4">Cancelled Orders</h2>
    <div class="overflow-x-auto">
      <table class="min-w-full border">
        <thead class="bg-gray-100">
          <tr>
            <th class="px-4 py-2 text-left">Order ID</th>
            <th class="px-4 py-2 text-left">Customer</th>
            <th class="px-4 py-2 text-left">Customer ID</th>
            <th class="px-4 py-2 text-left">Products</th>
            <th class="px-4 py-2 text-left">Category</th>
            <th class="px-4 py-2 text-left">Total</th>
            <th class="px-4 py-2 text-left">Payment</th>
            <th class="px-4 py-2 text-left">Delivery</th>
            <th class="px-4 py-2 text-left">Actions</th>
          </tr>
        </thead>
        <tbody>
          <!-- Example Order Row -->
           <?php
           while($row_order_cancelled=mysqli_fetch_assoc($select_cancelled)){
            if($row_order_cancelled){
              $select_product_id=mysqli_query($connect,"SELECT * FROM `product` WHERE id='".$row_order_cancelled['product_id']."'");
              $row_product_id=mysqli_fetch_assoc($select_product_id);
              if($row_product_id){
              $select_customer_id=mysqli_query($connect,"SELECT * FROM `cu-signup` WHERE email='".$row_order_cancelled['useremail']."'");
              $row_customer_id=mysqli_fetch_assoc($select_customer_id);
              if($row_customer_id){
           ?>
          <tr class="hover:bg-gray-50">
            <td class="px-4 py-2"><?php echo $row_order_cancelled['id']?></td>
            <td class="px-4 py-2 flex items-center gap-2"><img src="../images/<?php echo $row_customer_id['image']?>" class="w-6 h-6 rounded-full"> <?php echo $row_customer_id['name']?></td>
            <td class="px-4 py-2"><?php echo $row_customer_id['id']?></td>
              <td class="px-4 py-2 flex items-center gap-2"><?php echo $row_product_id['name']?>
              <img src="../images/<?php echo $row_product_id['image']?>" class="w-6 h-6 rounded">
            </td>
            <td class="px-4 py-2"><?php echo $row_product_id['subcategory']?></td>
            <td class="px-4 py-2">PKR: <?php echo $row_order_cancelled['totalprice']?></td>
            <?php if($row_order_cancelled['peyment']==0){?>
            <td class="px-4 py-2"><span class="px-2 py-1 rounded text-xs bg-green-100 text-green-800">Cash on Delivery</span></td>
            <?php } else if($row_order_cancelled['peyment']==1){?>            
            <td class="px-4 py-2"><span class="px-2 py-1 rounded text-xs bg-green-100 text-green-800">Credit/Debit Card</span></td>
            <?php } else {?>
            <td class="px-4 py-2"><span class="px-2 py-1 rounded text-xs bg-green-100 text-green-800">PayPal</span></td>
            <?php }?>
            <td class="px-4 py-2"><span class="px-2 py-1 rounded text-xs bg-yellow-100 text-yellow-800">Cancelled</span></td>
            <td class="px-4 py-2 flex gap-2">
             <!-- 🟡 Pending -->
<button class="px-2 py-1 bg-yellow-500 text-white rounded text-xs hover:bg-yellow-600"><a href="status.php?id=<?php echo $row_order_cancelled['id']?>&status=0&type=order">Pending</a></button>

<!-- 🟢 Confirmed -->
<button class="px-2 py-1 bg-green-600 text-white rounded text-xs hover:bg-green-700"><a href="status.php?id=<?php echo $row_order_cancelled['id']?>&status=1&type=order">Confirmed</a></button>

<!-- 🔵 Shipped -->
<button class="px-2 py-1 bg-blue-600 text-white rounded text-xs hover:bg-blue-700"><a href="status.php?id=<?php echo $row_order_cancelled['id']?>&status=2&type=order">Shipped</a></button>

<!-- 🟢 Delivered -->
<button class="px-2 py-1 bg-green-500 text-white rounded text-xs hover:bg-green-600"><a href="status.php?id=<?php echo $row_order_cancelled['id']?>&status=3&type=order">Delivered</a></button>

<!-- 🔴 Cancelled -->
<button class="px-2 py-1 bg-red-600 text-white rounded text-xs hover:bg-red-700"><a href="status.php?id=<?php echo $row_order_cancelled['id']?>&status=4&type=order">Cancelled</a></button>

<!-- ⚫ Failed -->
<button class="px-2 py-1 bg-gray-700 text-white rounded text-xs hover:bg-gray-800"><a href="status.php?id=<?php echo $row_order_cancelled['id']?>&status=5&type=order">Failed</a></button>

<!-- 🟣 Returned -->
<button class="px-2 py-1 bg-purple-600 text-white rounded text-xs hover:bg-purple-700"><a href="status.php?id=<?php echo $row_order_cancelled['id']?>&status=6&type=order">Returned</a></button>

              <button class="px-2 py-1 bg-red-600 text-white rounded text-xs hover:bg-red-700"><a href="status.php?id=<?php echo $row_order_cancelled['id']?>&type=order_delete">Delete</button>
            </td>
          </tr>
          <?php }}} }?>
        </tbody>
      </table>
    </div>
  </div>



  <br>
  <div class="bg-white shadow rounded p-4">
    <h2 class="text-xl font-bold mb-4">Delivery Failed Orders</h2>
    <div class="overflow-x-auto">
      <table class="min-w-full border">
        <thead class="bg-gray-100">
          <tr>
            <th class="px-4 py-2 text-left">Order ID</th>
            <th class="px-4 py-2 text-left">Customer</th>
            <th class="px-4 py-2 text-left">Customer ID</th>
            <th class="px-4 py-2 text-left">Products</th>
            <th class="px-4 py-2 text-left">Category</th>
            <th class="px-4 py-2 text-left">Total</th>
            <th class="px-4 py-2 text-left">Payment</th>
            <th class="px-4 py-2 text-left">Delivery</th>
            <th class="px-4 py-2 text-left">Actions</th>
          </tr>
        </thead>
        <tbody>
          <!-- Example Order Row -->
           <?php
           while($row_order_failed=mysqli_fetch_assoc($select_failed)){
            if($row_order_failed){
              $select_product_id=mysqli_query($connect,"SELECT * FROM `product` WHERE id='".$row_order_failed['product_id']."'");
              $row_product_id=mysqli_fetch_assoc($select_product_id);
              if($row_product_id){
              $select_customer_id=mysqli_query($connect,"SELECT * FROM `cu-signup` WHERE email='".$row_order_failed['useremail']."'");
              $row_customer_id=mysqli_fetch_assoc($select_customer_id);
              if($row_customer_id){
           ?>
          <tr class="hover:bg-gray-50">
            <td class="px-4 py-2"><?php echo $row_order_failed['id']?></td>
            <td class="px-4 py-2 flex items-center gap-2"><img src="../images/<?php echo $row_customer_id['image']?>" class="w-6 h-6 rounded-full"> <?php echo $row_customer_id['name']?></td>
            <td class="px-4 py-2"><?php echo $row_customer_id['id']?></td>
              <td class="px-4 py-2 flex items-center gap-2"><?php echo $row_product_id['name']?>
              <img src="../images/<?php echo $row_product_id['image']?>" class="w-6 h-6 rounded">
            </td>
            <td class="px-4 py-2"><?php echo $row_product_id['subcategory']?></td>
            <td class="px-4 py-2">PKR: <?php echo $row_order_failed['totalprice']?></td>
            <?php if($row_order_failed['peyment']==0){?>
            <td class="px-4 py-2"><span class="px-2 py-1 rounded text-xs bg-green-100 text-green-800">Cash on Delivery</span></td>
            <?php } else if($row_order_failed['peyment']==1){?>            
            <td class="px-4 py-2"><span class="px-2 py-1 rounded text-xs bg-green-100 text-green-800">Credit/Debit Card</span></td>
            <?php } else {?>
            <td class="px-4 py-2"><span class="px-2 py-1 rounded text-xs bg-green-100 text-green-800">PayPal</span></td>
            <?php }?>
            <td class="px-4 py-2"><span class="px-2 py-1 rounded text-xs bg-yellow-100 text-yellow-800">Failed</span></td>
            <td class="px-4 py-2 flex gap-2">
             <!-- 🟡 Pending -->
<button class="px-2 py-1 bg-yellow-500 text-white rounded text-xs hover:bg-yellow-600"><a href="status.php?id=<?php echo $row_order_failed['id']?>&status=0&type=order">Pending</a></button>

<!-- 🟢 Confirmed -->
<button class="px-2 py-1 bg-green-600 text-white rounded text-xs hover:bg-green-700"><a href="status.php?id=<?php echo $row_order_failed['id']?>&status=1&type=order">Confirmed</a></button>

<!-- 🔵 Shipped -->
<button class="px-2 py-1 bg-blue-600 text-white rounded text-xs hover:bg-blue-700"><a href="status.php?id=<?php echo $row_order_failed['id']?>&status=2&type=order">Shipped</a></button>

<!-- 🟢 Delivered -->
<button class="px-2 py-1 bg-green-500 text-white rounded text-xs hover:bg-green-600"><a href="status.php?id=<?php echo $row_order_failed['id']?>&status=3&type=order">Delivered</a></button>

<!-- 🔴 Cancelled -->
<button class="px-2 py-1 bg-red-600 text-white rounded text-xs hover:bg-red-700"><a href="status.php?id=<?php echo $row_order_failed['id']?>&status=4&type=order">Cancelled</a></button>

<!-- ⚫ Failed -->
<button class="px-2 py-1 bg-gray-700 text-white rounded text-xs hover:bg-gray-800"><a href="status.php?id=<?php echo $row_order_failed['id']?>&status=5&type=order">Failed</a></button>

<!-- 🟣 Returned -->
<button class="px-2 py-1 bg-purple-600 text-white rounded text-xs hover:bg-purple-700"><a href="status.php?id=<?php echo $row_order_failed['id']?>&status=6&type=order">Returned</a></button>

              <button class="px-2 py-1 bg-red-600 text-white rounded text-xs hover:bg-red-700"><a href="status.php?id=<?php echo $row_order_failed['id']?>&type=order_delete">Delete</button>
            </td>
          </tr>
          <?php }}} }?>
        </tbody>
      </table>
    </div>
  </div>




  <br>
  <div class="bg-white shadow rounded p-4">
    <h2 class="text-xl font-bold mb-4">Returned Orders</h2>
    <div class="overflow-x-auto">
      <table class="min-w-full border">
        <thead class="bg-gray-100">
          <tr>
            <th class="px-4 py-2 text-left">Order ID</th>
            <th class="px-4 py-2 text-left">Customer</th>
            <th class="px-4 py-2 text-left">Customer ID</th>
            <th class="px-4 py-2 text-left">Products</th>
            <th class="px-4 py-2 text-left">Category</th>
            <th class="px-4 py-2 text-left">Total</th>
            <th class="px-4 py-2 text-left">Payment</th>
            <th class="px-4 py-2 text-left">Delivery</th>
            <th class="px-4 py-2 text-left">Actions</th>
          </tr>
        </thead>
        <tbody>
          <!-- Example Order Row -->
           <?php
           while($row_order_returned=mysqli_fetch_assoc($select_returned)){
            if($row_order_returned){
              $select_product_id=mysqli_query($connect,"SELECT * FROM `product` WHERE id='".$row_order_returned['product_id']."'");
              $row_product_id=mysqli_fetch_assoc($select_product_id);
              if($row_product_id){
              $select_customer_id=mysqli_query($connect,"SELECT * FROM `cu-signup` WHERE email='".$row_order_returned['useremail']."'");
              $row_customer_id=mysqli_fetch_assoc($select_customer_id);
              if($row_customer_id){
           ?>
          <tr class="hover:bg-gray-50">
            <td class="px-4 py-2"><?php echo $row_order_returned['id']?></td>
            <td class="px-4 py-2 flex items-center gap-2"><img src="../images/<?php echo $row_customer_id['image']?>" class="w-6 h-6 rounded-full"> <?php echo $row_customer_id['name']?></td>
            <td class="px-4 py-2"><?php echo $row_customer_id['id']?></td>
              <td class="px-4 py-2 flex items-center gap-2"><?php echo $row_product_id['name']?>
              <img src="../images/<?php echo $row_product_id['image']?>" class="w-6 h-6 rounded">
            </td>
            <td class="px-4 py-2"><?php echo $row_product_id['subcategory']?></td>
            <td class="px-4 py-2">PKR: <?php echo $row_order_returned['totalprice']?></td>
            <?php if($row_order_returned['peyment']==0){?>
            <td class="px-4 py-2"><span class="px-2 py-1 rounded text-xs bg-green-100 text-green-800">Cash on Delivery</span></td>
            <?php } else if($row_order_returned['peyment']==1){?>            
            <td class="px-4 py-2"><span class="px-2 py-1 rounded text-xs bg-green-100 text-green-800">Credit/Debit Card</span></td>
            <?php } else {?>
            <td class="px-4 py-2"><span class="px-2 py-1 rounded text-xs bg-green-100 text-green-800">PayPal</span></td>
            <?php }?>
            <td class="px-4 py-2"><span class="px-2 py-1 rounded text-xs bg-yellow-100 text-yellow-800">Returned</span></td>
            <td class="px-4 py-2 flex gap-2">
             <!-- 🟡 Pending -->
<button class="px-2 py-1 bg-yellow-500 text-white rounded text-xs hover:bg-yellow-600"><a href="status.php?id=<?php echo $row_order_returned['id']?>&status=0&type=order">Pending</a></button>

<!-- 🟢 Confirmed -->
<button class="px-2 py-1 bg-green-600 text-white rounded text-xs hover:bg-green-700"><a href="status.php?id=<?php echo $row_order_returned['id']?>&status=1&type=order">Confirmed</a></button>

<!-- 🔵 Shipped -->
<button class="px-2 py-1 bg-blue-600 text-white rounded text-xs hover:bg-blue-700"><a href="status.php?id=<?php echo $row_order_returned['id']?>&status=2&type=order">Shipped</a></button>

<!-- 🟢 Delivered -->
<button class="px-2 py-1 bg-green-500 text-white rounded text-xs hover:bg-green-600"><a href="status.php?id=<?php echo $row_order_returned['id']?>&status=3&type=order">Delivered</a></button>

<!-- 🔴 Cancelled -->
<button class="px-2 py-1 bg-red-600 text-white rounded text-xs hover:bg-red-700"><a href="status.php?id=<?php echo $row_order_returned['id']?>&status=4&type=order">Cancelled</a></button>

<!-- ⚫ Failed -->
<button class="px-2 py-1 bg-gray-700 text-white rounded text-xs hover:bg-gray-800"><a href="status.php?id=<?php echo $row_order_returned['id']?>&status=5&type=order">Failed</a></button>

<!-- 🟣 Returned -->
<button class="px-2 py-1 bg-purple-600 text-white rounded text-xs hover:bg-purple-700"><a href="status.php?id=<?php echo $row_order_returned['id']?>&status=6&type=order">Returned</a></button>

              <button class="px-2 py-1 bg-red-600 text-white rounded text-xs hover:bg-red-700"><a href="status.php?id=<?php echo $row_order_returned['id']?>&type=order_delete">Delete</button>
            </td>
          </tr>
          <?php }}} }?>
        </tbody>
      </table>
    </div>
  </div>



</div>

</body>
</html>
