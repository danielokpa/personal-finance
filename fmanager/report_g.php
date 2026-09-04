<?php
session_start();
$userID = $_SESSION['uid'];
$userName = "";
include_once("dbconfig.php");
$q = "select username from users where recid = '$userID'";
$res = mysqli_query($conn, $q);
if(@mysqli_num_rows($res) != 0){
	$pdata = mysqli_fetch_assoc($res);
	$userName = $pdata['username'];
}else{
	header("location: ./");
}
$budTotal = 0;
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Report - Personal Finance Manager</title>
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
          <li class="breadcrumb-item">Report</li>
          <li class="breadcrumb-item active">Finance Goals</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section">
      <div class="row">
        <div class="col-lg-8">

          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Budget Records</h5>
					<table class="table table-striped">
						<thead>
						  <tr><th scope="col">#</th><th scope="col">Budget Amount</th>
						  <th scope="col">Month</th><th scope="col">Year</th><th scope="col">Expense</th><th scope="col">Status</th></tr>
						</thead>
			  <?php
					$q = "select * from budget where userid = '$userID'";
					$res = mysqli_query($conn, $q);
					if(@mysqli_num_rows($res) == 0){
						echo "</table><br><br>No record found";
					}else{
						echo "<tbody>";
						$rc = 0;
						while($tdata = mysqli_fetch_assoc($res)){
							$rc++;
							
							$qe = "select sum(amount) from expense where userid = '$userID' and month = '{$tdata['month']}' and year = '{$tdata['year']}'";
							$qres = mysqli_query($conn, $qe);
							$pdata = mysqli_fetch_row($qres);
							$expAmt = $pdata[0];
							if($expAmt == ""){
								$expAmt = 0;
							}
							$status = "<span style='color: #008800;'>On Track</span>";
							if($tdata['amount'] < $expAmt){
								$status = "<span style='color: #880000;'>Exceeded</span>";
							}
							?>
							<tr><th scope="row"><?php echo $rc; ?></th>
							<td><?php echo $tdata['amount']; ?></td><td><?php echo $tdata['month']; ?></td>
							<td><?php echo $tdata['year']; ?></td><td><?php echo $expAmt; ?></td>
							<td><?php echo $status; ?></td>
							</tr>
							<?php
						}
						echo "</tbody></table>";
					}
				?>
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