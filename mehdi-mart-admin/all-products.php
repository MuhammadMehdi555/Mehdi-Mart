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
  if(isset($_POST['apply'])){
  $id = $_POST['id'];
  $sub = $_POST['sub'];
  $search = $_POST['name']; // or $_POST['search']

  if(!empty($id)){
    $select_product = mysqli_query($connect,"SELECT * FROM product WHERE id='$id'");
  }
  else if(!empty($sub)){
    $select_product = mysqli_query($connect,"SELECT * FROM product WHERE subcategory='$sub'");
  }
  else if(!empty($search)){
    $select_product = mysqli_query($connect,"SELECT * FROM product WHERE name LIKE '%$search%'");
  }
  else{
    $select_product = mysqli_query($connect,"SELECT * FROM product");
  }
}
else {
  $select_product = mysqli_query($connect,"SELECT * FROM product");
}

  $row_product=mysqli_num_rows($select_product);
  $select_active_product=mysqli_query($connect,"SELECT * FROM  product WHERE status='1'");
  $row_active_product=mysqli_num_rows($select_active_product);
  $select_closed_product=mysqli_query($connect,"SELECT * FROM product WHERE status='0' ");
  $row_closed_product=mysqli_num_rows($select_closed_product);
  ?>

  <!DOCTYPE html>
  <html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mehdi Mart - All Products</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
  </head>
  <body class="bg-gray-100">

    <!-- SIDEBAR (Same as index.php) -->
    <!-- SIDEBAR -->
  <aside class="fixed top-0 left-0 h-full w-64 bg-white shadow-md hidden md:block">
    <div class="p-6">
      <a href="index.php" class="text-2xl font-bold text-orange-600">Mehdi Mart</a>
    </div>

    <!-- yaha scroll enable kiya -->
    <div class="h-[calc(100%-80px)] overflow-y-auto">
            <nav class="mt-2">
          <a href="index.php" class="block py-3 px-6 hover:bg-orange-100 rounded flex items-center gap-3"><i class="fas fa-chart-line w-5"></i> Dashboard</a>
          <a href="all-products.php" class="block py-3 px-6 bg-orange-100 rounded flex items-center gap-3"><i class="fas fa-box w-5"></i> Products</a>
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

      <!-- SUMMARY CARDS -->
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
        <div class="bg-white shadow rounded p-4 text-center">
          <h3 class="text-sm font-semibold text-gray-500">Total Products</h3>
          <p class="text-2xl font-bold text-gray-800"><?php echo $row_product?></p>
        </div>
        <div class="bg-white shadow rounded p-4 text-center">
          <h3 class="text-sm font-semibold text-gray-500">Active Products</h3>
          <p class="text-2xl font-bold text-green-600"><?php echo $row_active_product?></p>
        </div>
        <div class="bg-white shadow rounded p-4 text-center">
          <h3 class="text-sm font-semibold text-gray-500">Inactive Products</h3>
          <p class="text-2xl font-bold text-red-600"><?php echo $row_closed_product?></p>
        </div>

      </div>

      <!-- FILTER SECTION -->
      <div class="bg-white shadow rounded p-4 mb-6">
        <h2 class="text-xl font-bold mb-4">Filter Products</h2>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
          <div>
            <label class="block mb-1 font-semibold text-gray-700">Product ID</label>
            <form method="POST">
            <input type="text" name='id' placeholder="Enter ID" class="w-full border rounded px-3 py-2">
          </div>
          <div>
            <label class="block mb-1 font-semibold text-gray-700">Product Name</label>
            <input type="text" name="name" placeholder="Enter Name" class="w-full border rounded px-3 py-2">
          </div>
          <div>
            <label class="block mb-1 font-semibold text-gray-700">Category</label>
            <select name="sub" class="w-full border rounded px-3 py-2">
              <option value="">All Categories</option>
              <?php 
              $select_sub=mysqli_query($connect,"SELECT * FROM `sub-category`");
              while($row_sub=mysqli_fetch_assoc($select_sub)){
              ?>
              <option value="<?php echo $row_sub['name_parentname']?>"><?php echo $row_sub['name_parentname']?></option>
              <?php } ?>
            </select>
          </div>
        </div>
        <div class="mt-4">
          <button type="submit" name="apply" class="px-4 py-2 bg-orange-600 text-white rounded hover:bg-orange-700">Apply Filters</button>
              </form>
          <button class="px-4 py-2 bg-gray-300 text-gray-800 rounded hover:bg-gray-400"><a href="all-products.php">Reset</a></button>
        </div>
      </div>

      <!-- PRODUCTS TABLE -->
      <div class="bg-white shadow rounded p-4">
        <h2 class="text-xl font-bold mb-4">Products List</h2>
        <div class="overflow-x-auto">
          <table class="min-w-full border">
            <thead class="bg-gray-100">
              <tr>
                <th class="px-4 py-2 text-left">ID</th>
                <th class="px-4 py-2 text-left">Name</th>
                <th class="px-4 py-2 text-left">Category</th>
                <th class="px-4 py-2 text-left">Price</th>
                <th class="px-4 py-2 text-left">Status</th>
                <th class="px-4 py-2 text-left">Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php
              while($row_product_list=mysqli_fetch_assoc($select_product)){
                if($row_product_list){
              ?>
              <tr class="hover:bg-gray-50">
                <td class="px-4 py-2"><?php echo $row_product_list['id']?></td>
                <td class="px-4 py-2"><?php echo $row_product_list['name']?></td>
                <td class="px-4 py-2"><?php echo $row_product_list['subcategory']?></td>
                <td class="px-4 py-2">PKR: <?php echo $row_product_list['price']?></td>
                <?php if($row_product_list['status']==1){?>
                <td class="px-4 py-2"><span class="px-2 py-1 rounded text-xs bg-green-100 text-green-800">Active</span></td>
                <?php } else{?>
                <td class="px-4 py-2"><span class="px-2 py-1 rounded text-xs bg-red-100 text-red-800">Inactive</span></td>
                  <?php }?>
                <td class="px-4 py-2 flex gap-2">
                  <?php if($row_product_list['status']==0){?>
                  <button class="px-2 py-1 bg-blue-600 text-white rounded text-xs hover:bg-blue-700"><a href="status.php?type=product&id=<?php echo $row_product_list['id']?>&status=1">Active</a></button>
                  <?php } else{?>
                    <button class="px-2 py-1 bg-blue-600 text-white rounded text-xs hover:bg-blue-700"><a href="status.php?type=product&id=<?php echo $row_product_list['id']?>&status=0">Closed</a></button>
                    <?php }?>
                  <button class="px-2 py-1 bg-red-600 text-white rounded text-xs hover:bg-red-700"><a href="status.php?type=pdelete&id=<?php echo $row_product_list['id']?>">Delete</a></button>
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
