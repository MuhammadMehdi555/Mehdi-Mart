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
if(isset($_POST['order_id'])){
    $order_id=$_POST['order_id'];
$update=mysqli_query($connect,"UPDATE `order` SET  status='4' WHERE id='$order_id'");
if($update){
    echo "<script>
alert('Your order has been cancelled successfully!');
window.location.href='profile.php'
</script>";

}

}

?>