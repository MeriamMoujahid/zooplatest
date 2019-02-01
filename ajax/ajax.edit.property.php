<?php
require_once "../includes/environment.php";
//$strAjaxType = 'staff';
//require_once '../includes/ssi.ajax.top.php';
//ajaxKickIfInsufficientRights($conn, 'STAFF', $objCurrentUser->ProfileID);

error_reporting(E_ALL);
ini_set('display_errors', 1);

$property = zpGetOrPostVar('property');

//echo $property;

$objProperty = new Property($conn);
$objProperty->GetByID($property);

?>

<div class="ajax ajax800">

<h3>Edit Property</h3>


<form id="frmAdminRightsEdit" action="actions/update.property.php" method="post" enctype="multipart/form-data" autocomplete="off">
<input type="hidden" name="intCurPage" value="<?php echo $intCurPage?>" />
<table class="formtable">

	<input type="hidden" name="id" value="<?php echo $objProperty->ID;?>" />
	<input type="hidden" name="ImageUrl" value="<?php echo $objProperty->ImageUrl;?>" />
	<tr>
	<th>Country</th>
	<td><input class="small-text focusHere" type="text" name="Country" value="<?php echo $objProperty->Country;?>" /></td>
	</tr>
	<tr>
	<th>County</th>
	<td><input class="small-text focusHere" type="text" name="County" value="<?php echo $objProperty->County;?>" /></td>
		</tr>
		<tr>
	<th>Town:</th>
	<td><input class="small-text focusHere" type="text" name="Town"  value="<?php echo $objProperty->Town;?>" /></td>
		</tr>
	
		<tr>
	<th>Description</th>
	<td><input class="small-text focusHere" type="text" name="Description" value="<?php echo $objProperty->Description;?>" /></td>
		</tr>
	<tr>
	<th>DetailsUrl:</th>
	<td><input class="small-text focusHere" type="text" name="DetailsUrl" value="<?php echo $objProperty->DetailsUrl;?>" /></td>
	</tr>
	
	<tr>
	<th>Address:</th>
	<td><input class="small-text focusHere" type="text" name="Address"  value="<?php echo $objProperty->Address;?>" /></td>
	</tr>
	
	<tr>
	<th>Latitude:</th>
	<td><input class="small-text focusHere" type="text" name="Latitude"  value="<?php echo $objProperty->Latitude;?>" /></td>
	</tr>
	
	<tr>
	<th>Longitude:</th>
	<td><input class="small-text focusHere" type="text" name="Longitude"  value="<?php echo $objProperty->Longitude;?>" /></td>
	</tr>
	
	<tr>
	<th>NumBedrooms:</th>
	<td><input class="small-text focusHere" type="text" name="NumBedrooms"  value="<?php echo $objProperty->NumBedrooms;?>" /></td>
	</tr>
	
	<tr>
	<th>NumBathrooms:</th>
	<td><input class="small-text focusHere" type="text" name="NumBathrooms"  value="<?php echo $objProperty->NumBathrooms;?>" /></td>
	</tr>
	
	<tr>
	<th>Price:</th>
	<td><input class="small-text focusHere" type="text" name="Price"  value="<?php echo $objProperty->Price;?>" /></td>
	</tr>
	
	<tr>
	<th>PropertyType:</th>
	<td><input class="small-text focusHere" type="text" name="PropertyType"  value="<?php echo $objProperty->PropertyType;?>" /></td>
	</tr>
	
	<tr>
	<th>Status:</th>
	<td><input class="small-text focusHere" type="text" name="Status"  value="<?php echo $objProperty->Status;?>" /></td>
	</tr>

</table>


<div class="formbuttons">
<div class="left">
</div>
<div class="right">
<input type="submit" value="Submit">
</div>
<div class="clearer"></div>
</div><!--/formbuttons-->


</form>
</div><!--/ajax720-->


