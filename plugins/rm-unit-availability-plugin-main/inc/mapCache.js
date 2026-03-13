function geocacher( addrArray ) {

  //Publicly exposed items
  var publicAPI;

  //Stores the results as a dictionary, with the address as the key and an object with lat,lng,and fromdb as the value
  var resultDictionary;

  //Stores if the lookup phase is complete
  var isLookupComplete = false;

  //Stores functions to execute once ready (that the user can provide)
  var readyFunctions = [];

  //Make sure input is good
  try {
    validateInput( addrArray );
  }catch ( e ) {
    console.log( e );
    return;
  }

  //Run the lookup and store it in the dictionary, then set isLookupComplete to true
  getLatLngDictPromise( addrArray, function( result ) {
    return new Promise(
      function( resolve, reject ) {
          resultDictionary = result;
          resolve();
        });
  }).then(function() {
    isLookupComplete = true;
    runReadyFunctions();
  }).catch(function( e ) {
    console.log( e );
  });

  //Validate input
  function validateInput( addrArray ) {
      if ( '[object Array]' != Object.prototype.toString.call( addrArray ) ) {
        throw 'Geocacher must receive an array.';
      }
      for ( var i = 0; i < addrArray.length; i++ ) {
        if ( 'string' != typeof addrArray[i] ) {
          throw 'One or more values in the array is not a string.';
        }
      }
  }

  //Run any queued up functions (i.e. from user)
  function runReadyFunctions() {
    for ( var i = 0; i < readyFunctions.length; i++ ) {
      readyFunctions[i].call( document );
    }
    readyFunctions = [];
  }

  //Runs the lookup of all the addresses
  function getLatLngDictPromise( addressArray, callbackFunction ) {
    return new Promise(
      function( resolve, reject ) {
          jQuery.ajax({
                url: WPURLS.ajaxlocation,
                type: 'post',
                data: {
                    'addresses':addressArray,
                    'action':'getAllGeocodesDict'
                },
                success:function( data ) {
                  var parsedData;
                try {
                  parsedData = JSON.parse( data );
                  if( !parsedData.hasOwnProperty('status') || parsedData.status != 'OK' ){
                    throw "Results not OK." + json_encode(parsedData);
                  }
                } catch ( e ) {
                    reject( 'BAD JSON DECODE: ' + data ); //Error in the above string
                } finally {

                  callbackFunction( parsedData.result ).then(function() {
                      resolve();
                  });
                }
                },
                error: function( e ) {
                    reject( e );
                }
            });
          });
  }

  //Returns an object (with the lat and lng) from the results matching the given address
  function getLatLngFunc( address ) {

    //Make sure the geocoding has been completed
    if ( ! isLookupComplete ) {
      console.log( 'Not ready for lookups yet.' );
      return '';
    }

    //Make sure the results have a match
    if ( ! resultDictionary.hasOwnProperty( address ) ) {
      console.log( 'Address (', address, ') was not successfully geocoded.' );
      return '';
    }
    return resultDictionary[address];
  }

  //Add a function to the ready array (simulating jquery's ready behavior) to run when the addresses are done
  function addReadyFunc( newFunc ) {

    //Make sure we've been given a function
    if ( 'function' != typeof newFunc ) {
      return;
    }

    //Go ahead and run it if we're already done
    if ( isLookupComplete ) {
      newFunc.call( document );
    }else {

      //Otherwise store it in an array
      readyFunctions.push( newFunc );
    }
  }

  publicAPI = {
    getLatLng: getLatLngFunc,
    ready: addReadyFunc
  };

  return publicAPI;

}
