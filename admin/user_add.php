<?php
session_start();
  require '../config/config.php';

  if(empty($_SESSION['userId']) && empty($_SESSION['loggin'])){
    header('Location:login.php');
  }
  if($_SESSION['role'] != 1){
    header('Location:login.php');
  }
  if(!empty($_POST)){
    $username = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    $stmt = $pdo->prepare('select * from users where email=:email');
    $stmt->bindValue(':email',$email);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    if($result){
        echo "<script>alert('Email is already taken..')</script>";
    }else{
        if(isset($_POST['role'])){
            $stmt1 = $pdo->prepare("INSERT INTO users(name,email,password,role) VALUES(:name,:email,:password,:role)");
            $result1 = $stmt1->execute(
                array(
                    ':name'=>$username,
                    ':email'=>$email,
                    ':password'=>$password,
                    ':role'=> 1
                )
            );
        }else{
            $stmt1 = $pdo->prepare("INSERT INTO users(name,email,password,role) VALUES(:name,:email,:password,:role)");
            $result1 = $stmt1->execute(
                array(
                    ':name'=>$username,
                    ':email'=>$email,
                    ':password'=>$password,
                    ':role'=> 0
                )
            );
        }
        
        if($result1){
            echo "<script>alert('User added successfully..You can now login');window.location.href='user_list.php';</script>";
        }else{
            echo "<script>alert('Something wrong');window.location.href='user_list.php';</script>";

        }
    }

  }

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Blog| Log in</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="../plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../dist/css/adminlte.min.css">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="index.php"><b>Add</b>User</a>
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Register new account</p>

      <form action="user_add.php" method="post">
      <div class="input-group mb-3">
          <input type="text" class="form-control" placeholder="Name" name="name">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="email" class="form-control" placeholder="Email" name="email">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" placeholder="Password" name="password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="checkbox"  placeholder="Admin" name="role" value="1">
        <span style="padding-left:10px;font-weight:bold;color:black;">Admin</span>
        </div>
        <div class="row">
          
          <div class="container">
            <button type="submit" class="btn btn-primary btn-block">Sign In</button>
            <a href="login.php" class="btn btn-default btn-block">Go Back</a>
          </div>
          <!-- /.col -->
        </div>
      </form>

     
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="../dist/js/adminlte.min.js"></script>
</body>
</html>
