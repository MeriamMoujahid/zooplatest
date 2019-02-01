<?php
require_once "../includes/environment.php";
$property = zpGetOrPostVar('property');


$objProperty = new Property($conn);
$objProperty->GetByID($property);
echo $objProperty->Description;

?>
<!DOCTYPE html>
<html>
  <head>
    <style>
       /* Set the size of the div element that contains the map */
      #map {
        height: 400px;  /* The height is 400 pixels */
        width: 100%;  /* The width is the width of the web page */
       }
    </style>
  </head>
  <body>
    <h3>On google map</h3>
    <!--The div element for the map -->
    <div id="map"></div>
    <script>
// Initialize and add the map
function initMap() {
  // The location of Uluru
  
  //var uluru = {lat: <?php echo $objProperty->Latitude;  ?>, <?php echo $objProperty->Longitude; ?>};
  var uluru = {lat: 55.901722;  , -3.225768};
  // The map, centered at Uluru
  var map = new google.maps.Map(
      document.getElementById('map'), {zoom: 4, center: uluru});
  // The marker, positioned at Uluru
  var marker = new google.maps.Marker({position: uluru, map: map});
}
    </script>
    <!--Load the API from the specified URL
    * The async attribute allows the browser to render the page while the API loads
    * The key parameter will contain your own API key 
    * The callback parameter executes the initMap() function
    -->
    <script async defer
    src="https://maps.googleapis.com/maps/api/js?key='.$googlemapkey.'&callback=initMap">
    </script>
  </body>
</html>