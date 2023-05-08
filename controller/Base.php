<?php

namespace Controller;

class Base {
    
    private $title;

    public function __construct() {
        self::setTittle('');
    }

    public function getTitle() {
        return $this->title;
    }

    public function setTitle($title = '') {
        return $this->title = $title;
    }

}
