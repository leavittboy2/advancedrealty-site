<?php
///*  Add functionality to filter only by properties with specific UDFs */

/*
Instructions:
Accepts select or checkboxes for input, and text fields for "min-price" and "max-price" 
The "name" of the select or checkbox should = the name of the data attribute that shows on the unit listing. (ex: if data-bedrooms="", then the name of the select should be "bedrooms"). Don't use typical "eq", "lk" operators. 
If the search field is numeric, such as bedrooms or bathrooms, add the class "numeric-filter" to the select or checkbox. 
*/




/* City */
$cityHTML = "";
if(have_rows('cities', 'options')){
    $cityHTML = "<label for=\"city\">City <select name=\"city\" id=\"city\">";
    $searchFields->addSearchField('cityeq', 'City', 'select');
    while(have_rows('cities', 'options') ) : the_row();
        $cityHTML .="<option value=\"".get_sub_field('city')."\">".get_sub_field('city')."</option>";
        $searchFields->addSearchFieldOptions('cityeq', get_sub_field('city') );
    endwhile;
    $cityHTML .="</select></label>";
    
}
 

$class = ""; //fill from options later




$searchHTML =<<<HTML

        <section class="search-units-section   {$class}">
            <div class="max-wrap search-form ">
                <form id="rmwb_search_form" class="unit-search" action="/unit-availability">            
                    {$cityHTML}
                    <label for="bedrooms">Bedrooms
                        <select class="numeric-filter" name="bedrooms" id="bedrooms">
                        <option value=""></option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        </select>
                    </label>
                    <label for="bathrooms">Bathrooms
                        <select class="numeric-filter" name="bathrooms" id="bathrooms">
                        <option value=""></option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        </select>
                    </label>
                    <label  for="min-rent">Min Rent
                        <input type="text" id="min-rent"/>    
                    </label>
                    <label for="max-rent">Max Rent
                        <input type="text" id="max-rent"/>    
                    </label>
                    <input id="submit_form" style="margin-top:auto;" class="update_listings color1-border bg-color2 bg-color2-hover" type="submit" value="View Availability" >
                </form>
            </div>
        </section>
        


HTML;
echo $searchHTML;


?>