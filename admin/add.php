<?php
session_start();
require '../config/config.php';

if(empty($_SESSION['userid']) && empty($_SESSION['loggin'])){
  header('Location:login.php');
}

    if(!empty($_POST)){
       
        $file = 'images/'.($_FILES['image']['name']);
        $imageType = pathinfo($file,PATHINFO_EXTENSION);

        if($imageType != 'png' && $imageType != 'jpg' && $imageType != 'jpeg'){
            echo "<script>alert('Image must be png,jpg,jpeg');</script>";
        }else{
            $title = $_POST['title'];
            $content = $_POST['content'];
            $image = $_FILES['image']['name'];
            $author_id = $_SESSION['userId'];
            move_uploaded_file($_FILES['image']['tmp_name'],$file);

            $stmt = $pdo->prepare("INSERT INTO post(title,content,author_id,image) values(:title,:content,:author_id,:image)");
            $result = $stmt->execute(
                array(
                    ':title'=> $title,
                    ':content'=> $content,
                    ':image' => $image,
                    ':author_id'=> $author_id,
                )
            );

            if($result){
                echo "<script>alert('New post successfully added');window.location.href='index.php';</script>";
            }else{
                echo "<script>alert('New post added unsuccessful');</script>";
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
                    <div class="form-group">
                        <label for="title" >Title</label>
                        <input type="text" class="form-control" name="title" value="" require>
                    </div>
                    <div class="form-group">
                        <label for="Content" >Content</label>
                        <textarea name="content" name="content" rows="8" cols="80"  value="" class="form-control" require></textarea>
                    </div>
                    <div class="from-group">
                        <label for="image">Image</label><br><br>
                        <input type="file" name="image" class="from-control">
                    </div>
                    <div class="form-group mt-2">
                        <input type="submit" name="add" value="Add Post" class="btn btn-success">
                        <a href="index.php" class="btn btn-outline-dark">Back</a>
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