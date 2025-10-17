<?php
session_start();
include("../connection.php");
$connect=connection();
if(isset($_POST['login'])){
  $username=$_POST['username'];
  $email=$_POST['email'];
  $password=$_POST['password'];
$chackemail=mysqli_query($connect,"SELECT * FROM admin WHERE email='$email'");
if(mysqli_num_rows($chackemail)==0){
        echo "<script>alert('Invalid Email!'); window.location.href='login.php';</script>";
        exit();
}

$chackuser=mysqli_query($connect,"SELECT * FROM admin WHERE username='$username'");
if(mysqli_num_rows($chackuser)==0){
        echo "<script>alert('Invalid Username!'); window.location.href='login.php';</script>";
        exit();
}
$chack=mysqli_query($connect,"SELECT * FROM admin WHERE username='$username' AND email='$email'");
if(mysqli_num_rows($chack)>0){
   $row=mysqli_fetch_assoc($chack);
   if($row['password']==$password){
        $_SESSION['username']=$row['username'];
        $_SESSION['email_admin']=$row['email'];
          echo "<script>alert('Login Successful!'); window.location.href='index.php';</script>";
   }
   else{
          echo "<script>alert('Invalid Password!'); window.location.href='login.php';</script>";

   }
}
else{
          echo "<script>alert('Email and Username do not match!'); window.location.href='login.php';</script>";

}
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Login - Mehdi Mart</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body class="bg-gradient-to-r from-orange-100 via-white to-orange-100 min-h-screen flex items-center justify-center">

  <!-- Admin Login Card -->
  <div class="w-full max-w-md bg-white rounded-2xl shadow-xl p-8">
    
    <!-- Logo / Heading -->
    <div class="text-center mb-6">
      <h1 class="text-3xl font-bold text-orange-600">Mehdi Mart</h1>
      <p class="text-gray-500 mt-2 text-sm">Admin Login to manage dashboard</p>
    </div>

    <!-- Login Form -->
    <form  method="POST" class="space-y-5">
      
  
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
    <!-- Username -->
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Username</label>
        <div class="relative">
          <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
            <i class="fas fa-user"></i>
          </span>
          <input type="text" name="username" required placeholder="Enter your username"
                 class="w-full pl-10 pr-3 py-2 border rounded-lg focus:ring-2 focus:ring-orange-400 focus:outline-none">
        </div>
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

      <!-- Login Button -->
      <button type="submit" name="login" class="w-full bg-orange-600 text-white py-2 rounded-lg font-semibold hover:bg-orange-700 transition">
        Login as Admin
      </button>      
    </form>
  </div>

</body>
</html>
