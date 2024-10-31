<?php
session_start();
require '../config/config.php';

if(empty($_SESSION['userId']) && empty($_SESSION['loggin'])){
  header('Location:login.php');
}


?>

<!DOCTYPE html>

  
    <?php

        if(!empty($_GET['pageno'])){
          $pageno = $_GET['pageno'];
        }else{
          $pageno = 1;
        }
        $numOfrecs = 2;
        $offset = ($pageno-1)*$numOfrecs;

          if(empty($_POST['search'])){
            $stmt = $pdo->prepare("SELECT * FROM POST ORDER BY postid DESC");
            $stmt->execute();
            $rawResult = $stmt->fetchAll();
            $total_pages = ceil(count($rawResult)/$numOfrecs);
    
            $stmt = $pdo->prepare("SELECT * FROM post ORDER BY postid DESC LIMIT $offset,$numOfrecs ");
            $stmt->execute();
            $result = $stmt->fetchAll();
    
          }else{
            $searchKey = $_POST['search'];
            $stmt = $pdo->prepare("SELECT * FROM POST WHERE title LIKE '%$searchKey%' ORDER BY postid DESC");
            $stmt->execute();
            $rawResult = $stmt->fetchAll();
            $total_pages = ceil(count($rawResult)/$numOfrecs);
    
            $stmt = $pdo->prepare("SELECT * FROM post WHERE title LIKE '%$searchKey%' ORDER BY postid DESC LIMIT $offset,$numOfrecs ");
            $stmt->execute();
            $result = $stmt->fetchAll();
    
          }
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
                  <div class="mb-2">
                    <a href="add.php" class="btn btn-success">New Blog Post</a>
                  </div>
                  <table class="table table-bordered">
                    <thead>
                      <tr>
                        <th style="width: 10px">#</th>
                        <th>Title</th>
                        <th>Description</th>
                        <th style="width: fit-content;">Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      if($result){
                      $i = 1;
                        foreach($result as $value){
                          ?>
                        <tr>
                        <td><?php echo $i;  ?></td>
                        <td><?php echo $value['title']  ?></td>
                        <td>
                        <?php echo substr($value['content'],0,50);  ?> 
                        </td>
                        <td>
                          <div class="btn-group">
                            <div class="container">
                              <a href="edit.php?id=<?php echo $value['postid'] ?>" class="btn btn-warning">Edit</a>
                            </div>
                            <div class="container">
                              <a href="delete.php?id=<?php echo $value['postid'] ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete?')">Delete</a>
                            </div>
                          </div>
                        </td>
                      </tr>
                      <?php
                      $i++;
                        }
                      }
                      ?>
                      
                      
                    </tbody>
                  </table>
                
                <nav aria-label="Page navigation example" class="mt-2">
                  <ul class="pagination justify-content-end">
                    <li class="page-item"><a class="page-link" href="?pageno=1">First</a></li>
                    <li class="page-item <?php if($pageno<=1){echo 'disabled';} ?>">
                      <a class="page-link" href="<?php if($pageno<=1){echo '#';}else{echo "?pageno=".($pageno-1);} ?>">Previous</a>
                    </li>
                    <li class="page-item"><a class="page-link" href="#"><?php echo $pageno; ?></a></li>
                    <li class="page-item <?php if($pageno>=$total_pages){echo 'disabled';} ?>">
                      <a class="page-link" href="<?php if($pageno>=$total_pages){echo '#';}else{echo "?pageno=".($pageno+1);} ?>">Next</a></li>
                    <li class="page-item"><a class="page-link" href="<?php echo $total_pages; ?>">Last</a></li>
                  </ul>
                </nav>
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