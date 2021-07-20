<?php
//koneksi.php
$dbhost="localhost";
$dbname="scpk";
$dbuser="root";
$dbpassword="";


function opendb()
{
	global $dbhost, $dbuser, $dbpassword, $dbname, $dbconnection;
	$dbconnection=mysql_connect($dbhost, $dbuser, $dbpassword)
	or die ("gagal membuka database");
	$dbselect=mysql_select_db($dbname);
}

function closedb()
{
	global $dbconnection;
	mysql_close($dbconnection);
}

function querydb($query)
{
	$result=mysql_query($query) or die ("gagal melakukan Query=$query");
	return $result;
}
?>