<?php
session_start();
$userID = $_SESSION['uid'];
$userName = "";
include_once("dbconfig.php");
$q = "select username, usermail from users where recid = '$userID'";
$res = mysqli_query($conn, $q);
if(@mysqli_num_rows($res) != 0){
	$pdata = mysqli_fetch_assoc($res);
	$userName = $pdata['username'];
	$userEmail = $pdata['usermail'];
}else{
	header("location: ./");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>User Dashboard - Personal Finance Manager</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/css/style.css" rel="stylesheet">
</head>

<body>

  <!-- ======= Header ======= -->
  <header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
      <a href="dashboard.php" class="logo d-flex align-items-center">
        <img src="assets/img/logo.png" alt="">
        <span class="d-none d-lg-block">Finance</span>
      </a>
      <i class="bi bi-list toggle-sidebar-btn"></i>
    </div><!-- End Logo -->

    <nav class="header-nav ms-auto">
      <ul class="d-flex align-items-center">

        <li class="nav-item d-block d-lg-none">
          &nbsp;
        </li><!-- End Search Icon-->

        <li class="nav-item dropdown pe-3">

          <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
            <img src="assets/img/profile.jpg" alt="Profile" class="rounded-circle">
            <span class="d-none d-md-block dropdown-toggle ps-2"><?php echo $userName; ?></span>
          </a>

          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
            <li class="dropdown-header">
              <h6><?php echo $userName; ?></h6>
              <span>&nbsp;</span>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>
            <li>
              <a class="dropdown-item d-flex align-items-center" href="logout.php">
                <i class="bi bi-box-arrow-right"></i>
                <span>Log Out</span>
              </a>
            </li>

          </ul><!-- End Profile Dropdown Items -->
        </li><!-- End Profile Nav -->

      </ul>
    </nav><!-- End Icons Navigation -->

  </header><!-- End Header -->

  <!-- ======= Sidebar ======= -->
  <aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

      <li class="nav-item">
        <a class="nav-link collapsed" href="dashboard.php">
          <i class="bi bi-grid"></i>
          <span>Dashboard</span>
        </a>
      </li><!-- End Dashboard Nav -->
	  
	  <li class="nav-item">
        <a class="nav-link collapsed" href="income.php">
          <i class="bi bi-journal-text"></i>
          <span>Income</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link collapsed" href="expense.php">
          <i class="bi bi-card-list"></i>
          <span>Expense</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link collapsed" href="budget.php">
          <i class="bi bi-bar-chart"></i>
          <span>Budget</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link collapsed" href="asset.php">
          <i class="bi bi-gem"></i>
          <span>Assets</span>
        </a>
      </li>
	  <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#components-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-layout-text-window-reverse"></i><span>Reports</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="components-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="report_p.php">
              <i class="bi bi-circle"></i><span>Ledger</span>
            </a>
          </li>
          <li>
            <a href="report_g.php">
              <i class="bi bi-circle"></i><span>Goals</span>
            </a>
          </li>
		</ul>
	  </li>
	  
      <li class="nav-item">
        <a class="nav-link collapsed" href="logout.php">
          <i class="bi bi-box-arrow-in-right"></i>
          <span>Log Out</span>
        </a>
      </li>

    </ul>

  </aside><!-- End Sidebar-->

  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Dashboard</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
          <li class="breadcrumb-item active">Dashboard</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section">
		<div class="row">
			<!-- Revenue Card -->
            <div class="col-md-5">
              <div class="card info-card revenue-card" style="background: #f0f4a8;">

                <div class="card-body">
                  <h5 class="card-title">Balance <span>| Current</span></h5>
				  <?php
					$qr = "select sum(amount) from income where userid = '$userID'";
					$res = mysqli_query($conn, $qr);
					$pdata = mysqli_fetch_row($res);
					$inBal = $pdata[0];
					
					$qr = "select sum(amount) from expense where userid = '$userID'";
					$res = mysqli_query($conn, $qr);
					$pdata = mysqli_fetch_row($res);
					$expBal = $pdata[0];
					$balance = $inBal - $expBal;
				  ?>
                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-cash-coin"></i>
                    </div>
                    <div class="ps-3">
                      <h6><?php echo $balance; ?> <strong>NGN</strong></h6>
                      <span class="text-success small pt-1 fw-bold">&nbsp;</span>
                    </div>
                  </div>
                </div>

              </div>
            </div><!-- End Revenue Card -->
			
			<div class="col-md-7">
              <div class="card">
				<div class="card-body">
					<h5 class="card-title">Transactions <span>| Count</span></h5>
					<?php
					$qr = "select count(*) from expense where userid = '$userID'";
					$res = mysqli_query($conn, $qr);
					$pdata = mysqli_fetch_row($res);
					$expCount = $pdata[0];
					
					$qr = "select count(*) from income where userid = '$userID'";
					$res = mysqli_query($conn, $qr);
					$pdata = mysqli_fetch_row($res);
					$inCount = $pdata[0];
					
					$qr = "select count(*) from asset where userid = '$userID'";
					$res = mysqli_query($conn, $qr);
					$pdata = mysqli_fetch_row($res);
					$atCount = $pdata[0];
					
					$qr = "select count(*) from budget where userid = '$userID'";
					$res = mysqli_query($conn, $qr);
					$pdata = mysqli_fetch_row($res);
					$budCount = $pdata[0];
					?>
					<table class="table table-striped">
					<tbody>
				  <tr><th scope="row">Income</th>
						<td><?php echo $inCount; ?></td></tr>
					<tr><th scope="row">Expense</th>
						<td><?php echo $expCount; ?></td></tr>
					<tr><th scope="row">Assets</th>
						<td><?php echo $atCount; ?></td></tr>
					<tr><th scope="row">Budget</th>
						<td><?php echo $budCount; ?></td></tr>
				  </tbody>
				  </table>
				</div>
			  </div>
            </div>
		</div>
    </section>

  </main><!-- End #main -->

  <footer id="footer" class="footer">
    <div class="copyright">
      &copy; Copyright <strong><span>Personal Finance Manager</span></strong>.
    </div>
  </footer>

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/chart.js/chart.umd.js"></script>
  <script src="assets/js/main.js"></script>

</body>

</html>