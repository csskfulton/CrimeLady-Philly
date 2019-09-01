<?php 


    class ParserHelper{
        
        
        function writeToLog($var){
            file_put_contents('test.txt', $var."\n",FILE_APPEND);
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
        
        
        function dateDifference($date_1 , $date_2 , $differenceFormat = '%a' ){
            
            $datetime1 = date_create($date_1);
            $datetime2 = date_create($date_2);
            
            $interval = date_diff($datetime1, $datetime2);
            
            return $interval->format($differenceFormat);
            
        }
        
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
        
        
        
        function fixAddress($location){
            
            $loc = $location;
            
            if(strpos($loc,"BLOCK")>=1){
                $arB = explode(" BLOCK ",$loc);
                $nADD =  ParserHelper::cvNum($arB[0])." block of ";
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
        
        
        function fetchShootArray($arr){
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
                
                
                $location = ParserHelper::fixAddress($location);
                
                
                $txt .= "<speak><p>In the ".$dist."th district, on ".$daa.", around ".$timeF.", A ".$pol." ".$sex.", age ".$age.", was wounded ".$wound.", on the ".$location."</p></speak>";
                //array_push($array,$txt);
                
            }
            
            return $txt;
            
        }
        
        
        
        
        function cleanTxT($fgg){
            
            $coo = $fgg;
            
            if(strpos($coo,"&#8217;") >=1){
                $coo = str_replace("&#8217;","'",$coo);
            }
            
            if(strpos($coo,"&#8243;") >=1){
                $coo = str_replace("&#8243;","'",$coo);
            }
            if(strpos($coo,"&#8220;") >=1){
                $coo = str_replace("&#8220;","'",$coo);
            }
            
            if(strpos($coo,"&#8221;") >=1){
                $coo = str_replace("&#8221;","'",$coo);
            }
            if(strpos($coo,"&#8242;") >=1){
                $coo = str_replace("&#8242;","'",$coo);
            }
            
            
            
            
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
            if(strpos($coo,$dtS2) >= 1){
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
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
    }















?>