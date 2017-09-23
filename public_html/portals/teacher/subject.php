<?php
session_start();
if (!isset($_SESSION['teacher_login'])) {
    header('location:../../');
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
    <title>Teacher Dashboard</title>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport'/>
    <meta name="viewport" content="width=device-width"/>
    <link href="../../assets/css/bootstrap.min.css" rel="stylesheet"/>
    <link href="../../assets/css/material-dashboard.css?v=1.2.0" rel="stylesheet"/>
    <link href="http://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
    <link href='http://fonts.googleapis.com/css?family=Roboto:400,700,300|Material+Icons' rel='stylesheet'
          type='text/css'>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.4.0/angular-messages.js"></script>
    <script src="assets/js/subjectHandler.js"></script>
</head>

<body>
<div class="wrapper">
    <div class="sidebar" data-color="purple" data-image="../assets/img/sidebar-1.jpg">
        <div class="logo">
            <a href="#" class=" simple-text">
                Teacher Dashboard
            </a>
        </div>
        <div class="sidebar-wrapper">
            <ul class="nav">
                <li>
                    <a href="index.php">
                        <i class="material-icons">dashboard</i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li  class="active">
                    <a href="subject.php">
                        <i class="material-icons">book</i>
                        <p>Manage Subjects</p>
                    </a>
                </li>
                <li>
                    <a href="student.php">
                        <i class="material-icons">assignment</i>
                        <p>Manage Students</p>
                    </a>
                </li>
            </ul>
        </div>
    </div>
    <div class="main-panel">
        <nav class="navbar navbar-transparent navbar-absolute">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <p class="navbar-brand"> Subject Management </p>
                </div>
                <div class="collapse navbar-collapse">
                    <ul class="nav navbar-nav navbar-right">
                        <li>
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="material-icons">person</i>
                                <p class="hidden-lg hidden-md">Profile</p>
                            </a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a href="#">Manage Account</a>
                                </li>
                                <li>
                                    <a href="../../logout.php">Logout</a>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <div class="content" ng-app="subjectHandler" ng-controller="myController">
            <form ng-submit="submitSubject()">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label class="control-label" for="subject">Subject Name</label>
                                <div class="selectContainer">
                                    <select id="subject" ng-model="selectedSubject"
                                            ng-options="x as x.name for x in subjectList" class="form-control">
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="noOfCOs">Number of COs</label>
                                <input type="number" id="noOfCOs" class="form-control" ng-model="noOfCOs"
                                       title="Number of CO's " ng-change="changeCO()"/>
                            </div>
                            <div class="text-right">
                                <input type="submit" class="btn btn-primary" value="Save">
                            </div>
                        </div>
                        <div class="col-sm-7">
                            <div class="card">
                                <div class="card-header" data-background-color="purple">
                                    <h4 class="title">Maximum CO Mapping for {{ selectedSubject.name}}</h4>
                                    <p class="category">Enter the maximum CO for each CIE</p>
                                </div>
                                <div class="card-content">
                                    <table id="cie_table" class="table-responsive">
                                        <tr>
                                            <thead class="text-primary">
                                            <th></th>
                                            <th ng-repeat="row in subject.CIE[0] track by $index">CO{{$index + 1}}
                                            </th>
                                            </thead>
                                        </tr>
                                        <tr ng-repeat="row in subject.CIE">

                                            <td>CIE{{$index + 1}}</td>
                                            <td ng-repeat="cell in row track by $index">
                                                <input type="number" class="form-control" value="{{cell}}"
                                                       ng-model="row[$index]" min="0" step="1">
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>
</body>
<script src="../../assets/js/jquery-3.2.1.min.js" type="text/javascript"></script>
<script src="../../assets/js/bootstrap.min.js" type="text/javascript"></script>
<script src="../../assets/js/material.min.js" type="text/javascript"></script>
<!--  Charts Plugin -->
<script src="../../assets/js/chartist.min.js"></script>
<!--  Dynamic Elements plugin -->
<script src="../../assets/js/arrive.min.js"></script>
<!--  PerfectScrollbar Library -->
<script src="../../assets/js/perfect-scrollbar.jquery.min.js"></script>
<!--  Notifications Plugin    -->
<script src="../../assets/js/bootstrap-notify.js"></script>
<!-- Material Dashboard javascript methods -->
<script src="../../assets/js/material-dashboard.js?v=1.2.0"></script>
</html>
