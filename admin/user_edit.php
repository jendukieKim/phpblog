<?php
    session_start();
    require '../config/config.php';

    if(empty($_SESSION['userid']) && empty($_SESSION['loggin'])){
    header('Location:login.php');
    }
    $userid = $_GET['id'];

    if($_SESSION['role'] != 1){
        header('Location:login.php');
      }
    //retrieve value according to userid
    $stmt = $pdo->prepare("SELECT * FROM users WHERE userid=$userid");
    $stmt->execute();
    $result = $stmt->fetchAll();
    $name = $result[0]['name'];
    $email = $result[0]['email'];
    $password = $result[0]['password'];
    $role = $result[0]['role'];
    
    //update two conditions (checkbox check or not)
    if(isset($_POST['submit'])){
        $upname = $_POST['username'];
        $upemail = $_POST['email'];
            if($_POST['role'] != null){
                $stmt1 = $pdo->prepare("UPDATE users SET name='$upname',email='$upemail',role=1 WHERE userid = $userid");
                $result1 = $stmt1->execute();
                if($result1){
                    echo "<script>alert('Succcessfully updated');window.location.href='user_list.php'</script>";

                }else{
                    echo "<script>alert('Update unsuccess');window.location.href='user_list.php'</script>";

                }

            }else{
                $stmt1 = $pdo->prepare("UPDATE users SET name='$upname',email='$upemail',role=0 WHERE userid = $userid");
                $result1 = $stmt1->execute();
                if($result1){
                    echo "<script>alert('Succcessfully updated');window.location.href='user_list.php'</script>";

                }else{
                    echo "<script>alert('Update unsuccess');window.location.href='user_list.php'</script>";

                }
            }
    }


?>

<!DOCTYPE html>

  
    <?php
        

     include '../admin/header.php';
    ?>
    <!-- Main content -->
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Bordered Table</h3>
            </div>
                <div class="card-body">
                  <form action="#" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="">
                    <div class="form-group">
                        <label for="name" >Name</label>
                        <input type="text" class="form-control" name="username" value="<?php echo $name; ?>" require>
                    </div>
                    <div class="form-group">
                        <label for="email" >Email</label>
                        <input type="email" name="email" class="form-control" value="<?php echo $email; ?>" require>
                    </div>
                    <div class="form-group">
                        <label for="role" >Role</label><br>
                        <input type="checkbox" name="role" <?php if($role == 1){echo 'checked';} ?> ><span style="padding-left:10px;font-weight:bold;color:black;">Admin</span>
                    </div>
                    <div class="form-group mt-2">
                        <input type="submit" name="submit" value="Edit Post" class="btn btn-success">
                        <a href="user_list.php" class="btn btn-outline-dark">Back</a>
                    </div>
                  </form>
                 
                </div>
              
  </div>
  </div>
  </div>
  </div>
  <!-- /.card -->
    <!-- /.content -->
 <?php
include '../admin/footer.php';
 ?>