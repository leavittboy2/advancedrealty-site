<?php
// place your html inside the <<<HTML tags. Use $property->[tagname] to get any information out. You can't do functions within <<HTML, so create variables to hold the content beforehand.
// Make sure that you have indentation within the <<<HTML or it will throw an error


// To get a UDF, call $property->udf->udfName - remove all spaces and special characters and use all lowercase. For example, if the UDF name is City-School District? , use cityschooldistrict. 
// (note, this may cause issues if there are two UDFs that are exactly the same once you remove spacing/characters.) In this case you'll want to modify the function formatName under the Marketing class in build_property.php to replace those characters with a different character instead of "".


$coCode = get_field('co_code', 'options');
$fallback = get_field('default_listing_image', 'options');
$unitListTitle = get_field('propDetailUnitTitle', 'options');
$autoHTML = "";

if ($unitListTitle) {
  $autoHTML .= "<section class=\"rmwb_listings-wrapper\"><h2>".$unitListTitle."</h2></section>";
}
$autoHTML .= "<div class=\"rmwb_listings\">";

if($PropUnitList) {
foreach($PropUnitList as $unit){
  $location = $unit->location;
  $mainTitle = getFieldOptions($unit, 'unitListTitle');
  $subTitle = getFieldOptions($unit, 'unitListSubTitle');

  $rent = createListItem('Rent', $unit->marketrent);
  $beds = createListItem('Bedrooms', $unit->bedrooms);
  $baths = createListItem('Bathrooms', $unit->bathrooms);
  $sqft = createListItem('Square Footage', $unit->squarefootage);

 $rmBtns = "";
 if ((getBoolOptions($unit, 'unitListMojo'))) {
  $rmBtns .= "<a target=\"_blank\" class=\"bg-color2 bg-color1-hover font2\" href=\"https://showmojo.com/rentmanager/".$coCode."/location=".$location."/".$unit->unitID."\">Schedule a Showing</a>";
}

 if ((getBoolOptions($unit, 'unitListApply'))) {
  $rmBtns.= "<a target=\"_blank\" class=\"bg-color2 bg-color1-hover font2\" href=\"https://".$coCode.".twa.rentmanager.com/ApplyNow?locations=".$location."&unitID=".$unit->unitID."\">Apply Now</a>";
}

if ((getBoolOptions($unit, 'unitListDetail')))  { 
  $locationQuery = "&location=".$unit->location;
  $rmBtns.= "<a class=\"bg-color2 bg-color1-hover font2\" href=\"".getLinkOptions($unit, 'unitDetailPage')."?uid=".$unit->unitID. $locationQuery."\">Details</a>";
}

  //For Unit Type images -> $unit->unitTypeImages
  // echo "<pre>";print_r($unit->unitTypeImages);echo "</pre>";

  $imagesHTML = "";
  if($unit->images) {
        $imagesHTML .= createSinglePhoto($unit->images[0]->url, $fallback, NULL, 'unit listing', NULL, NULL);
  } else {
    $imagesHTML .= createSinglePhoto($fallback, $fallback, NULL, 'unit listing', NULL, NULL);
  }      
        
   // }
    $daysToAdd = 0;
    $dateAvailable = displayAvailability($unit->availDate, "Now", $daysToAdd);
    $amenities = implode( ",", (array)$unit->amenities);

$autoHTML.=<<<HTML
        <div class="rmwb_listing-wrapper">
        <div class="rmwb_header-section rmwb_section">
            <div class="rmwb_main-header">
                <h2 class="rmwb_listing_header">{$mainTitle}</h2>
                <h3 class="rmwb_listing_header">{$unit->property->propName}</h3>
            </div>
        </div>
        <div class="rmwb_photo-section rmwb_section">
        {$imagesHTML}
        </div>                
         <div class="rmwb_important-info-section rmwb_section">
         <ul class="rmwb_info-list">
              {$rent}
              {$beds}
              {$baths}
              {$sqft}
        </ul>
        </div>
        <p class="rmwb_description">{$unit->udf->unitdescription}</p>
        <div class="rmwb_detail-button-wrapper">
          {$rmBtns}
        </div>
        </div>
      HTML;
}
} else {
    $autoHTML .= "<p>No available units</p>";
}
      $autoHTML.= "</div>";
print $autoHTML;
 return $autoHTML; ?>
  