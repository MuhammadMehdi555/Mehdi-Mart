<?php
session_start();
if(!isset($_SESSION['email'])){
    echo "<script>
            alert('Please login first!');
            window.location.href='login.php';
          </script>";
    exit();
}
include("connection.php");
$connect = connection();
if(isset($_POST['product_id'])){
    $product_id=$_POST['product_id'];
    $email=$_SESSION['email'];
    $check_product=mysqli_query($connect,"SELECT * FROM wishlist WHERE email='$email' AND product_id='$product_id'");
    if(mysqli_num_rows($check_product)>0){
        $delete_product=mysqli_query($connect,"DELETE FROM wishlist WHERE email='$email' AND product_id='$product_id'");
        if($delete_product){
            echo "<script>
        alert('Product removed from your wishlist!');
        window.location.href='index.php';
    </script>";

    }
    }
    else{
        $insert_product=mysqli_query($connect,"INSERT INTO wishlist (`email`,`product_id`) VALUES ('$email','$product_id') ");
        if($insert_product){
        echo "<script>
        alert('Product added to your wishlist!');
        window.location.href='index.php';
        </script>";
        }
    }
}
?>