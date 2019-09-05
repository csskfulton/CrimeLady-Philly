<?php
 
    require_once("objs/CrimeObject.php");
    require_once("objs/NewsObject.php");
    require_once("objs/ShootingObject.php");
    require_once("objs/ErrorObject.php");

      
   
 ////////////////////////////////////////////////////////////////////////////////// START FUNCTIONS
    ////////////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////

  
            
            function numtoD($dist){
                $secc = $dist;
                
                if($dist == "25"){
                    $secc = "twenty fifth";
                }
                if($dist == "24"){
                    $secc = "twenty fourth";
                }
                if($dist == "26"){
                    $secc = "twenty sixth";
                }
                if($dist == "39"){
                    $secc = "thirty ninth";
                }
                if($dist == "35"){
                    $secc = "thirty fifth";
                }
                if($dist == "14"){
                    $secc = "fourteenth";
                }
                if($dist == "15"){
                    $secc = "fifteenth";
                }
                if($dist == "9"){
                    $secc = "ninth.";
                }
                if($dist == "22"){
                    $secc = "twenty second";
                }
                if($dist == "19"){
                    $secc = "nineteenth.";
                }
                if($dist == "18"){
                    $secc = "eighteenth";
                }
                if($dist == "16"){
                    $secc = "sixteenth";
                }
                if($dist == "5"){
                    $secc = "fifth";
                }
                if($dist == "6"){
                    $secc = "sixth";
                }
                if($dist == "2"){
                    $secc = "second";
                }
                if($dist == "7"){
                    $secc = "seventh";
                }
                if($dist == "8"){
                    $secc = "eighth";
                }
                
                return $secc;
                
            }
    
            

    
    function genString($tty){
        
        if(strpos($tty, "Robbery")>=1){
            return "Robbery";
        }
        if(strpos($tty, "Burglary")){
            return "Burglary";
        }
        if(strpos($tty, "Theft")){
            return "Theft";
        }
        if(strpos($tty, "Shooting")){
            return "Shooting";
        }
        if(strpos($tty, "Assault")){
            return "Assault";
        }
        if(strpos($tty, "Robberies")){
            return "Robberies";
        }
        if(strpos($tty, "Burglaries")){
            return "Burglary";
        }
        if(strpos($tty, "Sexual Assault")){
            return "Sexual Assault";
        }
        if(strpos($tty, "Counterfeiting")){
            return "Fraud";
        }
        if(strpos($tty, "Aggravated Assault")){
            return "Assault";
        }
        if(strpos($tty, "Fraud")){
            return "Fraud";
        }
        if(strpos($tty, "Vandalism")){
            return "Vandalism";
        }
        
        
        return $tty;
    }
    
       
    
    
    ////////////////////////////////////////////////////////////////////////////////// END FUNCTIONS
    ////////////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////
    
    
 ////////////////////////////////////////// APPLICATION LAUNCH POINT ///////////////////////////////////////////////////////////////////////////   

    
    
//////////////////////////////////////////////////////////// LAUNCH REQUEST ///////////////////////////////////////////////////////////////////////////    
  
    function writeToLog($var){
        file_put_contents('test.txt', $var."\n",FILE_APPEND);
    }
 
    
        $data = json_decode(file_get_contents('php://input'),true);
        $rot = file_get_contents('php://input');
        writeToLog($rot);
    
        $itReq = $data['request']['type'];
         $itNam = $data['request']['intent']['name'];
//         $itDis = $data['request']['dialogState'];
    
    
        if($itReq == "LaunchRequest"){
            
            
            
            $pw ='  <speak>                     
                    <s>Hello!</s>
                    <s>I am the Crime Lady!</s>
                    <s>How can I help you?</s>
                    </speak>
                ';
            
            $response = array("version"=>"1.0","response"=>
                            array("outputSpeech"=>
                                array("type"=>"SSML","text"=>$pw,"ssml"=>$pw),"shouldEndSession"=>false,"reprompt"=>
                                    array("outputSpeech"=>
                                        array("type"=>"SSML","ssml"=>"<speak>sooo?<s>your not going to say anything?</s></speak>")),"sessionAttributes"=>""));
            
            
            
            
            
            echo json_encode($response);
                  
             
            
        }
    
//////////////////////////////////////////////////////////// END LAUNCH REQUEST ///////////////////////////////////////////////////////////
    
    //this shit dont work 
//////////////////////////////////////////////////////////// START ERROR STUFF  /////////////////////////////////////////////////////////
        if($itReq == "SessionEndedRequest"){
            
            $pw ='  <speak>
                    <s>Bye Boy!</s>
                    </speak>
                ';
            
            $response = array("version"=>"1.0","response"=>
                array("outputSpeech"=>
                    array("type"=>"SSML","ssml"=>$pw),"shouldEndSession"=>true,"reprompt"=>
                    array("outputSpeech"=>
                        array("type"=>"SSML","ssml"=>"<speak>sooo?<s>your not going to say anything?</s></speak>")),"sessionAttributes"=>""));
            
            
            
            
            
            echo json_encode($response);
        }
        
        
//////////////////////////////////////////////////////////// END ERROR STUFF  /////////////////////////////////////////////////////////
        
        
        
//////////////////////////////////////////////////////////// INTENT fetchStatus //////////////////////////////////////////

    if($itReq == "IntentRequest" && $itNam == "districtNews"){ /// DISTRICT NEWS INTENT
            
        $newsTypeCode = $data['request']['intent']['slots']['newsType']['resolutions']['resolutionsPerAuthority'][0]['status']['code'];
        $newsTypeValue = $data['request']['intent']['slots']['newsType']['resolutions']['resolutionsPerAuthority'][0]['values'][0]['value']['name'];
        $naviValue = $data['request']['intent']['slots']['navigation']['resolutions']['resolutionsPerAuthority'][0]['values'][0]['value']['name'];
        $naviCode = $data['request']['intent']['slots']['navigation']['resolutions']['resolutionsPerAuthority'][0]['status']['code'];
        $presentTimeCode = $data['request']['intent']['slots']['presentTime']['resolutions']['resolutionsPerAuthority'][0]['status']['code'];
        $presentTimeValue = $data['request']['intent']['slots']['presentTime']['resolutions']['resolutionsPerAuthority'][0]['values'][0]['value']['name'];
        $districtNumberValue = $data['request']['intent']['slots']['districtNums']['resolutions']['resolutionsPerAuthority'][0]['values'][0]['value']['name'];
        $districtNumberCode = $data['request']['intent']['slots']['districtNums']['resolutions']['resolutionsPerAuthority'][0]['status']['code'];
        
        if($naviCode == "ER_SUCCESS_MATCH"){
            
            $pre = $data['session']['attributes'];
            $isDistrictNews = $pre['districtNews'];
            $totalCount = $pre['totalCount'];
            $currentCount = $pre['currentCount'];
            $hash = $pre['Hash'];
            $readCount = $pre['readCount'];
            $districtNumber = $pre['districtNumber'];
            $pubDate = $pre['pubDate'];
            
            switch($naviValue){
                
                case "repeat":
                    //STUFF
                    writeToLog("PLEASE REPEAT");
                    
                    if($isDistrictNews == true){
                        $totalCount = $totalCount + 1;
                        $readCount = $readCount - 1;
                        if($districtNumber == 0){
                            
                            echo NewsObject::getAnotherStory($districtNumber,$totalCount,$currentCount,$readCount,$hash,$pubDate);
                            
                        }else{
                            
                            echo NewsObject::getAnotherStory($districtNumber,$totalCount,$currentCount,$readCount,0,$pubDate);
                            
                        }
                        
                    }else{
                        
                    }
                    
                    
                    
                    break;
                
                case "next":
                   //STUFF
                   writeToLog("NEXT PLEASE!");
                   
                    if($totalCount == 0){
                        // NO MORE STORIES LEFT
                        if($isDistrictNews == true){
                            echo NewsObject::noMoreNewsStories();
                        }else{
                            echo NewsObject::noMoreNewsStories();
                        }
                        
                        
                    }else{
                        //// FIX ME !!!!!
                        writeToLog("NO DISTRICT BRO !");
                        
                        if(isDistrictNews == true){
                            
                            writeToLog("DISTRICT NEXT NEWS TRUE");
                            
                            if($districtNumber !== null){
                                
                                writeToLog("DISTRICT IS TRUE");
                                
                                
                            }else{
                                
                                writeToLog("NO DISTRICT BRO !");
                                echo NewsObject::getAnotherStory($districtNumber,$totalCount,$currentCount,$readCount,$hash,$pubDate);
                            }
                            
                        }else{
                            writeToLog("NOT NEWS !!!");
                        }
                        
                    }
                    
                    
                    
                    
                    
                    break;
                    
            }
            
        }else if($newsTypeCode == "ER_SUCCESS_MATCH"){
            
            switch($newsTypeValue){
                
                case "latest":
                    //STUFF
                    $news = new NewsObject();
                    if($districtNumberCode == "ER_SUCCESS_MATCH"){
                        echo $news->getLastDistrictNews($districtNumberValue);
                        
                    }else if($districtNumberCode == "ER_SUCCESS_NO_MATCH"){
                        // WRONG DISTRICT PROVIDED
                        $error = new ErrorObject();
                        echo $error->wrongDistrict();
                        
                    }else{
                        echo $news->getLastDistrictNews(0);
                    }
                    
                    
                    break;
                    
                case "crime":
                    //STUFF
                    
                    break;
            }
            
        }else if($presentTimeCode == "ER_SUCCESS_MATCH"){
            writeToLog("PRESENT CODE HERE");
            
            switch($presentTimeValue){
                
                case "yesterday":
                    
                    writeToLog("HAPPEN YESTERDAY");
                    $news = new NewsObject();
                    
                    if($districtNumberCode == "ER_SUCCESS_MATCH"){
                        writeToLog("DISTRICT CODE MATCH");
                        echo $news->getYesterdayNews($districtNumberValue);
                    }else if($districtNumberCode == "ER_SUCCESS_NO_MATCH"){
                        $error = new ErrorObject();
                        echo $error->wrongDistrict();
                    }else{
                        writeToLog("JUST RUN FUNCTION");
                        echo $news->getYesterdayNews(0);
                    }
                
                break;
                
                
            }
            
        }
        
    
    }
   
    ///////////////////// END OF DISTRICT NEWS INTENT///////////////////////////////////////////
   
    else if($itReq == "IntentRequest" && $itNam == "fetchStats"){ // FETCH INTENT STUFF
  
            date_default_timezone_set('US/Eastern'); // SET THAT TIME BOY
            
            $presentCode = $data['request']['intent']['slots']['presentTime']['resolutions']['resolutionsPerAuthority'][0]['status']['code'];
            $presentValue = $data['request']['intent']['slots']['presentTime']['resolutions']['resolutionsPerAuthority'][0]['values'][0]['value']['name'];
            $districtCode = $data['request']['intent']['slots']['district']['resolutions']['resolutionsPerAuthority'][0]['status']['code'];
            $districtValue = $data['request']['intent']['slots']['district']['resolutions']['resolutionsPerAuthority'][0]['values'][0]['value']['name'];
            $crimeValue = $data['request']['intent']['slots']['crimeType']['resolutions']['resolutionsPerAuthority'][0]['values'][0]['value']['name'];
            $crimeCode = $data['request']['intent']['slots']['crimeType']['resolutions']['resolutionsPerAuthority'][0]['status']['code'];

            
            
            if($presentCode == "ER_SUCCESS_MATCH"){
                writeToLog("PRESENT CODE HERE");
                
                switch($presentValue){
                    
                    case "today":
                        
                        // CHECK CRIME CODE
                        writeToLog("TODAY HERE");
                        if($crimeCode == "ER_SUCCESS_MATCH"){
                            
                            writeToLog("IS A CRIMETYPE");
                            $crime = new CrimeObject();
                            $shoot = new ShootingObject();
                            
                            if($districtCode == "ER_SUCCESS_MATCH" ){
                                
                                writeToLog("DISTRICT PROVIDED");
                                if($crimeValue == "shootings"){
                                    writeToLog("ITS A SHOOTING!");
                                    echo $shoot->getTodayShootings($districtValue);
                                }else{
                                    echo $crime->getCrimeToday($crimeValue, $districtValue);
                                    
                                }
                            
                            }else if($districtCode == "ER_SUCCESS_NO_MATCH"){
                                /// WRONG DISTRICT PROVIDED
                                $error = new ErrorObject();
                                echo $error->wrongDistrict();
                                
                            }else{
                                
                                writeToLog("NO DISTRICT PROVIDED");
                                if($crimeValue == "shootings"){
                                    writeToLog("ITS A SHOOTING!");
                                    echo $shoot->getTodayShootings(0);
                                }else{
                                    echo $crime->getCrimeToday($crimeValue, 0);
                                    
                                }
                               
                            }
                            
                        }else if($crimeCode == "ER_SUCCESS_NO_MATCH"){
                            // THE WRONG TYPE OF CRIME WAS PROVIDED
                            $error = new ErrorObject();
                            echo $error->wrongCrimeType();
                        }
                        
                        
                        break;
                        
                    case "last":
                        
                        writeToLog("LAST HERE");
                        if($crimeCode == "ER_SUCCESS_MATCH"){
                            
                            writeToLog("CRIMETYPE PROVIDED");
                            $crime = new CrimeObject();
                            $shoot = new ShootingObject();
                            
                            if($districtCode == "ER_SUCCESS_MATCH"){
                                writeToLog("IS A CRIMETYPE");
                                
                                if($crimeValue == "shootings"){
                                    echo $shoot->getLastShooting($districtValue);
                                }else{
                                    echo $crime->getLastCrime($crimeValue, $districtValue);
                                }
                               
                            }else if($districtCode == "ER_SUCCESS_NO_MATCH"){
                                /// WRONG DISTRICT PROVIDED
                                $error = new ErrorObject();
                                echo $error->wrongDistrict();
                                
                            }else{
                                
                                writeToLog("NO DISTRICT PROVIDED");
                                
                                if($crimeValue == "shootings"){
                                    echo $shoot->getLastShooting(0);
                                }else{
                                    echo $crime->getLastCrime($crimeValue, 0);
                                }
                                
                                
                            }
                            
                        }else if($crimeCode == "ER_SUCCESS_NO_MATCH"){
                            // THE WRONG TYPE OF CRIME WAS PROVIDED
                            $error = new ErrorObject();
                            echo $error->wrongCrimeType();
                        }
                        
                        break;
                        
                    case "yesterday":
                        
                        if($crimeCode == "ER_SUCCESS_MATCH"){
                            
                            writeToLog("IS A CRIMETYPE YESTERDAY");
                            
                            if($districtCode == "ER_SUCCESS_MATCH"){
                                writeToLog("DISTRICT HERE 99  YESTERDAY");
                                if($crimeValue == "shootings"){
                                    writeToLog("ITS A SHOOTING! YESTERDAY");
                                    //echo ShootingObject::getTodayShootings($districtValue);
                                }else{
                                    writeToLog("ITS A CRIME YESTERDAY");
                                   // echo CrimeObject::getCrimeToday($crimeValue,$districtValue);
                                    
                                }
                                
                                // HAS A DISTRICT
                            }else if($districtCode == "ER_SUCCESS_NO_MATCH"){
                                // WRONG DISTRICT PROVIDED
                                writeToLog("ERROR NO DISTRICT EXIST YESTERDAY");
                                echo ErrorObject::wrongDistrict();
                                
                            }else{
                                // NO DISTRICT
                                writeToLog("NO DISTRICT PROVIDED YESTERDAY");
                                if($crimeValue == "shootings"){
                                    writeToLog("ITS A SHOOTING! YESTERDAY");
                                    
                                    echo ShootingObject::getYesterdayShooting(0);
                                }else{
                                    echo CrimeObject::getCrimeToday($crimeValue, 0);
                                    
                                }
                            }
                            
                        }else{
                            
                        }
                    
                    
                    break;
                        
                    
                }
                
            }
    }
    
    else if($itReq == "IntentRequest" && $itNam == "ackResponse"){
        
        $answerCode = $data['request']['intent']['slots']['answer']['resolutions']['resolutionsPerAuthority'][0]['status']['code'];
        $answerValue = $data['request']['intent']['slots']['answer']['resolutions']['resolutionsPerAuthority'][0]['values'][0]['value']['name'];
        $attArray = $data['session']['attributes'];
        $hash = $data['session']['attributes']["Hash"];
        $presentTime = $data['session']['attributes']["presentTime"];
        $crimeType = $data['session']['attributes']["crimeType"];
        $districtNews = $data['session']['attributes']["districtNews"];
        $currentCount = $data['session']['attributes']["currentCount"];
        $districtNumber = $data['session']['attributes']["districtNumber"];
        
        if($answerCode == "ER_SUCCESS_MATCH"){
            
            switch($answerValue){
                
                case "yes":
                    
                    // FETCH ANOTHER STORY 
                    if($districtNews == true){
                        $totalCount = $data['session']['attributes']["totalCount"];
                        
                        if($totalCount == 0){
                            echo NewsObject::noMoreNewsStories();
                            
                        }else{
                            
                            $news = new NewsObject();
                            $totalCount = $data['session']['attributes']["totalCount"];
                            $currentCount = $data['session']['attributes']["currentCount"];
                            $readCount = $data['session']['attributes']["readCount"];
                            $pubDate = $data['session']['attributes']["pubDate"];
                            
                            if($hash !== null){
                                
                                echo $news->getAnotherStory($districtNumber,$totalCount,$currentCount,$readCount,$hash,0);
                                
                            }else{
                                
                                echo $news->getAnotherStory($districtNumber,$totalCount,$currentCount,$readCount,0,$pubDate);
                                
                            }
                            
                        }

                    }
                    
                    //FETCH ANOTHER CRIME INCIDENT
                    if($presentTime !== null && $crimeType != null){
                        
                         //WHERE THER ANY SHOOTINGS TODAY   
                        if($crimeType == "shootings"){
                            
                            $shootingDate = $attArray['shootingDate'];
                            $totalCount = $attArray["totalCount"];
                            $currentCount = $attArray["currentCount"];
                            $shoot = new ShootingObject();
                            echo $shoot->getAnotherShooting($districtNumber,$shootingDate,$totalCount,$currentCount);
                            
                        }else{
                            
                            // WHERE THERE ANY (CRIMES TODAY)
                            $currentCount = $attArray['currentCount'];
                            $totalCount = $attArray['totalCount'];
                            $districtNum = $attArray['districtNumber'];
                            $category = $attArray['category'];
                            $dDate = $attArray['dDate'];
                            $readCount = $attArray['readCount'];
                            
                            if($totalCount == 0){
                                echo CrimeObject::noMoreCrimes();
                                
                            }else{
                                echo CrimeObject::getMoreCrimes($districtNum,$dDate,$category,$totalCount,$currentCount,$presentTime,$crimeType,$readCount);
                                
                            }
                            
                            
                            
                        }
                            
                           
                        
                    }
                    
                    
                    
                    
                    break;
                    
                case "no":
                    
                    //SUFF
                    
                    
                    break;
                
            }
            
        }
        
        
        
    }
                      
                    	                



?>
