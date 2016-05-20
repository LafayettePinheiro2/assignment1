<?php
    session_start();
    unset($_SESSION['error_msg']);
    unset($_SESSION['success_msg']);
    
    include "functions.php";

    $page_redirect = $_SERVER['HTTP_REFERER'];    
    $filename_temp = $_FILES["fileToUpload"]["tmp_name"];
    
    if($_FILES["fileToUpload"]["type"] != 'text/csv'){
        
        $_SESSION['error_msg'] = '<div class="container">
            <div class="alert alert-danger">
                <span>The file must be in <strong>.csv</strong> format.</span>
            </div>
        </div>';        
        
        header("Location: {$page_redirect}"); /* Redirect browser */
        exit();
    }

    $file = fopen($filename_temp, "r");
    while(!feof($file)){
        $line = fgets($file);
        list($type, $value, $account_number, $date) = array_map('trim', explode(",", $line));
          
        if($type == "" || $value == "" || $account_number == "" || $date == ""){
        
            header("Location: {$page_redirect}"); /* Redirect browser */
            exit();
        }
        
        if(check_valid_date($date) !== true){            
           
            $_SESSION['error_msg'] = '<div class="container">
                <div class="alert alert-danger">
                    <span>The date must be in the format dd/mm/yyyy. The date '.$date.' was given</span>
                </div>
            </div>';
        
            header("Location: {$page_redirect}"); /* Redirect browser */
            exit();
        }
        
        if(check_valid_transaction_type($type) !== true){            
           
            $_SESSION['error_msg'] = '<div class="container">
                <div class="alert alert-danger">
                    <span>The transaction type must be withdrawal or deposit. '.$type.' was given.</span>
                </div>
            </div>';
        
            header("Location: {$page_redirect}"); /* Redirect browser */
            exit();
        }
        
        if(check_valid_account_number($account_number) !== true){            
           
            $_SESSION['error_msg'] = '<div class="container">
                <div class="alert alert-danger">
                    <span>This account number : '.$account_number.' is not registered here.</span>
                </div>
            </div>';
        
            header("Location: {$page_redirect}"); /* Redirect browser */
            exit();
        }
        
        if(!is_numeric($value)){            
           
            $_SESSION['error_msg'] = '<div class="container">
                <div class="alert alert-danger">
                    <span>The value must be an number.</span>
                </div>
            </div>';
        
            header("Location: {$page_redirect}"); /* Redirect browser */
            exit();
        }
        
        $timestamp_date = get_time($date);
        
        if(save_transaction(strtolower($type), $value, $account_number, $timestamp_date)) {
            $_SESSION['success_msg'] = '<div class="container">
                <div class="alert alert-success">
                    <span>New transaction(s) registered</span>
                </div>
            </div>';
        } else {
             $_SESSION['error_msg'] = '<div class="container">
                <div class="alert alert-danger">
                    <span>It happened an error while processing new transaction</span>
                </div>
            </div>';
        }
             
    }
    fclose($file);
    
    header("Location: {$page_redirect}"); /* Redirect browser */
    exit();