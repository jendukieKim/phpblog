<?php
  session_start();
  require('config/config.php');

  if(empty($_SESSION['userId']) && empty($_SESSION['loggin'])){
      header('Location:login.php');
  }

  $postid = $_GET['id'];
  $stmt = $pdo->prepare("SELECT * FROM post WHERE postid = :postid");
  $stmt->execute([':postid' => $postid]);
  $result = $stmt->fetchAll();

  $stmt2 = $pdo->prepare("SELECT * FROM comment WHERE post_id = :post_id");
  $stmt2->execute([':post_id' => $postid]);
  $result2 = $stmt2->fetchAll();

  if($_POST){
    $comment = $_POST['comment'];
    $author = $_SESSION['userId'];
    $stmt1 = $pdo->prepare("INSERT INTO comment(content,author_id,post_id) VALUES(:content, :author_id, :post_id)");
    $result1 = $stmt1->execute([
        ':content' => $comment,
        ':author_id' => $author,
        ':post_id' => $postid
    ]);
    if($result1){
        header('Location:blogdetails.php?id='.$postid);
    }
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Blog</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
  <div class="container">
    <section class="content">
      <div class="container-fluid">
        <div class="card-header">
          <div style="text-align:center !important;float:none" class="card-title">
              <h4><?php echo $result[0]['title']; ?></h4>
          </div>
        </div>
        <div class="card-body">
                <img class="img-fluid pad" src="admin/images/<?php echo $result[0]['image']; ?>" alt="Photo">
                <p><?php echo $result[0]['content']; ?></p>
                <h3>Comments</h3><br>
        </div>
        <div class="card-footer card-comments">
          <?php 
            foreach($result2 as $value2){
              // Fetch user info for each comment author
              $userid = $value2['author_id'];
              $stmt3 = $pdo->prepare("SELECT * FROM users WHERE userid = :userid");
              $stmt3->execute([':userid' => $userid]);
              $result3 = $stmt3->fetch();
          ?>
              <div class="card-comment">
                  <div class="comment-text" style="margin-left:0 !important">
                    <span class="username">
                      <?php echo htmlspecialchars($result3['name']); ?>
                      <span class="text-muted float-right"><?php echo $value2['create_at']; ?></span>
                    </span>
                    <?php echo htmlspecialchars($value2['content']); ?>
                  </div>
              </div>
          <?php
            }
          ?>    
        </div>
        <div class="card-footer">
          <form action="" method="post">
            <div class="img-push">
              <input type="text" name="comment" class="form-control form-control-sm" placeholder="Press enter to post comment">
            </div>
          </form>
        </div>
      </div>
  </div>
  <br><br>
  <footer class="container">
    <div class="float-right d-none d-sm-block">
    <a href="index.php" class="btn btn-default">Back</a>
    </div>
    <strong>&copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights reserved.
  </footer>
</div>
<script src="plugins/jquery/jquery.min.js"></script>
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="dist/js/adminlte.min.js"></script>
<script src="dist/js/demo.js"></script>
</body>
</html>
