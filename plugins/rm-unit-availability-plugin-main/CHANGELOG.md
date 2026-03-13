# Changelog

## [1.1] - 2025-08-26

### Fixed
- **PHP Warnings in `inc/acf_listing_options.php`**: Implemented defensive programming to eliminate PHP warnings occurring when the `[rm_propertyavailability]` shortcode is used.
- **PHP Warnings in `inc/build/build_property.php`**: Fixed undefined property access for Images objects.
- **PHP Warnings in `templates/unit_list.php`**: Fixed array access and undefined variable issues.

#### Specific Fixes:

**1. `getFieldOptions()` function in `inc/acf_listing_options.php` (line 30)**
- **Issue**: `PHP Warning: Undefined variable $v` and `PHP Warning: Undefined property: Property::$`
- **Root Cause**: Variable `$v` was not initialized when `get_field($fieldType, 'options')` returned a falsy value, causing attempts to access undefined properties
- **Solution**: 
  - Added proper variable initialization (`$v = ''`)
  - Implemented validation checks with `!empty($v) && isset($property->{$v})` before property access
  - Added explicit `return null;` for invalid cases
- **Impact**: Eliminates repeated warnings in error logs when ACF options are not configured

**2. `getPropName()` function in `inc/acf_listing_options.php` (lines 6-20)**
- **Issue**: Same undefined variable and property access warnings
- **Root Cause**: Similar to `getFieldOptions()`, lack of variable initialization and property validation
- **Solution**:
  - Initialize variables (`$v = ''`, `$propName = ''`) at function start
  - Added `!empty($v)` validation before using the variable
  - Implemented `isset()` checks before accessing `$property->udf->{$v}` and `$property->{$v}`
  - Added explicit `return null;` for invalid cases
- **Impact**: Prevents warnings when property name configuration is missing or invalid

**3. Property Images access in `inc/build/build_property.php` (line 61)**
- **Issue**: `PHP Warning: Undefined property: stdClass::$Images`
- **Root Cause**: Attempting to access `$rm_property->Images` without checking if the property exists
- **Solution**:
  - Added `isset($rm_property->Images)` checks before accessing Images property
  - Modified Images class instantiation to handle null input: `New Images(isset($rm_property->Images) ? $rm_property->Images : null)`
- **Impact**: Prevents warnings when property objects don't have Images data

**4. Array and Property access in `templates/unit_list.php` (line 45)**
- **Issue**: `PHP Warning: Trying to access array offset on value of type null` and `PHP Warning: Attempt to read property "url" on null`
- **Root Cause**: Accessing `$unit->images[0]->url` without validating the array exists and has elements
- **Solution**:
  - Added comprehensive validation: `(isset($unit->images) && is_array($unit->images) && !empty($unit->images[0]) && isset($unit->images[0]->url))`
  - Falls back to `$fallback` image when validation fails
- **Impact**: Prevents warnings when units don't have image data

**5. Undefined variable in `templates/unit_list.php` (line 54)**
- **Issue**: `PHP Warning: Undefined variable $availability`
- **Root Cause**: Variable `$availability` was used in HTML data attribute but never defined
- **Solution**:
  - Added `$availability = $dateAvailable;` to define the variable using the existing `$dateAvailable` value
- **Impact**: Eliminates undefined variable warnings in template output

**6. Undefined variable in `templates/unit_detail.php` (line 48)**
- **Issue**: `PHP Warning: Undefined variable $imagesHTML`
- **Root Cause**: Variable `$imagesHTML` was used with concatenation operator `.=` without being initialized first
- **Solution**:
  - Added `$imagesHTML = "";` initialization in the variable declaration section
- **Impact**: Prevents undefined variable warning when building image HTML in unit detail templates

#### Technical Details:
- **Files Modified**: 
  - `inc/acf_listing_options.php`
  - `inc/build/build_property.php`
  - `templates/unit_list.php`
  - `templates/unit_detail.php`
- **Functions Affected**: `getFieldOptions()`, `getPropName()`, Property constructor, Images class instantiation
