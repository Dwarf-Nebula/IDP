<?php
include 'functions.php';

$ammountLocations = getAmmountOfLocations($db);
$activemembers = getActiveCustomers($db);
$devicesAmmount = getAmmountOfSportsEquipment($db);
$allMembersInLocation = getCustomersInAllLocations($db);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>AdminLTE 2 | Starter</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="bower_components/font-awesome/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="bower_components/Ionicons/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
    <!-- AdminLTE Skins. We have chosen the skin-blue for this starter
          page. However, you can choose any other skin. Make sure you
          apply the skin class to the body tag so the changes take effect. -->
    <link rel="stylesheet" href="dist/css/skins/skin-blue.min.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- Google Font -->
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>

<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

    <!-- Main Header -->
    <header class="main-header">

        <!-- Logo -->
        <a href="index.php" class="logo">
            <!-- mini logo for sidebar mini 50x50 pixels -->
            <span class="logo-mini"><b>B</b>SS</span>
            <!-- logo for regular state and mobile devices -->
            <span class="logo-lg"><b>Benno's </b>Gym</span>
        </a>

        <!-- Header Navbar -->
        <nav class="navbar navbar-static-top" role="navigation">
            <!-- Sidebar toggle button-->
            <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                <span class="sr-only">Toggle navigation</span>
            </a>
        </nav>
    </header>
    <!-- Left side column. contains the logo and sidebar -->
    <aside class="main-sidebar">

        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">

            <!-- Sidebar user panel (optional) -->
            <div class="user-panel">
                <div class="pull-left image">
                    <img src="dist/img/benno/Benno-logo-001.png" class="img-circle"/>
                </div>
                <div class="pull-left info">
                    <p><?= $currentCustomer->getFirstname(); ?> <?=$currentCustomer->getMiddlename(); ?> <?=$currentCustomer->getLastname()?></p>
                    <!-- Status -->

                </div>
            </div>

            <!-- Sidebar Menu -->
            <ul class="sidebar-menu" data-widget="tree">
                <li class="header"></li>
                <!-- Optionally, you can add icons to the links -->
                <li><a href="customerdata.php"><i class="fa fa-link"></i> <span>mijn gegevens</span></a></li>
                <li><a href="stats.php"><i class="fa fa-link"></i> <span>Bekijk uw prestaties</span></a></li>
                <?php
                if ($currentCustomer->getAccounttype() == 'medewerker'){
                    echo "<li><a href='addcustomer.php'><i class='fa fa-link'></i> <span>Voeg klant toe</span></a></li>";
                    echo "<li><a href='viewlocations.php'><i class='fa fa-link'></i> <span>bekijk filialen</span></a></li>";
                }
                ?>

            </ul>
            <!-- /.sidebar-menu -->
        </section>
        <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Locaties
                <small>Een lijst met alle locaties</small>
            </h1>
        </section>

        <!-- Main content -->
        <section class="content container-fluid">
            <div class="row">
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-red"><i class="fa fa-home"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Locaties</span>
                            <span class="info-box-number"><?= $ammountLocations ?></span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-red"><i class="fa fa-users"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Actieve leden</span>
                            <span class="info-box-number"><?= $activemembers ?> </span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-red"><i class="fa fa-bicycle"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Aantal sport apparaten</span>
                            <span class="info-box-number"><?= $devicesAmmount ?></span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-red"><i class="fa fa-users"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Leden in alle sportscholen</span>
                            <span class="info-box-number"><?= $allMembersInLocation?> </span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
            </div>
            <?php
            $locations = getAllLocations($db);
            foreach ($locations as $location){
                $membersInLocation = getCustomersInLocation($db,$location['filiaalnummer']);
                $ammountOfSportEquipment = getAmmountOfSportsEquipmentPerLocation($db,$location['filiaalnummer']);
                echo '
                        <div class="row">
                        	<div class="col-lg-6 col-md-12 col-sm-12">
                        	    <h1>filiaal '.$location['filiaalnummer'].'</h1>
                        		<table class="table table-bordered">
                        			<tbody>
                        				<tr>
                        					<td>filiaal nummer</td>
                        					<td>'.$location['filiaalnummer'].'</td>
                        				</tr>
                        				<tr>
                        					<td>straat</td>
                        					<td>'.$location['straat'].'</td>
                        				</tr>
                        				<tr>
                        					<td>huisnummer</td>
                        					<td>'.$location['huisnummer'].'</td>
                        				</tr>
                        				<tr>
                        					<td>huisnummer toevoeging</td>
                        					<td>'.$location['huisnummertoevoeging'].'</td>
                        				</tr>
                        				<tr>
                        					<td>postcode</td>
                        					<td>'.$location['postcode'].'</td>
                        				</tr>
                        				<tr>
                        					<td>stad</td>
                        					<td>'.$location['stad'].'</td>
                        				</tr>
                        				<tr>
                        					<td>telefoonnummer</td>
                        					<td>'.$location['telefoonnummer'].'</td>
                        				</tr>
                        				<tr>
                        				<td>Aantal sportapparaten</td>
                        				<td>'.$ammountOfSportEquipment.'</td>
                                        </tr>
                        				<tr>
                        					<td>leden binnen</td>
                        					<td>'.$membersInLocation.'</td>
                        				</tr>
                        			</tbody>
                        		</table>
                        	</div>
                        </div>
                ';
            }
            ?>

        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <!-- Main Footer -->
    <footer class="main-footer">
        <!-- To the right -->
        <div class="pull-right hidden-xs">
            Benno will get you fit
        </div>
        <!-- Default to the left -->
        <strong>Copyright &copy; 2017 <a href="index.php">Benno's Gym</a>.</strong> All rights reserved.
    </footer>


</div>
<!-- ./wrapper -->

<!-- REQUIRED JS SCRIPTS -->

<!-- jQuery 3 -->
<script src="bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- chars -->
<script src="bower_components/chart.js/Chart.bundle.min.js"></script>

</body>
</html>