<?php


class Property
{


	public $ID;
	public $County;
	public $Country;
	public $Town;
	public $Description;
	public $DetailsUrl;
	public $Address;
	public $ImageUrl;
	public $ImageCaption;
	public $Latitude;
	public $Longitude;
	public $NumBedrooms;
	public $NumBathrooms;
	public $Price;
	public $PropertyType;
	public $Status;
	public $FromApi;


        public function __construct(&$Conn) {
		$this->Conn = $Conn;
		$this->Clear();
	}


	public function Clear() {
		$this->ID = "";
		$this->County = "";
		$this->Country = "";
		$this->Town = "";
		$this->Description = "";
		$this->DetailsUrl = "";
		$this->Address = "";
		$this->ImageUrl = "";
		$this->ImageCaption = "";
		$this->Latitude = "";
		$this->Longitude = "";
		$this->NumBedrooms = "";
		$this->NumBathrooms = "";
		$this->Price = "";
		$this->PropertyType = "";
		$this->Status = "";
		$this->FromApi = "";
		$this->Error = false;
	}


	public function GetByID($strCode) {
		$sql =  "SELECT ";
		$sql .= "* ";
		$sql .= "FROM properties ";
		$sql .= "WHERE (id='" . mysqli_real_escape_string($this->Conn, $strCode) . "') ";
		$this->GetRecord($sql);
	}
	
	

        private function GetRecord($sql) {
		$this->Clear();

		$objRS = mysqli_query($this->Conn, $sql);
		if (mysqli_num_rows($objRS) == 1) {
			$arrRS = mysqli_fetch_assoc($objRS);
			$this->ID = $arrRS["id"];
			$this->County = $arrRS["country"];
			$this->Country = $arrRS["county"];
			$this->Town = $arrRS["town"];
			$this->Description = $arrRS["description"];
			$this->DetailsUrl = $arrRS["details_url"];
			$this->Address = $arrRS["address"];
			$this->ImageUrl = $arrRS["image_url"];
			$this->ImageCaption = $arrRS["image_caption"];
			$this->Latitude = $arrRS["latitude"];
			$this->Longitude = $arrRS["longitude"];
			$this->NumBedrooms = $arrRS["num_bedrooms"];
			$this->NumBathrooms = $arrRS["num_bathrooms"];
			$this->Price = $arrRS["price"];
			$this->PropertyType = $arrRS["property_type"];
			$this->Status = $arrRS["status"];
			$this->FromApi = $arrRS["from_api"];
			$this->Error = false;
		} else {
			$this->Error = true;
		}
		mysqli_free_result($objRS);
	}


	public function Insert() {
	
		$sql  = "INSERT INTO properties ( ";
		//$sql .= "id, ";
		$sql .= "country, ";
		$sql .= "county, ";
		$sql .= "town, ";
		$sql .= "description, ";
		$sql .= "details_url, ";
		$sql .= "address, ";
		$sql .= "image_url, ";
		$sql .= "image_caption, ";
		$sql .= "latitude, ";
		$sql .= "longitude, ";
		$sql .= "num_bedrooms, ";
		$sql .= "num_bathrooms, ";
		$sql .= "price, ";
		$sql .= "property_type, ";
		$sql .= "status, ";
		$sql .= "from_api ";
		$sql .= ")VALUES ( ";
		//$sql .= "'" . mysqli_real_escape_string($this->Conn, $this->ID) . "', ";
		$sql .= "'" . mysqli_real_escape_string($this->Conn, $this->Country) . "', ";
		$sql .= "'" . mysqli_real_escape_string($this->Conn, $this->County) . "', ";
		$sql .= "'" . mysqli_real_escape_string($this->Conn, $this->Town) . "', ";
		$sql .= "'" . mysqli_real_escape_string($this->Conn, $this->Description) . "', ";
		$sql .= "'" . mysqli_real_escape_string($this->Conn, $this->DetailsUrl) . "', ";
		$sql .= "'" . mysqli_real_escape_string($this->Conn, $this->Address) . "', ";
		$sql .= "'" . mysqli_real_escape_string($this->Conn, $this->ImageUrl) . "', ";
		$sql .= "'" . mysqli_real_escape_string($this->Conn, $this->ImageCaption) . "', ";
		$sql .= "'" . mysqli_real_escape_string($this->Conn, $this->Latitude) . "', ";
		$sql .= "'" . mysqli_real_escape_string($this->Conn, $this->Longitude) . "', ";
		$sql .= "'" . mysqli_real_escape_string($this->Conn, $this->NumBedrooms) . "', ";
		$sql .= "'" . mysqli_real_escape_string($this->Conn, $this->NumBathrooms) . "', ";
		$sql .= "'" . mysqli_real_escape_string($this->Conn, $this->Price) . "', ";
		$sql .= "'" . mysqli_real_escape_string($this->Conn, $this->PropertyType) . "', ";
		$sql .= "'" . mysqli_real_escape_string($this->Conn, $this->Status) . "', ";
		$sql .= "'" . mysqli_real_escape_string($this->Conn, $this->FromApi) . "' ";
		
		$sql .= ") ";
		$resResult = mysqli_query($this->Conn, $sql);

	}


	public function Update() {
		$sql  = "UPDATE properties SET ";
		$sql .= "country='" . mysqli_real_escape_string($this->Conn, $this->Country) . "', ";
		$sql .= "county='" . mysqli_real_escape_string($this->Conn, $this->County) . "', ";
		$sql .= "town='" . mysqli_real_escape_string($this->Conn, $this->Town) . "', ";
		$sql .= "description='" . mysqli_real_escape_string($this->Conn, $this->Description) . "', ";
		$sql .= "details_url='" . mysqli_real_escape_string($this->Conn, $this->DetailsUrl) . "', ";
		$sql .= "address='" . mysqli_real_escape_string($this->Conn, $this->Address) . "', ";
		$sql .= "image_url='" . mysqli_real_escape_string($this->Conn, $this->ImageUrl) . "', ";
		$sql .= "image_caption='" . mysqli_real_escape_string($this->Conn, $this->ImageCaption) . "', ";
		$sql .= "latitude='" . mysqli_real_escape_string($this->Conn, $this->Latitude) . "', ";
		$sql .= "longitude='" . mysqli_real_escape_string($this->Conn, $this->Longitude) . "', ";
		$sql .= "num_bedrooms='" . mysqli_real_escape_string($this->Conn, $this->NumBedrooms) . "', ";
		$sql .= "num_bathrooms='" . mysqli_real_escape_string($this->Conn, $this->NumBathrooms) . "', ";
		$sql .= "price='" . mysqli_real_escape_string($this->Conn, $this->Price) . "', ";
		$sql .= "property_type='" . mysqli_real_escape_string($this->Conn, $this->PropertyType) . "', ";
		$sql .= "status='" . mysqli_real_escape_string($this->Conn, $this->Status) . "', ";
		$sql .= "from_api='" . mysqli_real_escape_string($this->Conn, $this->FromApi) . "' ";
		$sql .= "WHERE latitude='" . mysqli_real_escape_string($this->Conn, $this->Latitude) . "' ";
		$resResult = mysqli_query($this->Conn, $sql);

	}


	public function Delete() {
		$sql = "DELETE FROM properties WHERE id='" . mysqli_real_escape_string($this->Conn, $this->ID) . "' ";
		$resResult = mysqli_query($this->Conn, $sql);
		$this->Clear();
	}


	public function DeleteAllApi() {
	
		$sql = "DELETE FROM properties WHERE from_api=1 ";
		$resResult = mysqli_query($this->Conn, $sql);
		$this->Clear();
	}

	public function CountAll() {
		$total = 0;
		$sql = "SELECT COUNT(*) AS total FROM properties ";
		$resRS = mysqli_query($this->Conn, $sql);
		if ($resRS) {
			if (mysqli_num_rows($resRS) == 1) {
				$arrRS = mysqli_fetch_assoc($resRS);
				$total = $arrRS["total"];
			}
			mysqli_free_result($resRS);
		}
		return $total;
	}


        public function renderHtmlImg() {
            $img_src    = 'uploads/' . $this->ID . '.jpeg';
            $img_srcset = 'uploads/' . $this->ID . '-@2x.jpeg 2x';

            // no image:
            if ( !file_exists($img_src) ) {
                $sl_color = strtolower($this->Color);
                $sl_type  = strtolower($this->Type);

                $img_src    = 'img/'.$sl_type.'-'.$sl_color.'.png';
                $img_srcset = 'img/'.$sl_type.'-'.$sl_color.'-@2x.png 2x';
            }
            ?><img onerror="noImgOnCard(this)" srcset="<?php echo $img_srcset ?>" src="<?php echo $img_src ?>"/><?php
        }

        /**
         * @return array
         */
        
} # END OF CLASS


# EOF
