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

if ($property) {
    // echo "<pre>";
    // print_r($property);
    // echo "</pre>";
    $propertyIDList = "";
    $propID = $property->propID;
    $propertyIDList = $propID;
    $mainTitle = getFieldOptions($property, 'propDetailTitle');
    $subTitle = getFieldOptions($property, 'propDetailSubTitle');
    $amenities = "";
    $imagesHTML = "";
    $mapURL = "";
    $managerHTML = "";
    $propTour = "";
    $autoHTML = "";
    $location = $property->location;

    if ((getBoolOptions($property, 'propDetailType'))) {
        $propertyType = $property->propType;
    }

    $rmBtns = "";
    if ((getBoolOptions($property, 'propMojo'))) {
        $rmBtns .= "<a target=\"_blank\" class=\"bg-color2 bg-color1-hover font2\" href=\"https://showmojo.com/rentmanager/" . $coCode . "/location=" . $location . "/" . $property->propID . "\">Schedule a Showing</a>";
    }

    if ((getBoolOptions($property, 'propApplyNow'))) {
        $rmBtns .= "<a target=\"_blank\" class=\"bg-color2 bg-color1-hover font2\" href=\"https://" . $coCode . ".twa.rentmanager.com/ApplyNow?locations=" . $location . "&propertyID=" . $property->propID . "\">Apply Now</a>";
    }


    if (getBoolOptions($property, 'propDetailPhotos')) {
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
        $imagesHTML .= createMultiplePhotos($property->images);

    }
    if ((getBoolOptions($property, 'propDetailAmenities'))) {

        $amenities .= <<<HTML
        <div class="rmwb_amenities-section rmwb_section">
            <h3>Amenities</h3>
            <ul>
            {$fn(splitList($property->amenities))}
            </ul>
        </div>
        HTML;
    }

    if (getBoolOptions($property, 'propDetailMap')) {
        $mapStreet = explode('#', $property->pstreet)[0];
        $mapStreet = urlencode($mapStreet);
        $mapCity = urlencode($property->city);
        $mapState = urlencode($property->state);
        $mapZip = urlencode($property->zip);
        $mapURL = "<iframe src=\"https://maps.google.com/maps?f=q&amp;source=s_q&amp;hl=en&amp;q=" . $mapStreet . ",_" . $mapCity . "," . $mapState . "," . $mapZip . "&amp;ie=UTF8&amp;hq=&amp;hnear=" . $mapStreet . ",_" . $mapCity . "," . $mapState . "," . $mapZip . "&amp;output=embed&amp;z=13\" width=\"100%\" height=\"500\" frameborder=\"0\" style=\"border:0\" allowfullscreen></iframe>";
    }

    if (getBoolOptions($property, 'propDetailManager')) {
        $managerHTML .= <<<HTML
    <div class="rmwb_contact-section rmwb_section rmwb_important-info-section">
        <h3>Manager Information</h3>
        <ul class="rmwb_info-list">
            {$fn(createListItem('Manager', $property->manager))}
            {$fn(createListItem('Phone', $property->phone))}
            {$fn(createListItem('Email', $property->email))} 
        </ul>
    </div>
   HTML;
    }
    if (getBoolOptions($property, 'propDetailTour')) {
        $propTour .= <<<HTML
        <div class="rmwb_video-tour rmwb_section">
            <h3>Video Tour</h3>
            <div class="rmwb_video-wrapper">
                <iframe width="100%" height="500"  src="{$fn(youtubelink($property->tour))}" frameborder="0" allowfullscreen></iframe>
            </div>
        </div>
       HTML;
    }



    $autoHTML .= <<<HTML
        <div class="rmwb_option-2 rmwb_row">
            <div class="rmwb_detail-wrapper">
                <div class="rmwb_header-section rmwb_section">
                    <div class="rmwb_main-header">
                        <h2>{$mainTitle}</h2>
                        <h3>{$subTitle}</h3>
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
                        {$fn(createListItem('Property Type', $propertyType))}
                        {$fn(createListItem('School District', $property->udf->schoolDistrict))} 
                    </ul>
                    <p class="rmwb_description">{$property->udf->description}</p>
                </div> 
                {$managerHTML}
                {$amenities}
            </div>
            {$propTour}
            <div class="rmwb_google-map-detail rmwb_section">
                {$mapURL}
            </div>
        </div>
        HTML;

}

print $autoHTML;

if (getBoolOptions($property, 'propDetailUnits')) {
    $var = '[rm_unitlistproperty propertyidlist="' . $propertyIDList . '"]';

    echo (do_shortcode($var));
}
return $autoHTML; ?>