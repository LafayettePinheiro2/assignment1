<?php

class Customer {
    
    var $id;
    var $name;
    var $surname;
    var $birthdate;
    var $address;
    var $total_money;  
    
    function getId() {
        return $this->id;
    }

    function getName() {
        return $this->name;
    }

    function getSurname() {
        return $this->surname;
    }

    function getBirthdate() {
        return $this->birthdate;
    }

    function getAddress() {
        return $this->address;
    }

    function getTotal_money() {
        return $this->total_money;
    }

        function __construct($id, $name, $surname, $birthdate, $address, $total_money) {
        $this->id = $id;
        $this->name = $name;
        $this->surname = $surname;
        $this->birthdate = $birthdate;
        $this->address = $address;
        $this->total_money = $total_money;
    }

}