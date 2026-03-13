<?php
Class SearchFields{
    public $searchFields;
    function __construct(){
        $this->searchFields = array();
    }
    public function addSearchField($fieldName, $fieldDisplayName, $inputType, $numeric = false){
        $searchField = new stdClass();
        $searchField->name = $fieldName;
        $searchField->displayname = $fieldDisplayName;
        $searchField->options = array();
        $searchField->type = $inputType;
        $this->searchFields[]= $searchField;


        
    }
    public function addSearchFieldOptions($fieldName, $option){
        foreach($this->searchFields as $field){
            if($field->name == $fieldName){
                $field->options[] = $option;
            }
        }
        
    }
    public function __get($name) {
        $formattedName = $this->formatName($name);
      
        foreach ($this->searchFields as $item) {
          if ($this->formatName($item->name) === $formattedName ) {
            return $item->value;
          }
        }
        return null;
    }
}
?>