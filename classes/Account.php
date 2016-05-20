<?php
        
class Account {
    
    function __construct($account_holder, $account_number, $currency, $balance, $withdrawals, $deposits) {
        $this->account_holder = $account_holder;
        $this->account_number = $account_number;
        $this->currency = $currency;
        $this->balance = $balance;
        $this->withdrawals = $withdrawals;
        $this->deposits = $deposits;
    }

    var $account_holder;
    var $account_number;
    var $currency;
    var $balance;
    var $withdrawals;
    var $deposits;
}