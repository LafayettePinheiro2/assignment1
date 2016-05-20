<?php

include "classes/Customer.php";
include "classes/Account.php";
include "classes/Transaction.php";


function accounts_has_transactions (array $accounts) {
    $transactions = get_all_transactions();
    foreach($accounts as $account) {
        for($i=0; $i<count($transactions); $i++) {
            if($transactions[$i]->account_number == $account->account_number){
                return true;
            }
        }
    }
    return false;
    
}

function customer_has_accounts($customers_id) {
    $accounts = get_all_accounts();
    if($accounts) {
        for($i=0; $i<count($accounts); $i++) {
            if($accounts[$i]->account_holder == $customers_id){
                return true;
            }
        }
    } else {
        return false;
    }
    
    return false;
}

function write_sum_money($customer_id, $sum_money){    
    $filename = 'files/customers.csv';   
    $content = file_get_contents($filename);
    //remove blank spaces between one data and other
    $content = str_replace(", ", ",", $content);
    $content = str_replace(" ,", ",", $content);
    $content = str_replace(" , ", ",", $content);
    
    $customer = get_customer($customer_id);
    $data_old = $customer->id.','.$customer->name.','.$customer->surname.','.$customer->birthdate.','.$customer->address.','.$customer->total_money; 
    $data_new = $customer->id.','.$customer->name.','.$customer->surname.','.$customer->birthdate.','.$customer->address.','.$sum_money; 
    $content = str_replace($data_old, $data_new, $content);
    
    file_put_contents($filename, $content);
}

function write_withdrawals_deposits_account($account_number, $withdrawals, $deposits) {    
    $filename = 'files/accounts.csv';   
    $content = file_get_contents($filename);
    
    //remove blank spaces between one data and other
    $content = str_replace(", ", ",", $content);
    $content = str_replace(" ,", ",", $content);
    $content = str_replace(" , ", ",", $content);
    
    $account = get_account($account_number);
    $data_old = $account->account_holder.','.$account->account_number.','.$account->currency.','.$account->balance.','.$account->withdrawals.','.$account->deposits;   
    $data_new = $account->account_holder.','.$account->account_number.','.$account->currency.','.$account->balance.','.$withdrawals.','.$deposits;   
    $content = str_replace($data_old, $data_new, $content);
    
    file_put_contents($filename, $content);    
}


function print_customer_total_money($customer_id) {
    $total_money = 0;
    
    $customer_accounts = get_customer_accounts($customer_id);
    for($i=0; $i<count($customer_accounts); $i++){
        $total_money += $customer_accounts[$i]->balance;
    }
    
    return $total_money;
}

function print_account_withdrawals($account_number) {   
    $transactions = get_transactions_by_account($account_number);
    $withdrawals = 0;
    for($i=0; $i<count($transactions); $i++){
        if(strtolower($transactions[$i]->type) == 'withdrawal'){
            $withdrawals += 1;
        }
    }
    
    return $withdrawals;
}

function print_account_deposits($account_number) {   
    $transactions = get_transactions_by_account($account_number);
    $deposits = 0;
    for($i=0; $i<count($transactions); $i++){
        if(strtolower($transactions[$i]->type) == 'deposit'){
            $deposits += 1;
        }
    }
    
    return $deposits;
}

function get_transactions_by_account($account_number){
    $transactions = get_all_transactions();
    $transactions_return = array();
    
    for($i=0; $i<count($transactions); $i++){
        if ($account_number == $transactions[$i]->account_number){
            $transactions_return[] = $transactions[$i];
        }
    }
    if(count($transactions_return) == 0) {
        return false;
    }
    return $transactions_return;
}

function check_valid_account_number($account_number) {
    $account_numbers = get_all_account_numbers();
    return in_array($account_number, $account_numbers);
}

//transaction type must be withdrawal or deposit
function check_valid_transaction_type($type) {
    return (strtolower($type) == 'withdrawal' || strtolower($type) == 'deposit');
}

function generate_new_account_number() {
    $account_numbers = get_all_account_numbers();   
    return (max($account_numbers)+1);
}

function get_all_account_numbers() {
    $account_numbers = array();
    $accounts = get_all_accounts();
    for($i=0; $i<count($accounts); $i++){
        $account_numbers[] = $accounts[$i]->account_number;
    } 
    return $account_numbers;
}

function is_valid_account_holder($account_holder) {
    $ids = get_all_customers_ids();
    return in_array($account_holder, $ids);
}

function save_customer($id, $name, $surname, $birthdate, $address) {   
    $filename = 'files/customers.csv';
    $data = $id . ',' . $name. ','. $surname. ','. $birthdate.','.$address.',0 '.PHP_EOL;    
    return file_put_contents($filename, $data, FILE_APPEND);     
}

function save_account($account_holder, $account_number, $currency, $balance, $withdrawals, $deposits) {  
    $filename = 'files/accounts.csv';
    $data = $account_holder . ',' . $account_number. ','. $currency. ','.$balance.','. $withdrawals.','.$deposits.' '.PHP_EOL;           
    return file_put_contents($filename, $data, FILE_APPEND);       
}

function save_transaction($type, $value, $account_number, $timestamp_date){
    $filename = 'files/transactions.csv';   
    $data = $type. ',' .$value. ','.$account_number.','.$timestamp_date.' '.PHP_EOL;
    return file_put_contents($filename, $data, FILE_APPEND);   
}

//checks the biggest Id saved and return this ID plus one for a new customer
function generate_new_id ($counter) {
    $ids = get_all_customers_ids();
    
    if(!is_array($ids)){
        return $counter+1;
    }
    $high_id = max($ids);    
    return $high_id+1;
}

function get_all_customers_ids(){
    $ids = array();
    $customers = get_all_customers();
    if($customers == false || count($customers) == 0){
        return false;
    }
    for($i=0; $i<count($customers); $i++){
        $ids[] = $customers[$i]->id;
    }
    return $ids;
}

function get_time ($date) {
    
    $day = substr($date, 0, 2);
    $month = substr($date, 3, 2);
    $year = substr($date, 6, 4);
    
    return strtotime($day.'/'.$month.'/'.$year);
}


function check_valid_date ($date) {
    $day = (int) substr($date, 0, 2);
    $month = (int)substr($date, 3, 2);
    $year = (int)substr($date, 6, 4);        
    return checkdate($month, $day, $year);
}

    
function get_customer_accounts($customer_id){
    $accounts = get_all_accounts();
    if(count($accounts) == 0 || $accounts == false){
        return false;
    }
    $accounts_return = array();
    foreach($accounts as $account){
        if($account->account_holder == $customer_id){
            $accounts_return[] = $account;
        }
    }
    
    if(count($accounts_return) > 0) {        
        return $accounts_return;
    } else {
        return false;
    }
}

function get_accounts_transactions_by_value(array $accounts, $order = 'asc') {
    function ccomp_desc($a, $b)
    {
        if ($a->value == $b->value) {
            return 0;
        }            
        return ($a->value < $b->value) ? 1 : -1;        
    }
    
    function ccomp_asc($a, $b)
    {
        if ($a->value == $b->value) {
            return 0;
        }            
        return ($a->value < $b->value) ? -1 : 1;        
    }       
    if($order == 'desc'){
        usort($accounts, 'ccomp_desc');
    } else {
        usort($accounts, 'ccomp_asc');
    }        
    
    return $accounts;
}

function get_accounts_transactions_by_date(array $accounts, $order = 'asc') {
    
    function comp_desc($a, $b)
    {
        if ($a->date == $b->date) {
            return 0;
        }            
        return ($a->date < $b->date) ? 1 : -1;        
    }
    
    function comp_asc($a, $b)
    {
        if ($a->date == $b->date) {
            return 0;
        }            
        return ($a->date < $b->date) ? -1 : 1;        
    }       
    if($order == 'desc'){
        usort($accounts, 'comp_desc');
    } else {
        usort($accounts, 'comp_asc');
    }        
    
    return $accounts;
}

function get_accounts_transactions($accounts){
    if (!is_array($accounts)) {
        return false;
    }
    
    $transactions = get_all_transactions();
    $transactions_return = array();
    
    foreach($accounts as $account){
        for($i=0; $i<count($transactions); $i++){
            if ($account->account_number == $transactions[$i]->account_number){
                $transactions_return[] = $transactions[$i];
            }
        }
    }
    
    if (count($transactions_return) == 0) {
        return false;
    }
    
    return $transactions_return;
}


function get_customer($customer_id){
    $customers = get_all_customers();
    for($i=0; $i<count($customers); $i++){
        if ($customers[$i]->id == $customer_id){
            return $customers[$i];
        } 
    }
}

function get_account($account_number){
    $accounts = get_all_accounts();
    for($i=0; $i<count($accounts); $i++){
        if ($accounts[$i]->account_number == $account_number){
            return $accounts[$i];
        } 
    }
}


function get_all_customers(){            
    $customers = get_all_entities('customer');
    return $customers;            
}

function get_all_transactions(){            
    $transactions = get_all_entities('transaction');
    return $transactions;            
}

function get_all_accounts(){            
    $accounts = get_all_entities('account');    
    return $accounts;     
}

function get_all_entities($entity){
    $returns = array();
    $filename = 'files/'.$entity.'s.csv';   
    $count = 0;
    
    if( !file_exists ($filename)) {
        return false;
    }
    if(filesize($filename) == 0){
        return false;
    }

    $file = fopen($filename, "r");
    while(!feof($file)){
        $return = fgets($file); 
        if($return == PHP_EOL || $return == false){
            continue;
        }
        if($entity == 'customer'){
            list($id, $name, $surname, $birthdate, $address, $total_money) = array_map('trim', explode(",", $return));
            $return_obj = new Customer($id, $name, $surname, $birthdate, $address, $total_money);
        } else if($entity == 'account') {
            list($account_holder, $account_number, $currency, $balance, $withdrawals, $deposits) = array_map('trim', explode(",", $return));        
            $return_obj = new Account($account_holder, $account_number, $currency, $balance, $withdrawals, $deposits); 
        } else if($entity == 'transaction') {
            list($type, $value, $account_number, $date) = array_map('trim',explode(",",$return));
            $return_obj = new Transaction($type, $value, $account_number, $date);     
        } else {
            return false;
        }
        
        $returns[] = $return_obj;
        $count++;
    }
    fclose($file);       
    return $returns;   
}