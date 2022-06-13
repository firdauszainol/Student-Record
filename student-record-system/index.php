<?php 
session_start();
include('includes/config.php');
error_reporting(0);

if(isset($_REQUEST['del']))
	{
$delid=intval($_GET['del']);
$sql = "delete from tblstudent  WHERE  id=:delid";
$query = $dbh->prepare($sql);
$query -> bindParam(':delid',$delid, PDO::PARAM_STR);
$query -> execute();
// $msg="Student record deleted successfully";
}

?>

<!DOCTYPE HTML>
<html lang="en" >
<head>

<title>C-Hunter Portal</title>
<!--Bootstrap -->
<link rel="stylesheet" href="assets/css/bootstrap.min.css" type="text/css">
<link rel="stylesheet" href="assets/css/style.css" type="text/css">
<link rel="stylesheet" href="assets/css/owl.carousel.css" type="text/css">
<link rel="stylesheet" href="assets/css/owl.transitions.css" type="text/css">
<link href="assets/css/slick.css" rel="stylesheet">
<link href="assets/css/bootstrap-slider.min.css" rel="stylesheet">
<link href="assets/css/font-awesome.min.css" rel="stylesheet">
<link rel="stylesheet" id="switcher-css" type="text/css" href="assets/switcher/css/switcher.css" media="all" />
	<link rel="alternate stylesheet" type="text/css" href="assets/switcher/css/red.css" title="red" media="all" data-default-color="true" />
	<link rel="alternate stylesheet" type="text/css" href="assets/switcher/css/orange.css" title="orange" media="all" />
	<link rel="alternate stylesheet" type="text/css" href="assets/switcher/css/blue.css" title="blue" media="all" />
	<link rel="alternate stylesheet" type="text/css" href="assets/switcher/css/pink.css" title="pink" media="all" />
	<link rel="alternate stylesheet" type="text/css" href="assets/switcher/css/green.css" title="green" media="all" />
	<link rel="alternate stylesheet" type="text/css" href="assets/switcher/css/purple.css" title="purple" media="all" />
<link rel="apple-touch-icon-precomposed" sizes="144x144" href="assets/images/CHunterlogo.png">
<link rel="apple-touch-icon-precomposed" sizes="114x114" href="assets/images/CHunterlogo.png">
<link rel="apple-touch-icon-precomposed" sizes="72x72" href="assets/images/CHunterlogo.png">
<link rel="apple-touch-icon-precomposed" href="assets/images/CHunterlogo.png">
<link rel="shortcut icon" href="assets/images/CHunterlogo.png">
<link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,900" rel="stylesheet"> 


<!-- Font awesome -->
  <!-- <link rel="stylesheet" href="admin/css/font-awesome.min.css"> -->
	<!-- Sandstone Bootstrap CSS -->
	<!-- <link rel="stylesheet" href="admin/css/bootstrap.min.css"> -->
	<!-- Bootstrap Datatables -->
	<link rel="stylesheet" href="admin/css/dataTables.bootstrap.min.css">
	<!-- Bootstrap social button library -->
	<link rel="stylesheet" href="admin/css/bootstrap-social.css">
	<!-- Bootstrap select -->
	<link rel="stylesheet" href="admin/css/bootstrap-select.css">
	<!-- Bootstrap file input -->
	<link rel="stylesheet" href="admin/css/fileinput.min.css">
	<!-- Awesome Bootstrap checkbox -->
	<link rel="stylesheet" href="admin/css/awesome-bootstrap-checkbox.css">
	<!-- Admin Stye -->
	<link rel="stylesheet" href="admin/css/style.css">
  <style>
		.errorWrap {
    padding: 10px;
    margin: 0 0 20px 0;
    background: #fff;
    border-left: 4px solid #dd3d36;
    -webkit-box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
    box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
}
.succWrap{
    padding: 10px;
    margin: 0 0 20px 0;
    background: #fff;
    border-left: 4px solid #5cb85c;
    -webkit-box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
    box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
}
		</style>

</head>
<body>

<!-- Start Switcher -->
<?php include('includes/colorswitcher.php');?>
<!-- /Switcher -->  
        
<!--Header-->
<?php include('includes/header.php');?>
<!-- /Header --> 

<!-- Banners -->
<section id="banner" class="banner-section">

  <div class="container">
    <div class="div_zindex">
      <div class="row">
        
          <div class="banner_content">
            <h1><center>C-Hunter Dashboard</center></h1>
            <h2><center>to view Student Record</center></h2>
            </div>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- /Banners --> 


<!-- Resent Cat-->
<section class="section-padding gray-bg">
<div class="container-fluid">
    <div class="section-header text-center">
      <h2>STUDENT <span>DATA</span></h2>
     
    </div>

	
<!-- Zero Configuration Table -->
<div class="panel panel-default">
	<div class="panel-heading">Student Details</div>
	<div class="panel-body">
	<?php if($error){?><div class="errorWrap"><strong>ERROR</strong>:<?php echo htmlentities($error); ?> </div><?php } 
else if($msg){?><div class="succWrap"><strong>SUCCESS</strong>:<?php echo htmlentities($msg); ?> </div><?php }?>
<table id="zctb" class="display table table-striped table-bordered table-hover" cellspacing="0" width="100%">
									<thead>
										<tr>
										<th>#</th>
										<th>Student Name</th>
										<th>Student ID</th>
											<th>Class Section</th>
											<th>Password</th>
											<th>Level</th>
											<th>Timer</th>
											<th>Student Overview</th>
											<th>Action</th>
										</tr>
									</thead>
									<tfoot>
										<tr>
										<th>#</th>
										<th>Student Name</th>
										<th>Student ID</th>
											<th>Class Section</th>
											<th>Password</th>
											<th>Level</th>
											<th>Timer</th>
											<th>Student Overview</th>
											<th>Action</th>
										</tr>
										</tr>
									</tfoot>
									<tbody>

<?php $sql = "SELECT tblstudent.StudentName,tblclass.ClassName,tblstudent.Password,tblstudent.Level,tblstudent.Timer,tblstudent.StudentID,tblstudent.StudentOverview,tblstudent.id from tblstudent join tblclass on tblclass.id=tblstudent.StudentClass";
$query = $dbh -> prepare($sql);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $result)
{				?>	
										<tr>
											<td><?php echo htmlentities($cnt);?></td>
											<td><?php echo htmlentities($result->StudentName);?></td>
											<td><?php echo htmlentities($result->StudentID);?></td>
											<td><?php echo htmlentities($result->ClassName);?></td>
                      						<td><?php echo htmlentities($result->Password);?></td>
											<td><?php echo htmlentities($result->Level);?></td>
											<td><?php echo htmlentities($result->Timer);?></td>
												<td><?php echo htmlentities($result->StudentOverview);?></td>
		<td><center><a href="edit-student-detail.php?id=<?php echo $result->id;?>"><i class="fa fa-edit"></i></a></center>
<!-- <a href="index.php?del=<?php echo $result->id;?>" onclick="return confirm('Do you want to delete');"><i class="fa fa-close"></i></a></td> -->
										</tr>
										<?php $cnt=$cnt+1; }} ?>
										
									</tbody>
								</table>


	</div>
</div>



</div>
</div>

</div>
</div>
</div>
</section>


      

     

<!-- Fun Facts-->
<section class="fun-facts-section">
  <div class="container div_zindex">
    <div class="row">
      <div class="col-lg-3 col-xs-6 col-sm-3">
        <div class="fun-facts-m">
          <div class="cell">
            <h2><i class="fa fa-calendar" aria-hidden="true"></i>1+</h2>
            <p>Years In Business</p>
          </div>
        </div>
      </div>
      <div class="col-lg-3 col-xs-6 col-sm-3">
        <div class="fun-facts-m">
          <div class="cell">
            <h2><i class="fa fa-user-circle-o" aria-hidden="true"></i>12+</h2>
            <p>New User Register</p>
          </div>
        </div>
      </div>
      <div class="col-lg-3 col-xs-6 col-sm-3">
        <div class="fun-facts-m">
          <div class="cell">
            <h2><i class="fa fa-user-circle-o" aria-hidden="true"></i>10+</h2>
            <p>User Review</p>
          </div>
        </div>
      </div>
      <div class="col-lg-3 col-xs-6 col-sm-3">
        <div class="fun-facts-m">
          <div class="cell">
            <h2><i class="fa fa-user-circle-o" aria-hidden="true"></i>600+</h2>
            <p>Satisfied User</p>
          </div>
        </div>
      </div>
    </div>
  </div>

<!-- Dark Overlay-->
<div class="dark-overlay"></div>
</section>
<!-- /Fun Facts--> 


<!--Testimonial -->
<section class="section-padding testimonial-section parallex-bg">
  <div class="container div_zindex">
    <div class="section-header white-text text-center">
      <h2>Our Satisfied <span>User</span></h2>
    </div>
    <div class="row">
      <div id="testimonial-slider">
<?php 
$tid=1;
$sql = "SELECT tbltestimonial.Testimonial,tblusers.FullName from tbltestimonial join tblusers on tbltestimonial.UserEmail=tblusers.EmailId where tbltestimonial.status=:tid limit 4";
$query = $dbh -> prepare($sql);
$query->bindParam(':tid',$tid, PDO::PARAM_STR);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $result)
{  ?>


        <div class="testimonial-m">
 
          <div class="testimonial-content">
            <div class="testimonial-heading">
              <h5><?php echo htmlentities($result->FullName);?></h5>
            <p><?php echo htmlentities($result->Testimonial);?></p>
          </div>
        </div>
        </div>
        <?php }} ?>
        
       
  </div>
      </div>
    </div>
  </div>
  <!-- Dark Overlay-->
  <div class="dark-overlay"></div>
</section>
<!-- /Testimonial--> 


		<!--Footer -->
		<?php include('includes/footer.php'); ?>
		<!-- /Footer-->

		<!--Back to top-->
		<div id="back-top" class="back-top"> <a href="#top"><i class="fa fa-angle-up" aria-hidden="true"></i> </a> </div>
		<!--/Back to top-->

		<!--Login-Form -->
		<?php include('includes/login.php'); ?>
		<!--/Login-Form -->

		<!--Register-Form -->
		<?php include('includes/registration.php'); ?>

		<!--/Register-Form -->

		<!--Forgot-password-Form -->
		<?php include('includes/forgotpassword.php'); ?>
		<!--/Forgot-password-Form -->



		<!-- Loading Scripts -->
		<script src="admin/js/jquery.min.js"></script>
		<script src="admin/js/bootstrap-select.min.js"></script>
		<script src="admin/js/bootstrap.min.js"></script>
		<script src="admin/js/jquery.dataTables.min.js"></script>
		<script src="admin/js/dataTables.bootstrap.min.js"></script>
		<script src="admin/js/Chart.min.js"></script>
		<script src="admin/js/fileinput.js"></script>
		<script src="admin/js/chartData.js"></script>
		<script src="admin/js/main.js"></script>

</body>

<!-- Mirrored from themes.webmasterdriver.net/carforyou/demo/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 16 Jun 2017 07:22:11 GMT -->
</html>