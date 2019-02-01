<?php
 require_once '../includes/environment.php';
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
   

$property = zpGetOrPostVar('property');


$objProperty = new Property($conn);
$objProperty->GetByID($property);

$objProperty->Delete();

 header('Location: ../index.php');
