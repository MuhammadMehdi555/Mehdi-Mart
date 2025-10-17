<?php
session_start();
include("connection.php");
$connect=connection();
if(!isset($_SESSION['email'])){
      echo "<script>
            alert('Please login first!');
            window.location.href='login.php';
          </script>";
  exit();
}
if(isset($_POST['email']) && !empty($_POST['email'])){
$email=trim($_POST['email']);
$select=mysqli_query($connect,"SELECT * FROM newsletter WHERE email='$email'");
if(mysqli_num_rows($select)>0){
        echo "<script>alert('⚠ This email is already subscribed!'); window.location.href='index.php';</script>";
    exit();
}
else{
    $insert=mysqli_query($connect,"INSERT INTO newsletter (`email`,`status`) VALUES ('$email','1')");
    if($insert){
        echo "<script>alert('✅ Subscription successful! Thank you for joining our newsletter.'); window.location.href='index.php';</script>";
        exit();
    }
}
}
else{
    echo "<script>alert('⚠ Email is required!'); window.location.href='index.php';</script>";
        exit();
}
?>