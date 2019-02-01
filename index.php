<?php    
require_once "includes/environment.php";

error_reporting(E_ALL);
    ini_set('display_errors', 1);

$zoopla = file_get_contents('http://api.zoopla.co.uk/api/v1/property_listings.xml?postcode='.$postcode.'&api_key='.$zooplakey);
$properties = simplexml_load_string($zoopla);


$objApiProperty = new Property($conn);

$objApiProperty->DeleteAllApi();

?>



<?php  
for
 ($i = 1; $i < 10; $i++) {
$objProperty = new Property($conn);
    
    $objProperty->County = $properties->listing[$i]->county;
    $objProperty->Country = $properties->listing[$i]->country;
    $objProperty->Town = $properties->listing[$i]->town;
    $objProperty->Description = $properties->listing[$i]->description;
    $objProperty->DetailsUrl = $properties->listing[$i]->details_url;
    $objProperty->Address = $properties->listing[$i]->displayable_address;
    $objProperty->ImageUrl = $properties->listing[$i]->image_url;
    $objProperty->ImageCaption = $properties->listing[$i]->image_caption;
    $objProperty->Latitude = $properties->listing[$i]->latitude;
    $objProperty->Longitude = $properties->listing[$i]->longitude;
    $objProperty->NumBedrooms = $properties->listing[$i]->num_bedrooms;
    $objProperty->NumBathrooms = $properties->listing[$i]->num_bathrooms;
    $objProperty->Price = $properties->listing[$i]->price;
    $objProperty->PropertyType = $properties->listing[$i]->property_type;
    $objProperty->Status = $properties->listing[$i]->status;
    $objProperty->FromApi = 1;
    $objProperty->Insert();
    $objProperty->GetByID($objProperty->ID);

  ?>

  <?php 
  
 
}
 $sql   = "SELECT id FROM properties ORDER BY price ASC ";
            $objRS = new ZpRecordset($conn, $sql);

?>
 
<!DOCTYPE html>
<html lang="en">
  <head>
    <script type="text/javascript" src="js/jquery.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400" rel="stylesheet">
    <link rel="stylesheet" href="css/styles-merged.css">
    <link rel="stylesheet" href="css/style.min.css">
    <link rel="stylesheet" href="css/custom.css">
      
      <link media="screen" rel="stylesheet" type="text/css" href="css/facebox.css">
     
    <script type="text/javascript" src="js/facebox.js"></script>
      <script type="text/javascript">
    jQuery(document).ready(function($) {
      $('a[rel*=facebox]').facebox({
        loadingImage : 'img/loading.gif',
        closeImage   : 'img/closelabel.png'
      })
    })
  </script>
<style>
body {font-family: Arial, Helvetica, sans-serif;}

</style>
    <!--[if lt IE 9]>
      <script src="js/vendor/html5shiv.min.js"></script>
      <script src="js/vendor/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>

  <!-- START: header -->
  
  <div class="probootstrap-loader"></div>

  <header role="banner" class="probootstrap-header">
    <div class="container">
        
        <a href="#" class="probootstrap-burger-menu visible-xs" ><i>Menu</i></a>
        <div class="mobile-menu-overlay"></div>

        <nav role="navigation" class="probootstrap-nav hidden-xs">
          <ul class="probootstrap-main-nav">
            <li class="active"><a href="#all">All Properties</a></li>
            <li><a href="#add">Add Property</a></li>
          </ul>
          <div class="extra-text visible-xs"> 
            <a href="#" class="probootstrap-burger-menu"><i>Menu</i></a>
          </div>
        </nav>
    </div>
  </header>
  <!-- END: header -->
 


  <section class="probootstrap-section probootstrap-section-lighter">
    <div class="container">
      <div class="row heading">
      <h2 class="mt0 mb50 text-center">  </h2>
        <h2 class="mt0 mb50 text-center" id="all">All Properties</h2>
      </div>
      <div class="row">
<?php  
      if (!$objRS->Error) {
            $objProperty = new Property($conn);
            foreach ($objRS->Data as $arrRS) {
             $objProperty->GetByID($arrRS['id']);
            
?>
        <div class="col-md-4 col-sm-6">
          <div class="probootstrap-card probootstrap-listing">
            <div class="probootstrap-card-media">
              <img src="<?php echo $objProperty->ImageUrl ;  ?>" class="img-responsive" >
              <a href="#" class="probootstrap-love"><i class="icon-heart"></i></a>
            </div>
            <div class="probootstrap-card-text">
              <h2 class="probootstrap-card-heading"><a href="#"> <?php echo $objProperty->NumBedrooms ;  ?> Bed Room Property</a></h2>
              <div class="probootstrap-listing-location">
                <i class="icon-location2"></i> <span><?php echo $objProperty->Address ;  ?></span>
              </div>
              <?php if ($objProperty->Status=="for_sale"){?> <div class="probootstrap-listing-category for-sale"><span>for sale</span></div><?php }  ?>
              <?php if ($objProperty->Status=="for_rent"){?> <div class="probootstrap-listing-category for-rent"><span>for rent</span></div><?php }  ?>
              
              <div class="probootstrap-listing-price"><strong>£ <?php echo $objProperty->Price ;  ?></strong></div>
            <button><a href="ajax/ajax.propertydetails.php?property=<?php echo $objProperty->ID;  ?>" rel="facebox">More details</a></button>
              
  
            </div>
            <div class="probootstrap-card-extra">
              <ul>
                <li>
                   Beds
                  <span><?php echo $objProperty->NumBedrooms ;  ?></span>
                </li>
                <li>
                  Baths
                  <span><?php echo $objProperty->NumBathrooms ;  ?></span>
                </li>
                <li>
                 <a href="ajax/ajax.edit.property.php?property=<?php echo $objProperty->ID;  ?>" rel="facebox"> <button type="button"  >Edit</button></a>
                </li>
                <li>
                <a href="actions/delete.property.php?property=<?php echo $objProperty->ID;  ?>" ><button type="button"   >Delete</button></a>
                </li>
              </ul>
            </div>
          </div>
          <!-- END listing -->
        </div>       
<?php  
               
                
                }
                }
?>  
        
        
      </div>
    </div>
  </section>

  <section class="probootstrap-slider flexslider">
    <div class="probootstrap-wrap-banner">
      <div class="container">
        <div class="row">
          <div class="col-md-8 col-md-offset-2">

            <div class="probootstrap-home-search probootstrap-animate">
              <form action="actions/add.property.php" method="post" method="post" enctype="multipart/form-data">
                <h2 class="heading" id="add">Add a new property</h2>
                <div class="probootstrap-field-group">
                  <div class="probootstrap-fields">
                    
                    <div class="search-field">
                     <input type="hidden" name="newProperty" value="1" />
	
	Country:
	<input class="form-control" type="text" name="Country"  />
	County:
	<input class="form-control" type="text" name="County"  />
	Town:
	<input class="form-control" type="text" name="Town"  />
	Description:
	<textarea class="form-control" name="Description"></textarea>
	DetailsUrl:
	<input class="form-control" type="text" name="DetailsUrl"  />
	Address:
	<input class="form-control" type="text" name="Address"  />
	ImageUrl:
	<input type="file" name="fileToUpload" id="fileToUpload">
	Latitude:
	<input class="form-control" type="text" name="Latitude"  />
	Longitude:
	<input class="form-control" type="text" name="Longitude"  />
	NumBedrooms:
	<select class="form-control" name="NumBedrooms" >
  		<option value="1">1</option>
  		<option value="2">2</option>
  		<option value="3">3</option>
  		<option value="4">4</option>
  		<option value="5">5</option>
  		<option value="6">6</option>
  		<option value="7">7</option>
  		<option value="8">8</option>
    	<option value="9">9</option>
  		<option value="10">10</option>
	</select>
	NumBathrooms:
	<select class="form-control"  name="NumBathrooms" >
  		<option value="1">1</option>
  		<option value="2">2</option>
  		<option value="3">3</option>
  		<option value="4">4</option>
  		<option value="5">5</option>
  		<option value="6">6</option>
  		<option value="7">7</option>
  		<option value="8">8</option>
    	<option value="9">9</option>
  		<option value="10">10</option>
	</select>
	Price:
	<input class="form-control" type="text" name="Price"  />
	PropertyType:
		<select class="form-control" name="PropertyType" >
  			<option value="Studio">Studio</option>
  			<option value="Apartment">Apartment</option>
  			<option value="Bungalow">Bungalow</option>
  			<option value="Cottage">Cottage</option>
  			<option value="Mobile Home">Mobile Home</option>
  			<option value="Chateau">Chateau</option>
  			<option value="Tree House">Tree House</option>
  			<option value="Semi-dettached house">Semi-dettached house</option>
    		<option value="detached house">detached house</option>
  			<option value="Terraced house">Terraced house</option>
		</select>
	Status:
	<select class="form-control" name="Status" >
  			<option value="For sale">For sale</option>
  			<option value="For rent">For rent</option>
  			
		</select>               </div>
                   
                  </div>
                  <button class="btn btn-success" type="submit"> Add</button>
                </div>
              </form>
            </div>

          </div>
        </div>
      </div>
    </div>
   
  </section>
  <!-- END: slider  -->

  
  <footer class="probootstrap-footer probootstrap-bg" style="background-image: url(img/slider_3.jpg)">
    
  </footer>

  <div class="gototop js-top">
    <a href="#" class="js-gotop"><i class="icon-chevron-thin-up"></i></a>
  </div>
  

  <script src="js/scripts.min.js"></script>
  <script src="js/main.min.js"></script>
  <script src="js/custom.js"></script>

  </body>
</html>