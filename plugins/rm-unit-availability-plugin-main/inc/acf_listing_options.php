<?php
//Pulls from the ACF Options - Property Listing Tab

function getPropName($property){
    $v = '';
    $propName = '';
    
    if (get_field('propName', 'options')) {
        $v = get_field('propName', 'options');
    }
    
    if (!empty($v)) {
        if ((get_field('propNameType', 'options') !== '') && (get_field('propNameType', 'options') == 'udf') ) {
            if (isset($property->udf->{$v})) {
                $propName = $property->udf->{$v};
            }
        } elseif ((get_field('propNameType', 'options') !== '') && (get_field('propNameType', 'options') == 'system') ) {
            if (isset($property->{$v})) {
                $propName = $property->{$v};
            }
        }
    }
      
    if($propName){ 
        $property->propName = $propName;
        return $propName;
    }
    
    return null;
}

function getFieldOptions($property, $fieldType) {
    $v = '';
    if (get_field($fieldType, 'options')) {
        $v = get_field($fieldType, 'options');
    }

    // Only proceed if we have a valid field name and the property exists
    if (!empty($v) && isset($property->{$v})) {
        $newValue = $property->{$v};
        if($newValue){ 
            return $newValue;
        }
    }
    
    return null;
}

function getBoolOptions($property, $fieldType) {

  if (get_field($fieldType, 'options')) {
      return true;
    }

}

function getLinkOptions($property, $fieldType) {

  if (get_field($fieldType, 'options')) {
     $link = get_field($fieldType, 'options');
      return $link;
    }
     
}

?>