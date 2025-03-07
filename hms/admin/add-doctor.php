<?php
session_start();
error_reporting(0);
include('include/config.php');
if (strlen($_SESSION['id'] == 0)) {
	header('location:logout.php');
} else {
	function add_doctor($con, $specialization, $name, $address, $fees, $contact_no, $email, $password)
	{
		$hashed_password = md5($password);
		$sql = mysqli_query($con, "INSERT INTO doctors(specilization, doctorName, address, docFees, contactno, docEmail, password) VALUES('$specialization', '$name', '$address', '$fees', '$contact_no', '$email', '$hashed_password')");

		if ($sql) {
			return [
				"message" => "Doctor info added Successfully.",
				"redirect_url" => "manage-doctors.php"
			];
		} else {
			return [
				"message" => "Error in adding doctor.",
				"redirect_url" => null
			];
		}
	}
	if (isset($_POST['submit'])) {
		$response = add_doctor($con, $_POST['Doctorspecialization'], $_POST['docname'], $_POST['clinicaddress'], $_POST['docfees'], $_POST['doccontact'], $_POST['docemail'], $_POST['npass']);
		echo "<script>alert('{$response['message']}');</script>";
		if ($response['redirect_url']) {
			echo "<script>window.location.href ='{$response['redirect_url']}'</script>";
		}
	}
	?>
	<!DOCTYPE html>
	<html lang="en">

	<head>
		<title>Admin | Add Doctor</title>

		<link
			href="http://fonts.googleapis.com/css?family=Lato:300,400,400italic,600,700|Raleway:300,400,500,600,700|Crete+Round:400italic"
			rel="stylesheet" type="text/css" />
		<link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.min.css">
		<link rel="stylesheet" href="vendor/fontawesome/css/font-awesome.min.css">
		<link rel="stylesheet" href="vendor/themify-icons/themify-icons.min.css">
		<link href="vendor/animate.css/animate.min.css" rel="stylesheet" media="screen">
		<link href="vendor/perfect-scrollbar/perfect-scrollbar.min.css" rel="stylesheet" media="screen">
		<link href="vendor/switchery/switchery.min.css" rel="stylesheet" media="screen">
		<link href="vendor/bootstrap-touchspin/jquery.bootstrap-touchspin.min.css" rel="stylesheet" media="screen">
		<link href="vendor/select2/select2.min.css" rel="stylesheet" media="screen">
		<link href="vendor/bootstrap-datepicker/bootstrap-datepicker3.standalone.min.css" rel="stylesheet" media="screen">
		<link href="vendor/bootstrap-timepicker/bootstrap-timepicker.min.css" rel="stylesheet" media="screen">
		<link rel="stylesheet" href="assets/css/styles.css">
		<link rel="stylesheet" href="assets/css/plugins.css">
		<link rel="stylesheet" href="assets/css/themes/theme-1.css" id="skin_color" />
		<script type="text/javascript">
			function valid() {
				if (document.adddoc.npass.value != document.adddoc.cfpass.value) {
					alert("Password and Confirm Password Field do not match  !!");
					document.adddoc.cfpass.focus();
					return false;
				}
				return true;
			}
		</script>


		<script>
			function checkemailAvailability() {
				$("#loaderIcon").show();
				jQuery.ajax({
					url: "check_availability.php",
					data: 'emailid=' + $("#docemail").val(),
					type: "POST",
					success: function (data) {
						$("#email-availability-status").html(data);
						$("#loaderIcon").hide();
					},
					error: function () { }
				});
			}
		</script>
	</head>

	<body>
		<div id="app">
			<?php include('include/sidebar.php'); ?>
			<div class="app-content">

				<?php include('include/header.php'); ?>


				<div class="main-content">
					<div class="wrap-content container" id="container">

						<section id="page-title">
							<div class="row">
								<div class="col-sm-8">
									<h1 class="mainTitle">Admin | Add Doctor</h1>
								</div>
								<ol class="breadcrumb">
									<li>
										<span>Admin</span>
									</li>
									<li class="active">
										<span>Add Doctor</span>
									</li>
								</ol>
							</div>
						</section>


						<div class="container-fluid container-fullw bg-white">
							<div class="row">
								<div class="col-md-12">

									<div class="row margin-top-30">
										<div class="col-lg-8 col-md-12">
											<div class="panel panel-white">
												<div class="panel-heading">
													<h5 class="panel-title">Add Doctor</h5>
												</div>
												<div class="panel-body">

													<form role="form" name="adddoc" method="post"
														onSubmit="return valid();">
														<div class="form-group">
															<label for="DoctorSpecialization">
																Doctor Specialization
															</label>
															<select name="Doctorspecialization" class="form-control"
																required="true">
																<option value="">Select Specialization</option>
																<?php $ret = mysqli_query($con, "select * from doctorspecilization");
																while ($row = mysqli_fetch_array($ret)) {
																	?>
																	<option
																		value="<?php echo htmlentities($row['specilization']); ?>">
																		<?php echo htmlentities($row['specilization']); ?>
																	</option>
																<?php } ?>

															</select>
														</div>

														<div class="form-group">
															<label for="doctorname">
																Doctor Name
															</label>
															<input type="text" name="docname" class="form-control"
																placeholder="Enter Doctor Name" required="true">
														</div>


														<div class="form-group">
															<label for="address">
																Doctor Clinic Address
															</label>
															<textarea name="clinicaddress" class="form-control"
																placeholder="Enter Doctor Clinic Address"
																required="true"></textarea>
														</div>
														<div class="form-group">
															<label for="fess">
																Doctor Consultancy Fees
															</label>
															<input type="text" name="docfees" class="form-control"
																placeholder="Enter Doctor Consultancy Fees" required="true">
														</div>

														<div class="form-group">
															<label for="fess">
																Doctor Contact no
															</label>
															<input type="text" name="doccontact" class="form-control"
																placeholder="Enter Doctor Contact no" required="true">
														</div>

														<div class="form-group">
															<label for="fess">
																Doctor Email
															</label>
															<input type="email" id="docemail" name="docemail"
																class="form-control" placeholder="Enter Doctor Email id"
																required="true" onBlur="checkemailAvailability()">
															<span id="email-availability-status"></span>
														</div>




														<div class="form-group">
															<label for="exampleInputPassword1">
																Password
															</label>
															<input type="password" name="npass" class="form-control"
																placeholder="New Password" required="required">
														</div>

														<div class="form-group">
															<label for="exampleInputPassword2">
																Confirm Password
															</label>
															<input type="password" name="cfpass" class="form-control"
																placeholder="Confirm Password" required="required">
														</div>



														<button type="submit" name="submit" id="submit"
															class="btn btn-o btn-primary">
															Submit
														</button>
													</form>
												</div>
											</div>
										</div>

									</div>
								</div>
								<div class="col-lg-12 col-md-12">
									<div class="panel panel-white">


									</div>
								</div>
							</div>
						</div>
					</div>
				</div>









			</div>
		</div>
		</div>

		<?php include('include/footer.php'); ?>



		<?php include('include/setting.php'); ?>


		</div>

		<script src="vendor/jquery/jquery.min.js"></script>
		<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
		<script src="vendor/modernizr/modernizr.js"></script>
		<script src="vendor/jquery-cookie/jquery.cookie.js"></script>
		<script src="vendor/perfect-scrollbar/perfect-scrollbar.min.js"></script>
		<script src="vendor/switchery/switchery.min.js"></script>


		<script src="vendor/maskedinput/jquery.maskedinput.min.js"></script>
		<script src="vendor/bootstrap-touchspin/jquery.bootstrap-touchspin.min.js"></script>
		<script src="vendor/autosize/autosize.min.js"></script>
		<script src="vendor/selectFx/classie.js"></script>
		<script src="vendor/selectFx/selectFx.js"></script>
		<script src="vendor/select2/select2.min.js"></script>
		<script src="vendor/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
		<script src="vendor/bootstrap-timepicker/bootstrap-timepicker.min.js"></script>


		<script src="assets/js/main.js"></script>

		<script src="assets/js/form-elements.js"></script>
		<script>
			jQuery(document).ready(function () {
				Main.init();
				FormElements.init();
			});
		</script>


	</body>

	</html>
<?php } ?>