<?php
include 'functions.php';
if ($currentCustomer->getAccounttype() == 'medewerker'){
    if (!empty($_GET['id'])){
        $id = $_GET['id'];
    }else{
        $id = $currentCustomer->getId();
    }
}else{
    $id = $currentCustomer->getId();
}
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
                Maandelijkse statistieken
                <small>Hieronder staan al uw maandelijkse statistieken</small>
            </h1>
        </section>

        <!-- Main content -->
        <section class="content container-fluid">

            <div class="row">
                <div class="col-lg-6 col-md-12 col-sm-12">
                    <div class="chart-container lg-" >
                        <canvas id="gymgoingmonth"></canvas>
                    </div>
                </div>
                <div class="col-lg-6 col-md-12 col-sm-12">
                    <div class="chart-container lg-" >
                        <canvas id="equipmentusemonth"></canvas>
                    </div>
                </div>
            </div>
            <section class="content-header">
                <h1>
                    Alle statistieken
                    <small>Hieronder staan al uw statistieken sinds uw aanmelding</small>
                </h1>
            </section>
            <div class="row">
                <div class="col-lg-6 col-md-12 col-sm-12">
                    <div class="chart-container lg-" >
                        <canvas id="gymgoingall"></canvas>
                    </div>
                </div>
                <div class="col-lg-6 col-md-12 col-sm-12">
                    <div class="chart-container lg-" >
                        <canvas id="equipmentuseall"></canvas>
                    </div>
                </div>
            </div>

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

<script>
    var gymchart = $("#gymgoingmonth");
    var equipchart = $('#equipmentusemonth');
    var url = 'ajax.php';
    $.ajax({
        type: "POST",
        url: url,
        data: {actionName: 'monthchart', id : '<?= $id ?>'},
        success: function(result){
            var chartarray = JSON.parse(result);
            console.log(chartarray);
            buildcharts(chartarray)
        },
        dataType: 'json'
    });

    function buildcharts(chartarray){

        var days = chartarray['dates'];
        var equipment = chartarray['devicetypes'];
        var datadays = chartarray['data']['visits'];
        var datacal = chartarray['data']['calories'];
        var tempdataequip = chartarray['data']['devices'];
        var dataequip = $.map(tempdataequip, function(value, index) {
            return [value];
        });


        var gymchartconfig = {
            type: 'bar',
            data:{
                labels: days,
                datasets:[{

                    label: "bezoek",
                    backgroundColor: "#0000FF",
                    borderColor: "#0000FF",
                    data:
                    datadays


                },{
                    label: "calorieën per honderd",
                    backgroundColor: "transparent",
                    borderColor: "#FF0000",
                    data:
                    datacal,
                    type: 'line'
                }

                ]},
            options: {
                responsive: true,
                title:{
                    display:true,
                    text:'Calorieën en bezoeken per maand'
                },
                tooltips: {
                    mode: 'index',
                    intersect: false
                },
                hover: {
                    mode: 'nearest',
                    intersect: true
                },
                scales: {
                    xAxes: [{
                        display: true,
                        scaleLabel: {
                            display: true,
                            labelString: 'Dagen'
                        }
                    }],
                    yAxes: [{
                        display: true,
                        scaleLabel: {
                            display: true,
                            labelString: 'Aantal'
                        }, ticks: {
                            beginAtZero:true
                        }
                    }]
                }
            }


        };
        var equipchartconfig = {

            type: 'pie',
            data: {
                labels: equipment,
                datasets: [{
                    data: dataequip,
                    backgroundColor: [
                        "#FF6384",
                        "#63FF84"
                    ]

                }]
            },
            config:{
                responsive: true
            }
        };

        window.myLine = new Chart(equipchart, equipchartconfig);
        window.myLine = new Chart(gymchart, gymchartconfig);
    }



</script>

<script>
    var gymchartall = $("#gymgoingall");
    var equipchartall = $('#equipmentuseall');
    var url = 'ajax.php';
    $.ajax({
        type: "POST",
        url: url,
        data: {actionName: 'allchart', id : '<?= $id ?>'},
        success: function(result){
            var chartarrayall = JSON.parse(result);
            console.log(chartarrayall);
            buildchartsall(chartarrayall)
        },
        dataType: 'json'
    });

    function buildchartsall(chartarray){

        var daysall = chartarray['dates'];
        var equipmentall = chartarray['devicetypes'];
        var datadaysall = chartarray['data']['visits'];
        var datacalall = chartarray['data']['calories'];
        var tempdataequipall = chartarray['data']['devices'];
        var dataequipall = $.map(tempdataequipall, function(value, index) {
            return [value];
        });


        var gymchartconfigall = {
            type: 'bar',
            data:{
                labels: daysall,
                datasets:[{

                    label: "bezoek",
                    backgroundColor: "#0000FF",
                    borderColor: "#0000FF",
                    data:
                    datadaysall


                },{
                    label: "calorieën per honderd",
                    backgroundColor: "transparent",
                    borderColor: "#FF0000",
                    data:
                    datacalall,
                    type: 'line'
                }

                ]},
            options: {
                responsive: true,
                title:{
                    display:true,
                    text:'Calorieën en bezoeken altijd'
                },
                tooltips: {
                    mode: 'index',
                    intersect: false
                },
                hover: {
                    mode: 'nearest',
                    intersect: true
                },
                scales: {
                    xAxes: [{
                        display: true,
                        scaleLabel: {
//                            display: true,
                            labelString: 'Dagen'
                        }
                    }],
                    yAxes: [{
                        display: true,
                        scaleLabel: {
                            display: true,
                            labelString: 'Aantal'
                        }, ticks: {
                            beginAtZero:true
                        }
                    }]
                }
            }


        };
        var equipchartconfigall = {

            type: 'pie',
            data: {
                labels: equipmentall,
                datasets: [{
                    data: dataequipall,
                    backgroundColor: [
                        "#FF6384",
                        "#63FF84"
                    ]

                }]
            }
        };

        window.myLine = new Chart(equipchartall, equipchartconfigall);
        window.myLine = new Chart(gymchartall, gymchartconfigall);
    }



</script>
</body>
</html>