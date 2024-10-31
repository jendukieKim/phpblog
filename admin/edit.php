<?php
session_start();
require '../config/config.php';

if(empty($_SESSION['userid']) && empty($_SESSION['loggin'])){
  header('Location:login.php');
}
if(!empty($_POST)){
    $postid = $_POST['id'];
    $title = $_POST['title'];
    $content = $_POST['content'];
    
    if($_FILES['image']['name'] != null){
            $file = 'images/'.($_FILES['image']['name']);
        $imageType = pathinfo($file,PATHINFO_EXTENSION);

        if($imageType != 'png' && $imageType != 'jpg' && $imageType != 'jpeg'){
            echo "<script>alert('Image must be png,jpg,jpeg');</script>";
        }else{
           
            $image = $_FILES['image']['name'];
            $author_id = $_SESSION['userId'];
            move_uploaded_file($_FILES['image']['tmp_name'],$file);

           $stmt = $pdo->prepare("UPDATE post SET title='$title',content='$content',image='$image' WHERE postid=$postid");
           $result = $stmt->execute();
           if($result){
            echo "<script>alert('Succcessfully updated');window.location.href='index.php'</script>";
           }

        }
    }else{
        $stmt = $pdo->prepare("UPDATE post SET title='$title',content='$content' WHERE postid=$postid");
           $result = $stmt->execute();
           if($result){
            echo "<script>alert('Succcessfully updated');window.location.href='index.php'</script>";
           }
    }
}

    $postid = $_GET['id'];
    $stmt = $pdo->prepare("SELECT * FROM post WHERE postid=".$postid);
    $stmt->execute();
    $result = $stmt->fetchAll();

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
                    <input type="hidden" name="id" value="<?php echo $result[0]['postid']; ?>">
                    <div class="form-group">
                        <label for="title" >Title</label>
                        <input type="text" class="form-control" name="title" value="<?php echo $result[0]['title']; ?>" require>
                    </div>
                    <div class="form-group">
                        <label for="Content" >Content</label>
                        <textarea name="content" name="content" rows="8" cols="80"  class="form-control"  require><?php echo $result[0]['content']; ?></textarea>
                    </div>
                    <div class="from-group">
                        <label for="image">Image</label><br><br>
                        <img src="images/<?php echo $result[0]['image']; ?>" alt="" width="150" height="150"><br><br>
                        <input type="file" name="image" class="from-control">
                    </div>
                    <div class="form-group mt-2">
                        <input type="submit" name="add" value="Edit Post" class="btn btn-success">
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