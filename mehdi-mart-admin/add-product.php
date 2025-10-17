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
if(isset($_POST['add'])){
  $name = $_POST['name'];
  $des = $_POST['des'];
  $sub_cate = $_POST['sub_cate'];
  $price = $_POST['price'];
  $status = $_POST['status'];
  $d_type = $_POST['d_type'];
  $d_price = $_POST['d_price'];
  $s_des=$_POST['s_des'];

  // --- Main Image ---
  $new_name = "";
  if(isset($_FILES['image']) && !empty($_FILES['image']['name'])){
      $img_name = $_FILES['image']['name'];
      $img_tmp = $_FILES['image']['tmp_name'];
      $path = pathinfo($img_name, PATHINFO_EXTENSION);
      $rand = rand(100,999);
      $new_name = pathinfo($img_name, PATHINFO_FILENAME)."_".$rand.".".$path;
      move_uploaded_file($img_tmp,"../images/".$new_name);
  }

  // --- Image1 ---
  $new_name1 = "";
  if(isset($_FILES['image1']) && !empty($_FILES['image1']['name'])){
      $img_name1 = $_FILES['image1']['name'];
      $img_tmp1 = $_FILES['image1']['tmp_name'];
      $path1 = pathinfo($img_name1, PATHINFO_EXTENSION);
      $rand1 = rand(100,999);
      $new_name1 = pathinfo($img_name1, PATHINFO_FILENAME)."_".$rand1.".".$path1;
      move_uploaded_file($img_tmp1,"../images/".$new_name1);
  }

  // --- Image2 ---
  $new_name2 = "";
  if(isset($_FILES['image2']) && !empty($_FILES['image2']['name'])){
      $img_name2 = $_FILES['image2']['name'];
      $img_tmp2 = $_FILES['image2']['tmp_name'];
      $path2 = pathinfo($img_name2, PATHINFO_EXTENSION);
      $rand2 = rand(100,999);
      $new_name2 = pathinfo($img_name2, PATHINFO_FILENAME)."_".$rand2.".".$path2;
      move_uploaded_file($img_tmp2,"../images/".$new_name2);
  }

  // INSERT Query
  $insert=mysqli_query($connect,"INSERT INTO `product` 
  (`name`,`description`,`subcategory`,`price`,`image`,`image1`,`image2`,`status`,`discount_type`,`discount_value`,`short_description`) 
  VALUES 
  ('$name','$des','$sub_cate','$price','$new_name','$new_name1','$new_name2','$status','$d_type','$d_price','$s_des')");
  
  if($insert){
      echo "<script>alert('✅ Great! Your Product has been added successfully.');
      window.location.href='add-product.php';
      </script>";
  } else {
      echo "<script>alert('❌ Oops! Something went wrong, Product could not be added.');
      window.location.href='add-product.php';
      </script>";
  }
}

?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Add Product - Mehdi Mart Admin</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
  <style>
    body {font-family: 'Inter', ui-sans-serif, system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial;}
  </style>
</head>
<body class="bg-gray-100 min-h-screen">

<!-- SIDEBAR -->
 <aside class="fixed top-0 left-0 h-full w-64 bg-white shadow-md hidden md:block">
    <div class="p-6">
      <a href="index.php" class="text-2xl font-bold text-orange-600">Mehdi Mart</a>
    </div>

    <div class="h-[calc(100%-80px)] overflow-y-auto">
            <nav class="mt-2">
        <a href="index.php" class="block py-3 px-6 hover:bg-orange-100 rounded flex items-center gap-3"><i class="fas fa-chart-line w-5"></i> Dashboard</a>
        <a href="all-products.php" class="block py-3 px-6 hover:bg-orange-100 rounded flex items-center gap-3"><i class="fas fa-box w-5"></i> Products</a>
        <a href="add-product.php" class="block py-3 px-6 bg-orange-100 rounded flex items-center gap-3"><i class="fas fa-plus w-5"></i> Add Product</a>
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

  <div class="bg-white shadow rounded p-6">
    <form class="space-y-6" method="POST" enctype="multipart/form-data">

      <!-- Product Name -->
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-2">Product Name</label>
        <input type="text" name="name" placeholder="Enter product name" class="w-full border rounded p-2">
      </div>
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-2">Short Discription</label>
        <input type="text" name="s_des" placeholder="Enter Short Discription name" class="w-full border rounded p-2">
      </div>
      <!-- Description -->
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
        <textarea placeholder="Enter product description" name="des" rows="3" class="w-full border rounded p-2"></textarea>
      </div>

      <!-- Subcategory -->
    <!-- Subcategory -->
<div>
  <label class="block text-sm font-medium text-gray-700 mb-2">Subcategory</label>
  <select class="w-full border rounded p-2" name="sub_cate">
    <option value="">Select Subcategory</option>
    <?php 
    $select_sub=mysqli_query($connect,"SELECT * FROM `sub-category`");
    while($row_sub=mysqli_fetch_assoc($select_sub)){
      if($row_sub['status']==1){
    ?>
        <option value="<?php echo $row_sub['name_parentname']?>"><?php echo $row_sub['name_parentname']?></option>
        <?php } }?>
  </select>
</div>


      <!-- Price -->
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-2">Price</label>
        <input type="number" name="price" placeholder="Enter price" class="w-full border rounded p-2">
      </div>

      <!-- Images -->
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-2">Main Image</label>
        <input type="file" name="image" class="block w-full border rounded p-2">
      </div>
      <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-2">Image 1</label>
          <input type="file" name="image1"class="block w-full border rounded p-2">
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-2">Image 2</label>
          <input type="file" name="image2" class="block w-full border rounded p-2">
        </div>
      </div>

      <!-- Status -->
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
        <select class="w-full border rounded p-2" name="status">
          <option value="1">Active</option>
          <option value="0">Inactive</option>
        </select>
      </div>

      <!-- Discount -->
      <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-2">Discount Type</label>
          <select class="w-full border rounded p-2" name="d_type">
            <option value="">None</option>
            <option value="1">Percentage</option>
            <option value="2">Fixed</option>
          </select>
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-2">Discount Value</label>
          <input type="number" name="d_price" placeholder="Enter discount value" class="w-full border rounded p-2">
        </div>
      </div>

      <!-- Submit -->
      <div>
        <button type="submit" name="add" class="px-4 py-2 bg-orange-600 text-white rounded hover:bg-orange-700">Add Product</button>
      </div>

    </form>
  </div>
</div>
</body>
</html>
