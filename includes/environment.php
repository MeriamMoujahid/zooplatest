<?php
# initial housekeeping
ini_set("session.use_only_cookies", "1");
session_start();
ob_start();


# classes and functions
require_once "zplib/header.p3p.php";
require_once "zplib/header.nocache.php";
require_once "zplib/functions.php";
require_once "zplib/class.zprecordset.php";
require_once "zplib/class.zppagingrecordset.php";
require_once "zplib/class.zpsimplecrypt.php";
require_once "zplib/class.zpurl.php";
require_once "class.property.php";

#API connection
$postcode = "EH10";
$zooplakey = "";
$googlemapkey = "";

# database connection
$strDbServer = 'localhost';
$strDbUsername = 'mtctest';
$strDbPassword = 'mtctest';
$strDbDatabase = 'Zoopla';


if (!($conn = zpConnectMySQL($strDbServer, $strDbUsername, $strDbPassword, $strDbDatabase))) {
	cleanUpAndRedirect( 'maintenance.php'); # if we can't connect, go to a page that doesn't try to, thus preventing an endless redirect
}
mysqli_query($conn, "SET NAMES 'utf8' COLLATE 'utf8_unicode_ci'"); # force utf8 in result sets

