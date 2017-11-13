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
    <link href="../../dist/css/sb-admin-2.css" rel="stylesheet">
    <link href="../../vendor/metisMenu/metisMenu.min.css" rel="stylesheet">
    <link href="../../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular.min.js"></script>
    <script src="assets/js/subjectHandler.js"></script>
</head>

<body>
<div id="wrapper">
    <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="index.php">Teacher Dashboard</a>
        </div>
        <ul class="nav navbar-top-links navbar-right">
            <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                    <i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i>
                </a>
                <ul class="dropdown-menu dropdown-user">
                    <li><a href="#"><i class="fa fa-user fa-fw"></i> User Profile</a>
                    </li>
                    <li><a href="#"><i class="fa fa-gear fa-fw"></i> Settings</a>
                    </li>
                    <li class="divider"></li>
                    <li><a href="../../logout.php"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                    </li>
                </ul>
                <!-- /.dropdown-user -->
            </li>
        </ul>
        <div class="navbar-default sidebar" role="navigation">
            <div class="sidebar-nav navbar-collapse">
                <ul class="nav" id="side-menu">
                    <li>
                        <a href="index.php">
                            <i class="fa fa-dashboard fa-fw" style="font-size: 2em;"></i>
                            Dashboard
                        </a>
                    </li>
                    <li>
                        <a href="subject.php">
                            <i class="fa fa-book fa-fw" style="font-size: 2em;"></i>
                            Manage Subjects
                        </a>
                    </li>
                    <li class="active">
                        <a href="student.php">
                            <i class=" fa fa-users fa-fw" style="font-size: 2em;"></i>
                            Manage Students
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12 ">
                <h1 class="page-header">Subject Management</h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <div class="row" ng-app="subjectHandler" ng-controller="myController">
            <form ng-submit="submitSubject()">
                <div class="container col-lg-12">
                    <div class="row">
                        <div class="panel panel-default col-lg-4">
                            <div class="panel-body">
                                <div class="form-group">
                                    <label class="control-label" for="subject">Subject Name</label>
                                    <div class="selectContainer">
                                        <select id="subject" ng-model="selectedSubject"
                                                ng-options="x as x.name+' Section '+x.section_id for x in subjectList"
                                                class="form-control">
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label" for="selectedSubject.no_of_co">Number of COs</label>
                                    <input type="number" id="selectedSubject.no_of_co" class="form-control"
                                           ng-model="selectedSubject.no_of_co"
                                           title="Number of CO's " ng-change="changeCO()"/>
                                </div>
                                <div class="text-right">
                                    <input type="submit" class="btn btn-success" value="Save">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-7">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    Enter the Maximum CO Mapping for {{ selectedSubject.name}} ({{
                                        selectedSubject.subject_code}})</h4>
                                </div>
                                <div class="panel-body">
                                    <div class="table-responsive">
                                    <table id="cie_table" class="table">
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
                        </div>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>
<!-- jQuery -->
<script src="../../vendor/jquery/jquery.min.js"></script>

<!-- Bootstrap Core JavaScript -->
<script src="../../vendor/bootstrap/js/bootstrap.min.js"></script>

<!-- Metis Menu Plugin JavaScript -->
<script src="../../vendor/metisMenu/metisMenu.min.js"></script>

<!-- Custom Theme JavaScript -->
<script src="../../dist/js/sb-admin-2.js"></script>
</body>
</html>
