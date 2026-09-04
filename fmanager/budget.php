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
$errMsg = "";
if(isset($_POST['budbtn'])){
	$budAmount = trim(mysqli_real_escape_string($conn,$_POST['amt']));
	$bMonth = trim(mysqli_real_escape_string($conn,$_POST['bmonth']));
	$bYear = trim(mysqli_real_escape_string($conn,$_POST['byear']));
	if($budAmount == ""){
		$errMsg = "All fields are required";
	}else{
		if(is_numeric($budAmount)){
			//Update database
			$q = "insert into budget (amount, userid,month, year) values('$budAmount', '$userID', '$bMonth', '$bYear')";
			mysqli_query($conn, $q);
			$errMsg = "Database has been updated";
		}else{
			$errMsg = "Amount field must be a number";
		}
	}
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Budget - Personal Finance Manager</title>
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
          <li class="breadcrumb-item active">Budget</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section">
      <div class="row">
        <div class="col-lg-8">

          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Budget Form</h5>
			  <?php
				echo "<div class='pt-4 pb-2' style='color: #008800;text-align:center;'>$errMsg</div><hr>";
			  ?>
			  
              <form class="row g-3" method="post" action="budget.php">
                <div class="col-12">
                  <label for="inputNanme4" class="form-label">Amount</label>
                  <input type="text" class="form-control" id="inputNanme4" name="amt">
                </div>
                <div class="col-12">
				<table width="50%">
				<tr><td>
					<div>
					  <label class="form-label">Date</label>
					</div>
					</td><td>
					<div>
					  <label for="d2" class="form-label">Month</label>
					  <select name="bmonth" class="form-control" id="d2">
					  <option>1</option><option>2</option><option>3</option><option>4</option>
					  <option>5</option><option>6</option><option>7</option><option>8</option>
					  <option>9</option><option>10</option><option>11</option><option>12</option>
					  </select>
					</div>
					</td><td>
					<div>
					  <label for="d3" class="form-label">Year</label>
					  <select name="byear" class="form-control" id="d3">
					  <option>2026</option><option>2027</option><option>2028</option><option>2029</option>
					  </select>
					</div>
					</td></tr>
					</table>
                </div>
                <div class="text-center">
                  <button type="submit" class="btn btn-primary" name="budbtn">Submit</button>
                </div>
              </form>

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