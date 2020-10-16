<?php include_once('processForm.php') ?>
<!DOCTYPE html>
<html lang="en">
<head>
 
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <!--[if IE]>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <![endif]-->
    <title>Online Library Management System | Student Update Image</title>
    <link rel="icon" href="assets/img/lowaLogo.png" type = "image/x-icon">
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0/css/bootstrap.min.css" />
  <link rel="stylesheet" href="main.css">
</head>

<style>
body {
  background-image: url('assets/img/libraryBackground.jpg');
  background-repeat: no-repeat;
  background-attachment: fixed;
  background-size: cover;
}
</style>

<body>
  <div class="container">
    <div class="row">
      <div class="col-4 offset-md-4 form-div">
        <form action="updateprofileImage.php" method="post" enctype="multipart/form-data">
          <h2 class="text-center mb-3 mt-3" style="color:#007bff">Update profile Image</h2>
          <?php if (!empty($msg)): ?>
            <div class="alert <?php echo $msg_class ?>" role="alert">
              <?php echo $msg; ?>
            </div>
          <?php endif; ?>
          <div class="form-group text-center" style="position: relative;" >
            <span class="img-div">
              <div class="text-center img-placeholder"  onClick="triggerClick()">
                <h4>Update image</h4>
              </div>
              <img src="images/avatar.jpg" onClick="triggerClick()" id="profileDisplay">
            </span>
            <input type="file" name="profileImage" onChange="displayImage(this)" id="profileImage" class="form-control" style="display: none;">
            <label  style="color:white">Profile Image</label>
          </div>
         
          <div class="form-group">
            <button type="submit" name="Student_save_profile" class="btn btn-primary btn-block">Update Profile Image</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</body>
</html>
<script src="script.js"></script>