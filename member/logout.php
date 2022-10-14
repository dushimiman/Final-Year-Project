<?php session_start();
	unset($_SESSION['gb_member']);
	echo"<script>window.location='../index.php';</script>";
?>