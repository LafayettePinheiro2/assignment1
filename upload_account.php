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
        list($account_holder, $currency, $balance) = array_map('trim', explode(",", $line));
                
        if($account_holder == "" || $currency == "" || $balance == ""){        
            header("Location: {$page_redirect}"); /* Redirect browser */
            exit();
        }
        
        if (!is_valid_account_holder($account_holder)) {
            $_SESSION['error_msg'] = '<div class="container">
                <div class="alert alert-danger">
                    <span>This account holder id - '.$account_holder.' - is not registered.</span>
                </div>
            </div>';
        
            header("Location: {$page_redirect}"); /* Redirect browser */
            exit();
        }
        
        $account_number = generate_new_account_number();
        
        if(save_account($account_holder, $account_number, $currency, $balance, '0', '0')) {
            $_SESSION['success_msg'] = '<div class="container">
                <div class="alert alert-success">
                    <span>New account(s) registered</span>
                </div>
            </div>';
        } else {
             $_SESSION['error_msg'] = '<div class="container">
                <div class="alert alert-danger">
                    <span>It happened an error while processing the new account. Please try again.</span>
                </div>
            </div>';
        }
             
    }
    fclose($file);
    
    header("Location: {$page_redirect}"); /* Redirect browser */
    exit();