<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['alogin'])==0)
	{	
header('location:index.php');
}
else{ 

if(isset($_POST['submit']))
  {
$studentname=$_POST['studentname'];
$class=$_POST['classname'];
$studentoverview=$_POST['studentorcview'];
$password=$_POST['password'];
$studentid=$_POST['studentid'];
$level=$_POST['level'];
$timer=$_POST['timer'];
$airconditioner=$_POST['airconditioner'];
$powerdoorlocks=$_POST['powerdoorlocks'];
$antilockbrakingsys=$_POST['antilockbrakingsys'];
$brakeassist=$_POST['brakeassist'];
$powersteering=$_POST['powersteering'];
$driverairbag=$_POST['driverairbag'];
$passengerairbag=$_POST['passengerairbag'];
$powerwindow=$_POST['powerwindow'];
$cdplayer=$_POST['cdplayer'];
$centrallocking=$_POST['centrallocking'];
$crashcensor=$_POST['crashcensor'];
$leatherseats=$_POST['leatherseats'];
$id=intval($_GET['id']);

$sql="update tblstudent set StudentName=:studentname,StudentCLass=:class,StudentOverview=:studentoverview,Password=:password,Level=:level,StudentID=:studentid,Timer=:timer where id=:id ";
$query = $dbh->prepare($sql);
$query->bindParam(':studentname',$studentname,PDO::PARAM_STR);
$query->bindParam(':class',$class,PDO::PARAM_STR);
$query->bindParam(':studentoverview',$studentoverview,PDO::PARAM_STR);
$query->bindParam(':password',$password,PDO::PARAM_STR);
$query->bindParam(':studentid',$studentid,PDO::PARAM_STR);
$query->bindParam(':level',$level,PDO::PARAM_STR);
$query->bindParam(':timer',$timer,PDO::PARAM_STR);

$query->bindParam(':id',$id,PDO::PARAM_STR);
$query->execute();

$msg="Data updated successfully";


}


	?>
<!doctype html>
<html lang="en" class="no-js">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
	<meta name="description" content="">
	<meta name="author" content="">
	<meta name="theme-color" content="#3e454c">
	
	<title>C-Hunter Portal | Admin Edit Student Info</title>

	<!-- Font awesome -->
	<link rel="stylesheet" href="css/font-awesome.min.css">
	<!-- Sandstone Bootstrap CSS -->
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<!-- Bootstrap Datatables -->
	<link rel="stylesheet" href="css/dataTables.bootstrap.min.css">
	<!-- Bootstrap social button library -->
	<link rel="stylesheet" href="css/bootstrap-social.css">
	<!-- Bootstrap select -->
	<link rel="stylesheet" href="css/bootstrap-select.css">
	<!-- Bootstrap file input -->
	<link rel="stylesheet" href="css/fileinput.min.css">
	<!-- Awesome Bootstrap checkbox -->
	<link rel="stylesheet" href="css/awesome-bootstrap-checkbox.css">
	<!-- Admin Stye -->
	<link rel="stylesheet" href="css/style.css">
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
	<?php include('includes/header.php');?>
	<div class="ts-main-content">
	<?php include('includes/leftbar.php');?>
		<div class="content-wrapper">
			<div class="container-fluid">

				<div class="row">
					<div class="col-md-12">
					
						<h2 class="page-title">Edit Vehicle</h2>

						<div class="row">
							<div class="col-md-12">
								<div class="panel panel-default">
									<div class="panel-heading">Basic Info</div>
									<div class="panel-body">
<?php if($msg){?><div class="succWrap"><strong>SUCCESS</strong>:<?php echo htmlentities($msg); ?> </div><?php } ?>
<?php 
$id=intval($_GET['id']);
$sql ="SELECT tblstudent.*,tblclass.ClassName,tblclass.id as cid from tblstudent join tblclass on tblclass.id=tblstudent.StudentClass where tblstudent.id=:id";
$query = $dbh -> prepare($sql);
$query-> bindParam(':id', $id, PDO::PARAM_STR);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $result)
{	?>





<form method="post" class="form-horizontal" enctype="multipart/form-data">

<div class="form-group">
<label class="col-sm-2 control-label">Student Name<span style="color:red">*</span></label>
<div class="col-sm-4">
<input type="text" name="studentname" class="form-control" value="<?php echo htmlentities($result->StudentName);?>" required>
</div>
<label class="col-sm-2 control-label">Password<span style="color:red">*</span></label>
<div class="col-sm-4">
<input type="text" name="password" class="form-control" value="<?php echo htmlentities($result->Password);?>" required>
</div>
</div>

<div class="form-group">
<label class="col-sm-2 control-label">Student ID <span style="color:red">*</span></label>
<div class="col-sm-4">
<input type="text" name="studentid" class="form-control" value="<?php echo htmlentities($result->StudentID)?>" required>
</div>
<label class="col-sm-2 control-label">Select Class<span style="color:red">*</span></label>
<div class="col-sm-4">
<select class="selectpicker" name="classname" required>
<option value="<?php echo htmlentities($result->cid);?>"><?php echo htmlentities($cname=$result->ClassName); ?> </option>
<?php $ret="select id,ClassName from tblclass";
$query= $dbh -> prepare($ret);
//$query->bindParam(':id',$id, PDO::PARAM_STR);
$query-> execute();
$resultss = $query -> fetchAll(PDO::FETCH_OBJ);
if($query -> rowCount() > 0)
{
foreach($resultss as $results)
{
if($results->ClassName==$cname)
{
continue;
} else{
?>
<option value="<?php echo htmlentities($results->id);?>"><?php echo htmlentities($results->ClassName);?></option>
<?php }}} ?>

</select>
</div>
</div>
			
<div class="form-group">
<label class="col-sm-2 control-label">Timer Record<span style="color:red">*</span></label>
<div class="col-sm-4">
<input type="text" name="timer" class="form-control" value="<?php echo htmlentities($result->Timer);?>" required>
</div>

<label class="col-sm-2 control-label">Select Level<span style="color:red">*</span></label>
<div class="col-sm-4">
<select class="selectpicker" name="level" required>
<option value="<?php echo htmlentities($result->Level);?>"> <?php echo htmlentities($result->Level);?> </option>

<option value="1">1</option>
<option value="2">2</option>
<option value="3">3</option>
</select>
</div>
</div>




<div class="hr-dashed"></div>
<div class="form-group">
<label class="col-sm-2 control-label">Student Overview<span style="color:red">*</span></label>
<div class="col-sm-10">
<textarea class="form-control" name="studentorcview" rows="3" required><?php echo htmlentities($result->StudentOverview);?></textarea>
</div>
</div>






<div class="hr-dashed"></div>								
<div class="form-group">
<div class="col-sm-12">
<h4><b>Student Images</b></h4>
</div>
</div>


<div class="form-group">
<div class="col-sm-4">
Image 1 <img src="img/vehicleimages/<?php echo htmlentities($result->Vimage1);?>" width="300" height="200" style="border:solid 1px #000">
<a href="changeimage1.php?imgid=<?php echo htmlentities($result->id)?>">Change Image 1</a>
</div>
<div class="col-sm-4">
Image 2<img src="img/vehicleimages/<?php echo htmlentities($result->Vimage2);?>" width="300" height="200" style="border:solid 1px #000">
<a href="changeimage2.php?imgid=<?php echo htmlentities($result->id)?>">Change Image 2</a>
</div>
<div class="col-sm-4">
Image 3<img src="img/vehicleimages/<?php echo htmlentities($result->Vimage3);?>" width="300" height="200" style="border:solid 1px #000">
<a href="changeimage3.php?imgid=<?php echo htmlentities($result->id)?>">Change Image 3</a>
</div>
</div>


<div class="form-group">
<div class="col-sm-4">
Image 4<img src="img/vehicleimages/<?php echo htmlentities($result->Vimage4);?>" width="300" height="200" style="border:solid 1px #000">
<a href="changeimage4.php?imgid=<?php echo htmlentities($result->id)?>">Change Image 4</a>
</div>
<div class="col-sm-4">
Image 5
<?php if($result->Vimage5=="")
{
echo htmlentities("File not available");
} else {?>
<img src="img/vehicleimages/<?php echo htmlentities($result->Vimage5);?>" width="300" height="200" style="border:solid 1px #000">
<a href="changeimage5.php?imgid=<?php echo htmlentities($result->id)?>">Change Image 5</a>
<?php } ?>
</div>

</div>
<div class="hr-dashed"></div>									
</div>
</div>
</div>
</div>
	
							



<?php }} ?>


										<center>	<div class="form-group">
												<div class="col-sm-8 col-sm-offset-2" >
													
<button class="btn btn-primary" name="submit" type="submit" style="margin-top:4%">Save changes</button>
												</div>
											</div> </center>

										</form>
									</div>
								</div>
							</div>
						</div>
						
					

					</div>
				</div>
				
			

			</div>
		</div>
	</div>

	<!-- Loading Scripts -->
	<script src="js/jquery.min.js"></script>
	<script src="js/bootstrap-select.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/jquery.dataTables.min.js"></script>
	<script src="js/dataTables.bootstrap.min.js"></script>
	<script src="js/Chart.min.js"></script>
	<script src="js/fileinput.js"></script>
	<script src="js/chartData.js"></script>
	<script src="js/main.js"></script>
</body>
</html>
<?php } ?>