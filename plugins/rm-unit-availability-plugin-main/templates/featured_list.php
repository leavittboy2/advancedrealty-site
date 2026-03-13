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
$autoHTML = "<div class=\"featured-wrapper\">";
foreach ($propertyList as $property) {
    if ($property->udf->isfeatured == "Yes") {
        $location = $property->location;

        $photourl = "";
        $photourl = ($property->images) ? $property->images[0]->url : $fallback;

        $autoHTML .= <<<HTML
        <div class="featured-property">
            <a href="property?pid={$property->propID}">
                <img src="{$photourl}" class="image">
            </a>
            <div class="featured-details">
            <p>{$property->propName}</p>
            <p>{$property->pstreet}</p>
            <p>{$property->csz}</p>
            <a href="property?pid={$property->propID}&location={$property->location}" class="color1 border-color1">View Property</a>
            </div>
        </div>



        HTML;
        
    }

}
$autoHTML .="</div>";
print $autoHTML;
return $autoHTML;