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
$connect=connection();

$name=$_POST['name'];
$email=$_POST['email'];
$subject=$_POST['subject'];
$message=$_POST['message'];
$select=mysqli_query($connect,"SELECT created_at FROM contact WHERE email='$email' ORDER BY created_at DESC LIMIT 1");
$row=mysqli_fetch_assoc($select);
if($row){
    $last_time=strtotime($row['created_at']);
    $current_time=TIME();
    $hours_diff=($current_time - $last_time)/3600;
    if($hours_diff<24){
       echo "<script>
            alert('You can send only one message per day!');
            window.location.href='contact.php';
          </script>";
  exit(); 
    }
    else{
        $insert=mysqli_query($connect,"INSERT INTO contact (`name`,`email`,`subject`,`message`,`status`,`created_at`) VALUES ('$name','$email','$subject','$message','1',NOW())");
        if($insert){
            echo "<script>
            alert('✅ Message Sent successful! Thank you!');
            window.location.href='contact.php';
          </script>";
  exit();
        }
    }
}
else{
  $insert=mysqli_query($connect,"INSERT INTO contact (`name`,`email`,`subject`,`message`,`status`,`created_at`) VALUES ('$name','$email','$subject','$message','1',NOW())");
        if($insert){
            echo "<script>
            alert('✅ Message Sent successful! Thank you!');
            window.location.href='contact.php';
          </script>";
  exit();}  
}
?>