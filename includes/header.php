<div class="navbar navbar-inverse set-radius-zero" >
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" >

                    <img src="assets/img/logo2.png" />
                </a>

            </div>
<?php if($_SESSION['login'])
{
?> 
            <div class="right-div">
             <span style="font-weight: bold;"><?php echo "Student | "?><a href="my-profile.php"><?php echo strtoupper($_SESSION['SName']); ?></a></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <img src="<?php if($_SESSION['std_profile_image']){ echo 'images/'.$_SESSION['std_profile_image'];} else {echo 'images/avatar.jpg';}?>" style="height:50px; weight:50px; border-radius:50%;" alt="No img" />&nbsp;&nbsp;&nbsp;&nbsp;
               <a href="logout.php" class="btn btn-danger pull-right">LOG OUT</a>
            </div>
            <?php }?>
        </div>
    </div>
    <!-- LOGO HEADER END-->
<?php if($_SESSION['login'])
{
?>    
<section class="menu-section">
        <div class="container">
            <div class="row ">
                <div class="col-md-12">
                    <div class="navbar-collapse collapse ">
                        <ul id="menu-top" class="nav navbar-nav navbar-right">
                            <li><a href="dashboard.php" class="menu-top-active">DASHBOARD</a></li>
                           
                          
   <li>
                                <a href="#" class="dropdown-toggle" id="ddlmenuItem" data-toggle="dropdown"> Account <i class="fa fa-angle-down"></i></a>
                                <ul class="dropdown-menu" role="menu" aria-labelledby="ddlmenuItem">
                                    <li role="presentation"><a role="menuitem" tabindex="-1" href="my-profile.php">My Profile</a></li>
                                     <li role="presentation"><a role="menuitem" tabindex="-1" href="change-password.php">Change Password</a></li>
                                </ul>
                            </li>
                            <li><a href="issued-books.php">Issued Books</a></li>
                            <li><a href="available-books.php">Avalable Books</a></li>
                          

                        </ul>
                    </div>
                </div>

            </div>
        </div>
    </section>
    <?php } else { ?>
        <section class="menu-section">
        <div class="container">
            <div class="row ">
                <div class="col-md-12">
                    <div class="navbar-collapse collapse ">
                        <ul id="menu-top" class="nav navbar-nav navbar-right">                        
                          
                            <li><a href="adminlogin.php">LIBRARIAN Login</a></li>
                            
                            <!--STUDENTS PANEL -->
                            <li><a href="signup.php">STUDENT Signup</a></li>
                             <li><a href="index.php">STUDENT Login</a></li>

                             <!--PROFESSORS PANEL -->
                             <li><a href="./teachers/tech_signup.php">TEACHER Signup</a></li>
                             <li><a href="./teachers/tech_login.php">TEACHER Login</a></li>
                          

                        </ul>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <?php } ?>