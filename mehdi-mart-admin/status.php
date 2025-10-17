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
$id = $_GET['id'] ?? null;
$type = $_GET['type'] ?? null;
$status = $_GET['status'] ?? null;
if($type=='slider'){
    $update=mysqli_query($connect,"UPDATE slider SET status='$status' WHERE id='$id'");
    if($update){
        $select=mysqli_query($connect,"SELECT * FROM slider WHERE id='$id'");
        $row=mysqli_fetch_assoc($select);
        if($row['status']==1){
                    echo "<script>alert('Slider Activated Successfully!'); window.location.href='slider.php';</script>";

        }
        else{
                    echo "<script>alert('Slider Closed Successfully!'); window.location.href='slider.php';</script>";

        }
    }
    else{
                echo "<script>alert('Action Failed! Please try again.'); window.location.href='slider.php';</script>";

    }
}
else if($type=='category'){
    $update=mysqli_query($connect,"UPDATE category SET status='$status' WHERE id='$id'");
    if($update){
        $select=mysqli_query($connect,"SELECT * FROM category WHERE id='$id'");
        $row=mysqli_fetch_assoc($select);
        if($row['status']==1){
                                echo "<script>alert('category Activated Successfully!'); window.location.href='add-category.php';</script>";
        }
        else{
                                echo "<script>alert('category Closed Successfully!'); window.location.href='add-category.php';</script>";

        }
    }
    else{
                 echo "<script>alert('Action Failed! Please try again.'); window.location.href='add-category.php';</script>";       
    }
}
else if($type=='sub_category'){
    $update=mysqli_query($connect,"UPDATE `sub-category` SET status='$status' WHERE id='$id' ");
    if($update){
        $select=mysqli_query($connect,"SELECT * FROM `sub-category` WHERE id='$id'");
        $row=mysqli_fetch_assoc($select);
        if($row['status']==1){
                                echo "<script>alert('Sub category Activated Successfully!'); window.location.href='sub_category.php';</script>";
           
        }
        else{
                                 echo "<script>alert('sub category Closed Successfully!'); window.location.href='sub_category.php';</script>";
           
        }
    }
    else{
                 echo "<script>alert('Action Failed! Please try again.'); window.location.href='sub_category.php';</script>";           
    }
}
else if($type=='order'){
$update=mysqli_query($connect,"UPDATE `order` SET status='$status' WHERE id='$id'");
if($update){
    $select=mysqli_query($connect,"SELECT * FROM `order` WHERE id='$id'");
    $row=mysqli_fetch_assoc($select);
    
if ($row['status'] == 0) {
    echo "<script>alert('Order is still Pending 🟡'); window.location.href='orders.php';</script>";
} 
else if ($row['status'] == 1) {
    echo "<script>alert('Order Confirmed Successfully 🟢'); window.location.href='orders.php';</script>";
} 
else if ($row['status'] == 2) {
    echo "<script>alert('Order has been Shipped 🔵'); window.location.href='orders.php';</script>";
} 
else if ($row['status'] == 3) {
    echo "<script>alert('Order Delivered Successfully 🟢'); window.location.href='orders.php';</script>";
} 
else if ($row['status'] == 4) {
    echo "<script>alert('Order has been Cancelled 🔴'); window.location.href='orders.php';</script>";
} 
else if ($row['status'] == 5) {
    echo "<script>alert('Delivery Failed ⚫'); window.location.href='orders.php';</script>";
} 
else{
    echo "<script>alert('Order Returned 🟣'); window.location.href='orders.php';</script>";
} 
}
}
else if($type=='customer'){
    $update=mysqli_query($connect,"UPDATE `cu-signup` SET status='$status' WHERE  id='$id'");
    if($update){
        $select=mysqli_query($connect,"SELECT * FROM `cu-signup` WHERE id='$id'");
        $row=mysqli_fetch_assoc($select);
        if($row['status']==1){
        echo "<script>alert('Customer Account Activated Successfully!'); window.location.href='customers.php';</script>";            
        }
        else{
        echo "<script>alert('Customer account Closed Successfully!'); window.location.href='customers.php';</script>";
                      
        }
    }
}
else if($type=='mdelete'){
    $delete=mysqli_query($connect,"DELETE FROM `contact` WHERE id='$id'");
    if($delete){
        echo "<script>alert('Message deleted successfully!'); window.location.href='messages.php';</script>";

    }
}
else if($type=='pdelete'){
    $delete=mysqli_query($connect,"DELETE FROM `product` WHERE id='$id'");
    if($delete){
        echo "<script>alert('product deleted successfully!'); window.location.href='all-products.php';</script>";

    }
}
else if($type=='product'){
       $update=mysqli_query($connect,"UPDATE product SET status='$status' WHERE  id='$id'");
    if($update){
        $select=mysqli_query($connect,"SELECT * FROM product WHERE id='$id'");
        $row=mysqli_fetch_assoc($select);
        if($row['status']==1){
        echo "<script>alert('Product Activated Successfully!'); window.location.href='all-products.php';</script>";            
        }
        else{
        echo "<script>alert('Product Closed Successfully!'); window.location.href='all-products.php';</script>";
                      
        }
    } 
}
else if($type=='order_delete'){
       $delete=mysqli_query($connect,"DELETE FROM `order` WHERE id='$id'");
    if($delete){
        echo "<script>alert('Order deleted successfully!'); window.location.href='orders.php';</script>";

    } 
}
else if($type=='cu_delete'){
           $delete=mysqli_query($connect,"DELETE FROM `cu-signup` WHERE id='$id'");
    if($delete){
        echo "<script>alert('Customer Account deleted successfully!'); window.location.href='customers.php';</script>";

    } 
}
   
?>