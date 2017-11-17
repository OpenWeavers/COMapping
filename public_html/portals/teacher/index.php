<?php
session_start();
if (!isset($_SESSION['teacher_login'])) {
    header('location:../../');
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Teacher Dashboard</title>
    <link href="../../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="../../dist/css/AdminLTE.css">
    <link rel="stylesheet" href="../../dist/css/skins/_all-skins.min.css">
    <link rel="stylesheet" href="../../vendor/morris.js/morris.css">

    <link href="../../vendor/Ionicons/css/ionicons.min.css" rel="stylesheet">
    <link href="../../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script src="../../vendor/angularjs/angular.min.js"></script>
    <script src="assets/js/infoHandler.js"></script>

    <script src="../../vendor/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../../vendor/bootstrap/js/bootstrap.min.js"></script>

    <script src="../../dist/js/fastclick.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="../../dist/js/adminlte.js"></script>

    <script src="../../vendor/jquery-knob/js/jquery.knob.js"></script>

    <script>
        $(function () {
            /* jQueryKnob */

            $(".knob").knob({
                /*change : function (value) {
                 //console.log("change : " + value);
                 },
                 release : function (value) {
                 console.log("release : " + value);
                 },
                 cancel : function () {
                 console.log("cancel : " + this.value);
                 },*/
                draw: function () {

                    // "tron" case
                    if (this.$.data('skin') == 'tron') {

                        var a = this.angle(this.cv)  // Angle
                            , sa = this.startAngle          // Previous start angle
                            , sat = this.startAngle         // Start angle
                            , ea                            // Previous end angle
                            , eat = sat + a                 // End angle
                            , r = true;

                        this.g.lineWidth = this.lineWidth;

                        this.o.cursor
                        && (sat = eat - 0.3)
                        && (eat = eat + 0.3);

                        if (this.o.displayPrevious) {
                            ea = this.startAngle + this.angle(this.value);
                            this.o.cursor
                            && (sa = ea - 0.3)
                            && (ea = ea + 0.3);
                            this.g.beginPath();
                            this.g.strokeStyle = this.previousColor;
                            this.g.arc(this.xy, this.xy, this.radius - this.lineWidth, sa, ea, false);
                            this.g.stroke();
                        }

                        this.g.beginPath();
                        this.g.strokeStyle = r ? this.o.fgColor : this.fgColor;
                        this.g.arc(this.xy, this.xy, this.radius - this.lineWidth, sat, eat, false);
                        this.g.stroke();

                        this.g.lineWidth = 2;
                        this.g.beginPath();
                        this.g.strokeStyle = this.o.fgColor;
                        this.g.arc(this.xy, this.xy, this.radius - this.lineWidth + 1 + this.lineWidth * 2 / 3, 0, 2 * Math.PI, false);
                        this.g.stroke();

                        return false;
                    }
                }
            })
        });
        /* END JQUERY KNOB */
    </script>
</head>

<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">
    <header class="main-header">
        <a href="index.php" class="logo">
            <!-- mini logo for sidebar mini 50x50 pixels -->
            <span class="logo-mini"><b>CO</b></span>
            <!-- logo for regular state and mobile devices -->
            <span class="logo-lg"><b>CO</b>MS</span>
        </a>
        <nav class="navbar navbar-static-top">
            <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                <span class="sr-only">Toggle navigation</span>
            </a>
            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                    <li class="dropdown user user-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <img src="../../dist/img/avatar.png" class="user-image" alt="User Image">
                            <span class="hidden-xs"><?php echo $_SESSION['staff_name'] ?></span>
                        </a>
                        <ul class="dropdown-menu">
                            <!-- User image -->
                            <li class="user-header">
                                <img src="../../dist/img/avatar.png" class="img-circle" alt="User Image">

                                <p>
                                    <?php echo $_SESSION['staff_name'] ?>
                                    <small></small>
                                </p>
                            </li>
                            <!-- Menu Footer-->
                            <li class="user-footer">
                                <div class="pull-left">
                                    <a href="#" class="btn btn-default btn-flat">Profile</a>
                                </div>
                                <div class="pull-right">
                                    <a href="../../logout.php" class="btn btn-default btn-flat">Sign out</a>
                                </div>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>
    </header>
    <aside class="main-sidebar">
        <section class="sidebar">
            <div class="user-panel">
                <div class="pull-left image">
                    <img src="../../dist/img/avatar.png" class="img-circle" alt="User Image">
                </div>
                <div class="pull-left info">
                    <p><?php echo $_SESSION['staff_name'] ?></p>
                    <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
                </div>
            </div>
            <ul class="sidebar-menu" data-widget="tree">
                <li class="header">MAIN NAVIGATION</li>
                <li class="active">
                    <a href="index.php">
                        <i class="fa fa-dashboard fa-fw"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="subject.php">
                        <i class="fa fa-book fa-fw"></i>
                        <span>Manage Subjects</span>
                    </a>
                </li>
                <li>
                    <a href="student.php">
                        <i class=" fa fa-users fa-fw"></i>
                        <span>Manage Students</span>
                    </a>
                </li>
            </ul>
        </section>
    </aside>
    <div class="content-wrapper" ng-app="infoHandler" ng-controller="myController">
        <section class="content-header">
            <h1>
                Teacher Dashboard
            </h1>
        </section>
        <section class="content">
            <div class="row">
                <div class="col-lg-3 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-aqua">
                        <div class="inner">
                            <h3>{{subInfo.length}}</h3>

                            <p>Subjects</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-clipboard"></i>
                        </div>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-blue">
                        <div class="inner">
                            <h3>{{total_students}}</h3>

                            <p>Students Combined</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-android-people"></i>
                        </div>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-green">
                        <div class="inner">
                            <h3>{{total_entered}}</h3>

                            <p>Entry over</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-person-stalker"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-purple">
                        <div class="inner">
                            <h3>{{((total_entered/total_students)*100).toFixed(2)}} <sup style="font-size: 20px">%</sup>
                            </h3>

                            <p>Task Complete</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-pie-graph"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="box">
                <div class="box-header">
                    <h4>Subject Summary</h4>
                </div>
                <div class="box-body table-responsive table-bordered no-padding">
                    <table class="table">
                        <tr>
                            <thead>
                            <th ng-repeat="x in properties"> {{ humanize(x) }}</th>
                            </thead>
                        </tr>
                        <tr ng-repeat="subject in subInfo">
                            <td ng-repeat="prop in properties">
                                {{ subject[prop] }}
                            </td>
                            <td>
                                <button class="btn btn-flat" ng-click="calculate(subject)">Get Stats</button>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12">
                    <!-- jQuery Knob -->
                    <div class="box box-solid">
                        <div class="box-header">
                            <i class="fa fa-bar-chart-o"></i>

                            <h3 class="box-title">Subjectwise Progress</h3>
                        </div>
                        <div class="box-body">
                            <div class="col-xs-6 col-md-3 text-center" ng-repeat="subject in subInfo">
                                <input type="text" class="knob" value="{{subject.percentage}}" data-width="120"
                                       data-height="120"
                                       data-fgColor="#3c8dbc" data-readonly="true">

                                <div class="knob-label">{{subject.subject_name}}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12">
                    <!-- jQuery Knob -->
                    <div class="box box-solid">
                        <div class="box-header">
                            <i class="fa fa-bar-chart-o"></i>

                            <h3 class="box-title">Summary Resutls</h3>
                        </div>
                        <div class="box-body">
                            <div class="row">
                                <div id="cie_chart_div" class=" col-md-6"></div>
                                <div id="co_chart_div" class=" col-md-6"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <!-- jQuery -->

</body>
</html>
