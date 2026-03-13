<?php
// place your html inside the <<<HTML tags. Use $property->[tagname] to get any information out. You can't do functions within <<HTML, so create variables to hold the content beforehand.
// Make sure that you have indentation within the <<<HTML or it will throw an error


// To get a UDF, call $property->udf->udfName - remove all spaces and special characters and use all lowercase. For example, if the UDF name is City-School District? , use cityschooldistrict. 
// (note, this may cause issues if there are two UDFs that are exactly the same once you remove spacing/characters.) In this case you'll want to modify the function formatName under the Marketing class in build_property.php to replace those characters with a different character instead of "".
function fn2($data)
{
  return $data;
}
$fn = 'fn2';

$coCode = get_field('co_code', 'options');
$fallback = get_field('default_detail_image', 'options');
$mainTitle = getFieldOptions($unit, 'unitDetailTitle');
$subTitle = getFieldOptions($unit, 'unitDetailSubTitle');
$mapURL = "";
$propTour = "";
$propDescription = "";
$unitTour = "";
$imagesHTML = ""; // Initialize imagesHTML variable

$autoHTML = "<div class=\"rmwb_option-2 rmwb_row\">";

if ($unit) {
  // print_r($unit);
  $location = $unit->location;

  //For Unit Type images -> $unit->unitTypeImages
  // echo "<pre>";print_r($unit->unitTypeImages);echo "</pre>";

  if ($unit->images) {
    $imagesHTML .= createSinglePhoto(
        $unit,                
        $unit->images[0]->url, 
        $fallback,                
        'unit listing',        
        null,                     
        null                       
    );
} else {
    $imagesHTML .= createSinglePhoto(
        $unit,
        null,
        $fallback,
        'unit listing',
        null,
        null
    );
}
  $imagesHTML .= createMultiplePhotos($unit->images);

  $rmBtns = "";
  if ((getBoolOptions($unit, 'unitDetailMojo'))) {
    $rmBtns .= "<a target=\"_blank\" class=\"bg-color2 bg-color1-hover font2\" href=\"https://showmojo.com/rentmanager/" . $coCode . "/location=" . $location . "/" . $unit->unitID . "\">Schedule a Showing</a>";
  }

  if ((getBoolOptions($unit, 'unitDetailApply'))) {
    $rmBtns .= "<a target=\"_blank\" class=\"bg-color2 bg-color1-hover font2\" href=\"https://" . $coCode . ".twa.rentmanager.com/ApplyNow?locations=" . $location . "&unitID=" . $unit->unitID . "\">Apply Now</a>";
  }

  if ((getBoolOptions($unit, 'unitDetailProp'))) {
    $rmBtns .= "<a class=\"bg-color2 bg-color1-hover font2\" href=\"/Property?pid=" . $unit->propID . "&location=" . $unit->location . "\">View Property</a>";
  }

  if ((getBoolOptions($unit, 'unitDetailPropDesc'))) {
    $propDescription = $unit->property->udf->description;
  }

  if ((getBoolOptions($unit, 'unitDetailPropTour'))) {
    $propTour = youtubelink($unit->property->udf->virtualtour);
  }

  if ((getBoolOptions($unit, 'unitDetailPropTour'))) {
    $unitTour = youtubelink($unit->udf->virtualtour);
  }

  // }
  $daysToAdd = 0;
  $dateAvailable = displayAvailability($unit->availDate, "Now", $daysToAdd);
  $amenities = implode(",", (array) $unit->amenities);

  if (getBoolOptions($unit, 'unitDetailMap')) {
    if (getBoolOptions($unit, 'unitDetailMapProp')) {
      $mapStreet = explode('#', $unit->property->pstreet)[0];
      $mapStreet = urlencode($mapStreet);
      $mapCity = urlencode($unit->property->city);
      $mapState = urlencode($unit->property->state);
      $mapZip = urlencode($unit->property->zip);
    }
  } else {
    $mapStreet = explode('#', $unit->street)[0];
    $mapStreet = urlencode($mapStreet);
    $mapCity = urlencode($unit->city);
    $mapState = urlencode($unit->state);
    $mapZip = urlencode($unit->zip);
  }
  $mapURL = "<iframe src=\"https://maps.google.com/maps?f=q&amp;source=s_q&amp;hl=en&amp;q=" . $mapStreet . ",_" . $mapCity . "," . $mapState . "," . $mapZip . "&amp;ie=UTF8&amp;hq=&amp;hnear=" . $mapStreet . ",_" . $mapCity . "," . $mapState . "," . $mapZip . "&amp;output=embed&amp;z=13\" width=\"100%\" height=\"500\" frameborder=\"0\" style=\"border:0\" allowfullscreen></iframe>";

  $autoHTML .= <<<HTML
            <div class="rmwb_detail-wrapper">
            
                <div class="rmwb_header-section rmwb_section">
                    <div class="rmwb_main-header">
                    <h2>{$unit->street}</h2>
                    <h3>{$unit->csz}</h3>
                    </div>
                    <div class="rmwb_callout-links">
                     {$rmBtns}
                    </div>
                </div>
                <div class="rmwb_photo-section rmwb_section rmwb_primary-photos">
                 {$imagesHTML}
                </div>    
                <div class="rmwb_important-info-section rmwb_section">
                    <ul class="rmwb_info-list">
                    {$fn(createListItem('Available', $dateAvailable))}
                {$fn(createListItem('Rent', $unit->marketrent))}
                {$fn(createListItem('Bedrooms', $unit->bedrooms))}
                {$fn(createListItem('Bathrooms', $unit->bathrooms))}
                {$fn(createListItem('Square Footage', $unit->squarefootage))}
                    </ul>
                    <p class="rmwb_description">{$unit->udf->unitdescription}</p>
                    <p class="rmwb_description">{$propDescription}</p>
                    {$unitTour}
                    {$propTour}
                </div>
                <div class="rmwb_contact-section rmwb_section rmwb_important-info-section">
                    <h3>Manager</h3>
                    <ul class="rmwb_info-list">
                    {$fn(createListItem('Manager', $unit->property->manager))}
                    {$fn(createListItem('Phone', $unit->property->phone))}
                    {$fn(createListItem('Email', $unit->property->email))}    
                    </ul>
                </div>
                <div class="rmwb_amenities-section rmwb_section">
                    <h3>Amenities</h3>
                    <ul>
                    {$fn(splitList($unit->amenities))}
                    </ul>
                </div>
                <div class="rmwb_google-map-detail rmwb_section">
               
                 {$mapURL}
                </div>
        HTML;


}

$autoHTML .= "</div>";


print $autoHTML;

return $autoHTML; ?>