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


    <link href="../../vendor/metisMenu/metisMenu.min.css" rel="stylesheet">
    <link href="../../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <script src="../../vendor/angularjs/angular.min.js"></script>
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
    <div class="content-wrapper">
        <section class="content-header">
            <h1>
                Teacher Dashboard
            </h1>
        </section>
        <section class="content">
        </section>
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
