<?php
    require_once '../includes/environment.php';
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
   
    
    $County = zpDenyChars(zpPostVar('County'), '"<>', false);
    $Country = zpDenyChars(zpPostVar('Country'), '"<>', false);
    $Town = zpDenyChars(zpPostVar('Town'), '"<>', false);
    $Description = zpDenyChars(zpPostVar('Description'), '"<>', false);
    $DetailsUrl = zpDenyChars(zpPostVar('DetailsUrl'), '"<>', false);
    $Address = zpDenyChars(zpPostVar('Address'), '"<>', false);
    $Latitude = zpDenyChars(zpPostVar('Latitude'), '"<>', false);
    $Longitude = zpDenyChars(zpPostVar('Longitude'), '"<>', false);
    $NumBedrooms = zpDenyChars(zpPostVar('NumBedrooms'), '"<>', false);
    $NumBathrooms = zpDenyChars(zpPostVar('NumBathrooms'), '"<>', false);
    $Price = zpDenyChars(zpPostVar('Price'), '"<>', false);
    $PropertyType = zpDenyChars(zpPostVar('PropertyType'), '"<>', false);
    $Status = zpDenyChars(zpPostVar('Status'), '"<>', false);
    $FromApi = zpDenyChars(zpPostVar('FromApi'), '"<>', false);
    $newProperty = zpDenyChars(zpPostVar('newProperty'), '"<>', false);
    if($newProperty == 1) { $FromApi = 0;} else {$FromApi = 1;}
    $ImageCaption = "";
    
    $target_dir = "../uploads/";
	$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
	$uploadOk = 1;
	$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
	// Check if image file is a actual image or fake image
	
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
    $ImageUrl = "uploads/". basename($_FILES["fileToUpload"]["name"]);
    echo $ImageUrl;
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
        move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file);
        
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }

    
    //zpTruncate($dih_name, 250);
    
    
    list($ok, $strResult) = array(true, 'OK|Changes saved.');
    $objProperty = new Property($conn);
    
    
    
    $objProperty->ID = zpGuid();
    $objProperty->County = $County;
    $objProperty->Country = $Country;
    $objProperty->Town = $Town;
    $objProperty->Description = $Description;
    $objProperty->DetailsUrl = $DetailsUrl;
    $objProperty->Address = $Address;
    $objProperty->ImageUrl = $ImageUrl;
    $objProperty->ImageCaption = $ImageCaption;
    $objProperty->Latitude = $Latitude;
    $objProperty->Longitude = $Longitude;
    $objProperty->NumBedrooms = $NumBedrooms;
    $objProperty->NumBathrooms = $NumBathrooms;
    $objProperty->Price = $Price;
    $objProperty->PropertyType = $PropertyType;
    $objProperty->Status = $Status;
    $objProperty->FromApi = $FromApi;
    $objProperty->Insert();
    $objProperty->GetByID($objProperty->ID); # always reget after inserting
    //$objAuditTrail->SmartLogEvent("added the Dish " . $dih_name, 'fb_dishes', $objProperty->ID, $objProperty->Name, null, $objProperty);
    
    header('Location: ../index.php'); 
    

