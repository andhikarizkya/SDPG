<?php
session_start();
unset($_SESSION['sesIdUser']);
unset($_SESSION['sesNamaUser']);
unset($_SESSION['sesTipeUser']);
header("location:login.php");
?>