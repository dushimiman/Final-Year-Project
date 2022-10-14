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
                                    <a href="bank" class="mm-active">
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
                                    <div class="card-header">Recent Transactions</div>
                                     <form method="GET">
                                            <table><tr><td>From:</td><td><input type="date" name="fromdate" required style="padding: 3px 5px; position: relative; top: 2px;"></td><td> <button class="btn-wide btn btn-success">Search</button></td></tr>
                                            <tr><td>To:</td><td><input type="date" required name="todate" style="padding: 3px 5px; position: relative; top: 2px;"></td></tr></table>
                                        </form>
                                    <div class="table-responsive">
                                        <table class="align-middle mb-0 table table-borderless table-striped table-hover">
                                            <thead>
                                            <tr>
                                                <th>Account</th>
                                                <th>Name</th>
                                                <th>Type</th>
                                                <th style='text-align: right;'>O.B</th>
                                                <th style='text-align: right;'>Amount</th>
                                                <th style='text-align: right;'>Balance</th>
                                                <th>Date</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                                if(isset($_GET['fromdate'])){
                                                    $fromdate = $_GET['fromdate'];
                                                    $todate = $_GET['todate'];
                                                    $sql_u = mysqli_query($connect, "SELECT * FROM transactions WHERE (DATE(trdatealt) BETWEEN '$fromdate' AND '$todate') ORDER BY id DESC LIMIT 10"); 
                                                }else{
                                                    $sql_u = mysqli_query($connect, "SELECT * FROM transactions ORDER BY id DESC LIMIT 10");
                                                }
                                                while($d_u = mysqli_fetch_array($sql_u)){

                                                    if($d_u['type'] == 'in'){
                                                        $type = 'Deposit';
                                                    }elseif($d_u['type'] == 'out'){
                                                       $type = 'Withdraw'; 
                                                    }

                                                    $sql_c = mysqli_query($connect, "SELECT * FROM accounts WHERE accountno='".$d_u['account']."'");
                                                    $d_c = mysqli_fetch_array($sql_c);

                                                    echo"<tr>
                                                        <td>".$d_c['accountno']."</td>
                                                        <td>".$d_c['fullname']."</td>
                                                        <td>".$type."</td>
                                                        <td style='text-align: right;'>".$d_u['ob']."Frw</td>
                                                        <td style='text-align: right;'>".$d_u['amount']."Frw</td>
                                                        <td style='text-align: right;'>".$d_u['balance']."Frw</td>
                                                        <td>".date('d/m/Y H:i', $d_u['trdate'])."</td>
                                                    </tr>";
                                                }
                                            ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="d-block text-center card-footer"></div>
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
