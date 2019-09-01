<?php 


include_once("ConnectObject.php");
include_once("ParserHelper.php");


class CrimeObject{
 
    
    var $CrimeID;
    var $TimeStamp;
    var $DistrictNumber;
    var $PSAArea;
    var $DispatchTime;
    var $DispatchDate;
    var $Address;
    var $CrimeType;
    var $CrimeCode;
    var $LocationX;
    var $LocationY;
    
    
    function getMoreCrimes($districtNum,$dDate,$category,$totalCount,$currentCount,$presentTime,$crimeType,$readCount){
        
        $connect = new ConnectObject();
        $utils = new ParserHelper();
        
        $totalCount = $totalCount - 1;
        
        if($districtNum == 0){
            $f_URL = "SELECT * FROM `CrimeIncidents` WHERE `DispatchDate` = '$dDate' AND `CrimeName` IN ($category) ORDER BY `DispatchTime` DESC LIMIT $totalCount, $currentCount";
            
        }else{
            $f_URL = "SELECT * FROM `CrimeIncidents` WHERE `DispatchDate` = '$dDate' AND `CrimeName` IN ($category) AND `DistrictNumber` = $districtNum ORDER BY `DispatchTime` DESC LIMIT $totalCount, $currentCount";
            
        }
        
        $utils->writeToLog("QUERY: ".$f_URL);
        
        $rex = mysqli_query($connect->connect(), $f_URL);
        $roq = mysqli_fetch_array($rex);
        
        $desc = utf8_encode($utils->cleanTxT($roq['AddressBlock']));
        $speaK = '<p>'.$desc.'</p>';
        $tiime = date('l F jS,',strtotime($roq['DispatchDate']));
        $d_time = date("g:i a",strtotime($roq['DispatchTime']));
        $bllk = $utils->fixAddress($roq['AddressBlock']);
        $crime = $roq['CrimeName'];
        $more = ", do you want to hear the next incident?";
        $noMore = "<p>, there are no more incidents to report at this time, would you like me to help you with something else?</p>";
        $numD = $utils->addTH($roq['DistrictNumber']);
        $wDis = "in the ".$numD." district, ";
        
        if($totalCount == 0){
            
            $utils->writeToLog("COUNT NOW zero: ".$totalCount);
            
            $free = "<p>".$wDis."on ".$tiime." the Philadelphia Police were dispatched at ".$d_time.", to the ".$bllk." for a ".$crime.$noMore."</p>";
            
            $ress = json_encode(array("version"=>"1.0","sessionAttributes"=>array("totalCount"=>$totalCount,"currentCount"=>$currentCount,"dDate"=>null,"category"=>null,"districtNumber"=>$districtNum,"presentTime"=>null,"crimeType"=>null,"readCount"=>""),"response"=>
                array("outputSpeech"=>
                    array("type"=>"SSML","ssml"=>"<speak>".$free."</speak>"),"shouldEndSession"=>false,"reprompt"=>null)));
            
        
        
        }else{
            
            $utils->writeToLog("COUNT NOW: ".$totalCount);
            $free = "<p>".$wDis."on ".$tiime." the Philadelphia Police were dispatched at ".$d_time.", to the ".$bllk." for a ".$crime.$more."</p>";
            
            $totalCount - 1;
            $readCount ++;
            
            $ress = json_encode(array("version"=>"1.0","sessionAttributes"=>array("totalCount"=>$totalCount,"currentCount"=>$currentCount,"dDate"=>$dDate,"category"=>$category,"districtNumber"=>$districtNum,"presentTime"=>$presentTime,"crimeType"=>$crimeType,"readCount"=>$readCount),"response"=>
                array("outputSpeech"=>
                    array("type"=>"SSML","ssml"=>"<speak>".$free."</speak>"),"shouldEndSession"=>false,"reprompt"=>null)));
            
        }
        
  
        
        $utils->writeToLog($ress);
        
        return $ress;
        
        
        
        
    }
    
    
    function getCrimeToday($crimeValue, $districtNumber){
        
        $connect = new ConnectObject();
        $utils = new ParserHelper();
        
        $ret = '';
        
        $tyArr = array();
        $sRob = 'SELECT `Name` FROM `CrimeTypes` WHERE `Type` = '."'".$crimeValue."'";
        $sRes = mysqli_query($connect->connect(), $sRob);
        
        if(mysqli_num_rows($sRes) >= 1){
            
            while($tows = mysqli_fetch_array($sRes)){
                $nam = $tows['Name'];
                array_push($tyArr,$nam);
            }
            
            $sir = implode("','", $tyArr);
            $fin = "'".$sir."'";
            $td2 = date('Y-m-d');
            
            
            if($districtNumber == 0){
                $sql_x = 'SELECT * FROM `CrimeIncidents` WHERE `CrimeName` IN ('.$fin.') AND `DispatchDate` = '.$td2.' ORDER BY `DispatchTime` DESC';
                
            }else{
                $sql_x = 'SELECT * FROM `CrimeIncidents` WHERE `CrimeName` IN ('.$fin.') AND `DispatchDate` = '.$td2.' AND `DistrictNumber` = '.$districtNumber.' ORDER BY `DispatchTime` DESC';
                
            }
            
            $resx = mysqli_query($connect->connect(), $sql_x);
            
            if(mysqli_num_rows($resx) >= 1){
                /// ASSAULTS DO EXIST TODAY
                
            }else{
                
                if($districtNumber == 0){
                    $l_sql = 'SELECT `DispatchDate` FROM `CrimeIncidents` WHERE `CrimeName`IN ('.$fin.') ORDER BY `DispatchDate` DESC LIMIT 0,1';
                    
                }else{
                    $l_sql = 'SELECT `DispatchDate` FROM `CrimeIncidents` WHERE `CrimeName`IN ('.$fin.') AND `DistrictNumber` = '.$districtNumber.' ORDER BY `DispatchDate` DESC LIMIT 0,1';
                    
                }
                
                $lres = mysqli_query($connect->connect(), $l_sql);
                
                if(mysqli_num_rows($lres) >= 1){
                    
                    $drow = mysqli_fetch_array($lres);
                    $f_date = $drow['DispatchDate'];
                    
                    if($districtNumber == 0){
                        $m_sql = 'SELECT COUNT(`DispatchDate`) AS d_Count FROM `CrimeIncidents` WHERE `DispatchDate` = '."'".$f_date."'".' AND `CrimeName` IN ('.$fin.')';
                        
                    }else{
                        $m_sql = 'SELECT COUNT(`DispatchDate`) AS d_Count FROM `CrimeIncidents` WHERE `DispatchDate` = '."'".$f_date."'".' AND `CrimeName` IN ('.$fin.') AND `DistrictNumber` = '.$districtNumber.'';
                        
                    }
                    
                    $ref = mysqli_query($connect->connect(), $m_sql);
                    
                    if(mysqli_num_rows($ref) >= 1){
                        $c_arr = mysqli_fetch_array($ref);
                        $ctc = $c_arr['d_Count'];
                        date_default_timezone_set('US/Eastern');
                        $td2 = date('Y-m-d');
                        $x_ago = $utils->dateDifference($f_date,$td2,"%d days");
                        $cvv = strtotime($f_date);
                        $nDate = date('l F jS ',$cvv);
                        
                        
                        /// IF ONE ONLY ONE RECORD RETURN
                        if($ctc == 1 && $x_ago == "1 days"){
                            
                            if($crimeValue == "assault"){
                                
                                if($districtNumber == 0){
                                    $say = '<speak><p>There are no assaults to report today at this time. However, there is '.$ctc.' reported assault yesterday, '.$nDate.', would you like to hear the details?</p></speak>';
                                    
                                }else{
                                    $say = '<speak><p>In the '.$utils->addTH($districtNumber).' district, There are no assaults to report today at this time. However, there is '.$ctc.' reported assault yesterday, '.$nDate.', would you like to hear the details?</p></speak>';
                                    
                                }
                                
                            }
                            if($crimeValue == "theft"){
                                
                                if($districtNumber == 0){
                                    $say = '<speak><p>There are no thefts to report today at this time. However, there is '.$ctc.' reported theft yesterday, '.$nDate.', would you like to hear the details?</p></speak>';
                                    
                                }else{
                                    $say = '<speak><p>In the '.$utils->addTH($districtNumber).' district, There are no thefts to report today at this time. However, there is '.$ctc.' reported theft yesterday, '.$nDate.', would you like to hear the details?</p></speak>';
                                    
                                }
                                
                            }
                            if($crimeValue == "robbery"){
                                
                                if($districtNumber == 0){
                                    $say = '<speak><p>I do not have any robberies to report today at this time. However, there is '.$ctc.' reported robbery yesterday, '.$nDate.', would you like to hear the details?</p></speak>';
                                    
                                }else{
                                    $say = '<speak><p>In the '.$utils->addTH($districtNumber).' district, I do not have any robberies to report today at this time. However, there is '.$ctc.' reported robbery yesterday, '.$nDate.', would you like to hear the details?</p></speak>';
                                    
                                }
                                
                            }
                            if($crimeValue == "burglary"){
                                
                                if($districtNumber == 0){
                                    $say = '<speak><p>There are no burglaries to report today at this time. However, there is '.$ctc.' reported burglary yesterday, '.$nDate.', would you like to hear the details?</p></speak>';
                                    
                                }else{
                                    $say = '<speak><p>In the '.$utils->addTH($districtNumber).' district, There are no burglaries to report today at this time. However, there is '.$ctc.' reported burglary yesterday, '.$nDate.', would you like to hear the details?</p></speak>';
                                    
                                }
                                
                            }
                            if($crimeValue == "homicide"){
                                
                                if($districtNumber == 0){
                                    $say = '<speak><p>There are no homicides to report today at this time. However, there is '.$ctc.' reported homicide yesterday, '.$nDate.', would you like to hear the details?</p></speak>';
                                    
                                }else{
                                    $say = '<speak><p>In the '.$utils->addTH($districtNumber).' district, There are no homicides to report today at this time. However, there is '.$ctc.' reported homicide yesterday, '.$nDate.', would you like to hear the details?</p></speak>';
                                    
                                }
                                
                            }
                            if($crimeValue == "sexual assault"){
                                
                                if($districtNumber == 0){
                                    $say = '<speak><p>There are no sexual assaults to report today at this time. However, there is '.$ctc.' reported sexual assault yesterday, '.$nDate.', would you like to hear the details?</p></speak>';
                                    
                                }else{
                                    $say = '<speak><p>In the '.$utils->addTH($districtNumber).' district, There are no sexual assaults to report today at this time. However, there is '.$ctc.' reported sexual assault yesterday, '.$nDate.', would you like to hear the details?</p></speak>';
                                    
                                }
                                
                            }
                            if($crimeValue == "drugs"){
                                
                                if($districtNumber == 0){
                                    $say = '<speak><p>there are no drugs, or narcotic law violations to report today at this time. However, there is '.$ctc.' reported drug, or narcotic law violation yesterday, '.$nDate.', would you like to hear the details?</p></speak>';
                                    
                                }else{
                                    $say = '<speak><p>In the '.$utils->addTH($districtNumber).' district, There are no drugs, or narcotic law violations to report today at this time. However, there is '.$ctc.' reported drug, or narcotic law violation yesterday, '.$nDate.', would you like to hear the details?</p></speak>';
                                    
                                }
                                
                            }
                        }else if($ctc > 1 && $x_ago == "1 days"){
                            
                            if($crimeValue == "assault"){
                                
                                if($districtNumber == 0){
                                    $say = '<speak><p>There are no assaults to report today at this time. However, there was '.$ctc.' reported assaults yesterday, '.$nDate.', would you like to hear the details?</p></speak>';
                                    
                                }else{
                                    $say = '<speak><p>In the '.$utils->addTH($districtNumber).' district, There are no assaults to report today at this time. However, there was '.$ctc.' reported assault yesterday, '.$nDate.', would you like to hear the details?</p></speak>';
                                    
                                }
                                
                            }
                            if($crimeValue == "theft"){
                                
                                if($districtNumber == 0){
                                    $say = '<speak><p>There are no thefts to report today at this time. However, there was '.$ctc.' reported thefts yesterday, '.$nDate.', would you like to hear the details?</p></speak>';
                                    
                                }else{
                                    $say = '<speak><p>In the '.$utils->addTH($districtNumber).' district, There are no thefts to report today at this time. However, there was '.$ctc.' reported theft yesterday, '.$nDate.', would you like to hear the details?</p></speak>';
                                    
                                }
                                
                            }
                            if($crimeValue == "robbery"){
                                
                                if($districtNumber == 0){
                                    $say = '<speak><p>I do not have any robberies to report today at this time. However, there was '.$ctc.' reported robberies yesterday, '.$nDate.', would you like to hear the details?</p></speak>';
                                    
                                }else{
                                    $say = '<speak><p>In the '.$utils->addTH($districtNumber).' district, I do not have any robberies to report today at this time. However, there was '.$ctc.' reported robbery yesterday, '.$nDate.', would you like to hear the details?</p></speak>';
                                    
                                }
                                
                            }
                            if($crimeValue == "burglary"){
                                
                                if($districtNumber == 0){
                                    $say = '<speak><p>There are no burglaries to report today at this time. However, there was '.$ctc.' reported burglaries yesterday, '.$nDate.', would you like to hear the details?</p></speak>';
                                    
                                }else{
                                    $say = '<speak><p>In the '.$utils->addTH($districtNumber).' district, There are no burglaries to report today at this time. However, there was '.$ctc.' reported burglary yesterday, '.$nDate.', would you like to hear the details?</p></speak>';
                                    
                                }
                                
                            }
                            if($crimeValue == "homicide"){
                                
                                if($districtNumber == 0){
                                    $say = '<speak><p>There are no homicides to report today at this time. However, there was '.$ctc.' reported homicides yesterday, '.$nDate.', would you like to hear the details?</p></speak>';
                                    
                                }else{
                                    $say = '<speak><p>In the '.$utils->addTH($districtNumber).' district, There are no homicides to report today at this time. However, there was '.$ctc.' reported homicide yesterday, '.$nDate.', would you like to hear the details?</p></speak>';
                                    
                                }
                                
                            }
                            if($crimeValue == "sexual assault"){
                                
                                if($districtNumber == 0){
                                    $say = '<speak><p>There are no sexual assaults to report today at this time. However, there was '.$ctc.' reported sexual assaults yesterday, '.$nDate.', would you like to hear the details?</p></speak>';
                                    
                                }else{
                                    $say = '<speak><p>In the '.$utils->addTH($districtNumber).' district, There are no sexual assaults to report today at this time. However, there was '.$ctc.' reported sexual assault yesterday, '.$nDate.', would you like to hear the details?</p></speak>';
                                    
                                }
                                
                            }
                            if($crimeValue == "drugs"){
                                
                                if($districtNumber == 0){
                                    $say = '<speak><p>There are no drugs, or narcotic law violations to report today at this time. However, there was '.$ctc.' reported drug or narcotic law violations yesterday, '.$nDate.', would you like to hear the details?</p></speak>';
                                    
                                }else{
                                    $say = '<speak><p>In the '.$utils->addTH($districtNumber).' district, There are no drug, or narcotic law violations to report today at this time. However, there was '.$ctc.' reported drug, or narcotic law violation, '.$nDate.', would you like to hear the details?</p></speak>';
                                    
                                }
                                
                            }
                            
                        }else if($ctc == 1){
                            
                            if($crimeValue == "assault"){
                                
                                if($districtNumber == 0){
                                    $say = '<speak><p>There are no assaults to report today at this time. However, there is '.$ctc.' reported assault '.$x_ago.' ago, '.$nDate.', would you like to hear the details?</p></speak>';
                                    
                                }else{
                                    $say = '<speak><p>In the '.$utils->addTH($districtNumber).' district, There are no assaults to report today at this time. However, there is '.$ctc.' reported assault '.$x_ago.' ago, '.$nDate.', would you like to hear the details?</p></speak>';
                                    
                                }
                                
                            }
                            if($crimeValue == "theft"){
                                
                                if($districtNumber == 0){
                                    $say = '<speak><p>There are no thefts to report today at this time. However, there is '.$ctc.' reported theft '.$x_ago.' ago, '.$nDate.', would you like to hear the details?</p></speak>';
                                    
                                }else{
                                    $say = '<speak><p>In the '.$utils->addTH($districtNumber).' district, There are no thefts to report today at this time. However, there is '.$ctc.' reported theft '.$x_ago.' ago, '.$nDate.', would you like to hear the details?</p></speak>';
                                    
                                }
                                
                            }
                            if($crimeValue == "robbery"){
                                
                                if($districtNumber == 0){
                                    $say = '<speak><p>I do not have any robberies to report today at this time. However, there is '.$ctc.' reported robbery '.$x_ago.' ago, '.$nDate.', would you like to hear the details?</p></speak>';
                                    
                                }else{
                                    $say = '<speak><p>In the '.$utils->addTH($districtNumber).' district, I do not have any robberies to report today at this time. However, there is '.$ctc.' reported robbery '.$x_ago.' ago, '.$nDate.', would you like to hear the details?</p></speak>';
                                    
                                }
                                
                            }
                            if($crimeValue == "burglary"){
                                if($districtNumber == 0){
                                    $say = '<speak><p>There are no burglaries to report today at this time. However, there is '.$ctc.' reported burglary '.$x_ago.' ago, '.$nDate.', would you like to hear the details?</p></speak>';
                                    
                                }else{
                                    $say = '<speak><p>In the '.$utils->addTH($districtNumber).' district, There are no burglaries to report today at this time. However, there is '.$ctc.' reported burglary '.$x_ago.' ago, '.$nDate.', would you like to hear the details?</p></speak>';
                                    
                                }
                                
                            }
                            if($crimeValue == "homicide"){
                                if($districtNumber == 0){
                                    $say = '<speak><p>There are no homicides to report today at this time. However, there is '.$ctc.' reported homicide '.$x_ago.' ago, '.$nDate.', would you like to hear the details?</p></speak>';
                                    
                                }else{
                                    $say = '<speak><p>In the '.$utils->addTH($districtNumber).' district, There are no homicides to report today at this time. However, there is '.$ctc.' reported homicide '.$x_ago.' ago, '.$nDate.', would you like to hear the details?</p></speak>';
                                    
                                }
                                
                            }
                            if($crimeValue == "sexual assault"){
                                if($districtNumber == 0){
                                    $say = '<speak><p>There are no sexual assaults to report today at this time. However, there is '.$ctc.' reported sexual assault '.$x_ago.' ago, '.$nDate.', would you like to hear the details?</p></speak>';
                                    
                                }else{
                                    $say = '<speak><p>In the '.$utils->addTH($districtNumber).' district, There are no sexual assaults to report today at this time. However, there is '.$ctc.' reported sexual assault '.$x_ago.' ago, '.$nDate.', would you like to hear the details?</p></speak>';
                                    
                                }
                                
                            }
                            if($crimeValue == "drugs"){
                                if($districtNumber == 0){
                                    $say = '<speak><p>There are no drugs, or narcotic law violations to report today at this time. However, there is '.$ctc.' reported drug, or narcotic law violation '.$x_ago.' ago, '.$nDate.', would you like to hear the details?</p></speak>';
                                    
                                }else{
                                    $say = '<speak><p>In the '.$utils->addTH($districtNumber).' district, There are no drug, or narcotic law violations to report today at this time. However, there is '.$ctc.' reported drug, or narcotic law violation '.$x_ago.' ago, '.$nDate.', would you like to hear the details?</p></speak>';
                                    
                                }
                                
                            }
                        }else{
                            
                            if($crimeValue == "assault"){
                                
                                if($districtNumber == 0){
                                    $say = '<speak><p>There are no assaults to report today at this time. However, there were '.$ctc.' assaults '.$x_ago.' ago, '.$nDate.', would you like to hear the details?</p></speak>';
                                    
                                }else{
                                    $say = '<speak><p>In the '.$utils->addTH($districtNumber).' district, There are no assaults to report today at this time. However, there were '.$ctc.' assaults '.$x_ago.' ago, '.$nDate.', would you like to hear the details?</p></speak>';
                                    
                                }
                            }
                            if($crimeValue == "theft"){
                                
                                if($districtNumber == 0){
                                    $say = '<speak><p>There are no thefts to report today at this time. However, there were '.$ctc.' reported thefts '.$x_ago.' ago, '.$nDate.', would you like to hear the details?</p></speak>';
                                    
                                }else{
                                    $say = '<speak><p>In the '.$utils->addTH($districtNumber).' district, There are no thefts to report today at this time. However, there were '.$ctc.' reported thefts '.$x_ago.' ago, '.$nDate.', would you like to hear the details?</p></speak>';
                                    
                                }
                                
                                
                            }
                            if($crimeValue == "robbery"){
                                
                                if($districtNumber == 0){
                                    $say = '<speak><p>I do not have any robberies to report today at this time. However, there were '.$ctc.' reported robberies '.$x_ago.' ago, '.$nDate.', would you like to hear the details?</p></speak>';
                                    
                                }else{
                                    $say = '<speak><p>In the '.$utils->addTH($districtNumber).' district, I do not have any robberies to report today at this time. However, there were '.$ctc.' reported robberies '.$x_ago.' ago, '.$nDate.', would you like to hear the details?</p></speak>';
                                    
                                }
                                
                                
                            }
                            if($crimeValue == "burglary"){
                                
                                if($districtNumber == 0){
                                    $say = '<speak><p>There are no burglaries to report today at this time. However, there were '.$ctc.' reported burglaries '.$x_ago.' ago, '.$nDate.', would you like to hear the details?</p></speak>';
                                    
                                }else{
                                    $say = '<speak><p>In the '.$utils->addTH($districtNumber).' district, There are no burglaries to report today at this time. However, there were '.$ctc.' reported burglaries '.$x_ago.' ago, '.$nDate.', would you like to hear the details?</p></speak>';
                                    
                                }
                                
                                
                            }
                            if($crimeValue == "homicide"){
                                
                                if($districtNumber == 0){
                                    $say = '<speak><p>There are no homicides to report today at this time. However, there were '.$ctc.' reported homicides '.$x_ago.' ago, '.$nDate.', would you like to hear the details?</p></speak>';
                                    
                                }else{
                                    $say = '<speak><p>In the '.$utils->addTH($districtNumber).' district, There are no homicides to report today at this time. However, there were '.$ctc.' reported homicides '.$x_ago.' ago, '.$nDate.', would you like to hear the details?</p></speak>';
                                    
                                }
                                
                                
                            }
                            if($crimeValue == "sexual assault"){
                                
                                if($districtNumber == 0){
                                    $say = '<speak><p>There are no sexual assaults to report today at this time. However, there were '.$ctc.' reported sexual assaults '.$x_ago.' ago, '.$nDate.', would you like to hear the details?</p></speak>';
                                    
                                }else{
                                    $say = '<speak><p>In the '.$utils->addTH($districtNumber).' district, There are no sexual assaults to report today at this time. However, there were '.$ctc.' reported sexual assaults '.$x_ago.' ago, '.$nDate.', would you like to hear the details?</p></speak>';
                                    
                                }
                                
                                
                            }
                            if($crimeValue == "drugs"){
                                
                                if($districtNumber == 0){
                                    $say = '<speak><p>There are no drugs, or narcotic law violations to report today at this time. However, there were '.$ctc.' reported drugs, or narcotic law violations '.$x_ago.' ago, '.$nDate.', would you like to hear the details?</p></speak>';
                                    
                                }else{
                                    $say = '<speak><p>In the '.$utils->addTH($districtNumber).' district, There are no drugs, or narcotic law violations to report today at this time. However, there were '.$ctc.' reported drugs, or narcotic law violations '.$x_ago.' ago, '.$nDate.', would you like to hear the details?</p></speak>';
                                    
                                }
                                
                                
                            }
                            
                            
                        }
                        
                        
                        
                        $txt = array("version"=>"1.0","sessionAttributes"=>array("presentTime"=>"today","crimeType"=>$crimeValue,"currentCount"=>1,"totalCount"=>$ctc,"districtNumber"=>$districtNumber,"category"=>$fin,"dDate"=>$f_date,"readCount"=>1),"response"=>array("outputSpeech"=>array("type"=>"SSML","ssml"=>$say),"reprompt"=>null,"shouldEndSession"=>false));
                        
                        $ret = json_encode($txt);
                        
                        
                    }
                    
                }
                
                
            }
            
            
        }
        
        
        // NO CRIME TYPE RETURNED FROM QUERY
        writeToLog("WET ".$ret);
        
        return $ret;
        
        
        
        
        
    }
    
    
    function getLastCrime($crimeValue, $districtNumber){
        
        $connect = new ConnectObject();
        $utils = new ParserHelper();
        
        $td2 = date('Y-m-d');
        
            if($crimeValue == "robbery"){
                
                if($districtNumber == 0){
                    
                    $sel = "SELECT * FROM `CrimeIncidents` WHERE `CrimeName` LIKE '%robbery%' ORDER BY `DispatchDate` DESC, `DispatchTime` ASC LIMIT 0,1";
                    
                }else{
                    $sel = "SELECT * FROM `CrimeIncidents` WHERE `CrimeName` LIKE '%robbery%' AND `DistrictNumber` = $districtNumber ORDER BY `DispatchDate` DESC, `DispatchTime` ASC LIMIT 0,1";
                    
                    
                }
                
                $res = mysqli_query($connect->connect(), $sel);
                $arr = mysqli_fetch_array($res);
                writeToLog($sel);
                
                
                $dist = $utils->addTH($arr['DistrictNumber']);
                $dTime =  $arr['DispatchTime'];
                $dDate =  $arr['DispatchDate'];
                $aBlock = $utils->fixaddress($arr['AddressBlock']);
                $cName =  $arr['CrimeName'];
                $patt = '/(?i)(Robbery Firearm)/is';
                $conT = $dDate." ".$dTime;
                $ctime = date('l F jS, h:i a', strtotime($conT));
                
                if(preg_match($patt,$cName)){
                    
                    if($districtNumber == 0){
                        
                        $sa = '<speak><p>The last reported robbery was '.$ctime.'. On the '.$aBlock.' in the '.$dist.' police district.</p></speak>';
                        
                    }else{
                        $sa = '<speak><p>The last reported robbery in the '.$dist.' police district was '.$ctime.'. On the '.$aBlock.'.</p></speak>';
                        
                    }
                    
                }else{
                    
                    if($districtNumber == 0){
                        $sa = '<speak><p>The last reported robbery was '.$ctime.'. On the '.$aBlock.' in the '.$dist.' police district. No firearm was reportedly used in this crime.</p></speak>';
                        
                    }else{
                        $sa = '<speak><p>The last reported robbery in the '.$dist.' police district was '.$ctime.'. On the '.$aBlock.'. No firearm was reportedly used in this crime.</p></speak>';
                        
                    }
                    
                }
                
                $say = array("version"=>"1.0","sessionAttributes"=>"",
                    "response"=>array("outputSpeech"=>array("type"=>"SSML","ssml"=>$sa),
                        "reprompt"=>null,"shouldEndSession"=>false));
                
                echo json_encode($say);
            }
            
            if($crimeValue == "assault"){
                
                if($districtNumber == 0){
                    
                    $sel = "SELECT * FROM `CrimeIncidents` WHERE `CrimeName` LIKE '%assault%' ORDER BY `DispatchDate` DESC, `DispatchTime` ASC LIMIT 0,1";
                    
                }else{
                    $sel = "SELECT * FROM `CrimeIncidents` WHERE `CrimeName` LIKE '%assault%' AND `DistrictNumber` = $districtNumber ORDER BY `DispatchDate` DESC, `DispatchTime` ASC LIMIT 0,1";
                    
                    
                }
                
                $res = mysqli_query($connect->connect(), $sel);
                $arr = mysqli_fetch_array($res);
                
                $dist = $arr['DistrictNumber'];
                $dTime =  $arr['DispatchTime'];
                $dDate =  $arr['DispatchDate'];
                $aBlock = $utils->fixaddress($arr['AddressBlock']);
                $cName =  $arr['CrimeName'];
                $conT = $dDate." ".$dTime;
                $ctime = date('l F jS, h:i a', strtotime($conT));
                
                $patt1 = '/(?i)(no firearm)/is';
                $patt2 = '/(?i)(assault firearm)/is';
                
                if(preg_match($patt1,$cName)){
                    //Aggravated Assault No Firearm
                    if($districtNumber == 0){
                        $sa = '<speak><p>The last reported aggravated assault was '.$ctime.'. On the '.$aBlock.' in the '.$utils->addTH($dist).' police district. No firearm was reportedly used in this crime.</p></speak>';
                        
                       
                    }else{
                        $sa = '<speak><p>The last reported aggravated assault in the '.$utils->addTH($districtNumber).' police district, was '.$ctime.'. On the '.$aBlock.'. No firearm was reportedly used in this crime.</p></speak>';
                        
                        
                        
                        
                        
                    }
                    
                }
                else if(preg_match($patt2,$cName)){
                    //Aggravated Assault Firearm
                    
                    if($districtNumber == 0){
                        $sa = '<speak><p>The last reported aggravated assault was '.$ctime.'. On the '.$aBlock.' in the '.$utils->addTH($dist).' police district. A firearm was reportedly used in this crime.</p></speak>';
                        
                    }else{
                        $sa = '<speak><p>The last reported aggravated assault in the '.$utils->addTH($districtNumber).' police district, was '.$ctime.'. On the '.$aBlock.'. No firearm was reportedly used in this crime.</p></speak>';
                        
                    }
                    
                    
                    
                }else{
                    //Other Assaults
                    
                    if($districtNumber == 0){
                        $sa = '<speak><p>The last reported assault was '.$ctime.'. On the '.$aBlock.' in the '.$utils->addTH($dist).' police district. A firearm was reportedly used in this crime.</p></speak>';
                        
                    }else{
                        $sa = '<speak><p>The last reported assault in the '.$utils->addTH($districtNumber).' police district, was '.$ctime.'. On the '.$aBlock.'. No firearm was reportedly used in this crime.</p></speak>';
                        
                    }
                    
                    
                    
                }
                
                
                $say = array("version"=>"1.0","sessionAttributes"=>"",
                    "response"=>array("outputSpeech"=>array("type"=>"SSML","ssml"=>$sa),
                        "reprompt"=>null,"shouldEndSession"=>false));
                
                return json_encode($say);
                
                
                
                
                
            }
            
            // END OF ASSULTS
            
            if($crimeValue == "homicide"){
                
                if($districtNumber == 0){
                    
                    $sel = "SELECT * FROM `CrimeIncidents` WHERE `CrimeName` LIKE '%homicide%' ORDER BY `DispatchDate` DESC, `DispatchTime` ASC LIMIT 0,1";
                    
                }else{
                    $sel = "SELECT * FROM `CrimeIncidents` WHERE `CrimeName` LIKE '%homicide%' AND `DistrictNumber` = $districtNumber ORDER BY `DispatchDate` DESC, `DispatchTime` ASC LIMIT 0,1";
                    
                    
                }
                
                $res = mysqli_query($connect->connect(), $sel);
                $arr = mysqli_fetch_array($res);
                
                $dist = $arr['DistrictNumber'];
                $dTime =  $arr['DispatchTime'];
                $dDate =  $arr['DispatchDate'];
                $aBlock = $utils->fixaddress($arr['AddressBlock']);
                $cName =  $arr['CrimeName'];
                $conT = $dDate." ".$dTime;
                $ctime = date('l F jS, h:i a', strtotime($conT));
                
                $patt1 = '/(?i)(justifiable))/is';
                $patt2 = '/(?i)(criminal)/is';
                
                if(preg_match($patt1,$cName)){
                    
                    //Homicide - Justifiable
                    if($districtNumber == 0){
                        
                        $sa = '<speak><p>The last reported homicide was '.$ctime.'. On the '.$aBlock.' in the '.$utils->addTH($dist).' police district. This incident has been reported as justifiable.</p></speak>';
                        
                        
                    }else{
                        
                        $sa = '<speak><p>The last reported homicide in the '.$utils->addTH($districtNumber).' police district was '.$ctime.'. On the '.$aBlock.'. This incident has been reported as justifiable.</p></speak>';
                        
                        
                    }
                    
                    
                    
                }
                
                if(preg_match($patt2,$cName)){
                    
                    //Homicide - Criminal
                    if($districtNumber == 0){
                        
                        $sa = '<speak><p>The last reported homicide was '.$ctime.'. On the '.$aBlock.' in the '.$utils->addTH($dist).' police district. This incident has been reported as criminal.</p></speak>';
                        
                        
                    }else{
                        
                        $sa = '<speak><p>The last reported homicide in the '.$utils->addTH($districtNumber).' police district was '.$ctime.'. On the '.$aBlock.'. This incident has been reported as criminal.</p></speak>';
                        
                        
                    }
                    
                    
                    
                }
                
                
                $say = array("version"=>"1.0","sessionAttributes"=>"",
                    "response"=>array("outputSpeech"=>array("type"=>"SSML","ssml"=>$sa),
                        "reprompt"=>null,"shouldEndSession"=>false));
                
                return json_encode($say);
                
                
                
            }
            
            
            if($crimeValue == "theft"){
                
                if($districtNumber == 0){
                    
                    $sel = "SELECT * FROM `CrimeIncidents` WHERE `CrimeName` LIKE '%theft%' ORDER BY `DispatchDate` DESC, `DispatchTime` ASC LIMIT 0,1";
                    
                    
                }else{
                    $sel = "SELECT * FROM `CrimeIncidents` WHERE `CrimeName` LIKE '%theft%' AND `DistrictNumber` = $districtNumber ORDER BY `DispatchDate` DESC, `DispatchTime` ASC LIMIT 0,1";
                    
                }
                
                $res = mysqli_query($connect->connect(), $sel);
                $arr = mysqli_fetch_array($res);
                
                $dist = $arr['DistrictNumber'];
                $dTime =  $arr['DispatchTime'];
                $dDate =  $arr['DispatchDate'];
                $aBlock = $utils->fixaddress($arr['AddressBlock']);
                $cName =  $arr['CrimeName'];
                $conT = $dDate." ".$dTime;
                $ctime = date('l F jS, h:i a', strtotime($conT));
                
                $patt1 = '/(?i)(from vehicle)/is';
                $patt2 = '/(?i)(vehicle theft)/is';
                
                if(preg_match($patt1,$cName)){
                    
                    // Theft from Vehicle
                    if($districtNumber == 0){
                        
                       
                        $sa = '<speak><p>The last reported theft was '.$ctime.'. On the '.$aBlock.' in the '.$utils->addTH($dist).' police district. This incident has been reported as a theft from vehicle.</p></speak>';
                        
                    }else{
                        
                        $sa = '<speak><p>The last reported theft in the '.$utils->addTH($districtNumber).' police district was '.$ctime.'. On the '.$aBlock.'. This incident has been reported as a theft from vehicle.</p></speak>';
                        
                        
                    }
                    
                    
                    
                }
                
                
                
                if(preg_match($patt2,$cName)){
                    
                    // Motor Vehicle Theft
                    if($districtNumber == 0){
                        
                        $sa = '<speak><p>The last reported theft was '.$ctime.'. On the '.$aBlock.' in the '.$utils->addTH($dist).' police district. This incident has been reported as a motor vehicle theft.</p></speak>';
                        
                        
                    }else{
                        
                        $sa = '<speak><p>The last reported theft in the '.$utils->addTH($districtNumber).' police district was '.$ctime.'. On the '.$aBlock.'. This incident has been reported as a motor vehicle theft.</p></speak>';
                        
                        
                    }
                    
                    
                    
                }
                
                
                $say = array("version"=>"1.0","sessionAttributes"=>"",
                    "response"=>array("outputSpeech"=>array("type"=>"SSML","ssml"=>$sa),
                        "reprompt"=>null,"shouldEndSession"=>false));
                
                return json_encode($say);
                
                
            }
            
            
            if($crimeValue == "burglary"){
                
                if($districtNumber == 0){
                    
                    $sel = "SELECT * FROM `CrimeIncidents` WHERE `CrimeName` LIKE '%burglary%' ORDER BY `DispatchDate` DESC, `DispatchTime` ASC LIMIT 0,1";
                    
                }else{
                    $sel = "SELECT * FROM `CrimeIncidents` WHERE `CrimeName` LIKE '%burglary%' AND `DistrictNumber` = $districtNumber ORDER BY `DispatchDate` DESC, `DispatchTime` ASC LIMIT 0,1";
                    
                    
                }
                
                $res = mysqli_query($connect->connect(), $sel);
                $arr = mysqli_fetch_array($res);
                
                $dist = $arr['DistrictNumber'];
                $dTime =  $arr['DispatchTime'];
                $dDate =  $arr['DispatchDate'];
                $aBlock = $utils->fixaddress($arr['AddressBlock']);
                $cName =  $arr['CrimeName'];
                $conT = $dDate." ".$dTime;
                $ctime = date('l F jS, h:i a', strtotime($conT));
                
                $patt1 = '/(?i)(Non-Residential)/is';
                
                if(preg_match($patt1,$cName)){
                    
                    // Non-Residential
                    if($districtNumber == 0){
                        
                        $sa = '<speak><p>The last reported burglary was '.$ctime.'. On the '.$aBlock.' in the '.$utils->addTH($dist).' police district. This incident has been reported as a non residential burglary.</p></speak>';
                        
                        
                    }else{
                        
                       
                        $sa = '<speak><p>The last reported burglary in the '.$utils->addTH($districtNumber).' police district was '.$ctime.'. On the '.$aBlock.'. This incident has been reported as a non residential burglary.</p></speak>';
                        
                    }
                    
                    
                    
                }else{
                    
                    if($districtNumber == 0){
                        
                       
                        $sa = '<speak><p>The last reported burglary was '.$ctime.'. On the '.$aBlock.' in the '.$utils->addTH($dist).' police district. This incident has been reported as a residential burglary.</p></speak>';
                        
                    }else{
                        
                        $sa = '<speak><p>The last reported burglary in the '.$utils->addTH($districtNumber).' police district was '.$ctime.'. On the '.$aBlock.'. This incident has been reported as a residential burglary.</p></speak>';
                        
                        
                    }
                    
                    
                }
                
                
                
                $say = array("version"=>"1.0","sessionAttributes"=>"",
                    "response"=>array("outputSpeech"=>array("type"=>"SSML","ssml"=>$sa),
                        "reprompt"=>null,"shouldEndSession"=>false));
                
                return json_encode($say);
                
                
            }
            
            
            
            if($crimeValue == "sexual assault"){
                
                if($districtNumber == 0){
                    $sel = "SELECT * FROM `CrimeIncidents` WHERE `CrimeName` LIKE '%sex%' ORDER BY `DispatchDate` DESC, `DispatchTime` ASC LIMIT 0,1";
                    
                    
                }else{
                    $sel = "SELECT * FROM `CrimeIncidents` WHERE `CrimeName` LIKE '%sex%' AND `DistrictNumber` = $districtNumber ORDER BY `DispatchDate` DESC, `DispatchTime` ASC LIMIT 0,1";
                    
                }
                
                $res = mysqli_query($connect->connect(), $sel);
                $arr = mysqli_fetch_array($res);
                
                $dist = $arr['DistrictNumber'];
                $dTime =  $arr['DispatchTime'];
                $dDate =  $arr['DispatchDate'];
                $aBlock = $utils->fixaddress($arr['AddressBlock']);
                $cName =  $arr['CrimeName'];
                $conT = $dDate." ".$dTime;
                $ctime = date('l F jS, h:i a', strtotime($conT));
                
                if($districtNumber == 0){
                    
                    $sa = '<speak><p>The last reported sexual assault was '.$ctime.'. On the '.$aBlock.' in the '.$utils->addTH($dist).' police district. This incident has been reported as other sex offenses, not commercialized.</p></speak>';
                    
                }else{
                    $sa = '<speak><p>The last reported sexual assault in the '.$utils->addTH($districtNumber).' police district was '.$ctime.'. On the '.$aBlock.'. This incident has been reported as other sex offenses, not commercialized.</p></speak>';
                    
                    
                }
                
                
                $say = array("version"=>"1.0","sessionAttributes"=>"",
                    "response"=>array("outputSpeech"=>array("type"=>"SSML","ssml"=>$sa),
                        "reprompt"=>null,"shouldEndSession"=>false));
                
                return json_encode($say);
                
                
            }
            
            if($crimeValue == "rape"){
                
                if($districtNumber == 0){
                    
                    $sel = "SELECT * FROM `CrimeIncidents` WHERE `CrimeName` LIKE '%rape%' ORDER BY `DispatchDate` DESC, `DispatchTime` ASC LIMIT 0,1";
                    
                }else{
                    $sel = "SELECT * FROM `CrimeIncidents` WHERE `CrimeName` LIKE '%rape%' AND `DistrictNumber` = $districtNumber ORDER BY `DispatchDate` DESC, `DispatchTime` ASC LIMIT 0,1";
                    
                }
                
                $res = mysqli_query($connect->connect(), $sel);
                $arr = mysqli_fetch_array($res);
                
                $dist = $arr['DistrictNumber'];
                $dTime =  $arr['DispatchTime'];
                $dDate =  $arr['DispatchDate'];
                $aBlock = $utils->fixaddress($arr['AddressBlock']);
                $cName =  $arr['CrimeName'];
                $conT = $dDate." ".$dTime;
                $ctime = date('l F jS, h:i a', strtotime($conT));
                
                if($districtNumber == 0){
                    
                    $sa = '<speak><p>The last reported rape was '.$ctime.'. On the '.$aBlock.' in the '.$utils->addTH($dist).' police district.</p></speak>';
                    
                }else{
                    $sa = '<speak><p>The last reported rape in the '.$utils->addTH($districtNumber).' police district was '.$ctime.'. On the '.$aBlock.'</p></speak>';
                    
                    
                }
                
                
                $say = array("version"=>"1.0","sessionAttributes"=>"",
                    "response"=>array("outputSpeech"=>array("type"=>"SSML","ssml"=>$sa),
                        "reprompt"=>null,"shouldEndSession"=>false));
                
                
                return json_encode($say);
                
                
            }
            
            
            if($crimeValue == "drugs"){
                
                if($districtNumber == 0){
                    $sel = "SELECT * FROM `CrimeIncidents` WHERE `CrimeName` LIKE '%narcotic%' ORDER BY `DispatchDate` DESC, `DispatchTime` ASC LIMIT 0,1";
                    
                    
                }else{
                    $sel = "SELECT * FROM `CrimeIncidents` WHERE `CrimeName` LIKE '%narcotic%' AND `DistrictNumber` = $districtNumber ORDER BY `DispatchDate` DESC, `DispatchTime` ASC LIMIT 0,1";
                    
                }
                
                $res = mysqli_query($connect->connect(), $sel);
                $arr = mysqli_fetch_array($res);
                
                $dist = $arr['DistrictNumber'];
                $dTime =  $arr['DispatchTime'];
                $dDate =  $arr['DispatchDate'];
                $aBlock = $utils->fixaddress($arr['AddressBlock']);
                $cName =  $arr['CrimeName'];
                $conT = $dDate." ".$dTime;
                $ctime = date('l F jS, h:i a', strtotime($conT));
                
                if($districtNumber == 0){
                    
                    $sa = '<speak><p>The last reported narcotic drug violation, was '.$ctime.'. On the '.$aBlock.' in the '.$utils->addTH($dist).' police district.</p></speak>';
                    
                }else{
                    
                    $sa = '<speak><p>The last narcotic drug violation in the '.$utils->addTH($districtNumber).' police district, was '.$ctime.'. On the '.$aBlock.'</p></speak>';
                    
                }
                
                
                $say = array("version"=>"1.0","sessionAttributes"=>"",
                    "response"=>array("outputSpeech"=>array("type"=>"SSML","ssml"=>$sa),
                        "reprompt"=>null,"shouldEndSession"=>false));
                
                return json_encode($say);
                
                
            }
            
            
            
            
        
        
        
    }
    
    function setCrimeID($CrimeID) { $this->CrimeID = $CrimeID; }
    function getCrimeID() { return $this->CrimeID; }
    function setTimeStamp($TimeStamp) { $this->TimeStamp = $TimeStamp; }
    function getTimeStamp() { return $this->TimeStamp; }
    function setDistrictNumber($DistrictNumber) { $this->DistrictNumber = $DistrictNumber; }
    function getDistrictNumber() { return $this->DistrictNumber; }
    function setPSAArea($PSAArea) { $this->PSAArea = $PSAArea; }
    function getPSAArea() { return $this->PSAArea; }
    function setDispatchTime($DispatchTime) { $this->DispatchTime = $DispatchTime; }
    function getDispatchTime() { return $this->DispatchTime; }
    function setDispatchDate($DispatchDate) { $this->DispatchDate = $DispatchDate; }
    function getDispatchDate() { return $this->DispatchDate; }
    function setAddress($Address) { $this->Address = $Address; }
    function getAddress() { return $this->Address; }
    function setCrimeType($CrimeType) { $this->CrimeType = $CrimeType; }
    function getCrimeType() { return $this->CrimeType; }
    function setCrimeCode($CrimeCode) { $this->CrimeCode = $CrimeCode; }
    function getCrimeCode() { return $this->CrimeCode; }
    function setLocationX($LocationX) { $this->LocationX = $LocationX; }
    function getLocationX() { return $this->LocationX; }
    function setLocationY($LocationY) { $this->LocationY = $LocationY; }
    function getLocationY() { return $this->LocationY; }
    
 
    
    
}





?>
