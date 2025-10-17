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
$select_user=mysqli_query($connect,"SELECT * FROM `cu-signup`");
$total_user=mysqli_num_rows($select_user);
$select_product=mysqli_query($connect,"SELECT * FROM product ");
$total_product=mysqli_num_rows($select_product);
$select_active=mysqli_query($connect,"SELECT * FROM `cu-signup` WHERE status='1'");
$row_active=mysqli_num_rows($select_active);
$select_closed=mysqli_query($connect,"SELECT * FROM  `cu-signup` WHERE status='0'");
$row_close=mysqli_num_rows($select_closed);

$select_re=mysqli_query($connect,"SELECT sum(totalprice) AS total FROM  `order`");
$row_re=mysqli_fetch_assoc($select_re);
$totalprice=$row_re['total'];
function formatNumber($num) {
    if ($num >= 1000000000) {
        return round($num / 1000000000, 1) . 'B'; // Billion
    } elseif ($num >= 1000000) {
        return round($num / 1000000, 1) . 'M'; // Million
    } elseif ($num >= 1000) {
        return round($num / 1000, 1) . 'K'; // Thousand
    } else {
        return $num;
    }
}



?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Mehdi Mart Admin Dashboard</title>
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
        <a href="index.php" class="block py-3 px-6 bg-orange-100 rounded flex items-center gap-3"><i class="fas fa-chart-line w-5"></i> Dashboard</a>
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

    <!-- UPDATED STATS CARDS -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-6 mb-6">
      <div class="bg-white shadow rounded p-4">
        <h3 class="text-sm font-semibold text-gray-500">Total Customers</h3>
        <p class="text-2xl font-bold text-gray-800"><?php echo $total_user?></p>
      </div>
      
      <div class="bg-white shadow rounded p-4">
        <h3 class="text-sm font-semibold text-gray-500">Active Customers</h3>
        <p class="text-2xl font-bold text-gray-800"><?php echo $row_active?></p>
      </div>
      <div class="bg-white shadow rounded p-4">
        <h3 class="text-sm font-semibold text-gray-500">Closed Customers</h3>
        <p class="text-2xl font-bold text-gray-800"><?php echo $row_close?></p>
      </div>
      <div class="bg-white shadow rounded p-4">
        <h3 class="text-sm font-semibold text-gray-500">Total Products</h3>
        <p class="text-2xl font-bold text-gray-800"><?php echo $total_product?></p>
      </div>
      <div class="bg-white shadow rounded p-4">
        <h3 class="text-sm font-semibold text-gray-500">Revenue</h3>
        <p class="text-2xl font-bold text-gray-800">PKR 
  <?php echo formatNumber($totalprice); ?>
</p>

      </div>
    </div>

   

    <!-- LATEST ORDERS -->
    <div class="bg-white shadow rounded p-4 mb-6">
      <h2 class="text-xl font-bold mb-4">New Orders</h2>
      <div class="overflow-x-auto">
        <table class="min-w-full border">
          <thead class="bg-gray-100">
            <tr>
              <th class="px-4 py-2 text-left">Order ID</th>
              <th class="px-4 py-2 text-left">Customer</th>
              <th class="px-4 py-2 text-left">Products</th>
              <th class="px-4 py-2 text-left">Total</th>
              <th class="px-4 py-2 text-left">Payment</th>
              <th class="px-4 py-2 text-left">Delivery</th>
              
              <th class="px-4 py-2 text-left">Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php 
            $select_order=mysqli_query($connect,"SELECT * FROM  `order` WHERE status='0'");
            while($row_order=mysqli_fetch_assoc($select_order)){
              if($row_order){
                $select_order_user=mysqli_query($connect,"SELECT * FROM `cu-signup` WHERE email='".$row_order['useremail']."'");
                $row_order_user=mysqli_fetch_assoc($select_order_user);
                $select_order_product=mysqli_query($connect,"SELECT * FROM product WHERE id='".$row_order['product_id']."'");
                $row_order_product=mysqli_fetch_assoc($select_order_product);
            ?>
            <tr class="hover:bg-gray-50">
              <td class="px-4 py-2"><?php echo $row_order['id']?></td>
              <td class="px-4 py-2 flex items-center gap-2"><img src="../images/<?php echo $row_order_user['image']?>" class="w-6 h-6 rounded-full"><?php echo $row_order_user['name']?> </td>
              <td class="px-4 py-2"><?php echo $row_order_product['name']?>
               <img src="../images/<?php echo $row_order_product['image']?>" class="w-6 h-6 rounded"> 
              </td>
              <td class="px-4 py-2">PKR: <?php echo $row_order['totalprice']?></td>
              <td class="px-4 py-2">
                <?php if($row_order['peyment']=='0'){?>
                <span class="px-2 py-1 rounded text-xs bg-green-100 text-green-800">Cash on Delivery</span>
                <?php } else if($row_order['peyment']=='1'){?>
                <span class="px-2 py-1 rounded text-xs bg-green-100 text-green-800">Credit/Debit Card</span>
                <?php } else{?>
                <span class="px-2 py-1 rounded text-xs bg-green-100 text-green-800">PayPal</span>
                <?php }?>
              </td>
              <td class="px-4 py-2"><span class="px-2 py-1 rounded text-xs bg-yellow-100 text-yellow-800">Pending</span></td>
              <td class="px-4 py-2 flex gap-2">
                <button class="px-2 py-1 bg-blue-600 text-white rounded text-xs hover:bg-blue-700"><a href="status.php?id=<?php echo $row_order['id']?>&status=1&type=order">Confirmed</a></button>
                <button class="px-2 py-1 bg-red-600 text-white rounded text-xs hover:bg-red-700"><a href="status.php?id=<?php echo $row_order['id']?>&status=4&type=order">Cancel</a></button>
              </td>
            </tr>
            <?php }} ?>
          </tbody>
        </table>
      </div>
    </div>

    <!-- LATEST CUSTOMERS -->
    <div class="bg-white shadow rounded p-4 mb-6">
      <h2 class="text-xl font-bold mb-4">Latest Customers</h2>
      <div class="overflow-x-auto">
        <table class="min-w-full border">
          <thead class="bg-gray-100">
    
            <tr>
              <th class="px-4 py-2 text-left">NAME</th>
              <th class="px-4 py-2 text-left">UserName</th>
              <th class="px-4 py-2 text-left">Email</th>
              <th class="px-4 py-2 text-left">Phone</th>
              <th class="px-4 py-2 text-left">Total Orders</th>
              <th class="px-4 py-2 text-left">Status</th>
              <th class="px-4 py-2 text-left">Actions</th>
            </tr>
          </thead>
          <tbody>
                    <?php 
            $select_customer=mysqli_query($connect,"SELECT * FROM `cu-signup` ORDER BY id DESC LIMIT 3");
            while($row_customer=mysqli_fetch_assoc($select_customer)){
              if($row_customer){
$select_customer_order = mysqli_query($connect, "SELECT * FROM `order` WHERE useremail='".$row_customer['email']."'");

if($select_customer_order && mysqli_num_rows($select_customer_order) > 0){
    $row_order_customer = mysqli_num_rows($select_customer_order);
} else {
    $row_order_customer = 0;
}

            ?>
            <tr class="hover:bg-gray-50">
              <td class="px-4 py-2"><?php echo $row_customer['name']?></td>
              <td class="px-4 py-2"><?php echo $row_customer['username']?></td>
              <td class="px-4 py-2"><?php echo $row_customer['email']?></td>
              <td class="px-4 py-2"><?php echo $row_customer['phone']?></td>
              <td class="px-4 py-2"><?php echo $row_order_customer?></td>
              <?php 
              if($row_customer['status']=='1')
              {?>
              <td class="px-4 py-2"><span class="px-2 py-1 rounded text-xs bg-green-100 text-green-800">Active</span></td>
              <?php } else{?>
              <td class="px-4 py-2"><span class="px-2 py-1 rounded text-xs bg-green-100 text-green-800">Closed</span></td>
              <?php } ?>                
              <td class="px-4 py-2 flex gap-2">
                <button class="px-2 py-1 bg-blue-600 text-white rounded text-xs hover:bg-blue-700"><a href="customers.php">View</a></button>
                <?php if($row_customer['status']=='1'){?>
                <button class="px-2 py-1 bg-red-600 text-white rounded text-xs hover:bg-red-700"><a href="status.php?type=customer&id=<?php echo $row_customer['id']?>&status=0">Deactivate</a></button>
                <?php } else{?>
                <button class="px-2 py-1 bg-red-600 text-white rounded text-xs hover:bg-red-700"><a href="status.php?type=customer&id=<?php echo $row_customer['id']?>&status=1">Active</a></button>
                <?php } ?>
              </td>
            </tr>
            <?php }} ?>
          </tbody>
        </table>
      </div>
    </div>

    <!-- LATEST MESSAGES -->
    <div class="bg-white shadow rounded p-4 mb-6">
      <h2 class="text-xl font-bold mb-4">Latest Messages</h2>
      <div class="overflow-x-auto">
        <table class="min-w-full border">
          <thead class="bg-gray-100">
            <tr>
              <th class="px-4 py-2 text-left">Message ID</th>
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
            $select_message=mysqli_query($connect,"SELECT * FROM `contact` ORDER BY id DESC LIMIT 3");
            while($row_contact=mysqli_fetch_assoc($select_message)){
                          $datetime = $row_contact['created_at'];
            $only_date = date('Y-m-d', strtotime($datetime));
              if($row_contact){

            ?>
            <tr class="hover:bg-gray-50">
              <td class="px-4 py-2"><?php echo $row_contact['id']?></td>
              <td class="px-4 py-2"><?php echo $row_contact['name']?></td>
              <td class="px-4 py-2"><?php echo $row_contact['email']?></td>
              <td class="px-4 py-2"><?php echo $row_contact['subject']?></td>
              <td class="px-4 py-2"><?php echo $row_contact['message']?></td>
              <td class="px-4 py-2"><?php echo $only_date?></td>
              <td class="px-4 py-2 flex gap-2">
                <button class="px-2 py-1 bg-blue-600 text-white rounded text-xs hover:bg-blue-700"><a href="messages.php">View<a></button>
                <button class="px-2 py-1 bg-red-600 text-white rounded text-xs hover:bg-red-700"><a href="status.php?type=mdelete&id=<?php echo $row_contact['id']?>">Delete</a></button>
              </td>
            </tr>
            <?php }} ?>
          </tbody>
        </table>
      </div>
    </div>

  </div>

  <!-- SCRIPT FOR DROPDOWNS -->
  <script>
    // Toggle Notifications dropdown
    const notifBtn = document.getElementById('notifBtn');
    const notifDropdown = document.getElementById('notifDropdown');
    notifBtn.addEventListener('click', () => {
      notifDropdown.classList.toggle('hidden');
    });

    // Toggle Messages dropdown
    const msgBtn = document.getElementById('msgBtn');
    const msgDropdown = document.getElementById('msgDropdown');
    msgBtn.addEventListener('click', () => {
      msgDropdown.classList.toggle('hidden');
    });
  </script>

</body>
</html>
