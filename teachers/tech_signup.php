<?php 
session_start();
include('includes/config.php');
include_once('techSignupForm.php');
error_reporting(0);
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
  <meta name="description" content="" />
  <meta name="author" content="" />
    <!--[if IE]>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
      <![endif]-->
      <title>Online Library Management System | Teacher Signup</title>
      <link rel="icon" href="assets/img/lowaLogo.png" type = "image/x-icon">
      <!-- BOOTSTRAP CORE STYLE  -->
      <link href="assets/css/bootstrap.css" rel="stylesheet" />
      <!-- FONT AWESOME STYLE  -->
      <link href="assets/css/font-awesome.css" rel="stylesheet" />
      <!-- CUSTOM STYLE  -->
      <link href="assets/css/style.css" rel="stylesheet" />
      <link rel="stylesheet" href="main.css">
      <!-- GOOGLE FONT -->
      <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />


      <script type="text/javascript">
        function valid()
        {
          if(document.signup.password.value!= document.signup.confirmpassword.value)
          {
            alert("Password and Confirm Password Field do not match  !!");
            document.signup.confirmpassword.focus();
            return false;
          }
          return true;
        }
      </script>
      <script>
        function checkAvailability() {
          $("#loaderIcon").show();
          jQuery.ajax({
            url: "check_availability.php",
            data:'emailid='+$("#emailid").val(),
            type: "POST",
            success:function(data){
              $("#user-availability-status").html(data);
              $("#loaderIcon").hide();
            },
            error:function (){}
          });
        }
      </script>   
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
      <?php include('includes/header.php');?>

      <!-- MENU SECTION END-->
      <div class="content-wrapper">
       <div class="container">
        <div class="row pad-botm">
          <div class="col-md-12">
            <h2 class="header-line" style="color:white">Teacher Signup</h2>
            
          </div>

        </div>
        <div class="row">
         
          <div class="col-md-9 col-md-offset-1">
           <div class="panel panel-danger">
            <div class="panel-heading">
             SINGUP FORM
           </div>
           <div class="panel-body">
            <!-- issue -->

            <form action="tech_signup.php" method="post" enctype="multipart/form-data"  onSubmit="return valid();">
              
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
                <input type="file" name="profileImage" onChange="displayImage(this)" id="profileImage" class="form-control" style="display: none;" required>
                <label>Profile Image</label>
              </div>
              

              <div class="form-group">
                <label>Enter Full Name</label>
                <input class="form-control" type="text" name="fullanme" autocomplete="off" required />
              </div>


              <div class="form-group">
                <label>Mobile Number :</label>
                <input class="form-control" type="text" name="mobileno" maxlength="20" autocomplete="off" required />
              </div>
              
              <div class="form-group">
                <label>Enter Email</label>
                <input class="form-control" type="email" name="email" id="emailid" onBlur="checkAvailability()"  autocomplete="off" required  />
                <span id="user-availability-status" style="font-size:12px;"></span> 
              </div>

              <div class="form-group">
                <label>Enter Password</label>
                <input class="form-control" type="password" name="password" autocomplete="off" required  />
              </div>

              <div class="form-group">
                <label>Confirm Password </label>
                <input class="form-control"  type="password" name="confirmpassword" autocomplete="off" required  />
              </div>
              <div class="form-group">
                <label>Verification code : </label>
                <input type="text"  name="vercode" maxlength="5" autocomplete="off" required style="width: 150px; height: 25px;" />&nbsp;<img src="captcha.php">
              </div>                                


              <div class="form-group">
                <button type="submit" name="teacher_signup" class="btn btn-primary btn-block">Register Now </button>
                
              </div>
            </form>
          </div>
        </div>
      </div>

    </div>
  </div>
</div>
<!-- CONTENT-WRAPPER SECTION END-->
<?php include('includes/footer.php');?>

<script src="assets/js/jquery-1.10.2.js"></script>
<!-- BOOTSTRAP SCRIPTS  -->
<script src="assets/js/bootstrap.js"></script>
<script src="assets/js/custom.js"></script>
</body>
</html>
<script src="Imagescript.js"></script>