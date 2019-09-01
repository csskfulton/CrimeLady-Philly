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
        

        
        function getAnotherStory($districtNumber,$totalCount,$currentCount,$readCount,$hash){
            
            $ress = '';
            $speaK = '';
            $f_obj = '';
            $ct = 0;
            
            $connect = new ConnectObject();
            $utils = new ParserHelper();
            
            $totalCount --;
            
            if($districtNumber == 0){
                $us_ql = "SELECT * FROM `NewsStory` WHERE `ScrapeHash` = '$hash' ORDER BY `PubDate` DESC LIMIT $totalCount,$currentCount";
                
            }else{
                $us_ql = "SELECT * FROM `NewsStory` WHERE `ScrapeHash` = '$hash' AND `DistrictNumber` = $districtNumber ORDER BY `PubDate` DESC LIMIT $totalCount,$currentCount";
                
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
            
            $utils->writetoLog($speaK);
            
            $readCount ++;
            
            if($totalCount == 0){
                $spea = $newsNum.$speaK.$ending2;
                
                $ress = json_encode(array("version"=>"1.0","sessionAttributes"=>array("totalCount"=>$totalCount,"currentCount"=>1,"Hash"=>$hash,"readCount"=>$readCount),"response"=>
                    array("outputSpeech"=>
                        array("type"=>"SSML","ssml"=>"<speak>".$spea."</speak>"),"shouldEndSession"=>false,"reprompt"=>null)));
                
                
            }else{
                $spea = $newsNum.$speaK.$kepg;
                
                $ress = json_encode(array("version"=>"1.0","sessionAttributes"=>array("totalCount"=>$totalCount,"currentCount"=>1,"Hash"=>$hash,"readCount"=>$readCount),"response"=>
                    array("outputSpeech"=>
                        array("type"=>"SSML","ssml"=>"<speak>".$spea."</speak>"),"shouldEndSession"=>false,"reprompt"=>null)));
                
                
            }
            
            
            
            
            $utils->writetoLog($ress);
            
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
