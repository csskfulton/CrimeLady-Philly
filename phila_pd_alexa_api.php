<?php
 
    define("MYSQL_SERVER", 'localhost');
    define("MYSQL_USERNAME", 'gerry');
    define("MYSQL_PASSWORD", 'Keithistheking');
    define("MYSQL_DATABASE",'PhillyPolice');
    
    $CONN = mysqli_connect(MYSQL_SERVER,MYSQL_USERNAME,MYSQL_PASSWORD,MYSQL_DATABASE);
    
    if(mysqli_connect_errno()){
        die($NO_CONNECTION. header('HTTP/1.1 403 Forbidden'));
    }
      
   
 ////////////////////////////////////////////////////////////////////////////////// START FUNCTIONS
    ////////////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////
    
    
    function writeToLog($var){
        file_put_contents('test.txt', $var."\n",FILE_APPEND);
    }
    
    file_put_contents('test.txt', $rot."\n",FILE_APPEND);
    

    function addTH($num){
        
        $final = $num."th";
        
            
        if($num == "1"){
            $final = "1st";
        }  
        if($num == "2"){
            $final = "2nd"; 
        }
        if($num == "22"){
            $final = "22nd";
        }
        if($num == "22"){
            $final = "22nd";
        }
        if($num == "3"){
            $final = "3rd";
        }
            
        return $final;
    }
    
        function cvNum($you){
            
            if(strpos($you,"000")>=1){
                $num_ar = explode("000",$you);
                $hun = $num_ar[0];
                return $hun." thousand";
                
            }else{
                
                $num_ar = explode("00",$you);
                $hun = $num_ar[0];
                return $hun." hundred";
                
        }
         
    }
    
    function fixAddress($location){
        
        $loc = $location;
        
        if(strpos($loc,"BLOCK")>=1){
            $arB = explode(" BLOCK ",$loc);
            $nADD = cvNum($arB[0])." block of ";
            $txt2 = $arB[1];
            
            
            if(preg_match('/^(E)(\s+)/is',$txt2)){
                $txt2 = preg_replace('/^(E)(\s+)/is', 'EAST ', $txt2,1);
            }
            if(preg_match('/^(N)(\s+)/is',$txt2)){
                $txt2 = preg_replace('/^(N)(\s+)/is', 'NORTH ', $txt2,1);
            }
            if(preg_match('/^(S)(\s+)/is',$txt2)){
                $txt2 = preg_replace('/^(S)(\s+)/is', 'SOUTH ', $txt2,1);
            }
            if(preg_match('/^(W)(\s+)/is',$txt2)){
                $txt2 = preg_replace('/^(W)(\s+)/is', 'WEST ', $txt2,1);
            }
            
            if(preg_match('/(\s+)(BLVD)/is',$txt2)){
                $txt2 = preg_replace('/(\s+)(BLVD)/is', ' BOULEVARD', $txt2,1);
            }
            if(preg_match('/(\s+)(ST)/is',$txt2)){
                $txt2 = preg_replace('/(\s+)(ST)/is', ' STREET', $txt2,1);
            }
            if(preg_match('/(\s+)(AV)/is',$txt2)){
                $txt2 = preg_replace('/(\s+)(AV)/is', ' AVENUE', $txt2,1);
            }
            if(preg_match('/(\s+)(RD)/is',$txt2)){
                $txt2 = preg_replace('/(\s+)(RD)/is', ' ROAD', $txt2,1);
            }
            if(preg_match('/(\s+)(LA)/is',$txt2)){
                $txt2 = preg_replace('/(\s+)(LA)/is', ' LANE', $txt2,1);
            }
            if(preg_match('/(\s+)(DR)/is',$txt2)){
                $txt2 = preg_replace('/(\s+)(DR)/is', ' DRIVE', $txt2,1);
            }
            if(preg_match('/(0)(\d)(TH)(\s+)/is',$txt2)){
                $txt2 = preg_replace('/(0)/is', '', $txt2,1);
            }
            if(preg_match('/(0)(\d)(RD)(\s+)/is',$txt2)){
                $txt2 = preg_replace('/(0)/is', '', $txt2,1);
            }
            if(preg_match('/(0)(\d)(ND)(\s+)/is',$txt2)){
                $txt2 = preg_replace('/(0)/is', '', $txt2,1);
            }
            
            $loc = $nADD.$txt2;
            
            
        }
        
        if(strpos($loc,"/") >= 1){
            $hals = explode("/ ", $loc);
            $lox = $hals[0];
            $loz = $hals[1];
            
            
            if(preg_match('/^(E)/is',$lox)){
                $lox = preg_replace('/^(E)/is', 'EAST', $lox,1);
            }
            if(preg_match('/^(N)/is',$lox)){
                $lox = preg_replace('/^(N)/is', 'NORTH', $lox,1);
            }
            if(preg_match('/^(S)/is',$lox)){
                $lox = preg_replace('/^(S)/is', 'SOUTH', $lox,1);
            }
            if(preg_match('/^(W)/is',$lox)){
                $lox = preg_replace('/^(W)/is', 'WEST', $lox,1);
            }
            if(preg_match('/(\s+)(BLVD)/is',$lox)){
                $lox = preg_replace('/(\s+)(BLVD)/is', ' BOULEVARD', $lox,1);
            }
            if(preg_match('/(\s+)(ST)/is',$lox)){
                $lox = preg_replace('/(\s+)(ST)/is', ' STREET', $lox,1);
            }
            if(preg_match('/(\s+)(AV)/is',$lox)){
                $lox = preg_replace('/(\s+)(AV)/is', ' AVENUE', $lox,1);
            }
            if(preg_match('/(\s+)(RD)/is',$lox)){
                $lox = preg_replace('/(\s+)(RD)/is', ' ROAD', $lox,1);
            }
            if(preg_match('/(\s+)(LA)/is',$lox)){
                $lox = preg_replace('/(\s+)(LA)/is', ' LANE', $lox,1);
            }
            if(preg_match('/(\s+)(DR)/is',$lox)){
                $lox = preg_replace('/(\s+)(DR)/is', ' DRIVE', $lox,1);
            }
            if(preg_match('/(0)(\d)(TH)(\s+)/is',$lox)){
                $lox = preg_replace('/(0)/is', '', $lox,1);
            }
            if(preg_match('/(0)(\d)(RD)(\s+)/is',$lox)){
                $lox = preg_replace('/(0)/is', '', $lox,1);
            }
            if(preg_match('/(0)(\d)(ND)(\s+)/is',$lox)){
                $lox = preg_replace('/(0)/is', '', $lox,1);
            }
            
            
            if(preg_match('/^(E)/is',$loz)){
                $loz = preg_replace('/^(E)/is', 'EAST', $loz,1);
            }
            if(preg_match('/^(N)/is',$loz)){
                $loz = preg_replace('/^(N)/is', 'NORTH', $loz,1);
            }
            if(preg_match('/^(S)/is',$loz)){
                $loz = preg_replace('/^(S)/is', 'SOUTH', $loz,1);
            }
            if(preg_match('/^(W)/is',$loz)){
                $loz = preg_replace('/^(W)/is', 'WEST', $loz,1);
            }
            if(preg_match('/(\s+)(BLVD)/is',$loz)){
                $loz = preg_replace('/(\s+)(BLVD)/is', ' BOULEVARD', $loz,1);
            }
            if(preg_match('/(\s+)(ST)/is',$loz)){
                $loz = preg_replace('/(\s+)(ST)/is', ' STREET', $loz,1);
            }
            if(preg_match('/(\s+)(AV)/is',$loz)){
                $loz = preg_replace('/(\s+)(AV)/is', ' AVENUE', $loz,1);
            }
            if(preg_match('/(\s+)(RD)/is',$loz)){
                $loz = preg_replace('/(\s+)(RD)/is', ' ROAD', $loz,1);
            }
            if(preg_match('/(\s+)(LA)/is',$loz)){
                $loz = preg_replace('/(\s+)(LA)/is', ' LANE', $loz,1);
            }
            if(preg_match('/(\s+)(DR)/is',$loz)){
                $loz = preg_replace('/(\s+)(DR)/is', ' DRIVE', $loz,1);
            }
            if(preg_match('/(0)(\d)(TH)(\s+)/is',$loz)){
                $loz = preg_replace('/(0)/is', '', $loz,1);
            }
            if(preg_match('/(0)(\d)(RD)(\s+)/is',$loz)){
                $loz = preg_replace('/(0)/is', '', $loz,1);
            }
            if(preg_match('/(0)(\d)(ND)(\s+)/is',$loz)){
                $loz = preg_replace('/(0)/is', '', $loz,1);
            }
            $loc = $lox." and ".$loz;
            
        }
        
        
        return $loc;
        
    }
    
    
    function cleanUpHTML($ret){ // USED TO TRIM (HTML) THE DESCRIPTION OF THE NEW STORY
        
        $fire = $ret;
        
        if(strpos($fire,"&#8217;") >=1){
            $fire = str_replace("&#8217;","'",$fire);
        }
        
        if(strpos($fire,"&#8243;") >=1){
            $fire = str_replace("&#8243;","'",$fire);
        }
        if(strpos($fire,"&#8220;") >=1){
            $fire = str_replace("&#8220;","'",$fire);
        }
        
        if(strpos($fire,"&#8221;") >=1){
            $fire = str_replace("&#8221;","'",$fire);
        }
        if(strpos($fire,"&#8242;") >=1){
            $fire = str_replace("&#8242;","'",$fire);
        }
        
        return $fire;
    }
    
    
    function cleanTxT($fgg){
        $coo = cleanUpHTML($fgg);
        
        $nURL = "https://www.phillypolice.com/news";
        $nURL1 = 'www.phillypolice.com/news,';
        
        $nin = "contact 911";
        $nin1 = 'contact <say-as interpret-as="digits">911</say-as>';
        
        $noi = "call 911";
        $noi1 = 'call <say-as interpret-as="digits">911</say-as>';
        
        $numf = '215.686.TIPS (8477)';
        $numf1 = '215-686-8477';
        
        $tNum = '773847';
        $tNum1 = '<say-as interpret-as="digits">773847</say-as>';
        
        $rmE = "Use this electronic form to submit a tip anonymously.";
        
        
        $dX = '&#215;';
        $aX = '&#8216;';
        
        $andP = '&';
        $ampp = 'amp;';
        
        $det = 'Det.';
        $det1 = 'Detective';
        
        $asp = "'-";
        $aspX = "' to ";
        
        $fbi = "FBI/PPD";
        $fbiX = "FBI's Philadelphia Police Department";
        
        if(strpos($coo,$nURL) >= 1){
            $coo = str_replace($nURL,$nURL1,$coo);
        }
        if(strpos($coo,$nin) >= 1){
            $coo = str_replace($nin,$nin1,$coo);
        }
        if(strpos($coo,$noi) >= 1){
            $coo = str_replace($noi,$noi1,$coo);
        }
        if(strpos($coo,$numf) >= 1){
            $coo = str_replace($numf,$numf1,$coo);
        }
        if(strpos($coo,$tNum) >= 1){
            $coo = str_replace($tNum,$tNum1,$coo);
        }
        if(strpos($coo,$rmE) >= 1){
            $coo = str_replace($rmE,"",$coo);
        }
        if(strpos($coo,$dX) >= 1){
            $coo = str_replace($dX,"X",$coo);
        }
        if(strpos($coo,$aX) >= 1){
            $coo = str_replace($aX,"'",$coo);
        }
        if(strpos($coo,$andP) >= 1){
            $coo = str_replace($andP,"and",$coo);
        }
        if(strpos($coo,$det) >= 1){
            $coo = str_replace($det,$det1,$coo);
        }
        if(strpos($coo,$ampp) >= 1){
            $coo = str_replace($ampp,'',$coo);
        }
        if(strpos($coo,$fbi) >= 1){
            $coo = str_replace($fbi,$fbiX,$coo);
        }
        if(strpos($coo,$asp) >= 1){
            $coo = str_replace($asp,$aspX,$coo);
        }
        
        $badg = '/(3)(\d)(\d)(\d)(\s+)(Detective)(\s+)((?:[A-Za-z]+))(\s+#\d{3,4}|#\d{3,4})/is';
        $bagg1 = '/(Detective)(\s+)((?:[A-Za-z]+))(\s+)(#\d{3,4})/is';
        
        if(preg_match_all($badg,$coo,$matches,PREG_PATTERN_ORDER)){
            $dpt = $matches[0];
            //print_r($matches);
            foreach($dpt as $thT){
                
                $arr = explode(" ",$thT);
                
                $ctV = strlen($arr[3]);
                //print_r($arr[3]);
                if($ctV == "4"){
                    $nArr = str_split($arr[3]);
                    $cCa = "#".$nArr[1]." ".$nArr[2].$nArr[3];
                    $trr = str_replace($arr[3],$cCa,$thT);
                }
                if($ctV == "5"){
                    $cn = str_replace("#","",$arr[3]);
                    $dArr = str_split($cn,2);
                    $cCx = "#".$dArr[0]." ".$dArr[1];
                    $trr = str_replace($arr[3],$cCx,$thT);
                }
                
                
                //$gVal = substr($ctV,);
                $att = ', to the attention of, ';
                $ckp = str_replace($arr[1],$att.$arr[1],$trr);
                $nStr = str_replace(" #",", badge #",$ckp);
                $coo = str_replace($thT,$nStr,$coo);
                
                
                
                
            }
        }
        
        if(preg_match_all($bagg1,$coo,$matches,PREG_PATTERN_ORDER)){
            $mag = $matches[0];
            foreach($mag as $fot){
                $spa = explode(" ",$fot);
                $nums = $spa[2];
                $nNx = str_replace("#","",$nums);
                $spN = str_split($nNx,2);
                $cvV = "#".$spN[0]." ".$spN[1];
                $end = str_replace($nums,"badge ".$cvV,$fot);
                $coo = str_replace($fot,$end,$coo);
                
            }
            
        }
        
        
        
        //SVU
        $svu = '215-685-3251/3252';
        $svuX = '215-685-3251 or, <say-as interpret-as="digits">3252</say-as>';
        
        if(strpos($coo,$svu) >= 1){
            $coo = str_replace($svu,$svuX,$coo);
        }
        
        //South
        $dtS = '215-686-3013/3014';
        $dtS1 = '215-686-3013/ 3014';
        $dtS2 = '215-686-3013/14';
        $dtSx = '215-686-3013 or, <say-as interpret-as="digits">3014</say-as>';
        
        if(strpos($coo,$dtS) >= 1){
            $coo = str_replace($dtS,$dtSx,$coo);
        }
        if(strpos($coo,$dtS1) >= 1){
            $coo = str_replace($dtS1,$dtSx,$coo);
        }
        if(strpos($coo,$dt2) >= 1){
            $coo = str_replace($dtS2,$dtSx,$coo);
        }
        
        //Southwest
        $dtSW = '215-686-3183/3184';
        $dtSW1 = '215-686-3183/ 3184';
        $dtSW2 = '215-686-3183/84';
        $dtSWx = '215-686-3183 or, <say-as interpret-as="digits">3184</say-as>';
        
        if(strpos($coo,$dtSW) >= 1){
            $coo = str_replace($dtSW,$dtSWx,$coo);
        }
        if(strpos($coo,$dtSW1) >= 1){
            $coo = str_replace($dtSW1,$dtSWx,$coo);
        }
        if(strpos($coo,$dtSW2) >= 1){
            $coo = str_replace($dtSW2,$dtSWx,$coo);
        }
        
        //East
        $dtE = '215-686-3243/3244';
        $dtE1 = '215-686-3243/ 3244';
        $dtE2 = '215-686-3243/44';
        $dtE3 = '215-686-3242/3244';
        $dtE4 = '215-686-3343/3344';
        $dtEx = '215-686-3243 or, <say-as interpret-as="digits">3244</say-as>';
        
        if(strpos($coo,$dtE) >= 1){
            $coo = str_replace($dtE,$dtEx,$coo);
        }
        if(strpos($coo,$dtE1) >= 1){
            $coo = str_replace($dtE1,$dtEx,$coo);
        }
        if(strpos($coo,$dtE2) >= 1){
            $coo = str_replace($dtE2,$dtEx,$coo);
        }
        if(strpos($coo,$dtE3) >= 1){
            $coo = str_replace($dtE3,$dtEx,$coo);
        }
        if(strpos($coo,$dtE4) >= 1){
            $coo = str_replace($dtE4,$dtEx,$coo);
        }
        
        //Central
        $dtC = '215-686-3093/3094';
        $dtC1 = '215-686-3093/ 3094';
        $dtC2 = '215-686-3093/94';
        $dtCx = '215-686-3093 or, <say-as interpret-as="digits">3094</say-as>';
        
        if(strpos($coo,$dtC) >= 1){
            $coo = str_replace($dtC,$dtCx,$coo);
        }
        if(strpos($coo,$dtC1) >= 1){
            $coo = str_replace($dtC1,$dtCx,$coo);
        }
        if(strpos($coo,$dtC2) >= 1){
            $coo = str_replace($dtC2,$dtCx,$coo);
        }
        
        //Northwest
        $dtN = '215-686-3353/3354';
        $dtN1 = '215-686-3353/ 3354';
        $dtN2 = '215-686-3353/54';
        $dtNx = '215-686-3353 or, <say-as interpret-as="digits">3354</say-as>';
        
        if(strpos($coo,$dtN) >= 1){
            $coo = str_replace($dtN,$dtNx,$coo);
        }
        if(strpos($coo,$dtN1) >= 1){
            $coo = str_replace($dtN1,$dtNx,$coo);
        }
        if(strpos($coo,$dtN2) >= 1){
            $coo = str_replace($dtN2,$dtNx,$coo);
        }
        
        //Northeast
        $dtNE = '215-686-3153/3154';
        $dtNE1 = '215-686-3153/ 3154';
        $dtNE2 = '215-686-3153/54';
        $dtNEx = '215-686-3153 or, <say-as interpret-as="digits">3154</say-as>';
        
        if(strpos($coo,$dtNE) >= 1){
            $coo = str_replace($dtNE,$dtNEx,$coo);
        }
        if(strpos($coo,$dtNE1) >= 1){
            $coo = str_replace($dtNE1,$dtNEx,$coo);
        }
        if(strpos($coo,$dtNE2) >= 1){
            $coo = str_replace($dtNE2,$dtNEx,$coo);
        }
        
        ////FIX DC #s
        $witH = '/(DC)(\s+)(#)(\d)(\d)(-)(\d)(\d)(-)(\d)(\d)(\d)(\d)(\d)(\d)/is';
        $witOH = '/(DC)(\s+)(\d+)(-)(\d+)(-)(\d)(\d)(\d)(\d)(\d)(\d)/is';
        
        
        #DC Number with Haah
        if(preg_match_all($witH,$coo, $matches,PREG_PATTERN_ORDER)){
            
            if($matches[0] !== ''){
                
                $vR = $matches[0];
                foreach($vR as $foot){
                    $dsp =  explode("-",$foot);
                    $ctt = str_split($dsp[2],2);
                    $end = ", ".$dsp[0]." ".$dsp[1]." ".$ctt[0]." ".$ctt[1]." ".$ctt[2];
                    $coo = str_replace($foot,$end,$coo);
                }
                
            }
            
        }
        #DC Number with OUT Haah
        if(preg_match_all($witOH, $coo, $matches,PREG_PATTERN_ORDER)){
            
            if($matches[0] !== ''){
                
                $vP = $matches[0];
                
                foreach($vP as $dog){
                    $hal = explode(" ",$dog);
                    $nu = $hal[0];
                    $nu1 = $hal[1];
                    $ddp = explode("-",$nu1);
                    $cxx = str_split($ddp[2],2);
                    $nsT = str_replace($dog,"#".$ddp[0]." ".$ddp[1]." ".$cxx[0]." ".$cxx[1]." ".$cxx[2],$dog);
                    $fNN = ", DC ".$nsT;
                    $coo = str_replace($dog,$fNN,$coo);
                }
                
            }
        }
        
        
        
        //Rid this "(1)"
        if(preg_match_all('/(\()(\d+)(\))/is',$coo,$matches,PREG_PATTERN_ORDER)){
            $fsl = $matches[0];
            foreach($fsl as $jon){
                $coo = str_replace($jon,"",$coo);
            }
        }
        
        
        //Bloc hundred  "3400 hundred"
        $thou = '/(\d)([1-9])(0)(0)\s+(block)/is';
        
        if(preg_match_all($thou,$coo,$matches,PREG_PATTERN_ORDER)){
            $stf = $matches[0];
            foreach($stf as $tuff){
                $fp = str_replace("00"," hundred",$tuff);
                $coo = str_replace($tuff,$fp,$coo);
            }
        }
        
        $bPh = '/(215)(-)(686)(-)(\d)(\d)(\d)(\d)(\/)(\s+)/is';
        //Number clean up
        if(preg_match_all($bPh,$coo,$matches,PREG_PATTERN_ORDER)){
            $ma = $matches[0];
            foreach($ma as $fdd){
                $dfiX = str_replace("/","",$fdd);
                $coo = str_replace($fdd,$dfiX,$coo);
            }
        }
        
        ///OPPPPSSS!
        
        
        
        
        
        
        
        
        return $coo;
        
    }
    
    
            function getAPI_Info($d_url){
    
                $curl = curl_init($d_url);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
                curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
                $curl_response = curl_exec($curl);
                curl_close($curl);
                return json_decode($curl_response, true);
    
            }
            
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
    
            function fetchSootArray($arr){ 
                   $txt = ""; 
                foreach($arr as $feet){
                            
                    $d_id = $feet['cartodb_id'];
                    $obj_id = $feet['objectid'];
                    $year = $feet['year'];
                    $dc_num = $feet['dc_key'];
                    $c_code = $feet['code'];
                    $d_date = $feet['date_'];
                    $race = $feet['race'];
                    $gen = $feet['sex'];
                    $age = $feet['age'];
                    $wound = "in the ".$feet['wound'];
                    $isOffI = $feet['officer_involved'];
                    $isOffenInj = $feet['offender_injured'];
                    $isOffDead = $feet['offender_deceased'];
                    $location = $feet['location'];
                    $latino = $feet['latino'];
                    $pointx = $feet['point_x'];
                    $pointy = $feet['point_y'];
                    $dist = $feet['dist'];
                    $time_d = $feet['time'];
                    $in = $feet['inside'];
                    $out = $feet['outside'];
                    $fatal = $feet['fatal'];
                    
                    if(strpos($wound,"abdom") !== false){
                        $wound = "in the abdomen";
                    }
                    if(strpos($wound,"multi") !== false){
                        $wound = "multiple times";
                    }
                    if(strpos($wound,"multi/head") !== false){
                        $wound = "in the head and multiple times in the body";
                    }
                    if(strpos($wound,"head/multi") !== false){
                        $wound = "in the head and multiple times in the body";
                    }
                    if(strpos($wound,"shoul") !== false){
                        $wound = "in the shoulder";
                    }
                    if(strpos($wound,"head/back") !== false){
                        $wound = "in the head and back";
                    }
                    if(strpos($wound,"head/mullt") !== false){
                        $wound = "in the head and multiple times in the body";
                    }
                    if(strpos($wound,"mullti") !== false){
                        $wound = "multiple times";
                    }
                    if(strpos($wound,"multi/face") !== false){
                        $wound = "in the face and multiple times in the body";
                    }
                    if(strpos($wound,"shouldr") !== false){
                        $wound = "in the shoulder";
                    }
                    if(strpos($wound,"head/mullt") !== false){
                        $wound = "in the head and multiple times in the body";
                    }
                    if(strpos($wound,"cheat") !== false){
                        $wound = "in the cheek";
                    }
                    if(strpos($wound,"Multi") !== false){
                        $wound = "multiple times";
                    }
                    if(strpos($wound,"multi leg") !== false){
                        $wound = "in the leg and multiple times in the body";
                    }
                    if(strpos($wound,"chest/back") !== false){
                        $wound = "in the chest and back";
                    }
                    if(strpos($wound,"back/head") !== false){
                        $wound = "in the chest and back";
                    }
                   
                    $timeF = date("g:i a", strtotime($time_d));
                    
                    $zaq = explode("T",$d_date);
                    $old_date = date($zaq[0]);
                    $old_date_timestamp = strtotime($old_date);
                    $daa = date('l F jS', $old_date_timestamp);
                    
                    
                    if($race == "W" && $latino == "1"){
                        $pol = "latino";
                    }
                    
                    if($race == "W" && $latino == "0"){
                        $pol = "white";
                    }
                    
                    if($race == "B"){
                        $pol = "black";
                    }
                    
                    if($gen == "M"){
                        $sex = "male";
                    }
                    if($gen == "W"){
                        $sex = "women";
                    }
                    
                    
                    $location = fixAddress($location);
           
                    
                    $txt .= "<p>In the ".$dist."th district, on ".$daa.", around ".$timeF.", A ".$pol." ".$sex.", age ".$age.", was wounded ".$wound.", on the ".$location."</p>";
                    //array_push($array,$txt);
                            
                }
                
                return $txt;
            
            }
    
    
    
    
    
    
    
    
    function dateDifference($date_1 , $date_2 , $differenceFormat = '%a' ){
        
        $datetime1 = date_create($date_1);
        $datetime2 = date_create($date_2);
        
        $interval = date_diff($datetime1, $datetime2);
        
        return $interval->format($differenceFormat);
        
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
  
 
    
        $data = json_decode(file_get_contents('php://input'),true);
        $rot = file_get_contents('php://input');
        writeToLog($rot);
    
        $itReq = $data['request']['type'];
        $itNam = $data['request']['intent']['name'];
        $itDis = $data['request']['dialogState'];
    
    
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

        
    if($itReq == "IntentRequest" && $itNam == "fetchStats"){
  
                        
            $prT = $data['request']['intent']['slots']['presentTime']['resolutions']['resolutionsPerAuthority'][0]['status']['code'];
            $pio = $data['request']['intent']['slots']['presentTime']['resolutions']['resolutionsPerAuthority'][0]['values'][0]['value']['name'];
            $diss = $data['request']['intent']['slots']['district']['resolutions']['resolutionsPerAuthority'][0]['status']['code'];
            $d_val = $data['request']['intent']['slots']['district']['resolutions']['resolutionsPerAuthority'][0]['values'][0]['value']['name'];
            $crT = $data['request']['intent']['slots']['crimeType']['resolutions']['resolutionsPerAuthority'][0]['values'][0]['value']['name'];
            $isRob = $data['request']['intent']['slots']['crimeType']['resolutions']['resolutionsPerAuthority'][0]['status']['code'];
            
            
            
            if($prT == "ER_SUCCESS_MATCH"){ //PRESENT TIME IS TRUE (TODAY | YESTERDAY | WEEK )
               
                //date_default_timezone_set('US/Eastern');
                
                
                if($pio == "today"){
                    
                    $td2 = date('Y-m-d');
                    
                        if($isRob == "ER_SUCCESS_MATCH"){ /// MATCH CRIMETYPE
                            
                            
                            if($crT == "shootings"){
                                
                                // GRAB THE LATEST RECORD DATE FIRST
                                $curl_jason2 = getAPI_Info('https://phl.carto.com/api/v2/sql?q=SELECT%20date_%20FROM%20shootings%20ORDER%20%20BY%20date_%20DESC%20NULLS%20LAST%20LIMIT%20%201');
                                $h_dat = $curl_jason2['rows'][0]['date_'];
                                $d_ha = explode("T",$h_dat);
                                $td1 = $d_ha[0];
                                writeToLog("LAST SHOOTING DATE: ".$td1);
    
                                // USING DATE TO FETCH NEW RECORDS
                                $f_more = getAPI_Info('https://phl.carto.com/api/v2/sql?q=SELECT%20count%20(date_)%20FROM%20shootings%20WHERE%20date_%20=%20%27'.$td1.'%27');
                                $s_ctz = $f_more['rows'][0]['count'];
                                writeToLog("QUERY TO SERVER: ".'https://phl.carto.com/api/v2/sql?q=SELECT%20count%20(date_)%20FROM%20shootings%20WHERE%20date_%20=%20%27'.$td1.'%27');
    
                                // DOING DATE MATH; CHECKING AGE
                                date_default_timezone_set('US/Eastern');
                                $td2 = date('Y-m-d');
                                $x_ago = dateDifference($td1,$td2,"%d days");
    
                                $old_date = date($td1);
                                $old_date_timestamp = strtotime($old_date);
                                $daa = date('l F jS', $old_date_timestamp);
    
                                    // IF ONLY ONE RECORD EXIST
                                    if($s_ctz == 1){
    
                                        if($x_ago == "1 days"){
                                            /// IF ONE SHOOTING AND ONE DAY AGO
                                            $x_ago = 'yesterday';
                                            $txxt = '<speak><p>I do not have any shootings to report today.</p><p>However, there was '.$s_ctz.' shooting '.$x_ago.', '.$daa.'</p><p>Would you like to hear the details</p></speak>';
    
                                        }else{
                                            //// IF MULTI SHOOTINGS AND ONE DAY
                                            $txxt = '<speak><p>I do not have any shootings to report today.</p><p>However, there was '.$s_ctz.' shootings '.$x_ago.' ago, '.$daa.'</p><p>Would you like to hear the details</p></speak>';
    
                                        }
    
    
                                    }else{
                                        $txxt = '<speak><p>I do not have any shootings to report today.</p><p>However, there were '.$s_ctz.' shootings '.$x_ago.' ago, '.$daa.'</p><p>Would you like to hear the details</p></speak>';
    
                                    }
    
                                    $txt = array("version"=>"1.0","sessionAttributes"=>array("shooting"=>"true","shootingDate"=>$td1,"shootingCount"=>$s_ctz),"response"=>array("outputSpeech"=>array("type"=>"SSML","ssml"=>$txxt),"reprompt"=>null,"shouldEndSession"=>false));
    
                                    echo json_encode($txt);
                                
                            }
                            
                          //////END SHOOTING  
                            
                            else{
                         
                            $ret = '';
                            
                            $tyArr = array();
                            $sRob = 'SELECT `Name` FROM `CrimeTypes` WHERE `Type` = '."'".$crT."'";
                            $sRes = mysqli_query($CONN, $sRob);
                            
                            if(mysqli_num_rows($sRes) >= 1){
                                
                                while($tows = mysqli_fetch_array($sRes)){
                                    $nam = $tows['Name'];
                                    array_push($tyArr,$nam);
                                }
                                
                                $sir = implode("','", $tyArr);
                                $fin = "'".$sir."'";
                                $td2 = date('Y-m-d');
                                
                                
                                if($d_val !== null){
                                    $sql_x = 'SELECT * FROM `CrimeIncidents` WHERE `CrimeName` IN ('.$fin.') AND `DispatchDate` = '.$td2.' AND `DistrictNumber` = '.$d_val.' ORDER BY `DispatchTime` DESC';
                                }else{
                                    $sql_x = 'SELECT * FROM `CrimeIncidents` WHERE `CrimeName` IN ('.$fin.') AND `DispatchDate` = '.$td2.' ORDER BY `DispatchTime` DESC';
                                    
                                }
                                
                                $resx = mysqli_query($CONN, $sql_x);
                                
                                if(mysqli_num_rows($resx) >= 1){
                                    /// ASSAULTS DO EXIST TODAY
                                    
                                }else{
                                    
                                    if($d_val !== null){
                                        $l_sql = 'SELECT `DispatchDate` FROM `CrimeIncidents` WHERE `CrimeName`IN ('.$fin.') AND `DistrictNumber` = '.$d_val.' ORDER BY `DispatchDate` DESC LIMIT 0,1';
                                        
                                    }else{
                                        $l_sql = 'SELECT `DispatchDate` FROM `CrimeIncidents` WHERE `CrimeName`IN ('.$fin.') ORDER BY `DispatchDate` DESC LIMIT 0,1';
                                        
                                    }
                                    
                                    $lres = mysqli_query($CONN, $l_sql);
                                    
                                    if(mysqli_num_rows($lres) >= 1){
                                        
                                        $drow = mysqli_fetch_array($lres);
                                        $f_date = $drow['DispatchDate'];
                                        
                                        if($d_val !== null){
                                            $m_sql = 'SELECT COUNT(`DispatchDate`) AS d_Count FROM `CrimeIncidents` WHERE `DispatchDate` = '."'".$f_date."'".' AND `CrimeName` IN ('.$fin.') AND `DistrictNumber` = '.$d_val.'';
                                            
                                        }else{
                                            $m_sql = 'SELECT COUNT(`DispatchDate`) AS d_Count FROM `CrimeIncidents` WHERE `DispatchDate` = '."'".$f_date."'".' AND `CrimeName` IN ('.$fin.')';
                                            
                                        }
                                        
                                        $ref = mysqli_query($CONN, $m_sql);
                                        
                                        if(mysqli_num_rows($ref) >= 1){
                                            $c_arr = mysqli_fetch_array($ref);
                                            $ctc = $c_arr['d_Count'];
                                            date_default_timezone_set('US/Eastern');
                                            $td2 = date('Y-m-d');
                                            $x_ago = dateDifference($f_date,$td2,"%d days");
                                            $cvv = strtotime($f_date);
                                            $nDate = date('l F jS ',$cvv);
                                            
                                            
                                            /// IF ONE ONLY ONE RECORD RETURN
                                            if($ctc == 1 && $x_ago == "1 days"){
                                                
                                                if($crT == "assault"){
                                                    
                                                    if($d_val == null){
                                                        $say = '<speak><p>There are no assaults to report today at this time. However, there is '.$ctc.' reported assault yesterday, '.$nDate.', would you like to hear the details?</p></speak>';
                                                        
                                                    }else{
                                                        $say = '<speak><p>In the '.addTH($d_val).' district, There are no assaults to report today at this time. However, there is '.$ctc.' reported assault yesterday, '.$nDate.', would you like to hear the details?</p></speak>';
                                                        
                                                    }
                                                    
                                                }
                                                if($crT == "theft"){
                                                    
                                                    if($d_val == null){
                                                        $say = '<speak><p>There are no thefts to report today at this time. However, there is '.$ctc.' reported theft yesterday, '.$nDate.', would you like to hear the details?</p></speak>';
                                                        
                                                    }else{
                                                        $say = '<speak><p>In the '.addTH($d_val).' district, There are no thefts to report today at this time. However, there is '.$ctc.' reported theft yesterday, '.$nDate.', would you like to hear the details?</p></speak>';
                                                        
                                                    }
                                                    
                                                }
                                                if($crT == "robbery"){
                                                    
                                                    if($d_val == null){
                                                        $say = '<speak><p>I do not have any robberies to report today at this time. However, there is '.$ctc.' reported robbery yesterday, '.$nDate.', would you like to hear the details?</p></speak>';
                                                        
                                                    }else{
                                                        $say = '<speak><p>In the '.addTH($d_val).' district, I do not have any robberies to report today at this time. However, there is '.$ctc.' reported robbery yesterday, '.$nDate.', would you like to hear the details?</p></speak>';
                                                        
                                                    }
                                                    
                                                }
                                                if($crT == "burglary"){
                                                    
                                                    if($d_val == null){
                                                        $say = '<speak><p>There are no burglaries to report today at this time. However, there is '.$ctc.' reported burglary yesterday, '.$nDate.', would you like to hear the details?</p></speak>';
                                                        
                                                    }else{
                                                        $say = '<speak><p>In the '.addTH($d_val).' district, There are no burglaries to report today at this time. However, there is '.$ctc.' reported burglary yesterday, '.$nDate.', would you like to hear the details?</p></speak>';
                                                        
                                                    }
                                                    
                                                }
                                                if($crT == "homicide"){
                                                    
                                                    if($d_val == null){
                                                        $say = '<speak><p>There are no homicides to report today at this time. However, there is '.$ctc.' reported homicide yesterday, '.$nDate.', would you like to hear the details?</p></speak>';
                                                        
                                                    }else{
                                                        $say = '<speak><p>In the '.addTH($d_val).' district, There are no homicides to report today at this time. However, there is '.$ctc.' reported homicide yesterday, '.$nDate.', would you like to hear the details?</p></speak>';
                                                        
                                                    }
                                                    
                                                }
                                                if($crT == "sexual assault"){
                                                    
                                                    if($d_val == null){
                                                        $say = '<speak><p>There are no sexual assaults to report today at this time. However, there is '.$ctc.' reported sexual assault yesterday, '.$nDate.', would you like to hear the details?</p></speak>';
                                                        
                                                    }else{
                                                        $say = '<speak><p>In the '.addTH($d_val).' district, There are no sexual assaults to report today at this time. However, there is '.$ctc.' reported sexual assault yesterday, '.$nDate.', would you like to hear the details?</p></speak>';
                                                        
                                                    }
                                                    
                                                }
                                                if($crT == "drugs"){
                                                    
                                                    if($d_val == null){
                                                        $say = '<speak><p>there are no drugs, or narcotic law violations to report today at this time. However, there is '.$ctc.' reported drug, or narcotic law violation yesterday, '.$nDate.', would you like to hear the details?</p></speak>';
                                                        
                                                    }else{
                                                        $say = '<speak><p>In the '.addTH($d_val).' district, There are no drugs, or narcotic law violations to report today at this time. However, there is '.$ctc.' reported drug, or narcotic law violation yesterday, '.$nDate.', would you like to hear the details?</p></speak>';
                                                        
                                                    }
                                                    
                                                }
                                            }else if($ctc > 1 && $x_ago == "1 days"){
                                                
                                                if($crT == "assault"){
                                                    
                                                    if($d_val == null){
                                                        $say = '<speak><p>There are no assaults to report today at this time. However, there was '.$ctc.' reported assaults yesterday, '.$nDate.', would you like to hear the details?</p></speak>';
                                                        
                                                    }else{
                                                        $say = '<speak><p>In the '.addTH($d_val).' district, There are no assaults to report today at this time. However, there was '.$ctc.' reported assault yesterday, '.$nDate.', would you like to hear the details?</p></speak>';
                                                        
                                                    }
                                                    
                                                }
                                                if($crT == "theft"){
                                                    
                                                    if($d_val == null){
                                                        $say = '<speak><p>There are no thefts to report today at this time. However, there was '.$ctc.' reported thefts yesterday, '.$nDate.', would you like to hear the details?</p></speak>';
                                                        
                                                    }else{
                                                        $say = '<speak><p>In the '.addTH($d_val).' district, There are no thefts to report today at this time. However, there was '.$ctc.' reported theft yesterday, '.$nDate.', would you like to hear the details?</p></speak>';
                                                        
                                                    }
                                                    
                                                }
                                                if($crT == "robbery"){
                                                    
                                                    if($d_val == null){
                                                        $say = '<speak><p>I do not have any robberies to report today at this time. However, there was '.$ctc.' reported robberies yesterday, '.$nDate.', would you like to hear the details?</p></speak>';
                                                        
                                                    }else{
                                                        $say = '<speak><p>In the '.addTH($d_val).' district, I do not have any robberies to report today at this time. However, there was '.$ctc.' reported robbery yesterday, '.$nDate.', would you like to hear the details?</p></speak>';
                                                        
                                                    }
                                                    
                                                }
                                                if($crT == "burglary"){
                                                    
                                                    if($d_val == null){
                                                        $say = '<speak><p>There are no burglaries to report today at this time. However, there was '.$ctc.' reported burglaries yesterday, '.$nDate.', would you like to hear the details?</p></speak>';
                                                        
                                                    }else{
                                                        $say = '<speak><p>In the '.addTH($d_val).' district, There are no burglaries to report today at this time. However, there was '.$ctc.' reported burglary yesterday, '.$nDate.', would you like to hear the details?</p></speak>';
                                                        
                                                    }
                                                    
                                                }
                                                if($crT == "homicide"){
                                                    
                                                    if($d_val == null){
                                                        $say = '<speak><p>There are no homicides to report today at this time. However, there was '.$ctc.' reported homicides yesterday, '.$nDate.', would you like to hear the details?</p></speak>';
                                                        
                                                    }else{
                                                        $say = '<speak><p>In the '.addTH($d_val).' district, There are no homicides to report today at this time. However, there was '.$ctc.' reported homicide yesterday, '.$nDate.', would you like to hear the details?</p></speak>';
                                                        
                                                    }
                                                    
                                                }
                                                if($crT == "sexual assault"){
                                                    
                                                    if($d_val == null){
                                                        $say = '<speak><p>There are no sexual assaults to report today at this time. However, there was '.$ctc.' reported sexual assaults yesterday, '.$nDate.', would you like to hear the details?</p></speak>';
                                                        
                                                    }else{
                                                        $say = '<speak><p>In the '.addTH($d_val).' district, There are no sexual assaults to report today at this time. However, there was '.$ctc.' reported sexual assault yesterday, '.$nDate.', would you like to hear the details?</p></speak>';
                                                        
                                                    }
                                                    
                                                }
                                                if($crT == "drugs"){
                                                    
                                                    if($d_val == null){
                                                        $say = '<speak><p>There are no drugs, or narcotic law violations to report today at this time. However, there was '.$ctc.' reported drug or narcotic law violations yesterday, '.$nDate.', would you like to hear the details?</p></speak>';
                                                        
                                                    }else{
                                                        $say = '<speak><p>In the '.addTH($d_val).' district, There are no drug, or narcotic law violations to report today at this time. However, there was '.$ctc.' reported drug, or narcotic law violation, '.$nDate.', would you like to hear the details?</p></speak>';
                                                        
                                                    }
                                                    
                                                }
                                                
                                            }else if($ctc == 1){
                                                
                                                if($crT == "assault"){
                                                    
                                                    if($d_val == null){
                                                        $say = '<speak><p>There are no assaults to report today at this time. However, there is '.$ctc.' reported assault '.$x_ago.' ago, '.$nDate.', would you like to hear the details?</p></speak>';
                                                        
                                                    }else{
                                                        $say = '<speak><p>In the '.addTH($d_val).' district, There are no assaults to report today at this time. However, there is '.$ctc.' reported assault '.$x_ago.' ago, '.$nDate.', would you like to hear the details?</p></speak>';
                                                        
                                                    }
                                                    
                                                }
                                                if($crT == "theft"){
                                                    
                                                    if($d_val == null){
                                                        $say = '<speak><p>There are no thefts to report today at this time. However, there is '.$ctc.' reported theft '.$x_ago.' ago, '.$nDate.', would you like to hear the details?</p></speak>';
                                                        
                                                    }else{
                                                        $say = '<speak><p>In the '.addTH($d_val).' district, There are no thefts to report today at this time. However, there is '.$ctc.' reported theft '.$x_ago.' ago, '.$nDate.', would you like to hear the details?</p></speak>';
                                                        
                                                    }
                                                    
                                                }
                                                if($crT == "robbery"){
                                                    
                                                    if($d_val == null){
                                                        $say = '<speak><p>I do not have any robberies to report today at this time. However, there is '.$ctc.' reported robbery '.$x_ago.' ago, '.$nDate.', would you like to hear the details?</p></speak>';
                                                        
                                                    }else{
                                                        $say = '<speak><p>In the '.addTH($d_val).' district, I do not have any robberies to report today at this time. However, there is '.$ctc.' reported robbery '.$x_ago.' ago, '.$nDate.', would you like to hear the details?</p></speak>';
                                                        
                                                    }
                                                    
                                                }
                                                if($crT == "burglary"){
                                                    if($d_val == null){
                                                        $say = '<speak><p>There are no burglaries to report today at this time. However, there is '.$ctc.' reported burglary '.$x_ago.' ago, '.$nDate.', would you like to hear the details?</p></speak>';
                                                        
                                                    }else{
                                                        $say = '<speak><p>In the '.addTH($d_val).' district, There are no burglaries to report today at this time. However, there is '.$ctc.' reported burglary '.$x_ago.' ago, '.$nDate.', would you like to hear the details?</p></speak>';
                                                        
                                                    }
                                                    
                                                }
                                                if($crT == "homicide"){
                                                    if($d_val == null){
                                                        $say = '<speak><p>There are no homicides to report today at this time. However, there is '.$ctc.' reported homicide '.$x_ago.' ago, '.$nDate.', would you like to hear the details?</p></speak>';
                                                        
                                                    }else{
                                                        $say = '<speak><p>In the '.addTH($d_val).' district, There are no homicides to report today at this time. However, there is '.$ctc.' reported homicide '.$x_ago.' ago, '.$nDate.', would you like to hear the details?</p></speak>';
                                                        
                                                    }
                                                    
                                                }
                                                if($crT == "sexual assault"){
                                                    if($d_val == null){
                                                        $say = '<speak><p>There are no sexual assaults to report today at this time. However, there is '.$ctc.' reported sexual assault '.$x_ago.' ago, '.$nDate.', would you like to hear the details?</p></speak>';
                                                        
                                                    }else{
                                                        $say = '<speak><p>In the '.addTH($d_val).' district, There are no sexual assaults to report today at this time. However, there is '.$ctc.' reported sexual assault '.$x_ago.' ago, '.$nDate.', would you like to hear the details?</p></speak>';
                                                        
                                                    }
                                                    
                                                }
                                                if($crT == "drugs"){
                                                    if($d_val == null){
                                                        $say = '<speak><p>There are no drugs, or narcotic law violations to report today at this time. However, there is '.$ctc.' reported drug, or narcotic law violation '.$x_ago.' ago, '.$nDate.', would you like to hear the details?</p></speak>';
                                                        
                                                    }else{
                                                        $say = '<speak><p>In the '.addTH($d_val).' district, There are no drug, or narcotic law violations to report today at this time. However, there is '.$ctc.' reported drug, or narcotic law violation '.$x_ago.' ago, '.$nDate.', would you like to hear the details?</p></speak>';
                                                        
                                                    }
                                                    
                                                }
                                            }else{
                                                
                                                if($crT == "assault"){
                                                    
                                                    if($d_val == null){
                                                        $say = '<speak><p>There are no assaults to report today at this time. However, there were '.$ctc.' assaults '.$x_ago.' ago, '.$nDate.', would you like to hear the details?</p></speak>';
                                                        
                                                    }else{
                                                        $say = '<speak><p>In the '.addTH($d_val).' district, There are no assaults to report today at this time. However, there were '.$ctc.' assaults '.$x_ago.' ago, '.$nDate.', would you like to hear the details?</p></speak>';
                                                        
                                                    }
                                                }
                                                if($crT == "theft"){
                                                    
                                                    if($d_val == null){
                                                        $say = '<speak><p>There are no thefts to report today at this time. However, there were '.$ctc.' reported thefts '.$x_ago.' ago, '.$nDate.', would you like to hear the details?</p></speak>';
                                                        
                                                    }else{
                                                        $say = '<speak><p>In the '.addTH($d_val).' district, There are no thefts to report today at this time. However, there were '.$ctc.' reported thefts '.$x_ago.' ago, '.$nDate.', would you like to hear the details?</p></speak>';
                                                        
                                                    }
                                                    
                                                    
                                                }
                                                if($crT == "robbery"){
                                                    
                                                    if($d_val == null){
                                                        $say = '<speak><p>I do not have any robberies to report today at this time. However, there were '.$ctc.' reported robberies '.$x_ago.' ago, '.$nDate.', would you like to hear the details?</p></speak>';
                                                        
                                                    }else{
                                                        $say = '<speak><p>In the '.addTH($d_val).' district, I do not have any robberies to report today at this time. However, there were '.$ctc.' reported robberies '.$x_ago.' ago, '.$nDate.', would you like to hear the details?</p></speak>';
                                                        
                                                    }
                                                    
                                                    
                                                }
                                                if($crT == "burglary"){
                                                    
                                                    if($d_val == null){
                                                        $say = '<speak><p>There are no burglaries to report today at this time. However, there were '.$ctc.' reported burglaries '.$x_ago.' ago, '.$nDate.', would you like to hear the details?</p></speak>';
                                                        
                                                    }else{
                                                        $say = '<speak><p>In the '.addTH($d_val).' district, There are no burglaries to report today at this time. However, there were '.$ctc.' reported burglaries '.$x_ago.' ago, '.$nDate.', would you like to hear the details?</p></speak>';
                                                        
                                                    }
                                                    
                                                    
                                                }
                                                if($crT == "homicide"){
                                                    
                                                    if($d_val == null){
                                                        $say = '<speak><p>There are no homicides to report today at this time. However, there were '.$ctc.' reported homicides '.$x_ago.' ago, '.$nDate.', would you like to hear the details?</p></speak>';
                                                        
                                                    }else{
                                                        $say = '<speak><p>In the '.addTH($d_val).' district, There are no homicides to report today at this time. However, there were '.$ctc.' reported homicides '.$x_ago.' ago, '.$nDate.', would you like to hear the details?</p></speak>';
                                                        
                                                    }
                                                    
                                                    
                                                }
                                                if($crT == "sexual assault"){
                                                    
                                                    if($d_val == null){
                                                        $say = '<speak><p>There are no sexual assaults to report today at this time. However, there were '.$ctc.' reported sexual assaults '.$x_ago.' ago, '.$nDate.', would you like to hear the details?</p></speak>';
                                                        
                                                    }else{
                                                        $say = '<speak><p>In the '.addTH($d_val).' district, There are no sexual assaults to report today at this time. However, there were '.$ctc.' reported sexual assaults '.$x_ago.' ago, '.$nDate.', would you like to hear the details?</p></speak>';
                                                        
                                                    }
                                                    
                                                    
                                                }
                                                if($crT == "drugs"){
                                                    
                                                    if($d_val == null){
                                                        $say = '<speak><p>There are no drugs, or narcotic law violations to report today at this time. However, there were '.$ctc.' reported drugs, or narcotic law violations '.$x_ago.' ago, '.$nDate.', would you like to hear the details?</p></speak>';
                                                        
                                                    }else{
                                                        $say = '<speak><p>In the '.addTH($d_val).' district, There are no drugs, or narcotic law violations to report today at this time. However, there were '.$ctc.' reported drugs, or narcotic law violations '.$x_ago.' ago, '.$nDate.', would you like to hear the details?</p></speak>';
                                                        
                                                    }
                                                    
                                                    
                                                }
                                                
                                                
                                            }
                                            
                                            if($d_val == null){
                                                $d_val = 0;
                                            }
                                            
                                            $txt = array("version"=>"1.0","sessionAttributes"=>array("presentTime"=>"today","crimeType"=>$crT,"currentCount"=>1,"totalCount"=>$ctc,"districtNumber"=>$d_val,"category"=>$fin,"dDate"=>$f_date,"readCount"=>1),"response"=>array("outputSpeech"=>array("type"=>"SSML","ssml"=>$say),"reprompt"=>null,"shouldEndSession"=>false));
                                            
                                            $ret = json_encode($txt);
                                            
                                            
                                        }
                                        
                                    }
                                    
                                    
                                }
                                
                                
                            }
                            
                     
                            // NO CRIME TYPE RETURNED FROM QUERY
                            
                            echo $ret;
                            writeToLog("No Crime Type for You");
                            
                        }
                            
                             

                        }else if($isRob == "ER_SUCCESS_NO_MATCH"){
                            
                            /// ERROR NEEDED, TODAY SPECFIED BUT NO CRIME-TYPE PROVIDED
                            ///GET SHOOTING FROM TODAY's DATE
                            //$curl_jason = getAPI_Info('https://phl.carto.com/api/v2/sql?q=SELECT%20*%20FROM%20shootings%20WHERE%20date_%20=%20%27'.$td2.'%20%27');
                            writeToLog("I RAN HERE BABY !");
                        }
                   
                    
                    
                    
                }
                
                
                
                else if($pio == "last"){
                    
                    $td2 = date('Y-m-d');
                    
                    if($isRob == "ER_SUCCESS_MATCH"){ /// MATCH CRIMETYPE
                        
                        if($crT == "shootings"){
                            
                            if($diss == "ER_SUCCESS_MATCH"){
                                
                                // SELECT THE LAST SHOOTING RECORD BY DATE
                                $curl_jason2 = getAPI_Info('https://phl.carto.com/api/v2/sql?q=SELECT+%2A+FROM+shootings+WHERE+dist+%3D+%27'.$d_val.'%27+ORDER++BY+date_+DESC+NULLS+LAST+LIMIT++1');
                                $h_dat = fetchSootArray($curl_jason2['rows']);
                                $sa = "<speak>".$h_dat."</speak>";
                                
                            }else{
                                
                                $url = 'https://phl.carto.com/api/v2/sql?q=SELECT+%2A+FROM+shootings+WHERE+dist+%3D+%27'.$d_val.'%27+ORDER++BY+date_+DESC+NULLS+LAST+LIMIT++1';
                                $curl_jason2 = getAPI_Info('https://phl.carto.com/api/v2/sql?q=SELECT+%2A+FROM+shootings+ORDER++BY+date_+DESC+NULLS+LAST+LIMIT++1');
                                $h_dat = fetchSootArray($curl_jason2['rows']);
                                $sa = "<speak>".$h_dat."</speak>";
                                
                            }
                            
                            
                            $say = array("version"=>"1.0","sessionAttributes"=>"",
                                "response"=>array("outputSpeech"=>array("type"=>"SSML","ssml"=>$sa),
                                    "reprompt"=>null,"shouldEndSession"=>false));
                            
                            echo json_encode($say);
     
                
                        }
                        
                        if($crT == "robbery"){
                            
                            if($diss == "ER_SUCCESS_MATCH"){
                                
                                $sel = "SELECT * FROM `CrimeIncidents` WHERE `CrimeName` LIKE '%Robbery%' AND `DistrictNumber` = $d_val ORDER BY `DispatchDate` DESC, `DispatchTime` ASC LIMIT 0,1";
                            
                            }else{
                                
                                $sel = "SELECT * FROM `CrimeIncidents` WHERE `CrimeName` LIKE '%Robbery%' ORDER BY `DispatchDate` DESC, `DispatchTime` ASC LIMIT 0,1";
                                
                            }
                            
                           $res = mysqli_query($CONN, $sel);
                           $arr = mysqli_fetch_array($res);
                           writeToLog($sel);
                           
                           $dist = $arr['DistrictNumber'];
                           $dTime =  $arr['DispatchTime'];
                           $dDate =  $arr['DispatchDate'];
                           $aBlock = fixAddress($arr['AddressBlock']);
                           $cName =  $arr['CrimeName'];
                           $patt = '/(?i)(Robbery Firearm)/is';
                           $conT = $dDate." ".$dTime;
                           $ctime = date('F jS, h:i a', strtotime($conT));
                           
                           if(preg_match($patt,$cName)){
                               if($diss == "ER_SUCCESS_MATCH"){
                                   
                                   $sa = '<speak><p>The last reported robbery in the '.addTH($d_val).' police district was '.$ctime.'. On the '.$aBlock.'.</p></speak>';
                                   
                               }else{
                                   $sa = '<speak><p>The last reported robbery was '.$ctime.'. On the '.$aBlock.' in the '.addTH($dist).' police district.</p></speak>';
                                   
                               }
                               
                           }else{
                               
                               if($diss == "ER_SUCCESS_MATCH"){
                                   $sa = '<speak><p>The last reported robbery in the '.addTH($d_val).' police district was '.$ctime.'. On the '.$aBlock.'. No firearm was reportedly used in this crime.</p></speak>';
                                   
                               }else{
                                   
                                   $sa = '<speak><p>The last reported robbery was '.$ctime.'. On the '.$aBlock.' in the '.addTH($dist).' police district. No firearm was reportedly used in this crime.</p></speak>';
                                   
                               }
                               
                           }
                           
                           $say = array("version"=>"1.0","sessionAttributes"=>"",
                               "response"=>array("outputSpeech"=>array("type"=>"SSML","ssml"=>$sa),
                                   "reprompt"=>null,"shouldEndSession"=>false));
                           
                           echo json_encode($say);
                        }
                        
                    }
                
                
                }
                
                
                
                
                
                else if($pio == "week"){
                    
                    date_default_timezone_set('US/Eastern');
                    //$td1 = date('Y-m-d');
                    $ddz = date('l');
                    $pDate1 = strtotime('last '.$ddz);
                    $td2x = date('Y-m-d',$pDate1);
                    
                        if($diss == "ER_SUCCESS_MATCH"){
                            
                            $curl_jason = getAPI_Info('https://phl.carto.com/api/v2/sql?q=SELECT%20*%20FROM%20shootings%20WHERE%20date_%20%3E=%27'.$td2x.'%27%20AND%20dist%20=%20%27'.$d_val.'%27');
                            
                            
                        }else{
                          
                            $curl_jason = getAPI_Info('https://phl.carto.com/api/v2/sql?q=SELECT%20*%20FROM%20shootings%20WHERE%20date_%20%3E=%27'.$td2x.'%27');
                            
                            
                        }
                    
                    
                }else if($pio == "month"){
                    date_default_timezone_set('US/Eastern');
                    $pDate = strtotime('today - 30 days');
                    $td2 = date('Y-m-d',$pDate);
                    
                    $curl_jason = getAPI_Info('https://phl.carto.com/api/v2/sql?q=SELECT%20*%20FROM%20shootings%20WHERE%20date_%20%3E=%27'.$td2.'%27');
                    
                }
                
            
                
                    $arr = $curl_jason['rows'];
                    $ttc = $curl_jason['total_rows'];
                    

                        
                     if($ttc >=1 && $pio == "week"){
                         
                         date_default_timezone_set('US/Eastern');
                         //$td1 = date('Y-m-d');
                         $dd = date('l');
                         $pDate = strtotime('last '.$dd);
                         $td2 = date('F jS, Y',$pDate);
                         $jjk = $dd." ".$td2;
                         
                         if($diss == "ER_SUCCESS_MATCH"){
                             $sa2 = '<p>Since the last week, in the '.$d_val.' district, starting from '.$jjk.'. There have been '.$ttc.' shootings, according to my knowledge. Would you like to hear the details?</p>';
                             
                             echo '{
                            	"version": "1.0",
                            	"response": {
                            		"outputSpeech": {
                            			"type": "SSML",
                                        "ssml": "'."<speak>".$sa2."</speak>".'"
                            		},
                            		"reprompt": null,
                            		"sessionAttributes": {}
                            	}
                            }';
                             
                         }else{
                             
                             
                             $arr = $curl_jason['rows'];
                             $txt = fetchSootArray($arr);
                             $sa = "<speak>".$txt."</speak>";
                            

                             $say = array("version"=>"1.0","sessionAttributes"=>"",
                                 "response"=>array("outputSpeech"=>array("type"=>"SSML","ssml"=>$sa),
                                     "reprompt"=>null,"shouldEndSession"=>false));
                                 echo json_encode($say);
                             
                         }
                         
                         
                     }
                     
                     
                     if($ttc >=1 && $pio == "month"){
                         date_default_timezone_set('US/Eastern');
                         $pDate = strtotime('today - 30 days');
                         $td2 = date('l F jS, Y',$pDate);
                         
                         $sa = '<p>In the last month, starting from '.$td2.'. There have been '.$ttc.' shootings in the city, according to my knowledge. Would you like to hear the details?</p>';
                         
                         //$txt = hhSootArray($arr);
                         
                         echo '{
                            	"version": "1.0",
                            	"response": {
                            		"outputSpeech": {
                            			"type": "SSML",
                                        "ssml": "'."<speak>".$sa."</speak>".'"
                            		},
                            		"reprompt": null,
                            		"sessionAttributes": {}
                            	}
                            }';
                     }
                     
                     
                         
                    }
                        
                             
            
        }
        
        
        
//////////////////////////////////////////////////////////// END INTENT fetchStatus //////////////////////////////////////////
                    
                    

                    
     
                        
                   
//////////////////////////////////////////////////////////// START ackResponse INTENT LAUNCH //////////////////////////////////////////
    

    
    if($itReq == "IntentRequest" && $itNam == "ackResponse"){
        $anw = $data['request']['intent']['slots']['answer']['resolutions']['resolutionsPerAuthority'][0]['status']['code'];
        $val = $data['request']['intent']['slots']['answer']['resolutions']['resolutionsPerAuthority'][0]['values'][0]['value']['name'];
            
            if($anw == "ER_SUCCESS_MATCH"){
                
                if($val == "yes"){
                    $aTT = $data['session'];
                    
                    
                    if($aTT['attributes']['Hash'] !== null){
                        $pre = $aTT['attributes'];
                        $u_has = $pre['Hash'];
                        $ut_ct = $pre['totalCount'] - 1 ;
                        $cu_ct = $pre['currentCount'];
                        $rxx_ct = $pre['readCount'];
                       
                         
                         $ress = '';
                         $speaK = '';
                         $f_obj = '';
                         $ct = 0;
                         
                         
                         $us_ql = "SELECT * FROM `NewsStory` WHERE `ScrapeHash` = '$u_has' ORDER BY `PubDate` DESC LIMIT $ut_ct , $cu_ct";
                         $us_res = mysqli_query($CONN, $us_ql);
                         
                         $roe = mysqli_fetch_array($us_res);
                         $cattt = $roe['Category'];
                         

                         $newsNum = "<p>story number ".$rxx_ct.",</p> ";
                         $kepg = " <p>would you like me to read the next story?</p>";
                         $ending2 = "<p> ,there are no more stories to report, would you like me to help you with something else?</p>";
                         
                         $desc = utf8_encode(cleanTxT($roe['Description']));
                         $speaK = '<p>'.$desc.'</p>';
                         
                         $rxx_ct ++;
                         
                         if($ut_ct == 0){
                             $spea = $newsNum.$speaK.$ending2; 
                         }else{
                               $spea = $newsNum.$speaK.$kepg;
                         }
                         
                         
                         
                         $ress = json_encode(array("version"=>"1.0","sessionAttributes"=>array("totalCount"=>$ut_ct,"currentCount"=>1,"Hash"=>$u_has,"readCount"=>$rxx_ct),"response"=>
                             array("outputSpeech"=>
                                 array("type"=>"SSML","ssml"=>"<speak>".$spea."</speak>"),"shouldEndSession"=>false,"reprompt"=>null)));
                         
                         echo $ress;

                    }
                    
                    if($aTT['attributes']['presentTime'] !== null && $aTT['attributes']['crimeType'] !== null){
                        $pre = $aTT['attributes'];
                        $ppTime = $pre['presentTime'];
                        $cCount = $pre['currentCount'];
                        $tCount = $pre['totalCount'] -1;
                        $cyT = $pre['crimeType'];
                        $dNumz = $pre['districtNum'];
                        $catt = $pre['category'];
                        $dDate = $pre['dDate'];
                        $rdCount = $pre['readCount'];
                        
                            if($dNumz == 0){
                                $f_URL = "SELECT * FROM `CrimeIncidents` WHERE `DispatchDate` = '$dDate' AND `CrimeName` IN ($catt) ORDER BY `DispatchTime` DESC LIMIT $tCount, $cCount";
                                
                            }else{
                                $f_URL = "SELECT * FROM `CrimeIncidents` WHERE `DispatchDate` = '$dDate' AND `CrimeName` IN ($catt) AND `DistrictNumber` = $dNumz ORDER BY `DispatchTime` DESC LIMIT $tCount, $cCount";
                                
                            }
                        
                       
                        $rex = mysqli_query($CONN, $f_URL);
                        $roq = mysqli_fetch_array($rex);
                        
                        $desc = utf8_encode(cleanTxT($roq['AddressBlock']));
                        $speaK = '<p>'.$desc.'</p>';
                        $tiime = date('l F jS,',strtotime($roq['DispatchDate']));
                        $d_time = date("g:i a",strtotime($roq['DispatchTime']));
                        $bllk = fixAddress($roq['AddressBlock']);
                        $crime = $roq['CrimeName'];
                        $more = ", do you want to hear the next incident?";
                        $noMore = "<p>, there are no more incidents to report at this time, would you like me to help you with something else?</p>";
                        $numD = addTH($roq['DistrictNumber']);
                        $wDis = "in the ".$numD." district, ";
                        
                        if($tCount == 0){
                            $free = "<p>".$wDis."on ".$tiime." the Philadelphia Police were dispatched at ".$d_time.", to the ".$bllk." for a ".$crime.$noMore."</p>";
                            
                        }else{
                            $free = "<p>".$wDis."on ".$tiime." the Philadelphia Police were dispatched at ".$d_time.", to the ".$bllk." for a ".$crime.$more."</p>";
                            
                        }
                        
                        $rdCount ++;
                        
                        $ress = json_encode(array("version"=>"1.0","sessionAttributes"=>array("totalCount"=>$tCount,"currentCount"=>$cCount,"dDate"=>$dDate,"category"=>$catt,"districtNumber"=>$dNumz,"presentTime"=>$ppTime,"crimeType"=>$cyT,"readCount"=>$rdCount),"response"=>
                            array("outputSpeech"=>
                                array("type"=>"SSML","ssml"=>"<speak>".$free."</speak>"),"shouldEndSession"=>false,"reprompt"=>null)));
                        
                        echo $ress;
                        
                        
                    }
                    
                    if($aTT['attributes']['districtNews'] !== null && $aTT['attributes']['currentCount'] !== null){
                        
                        $isDis = $aTT['attributes']['districtNews'];
                        $cCT = $aTT['attributes']['currentCount'];
                        $SQl = $aTT['attributes']['SQL'];
                        $ttCT = $aTT['attributes']['totalCount'];
                        $disNu = $aTT['attributes']['districtNumber'];
                        $pDate = $aTT['attributes']['pubDate'];

                        
                        if($ttCT > 1){
                            
                        }else{
                            
                            $sql_1 = "SELECT * FROM `NewsStory` WHERE `DistrictNumber` = '$disNu' AND `TimeStamp` LIKE '%$pDate%'";
                            $my_res = mysqli_query($CONN, $sql_1);
                            $myArr = mysqli_fetch_array($my_res);
                            $desc = utf8_encode(cleanTxT($myArr['Description']));
                            $speaK = '<p>'.$desc.'</p>';
                            
                            
                            $ress = json_encode(array("version"=>"1.0","sessionAttributes"=>array("currentCount"=>"1","totalCount"=>$ttCT,"isDistrictNews"=>"true","districtNumber"=>$disNu,"pubDate"=>$pDate),"response"=>
                                array("outputSpeech"=>
                                    array("type"=>"SSML","ssml"=>"<speak>".$speaK."</speak>"),"shouldEndSession"=>false,"reprompt"=>null)));
                            
                            echo $ress;
                            
                        }
                        
                 
                        
                        
                    }
                    
                    if($aTT['attributes']['shootingDate'] !== null && $aTT['attributes']['shooting'] == "true"){
                        
                        $shDate = $aTT['attributes']['shootingDate'];
                        $url = 'https://phl.carto.com/api/v2/sql?q=SELECT%20*%20FROM%20shootings%20WHERE%20date_%20=%20%27'.$shDate.'%20%27';
                        $f_more = getAPI_Info($url);
                        $readThis = fetchSootArray($f_more['rows']);
                        $end = "<p>, that is the last reported shooting. would you like me to help you with something else?</p>";
                        writeToLog($url);
                        
                        $ress = json_encode(array("version"=>"1.0","sessionAttributes"=>array("currentCount"=>"1"),"response"=>
                            array("outputSpeech"=>
                                array("type"=>"SSML","ssml"=>"<speak>".$readThis.$end."</speak>"),"shouldEndSession"=>false,"reprompt"=>null)));
                        
                        echo $ress;
                        
                    }
                    
                    
                    if($aTT['attributes']['crimeHash'] !== null && $aTT['attributes']['crimeIncidents'] == "true"){
                       
                        $dHash = $aTT['attributes']['crimeHash'];
                        $dNum = $aTT['attributes']['districtNumber'];
                        $cCount = $aTT['attributes']['currentCount'];
                        $tTotal = $aTT['attributes']['totalCount'] -1;
                        $rdCount = $aTT['attributes']['readCount'] + 1;
                        
                        
                        
                        if($dNum == 0){
                            $sqz = "SELECT * FROM `CrimeIncidents` WHERE `HashTag` = '$dHash' ORDER BY `DispatchDate` DESC LIMIT $tTotal,$cCount";
                        }else{
                            $sqz = "SELECT * FROM `CrimeIncidents` WHERE `HashTag` = '$dHash' AND `DistrictNumber` = '$dNum' ORDER BY `DispatchDate` DESC LIMIT $tTotal,$cCount";
                        }
                        
                        

                        $ref = mysqli_query($CONN, $sqz);
                        $rox = mysqli_fetch_array($ref);
                        $disDate = date('l F jS ', strtotime($rox['DispatchDate']));
                        $disTime = date('h:i a',strtotime($rox['DispatchTime']));
                        $addBlk = fixAddress($rox['AddressBlock']);
                        $distN = addTH($rox['DistrictNumber']);
                        $crmN = $rox['CrimeName'];
                        $incd  = "incident ".$rdCount;
                        
                        if($tTotal == 0){
                            $next = "<p>that is the last criminal incident, would you like me to help you with something else?</p>";
                            
                        }else{
                            $next = "<p>would you like to hear the next incident?</p>";
                            
                        }
                        
                        
                        
                        $lastTx = "<p>".$incd.", In the ".$distN." district, ".$disDate.", ".$disTime.", the Philadelphia Police where dispatched to the ".$addBlk.", for ".$crmN.", ".$next."</p>";
                        
                        if($dNum == 0){
                            $distN = 0;
                        }else{
                            $distN = addTH($rox['DistrictNumber']);
                        }
                        
                        $ress = json_encode(array("version"=>"1.0","sessionAttributes"=>array("totalCount"=>$tTotal,"currentCount"=>$cCount,"crimeHash"=>$dHash,"districtNumber"=>$distN,"readCount"=>$rdCount,"crimeIncidents"=>"true"),"response"=>
                            array("outputSpeech"=>
                                array("type"=>"SSML","ssml"=>"<speak>".$lastTx."</speak>"),"shouldEndSession"=>false,"reprompt"=>null)));
                        
                        echo $ress;
                        
                        
                    }
                    

                    
                 }
                 
                 
                 ///// END YES
                 
                 if($val == "no"){
                     
                     echo '{
                                	"version": "1.0",
                                	"response": {
                                		"outputSpeech": {
                                			"type": "SSML",
                                            "ssml": "<speak><s>Alright!</s>What else would you like me to help you with</speak>"
                                            
                                		},
                                        "shouldEndSession": false,
                                		"reprompt": {
                                            "outputSpeech": {
                                                "type": "SSML",
                                                "ssml": "<speak>What else would you like me to help you with</speak>"
                                                
                                              }
                                         },
                                		"sessionAttributes": {}
                                	   }
                                   }';
                 }
                
                
                
                 
            }
            
            
    }
    
    
//////////////////////////////////////////////////////////// END ackResponse INTENT LAUNCH //////////////////////////////////////////
    
    

 
    
//////////////////////////////////////////////////////////// START INTENT districtNews //////////////////////////////////////////
    
    

    if($itReq == "IntentRequest" && $itNam == "districtNews"){
        
        $stat = $data['request']['intent']['slots']['newsType']['resolutions']['resolutionsPerAuthority'][0]['status']['code'];
        $val = $data['request']['intent']['slots']['newsType']['value'];
        $navi = $data['request']['intent']['slots']['navigation']['resolutions']['resolutionsPerAuthority'][0]['values'][0]['value']['name'];
        $isNavi = $data['request']['intent']['slots']['navigation']['resolutions']['resolutionsPerAuthority'][0]['status']['code'];
        $isPTime = $data['request']['intent']['slots']['presentTime']['resolutions']['resolutionsPerAuthority'][0]['status']['code'];
        $pTime = $data['request']['intent']['slots']['presentTime']['resolutions']['resolutionsPerAuthority'][0]['values'][0]['value']['name'];
        $isDisA = $data['request']['intent']['slots']['districtNums']['resolutions']['resolutionsPerAuthority'][0]['values'][0]['value']['name'];
        
        if($isNavi == "ER_SUCCESS_MATCH"){ /// NAVIGATION YES/NO SAID
            
            if($navi == "continue" || $navi == "next"){

                if($data['session']['attributes']['totalCount'] >= 1){ // check for total count
                    
                    $aTTs = $data['session']['attributes'];
                    $u_has = $aTTs['Hash'];
                    $ut_ct = $aTTs['totalCount'] - 1 ;
                    $cu_ct = $aTTs['currentCount'];
                    $rx_ct = $aTTs['readCount'];
                    
                    $isDist = $aTTs['isDistrictNews'];
                    $disNu = $aTTs['districtNumber'];
                    $pDate = $aTTs['pubDate'];
                    

                        
                        $sqll = "SELECT * FROM `NewsStory` WHERE `ScrapeHash` = '$u_has' ORDER BY `PubDate` DESC LIMIT $ut_ct, $cu_ct";
                        $rezz = mysqli_query($CONN, $sqll);
                        if(mysqli_num_rows($rezz) >=1){
                            $art = mysqli_fetch_array($rezz);
                            
                            
                            $desc = utf8_encode(cleanTxT($art['Description']));
                            $speaK = '<p>'.$desc.'</p>';
                            
                            
                            
                            $newsNum = "<p>story number"." ".$rx_ct.",</p> ";
                            $rx_ct ++;
                            
                            
                            if($ut_ct == 0){
                                
                                $kepg = "<p>that is the last news story to report, would you like me to help you with something else?</p>";
                                $spea = $newsNum.$speaK.$kepg;
                                
                                $ress = json_encode(array("version"=>"1.0","response"=>array("outputSpeech"=>
                                        array("type"=>"SSML","ssml"=>"<speak>".$spea."</speak>"),"shouldEndSession"=>false,"reprompt"=>null)));
                                
                                echo $ress;
                                
                            }else{
                                
                                $kepg = " <p>would you like me to read the next story?</p>";
                                $spea = $newsNum.$speaK.$kepg;
                                
                                $ress = json_encode(array("version"=>"1.0","sessionAttributes"=>array("totalCount"=>$ut_ct,"currentCount"=>1,"Hash"=>$u_has,"readCount"=>$rx_ct),"response"=>
                                    array("outputSpeech"=>
                                        array("type"=>"SSML","ssml"=>"<speak>".$spea."</speak>"),"shouldEndSession"=>false,"reprompt"=>null)));
                                
                                echo $ress;
                                
                                
                            }
                            
                            
                            
                            

                                
                                
                                
                                
                            
                            
                            
                            
                        }else{
                            // nothing returned mysql
                            
                        }
                        
                        
           //         }
                    
                    
                    
                    
                    
                    
                }
                
                
                
                if($aTTs['totalCount'] == 0 || $aTTs['totalCount'] == "0"){
                    
                    writeToLog("LANDED HERE");
                    
                    $spea = "There are no more stories to report at this time, would you like me to help you with something else?";
                    
                    $ress = json_encode(array("version"=>"1.0","sessionAttributes"=>array("totalCount"=>$ut_ct,"currentCount"=>"1","Hash"=>$u_has,"readCount"=>$rx_ct),"response"=>
                        array("outputSpeech"=>
                            array("type"=>"SSML","ssml"=>"<speak>".$spea."</speak>"),"shouldEndSession"=>false,"reprompt"=>null)));
                    
                    echo $ress;
                    // no more stories left to tell
                }
                
                

                
            }
            
            if($navi == "repeat"){
                
                $aTTs = $data['session']['attributes'];
                $u_has = $aTTs['Hash'];
                $ut_ct = $aTTs['totalCount'];
                $cu_ct = $aTTs['currentCount'];
                $isDist = $aTTs['isDistrictNews'];
                $disNu = $aTTs['districtNumber'];
                $pDate = $aTTs['pubDate'];
                $crmType = $aTTs['crimeType'];
                $cate = $aTTs['category'];
                $dDate = $aTTs['dDate'];
                $crimInd = $aTTs['crimeIncidents'];
                $crmHash = $aTTs['crimeHash'];
                $redCtt = $aTTs['readCount'];
                
                
                if($crimInd !== null && $crmHash !== null){
                    
                    if($disNu == 0){
                        $sqz = "SELECT * FROM `CrimeIncidents` WHERE `HashTag` = '$crmHash' ORDER BY `DispatchDate` DESC LIMIT $ut_ct,$cu_ct";
                    }else{
                        $sqz = "SELECT * FROM `CrimeIncidents` WHERE `HashTag` = '$crmHash' AND `DistrictNumber` = '$disNu' ORDER BY `DispatchDate` DESC LIMIT $ut_ct,$cu_ct";
                    }
                    
                    $ref = mysqli_query($CONN, $sqz);
                    $rox = mysqli_fetch_array($ref);
                    $distN = addTH($rox['DistrictNumber']);
                    $disDate = date('l F jS ', strtotime($rox['DispatchDate']));
                    $disTime = date('h:i a',strtotime($rox['DispatchTime']));
                    $addBlk = fixAddress($rox['AddressBlock']);
                    $crmN = $rox['CrimeName'];
                    $incd  = "incident ".$redCtt;
                    $next = "<p>would you like to hear the next incident?</p>";
                    
                    $lastTx = "<p>".$incd.", In the ".$distN." district, ".$disDate.", ".$disTime.", the Philadelphia Police where dispatched to the ".$addBlk.", for ".$crmN.", ".$next."</p>";
                    
                    $ress = json_encode(array("version"=>"1.0","sessionAttributes"=>array("totalCount"=>$ut_ct,"currentCount"=>$cu_ct,"crimeHash"=>$crmHash,"districtNumber"=>$disNu,"readCount"=>$redCtt,"crimeIncidents"=>"true"),"response"=>
                        array("outputSpeech"=>
                            array("type"=>"SSML","ssml"=>"<speak>".$lastTx."</speak>"),"shouldEndSession"=>false,"reprompt"=>null)));
                    
                    echo $ress;
                
                }
                
                
                
                if($crmType !== null && $cate !== null){
                    
                    
                    if($disNu == 0){
                        $f_URL = "SELECT * FROM `CrimeIncidents` WHERE `DispatchDate` = '$dDate' AND `CrimeName` IN ($cate) ORDER BY `DispatchTime` DESC LIMIT $ut_ct, $cu_ct";
                        
                    }else{
                        $f_URL = "SELECT * FROM `CrimeIncidents` WHERE `DispatchDate` = '$dDate' AND `CrimeName` IN ($cate) AND `DistrictNumber` = $disNu ORDER BY `DispatchTime` DESC LIMIT $ut_ct, $cu_ct";
                        
                    }
                    
                    
                     $rex = mysqli_query($CONN, $f_URL);
                     $roq = mysqli_fetch_array($rex);
                    
                     $desc = utf8_encode(cleanTxT($roq['AddressBlock']));
                     $speaK = '<p>'.$desc.'</p>';
                     $tiime = date('l F jS,',strtotime($roq['DispatchDate']));
                     $d_time = date("g:i a",strtotime($roq['DispatchTime']));
                     $bllk = fixAddress($roq['AddressBlock']);
                     $crime = $roq['CrimeName'];
                     $more = ", do you want to hear the next incident?";
                     $noMore = "<p>, there are no more incidents to report at this time, would you like me to help you with something else?</p>";
                     $numD = addTH($roq['DistrictNumber']);
                     $wDis = "in the ".$numD." district, ";
                    
                     if($ut_ct == 0){
                        $free = "<p>".$wDis."on ".$tiime." the Philadelphia Police were dispatched at ".$d_time.", to the ".$bllk." for a ".$crime.$noMore."</p>";
                        
                    }else{
                        $free = "<p>".$wDis."on ".$tiime." the Philadelphia Police were dispatched at ".$d_time.", to the ".$bllk." for a ".$crime.$more."</p>";
                        
                    }
                    
                    
                    
                    //$rdCount ++;
                    
                    $ress = json_encode(array("version"=>"1.0","sessionAttributes"=>array("totalCount"=>$ut_ct,"currentCount"=>$cu_ct,"dDate"=>$dDate,"category"=>$cate,"districtNumber"=>$disNu,"presentTime"=>$ppTime,"crimeType"=>$cyT,"readCount"=>$rdCount),"response"=>
                        array("outputSpeech"=>
                            array("type"=>"SSML","ssml"=>"<speak>".$free."</speak>"),"shouldEndSession"=>false,"reprompt"=>null)));
                    
                    echo $ress;
                    
                    
                    
                }else{
                    
                    
                    if($isDist == "true"){
                        $sqll = "SELECT * FROM `NewsStory` WHERE `DistrictNumber` = '$disNu' AND `TimeStamp` LIKE '%$pDate%'";
                    }else{
                        $sqll = "SELECT * FROM `NewsStory` WHERE `ScrapeHash` = '$u_has' ORDER BY `PubDate` DESC LIMIT $ut_ct, $cu_ct";
                    }
                    
                    $rezz = mysqli_query($CONN, $sqll);
                    if(mysqli_num_rows($rezz) >=1){
                        $art = mysqli_fetch_array($rezz);
                        
                        
                        $desc = utf8_encode(cleanTxT($art['Description']));
                        $speaK = '<p>'.$desc.'</p>';
                        
                        if($isDist == "true"){
                            $ress = json_encode(array("version"=>"1.0","sessionAttributes"=>array("pubDate"=>$pDate,"districtNumber"=>$disNu,"isDistrictNews"=>"true","totalCount"=>$ut_ct,"currentCount"=>"1","Hash"=>$u_has),"response"=>
                                array("outputSpeech"=>
                                    array("type"=>"SSML","ssml"=>"<speak>".$speaK."</speak>"),"shouldEndSession"=>false,"reprompt"=>null)));
                            
                            
                        }else{
                            $ress = json_encode(array("version"=>"1.0","sessionAttributes"=>array("totalCount"=>$ut_ct,"currentCount"=>"1","Hash"=>$u_has),"response"=>
                                array("outputSpeech"=>
                                    array("type"=>"SSML","ssml"=>"<speak>".$speaK."</speak>"),"shouldEndSession"=>false,"reprompt"=>null)));
                            
                        }
                        
                        
                        echo $ress;
                        
                    }
                    
                    
                    
                }
                
  
                
            }
            
            
        }

         
        if($stat == "ER_SUCCESS_MATCH"){ 
            
            
            if($val == "latest"){
                
                $array = array();
                $ch = "SELECT `TimeStamp`,`Hash` FROM `CurrentHash` WHERE `HashName` = 'NewsStory'";
                $reyt = mysqli_query($CONN, $ch);
                
                $speaK = '';
                $f_obj = '';
                $ct = 0;
                //$obj_arr = array();
                $cat_ct = array();
                
                if(mysqli_num_rows($reyt) >=1){  /// FETCHING CURRENT HASH
                    
                    $row = mysqli_fetch_array($reyt);
                    $hash = $row['Hash'];
                    $tDATE = $row['TimeStamp'];
                        
                    if($isDisA !== null){
                        $sql = "SELECT SQL_CALC_FOUND_ROWS * FROM `NewsStory` WHERE `DistrictNumber` = $isDisA AND `ScrapeHash` = '$hash' ORDER BY `PubDate` DESC LIMIT 0,1";
                        
                    }else{
                        $sql = "SELECT SQL_CALC_FOUND_ROWS * FROM `NewsStory` WHERE `ScrapeHash` = '$hash' ORDER BY `PubDate` DESC LIMIT 0,1";
                        
                    }
                        
                    $rec_ct = "SELECT FOUND_ROWS() AS ROWS";
                    $rep = mysqli_query($CONN, $sql);
                    
                    
                    if(mysqli_num_rows($rep) >= 1){ /// FETCHING DATA WITH CURRENT HASH
                        
                        $rep_ct = mysqli_query($CONN, $rec_ct);
                        $tl_ctt = mysqli_fetch_array($rep_ct);
                        $rowD = mysqli_fetch_array($rep);
                        $total_ct = $tl_ctt['ROWS'];
                        $f_obj = $rowD['PubDate'];
                        
                        
                        $ti = date('l F jS, h:i a',strtotime($f_obj));
                        $td2 = date('Y-m-d');
                        $x_ago = dateDifference($ti,$td2,"%d days");
                        
                        if($x_ago == "0 days"){
                            $x_ago = "today,";
                        }
                        else if($x_ago == "1 days"){
                            $x_ago = "yesterday";
                        }
                        else{
                            $x_ago = $x_ago." ago,";
                            
                        }
                        
                        
                        $ctCat = array_count_values($cat_ct);
                        $wanCt = $ctCat['Wanted'];
                        $cg = strlen($speaK);
                        $ending = "<s> would you like me to continue reading?</s>";
                        $ending1 = "<s> would you like me to read this news story?</s>";
                        
                        
                        
                        if($total_ct == "1"){ //change message to provoke user to say something else
                            //singular
                            if($isDisA !== null){
                                $sayy = '<s>Here is the latest police news for the '.addTH($isDisA).' district, As of '.$ti.', There is '.$total_ct.' story to report</s> '.$speaK.$ending;
                                
                            }else{
                                //$sayy = '<s>Here is the latest police news update!. As of '.$ti.', There is '.$total_ct.' story to report</s> '.$speaK.$ending1;
                                $sayy = '<s>Here is the latest police news update! As of '.$x_ago.' '.$ti.', There is '.$total_ct.' story to report</s> '.$speaK.$ending1;
                            }
                            
                            
                        }else{
                            //plural
                            if($isDisA !== null){
                                $sayy = '<s>Here is the latest police news for the '.addTH($isDisA).' district, As of '.$ti.', There are '.$total_ct.' stories to report</s> '.$speaK.$ending;
                                
                            }else{
                                $sayy = '<s>Here is the latest police news update!. As of '.$ti.', There are '.$total_ct.' stories to report</s> '.$speaK.$ending;
                                
                            }
                        }
                            
                            
                            
                        
                        
                        echo json_encode(array("version"=>"1.0","sessionAttributes"=>array("totalCount"=>$total_ct,"currentCount"=>1,"Hash"=>$hash,"readCount"=>1),"response"=>
                            array("outputSpeech"=>
                                array("type"=>"SSML","ssml"=>"<speak>".$sayy."</speak>"),"shouldEndSession"=>false,"reprompt"=>array("outputSpeech"=>array("type"=>"SSML","ssml"=>"<speak>sooo?<s>your not going to say anything?</s></speak>")))));
                         
                        
                        
                        
                    }else{
                        
                        if($isDisA !== null){ /// DISTRICT  NUMBER PROVIDED
                            
                            $sql = "SELECT `TimeStamp` FROM `NewsStory` WHERE `DistrictNumber` = $isDisA ORDER BY `TimeStamp` DESC LIMIT 1";
                            $ret = mysqli_query($CONN, $sql);
                            $arF = mysqli_fetch_array($ret);
                            $tStamp = $arF['TimeStamp'];
                            $hals = explode(" ",$tStamp);
                            $nStam = $hals[0];
                            
                            $sql_1 = "SELECT SQL_CALC_FOUND_ROWS `TimeStamp` FROM `NewsStory` WHERE `TimeStamp` LIKE '%'.$nStam.'%'";
                            $sql_11 = "SELECT FOUND_ROWS() AS ROWS";
                            
                            $ret1 = mysqli_query($CONN, $sql_1);
                            $ret11 = mysqli_query($CONN, $sql_11);
                            
                            $ctRows = mysqli_fetch_array($ret11);
                            $ctA = $ctRows['ROWS'];
                            $ti = date('Y-m-d',strtotime($nStam));
                            $ti_dd = date('l F jS',strtotime($nStam));
                            $td2 = date('Y-m-d');
                            $x_ago = dateDifference($td2,$ti,"%d days");
                            $ending = "<s> would you like me to continue reading?</s>";
                            $endings = "<s> would you like me to continue reading?</s>";
                            $ending1 = "<s> would you like me to read this news story?</s>";
                            $disNUM = $isDisA;
                            //$isDisA = addTH($isDisA);
                            
                            if($x_ago == "0 days"){
                                $x_ago = "today";
                            }
                            else if($x_ago == "1 days"){
                                $x_ago = "yesterday";
                            }
                            else{
                                $x_ago = $x_ago." ago,";
                                
                            }
                            
                            if($ctA == "1"){ //change message to provoke user to say something else
                                //singular
                                //$sayy = '<s>Here is the latest police news for the '.$isDisA.' district, As of '.$x_ago.' on '.$ti_dd.', There is '.$ctA.' story to report</s> '.$ending1;
                                $sayy = '<s>Here is the latest police news for the '.addTH($isDisA).' district, '.$x_ago.' '.$ti_dd.', There is '.$ctA.' story to report</s> '.$ending1;
                                
                                
                            }else{
                                //plural
                                $sayy = '<s>Here is the latest police news for the '.addTH($isDisA).' district, As of '.$x_ago.' on '.$ti_dd.', There are '.$ctA.' stories to report</s> '.$endings;
                                
                            }
                            
                            
                            echo json_encode(array("version"=>"1.0","sessionAttributes"=>array("SQL"=>$sql_1,"totalCount"=>$ctA,"districtNews"=>"true","currentCount"=>"1","districtNumber"=>$disNUM,"pubDate"=>$nStam),"response"=>
                                array("outputSpeech"=>
                                    array("type"=>"SSML","ssml"=>"<speak>".$sayy."</speak>"),"shouldEndSession"=>false,"reprompt"=>array("outputSpeech"=>array("type"=>"SSML","ssml"=>"<speak>sooo?<s>your not going to say anything?</s></speak>")))));
                            
                                          
                            
                        }else{
                            
                            
                        }
                        
                        
                        
                    }
                    
                    //   NO news returned from the SQL query
                   
                    
                }
                        
                /// FAILED TO FIND CURRENT HASH
                    
                
                
            }
            
            
            
            
            if($val == "crime"){
                
                if($isDisA !== null){
                    $sql = "SELECT `HashTag` AS 'Hash' FROM `CrimeIncidents` WHERE `DistrictNumber` = '$isDisA' ORDER BY `DispatchDate` DESC LIMIT 0,1";
                    
                }else{
                    $sql = "SELECT `Hash` FROM `CurrentHash` WHERE `HashName` = 'CrimeIncidents'";
                }
                
                $sql_res = mysqli_query($CONN,$sql);
                
                if(mysqli_num_rows($sql_res) >= 1){
                    $ret = mysqli_fetch_array($sql_res);
                    $hash = $ret['Hash'];
                    
                    if($isDisA !== null){
                        $n_sql = "SELECT SQL_CALC_FOUND_ROWS * FROM `CrimeIncidents` WHERE `HashTag` = '$hash' AND `DistrictNumber` = '$isDisA' ORDER BY `DispatchDate` DESC LIMIT 0,1";
                    }else{
                        $n_sql = "SELECT SQL_CALC_FOUND_ROWS * FROM `CrimeIncidents` WHERE `HashTag` = '$hash' ORDER BY `DispatchDate` DESC LIMIT 0,1";
                        
                    }
                    
                    $rec_ct = "SELECT FOUND_ROWS() AS ROWS";
                    
                    $res2 = mysqli_query($CONN, $n_sql);
                    $res3 = mysqli_query($CONN, $rec_ct);
                    
                    if(mysqli_num_rows($res2) >= 1){
                        $row = mysqli_fetch_array($res3);
                        $row1 = mysqli_fetch_array($res2);
                        $count = $row['ROWS'];
                        $nTime = date('l F jS ', strtotime($row1['DispatchDate']));
                        
                        if($isDisA !== null){
                            $sayy = "<p>In the ".addTH($isDisA)." district,  as of ".$nTime.",Their are ".$count." criminal incidents to report, would you like to hear them</p>";
                            
                        }else{
                            $sayy = "<p>Their are ".$count." criminal incidents to report, would you like to hear them</p>";
                            $isDisA = 0;
                        }
                        
                        
                        echo json_encode(array("version"=>"1.0","sessionAttributes"=>array("currentCount"=>1,"totalCount"=>$count,"crimeIncidents"=>"true","crimeHash"=>$hash,"districtNumber"=>$isDisA,"readCount"=>0),"response"=>
                            array("outputSpeech"=>
                                array("type"=>"SSML","ssml"=>"<speak>".$sayy."</speak>"),"shouldEndSession"=>false,"reprompt"=>array("outputSpeech"=>array("type"=>"SSML","ssml"=>"<speak>sooo?<s>your not going to say anything?</s></speak>")))));
                        
                        
                    }else{
                        // NO RECORD RETURNED FOR CRIME INCIDENTS
                    }
                    
                }else{
                    ///NO RECORD RETRNED FRO CURRENT HASH       
                }
                
                
            }
            
            
            
        }
        
        if($isPTime == "ER_SUCCESS_MATCH"){
            
            if($pTime == "yesterday"){
                
                $tdat = date('Y-m-d');
                $ndate = strtotime('-1 day',strtotime($tdat));
                $ndate = date('Y-m-j', $ndate);
                
                $sel = "SELECT * FROM `NewsStory` WHERE `PubDate` LIKE '%$ndate%' ORDER BY `ID` DESC ";
                $rec = mysqli_query($CONN,$sel);
                
                if(mysqli_num_rows($rec) >=1){ /// THER ARE STORIES YESTERDAY
                    
                    while($roy = mysqli_fetch_array($rec)){
                        $des = $roy['Description'];
                    }
                    
                }else{ /// NO NEWS STORIES RETURNED FOR YESTERDAY
                    
                   $se1 = "SELECT `PubDate` FROM `NewsStory` WHERE `PubDate`<= '$ndate' ORDER BY `PubDate` DESC LIMIT 0,1";
                   
                   $nres = mysqli_query($CONN, $se1);
                   $arry = mysqli_fetch_array($nres);
                   $tt = $arry['PubDate'];
                   $set = "SELECT COUNT(`PubDate`) AS ROWS FROM `NewsStory` WHERE `PubDate` LIKE '%$tt%'";
                   $gres = mysqli_query($CONN, $set);
                   $roc = mysqli_fetch_array($gres);
                   $ctrw = $roc['ROWS'];
                   
                   $neDA = date('l F jS',strtotime($tt));
                   $ti = date('Y-m-d',strtotime(time()));
                   $x_ago = dateDifference($neDA,$ti,"%d days");
                   
                   if($x_ago == "0 days"){
                       $x_ago = "today,";
                   }
                   else if($x_ago == "1 days"){
                       $x_ago = "yesterday";
                   }
                   else{
                       $x_ago = $x_ago." ago,";
                       
                   }
                   
                   
                   $say = "There are no reported news stories yesterday. However, there are '$ctrw' news stories reported '$x_ago', '$neDA'. Would you like to me to read these news stories?";
                   
                                   echo '{
                                   	"version": "1.0",
                                   	"response": {
                                   		"outputSpeech": {
                                   			"type": "PlainText",
                                               "text": "'.$say.'",
                                               "ssml": "Try Again"
                                   		},
                                   		"reprompt": null,
                                   		"sessionAttributes": {}
                                   	}
                                   }';
                   
                   
                }
                
           
                

                
                
                
                
            }
            
            
            
            
        }
        
        
        
        
        
        
        
        if($stat == "ER_SUCCESS_NO_MATCH"){
            echo '{
                	"version": "1.0",
                	"response": {
                		"outputSpeech": {
                			"type": "PlainText",
                            "text": "Try Again",
                            "ssml": "Try Again"
                		},
                		"reprompt": null,
                		"sessionAttributes": {}
                	}
                }';
        }
        
        
        
        
        
        
        
        
    }
    
                    	                



?>