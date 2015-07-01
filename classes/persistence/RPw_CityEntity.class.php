<?php
use Webcodin\WCPOpenWeather\Core\Agp_Entity;

class RPw_CityEntity extends Agp_Entity {
    
    private $name;
    
    private $coord;
    
    private $country;
        
    public function __construct($data) {
        $default = array(
            'ID' => NULL, 
        );

        parent::__construct($data, $default); 
    }
    
    public function getName() {
        return $this->name;
    }

    public function getCoord() {
        return $this->coord;
    }

    public function getCountry() {
        return $this->country;
    }

    public function setName($name) {
        $this->name = $name;
        return $this;
    }

    public function setCoord($coord) {
        $this->coord = $coord;
        return $this;
    }

    public function setCountry($country) {
        $this->country = $country;
        return $this;
    }

}
