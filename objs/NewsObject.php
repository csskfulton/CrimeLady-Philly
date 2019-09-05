<?php

    include_once("ConnectObject.php");
    include_once("ParserHelper.php");

    class NewsObject{
        
        var $NewsStoryID;
        var $TimeStamp;
        var $StoryAuthor;
        var $DistrictNumber;
        var $Title;
        var $URL;
        var $Description;
        var $GUID;
        var $PubDate;
        var $Category;
        var $ImageURL;
        var $ScrapeHash;
        var $TubeURL;
        var $MasterHash;
        

        
        function noMoreNewsStories(){

            $txt = '<speak>did you not hear me say, <p>there are no more stories left to read!</p> Are you hard of hearing?</speak>';
            
            $say = array("version"=>"1.0","sessionAttributes"=>"",
                "response"=>array("outputSpeech"=>array("type"=>"SSML","ssml"=>$txt),
                    "reprompt"=>null,"shouldEndSession"=>false));
            
            return json_encode($say);
            
            
        }
        
        
        function getAnotherStory($districtNumber,$totalCount,$currentCount,$readCount,$hash,$pubDate){
            
            $ress = '';
            $speaK = '';
            $f_obj = '';
            $ct = 0;
            
            $connect = new ConnectObject();
            $utils = new ParserHelper();
            
            $totalCount --;
            
            if($districtNumber == 0){
                $utils->writetoLog("DISTRICT  = 00");
                
                if($hash == 0){
                    $utils->writetoLog("NO HASH HERE");
                    $us_ql = "SELECT * FROM `NewsStory` WHERE `PubDate` LIKE '%$pubDate%' ORDER BY `PubDate` DESC LIMIT $totalCount,$currentCount";
                    
                }else{
                    $utils->writetoLog("GOT THAT HASH");
                    $us_ql = "SELECT * FROM `NewsStory` WHERE `ScrapeHash` = '$hash' ORDER BY `PubDate` DESC LIMIT $totalCount,$currentCount";
                    
                }
                
                
            }else{
                
                $utils->writetoLog("GOT A DISTRICT HERE");
                if($hash == 0){
                    $utils->writetoLog("NO HASH HERE ");
                }else{
                    $utils->writetoLog("DA HASH IS HERE ");
                    $us_ql = "SELECT * FROM `NewsStory` WHERE `ScrapeHash` = '$hash' AND `DistrictNumber` = $districtNumber ORDER BY `PubDate` DESC LIMIT $totalCount,$currentCount";
                    
                }
                
            }
            
            $us_res = mysqli_query($connect->connect(), $us_ql);
            
            $roe = mysqli_fetch_array($us_res);
            $cattt = $roe['Category'];
            
            
            $newsNum = "<p>story number ".$readCount.",</p> ";
            $kepg = " <p>would you like me to read the next story?</p>";
            $ending2 = "<p> ,there are no more stories to report, would you like me to help you with something else?</p>";
            
            
            $desc = utf8_encode($utils->cleanTxT($roe['Description']));
            //$desc = utf8_encode($roe['Description']);
            $speaK = '<p>'.$desc.'</p>';
            
            $utils->writetoLog("ABOTU TO SAY @@".$speaK);
            
            $readCount ++;
            
            if($totalCount == 0){
                $spea = $newsNum.$speaK.$ending2;
                
                $ress = json_encode(array("version"=>"1.0","sessionAttributes"=>array("districtNews"=>true,"totalCount"=>$totalCount,"currentCount"=>1,"Hash"=>$hash,"readCount"=>$readCount),"response"=>
                    array("outputSpeech"=>
                        array("type"=>"SSML","ssml"=>"<speak>".$spea."</speak>"),"shouldEndSession"=>false,"reprompt"=>null)));
                
                
            }else{
                $spea = $newsNum.$speaK.$kepg;
                
                $ress = json_encode(array("version"=>"1.0","sessionAttributes"=>array("districtNews"=>true,"totalCount"=>$totalCount,"currentCount"=>1,"Hash"=>$hash,"readCount"=>$readCount,"pubDate"=>$pubDate),"response"=>
                    array("outputSpeech"=>
                        array("type"=>"SSML","ssml"=>"<speak>".$spea."</speak>"),"shouldEndSession"=>false,"reprompt"=>null)));
                
                
            }
            
            
            
            
            $utils->writetoLog("PASSING THIS  ".$ress);
            
            return $ress;
            
            
        }
        
  
        
        
        function getYesterdayNews($districtNumber){
            
            $connect = new ConnectObject();
            $utils = new ParserHelper();
            date_default_timezone_set('US/Eastern');
            $say = '';
            $totalCount = '';
            $pubDate = '';
                
                $utils->writeToLog("YESTERDAY NO DISTRICT");
                $tDate = date('Y-m-d');
                $pubDate = date('Y-m-d', (strtotime ('-1 day', strtotime($tDate))));
                
                if($districtNumber == 0){
                   
                    $sel = "SELECT COUNT(`PubDate`) AS COUNT FROM `NewsStory` WHERE `PubDate` LIKE '%$pubDate%'";
                    
                }else{
                    
                    $sel = "SELECT COUNT(`PubDate`) AS COUNT FROM `NewsStory` WHERE `PubDate` LIKE '%$pubDate%' AND `DistrictNumber` = '$districtNumber'";
                    
                }
                
                $res = mysqli_query($connect->connect(),$sel);
                $utils->writeToLog("RAN THIS QUERY: ".$sel);
                
                if($res){ 
                    
                    $arr = mysqli_fetch_array($res);
                    $totalCount = $arr['COUNT'];
                    $utils->writeToLog("DA COUNT111 ".$totalCount);
                    
                    if($totalCount == 0){ // NO NEWS STORY YESTERDAY
                        
                        if($districtNumber == 0){
                            
                            $sel1 = "SELECT `PubDate` FROM `NewsStory` WHERE `PubDate` < '$pubDate' ORDER BY `PubDate` DESC LIMIT 0,1";
                            
                        }else{
                            
                            $sel1 = "SELECT `PubDate` FROM `NewsStory` WHERE `PubDate` < '$pubDate' AND `DistrictNumber` = '$districtNumber' ORDER BY `PubDate` DESC LIMIT 0,1";
                            
                        }
                        
                            $res1 = mysqli_query($connect->connect(), $sel1);
                            $utils->writeToLog("RAN THIS QUERY: ".$sel1);
                            
                            if($res1){
                                
                                $arr1 = mysqli_fetch_array($res1);
                               // $hash = $arr1['ScrapeHash'];
                                $h9 = explode(" ",$arr1['PubDate']);
                                $pubDate = $h9[0];
                                $utils->writeToLog("DA DATE RETURNED-  ".$pubDate);
                                if($districtNumber == 0){
                                    
                                    $sel3 = "SELECT COUNT(`PubDate`) AS COUNT FROM `NewsStory` WHERE `PubDate` LIKE '%$pubDate'%";
                                    
                                }else{
                                    
                                    $sel3 = "SELECT COUNT(`PubDate`) AS COUNT FROM `NewsStory` WHERE `PubDate` LIKE '%$pubDate%' AND `DistrictNumber` = '$districtNumber'";
                                    
                                }
                                
                                $res3 = mysqli_query($connect->connect(), $sel3);
                                $utils->writeToLog("RAN THIS QUERY 333: ".$sel3);
                                
                                    if($res3){
                                        
                                        $arr3 = mysqli_fetch_array($res3);
                                        $totalCount = $arr3['COUNT'];
                                        $utils->writeToLog("RAN THIS QUERY 333: ".$totalCount);
                                        
                                        $now = date('Y-m-d');
                                        $then = date('Y-m-d', strtotime($pubDate));
                                        $lName = date('l F jS,', strtotime($then));
                                        
                                        $x_ago = $utils->dateDifference($now, $then, "%d days");
                                        
                                        
                                        
                                        $utils->writeToLog("AGO ".$x_ago);
                                        
                                        if($x_ago == "0 days"){
                                            $x_ago = "today, ".$lName;
                                        }
                                        else if($x_ago == "1 days"){
                                            $x_ago = "yesterday, ".$lName;
                                        }
                                        else{
                                            $x_ago = $x_ago." ago, ".$lName;
                                            
                                        }
                                        
                                        if($totalCount == 1){
                                            
                                            if($districtNumber == 0){
                                                $say = '<p>There were no reported news stories yesterday, however</p> <s>there is one news story '.$x_ago.' would you like me to read this story?</s>';
                                                
                                            }else{
                                                $say = '<p>There were no reported news stories in the '.$utils->addTH($districtNumber).' district yesterday, however</p> <s>there is one news story '.$x_ago.' would you like me to read this story?</s>';
                                                
                                            }
                                            
                                           
                                        }else{
                                         // MORE THEN ONE NEWS STORY  
                                            if($districtNumber == 0){
                                                $say = '<p>There were no reported news stories yesterday, however</p> <s>there are '.$totalCount.' news stories '.$x_ago.' would you like me to read this story?</s>';
                                                
                                            }else{
                                                
                                                $say = '<p>There were no reported news stories in the '.$utils->addTH($districtNumber).' district yesterday, however</p> <s>there are '.$totalCount.' news stories '.$x_ago.' would you like me to read this story?</s>';
                                                
                                            }
                                         
                                            
                                        }
                                        
                                        
                                        
                                    }
                                
                                
                            }
                            
                        }else{
                            /// THERE IS A YESTERDAY STORY

                            $utils->writeToLog("RAN THIS QUERY 999: ");
                            $lName = date('l F jS,', strtotime($pubDate));
                            
                            if($totalCount == 1){
                                if($districtNumber == 0){
                                    $say = 'There is one reported news story yesterday, '.$lName.' would you like me to read this story?';
                                    
                                }else{
                                    $say = 'There is one reported news story in the '.$utils->addTH($districtNumber).' district yesterday, '.$lName.' would you like me to read this story?';
                                    
                                }
                               
                            }else{
                                // MORE THEN ONE NEWS STORY
                                if($districtNumber == 0){
                                    
                                    $say = 'There were '.$totalCount.' reported news stories yesterday, '.$lName.' would you like me to read these news stories?';
                                    
                                }else{
                                    
                                    $say = 'There were '.$totalCount.' reported news stories in the '.$utils->addTH($districtNumber).' district yesterday, '.$lName.' would you like me to read these news stories?';
                                    
                                }
                                
                                
                            }
                            
                        }
                    
                    
                    
                    
                }else{
                    
                    /// FIRST QUERY FAILED TO GET COUNT
                    
                    
                }
                
                
                $ress = json_encode(array("version"=>"1.0","sessionAttributes"=>array("districtNews"=>true,"pubDate"=>$pubDate,"districtNumber"=>0,"totalCount"=>$totalCount,"currentCount"=>1,"readCount"=>1),"response"=>
                    array("outputSpeech"=>
                        array("type"=>"SSML","ssml"=>"<speak>".$say."</speak>"),"shouldEndSession"=>false,"reprompt"=>null)));
                
                return $ress;
                
                
            
            
            
            
        }
        
        
        
        
        
        function getLastDistrictNews($isDisA){
            
            $connect = new ConnectObject();
            $utils = new ParserHelper();
            date_default_timezone_set('US/Eastern');
            
            $array = array();
            if($isDisA == 0){
                $ch = "SELECT `TimeStamp`,`Hash` FROM `CurrentHash` WHERE `HashName` = 'NewsStory'";
            }else{
                $ch = "SELECT `TimeStamp`, `ScrapeHash` FROM `NewsStory` WHERE `DistrictNumber` = $isDisA ORDER BY `TimeStamp` DESC LIMIT 0,1";
                
                
            }
            
            $reyt = mysqli_query($connect->connect(), $ch);
            
            $speaK = '';
            $f_obj = '';
            $ct = 0;
            $cat_ct = array();
            
            if(mysqli_num_rows($reyt) >=1){  /// FETCHING CURRENT HASH
                $row = mysqli_fetch_array($reyt);
                
                if($isDisA == 0){
                    $hash = $row['Hash'];
                }else{
                    
                    $hash = $row['ScrapeHash'];
                }
 
                $tDATE = $row['TimeStamp'];
                

                if($isDisA !== 0){
                    $sql = "SELECT COUNT(*) AS ROWS FROM `NewsStory` WHERE `DistrictNumber` = $isDisA AND `ScrapeHash` = '$hash'";
                    $sql1 = "SELECT `PubDate` FROM `NewsStory` WHERE `DistrictNumber` = $isDisA AND `ScrapeHash` = '$hash' ORDER BY `PubDate` DESC LIMIT 0,1";
                    
                }else{
                    $sql = "SELECT COUNT(*) AS ROWS FROM `NewsStory` WHERE `ScrapeHash` = '$hash'";
                    $sql1 = "SELECT `PubDate` FROM `NewsStory` WHERE `ScrapeHash` = '$hash' ORDER BY `PubDate` DESC LIMIT 0,1";
                    
                }
                
                $utils->writeToLog("SQL ".$sql);
                $utils->writeToLog("SQL ".$sql1);
                $rep = mysqli_query($connect->connect(), $sql);
                $rep1 = mysqli_query($connect->connect(), $sql1);
                
                
                if(mysqli_num_rows($rep) >= 1){ /// FETCHING DATA WITH CURRENT HASH
                    
                    $rowD = mysqli_fetch_array($rep);
                    $rowD1 = mysqli_fetch_array($rep1);
                    
                    $total_ct = $rowD['ROWS'];
                    $f_obj = $rowD1['PubDate'];
                    $utils->writeToLog("TCO?U ".$total_ct);
                    
                    
                    $tix = date('Y-m-d',strtotime($f_obj));
                    $td2 = date('Y-m-d');
                    $ti = date('l F jS, h:i a',strtotime($f_obj));
                    $utils->writeToLog("DATE 1 ".$ti);
                    $utils->writeToLog("DATE 2 ".$td2);
                    $x_ago = $utils->dateDifference($tix,$td2,"%d days");
                    $utils->writeToLog("AGO ".$x_ago);
                    
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
                    
                    
                    
                    if($total_ct == 1){ //change message to provoke user to say something else
                        //singular
                        if($isDisA !== 0){
                            $sayy = '<s>Here is the latest police news for the '.$utils->addTH($isDisA).' district, As of '.$ti.', There is one news story to report</s> '.$speaK.$ending;
                            
                        }else{
                            //$sayy = '<s>Here is the latest police news update!. As of '.$ti.', There is '.$total_ct.' story to report</s> '.$speaK.$ending1;
                            $sayy = '<s>Here is the latest police news update! As of '.$x_ago.' '.$ti.', There is one news story to report</s> '.$speaK.$ending1;
                        }
                        
                        
                    }else{
                        //plural
                        if($isDisA !== 0){
                            $sayy = '<s>Here is the latest police news for the '.$utils->addTH($isDisA).' district, As of '.$ti.', There are '.$total_ct.' stories to report</s> '.$speaK.$ending;
                            
                        }else{
                            $sayy = '<s>Here is the latest police news update!. As of '.$ti.', There are '.$total_ct.' stories to report</s> '.$speaK.$ending;
                            
                        }
                    }

                    
                    return json_encode(array("version"=>"1.0","sessionAttributes"=>array("totalCount"=>$total_ct,"districtNews"=>true,"currentCount"=>1,"Hash"=>$hash,"readCount"=>1),"response"=>
                        array("outputSpeech"=>
                            array("type"=>"SSML","ssml"=>"<speak>".$sayy."</speak>"),"shouldEndSession"=>false,"reprompt"=>array("outputSpeech"=>array("type"=>"SSML","ssml"=>"<speak>sooo?<s>your not going to say anything?</s></speak>")))));
                    
                    
                    
                    
                }else{
                    
                    if($isDisA !== 0){ /// DISTRICT  NUMBER PROVIDED
                        
                        $sql = "SELECT `TimeStamp` FROM `NewsStory` WHERE `DistrictNumber` = $isDisA ORDER BY `TimeStamp` DESC LIMIT 1";
                        $ret = mysqli_query($connect->connect(), $sql);
                        $arF = mysqli_fetch_array($ret);
                        $tStamp = $arF['TimeStamp'];
                        $hals = explode(" ",$tStamp);
                        $nStam = $hals[0];
                        
                        $sql_1 = "SELECT SQL_CALC_FOUND_ROWS `TimeStamp` FROM `NewsStory` WHERE `TimeStamp` LIKE '%'.$nStam.'%'";
                        $sql_11 = "SELECT FOUND_ROWS() AS ROWS";
                        
                        $ret1 = mysqli_query($connect->connect(), $sql_1);
                        $ret11 = mysqli_query($connect->connect(), $sql_11);
                        
                        $ctRows = mysqli_fetch_array($ret11);
                        $ctA = $ctRows['ROWS'];
                        $ti = date('Y-m-d',strtotime($nStam));
                        $ti_dd = date('l F jS',strtotime($nStam));
                        $td2 = date('Y-m-d');
                        $x_ago = $utils->dateDifference($td2,$ti,"%d days");
                        $ending = "<s> would you like me to continue reading?</s>";
                        $endings = "<s> would you like me to continue reading?</s>";
                        $ending1 = "<s> would you like me to read this news story?</s>";
                        $disNUM = $isDisA;
                        
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
                            $sayy = '<s>Here is the latest police news for the '.$utils->addTH($isDisA).' district, '.$x_ago.' '.$ti_dd.', There is '.$ctA.' story to report</s> '.$ending1;
                            
                            
                        }else{
                            //plural
                            $sayy = '<s>Here is the latest police news for the '.$utils->addTH($isDisA).' district, As of '.$x_ago.' on '.$ti_dd.', There are '.$ctA.' stories to report</s> '.$endings;
                            
                        }
                        
                        
                        return json_encode(array("version"=>"1.0","sessionAttributes"=>array("SQL"=>$sql_1,"totalCount"=>$ctA,"districtNews"=>true,"currentCount"=>"1","districtNumber"=>$disNUM,"pubDate"=>$nStam),"response"=>
                            array("outputSpeech"=>
                                array("type"=>"SSML","ssml"=>"<speak>".$sayy."</speak>"),"shouldEndSession"=>false,"reprompt"=>array("outputSpeech"=>array("type"=>"SSML","ssml"=>"<speak>sooo?<s>your not going to say anything?</s></speak>")))));
                        
                        
                        
                    }else{
                        
                        
                    }
                    
                    
                    
                }
                
                //   NO news returned from the SQL query
                
                
            }
            
            
        }
        
        function setNewsStoryID($NewsStoryID) { $this->NewsStoryID = $NewsStoryID; }
        function getNewsStoryID() { return $this->NewsStoryID; }
        function setTimeStamp($TimeStamp) { $this->TimeStamp = $TimeStamp; }
        function getTimeStamp() { return $this->TimeStamp; }
        function setStoryAuthor($StoryAuthor) { $this->StoryAuthor = $StoryAuthor; }
        function getStoryAuthor() { return $this->StoryAuthor; }
        function setDistrictNumber($DistrictNumber) { $this->DistrictNumber = $DistrictNumber; }
        function getDistrictNumber() { return $this->DistrictNumber; }
        function setTitle($Title) { $this->Title = $Title; }
        function getTitle() { return $this->Title; }
        function setURL($URL) { $this->URL = $URL; }
        function getURL() { return $this->URL; }
        function setDescription($Description) { $this->Description = $Description; }
        function getDescription() { return $this->Description; }
        function setGUID($GUID) { $this->GUID = $GUID; }
        function getGUID() { return $this->GUID; }
        function setPubDate($PubDate) { $this->PubDate = $PubDate; }
        function getPubDate() { return $this->PubDate; }
        function setCategory($Category) { $this->Category = $Category; }
        function getCategory() { return $this->Category; }
        function setImageURL($ImageURL) { $this->ImageURL = $ImageURL; }
        function getImageURL() { return $this->ImageURL; }
        function setScrapeHash($ScrapeHash) { $this->ScrapeHash = $ScrapeHash; }
        function getScrapeHash() { return $this->ScrapeHash; }
        function setTubeURL($TubeURL) { $this->TubeURL = $TubeURL; }
        function getTubeURL() { return $this->TubeURL; }
        function setMasterHash($MasterHash) { $this->MasterHash = $MasterHash; }
        function getMasterHash() { return $this->MasterHash; }
        
    }


?>
