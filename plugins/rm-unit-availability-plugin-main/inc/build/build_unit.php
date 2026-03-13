<?php

class Unit {
        public $unitID;
        public $unitName;
        public $unitType;
        public $street;
        public $city;
        public $state;
        public $zip;
        public $bedrooms;
        public $bathrooms;
        public $marketrent;
        public $squarefootage;
        public $availDate;
        public $amenities;
        public $mainImage;
        public $images;
        public $unitTypeImages;
        public $udf;
        public $marketing;
        public $property;
        public $emoDate;
        public $location;


        function __construct($rm_unit){
     
          $this->unitID = !empty($rm_unit->UnitID) ? $rm_unit->UnitID : -1;
          $this->unitName = !empty( $rm_unit->Name ) ? $rm_unit->Name : '';
          $this->propID = !empty( $rm_unit->PropertyID ) ? $rm_unit->PropertyID : '';
          $this->unitType =  !empty( $rm_unit->UnitType->Name ) ? $rm_unit->UnitType->Name : '';
          $this->street = !empty( $rm_unit->PrimaryAddress->Street ) ? $rm_unit->PrimaryAddress->Street : '';
          $this->city = !empty( $rm_unit->PrimaryAddress->City ) ? $rm_unit->PrimaryAddress->City : '';
          $this->state = !empty( $rm_unit->PrimaryAddress->State ) ? $rm_unit->PrimaryAddress->State : '';
          $this->zip  =  !empty( $rm_unit->PrimaryAddress->PostalCode ) ? $rm_unit->PrimaryAddress->PostalCode : '';
          $this->bedrooms =!empty( $rm_unit->Bedrooms ) ? $rm_unit->Bedrooms : '';
          $this->bathrooms =!empty( $rm_unit->Bathrooms ) ? $rm_unit->Bathrooms : '';
          $this->squarefootage =!empty( $rm_unit->SquareFootage ) ? $rm_unit->SquareFootage : '';
          $this->emoDate =!empty( $rm_unit->CurrentOccupancyStatus->ExpectedMoveOutDate ) ? $rm_unit->CurrentOccupancyStatus->ExpectedMoveOutDate : '';
           $this->location = !empty( $rm_unit->location) ? $rm_unit->location : 'default';
          if (!empty($rm_unit->UnitAmenities)) {
          $amenities = new Amenities($rm_unit->UnitAmenities);
          $this->amenities = $amenities->amenityList;
          }
          $unitproperty = new Property($rm_unit->Property);
          $this->property = $unitproperty;

          if (!empty($rm_unit->MarketingValues)) {
          $this->marketing = new Marketing($rm_unit->MarketingValues);
          }
          if (!empty($rm_unit->UserDefinedValues)) {
            $this->udf = new UserDefined($rm_unit->UserDefinedValues);
            }
         
          $this->availDate = !empty( $rm_unit->CurrentOccupancyStatus->EndDate ) ? $rm_unit->CurrentOccupancyStatus->EndDate : '';
          $this->marketrent = !empty( $rm_unit->CurrentMarketRent->Amount ) ? $rm_unit->CurrentMarketRent->Amount : '';
          
      if ((!empty($this->city)) && (!empty($this->state)) && (!empty($this->zip))) {
        $this->csz = $this->city.', '.$this->state.' '.$this->zip;
      }
      $this->mainImage = !empty($rm_unit->Images->File->DownloadURL ) ? $rm_unit->Images->File->DownloadURL : '';
      if (!empty($rm_unit->Images)) {
      $images = New Images($rm_unit->Images);
      $this->images = $images->images;
      }
      if (!empty($rm_unit->UnitType->Images)) {
        $unitTypeImages = New Images($rm_unit->UnitType->Images);
        $this->unitTypeImages = $unitTypeImages->images;
      }
      

    
        }

}




class UnitList {
  
  public $units;

  function __construct() {
     
    $this->units = array();
  }
  

  function addUnit($unit) {
   
    $this->units[] = $unit;
  }
}

?>