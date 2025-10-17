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
<title>Mehdi Mart Admin - Messages</title>
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
        <a href="orders.php" class="block py-3 px-6 hover:bg-orange-100 rounded flex items-center gap-3"><i class="fas fa-shopping-cart w-5"></i> Orders</a>
        <a href="customers.php" class="block py-3 px-6 hover:bg-orange-100 rounded flex items-center gap-3"><i class="fas fa-users w-5"></i> Customers</a>
        <a href="messages.php" class="block py-3 px-6 bg-orange-100 rounded flex items-center gap-3"><i class="fas fa-envelope w-5"></i> Messages</a>
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

  <!-- MESSAGES TABLE -->
  <div class="bg-white shadow rounded p-4 mb-6">
    <h2 class="text-xl font-bold mb-4">Customer Messages</h2>
    <div class="overflow-x-auto">
      <table class="min-w-full border">
        <thead class="bg-gray-100">
          <tr>
            <th class="px-4 py-2 text-left">ID</th>
            <th class="px-4 py-2 text-left">Sender</th>
            <th class="px-4 py-2 text-left">Email</th>
            <th class="px-4 py-2 text-left">Subject</th>
            <th class="px-4 py-2 text-left">Message</th>
            <th class="px-4 py-2 text-left">Date</th>
            <th class="px-4 py-2 text-left">Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $select_co=mysqli_query($connect,"SELECT * FROM contact ");
          while($row_co=mysqli_fetch_assoc($select_co)){
            if($row_co){
              $date=$row_co['created_at'];
              $only_date=date('y-m-d',strtotime($date));
          ?>
          <tr class="hover:bg-gray-50">
            <td class="px-4 py-2"><?php echo $row_co['id']?></td>
            <td class="px-4 py-2"><?php echo $row_co['name']?></td>
            <td class="px-4 py-2"><?php echo $row_co['email']?></td>
            <td class="px-4 py-2"><?php echo $row_co['subject']?></td>
            <td class="px-4 py-2"><?php echo $row_co['message']?></td>
            <td class="px-4 py-2"><?php echo $only_date?></td>
            <td class="px-4 py-2 flex gap-2">
              <button class="px-2 py-1 bg-red-600 text-white rounded text-xs hover:bg-red-700"><a href="status.php?type=mdelete&id=<?php echo $row_co['id']?>">Delete</a></button>
            </td>
          </tr>
          <?php }}?>
        </tbody>
      </table>
    </div>
  </div>
<div class="bg-white shadow rounded p-4 mb-6">
    <h2 class="text-xl font-bold mb-4">NEWSLETTER</h2>
    <div class="overflow-x-auto">
      <table class="min-w-full border">
        <thead class="bg-gray-100">
          <tr>
            <th class="px-4 py-2 text-left">E_mail</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $select_new=mysqli_query($connect,"SELECT * FROM newsletter ");
          while($row_new=mysqli_fetch_assoc($select_new)){
            if($row_new){

          ?>
          <tr class="hover:bg-gray-50">
            <td class="px-4 py-2"><?php echo $row_new['email']?></td>
            </td>
          </tr>
          <?php }}?>
        </tbody>
      </table>
    </div>
  </div>
</div>





</body>
</html>
