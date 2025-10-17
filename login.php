<?php
session_start();
include("connection.php");
$connect=connection();
if(isset($_POST['login'])){
  $email=$_POST['email'];
  $password=$_POST['password'];
  $chack=mysqli_query($connect,"SELECT * FROM `cu-signup` WHERE email='$email'");
  if(mysqli_num_rows($chack)>0){
    $row=mysqli_fetch_assoc($chack);
    if($row['status']=='1'){
    if(password_verify($password,$row['password'])){
      $_SESSION['email']=$row['email'];
                  echo "<script>
                    alert('Login successful! Redirecting...');
                    window.location.href='index.php';
                  </script>";
            exit();
    }

    else{
                  echo "<script>
                    alert('Incorrect password! Please try again.');
                    window.location.href='login.php';
                  </script>";
            exit();
        }}
        else{
                           echo "<script>
                    alert('Users Account Banned.');
                    window.location.href='signup.php';
                  </script>";
            exit();   
        }
  }
  else{
            echo "<script>
                alert('Email not registered! Please sign up.');
                window.location.href='signup.php';
              </script>";
        exit();
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Mehdi Mart</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>

<body class="bg-gradient-to-r from-orange-100 via-white to-orange-100 min-h-screen flex items-center justify-center">

    <!-- Login Card -->
    <div class="w-full max-w-md bg-white rounded-2xl shadow-xl p-8">
        <!-- Logo / Heading -->
        <div class="text-center mb-6">
            <h1 class="text-3xl font-bold text-orange-600">Mehdi Mart</h1>
            <p class="text-gray-500 mt-2 text-sm">Login to your account to continue</p>
        </div>

        <!-- Login Form -->
        <form method="POST" class="space-y-5">

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

            <!-- Options -->
            <!-- Login Button -->
            <button type="submit" name="login"
                class="w-full bg-orange-600 text-white py-2 rounded-lg font-semibold hover:bg-orange-700 transition">
                Login
            </button>

            <!-- Divider -->
            <div class="relative flex items-center justify-center my-4">
                <span class="h-px bg-gray-300 w-full"></span>
                <span class="absolute bg-white px-2 text-sm text-gray-500">or</span>
            </div>


            <!-- Signup Link -->
            <p class="text-sm text-center text-gray-600">Don’t have an account?
                <a href="signup.php" class="text-orange-600 font-semibold hover:underline">Sign up</a>
            </p>
        </form>
    </div>

</body>

</html>