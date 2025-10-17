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
$email=$_SESSION['email'];
if(isset($_POST['product_id'])){
    $product_id=$_POST['product_id'];
$check_product = mysqli_query($connect,"SELECT * FROM cart WHERE email='$email' AND product_id='$product_id'");
    if(mysqli_num_rows($check_product)>0){
        $delete=mysqli_query($connect,"DELETE FROM cart WHERE email='$email' AND product_id='$product_id'");
        if($delete){
             echo "<script>
        alert('Product removed from your Cart!');
        window.location.href='index.php';
    </script>";
        }
    }
    else{
        $insert=mysqli_query($connect,"INSERT INTO cart (email,product_id,quantity) VALUES ('$email','$product_id','1')");
        if($insert){
            $delete_wish=mysqli_query($connect,"DELETE FROM wishlist WHERE email='$email' AND product_id='$product_id'");
            echo "<script>
        alert('Product added to your Cart!');
        window.location.href='index.php';
        </script>";
        }
    }
}
if(isset($_POST['pr_id'])){
$product_id=$_POST['pr_id'];
$select_cart_plus=mysqli_query($connect,"SELECT * FROM cart WHERE email='$email' AND product_id='$product_id'");
$row_cart_plus=mysqli_fetch_assoc($select_cart_plus);
$quantity=$row_cart_plus['quantity'];
$quantity+='1';
$update_plus=mysqli_query($connect,"UPDATE `cart` SET `quantity`='$quantity' WHERE `email`='$email' AND product_id='$product_id'");
if($update_plus){
 echo "<script>
        
        window.location.href='cart.php';
        </script>";
}
}
if(isset($_POST['pro_id'])){
    $product_id=$_POST['pro_id'];
    $select_cart_minis=mysqli_query($connect,"SELECT * FROM cart WHERE email='$email' AND product_id='$product_id'");
    $row_cart_minis=mysqli_fetch_assoc($select_cart_minis);
    $quantity=$row_cart_minis['quantity'];
    $quantity-='1';
    if($quantity=='0'){

             echo "<script>
        
        window.location.href='cart.php';
        </script>";
        
    }
    else{
        $update_minis=mysqli_query($connect,"UPDATE cart SET quantity='$quantity' WHERE email='$email'AND product_id='$product_id' ");
        if($update_minis){
     echo "<script>
        
        window.location.href='cart.php';
        </script>";
        }
        }
    }

?>




// session_start();
// include("connection.php");
// $connect = connection();
// $email = $_SESSION['email'];

// if(isset($_POST['product_id']) && isset($_POST['quantity'])){
// $product_id = $_POST['product_id'];
// $quantity = (int)$_POST['quantity'];

// if($quantity > 0){
// // update quantity
// mysqli_query($connect, "UPDATE cart SET quantity='$quantity' WHERE email='$email' AND product_id='$product_id'");
// } else {
// // agar 0 ya negative ho to delete
// mysqli_query($connect, "DELETE FROM cart WHERE email='$email' AND product_id='$product_id'");
// }
// }
// header("Location: cart.php");
// exit();








<!-- <td class="p-3">
  <form method="POST" action="update-cart.php">
    <input type="hidden" name="product_id" value="<?php echo $row_cart_none['product_id'] ?>">
    <input type="number" name="quantity" min="0" value="<?php echo $row_cart_none['quantity']?>" 
           class="w-12 text-center border rounded"
           onchange="this.form.submit()"> 
  </form>
</td> -->