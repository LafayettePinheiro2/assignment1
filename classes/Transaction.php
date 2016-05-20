<?php

class Transaction {
    
    function __construct($type, $value, $account_number, $date) {
        $this->type = $type;
        $this->value = $value;
        $this->account_number = $account_number;
        $this->date = $date;
    }

    var $type;
    var $value;
    var $account_number;
    var $date;
}