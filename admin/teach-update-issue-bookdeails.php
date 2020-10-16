<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['alogin'])==0)
    {   
header('location:index.php');
}
else{ 

if(isset($_POST['return']))
{
$rid=intval($_GET['rid']);
$fine=$_POST['fine'];
$rstatus=1;
$sql="update Ttblissuedbookdetails set fine=:fine,RetrunStatus=:rstatus where id=:rid";
$query = $dbh->prepare($sql);
$query->bindParam(':rid',$rid,PDO::PARAM_STR);
$query->bindParam(':fine',$fine,PDO::PARAM_STR);
$query->bindParam(':rstatus',$rstatus,PDO::PARAM_STR);
$query->execute();



//update quntity starts
$qty=$_SESSION['returnbookquantity'];
$bookid=$_SESSION['bookid_returnbook'];
//$bookid=htmlentities($_SESSION['bookid_returnbook']);
$sqlUpadate="update  tblbooks set quantity=:qty where id=:bookid";
$queryUpadate = $dbh->prepare($sqlUpadate);
$queryUpadate->bindParam(':qty',$qty,PDO::PARAM_STR);
$queryUpadate->bindParam(':bookid',$bookid,PDO::PARAM_STR);
$queryUpadate->execute();

//update quntity ends

$_SESSION['Tmsg']="Book Returned successfully";
header('location:teach-manage-issued-books.php');



}
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Online Library Management System | Issued Book Details</title>
        <link rel="icon" href="assets/img/lowaLogo.png" type = "image/x-icon">
    <!-- BOOTSTRAP CORE STYLE  -->
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <!-- FONT AWESOME STYLE  -->
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <!-- CUSTOM STYLE  -->
    <link href="assets/css/style.css" rel="stylesheet" />
    <!-- GOOGLE FONT -->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
<script>
// function for get student name
function getteacher() {
$("#loaderIcon").show();
jQuery.ajax({
url: "get_teacher.php",
data:'teacherid='+$("#teacherid").val(),
type: "POST",
success:function(data){
$("#get_teacher_name").html(data);
$("#loaderIcon").hide();
},
error:function (){}
});
}

//function for book details
function getbook() {
$("#loaderIcon").show();
jQuery.ajax({
url: "get_book.php",
data:'bookid='+$("#bookid").val(),
type: "POST",
success:function(data){
$("#get_book_name").html(data);
$("#loaderIcon").hide();
},
error:function (){}
});
}

</script> 
<style type="text/css">
  .others{
    color:red;
}

</style>


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
      <!------MENU SECTION START-->
<?php include('includes/header.php');?>
<!-- MENU SECTION END-->
   
    <div class="content-wrapper">
         <div class="container">
        <div class="row pad-botm">
            <div class="col-md-12">
                <h2 class="header-line" style="color:white">Issued Book Details</h2>
                
                            </div>

</div>
<div class="row">
<div class="col-md-10 col-sm-6 col-xs-12 col-md-offset-1"">
<div class="panel panel-info">
<div class="panel-heading">
Issued Book Details
</div>
<div class="panel-body">
<form role="form" method="post">
<?php 
$rid=intval($_GET['rid']);
$sql = "SELECT tblteachers.FullName,tblbooks.BookName,tblbooks.id,tblbooks.quantity,tblbooks.ISBNNumber,ttblissuedbookdetails.IssuesDate,ttblissuedbookdetails.ReturnDate,ttblissuedbookdetails.id as rid,ttblissuedbookdetails.fine,ttblissuedbookdetails.RetrunStatus from  ttblissuedbookdetails join tblteachers on tblteachers.TeacherId=ttblissuedbookdetails.TeacherID join tblbooks on tblbooks.id=ttblissuedbookdetails.BookId where ttblissuedbookdetails.id=:rid";
$query = $dbh -> prepare($sql);
$query->bindParam(':rid',$rid,PDO::PARAM_STR);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $result)
{               ?>                                      
                   

                   
<?php $_SESSION['returnbookquantity']=($result->quantity)+1; 
$_SESSION['bookid_returnbook']=($result->id);
?>

<div class="form-group">
<label>Teacher Name :</label>
<?php echo htmlentities($result->FullName);?>
</div>

<div class="form-group">
<label>Book Name :</label>
<?php echo htmlentities($result->BookName);?>
</div>


<div class="form-group">
<label>ISBN :</label>
<?php echo htmlentities($result->ISBNNumber);?>
</div>

<div class="form-group">
<label>Book Issued Date :</label>
<?php echo htmlentities($result->IssuesDate);?>
</div>


<div class="form-group">
<label>Book Returned Date :</label>
<?php if($result->ReturnDate=="")
                                            {?>
                                            <span style="color:red">
                                             <?php   echo htmlentities("Not Return Yet"); ?>
                                                </span>
                                            <?php 
                                            } else {


                                            echo htmlentities($result->ReturnDate);
}
                                            ?>
</div>

<div class="form-group">
<label>Fine (in USD) :</label>
<?php 
if($result->fine=="")
{?>
<input class="form-control" type="text" name="fine" id="fine"  required />

<?php }else {
echo htmlentities($result->fine);
}
?>
</div>
 <?php if($result->RetrunStatus==0){?>

<button type="submit" name="return" id="submit" class="btn btn-info">Return Book </button>

 </div>

<?php }}} ?>
                                    </form>
                            </div>
                        </div>
                            </div>

        </div>
   
    </div>
    </div>
     <!-- CONTENT-WRAPPER SECTION END-->
  <?php include('includes/footer.php');?>
      <!-- FOOTER SECTION END-->
    <!-- JAVASCRIPT FILES PLACED AT THE BOTTOM TO REDUCE THE LOADING TIME  -->
    <!-- CORE JQUERY  -->
    <script src="assets/js/jquery-1.10.2.js"></script>
    <!-- BOOTSTRAP SCRIPTS  -->
    <script src="assets/js/bootstrap.js"></script>
      <!-- CUSTOM SCRIPTS  -->
    <script src="assets/js/custom.js"></script>

</body>
</html>
<?php } ?>
