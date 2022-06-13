<?php 
session_start();
include('includes/config.php');
error_reporting(0);
if(isset($_POST['submit']))
{
$fromdate=$_POST['fromdate'];
$todate=$_POST['todate']; 
$message=$_POST['message'];
$useremail=$_SESSION['login'];
$status=0;
$stid=$_GET['stid'];
$bookingno=mt_rand(100000000, 999999999);
$ret="SELECT * FROM tblbooking where (:fromdate BETWEEN date(FromDate) and date(ToDate) || :todate BETWEEN date(FromDate) and date(ToDate) || date(FromDate) BETWEEN :fromdate and :todate) and StudentId=:stid";
$query1 = $dbh -> prepare($ret);
$query1->bindParam(':stid',$stid, PDO::PARAM_STR);
$query1->bindParam(':fromdate',$fromdate,PDO::PARAM_STR);
$query1->bindParam(':todate',$todate,PDO::PARAM_STR);
$query1->execute();
$results1=$query1->fetchAll(PDO::FETCH_OBJ);

if($query1->rowCount()==0)
{

$sql="INSERT INTO  tblbooking(BookingNumber,userEmail,VehicleId,FromDate,ToDate,message,Status) VALUES(:bookingno,:useremail,:stid,:fromdate,:todate,:message,:status)";
$query = $dbh->prepare($sql);
$query->bindParam(':bookingno',$bookingno,PDO::PARAM_STR);
$query->bindParam(':useremail',$useremail,PDO::PARAM_STR);
$query->bindParam(':stid',$stid,PDO::PARAM_STR);
$query->bindParam(':fromdate',$fromdate,PDO::PARAM_STR);
$query->bindParam(':todate',$todate,PDO::PARAM_STR);
$query->bindParam(':message',$message,PDO::PARAM_STR);
$query->bindParam(':status',$status,PDO::PARAM_STR);
$query->execute();
$lastInsertId = $dbh->lastInsertId();
if($lastInsertId)
{
echo "<script>alert('Selecting student successfull.');</script>";
echo "<script type='text/javascript'> document.location = 'my-student.php'; </script>";
}
else 
{
echo "<script>alert('Something went wrong. Please try again');</script>";
 echo "<script type='text/javascript'> document.location = 'class-listing.php'; </script>";
} }  else{
 echo "<script>alert('Car already booked for these days');</script>"; 
 echo "<script type='text/javascript'> document.location = 'class-listing.php'; </script>";
}

}

?>


<!DOCTYPE HTML>
<html lang="en">
<head>

<title>C-Hunter | Student Details</title>
<!--Bootstrap -->
<link rel="stylesheet" href="assets/css/bootstrap.min.css" type="text/css">
<!--Custome Style -->
<link rel="stylesheet" href="assets/css/style.css" type="text/css">
<!--OWL Carousel slider-->
<link rel="stylesheet" href="assets/css/owl.carousel.css" type="text/css">
<link rel="stylesheet" href="assets/css/owl.transitions.css" type="text/css">
<!--slick-slider -->
<link href="assets/css/slick.css" rel="stylesheet">
<!--bootstrap-slider -->
<link href="assets/css/bootstrap-slider.min.css" rel="stylesheet">
<!--FontAwesome Font Style -->
<link href="assets/css/font-awesome.min.css" rel="stylesheet">

<!-- SWITCHER -->
		<link rel="stylesheet" id="switcher-css" type="text/css" href="assets/switcher/css/switcher.css" media="all" />
		<link rel="alternate stylesheet" type="text/css" href="assets/switcher/css/red.css" title="red" media="all" data-default-color="true" />
		<link rel="alternate stylesheet" type="text/css" href="assets/switcher/css/orange.css" title="orange" media="all" />
		<link rel="alternate stylesheet" type="text/css" href="assets/switcher/css/blue.css" title="blue" media="all" />
		<link rel="alternate stylesheet" type="text/css" href="assets/switcher/css/pink.css" title="pink" media="all" />
		<link rel="alternate stylesheet" type="text/css" href="assets/switcher/css/green.css" title="green" media="all" />
		<link rel="alternate stylesheet" type="text/css" href="assets/switcher/css/purple.css" title="purple" media="all" />
<link rel="apple-touch-icon-precomposed" sizes="144x144" href="assets/images/favicon-icon/apple-touch-icon-144-precomposed.png">
<link rel="apple-touch-icon-precomposed" sizes="114x114" href="assets/images/favicon-icon/apple-touch-icon-114-precomposed.html">
<link rel="apple-touch-icon-precomposed" sizes="72x72" href="assets/images/favicon-icon/apple-touch-icon-72-precomposed.png">
<link rel="apple-touch-icon-precomposed" href="assets/images/favicon-icon/apple-touch-icon-57-precomposed.png">
<link rel="shortcut icon" href="assets/images/favicon-icon/favicon.png">
<link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,900" rel="stylesheet">
</head>
<body>

<!-- Start Switcher -->
<?php include('includes/colorswitcher.php');?>
<!-- /Switcher -->  

<!--Header-->
<?php include('includes/header.php');?>
<!-- /Header --> 

<!--Listing-Image-Slider-->

<?php 
$stid=intval($_GET['stid']);
$sql = "SELECT tblstudent.*,tblclass.Classname,tblclass.id as cid  from tblstudent join tblclass on tblclass.id=tblstudent.StudentClass where tblstudent.id=:stid";
$query = $dbh -> prepare($sql);
$query->bindParam(':stid',$stid, PDO::PARAM_STR);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $result)
{  
$_SESSION['brndid']=$result->cid;  
?>  

<section id="listing_img_slider">
  <div><img src="admin/img/studentimages/<?php echo htmlentities($result->Vimage1);?>" class="img-responsive" alt="image" width="900" height="560"></div>
  <div><img src="admin/img/studentimages/<?php echo htmlentities($result->Vimage2);?>" class="img-responsive" alt="image" width="900" height="560"></div>
  <div><img src="admin/img/studentimages/<?php echo htmlentities($result->Vimage3);?>" class="img-responsive" alt="image" width="900" height="560"></div>
  <div><img src="admin/img/studentimages/<?php echo htmlentities($result->Vimage4);?>" class="img-responsive"  alt="image" width="900" height="560"></div>
  <?php if($result->Vimage5=="")
{

} else {
  ?>
  <div><img src="admin/img/studentimages/<?php echo htmlentities($result->Vimage5);?>" class="img-responsive" alt="image" width="900" height="560"></div>
  <?php } ?>
</section>
<!--/Listing-Image-Slider-->


<!--Listing-detail-->
<section class="listing-detail">
  <div class="container">
    <div class="listing_detail_head row">
      <div class="col-md-9">
        <h2><?php echo htmlentities($result->ClassName);?>  <?php echo htmlentities($result->StudentName);?></h2>
      </div>
      <div class="col-md-3">
        <div class="price_info">
        <p><?php echo htmlentities($result->StudentID);?> </p>Student ID
         
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-9">
        <div class="main_features">
          <ul>
          
          <li> <i class="fa fa-calendar" aria-hidden="true"></i>
          <p>Timer</p>
              <h5><?php echo htmlentities($result->Timer);?></h5>
            </li>
            <li> <i class="fa fa-cogs" aria-hidden="true"></i>
            <p>Level</p>
              <h5><?php echo htmlentities($result->Level);?></h5>
            </li>
       
          </ul>
        </div>
        <div class="listing_more_info">
          <div class="listing_detail_wrap"> 
            <!-- Nav tabs -->
            <ul class="nav nav-tabs gray-bg" role="tablist">
              <li role="presentation" class="active"><a href="#student-overview " aria-controls="student-overview" role="tab" data-toggle="tab">Student Overview </a></li>
          
              <li role="presentation"><a href="#accessories" aria-controls="accessories" role="tab" data-toggle="tab">Player Record</a></li>
            </ul>
            
            <!-- Tab panes -->
            <div class="tab-content"> 
              <!-- student-overview -->
              <div role="tabpanel" class="tab-pane active" id="student-overview">
                
                <p><?php echo htmlentities($result->StudentOverview);?></p>
              </div>
              
              
              <!-- Accessories -->
              <div role="tabpanel" class="tab-pane" id="accessories"> 
                <!--Accessories-->
                <table>
                  <thead>
                    <tr>
                      <th colspan="2">Level</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>Level 1</td>
<?php if($result->AirConditioner==1)
{
?>
                      <td><i class="fa fa-check" aria-hidden="true"></i></td>
<?php } else { ?> 
   <td><i class="fa fa-close" aria-hidden="true"></i></td>
   <?php } ?> </tr>

<tr>
<td>Level 2</td>
<?php if($result->AntiLockBrakingSystem==1)
{
?>
<td><i class="fa fa-check" aria-hidden="true"></i></td>
<?php } else {?>
<td><i class="fa fa-close" aria-hidden="true"></i></td>
<?php } ?>
                    </tr>

<tr>
<td>Level 3</td>
<?php if($result->PowerSteering==1)
{
?>
<td><i class="fa fa-check" aria-hidden="true"></i></td>
<?php } else { ?>
<td><i class="fa fa-close" aria-hidden="true"></i></td>
<?php } ?>
</tr>
                   

<tr>

<td>Level 4</td>

<?php if($result->PowerWindows==1)
{
?>
<td><i class="fa fa-check" aria-hidden="true"></i></td>
<?php } else { ?>
<td><i class="fa fa-close" aria-hidden="true"></i></td>
<?php } ?>
</tr>
                   

<tr>
<td>Level 5</td>
<?php if($result->CrashSensor==1)
{
?>
<td><i class="fa fa-check" aria-hidden="true"></i></td>
<?php } else { ?>
<td><i class="fa fa-close" aria-hidden="true"></i></td>
<?php } ?>
</tr>

                  </tbody>
                </table>
              </div>
            </div>
          </div>
          
        </div>
<?php }} ?>
   
      </div>
      
       <!--Side-Bar-->
       <aside class="col-md-3">
      
      <div class="share_vehicle">
        <p>Share: <a href="#"><i class="fa fa-facebook-square" aria-hidden="true"></i></a> <a href="#"><i class="fa fa-twitter-square" aria-hidden="true"></i></a> <a href="#"><i class="fa fa-linkedin-square" aria-hidden="true"></i></a> <a href="#"><i class="fa fa-google-plus-square" aria-hidden="true"></i></a> </p>
      </div>
      <div class="sidebar_widget">
        <div class="widget_heading">
          <h5><i class="fa fa-envelope" aria-hidden="true"></i>Select Student</h5>
        </div>
        <form method="post">
          <!-- <div class="form-group">
            <label>From Date:</label>
            <input type="date" class="form-control" name="fromdate" placeholder="From Date" required>
          </div>
          <div class="form-group">
            <label>To Date:</label>
            <input type="date" class="form-control" name="todate" placeholder="To Date" required>
          </div> -->
          <div class="form-group">
            <textarea rows="4" class="form-control" name="message" placeholder="Message" required></textarea>
          </div>
        <?php if($_SESSION['login'])
            {?>
            <div class="form-group">
              <input type="submit" class="btn"  name="submit" value="Select Now">
            </div>
            <?php } else { ?>
<a href="#loginform" class="btn btn-xs uppercase" data-toggle="modal" data-dismiss="modal">Login For Book</a>

            <?php } ?>
        </form>
      </div>
    </aside>
    <!--/Side-Bar--> 

    </div>
    
    <div class="space-20"></div>
    <div class="divider"></div>
    
    <!--Similar-Cars-->
    <div class="similar_cars">
      <h3>Similar Student</h3>
      <div class="row">
<?php 
$cid=$_SESSION['brndid'];
$sql="SELECT tblstudent.StudentName,tblclass.ClassName,tblstudent.StudentID,tblstudent.Timer,tblstudent.Level,tblstudent.id,tblstudent.StudentOverview,tblstudent.Vimage1 from tblstudent join tblclass on tblclass.id=tblstudent.StudentClass where tblstudent.StudentClass=:cid";
$query = $dbh -> prepare($sql);
$query->bindParam(':cid',$cid, PDO::PARAM_STR);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $result)
{ ?>      
        <div class="col-md-3 grid_listing">
          <div class="product-listing-m gray-bg">
            <div class="product-listing-img"> <a href="student-detail.php?stid=<?php echo htmlentities($result->id);?>"><img src="admin/img/studentimages/<?php echo htmlentities($result->Vimage1);?>" class="img-responsive" alt="image" /> </a>
            </div>
            <div class="product-listing-content">
              <h5><a href="student-detail.php?stid=<?php echo htmlentities($result->id);?>"><?php echo htmlentities($result->ClassName);?> , <?php echo htmlentities($result->StudentName);?></a></h5>
              <p class="list-price">Student ID : <?php echo htmlentities($result->StudentID);?></p>
          
              <ul class="features_list">
                
                <li><i class="fa fa-calendar" aria-hidden="true"></i><?php echo htmlentities($result->Timer);?> Timer</li>
                <li><i class="fa fa-user-circle-o" aria-hidden="true"></i><?php echo htmlentities($result->Level);?></li>
              </ul>
            </div>
          </div>
        </div>
 <?php }} ?>       

      </div>
    </div>
    <!--/Similar-Cars--> 
    
  </div>
</section>
<!--/Listing-detail--> 

<!--Footer -->
<?php include('includes/footer.php');?>
<!-- /Footer--> 

<!--Back to top-->
<div id="back-top" class="back-top"> <a href="#top"><i class="fa fa-angle-up" aria-hidden="true"></i> </a> </div>
<!--/Back to top--> 

<!--Login-Form -->
<?php include('includes/login.php');?>
<!--/Login-Form --> 

<!--Register-Form -->
<?php include('includes/registration.php');?>

<!--/Register-Form --> 

<!--Forgot-password-Form -->
<?php include('includes/forgotpassword.php');?>

<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script> 
<script src="assets/js/interface.js"></script> 
<script src="assets/switcher/js/switcher.js"></script>
<script src="assets/js/bootstrap-slider.min.js"></script> 
<script src="assets/js/slick.min.js"></script> 
<script src="assets/js/owl.carousel.min.js"></script>

</body>
</html>