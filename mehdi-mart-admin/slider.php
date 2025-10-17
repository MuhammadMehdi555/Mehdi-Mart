<?php
session_start();
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
  echo "<script>
        alert('You have been logged out successfully!');
        window.location.href='login.php';
      </script>";
}

include("../connection.php");
$connect= connection();
$select_admin=mysqli_query($connect,"SELECT * FROM `admin`");
$row_admin=mysqli_fetch_assoc($select_admin);
if(isset($_POST['save'])){
  $caption=$_POST['caption'];
  $img_name=$_FILES['image']['name'];
  $img_tmp=$_FILES['image']['tmp_name'];
  $rand=rand(100,999);
  $path=pathinfo($img_name,PATHINFO_EXTENSION);
  $new_name=pathinfo($img_name,PATHINFO_FILENAME)."_".$rand.".".$path;
  $move=move_uploaded_file($img_tmp,"../images/".$new_name);

  if(empty($_FILES['image']['name'])){
    echo "<script>
        alert('⚠️ Please select a file before uploading!');
        window.location.href='slider.php';
    </script>";
    exit();
  } else {
    if($move){
      $insert=mysqli_query($connect,"INSERT INTO slider (image,caption,status) VALUES ('$new_name','$caption','0')");
      if($insert){
        echo "<script>
          alert('✅ Great! Your slider has been added successfully.');
          window.location.href='slider.php';
        </script>";
      } else {
        echo "<script>
          alert('❌ Oops! Something went wrong, slider could not be added.');
          window.location.href='slider.php';
        </script>";
      }
    } else {
      echo "<script>
        alert('❌ Your image could not be moved to the folder!');
        window.location.href='slider.php';
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
  <title>Mehdi Mart - Slider Management</title>
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
        <a href="slider.php" class="block py-3 px-6 bg-orange-100 rounded flex items-center gap-3"><i class="fas fa-image w-5"></i> Add Slider</a><a href="add-category.php" class="block py-3 px-6 hover:bg-orange-100 rounded flex items-center gap-3"><i class="fas fa-folder"></i> Add Category</a>
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

    <!-- ADD SLIDE FORM -->
    <div class="bg-white shadow rounded p-6 mb-6">
      <h2 class="text-xl font-bold mb-4">Add New Slide</h2>
      <form class="grid grid-cols-1 md:grid-cols-2 gap-4" method="POST" enctype="multipart/form-data">
        <div>
          <label class="block text-sm font-semibold text-gray-600 mb-2">Select Image</label>
          <input type="file" name="image" class="w-full border p-2 rounded" />
        </div>
        <div>
          <label class="block text-sm font-semibold text-gray-600 mb-2">Caption (Optional)</label>
          <input type="text" name="caption" class="w-full border p-2 rounded" placeholder="Enter slide caption" />
        </div>
        <div class="md:col-span-2">
          <button type="submit" name="save" class="px-4 py-2 bg-orange-600 text-white rounded hover:bg-orange-700">
            <i class="fas fa-upload mr-2"></i> Upload Slide
          </button>
        </div>
      </form>
    </div>

    <!-- SLIDES LIST -->
    <div class="bg-white shadow rounded p-6">
      <h2 class="text-xl font-bold mb-4">All Slides</h2>
      <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6">
        <?php 
        $select = mysqli_query($connect,"SELECT * FROM slider");
        while($row=mysqli_fetch_assoc($select)){
        ?>
        <div class="border rounded shadow hover:shadow-lg transition">
          <img src="../images/<?php echo $row['image']?>" class="w-full h-40 object-cover rounded-t">
          <div class="p-4">
            <p class="text-gray-700 text-sm mb-2"><?php echo $row['caption']?></p>
            <div class="flex gap-4">
              <?php if($row['status'] == 0){ ?>
                <a href="status.php?id=<?php echo $row['id']?>&type=slider&status=1" 
                   class="flex-1 text-center py-3 bg-green-600 text-white rounded-lg text-base font-semibold shadow hover:bg-green-700 transition">
                  Active
                </a>
              <?php } else { ?>
                <a href="status.php?id=<?php echo $row['id']?>&type=slider&status=0" 
                   class="flex-1 text-center py-3 bg-yellow-600 text-white rounded-lg text-base font-semibold shadow hover:bg-yellow-700 transition">
                  Close
                </a>
              <?php } ?>
              <a href="delete.php?type=slider&id=<?php echo $row['id']?>" 
                 class="flex-1 text-center py-3 bg-red-600 text-white rounded-lg text-base font-semibold shadow hover:bg-red-700 transition">
                Delete
              </a>
            </div>
          </div>
        </div>
        <?php } ?>
      </div>
    </div>
  </div>
</body>
</html>
