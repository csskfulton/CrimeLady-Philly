<?php 

class IntentObject{
    
    
    public const isMatch = 'ER_SUCCESS_MATCH';
    public const isNotMatch = 'ER_SUCCESS_NO_MATCH';
    
    
    var $isPresentTime;
    var $isDistrict;
    var $isCrimeType;
    
    var $presentTime;
    var $district;
    var $crimeType;
    
    function setIsPresentTime($isPresentTime) { $this->isPresentTime = $isPresentTime; }
    function getIsPresentTime() { return $this->isPresentTime; }
    function setIsDistrict($isDistrict) { $this->isDistrict = $isDistrict; }
    function getIsDistrict() { return $this->isDistrict; }
    function setIsCrimeType($isCrimeType) { $this->isCrimeType = $isCrimeType; }
    function getIsCrimeType() { return $this->isCrimeType; }

    
    function setPresentTime($presentTime) { $this->presentTime = $presentTime; }
    function getPresentTime() { return $this->presentTime; }
    function setDistrict($district) { $this->district = $district; }
    function getDistrict() { return $this->district; }
    function setCrimeType($crimeType) { $this->crimeType = $crimeType; }
    function getCrimeType() { return $this->crimeType; }
    



}





?>