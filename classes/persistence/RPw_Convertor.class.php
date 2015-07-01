<?php

class RPw_Convertor {
    
    /**
     * Parent module
     * 
     * @var RPw
     */
    private $parentModule;
    
    public function __construct($parentModule) {
        $this->parentModule = $parentModule;
    }
    
    public function temperature($value, $unit) {
        switch ($unit) {
            case 'c':
                $value = round(($value - 273.15), 0);
            break;
            case 'f':
                $value = round(($value * 9 / 5 - 459.67), 0);
            break;        
        }
        return $value; 
    }

    public function temperatureObject($value, $unit) {
        foreach ($value as $k => $v ) {
           $value->$k = $this->temperature($v, $unit);
        }
        return $value;
    }    
    
    public function speed($value, $unit) {
        $fieldSet = $this->parentModule->getSettings()->getFieldSet('windSpeed');
        switch ($unit) {
            case 'mph':
                $value = round(($value * 2.236936), 0);
            break;
            case 'kmh':
                $value = round(($value * 3.6), 0);
            break;
            case 'ms':
                $value = round(($value), 0);
            break;
//            case 'beaufort':
//                $value = round(($value), 2);
//            break;
            case 'Knots':
                $value = round(($value * 1.943845), 0);
            break;
        }
        return $value .' '. $fieldSet[$unit] ;
    }    
    
    public function pressure($value, $unit) {
        $fieldSet = $this->parentModule->getSettings()->getFieldSet('pressure');        
        switch ($unit) {
            case 'atm':
                $value = round(($value * 0.0009869), 2);
            break;
            case 'bar':
                $value = round(($value * 0.001), 2);
            break;
            case 'hPa':
                $value = round(($value * 1), 2);
            break;
            case 'kgfcm2':
                $value = round(($value * 0.00102), 2);
            break;
            case 'kgfm2':
                $value = round(($value * 10.2), 2);
            break;
            case 'kPa':
                $value = round(($value * 0.1), 2);
            break;
            case 'mbar':
                $value = round(($value * 1), 2);
            break;
            case 'mmHg':
                $value = round(($value * 0.750064), 2);
            break;
            case 'inHg':
                $value = round(($value * 0.02953), 2);
            break;
            case 'Pa':
                $value = round(($value * 100), 2);
            break;
            case 'psf':
                $value = round(($value * 2.089), 2);
            break;
            case 'psi':
                $value = round(($value * 0.0145), 2);
            break;
            case 'torr':
                $value = round(($value * 0.750064), 2);
            break;
        }
        return $value .' '. $fieldSet[$unit] ;
    }
    
    public function degree( $value ) { 
        $arr=array("N","NNE","NE","ENE","E","ESE", "SE", "SSE","S","SSW","SW","WSW","W","WNW","NW","NNW","N");
        return $arr[ abs(floor(($value + 11.25) / 22.5)) ] ;
    }    
}