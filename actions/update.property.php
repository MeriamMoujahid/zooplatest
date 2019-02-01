<?php
 require_once '../includes/environment.php';
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
   
    
$ID = zpDenyChars(zpPostVar('id'), '"<>', false);
$County = zpDenyChars(zpPostVar('County'), '"<>', false);
$Country = zpDenyChars(zpPostVar('Country'), '"<>', false);
$Town = zpDenyChars(zpPostVar('Town'), '"<>', false);
$Description = zpDenyChars(zpPostVar('Description'), '"<>', false);
$DetailsUrl = zpDenyChars(zpPostVar('DetailsUrl'), '"<>', false);
$Address = zpDenyChars(zpPostVar('Address'), '"<>', false);
$ImageUrl = zpDenyChars(zpPostVar('ImageUrl'), '"<>', false);
$ImageCaption = zpDenyChars(zpPostVar('ImageCaption'), '"<>', false);
$Latitude = zpDenyChars(zpPostVar('Latitude'), '"<>', false);
$Longitude = zpDenyChars(zpPostVar('Longitude'), '"<>', false);
$NumBedrooms = zpDenyChars(zpPostVar('NumBedrooms'), '"<>', false);
$NumBathrooms = zpDenyChars(zpPostVar('NumBathrooms'), '"<>', false);
$Price = zpDenyChars(zpPostVar('Price'), '"<>', false);
$PropertyType = zpDenyChars(zpPostVar('PropertyType'), '"<>', false);
$Status = zpDenyChars(zpPostVar('Status'), '"<>', false);
$FromApi = 0;


//zpTruncate($dih_name, 250);


list($ok, $strResult) = array(true, 'OK|Changes saved.');
$objProperty = new Property($conn);

$objProperty->GetByID($ID);

if ($ok) {
	if ($objProperty->Error) {
			# code doesn't exist so it's an insertion
		$objProperty->ID = $ID;
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

}else {
		$objOldProperty = clone $objProperty;
		$objProperty->ID = $ID;
		$objProperty->County = $County;
		$objProperty->Country = $Country;
		$objProperty->Town = $Town;
		$objProperty->Description = $Description;
		$objProperty->DetailsUrl = $DetailsUrl;
		$objProperty->Address = $Address;
		$objProperty->ImageUrl = $ImageUrl;
		$objProperty->Latitude = $Latitude;
		$objProperty->Longitude = $Longitude;
		$objProperty->NumBedrooms = $NumBedrooms;
		$objProperty->NumBathrooms = $NumBathrooms;
		$objProperty->Price = $Price;
		$objProperty->PropertyType = $PropertyType;
		$objProperty->Status = $Status;
		$objProperty->FromApi = $FromApi;
		$objProperty->Update();
		//$objAuditTrail->SmartLogEvent("updated the Dish " . $dih_name, 'fb_dishes', $objDish->ID, $objDish->Name, $objOldDish, $objDish);
	}
}	

 header('Location: ../index.php');