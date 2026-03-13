<?php

class Property {
        public $propID;
        public $propName;
        public $pstreet;
        public $city;
        public $state;
        public $zip;
        public $neighborhood;
        public $csz;
        public $propType;
        public $description;
        public $tour;
        public $manager;
        public $email;
        public $amenities;
        public $mainImage;
        public $images;
        public $udf;
        public $marketing;
        public $location;

        function __construct($rm_property){
     



          $this->propName = $rm_property->Name;
          $this->propID = !empty($rm_property->PropertyID) ? $rm_property->PropertyID : -1;
          $this->propName = !empty( $rm_property->Name ) ? $rm_property->Name : '';
          $this->pstreet = !empty( $rm_property->PrimaryAddress->Street ) ? $rm_property->PrimaryAddress->Street : '';
          $this->city = !empty( $rm_property->PrimaryAddress->City ) ? $rm_property->PrimaryAddress->City : '';
          $this->state = !empty( $rm_property->PrimaryAddress->State ) ? $rm_property->PrimaryAddress->State : '';
          $this->zip  =  !empty( $rm_property->PrimaryAddress->PostalCode ) ? $rm_property->PrimaryAddress->PostalCode : '';
          $this->propType =  !empty( $rm_property->PropertyType ) ? $rm_property->PropertyType : '';
          $this->manager = !empty( $rm_property->ManagerName ) ? $rm_property->ManagerName : '';
          $this->phone = !empty( $rm_property->PhoneNumbers[0]->PhoneNumber ) ? $rm_property->PhoneNumbers[0]->PhoneNumber : '';
          $this->email = !empty( $rm_property->Email ) ? $rm_property->Email : '';
          $this->location = !empty( $rm_property->location) ? $rm_property->location : 'default';

          if (!empty($rm_property->PropertyAmenities)) {
          $amenities = new Amenities($rm_property->PropertyAmenities);
          $this->amenities = $amenities->amenityList;
         }


         if (!empty($rm_property->MarketingValues)) {
          $this->marketing = new Marketing($rm_property->MarketingValues);
         }

         if (!empty($rm_property->UserDefinedValues)) {
          $this->udf = new UserDefined($rm_property->UserDefinedValues);
         }
          
          
      if ((!empty($this->city)) && (!empty($this->state)) && (!empty($this->zip))) {
        $this->csz = $this->city.', '.$this->state.' '.$this->zip;
      }
      $this->mainImage = (isset($rm_property->Images) && !empty($rm_property->Images->File->DownloadURL)) ? $rm_property->Images->File->DownloadURL : '';
      $images = New Images(isset($rm_property->Images) ? $rm_property->Images : null);
      $this->images = $images->images;

    
      
        $propDescription = "";
  
        }
        
        public function getUDF($udf) {
          return $this->udf->{$udf};
        }
}

class Marketing {
  public $marketingValues;

  public function __construct($marketingValues) {
    $this->marketingValues = $marketingValues;
    
  }

  public function __get($name) {
    $formattedName = $this->formatName($name);
 
    foreach ($this->marketingValues as $item) {
      if ($this->formatName($this->formatName($item->Name) === $formattedName)) {
        return $item->Value;
      }
    }
    return null;
    }

  private function formatName($name) {
    $name = str_replace(' ', '', $name);
    return strtolower($name);
  }

}
class UserDefined extends Marketing{
 

}
class Amenities{
  private $amenities;
  public $amenityList = array();
  
  public function __construct($amenities){
    $this->amenities = $amenities;
    
    foreach($amenities as $amenity){ 
      array_push($this->amenityList, $amenity->Amenity->Name);
    }
  }
  


}
class Images{
  public $images;
  public function __construct($images){
    $this->images = array();
    if($images) {
    foreach($images as $image){
      $imageObject = New Image($image);
      $this->images[] = $imageObject;
    }
  }
  }
 
}
class Image{
  public $url;
  public $caption;
  public $description;
  public $type;
  public $imageType; 

  public function __construct($image){
    $this->caption=$image->Caption;
    $this->url = $image->File->DownloadURL;
    $this->description = $image->File->Description;
    $this->type = $image->File->Name;
    $this->imageType = $image->ImageType->Name;
  }


}



class PropertyList {
  
  public $properties;
  public $udffilters = null;
 

  function __construct($udffilters=null) {
   
          
    $this->udffilters = $udffilters;
    
     
    $this->properties = array();
  }
  

  function addProperty($property) {
    $showProperty = false;
   if(!is_null($this->udffilters)){
    foreach($this->udffilters as $udffilter){
      
    
    if($property->udf->{$udffilter->name} == $udffilter->value){
 
      $showProperty = true;
    }
  }
    
   
  }
  else{
    $showProperty = true;
  }
  if($showProperty == true){
    $this->properties[] = $property;
  }
}
}

?>