<?php
session_start();
if (!isset($_SESSION['gb_staff'])) {
  echo"<script>window.location='../index';</script>";
}else{
    include('../connector.php');
    $sql_u = mysqli_query($connect, "SELECT * FROM users WHERE deleted = 0");
    $n_u = mysqli_num_rows($sql_u);

    $sql_c = mysqli_query($connect, "SELECT * FROM accounts WHERE deleted = 0");
    $n_c = mysqli_num_rows($sql_c);

    $sql_b = mysqli_query($connect, "SELECT * FROM accounts WHERE deleted = 0");
    $cb = 0;
    while($d_b = mysqli_fetch_array($sql_b)){
        $cb = $cb + $d_b['balance'];
    }
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
                                    <a href="index" class="mm-active">
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

                            <?php if(isset($_SESSION['gb_staff_admin'])){
                                echo"<div class='col-md-6 col-xl-4'>
                                    <div class='card mb-3 widget-content bg-midnight-bloom'>
                                        <div class='widget-content-wrapper text-white'>
                                            <div class='widget-content-left'>
                                                <div class='widget-heading'>TELLERS</div>
                                                <div class='widget-subheading'>Registered Tellers</div>
                                            </div>
                                            <div class='widget-content-right'>
                                                <div class='widget-numbers text-white'><span>".$n_u."</span></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>";
                            } ?>

                            <div class="col-md-6 col-xl-4">
                                <div class="card mb-3 widget-content bg-arielle-smile">
                                    <div class="widget-content-wrapper text-white">
                                        <div class="widget-content-left">
                                            <div class="widget-heading">CUSTOMERS</div>
                                            <div class="widget-subheading">Registered Customers</div>
                                        </div>
                                        <div class="widget-content-right">
                                            <div class="widget-numbers text-white"><span><?php echo $n_c; ?></span></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 col-xl-4">
                                <div class="card mb-3 widget-content bg-grow-early">
                                    <div class="widget-content-wrapper text-white">
                                        <div class="widget-content-left">
                                            <div class="widget-heading">Bank</div>
                                            <div class="widget-subheading">Current balance</div>
                                        </div>
                                        <div class="widget-content-right">
                                            <div class="widget-numbers text-white"><span><?php echo $cb; ?> Frw</span></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="main-card mb-3 card">
                                    <div class="card-header">Active Accounts</div>
                                    <div class="table-responsive">
                                        <table class="align-middle mb-0 table table-borderless table-striped table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Account</th>
                                                    <th>Name</th>
                                                    <th style="text-align: right;">Balance</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                                $sql_u = mysqli_query($connect, "SELECT * FROM accounts WHERE deleted = 0 ORDER BY rand() LIMIT 5");
                                                while($d_u = mysqli_fetch_array($sql_u)){
                                                    echo"<tr>
                                                        <td>".$d_u['accountno']."</td>
                                                        <td>".$d_u['fullname']."</td>
                                                        <td style='text-align: right;'>".$d_u['balance']."Frw</td>
                                                    </tr>";
                                                }
                                            ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="d-block text-center card-footer">
                                       <?php if(!isset($_SESSION['gb_staff_admin'])){
                                        echo"<a href='transaction'>
                                        <a href='change'><button type='submit' style='margin-right: 20px;' class='btn btn-info'>My Account Settings</button></a>
                                        </a>";
                                    } ?>
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
