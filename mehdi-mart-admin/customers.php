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
if(isset($_POST['apply'])){
  $id=$_POST['id'];
  $name=$_POST['name'];
  if(!empty($id)){
    $select_customer=mysqli_query($connect,"SELECT * FROM `cu-signup` WHERE id='$id'");
  }
  else if(!empty($name)){
    $select_customer=mysqli_query($connect,"SELECT * FROM `cu-signup` WHERE name LIKE '%$name%'");

  }
  else{
    $select_customer=mysqli_query($connect,"SELECT * FROM `cu-signup`");

  }
}
else{
$select_customer=mysqli_query($connect,"SELECT * FROM `cu-signup`");
}
$select_admin=mysqli_query($connect,"SELECT * FROM `admin`");
$row_admin=mysqli_fetch_assoc($select_admin);

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Mehdi Mart - Customers</title>
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
        <a href="customers.php" class="block py-3 px-6 bg-orange-100 rounded flex items-center gap-3"><i class="fas fa-users w-5"></i> Customers</a>
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
    <!-- STATS CARDS -->

    <!-- FILTERS (DESIGN ONLY) -->
    <div class="bg-white shadow rounded p-4 mb-6 flex flex-wrap gap-4 items-center">
      <form method="POST">
      <input type="text" name="name" placeholder="Filter by Name" class="border px-3 py-2 rounded w-60">
      <input type="text" name="id" placeholder="Filter by Customer ID" class="border px-3 py-2 rounded w-60">
          <button type="submit" name="apply" class="px-4 py-2 bg-orange-600 text-white rounded hover:bg-orange-700">Apply Filters</button>
              </form>
          <button class="px-4 py-2 bg-gray-300 text-gray-800 rounded hover:bg-gray-400"><a href="customers.php">Reset</a></button>
    </div>

    <!-- CUSTOMERS TABLE (DESIGN ONLY) -->
    <div class="bg-white shadow rounded p-4 mb-6 overflow-x-auto">
      <table class="min-w-full border">
        <thead class="bg-gray-100">
          <tr>
            <th class="px-4 py-2 text-left">Customer ID</th>
            <th class="px-4 py-2 text-left">Name</th>
            <th class="px-4 py-2 text-left">Image</th>
            <th class="px-4 py-2 text-left">Email</th>
            <th class="px-4 py-2 text-left">Phone</th>
            <th class="px-4 py-2 text-left">Total Orders</th>
            <th class="px-4 py-2 text-left">Status</th>
            <th class="px-4 py-2 text-left">Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php
          while($row_customer=mysqli_fetch_assoc($select_customer)){
            if($row_customer){
              $email=$row_customer['email'];
              $select_order=mysqli_query($connect,"SELECT COUNT(*) AS total FROM `order` WHERE useremail='$email' ");
              $row_total=mysqli_fetch_assoc($select_order);
              $total=$row_total['total'];
          ?>
          <tr class="hover:bg-gray-50">
              <td class="px-4 py-2"><?php echo $row_customer['id']?></td>
              <td class="px-4 py-2"><?php echo $row_customer['name']?></td>
              <td class="px-4 py-2">
              <img src="../images/<?php echo $row_customer['image']?>" class="w-6 h-6 rounded"></td>
              <td class="px-4 py-2"><?php echo $row_customer['email']?></td>
              <td class="px-4 py-2"><?php echo $row_customer['phone']?></td>
              <td class="px-4 py-2"><?php echo $total?></td>
              <?php if($row_customer['status']==1){?>
            <td class="px-4 py-2"><span class="px-2 py-1 rounded text-xs bg-green-100 text-green-800">Active</span></td><?php } else{?>
            <td class="px-4 py-2"><span class="px-2 py-1 rounded text-xs bg-green-100 text-green-800">Close</span></td><?php }?>
            <td class="px-4 py-2">
              <?php if($row_customer['status']==0){?>
              <button class="px-2 py-1 bg-blue-600 text-white rounded text-xs hover:bg-blue-700"><a href="status.php?type=customer&id=<?php echo $row_customer['id']?>&status=1">Active</a></button>
              <?php } else{?>
                <button class="px-2 py-1 bg-blue-600 text-white rounded text-xs hover:bg-blue-700"><a href="status.php?type=customer&id=<?php echo $row_customer['id']?>&status=0">Closed</a></button>
                <?php }?>
              <button class="px-2 py-1 bg-red-600 text-white rounded text-xs hover:bg-red-700"><a href="status.php?type=cu_delete&id=<?php echo $row_customer['id']?>">Delete</a></button>
            </td>
          </tr>
          <?php }}?>
        </tbody>
      </table>
    </div>

</div>

</body>
</html>
