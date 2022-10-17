<?php
session_start();
if (!isset($_SESSION['gb_staff'])) {
  echo"<script>window.location='../index';</script>";
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
                                    <a href="index" class='mm-active'>
                                        <i class="metismenu-icon pe-7s-menu"></i>
                                        Dashboard
                                    </a>
                                </li>
                                <li class="app-sidebar__heading">Accounts</li>
                                <li>
                                    <?php if(isset($_SESSION['gb_staff_admin'])){
                                        echo"<a href='usersList'>
                                            <i class='metismenu-icon pe-7s-user'></i>
                                            Tellers
                                        </a>";
                                    } ?>
                                    <a href="membersList">
                                        <i class="metismenu-icon pe-7s-users"></i>
                                        Customers
                                    </a>
                                    <?php if(!isset($_SESSION['gb_staff_admin'])){
                                        echo"<a href='transaction'>
                                            <i class='metismenu-icon pe-7s-menu'></i>
                                            Transactions
                                        </a>";
                                    } ?>
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
                            <div class="col-md-12">

                                <div class="main-card mb-3 card">

                                    <div class="card-header">Change Account Password</div>
                                    <div style="padding: 10px 20px 30px 20px;">
                                        <?php
                                            if(isset($_GET['data'])){
                                                if($_GET['data'] == 'changed'){
                                                    echo"<div class='alert alert-success' style='padding: 7px 20px; border-radius: 0;'>New password is set successfully!</div>";
                                                }
                                                if($_GET['data'] == 'wcp'){
                                                    echo"<div class='alert alert-warning' style='padding: 7px 20px; border-radius: 0;'>Entered current password is invalid!</div>";
                                                }
                                            }
                                        ?>
                                        <form method="POST" action="../server.php">
                                            <div class="form-group">
                                                <label for="exampleInputPassword1">Current password</label>
                                                <input type="text" name="current" class="form-control" placeholder="Enter your current password" required>
                                            </div>
                                             <div class="form-group">
                                                <label for="exampleInputPassword1">New password</label>
                                                <input type="text" name="new" class="form-control" placeholder="Enter your new password" required>
                                            </div>
                                            <button type="submit" name="changePassword" class="btn btn-primary">Save changes</button>
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
<script type="text/javascript">
    function allowNumbersOnly(evt){
    var charCode = (evt.which) ? evt.which : event.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;
    return true;
    } 
</script>
</body>
</html>
