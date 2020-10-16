<?php
session_start();

  $msg = "";
  $msg_class = "";
  $conn = mysqli_connect("localhost", "root", "", "library");
  if (isset($_POST['Teacher_save_profile'])) {
    // for the database
   // $bio = stripslashes($_POST['bio']);
    $profileImageName = time() . '-' . $_FILES["profileImage"]["name"];
    // For image upload
    $target_dir = "images/";
    $target_file = $target_dir . basename($profileImageName);
    // VALIDATION
    // validate image size. Size is calculated in Bytes
    if($_FILES['profileImage']['size'] > 200000) {
      $msg = "Image size should not be greated than 200Kb";
      $msg_class = "alert-danger";
    }
    // check if file exists
    if(file_exists($target_file)) {
      $msg = "File already exists";
      $msg_class = "alert-danger";
    }
    $tid=$_SESSION['teachid'];
    // Upload image only if no errors
    if (empty($error)) {
      if(move_uploaded_file($_FILES["profileImage"]["tmp_name"], $target_file)) {

      $sql="update tblteachers set profile_image='$profileImageName' where TeacherId='$tid'";

        if(mysqli_query($conn, $sql)){
          $msg = "Image uploaded";
          $msg_class = "alert-success";
          echo "<script type='text/javascript'> document.location ='my-profile.php'; </script>";

        } else {
          $msg = "There was an error in the database";
          $msg_class = "alert-danger";
        }
      } else {
        $error = "There was an erro uploading the file";
        $msg = "alert-danger";
      }
    }
  }
?>