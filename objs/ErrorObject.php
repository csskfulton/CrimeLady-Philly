<?php 

    include_once("ParserHelper.php");



    class ErrorObject{
        
        
        function wrongDistrict(){
            
            $txt = '<speak>Sorry! you did not provide a valid police district number. Please try your request again.</speak>';
            
            $say = array("version"=>"1.0","sessionAttributes"=>"",
                "response"=>array("outputSpeech"=>array("type"=>"SSML","ssml"=>$txt),
                    "reprompt"=>null,"shouldEndSession"=>false));
            
            return json_encode($say);
            
            
            
        }
        
        function wrongCrimeType(){
            
            $txt = '<speak>Sorry! you did not provide a valid police crime that I understand. Please try your request again.</speak>';
            
            $say = array("version"=>"1.0","sessionAttributes"=>"",
                "response"=>array("outputSpeech"=>array("type"=>"SSML","ssml"=>$txt),
                    "reprompt"=>null,"shouldEndSession"=>false));
            
            return json_encode($say);
            
            
            
        }
        
        
        
        
        
    }














?>