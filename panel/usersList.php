<?php
session_start();
if (!isset($_SESSION['gb_staff'])) {
  echo"<script>window.location='../index';</script>";
}else{
    include('../connector.php');
}
?>
<!DOCTYPE html>
<html lang="en" >
<head>
  <meta charset="UTF-8">
  <title>Goshen Banking</title>
  <link rel="stylesheet" href="./style.css">

</head>
<body>
<!-- partial:index.partial.html -->
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Language" content="en">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Goshen Banking</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no" />
    <meta name="description" content="This is an example dashboard created using build-in elements and components.">
    <meta name="msapplication-tap-highlight" content="no">
<link href="https://demo.dashboardpack.com/architectui-html-free/main.css" rel="stylesheet"></head>
<body>
    <div class="app-container app-theme-white body-tabs-shadow fixed-sidebar fixed-header">
        <div class="app-header header-shadow">
            <div class="app-header__logo">
                <div></div>
                <div class="header__pane ml-auto">
                    <div>
                        <button type="button" class="hamburger close-sidebar-btn hamburger--elastic" data-class="closed-sidebar">
                            <span class="hamburger-box">
                                <span class="hamburger-inner"></span>
                            </span>
                        </button>
                    </div>
                </div>
            </div>
            <div class="app-header__mobile-menu">
                <div>
                    <button type="button" class="hamburger hamburger--elastic mobile-toggle-nav">
                        <span class="hamburger-box">
                            <span class="hamburger-inner"></span>
                        </span>
                    </button>
                </div>
            </div>
        </div>
        <div class="app-main">
                <div class="app-sidebar sidebar-shadow">
                    <div class="app-header__logo">
                        <div class="logo-src"></div>
                        <div class="header__pane ml-auto">
                            <div>
                                <button type="button" class="hamburger close-sidebar-btn hamburger--elastic" data-class="closed-sidebar">
                                    <span class="hamburger-box">
                                        <span class="hamburger-inner"></span>
                                    </span>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="app-header__mobile-menu">
                        <div>
                            <button type="button" class="hamburger hamburger--elastic mobile-toggle-nav">
                                <span class="hamburger-box">
                                    <span class="hamburger-inner"></span>
                                </span>
                            </button>
                        </div>
                    </div>
                    <div class="app-header__menu">
                        <span>
                            <button type="button" class="btn-icon btn-icon-only btn btn-primary btn-sm mobile-toggle-header-nav">
                                <span class="btn-icon-wrapper">
                                    <i class="fa fa-ellipsis-v fa-w-6"></i>
                                </span>
                            </button>
                        </span>
                    </div>

                    <div class="scrollbar-sidebar">
                        <div class="app-sidebar__inner">
                            <ul class="vertical-nav-menu">
                                <li class="app-sidebar__heading">Dashboard</li>
                                <li>
                                    <a href="index">
                                        <i class="metismenu-icon pe-7s-menu"></i>
                                        Dashboard
                                    </a>
                                </li>
                                <li class="app-sidebar__heading">Accounts</li>
                                <li>
                                    <a href="usersList" class="mm-active">
                                        <i class="metismenu-icon pe-7s-user"></i>
                                        Tellers
                                    </a>
                                    <a href="membersList">
                                        <i class="metismenu-icon pe-7s-users"></i>
                                        Customers
                                    </a>
                                </li>
                                <li class="app-sidebar__heading">Bank</li>
                                <li>
                                    <a href="bank">
                                        <i class="metismenu-icon pe-7s-display2"></i>
                                        History
                                    </a>
                                </li>
                                <li class="app-sidebar__heading">Options</li>
                                <li>
                                    <a href="logout">
                                        <i class="metismenu-icon pe-7s-lock"></i>
                                        Logout
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>

                </div>

                <div class="app-main__outer">

                    <div class="app-main__inner">
                        
                        <div class="row">
                            <a href="addNewUser"><button type="button" id="PopoverCustomT-1" class="btn btn-primary btn-sm" style="margin-left: 15px; margin-bottom: 15px;">New Teller</button></a>
                            <a href="usersList"><button type="button" class="btn btn-warning btn-sm" style="margin-left: 15px; margin-bottom: 15px">Refresh</button></a>
                            <div class="col-md-12">
                                <div class="main-card mb-3 card">
                                    <div class="card-header">Tellers List 
                                        <!-- <div class="btn-actions-pane-right">
                                            <div role="group" class="btn-group-sm btn-group">
                                                <button class="active btn btn-focus">Last Week</button>
                                                <button class="btn btn-focus">All Month</button>
                                            </div>
                                        </div> -->
                                    </div>
                                    <?php
                                    if(isset($_GET['data'])){
                                        if($_GET['data'] == 'success'){
                                            echo"<div class='alert alert-success' style='padding: 7px 20px; border-radius: 0;'>New teller is saved successfully!</div>";
                                        }
                                        if($_GET['data'] == 'deleted'){
                                            echo"<div class='alert alert-success' style='padding: 7px 20px; border-radius: 0;'>teller is deleted successfully!</div>";
                                        }
                                    }
                                    ?>
                                    <div class="table-responsive">
                                        <table class="align-middle mb-0 table table-borderless table-striped table-hover">
                                            <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Name</th>
                                                <th>Phone</th>
                                                <th>Email</th>
                                                <th colspan="2" style="text-align: center;">Options</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                        
                                            <?php
                                                if (isset($_GET['keyCode'])) {
                                                    $keyCode = $_GET['keyCode'];
                                                    $sql_u = mysqli_query($connect, "SELECT * FROM users WHERE deleted = 0 AND (fullname LIKE '%$keyCode%' OR phone LIKE '%$keyCode%' OR email LIKE '%$keyCode%') ORDER BY fullname ASC");
                                                }else{
                                                    $sql_u = mysqli_query($connect, "SELECT * FROM users WHERE deleted = 0 ORDER BY fullname ASC");
                                                }
                                                $rowCount = 0;
                                                while($d_u = mysqli_fetch_array($sql_u)){
                                                    $rowCount ++;
                                                    echo"<tr>
                                                        <td>".$rowCount."</td>
                                                        <td><b>".$d_u['fullname']."</b></td>
                                                        <td>".$d_u['phone']."</td>
                                                        <td>".$d_u['email']."</td>
                                                        <td>
                                                            <a href='editUser.php?userId=".$d_u['userid']."'><button type='button' id='PopoverCustomT-1' class='btn btn-primary btn-sm'>Edit</button></a>
                                                        </td>
                                                        <td>
                                                            <a href='../server.php?deleteUser=".$d_u['userid']."'><button type='button' id='PopoverCustomT-1' class='btn btn-danger btn-sm'>Delete</button></a>
                                                        </td>
                                                    </tr>";
                                                }
                                            ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="d-block text-center card-footer">
                                        <form method="GET">
                                            <input type="text" name="keyCode" style="padding: 3px 5px; position: relative; top: 2px;">
                                            <button class="btn-wide btn btn-success">Search</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            <script src="http://maps.google.com/maps/api/js?sensor=true"></script>
        </div>
    </div>
<script type="text/javascript" src="https://demo.dashboardpack.com/architectui-html-free/assets/scripts/main.js"></script></body>
</html>
<!-- partial -->
</body>
</html>
