
$indvListingWrapper = '.rmwb_listing-wrapper';    // Change this to your class name on the individual listing. 
$searchFormWrapper = '#rmwb_search_form'; //change this to the id or class on your search form
function gatherSelectedValues() {
  var selectedValues = {};

  jQuery($searchFormWrapper+' input[type="checkbox"], '+$searchFormWrapper+' select').each(function() {

    var inputName = jQuery(this).attr('name');
    
    
    if (inputName) {
      if (!selectedValues[inputName]) {
        selectedValues[inputName] = [];
      }
      if (jQuery(this).is(':checked')) {
        selectedValues[inputName].push(jQuery(this).val());
      }
      else{
        jQuery(this).find('option').each(function(){
          if(jQuery(this).is(':selected') && jQuery(this).val() != ''){
            selectedValues[inputName].push(jQuery(this).val());
          }
        })
      }
    }
  });
 console.log(selectedValues);

  return selectedValues;
}

function filterListings() {
  jQuery($indvListingWrapper).hide();
  var selectedValues = gatherSelectedValues();
  console.log('selectedvalues', selectedValues);
  jQuery($indvListingWrapper).each(function() {
    var item = jQuery(this);
    var showItem = true;

    Object.keys(selectedValues).forEach(function(inputName) {
      //console.log('selectedvalues' , selectedValues);
      var inputValues = selectedValues[inputName];
   
      var itemValue = item.data(inputName);


   


      if (jQuery('input[name="' + inputName + '"], select[name="' + inputName + '"]').hasClass('numeric-filter')) {
        // Convert input values and item value to numbers for numeric inputs
        inputValues = inputValues.map(function(value) { return parseFloat(value); });
        itemValue = parseFloat(itemValue);
      } 
       /*
       SPECIAL HANDLING FOR PETS
       if (inputName === 'pets') {
        // Handle filtering by words in item value for pets input
        var selectedWords = [];
        var itemWords = [];
        inputValues.forEach(function(value) {
          if (value === 'Cats') {
            selectedWords.push('Cats');
            selectedWords.push('Dogs');
          } else {
            selectedWords.push(value);
          }
        });
        selectedWords.forEach(function(word) {
          if (itemValue.includes(word)) {
            itemWords.push(word);
          }
        });
        if (selectedWords.length > 0 && itemWords.length === 0) {
          showItem = false;
        }
      } else {
        // Handle other inputs
        */

       // console.log(inputValues, itemValue);
        if (inputValues.length > 0 && !inputValues.includes(itemValue)) {
          showItem = false;
        }
        /*
      }*/
    });
    
    //Price
    var minrent = parseFloat(jQuery('#min-rent').val());
    
    var maxrent = parseFloat(String(jQuery('#max-rent').val()));
    if(item.data('rent')){
      //console.log('rent', item.data('rent'));
    var unitrent =  parseFloat(item.data('rent'));
  if(minrent){
    if( unitrent < minrent){
      showItem = false;
      //console.log(minrent,':',unitrent);         
    }    
  }
  if(maxrent){
    if(unitrent > maxrent){
      showItem = false;
    }
  }
}
    if (showItem) {
      item.show();
    }
  });
  ;
}


function getQueryParams() {
  var queryParams = {};
  var queryString = window.location.search.substring(1);
  var pairs = queryString.split("&");
  
  for (var i = 0; i < pairs.length; i++) {
    var pair = pairs[i].split("=");
    var key = decodeURIComponent(pair[0]);
    var value = decodeURIComponent(pair[1]);
    queryParams[key] = value;
  }
  
  return queryParams;
}

// Function to populate the form fields with query parameters
function populateFormFields() {
  var form = document.getElementById("rmwb_search_form");
  
  // Check if the form exists
  if(form){
    var queryParams = getQueryParams();

    for (var key in queryParams) {
      if (queryParams.hasOwnProperty(key)) {
        var input = form.elements[key];
        if (input) {
          input.value = queryParams[key];
        }
      }
    }

  } else {
    console.error("Form with ID 'rmwb_search_form' not found.");
  }
}



   
  jQuery(document).ready(function() {
 



  
    populateFormFields();
  filterListings();
 

    jQuery('#clear_search').click(function(){
      jQuery($searchFormWrapper+' input[type="checkbox"]').prop("checked", false);
      jQuery($indvListingWrapper).show();
      ; 
    })
      jQuery('.update_listings').click(function(e){
        e.preventDefault();
      
       
       filterListings();
      

      });
      jQuery($searchFormWrapper).submit(function(e){
        e.preventDefault();
        filterListings();
      });
    });
