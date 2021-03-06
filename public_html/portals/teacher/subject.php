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
    <title> Subject Management Portal</title>
    <link href="../../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="../../dist/css/AdminLTE.css">
    <link rel="stylesheet" href="../../dist/css/skins/_all-skins.min.css">


    <link href="../../vendor/metisMenu/metisMenu.min.css" rel="stylesheet">
    <link href="../../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <script src="../../vendor/angularjs/angular.min.js"></script>
    <script src="assets/js/subjectHandler.js"></script>
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
                <li>
                    <a href="index.php">
                        <i class="fa fa-dashboard fa-fw"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="active">
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

    <div class="content-wrapper" ng-app="subjectHandler" ng-controller="myController">
        <section class="content-header">
            <h1>
                Subject Management Portal
                <small>
                    {{ selectedSubject.subject_code }}
                </small>
            </h1>
        </section>
        <section class="content">
            <div class="row">
                <form role="form" ng-submit="submitSubject()">

                    <div class="col-md-5">
                        <div class="box box-primary col-lg-4">
                            <div class="box-body">
                                <div class="form-group">
                                    <label class="control-label" for="subject">Subject Name</label>
                                    <div class="selectContainer">
                                        <select class="form-control" style="width: 100%;" id="subject" ng-model="selectedSubject"
                                                ng-options="x as x.name+' Section '+x.section_id for x in subjectList"
                                                >
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label" for="selectedSubject.no_of_co">Number of
                                        COs</label>
                                    <input type="number" id="selectedSubject.no_of_co" class="form-control"
                                           ng-model="selectedSubject.no_of_co"
                                           title="Number of CO's " ng-change="changeCO()"/>
                                </div>
                                <div class="text-right">
                                    <input type="submit" class="btn btn-success" value="Save">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-7">
                        <div class="box">
                            <div class="box-header">
                                <h4>Enter the Maximum CO Mapping for {{ selectedSubject.name}} ({{
                                selectedSubject.subject_code}})</h4>
                            </div>
                            <div class="box-body table-responsive no-padding">
                                    <table id="cie_table" class="table table-hover">
                                        <tr>
                                            <thead class="text-primary">
                                            <th class="text-center "></th>
                                            <th class="text-center "
                                                ng-repeat="row in selectedSubject.max_co[0] track by $index">
                                                CO{{$index + 1}}
                                            </th>
                                            <th class="text-center ">Total</th>
                                            </thead>
                                        </tr>
                                        <tr ng-repeat="row in selectedSubject.max_co track by $index">
                                            <td class="text-center text-primary ">CIE{{$index + 1}}</td>
                                            <td ng-repeat="cell in row track by $index ">

                                                <input type="number" class=" col-sm-1 text-center form-control"

                                                       ng-model="row[$index]" min="0" step="1">
                                            </td>
                                            <td class=" col-sm-1 text-center">
                                                {{getTotal(row)}}
                                            </td>
                                        </tr>
                                    </table>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
        </section>
    </div>
</div>
<!-- jQuery -->
<script src="../../vendor/jquery/jquery.min.js"></script>

<!-- Bootstrap Core JavaScript -->
<script src="../../vendor/bootstrap/js/bootstrap.min.js"></script>

<script src="../../dist/js/fastclick.js"></script>

<!-- Custom Theme JavaScript -->
<script src="../../dist/js/adminlte.js"></script>
</body>
</html>
