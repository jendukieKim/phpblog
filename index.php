<?php
    session_start();
    require('config/config.php');
        if(empty($_SESSION['userId']) && empty($_SESSION['loggin'])){
            header('Location:login.php');
        }

        if(!empty($_GET['pageno'])){
            $pageno = $_GET['pageno'];
          }else{
            $pageno = 1;
          }
          $numOfrecs = 3;
          $offset = ($pageno-1)*$numOfrecs;

          $stmt1 = $pdo->prepare("SELECT * FROM post ORDER BY postid DESC");
          $stmt1->execute();
          $rawResult = $stmt1->fetchAll();
          $total_pages = ceil(count($rawResult)/$numOfrecs);
  
          $stmt1 = $pdo->prepare("SELECT * FROM post ORDER BY postid DESC LIMIT $offset,$numOfrecs ");
          $stmt1->execute();
          $result1 = $stmt1->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Blog</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
</head>
<body class="hold-transition sidebar-mini">
    <div class="container mt-1">
        <h4  style="text-align:center;">Blogs</h4>
        <?php
            // $stmt = $pdo->prepare("SELECT * FROM post ORDER BY postid DESC");
            // $stmt->execute();
            // $result = $stmt->fetchAll();
        ?>
        <div class="row">
        <?php
            if($result1){
                 $i = 1;
                  foreach($result1 as $value){
                          ?>
                  <div class="col-md-4">
                <!-- Box Comment -->
                <div class="card card-widget">
                <div class="card-header">
                    <div class="card-title" style="text-align: center !important;float:none;">
                        <h4><?php echo $value['title'] ?></h4>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <a href="blogdetails.php?id=<?php echo $value['postid']; ?>">
                    <img src="admin/images/<?php echo $value['image']; ?>" class="img-fluid pad" alt="Photo"  style="height:200px !important">

                    </a>
                </div>
                </div>
                <!-- /.card -->
            </div>
                      <?php
                      $i++;
                        }
                      }
                      ?>
                      
            
            
            <!-- /.col -->
        </div>
                <nav aria-label="Page navigation example" class="mt-2">
                  <ul class="pagination justify-content-end">
                    <li class="page-item"><a class="page-link" href="?pageno=1">First</a></li>
                    <li class="page-item <?php if($pageno<=1){echo 'disabled';} ?>">
                      <a class="page-link" href="<?php if($pageno<=1){echo '#';}else{echo "?pageno=".($pageno-1);} ?>">Previous</a>
                    </li>
                    <li class="page-item"><a class="page-link" href="#"><?php echo $pageno; ?></a></li>
                    <li class="page-item <?php if($pageno>=$total_pages){echo 'disabled';} ?>">
                      <a class="page-link" href="<?php if($pageno>=$total_pages){echo '#';}else{echo "?pageno=".($pageno+1);} ?>">Next</a></li>
                    <li class="page-item"><a class="page-link" href="?pageno=<?php echo $total_pages; ?>">Last</a></li>
                  </ul>
                </nav>
    </div>
            
<!-- ./wrapper -->
  <!-- Main Footer -->
  <footer class="main-footer ml-0">
    <!-- To the right -->
    <div class="float-right d-none d-sm-inline">
      <a href="logout.php" class="btn btn-outline-danger">Logout</a>
    </div>
    <!-- Default to the left -->
    <strong>Copyright &copy; 2024 <a href="https://adminlte.io">Ingyin Phyo</a>.</strong> All rights reserved.
  </footer>
<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
</body>
</html>
