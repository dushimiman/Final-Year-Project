<?php session_start();
	unset($_SESSION['gb_staff']);
	unset($_SESSION['gb_staff_admin']);
	echo"<script>window.location='../index.php';</script>";
?>