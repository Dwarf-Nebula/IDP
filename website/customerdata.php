<?php
include 'functions.php';
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
                <li class="header">HEADER</li>
                <!-- Optionally, you can add icons to the links -->
                <li class="active"><a href="customerdata.php"><i class="fa fa-link"></i> <span>mijn gegevens</span></a></li>
                <li><a href="#"><i class="fa fa-link"></i> <span>Another Link</span></a></li>
                <li class="treeview">
                    <a href="#"><i class="fa fa-link"></i> <span>Multilevel</span>
                        <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="#">Link in level 2</a></li>
                        <li><a href="#">Link in level 2</a></li>
                    </ul>
                </li>
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
                Mijn gegevens
                <small>Bekijk en verander hier uw gegevens</small>
            </h1>
        </section>

        <!-- Main content -->
        <section class="content container-fluid">

        <?php
        if (!empty($_POST)){
            $currentCustomer = new Customer();
            $currentCustomer->setFirstname($_POST['firstname']);
            $currentCustomer->setMiddlename($_POST['middlename']);
            $currentCustomer->setLastname($_POST['lastname']);
            $currentCustomer->setBirthday($_POST['birthday']);
            $currentCustomer->setPhonenumber($_POST['phonenumber']);
            $currentCustomer->setEmail($_POST['email']);
            $currentCustomer->setStreet($_POST['street']);
            $currentCustomer->setHousenumber($_POST['housenumber']);
            $currentCustomer->setHouseaffix($_POST['houseaffix']);
            $currentCustomer->setZipcode($_POST['zipcode']);
            $currentCustomer->setCity($_POST['city']);
            if ($_POST['password'] != ''){
                $currentCustomer->setPassword(generatehash($_POST['password']));
            }
            $currentCustomer->updateCustomer($db);
            session_unset();
            $_SESSION['customer'] = serialize($currentCustomer);
        }
        if (isset($_GET['edit'])){
            ?>
            <table class="table table-bordered">
                <tbody><tr><td>Voornaam</td><td><input title="firstname" form="customerform" id="firstname" name="firstname" type="text" maxlength="255" value="<?= $currentCustomer->getFirstname()?>"></td></tr>
                <tr><td>Tussenvoegsel</td><td><input title="middlename" form="customerform" id="middlename" name="middlename" type="text" maxlength="255" value="<?= $currentCustomer->getMiddlename() ?>"></td></tr>
                <tr><td>Achternaam</td><td><input title="lastname" form="customerform" id="lastname" name="lastname" type="text" maxlength="255" value="<?= $currentCustomer->getLastname() ?>"></td></tr>
                <tr><td>Geboorte datum</td><td><input title="birthday" form="customerform" id="birthday" name="birthday" type="text" maxlength="255" value="<?= $currentCustomer->getBirthday() ?>"></td></tr>
                <tr><td>Telefoon nummer</td><td><input title="phonenumber" form="customerform" id="phonenumber" name="phonenumber" type="number" maxlength="10" value="<?= $currentCustomer->getPhonenumber() ?>"></td></tr>
                <tr><td>Email adres</td><td><input title="email" form="customerform" id="email" name="email" type="text" maxlength="255" value="<?= $currentCustomer->getEmail() ?>"></td></tr>
                <tr><td>password</td><td><input title="password" form="customerform" id="password" name="password" type="text" maxlength="255" value=""></td></tr>
                <tr><td>Straatnaam</td><td><input title="street" form="customerform" id="street" name="street" type="text" maxlength="255" value="<?= $currentCustomer->getStreet() ?>"></td></tr>
                <tr><td>huisnummer</td><td><input title="housenumber" form="customerform" id="housenumber" name="housenumber" type="text" maxlength="255" value="<?= $currentCustomer->getHousenumber() ?>"></td></tr>
                <tr><td>toevoeging</td><td><input title="houseaffix" form="customerform" id="houseaffix" name="houseaffix" type="text" maxlength="255" value="<?= $currentCustomer->getHouseaffix() ?>"></td></tr>
                <tr><td>postcode</td><td><input title="zipcode" form="customerform" id="zipcode" name="zipcode" type="text" maxlength="255" value="<?= $currentCustomer->getZipcode() ?>"></td></tr>
                <tr><td>stad</td><td><input title="city" form="customerform" id="city" name="city" type="text" maxlength="255" value="<?= $currentCustomer->getCity() ?>"></td></tr></tbody>
                <tbody><tr><td>
                        <form id="customerform" method="post" action="customerdata.php">
                            <input type="submit" value="update" />
                        </form>
                    </td><td></td></tr></tbody>
            </table>

            <?php
        }else{
            ?>
            <table class="table table-bordered">
                <tbody><tr><td>Voornaam</td><td><?= $currentCustomer->getFirstname()?></td></tr>
                <tr><td>Tussenvoegsel</td><td><?= $currentCustomer->getMiddlename() ?></td></tr>
                <tr><td>Achternaam</td><td><?= $currentCustomer->getLastname() ?></td></tr>
                <tr><td>Geboorte datum</td><td><?= $currentCustomer->getBirthday() ?></td></tr>
                <tr><td>Telefoon nummer</td><td><?= $currentCustomer->getPhonenumber() ?></td></tr>
                <tr><td>Email adres</td><td><?= $currentCustomer->getEmail() ?></td></tr>
                <tr><td>password</td><td>**********</td></tr>
                <tr><td>Straatnaam</td><td><?= $currentCustomer->getStreet() ?></td></tr>
                <tr><td>huisnummer</td><td><?= $currentCustomer->getHousenumber() ?></td></tr>
                <tr><td>toevoeging</td><td><?= $currentCustomer->getHouseaffix() ?></td></tr>
                <tr><td>postcode</td><td><?= $currentCustomer->getZipcode() ?></td></tr>
                <tr><td>stad</td><td><?= $currentCustomer->getCity() ?></td></tr></tbody>
                <tbody><tr><td>
                        <form method="get" action="customerdata.php">
                            <input type="hidden" name="edit" value="true">
                            <input type="submit" value="wijzig" />
                        </form>
                    </td><td></td></tr></tbody>
            </table>
            <?php
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

</body>
</html>