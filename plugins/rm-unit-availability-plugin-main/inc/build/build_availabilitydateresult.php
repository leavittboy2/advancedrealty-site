<?php
Class AvailabilityDate{
    public $occupancystatus;
        public $expectedmoveout;
        public $moveout;
        public $noticedate;
        public $nextmovein;
        public $availabilitydateresult;
        public $typerequested = "moveout";
        public $additionaldays = 0;
        public $udfdate = null;
        public $primary = null;
        public $secondary = null;
        public $fallback = "moveout";
        
     

        function __construct($rm_availabilitydate, $udfdate = null, $fallback="moveout", $primary=null, $secondary=null ){
            // Takes options: "noticedate", "expectedmoveout", "moveout", "udf"
            // $primary will be used, if present, otherwise, $secondary will be used, otherwise $fallback, which defaults to moveout.
     
          $this->occupancystatus = $rm_availabilitydate;
            $this->udfdate = $udfdate;
            $availDate = "";
          
          //if blank, set to now
          if(!empty($this->occupancystatus)){
            
     
            foreach($this->occupancystatus as $occupant){

                // If no history, = no date 
                // If there is a current occupant, their dates should be used. 
                // Else, past occupants should be used
                // This assumes one current occupant and that the first found has the correct move out date.
                $occupantdate = "";
                
                $occupantdate = $this->determineDate($occupant);
               /* echo "<br/>availabilitydateresult: ".$occupantdate;
                echo "<br/><br/>";*/
                
                $occupantdate = new DateTime($occupantdate);
               
                if(empty($availDate)){
                    $availDate = $occupantdate; 
                }
                else if($availDate < $occupantdate){
                $availDate = $occupantdate;
                
                }
               /* if($occupant->OccupancyType == "CurrentOccupant"){
                    
      
                   $occupantdate = $this->determineDate($occupant);
                  echo "the occupant date is: ";
                   print_r($occupantdate);
                   break;
                    
                }
                else if($occupant->OccupancyType == "PastOccupant"){

                    $occupantdate = $this->determineDate($occupant);
                    echo "<pre>";
                    
                    echo "</pre>";
                    $this->expectedmoveout = $occupant->ExpectedMoveOutdate;
                    $this->noticedate = $occupant->NoticeDate;
                    $this->moveout = $occpant->EndDate;
                }*/
              }
          }
          else{
            $availDate = "";
          }
          if($availDate != ''){
          $availDate->modify('+1 day');
          $availDate = $availDate->format('m/d/Y');
          $this->availabilitydateresult = $availDate;
          }
        }

        function determineDate($occupant){
            $availabilitydateresult = "";

            
           //print_r($occupant);
            $expectedmoveout =  !empty( $occupant->ExpectedMoveOutDate ) ? $occupant->ExpectedMoveOutDate : '';
            $moveout =  !empty( $occupant->EndDate ) ? $occupant->EndDate : '';
            $noticedate =  !empty( $occupant->NoticeDate ) ? $occupant->NoticeDate : '';

          /*  echo "<pre>";
            echo "expectedmoveout: ".$expectedmoveout;
            echo "<br/>moveout: ".$moveout;
            echo "<br/>noticedate: ".$noticedate;
            
            echo "</pre>";*/

            
        $orders = array($this->{$primary}, $this->{$secondary}, $this->{$fallback});
        $orders = array( 'noticedate', 'expectedmoveout', 'moveout');


        /* To mimic UA settings: 
        Notice Date = array('moveout', 'noticedate');
        Move Out = array('moveout');
        Expected Move Out = array('moveout', 'expectedmoveout');
        */
  
      
        
            foreach ($orders as $order) {
                if (!empty(${$order})) {
                    
                    if(!empty($availabilitydateresult) && ${$order} > $availabilitydateresult){
                        
                        $availabilitydateresult = ${$order};
                        break;
                    }
                    else if(empty($availabilitydateresult)){
                        $availabilitydateresult = ${$order};
                        break;
                        
                    }
                    
                    break;
                }
            }
            if(empty($availabilitydateresult) && !empty($occupant->EndDate)){
                $availabilitydateresult = $occupant->EndDate;

            }
        
        return $availabilitydateresult;






        /*
        if the primary date is not empty
            if the object primary date is not empty
                if primary date > object primary date
                    set object primary date to primary date
                else leave it as is
            else
                set object primary date to primary date
        else (same with secondary)
        else (same with fallback)



            

           



        */


        
        
     

        /*  end */

            /*
            $overridedefault = true;

            // 
            
            if(!empty({$primary})){
                if(!empty($this->{$primary})){
                    if($availabilitydateresult > $this->{$primary}){
                        $this->{$primary} = $availabilitydateresult;
                    }
                }
                else{
                    $
                }
            }
            else if (!empty($this->{$secondary})){
                $availabilitydateresult = $this->{$secondary};
            }
            else if(!empty({
                $availabilitydateresult = $this->{$fallback};
            }

            /// Notice Date
            // Use Move out date, if present
            // otherwise use notice date


            // Expected Move out
            // Use Move out date, if present
            // otherwise, use expected move out date
            */

           



        }
         
         
       
      
      
    
        
}
?>