<?php
session_start();
include("connection.php");
$connect=connection();
if(isset($_POST['signup'])){
  $name=$_POST['name'];
  $user=str_replace(" ","_",strtolower($name));
  $rand_user=rand(100,999);
  $username=$user."_".$rand_user;
  $email=$_POST['email'];
  $phone=$_POST['phone'];
  $date=$_POST['date'];
  $password=$_POST['password'];
  $cpassword=$_POST['cpassword'];
  $passwordhash=password_hash($password,PASSWORD_DEFAULT);
  $address=$_POST['address'];
  $city=$_POST['city'];
  $postal=$_POST['postal'];
  $img_name=$_FILES['img']['name'];
  $img_tmp=$_FILES['img']['tmp_name'];
  $rand=rand(100,999);
  $path=pathinfo($img_name,PATHINFO_EXTENSION);
  $new_name=pathinfo($img_name,PATHINFO_FILENAME)."_".$rand.".".$path;
  move_uploaded_file($img_tmp,"images/".$new_name);
  $chackemail=mysqli_query($connect,"SELECT * FROM `cu-signup` WHERE email='$email'");
  $resultemail=mysqli_num_rows($chackemail);
  $cahckphone=mysqli_query($connect,"SELECT * FROM `cu-signup` WHERE phone='$phone'");
  $reslutphone=mysqli_num_rows($cahckphone);
  if(strlen($password)>8 || strlen($password)<4){
          echo "<script>
            alert('Password must be between 4 and 8 characters!');
            window.location.href='signup.php';
          </script>";
              exit();
  }
  else if($password!==$cpassword){
      echo "<script>
            alert('Password and Confirm Password do not match!');
            window.location.href='signup.php';
          </script>";
    exit();
  }
  else if($reslutphone>0 && $resultemail>0){
        echo "<script>alert('Phone and Email are already registered!');
    window.location.href='signup.php';
    </script>";
    exit();
  }
  else if($reslutphone>0){
        echo "<script>alert('Phone is already registered!');
    window.location.href='signup.php';
    </script>";
    exit();
  }
  else if($resultemail>0){
        echo "<script>alert('Email is already registered!');
    window.location.href='signup.php';
    </script>";
    exit();
  }
  else{
    $insert=mysqli_query($connect,"INSERT INTO `cu-signup` (`name`,`email`,`phone`,`dob`,`image`,`password`,`address`,`city`,`postal-code`,`status`,`username`)VALUES('$name','$email','$phone','$date','$new_name','$passwordhash','$address','$city','$postal','1','$username')");
    if($insert){
      $_SESSION['email']=$email;
          echo "<script>alert('Add Account successfully!'); window.location='index.php';</script>";
    }
    else {
    echo "<script>alert('Error: ".mysqli_error($connect)."');</script>";
}
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up - Mehdi Mart</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>

<body class="bg-gradient-to-r from-orange-100 via-white to-orange-100 min-h-screen flex items-center justify-center">

    <!-- Signup Card -->
    <div class="w-full max-w-md bg-white rounded-2xl shadow-xl p-8">
        <!-- Logo / Heading -->
        <div class="text-center mb-6">
            <h1 class="text-3xl font-bold text-orange-600">Mehdi Mart</h1>
            <p class="text-gray-500 mt-2 text-sm">Create a new account to start shopping</p>
        </div>

        <!-- Signup Form -->
        <form method="POST" enctype="multipart/form-data" class="space-y-5">

            <!-- Full Name -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                        <i class="fas fa-user"></i>
                    </span>
                    <input type="text" name="name" required placeholder="John Doe"
                        class="w-full pl-10 pr-3 py-2 border rounded-lg focus:ring-2 focus:ring-orange-400 focus:outline-none">
                </div>
            </div>

            <!-- Email -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                        <i class="fas fa-envelope"></i>
                    </span>
                    <input type="email" name="email" required placeholder="you@example.com"
                        class="w-full pl-10 pr-3 py-2 border rounded-lg focus:ring-2 focus:ring-orange-400 focus:outline-none">
                </div>
            </div>

            <!-- Phone Number -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Phone Number</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                        <i class="fas fa-phone"></i>
                    </span>
                    <input type="tel" name="phone" required placeholder="+92 300 1234567"
                        class="w-full pl-10 pr-3 py-2 border rounded-lg focus:ring-2 focus:ring-orange-400 focus:outline-none">
                </div>
            </div>

            <!-- Date of Birth -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Date of Birth</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                        <i class="fas fa-calendar"></i>
                    </span>
                    <input type="date" name="date" required
                        class="w-full pl-10 pr-3 py-2 border rounded-lg focus:ring-2 focus:ring-orange-400 focus:outline-none">
                </div>
            </div>

            <!-- Profile Image -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Profile Picture</label>
                <input type="file" name="img" accept="image/*"
                    class="w-full text-sm text-gray-600 border rounded-lg cursor-pointer focus:ring-2 focus:ring-orange-400 focus:outline-none">
            </div>

            <!-- Password -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                        <i class="fas fa-lock"></i>
                    </span>
                    <input type="password" name="password" required placeholder="••••••••"
                        class="w-full pl-10 pr-3 py-2 border rounded-lg focus:ring-2 focus:ring-orange-400 focus:outline-none">
                </div>
            </div>

            <!-- Confirm Password -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Confirm Password</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                        <i class="fas fa-lock"></i>
                    </span>
                    <input type="password" name="cpassword" required placeholder="••••••••"
                        class="w-full pl-10 pr-3 py-2 border rounded-lg focus:ring-2 focus:ring-orange-400 focus:outline-none">
                </div>
            </div>

            <!-- Address -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Address</label>
                <textarea name="address" required placeholder="Street, Apartment, etc."
                    class="w-full pl-3 pr-3 py-2 border rounded-lg focus:ring-2 focus:ring-orange-400 focus:outline-none"></textarea>
            </div>

            <!-- City + Postal Code -->
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">City</label>
                    <input type="text" name="city" required placeholder="Karachi"
                        class="w-full pl-3 pr-3 py-2 border rounded-lg focus:ring-2 focus:ring-orange-400 focus:outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Postal Code</label>
                    <input type="text" name="postal" required placeholder="74000"
                        class="w-full pl-3 pr-3 py-2 border rounded-lg focus:ring-2 focus:ring-orange-400 focus:outline-none">
                </div>
            </div>

            <!-- Signup Button -->
            <button type="submit" name="signup"
                class="w-full bg-orange-600 text-white py-2 rounded-lg font-semibold hover:bg-orange-700 transition">
                Sign Up
            </button>

            <!-- Login Link -->
            <p class="text-sm text-center text-gray-600">Already have an account?
                <a href="login.php" class="text-orange-600 font-semibold hover:underline">Login</a>
            </p>
        </form>
    </div>

</body>

</html>