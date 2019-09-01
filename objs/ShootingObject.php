<?php 

    include_once("ParserHelper.php");
    
    class ShootingObject{
        
    
        var $ShootingID;
        var $TimeStamp;
        var $DistrictNumber;
        var $Year;
        var $CrimeTime;
        var $DCNumber;
        var $CrimeDate;
        var $Race;
        var $Gender;
        var $Age;
        var $Wound;
        var $isOfficerInvolved;
        var $isOffenderInjured;
        var $isOffenderDeceased;
        var $LocationAddress;
        var $LocationX;
        var $LocationY;
        var $isInside;
        var $isOutside;
        var $isFatal;
    
        function getAPI_Info($d_url){
            $utils = new ParserHelper();
            $curl = curl_init($d_url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
            $curl_response = curl_exec($curl);
            $utils->writeToLog("DATA RETURNED ".$curl_response);
            curl_close($curl);
            
            return json_decode($curl_response, true);
            
        }
        
        
        function getAnotherShooting($districtNumber,$shootingDate,$totalCount,$currentCount){
           
            date_default_timezone_set('US/Eastern');
            $utils = new ParserHelper();
            
            $totalCount = $totalCount - 1;
            
            if($districtNumber !== 0){
               
                $SHOOT_URL = 'https://phl.carto.com/api/v2/sql?q=SELECT%20*%20FROM%20shootings%20WHERE%20dist%20%3D%20%27'.$districtNumber.'%27%20AND%20date_%3A%3Atext%20LIKE%20%27'.$shootingDate.'%27%20ORDER%20BY%20date_%20DESC%20NULLS%20LAST%20LIMIT%20'.$currentCount.'%20OFFSET%20'.$totalCount;
                $data_array = ShootingObject::getAPI_Info($SHOOT_URL);
                $txt = $utils->fetchShootArray($data_array['rows']);
                $utils->writeToLog("WITH D ".$SHOOT_URL);
                
            }else{
                
                $SHOOT_URL = 'https://phl.carto.com/api/v2/sql?q=SELECT%20%2A%20FROM%20shootings%20WHERE%20date_%3A%3Atext%20LIKE%20%27'.$shootingDate.'%27%20ORDER%20%20BY%20date_%20DESC%20NULLS%20LAST%20LIMIT%20'.$currentCount.'%20OFFSET%20'.$totalCount;
                $data_array = ShootingObject::getAPI_Info($SHOOT_URL);
                $txt = $utils->fetchShootArray($data_array['rows']);
                
                $utils->writeToLog("WITHOUT D ".$SHOOT_URL);
            }
            
            if($totalCount == 0){
                return json_encode(array("version"=>"1.0","sessionAttributes"=>array("presentTime"=>"today","shooting"=>"true","crimeType"=>"shootings","districtNumber"=>$districtNumber,"currentCount"=>1,"totalCount"=>$totalCount,"shootingDate"=>$shootingDate),"response"=>array("outputSpeech"=>array("type"=>"SSML","ssml"=>"<speak>NO more shootings</speak>"),"reprompt"=>null,"shouldEndSession"=>false)));
                
            }else{
                return json_encode(array("version"=>"1.0","sessionAttributes"=>array("presentTime"=>"today","shooting"=>"true","crimeType"=>"shootings","districtNumber"=>$districtNumber,"currentCount"=>1,"totalCount"=>$totalCount,"shootingDate"=>$shootingDate),"response"=>array("outputSpeech"=>array("type"=>"SSML","ssml"=>$txt),"reprompt"=>null,"shouldEndSession"=>false)));
                
            }
            
            
            
            
            
            
        }
        
    
        function getTodayShootings($districtNumber){
            
            date_default_timezone_set('US/Eastern');
            $utils = new ParserHelper();
            
            if($districtNumber !== 0){
                $SHOOT_URL = 'https://phl.carto.com/api/v2/sql?q=SELECT%20date_%20FROM%20shootings%20WHERE%20dist%20%3D%20%27'.$districtNumber.'%27%20ORDER%20%20BY%20date_%20DESC%20NULLS%20LAST%20LIMIT%20%201';
                
            }else{
                
                $SHOOT_URL = 'https://phl.carto.com/api/v2/sql?q=SELECT%20date_%20FROM%20shootings%20ORDER%20%20BY%20date_%20DESC%20NULLS%20LAST%20LIMIT%20%201';
                
            }
            
            $utils->writeToLog("GOING TO ".$SHOOT_URL);
            $data_array = ShootingObject::getAPI_Info($SHOOT_URL);
            $dDate = $data_array['rows'][0]['date_'];
            $ex1 = explode("T", $dDate);
            $last_date = $ex1[0];
            
            if($districtNumber !== 0){
                $SHOOT_URL1 = 'https://phl.carto.com/api/v2/sql?q=SELECT%20COUNT%28%2A%29%20AS%20COUNT%20FROM%20shootings%20WHERE%20dist%20%3D%20%27'.$districtNumber.'%27%20AND%20date_%3A%3Atext%20LIKE%20%27'.$last_date.'%27';
                $dd_array = ShootingObject::getAPI_Info($SHOOT_URL1);
                $row_count = $dd_array['rows'][0]['count'];
                $utils->writeToLog("WITH OUT ".$SHOOT_URL1);
                
            }else{
                
                $SHOOT_URL1 = 'https://phl.carto.com/api/v2/sql?q=SELECT%20COUNT%28%2A%29%20AS%20COUNT%20FROM%20shootings%20WHERE%20date_%3A%3Atext%20LIKE%20%27'.$last_date.'%27';
                $dd_array = ShootingObject::getAPI_Info($SHOOT_URL1);
                $row_count = $dd_array['rows'][0]['count'];
                $utils->writeToLog("WITH OUT ".$SHOOT_URL1);
            }
            
            
            $today_date = date('Y-m-d');
            $x_ago = $utils->dateDifference($last_date, $today_date,"%d days");
            
            $old_date = date($last_date);
            $old_date_timestamp = strtotime($old_date);
            $daa = date('l F jS', $old_date_timestamp);
            
            if($x_ago == "0 days"){
                $x_ago = "today,";
            }
            else if($x_ago == "1 days"){
                $x_ago = "yesterday";
            }
            else{
                $x_ago = $x_ago." ago,";
                
            }
            
            
            if($row_count == 1){
                
                
                    /// IF ONE SHOOTING AND ONE DAY AGO
                    if($districtNumber !== 0){
                        $txxt = '<speak><p>In the '.$utils->addTH($districtNumber).' police district, There are no reported shootings today at this time.</p><p>However, there was '.$row_count.' shooting '.$x_ago.' '.$daa.'</p><p>Would you like to hear the details</p></speak>';
                        
                    }else{
                        $txxt = '<speak><p>There are no reported shootings today at this time.</p><p>However, there was '.$row_count.' shooting '.$x_ago.' '.$daa.'</p><p>Would you like to hear the details</p></speak>';
                        
                    }
                    
                
            }else{
                
                //// IF ONE SHOOTING OTHER THEN YESTERDAY
                if($districtNumber !== 0){
                    $txxt = '<speak><p>In the '.$utils->addTH($districtNumber).' police district, there are no shootings to report today at this time.</p><p> However, there were '.$row_count.' shootings '.$x_ago.' '.$daa.'</p><p> Would you like to hear the details?</p></speak>';
                    
                }else{
                    $txxt = '<speak><p>I do not have any shootings to report today.</p><p> However, there were '.$row_count.' shootings '.$x_ago.' '.$daa.'</p><p> Would you like to hear the details?</p></speak>';
                    
                }
                
                
            }
            
            $txt = array("version"=>"1.0","sessionAttributes"=>array("presentTime"=>"today","shooting"=>"true","crimeType"=>"shootings","districtNumber"=>$districtNumber,"currentCount"=>1,"totalCount"=>$row_count,"shootingDate"=>$last_date),"response"=>array("outputSpeech"=>array("type"=>"SSML","ssml"=>$txxt),"reprompt"=>null,"shouldEndSession"=>false));
            
            return json_encode($txt);
            
            
        }
    
    function setShootingID($ShootingID) { $this->ShootingID = $ShootingID; }
    function getShootingID() { return $this->ShootingID; }
    function setTimeStamp($TimeStamp) { $this->TimeStamp = $TimeStamp; }
    function getTimeStamp() { return $this->TimeStamp; }
    function setDistrictNumber($DistrictNumber) { $this->DistrictNumber = $DistrictNumber; }
    function getDistrictNumber() { return $this->DistrictNumber; }
    function setYear($Year) { $this->Year = $Year; }
    function getYear() { return $this->Year; }
    function setCrimeTime($CrimeTime) { $this->CrimeTime = $CrimeTime; }
    function getCrimeTime() { return $this->CrimeTime; }
    function setDCNumber($DCNumber) { $this->DCNumber = $DCNumber; }
    function getDCNumber() { return $this->DCNumber; }
    function setCrimeDate($CrimeDate) { $this->CrimeDate = $CrimeDate; }
    function getCrimeDate() { return $this->CrimeDate; }
    function setRace($Race) { $this->Race = $Race; }
    function getRace() { return $this->Race; }
    function setGender($Gender) { $this->Gender = $Gender; }
    function getGender() { return $this->Gender; }
    function setAge($Age) { $this->Age = $Age; }
    function getAge() { return $this->Age; }
    function setWound($Wound) { $this->Wound = $Wound; }
    function getWound() { return $this->Wound; }
    function setIsOfficerInvolved($isOfficerInvolved) { $this->isOfficerInvolved = $isOfficerInvolved; }
    function getIsOfficerInvolved() { return $this->isOfficerInvolved; }
    function setIsOffenderInjured($isOffenderInjured) { $this->isOffenderInjured = $isOffenderInjured; }
    function getIsOffenderInjured() { return $this->isOffenderInjured; }
    function setIsOffenderDeceased($isOffenderDeceased) { $this->isOffenderDeceased = $isOffenderDeceased; }
    function getIsOffenderDeceased() { return $this->isOffenderDeceased; }
    function setLocationAddress($LocationAddress) { $this->LocationAddress = $LocationAddress; }
    function getLocationAddress() { return $this->LocationAddress; }
    function setLocationX($LocationX) { $this->LocationX = $LocationX; }
    function getLocationX() { return $this->LocationX; }
    function setLocationY($LocationY) { $this->LocationY = $LocationY; }
    function getLocationY() { return $this->LocationY; }
    function setIsInside($isInside) { $this->isInside = $isInside; }
    function getIsInside() { return $this->isInside; }
    function setIsOutside($isOutside) { $this->isOutside = $isOutside; }
    function getIsOutside() { return $this->isOutside; }
    function setIsFatal($isFatal) { $this->isFatal = $isFatal; }
    function getIsFatal() { return $this->isFatal; }
    
    
    
    }





?>
