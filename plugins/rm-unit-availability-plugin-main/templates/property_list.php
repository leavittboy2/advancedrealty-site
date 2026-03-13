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
$fallback = get_field('default_listing_image', 'options');
$propertyType = "";
$autoHTML = "<div class=\"rmwb_listings\">";
foreach ($propertyList as $property) {
// echo "<pre>";
// print_r($property);
// echo "</pre>";
  $location = $property->location;
  $mainTitle = getFieldOptions($property, 'propListTitle');
  $subTitle = getFieldOptions($property, 'propListSubTitle');

  if ((getBoolOptions($property, 'propListType'))) {
    $propertyType = $property->propType;
  }

  $rmBtns = "";
  if ((getBoolOptions($property, 'propListMojo'))) {
    $rmBtns .= "<a target=\"_blank\" class=\"bg-color2 bg-color1-hover font2\" href=\"https://showmojo.com/rentmanager/" . $coCode . "/location=" . $location . "/" . $property->propID . "\">Schedule a Showing</a>";
  }

  if ((getBoolOptions($property, 'propListApplyNow'))) {
    $rmBtns .= "<a target=\"_blank\" class=\"bg-color2 bg-color1-hover font2\" href=\"https://" . $coCode . ".twa.rentmanager.com/ApplyNow?locations=" . $location . "&propertyID=" . $property->propID . "\">Apply Now</a>";
  }

  if ((getBoolOptions($property, 'propDetailLink'))) {
    $locationQuery = "&location=".$property->location;
    $rmBtns .= "<a class=\"bg-color2 bg-color1-hover font2\" href=\"" . getLinkOptions($property, 'propDetailPage') . "?pid=" . $property->propID . $locationQuery."\">Details</a>";
  }


  $imagesHTML = "";
  if ($property->images) {
    $imagesHTML .= createSinglePhoto(
        $property,                
        $property->images[0]->url, 
        $fallback,                
        'property listing',        
        null,                     
        null                       
    );
} else {
    $imagesHTML .= createSinglePhoto(
        $property,
        null,
        $fallback,
        'property listing',
        null,
        null
    );
}
  $amenities = implode(",", (array) $property->amenities);
  $autoHTML .= <<<HTML
        <div class="rmwb_listing-wrapper">
        <div class="rmwb_header-section rmwb_section">
            <div class="rmwb_main-header">
                <h2 class="rmwb_listing_header">{$mainTitle} = {$property->location}</h2>
                <h3 class="rmwb_listing_header">{$subTitle}</h3>
            </div>
        </div>
        <div class="rmwb_photo-section rmwb_section">
        {$imagesHTML}
        </div>                
        <div class="rmwb_important-info-section rmwb_section">
         <ul class="rmwb_info-list">
                {$fn(createListItem('Property Type', $propertyType))}
                {$fn(createListItem('Amenities', $amenities))}
            </ul>
        </div>
        <p class="rmwb_description">{$property->description}</p>
        <div class="rmwb_detail-button-wrapper">
          {$rmBtns}
        </div>
        </div>
      HTML;
}
$autoHTML .= "</div>";
print $autoHTML;
return $autoHTML; ?>