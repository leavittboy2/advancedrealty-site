<?php



function rmField($fieldName, $propertyorunit){ // Get the field from Rent Manager based on the name of the field
    
    
    if(isset($propertyorunit->$fieldName) && !empty($propertyorunit->$fieldName) && $propertyorunit->$fieldName != ' '){
        return $propertyorunit->$fieldName;  // return the field value
    }
    else if(isset($propertyorunit->additionalFields)){ // check to see if it's a custom field (additionalFields in the json).
            foreach($propertyorunit->additionalFields as $additionalField){
                if($additionalField->fieldName == $fieldName && isset($additionalField->value)){
                    return $additionalField->value; // return the value of the custom field if it matches.
                }
            }
        
    }
}


function validateField($fieldName, $propertyorunit){
    
    
    
    preg_match_all("/(\*\{)\w+(\}\*)/", $fieldName, $uaVariables);
    $returnedText = "";
    
    if(isset($uaVariables[0]) && !empty($uaVariables[0])){
        $newFieldName = $fieldName;
        foreach($uaVariables[0] as $uaVariable){
            
            $variableShortName = str_replace('*{', '', $uaVariable);
            $variableShortName = str_replace('}*', '', $variableShortName);
            
            if(!empty(rmField($variableShortName, $propertyorunit))){
                
                $newFieldName = str_replace($uaVariable, rmField($variableShortName, $propertyorunit), $newFieldName);
            }
            else {$newFieldName = '';}
               
               
        }
        $returnedText .= $newFieldName;
        
    }
       else if(!empty(rmField($fieldName, $propertyorunit))){
            $returnedText .= rmField($fieldName, $propertyorunit);
        
    }
    else{
        $returnedText = $fieldName;
    }
    
    
       return $returnedText;
    
}





function displayField($fieldName, $propertyorunit){
echo validateField($fieldName, $propertyorunit);
}


function splitList($listField){
    $splitAmenities = $listField;
    $amenityHTML = "";
    foreach($splitAmenities as $amenity){
     $amenityHTML .= "<li class=\"border-color1\">";
        $amenityHTML .= addslashes($amenity);
        $amenityHTML .= "</li>";
    }
    return $amenityHTML;
}




function createListItem($fieldName, $fieldValue){
    
    $HTML = "";
    
    if(!empty($fieldValue)){
   
           $HTML .= "<li><span class=\"rmwb_info-title bg-color1 font2\">".addslashes($fieldName)."</span><span class=\"rmwb_info-detail\">".addslashes($fieldValue)."</span></li>";
     }
    return $HTML;

}



function createSinglePhoto(    
    $propertyorunit,
    $imageType = null,
    $fallback = null,
    $galleryName = null,
    $listingType = null,
    $detaillink = null
) {
    if(empty($fallback)){
        $fallback = plugin_dir_url( __FILE__ ) . 'assets/no-image.jpg';
    }
    $photoHTML = "";
    if($galleryName == NULL){
        $galleryName = "image-gallery";
    }
    
    $photoHTML = "<div class=\"rmwb_main-photo\">";
     
    if($imageType != NULL && $imageType != ''){
        
        
         if($listingType == "unit listing"){
            $photoHTML .= "<a ";
                
                if($detaillink){ 
                    $photoHTML .= "href=\"/".$detaillink."/?uid=".rmField('unitid', $propertyorunit)."\"";
                }
               $photoHTML .=  ">";
        }
        else if($listingType == "property listing"){
            
            $photoHTML .= "<a ";
                
                if($detaillink){ 
                    $photoHTML .= "href=\"/".$detaillink."/?pid=".rmField('ppid', $propertyorunit)."\"";
                }
               $photoHTML .=  ">";
            
            
        }
        else{
            
            $photoHTML .= "<a href=\"".addslashes($imageType)."\" data-lightbox=\"image-gallery\">";
        }
        
        
        $photoHTML .= "<img src=\"".addslashes($imageType)."\" alt=\"Unit Image\"/></a>";
     }
    else if($fallback != NULL && $fallback != ''){
        
        
         if($listingType == "unit listing"){
             
              $photoHTML .= "<a ";
                
                if($detaillink){ 
                    $photoHTML .= "href=\"/".$detaillink."/?uid=".rmField('unitid', $propertyorunit)."\"";
                }
               $photoHTML .=  ">";
             
           
        }
        else if($listingType == "property listing"){
             $photoHTML .= "<a ";
                
                if($detaillink){ 
                    $photoHTML .= "href=\"/".$detaillink."/?pid=".rmField('ppid', $propertyorunit)."\"";
                }
               $photoHTML .=  ">";
            
        }
        else{
            
            $photoHTML .= "<a href=\"".addslashes($fallback)."\" data-lightbox=\"image-gallery\">";
        }
        
         $photoHTML .= "<img src=\"".addslashes($fallback)."\" alt=\"Unit Image\"/></a>";
        
     }
    else{
        
        if($listingType == "listing"){
            
             $photoHTML .= "<a ";
                
                if($detaillink){ 
                    $photoHTML .= "href=\"/".$detaillink."/?uid=".rmField('unitid', $propertyorunit)."\"";
                }
               $photoHTML .=  ">";
            
            
        }
        else{
            
            $photoHTML .= "<a  data-lightbox=\"image-gallery\">";
        }
        
         $photoHTML .= "</a>";
       
     }

    $photoHTML .="</div>";
    
    return $photoHTML; 
    
}
function createMultiplePhotos($imageType){
    $photoHTML = "";
    
    //$imageArray = array();
    $photoHTML .= "<div class=\"rmwb_additional-photos\">";
 
        if(isset($imageType) && count($imageType) > 1){
        
            foreach((array_slice($imageType,1)) as $image){

                if($image != ''){

                $photoHTML .= "<div class=\"rmwb_additional-photo\">";
                $photoHTML .= " <a href=\"".addslashes($image->url)."\" data-lightbox=\"image-gallery\"><img src=\"".addslashes($image->url)."\" alt=\"$image->type\"/></a>";
                $photoHTML .= "</div>";

                }
              
            }


        }
    else if(!empty($imageType) && count($imageType) > 1){
        $photoHTML .= "<div class=\"rmwb_additional-photo\">";
        $photoHTML .= " <a href=\"".addslashes($imageType->url)."\" data-lightbox=\"image-gallery\"><img src=\"".addslashes($imageType->url)."\" alt=\"$imageType->type\"/></a>";
        $photoHTML .= "</div>";
        
    }
        $photoHTML .= "</div>";
        
    return $photoHTML;

}
function createCustomAdditionalItems($items){


}
function youtubelink($link){
$finalLink = $link;
    if(strpos($link, 'v=')){
        $finalLink = explode('v=', $link)[1];
        
    }
    else if(strpos($link, 'embed/')){
        $finalLInk = explode('embed/', $link)[1];
    }
    $finalLink = explode('&', $finalLink)[0];
    $finalLink = explode('?', $finalLink)[0];
    
    $finalLink = "https://youtube.com/embed/".addslashes($finalLink)."?rel=0";
    
    return $finalLink;
}


function conditional($option1, $option2){
    if(!empty($option1)){
        return $option1;
    }
    else if(!empty($option2)){
        return $option2;
    }

}


function displayAvailability($date, $availableNowText = NULL, $addDays = NULL){
    
    if($date){
        $availDate = $date;
        if($addDays != NULL && !empty($addDays)){
            $availDate = strtotime($date. ' + '.$addDays.' days');
        }
        else{
        
            $availDate = strtotime($date);
        }
        $todaysDate = date("Y/m/d");
        
        if($todaysDate <= date("Y/m/d", $availDate)){
            return date('m/d/Y', $availDate);
        }
        else{
            if($availableNowText != NULL && !empty($availableNowText)){
               return addslashes($availableNowText); 
            }
            else{
                return "Now";
            }
        }
    }
    else{
        if($availableNowText != NULL && !empty($availableNowText)){
               return $availableNowText; 
            }
            else{
                return "Now";
            }
    }
        
        
    
    
}

function addCommas($field){

    
    
    
    return $field;
    
}

function formatMoney($field){
    
    //use prebuilt php function for this
    return $field;
}


                              ?>