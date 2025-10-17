<?php
session_start();
if(!isset($_SESSION['email_admin'])&&!isset($_SESSION['username'])){
    echo "<script>
            alert('Please login first!');
            window.location.href='login.php';
          </script>";
  exit();
}
include("../connection.php");
$connect=connection();
    $id=$_GET['id'];
    $type=$_GET['type'];
    if($type=='slider'){
        $select=mysqli_query($connect,"SELECT * FROM slider WHERE id='$id'");
        $row=mysqli_fetch_assoc($select);
        $image_de="../images/".$row['image'];
        $delete=mysqli_query($connect,"DELETE FROM slider WHERE id='$id'");
        if($delete){

            if(file_exists($image_de)){
                unlink($image_de);
            }

                echo "<script>alert('Slider deleted successfully!'); window.location.href='slider.php';</script>";

        }
        else{
                echo "<script>alert('Failed to delete slider! Try again.'); window.location.href='slider.php';</script>";

        }

    }
    else if($type=='category'){
        $select=mysqli_query($connect,"SELECT * FROM category WHERE id='$id'");
        $row=mysqli_fetch_assoc($select);
        $image_de="../images/".$row['image'];
        $delete=mysqli_query($connect,"DELETE FROM category WHERE id='$id'");
        if($delete){
            if(file_exists($image_de)){
                unlink($image_de);
            }
                 echo "<script>alert('category deleted successfully!'); window.location.href='add-category.php';</script>";
           
        }
        else{
                echo "<script>alert('Failed to delete category! Try again.'); window.location.href='add-category.php';</script>";

        }
    }
    else if($type=='sub_category'){
        $select = mysqli_query($connect,"SELECT * FROM `sub-category` WHERE id='$id'");
        $row=mysqli_fetch_assoc($select);
        $image="../images/".$row['image'];
        $delete=mysqli_query($connect,"DELETE FROM `sub-category` WHERE id='$id' ");
        if($delete){
            if(file_exists($image)){
                unlink($image);
            }
                             echo "<script>alert('Sub category deleted successfully!'); window.location.href='sub_category.php';</script>";

        }
        else{
                echo "<script>alert('Failed to delete sub category! Try again.'); window.location.href='sub_category.php';</script>";
           
        }
    }
?>