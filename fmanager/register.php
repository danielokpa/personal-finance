<?php
ob_start();
include_once("dbconfig.php");
$regErr = false;
$errormsg = "";
if(isset($_POST['regbtn'])){
	$userID = trim(mysqli_real_escape_string($conn,$_POST['userid']));
	$userPwd = trim(mysqli_real_escape_string($conn,$_POST['upwd']));
	$userFullname = trim(mysqli_real_escape_string($conn,$_POST['uname']));
	$userEmail = trim(mysqli_real_escape_string($conn,$_POST['uemail']));
	if($userID == "" || $userPwd == "" || $userFullname == "" || $userEmail == ""){
		$regErr = true;
		$errormsg = "All fields are required";
	}else{
		$q = "select recid from users where userid = '$userID'";
		$res = mysqli_query($conn, $q);
		if(@mysqli_num_rows($res) == 0){
			$q = "insert into users (userid, pwd, username, usermail) values('$userID','$userPwd','$userFullname','$userEmail')";
			mysqli_query($conn, $q);
			$q = "select recid from users where userid = '$userID' and pwd = '$userPwd'";
			$res = mysqli_query($conn, $q);
			if(@mysqli_num_rows($res) != 0){
				$pdata = mysqli_fetch_assoc($res);
				session_start();
				$_SESSION['uid'] = $pdata['recid'];
				header("location: dashboard.php");
			}else{
				header("location: ./");
			}
		}else{
			$regErr = true;
			$errormsg = "A user with the given User ID already exists";
		}
	}
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Register - Personal Finance Manager</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/css/style.css" rel="stylesheet">
</head>

<body>

  <main>
    <div class="container">

      <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

              <div class="d-flex justify-content-center py-4">
                <a href="index.html" class="logo d-flex align-items-center w-auto">
                  <img src="assets/img/logo.png" alt="">
                  <span class="d-none d-lg-block" style="text-align:center">Personal Finance Manager</span>
                </a>
              </div><!-- End Logo -->

              <div class="card mb-3">

                <div class="card-body">

                  <div class="pt-4 pb-2">
                    <h5 class="card-title text-center pb-0 fs-4">Create an Account</h5>
                    <p class="text-center small">Enter your personal details to create account</p>
                  </div>
				  <?php
					if($regErr){
						echo "<div class='pt-4 pb-2' style='color: #cc0000;text-align:center;'>$errormsg</div><hr>";
					}
					?>

                  <form class="row g-3 needs-validation" novalidate method="post" action = "register.php">
                    <div class="col-12">
                      <label for="yourName" class="form-label">Your Name</label>
                      <input type="text" name="uname" class="form-control" id="yourName" required>
                      <div class="invalid-feedback">Please, enter your name!</div>
                    </div>

                    <div class="col-12">
                      <label for="yourEmail" class="form-label">Your Email</label>
                      <input type="email" name="uemail" class="form-control" id="yourEmail" required>
                      <div class="invalid-feedback">Please enter a valid Email adddress!</div>
                    </div>

                    <div class="col-12">
                      <label for="yourUsername" class="form-label">User ID</label>
                      <div class="input-group has-validation">
                        <span class="input-group-text" id="inputGroupPrepend">@</span>
                        <input type="text" name="userid" class="form-control" id="yourUsername" required>
                        <div class="invalid-feedback">Please choose a username.</div>
                      </div>
                    </div>

                    <div class="col-12">
                      <label for="yourPassword" class="form-label">Password</label>
                      <input type="password" name="upwd" class="form-control" id="yourPassword" required>
                      <div class="invalid-feedback">Please enter your password!</div>
                    </div>

                    <div class="col-12">
                      <button class="btn btn-primary w-100" type="submit" name="regbtn">Create Account</button>
                    </div>
                    <div class="col-12">
                      <p class="small mb-0">Already have an account? <a href="index.php">Log in</a></p>
                    </div>
                  </form>

                </div>
              </div>

            </div>
          </div>
        </div>

      </section>

    </div>
  </main><!-- End #main -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  
  <script src="assets/js/main.js"></script>

</body>

</html>