<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['login'])==0)
    {   
header('location:index.php');
}
else{ 


  //  echo $_SESSION['stdid'];//student id


if(isset($_POST['reserve']))
{

//check if book already borrow or not starts
 
$sid_borrow=$_SESSION['stdid'];
$rsts=0;
$sqlB ="SELECT id,BookId from tblissuedbookdetails where StudentID=:sid_borrow and RetrunStatus=:rsts";
$queryB = $dbh -> prepare($sqlB);
$queryB->bindParam(':sid_borrow',$sid_borrow,PDO::PARAM_STR);
$queryB->bindParam(':rsts',$rsts,PDO::PARAM_STR);
$queryB->execute();
$resultsB=$queryB->fetchAll(PDO::FETCH_OBJ);
$Borrowedbooks=$queryB->rowCount();


if($queryB->rowCount()>0){
    $_SESSION['error']="You have already borrowed a book. Please return it first OR Contact Librarian";
    header('location:issued-books.php');
}
else{
//check if book already borrow or not ends

$studentid=strtoupper($_SESSION['stdid']);
$bookid=intval($_GET['bookid']);
$sql="INSERT INTO  tblissuedbookdetails(StudentID,BookId) VALUES(:studentid,:bookid)";
$query = $dbh->prepare($sql);
$query->bindParam(':studentid',$studentid,PDO::PARAM_STR);
$query->bindParam(':bookid',$bookid,PDO::PARAM_STR);
$query->execute();
$lastInsertId = $dbh->lastInsertId();
if($lastInsertId)
{

//update quantity starts
$qty=$_SESSION['bookquantity'];
//$bookid=intval($_GET['bookid']);
$sqlUpadate="update  tblbooks set quantity=:qty where id=:bookid";
$queryUpadate = $dbh->prepare($sqlUpadate);
$queryUpadate->bindParam(':qty',$qty,PDO::PARAM_STR);
$queryUpadate->bindParam(':bookid',$bookid,PDO::PARAM_STR);
$queryUpadate->execute();

//update quantity ends

//insert studentid for checking reserved book starts
//$studentid=strtoupper($_SESSION['stdid']);
//$bookid=intval($_GET['bookid']);
$sqlInsert="INSERT INTO  studentTempBook(StudentID,BookId) VALUES(:studentid,:bookid)";
$queryInsert = $dbh->prepare($sqlInsert);
$queryInsert->bindParam(':studentid',$studentid,PDO::PARAM_STR);
$queryInsert->bindParam(':bookid',$bookid,PDO::PARAM_STR);
$queryInsert->execute();

//insert studentid for checking reserved book ends



$_SESSION['msg']="Book issued successfully";
header('location:issued-books.php');
}
else 
{
$_SESSION['error']="Something went wrong. Please try again";
header('location:issued-books.php');
}
}
}
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Online Library Management System | Reserve Book</title>
    <link rel="icon" href="assets/img/lowaLogo.png" type = "image/x-icon">
    <!-- BOOTSTRAP CORE STYLE  -->
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <!-- FONT AWESOME STYLE  -->
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <!-- CUSTOM STYLE  -->
    <link href="assets/css/style.css" rel="stylesheet" />
    <!-- GOOGLE FONT -->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />

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
                <h2 class="header-line" style="color:white">Reserve Book</h2>
                
                            </div>

</div>
<div class="row">
<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3"">
<div class="panel panel-info">
<div class="panel-heading">
Book Info
</div>
<div class="panel-body">
<form role="form" method="post">
<?php 
$bookid=intval($_GET['bookid']);
$sql = "SELECT tblbooks.BookName,tblcategory.CategoryName,tblcategory.id as cid,tblauthors.AuthorName,tblauthors.id as athrid,tblbooks.ISBNNumber,tblbooks.BookPrice,tblbooks.quantity,tblbooks.id as bookid from  tblbooks join tblcategory on tblcategory.id=tblbooks.CatId join tblauthors on tblauthors.id=tblbooks.AuthorId where tblbooks.id=:bookid";
$query = $dbh -> prepare($sql);
$query->bindParam(':bookid',$bookid,PDO::PARAM_STR);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $result)
{               ?>  

<div class="form-group">
<label>Book Name<span style="color:red;">*</span></label>
<input class="form-control" type="text" name="bookname" value="<?php echo htmlentities($result->BookName);?>" required />
</div>

<div class="form-group">
<label> Category<span style="color:red;">*</span></label>
<select class="form-control" name="category" required="required">
<option value="<?php echo htmlentities($result->cid);?>"> <?php echo htmlentities($catname=$result->CategoryName);?></option>
<?php 
$status=1;
$sql1 = "SELECT * from  tblcategory where Status=:status";
$query1 = $dbh -> prepare($sql1);
$query1-> bindParam(':status',$status, PDO::PARAM_STR);
$query1->execute();
$resultss=$query1->fetchAll(PDO::FETCH_OBJ);
if($query1->rowCount() > 0)
{
foreach($resultss as $row)
{           
if($catname==$row->CategoryName)
{
continue;
}
else
{
    ?>  
<option value="<?php echo htmlentities($row->id);?>"><?php echo htmlentities($row->CategoryName);?></option>
 <?php }}} ?> 
</select>
</div>


<div class="form-group">
<label> Author<span style="color:red;">*</span></label>
<select class="form-control" name="author" required="required">
<option value="<?php echo htmlentities($result->athrid);?>"> <?php echo htmlentities($athrname=$result->AuthorName);?></option>
<?php 

$sql2 = "SELECT * from  tblauthors ";
$query2 = $dbh -> prepare($sql2);
$query2->execute();
$result2=$query2->fetchAll(PDO::FETCH_OBJ);
if($query2->rowCount() > 0)
{
foreach($result2 as $ret)
{           
if($athrname==$ret->AuthorName)
{
continue;
} else{

    ?>  
<option value="<?php echo htmlentities($ret->id);?>"><?php echo htmlentities($ret->AuthorName);?></option>
 <?php }}} ?> 
</select>
</div>

<div class="form-group">
<label>ISBN Number<span style="color:red;">*</span></label>
<input class="form-control" type="text" name="isbn" value="<?php echo htmlentities($result->ISBNNumber);?>"  required="required" />
<p class="help-block">An ISBN is an International Standard Book Number.ISBN Must be unique</p>
</div>

 <div class="form-group">
 <label>Price in USD<span style="color:red;">*</span></label>
 <input class="form-control" type="text" name="price" value="<?php echo htmlentities($result->BookPrice);?>"   required="required" />
 </div>


 <div class="form-group">
 <label>Quantity<span style="color:red;">*</span></label>
 <input class="form-control" type="text" name="qty" value="<?php if($result->quantity>0){ $_SESSION['bookquantity']=($result->quantity)-1;echo htmlentities("Available");}else{echo htmlentities("Not Available");}?>"   />
 </div>
 <?php }} ?>
<button type="submit" name="reserve" class="btn btn-info">Reserve Book </button>

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
