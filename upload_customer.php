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
    $counter = 0;
    while(!feof($file)){        
        $line = fgets($file);
        list($name, $surname, $birthdate, $address) = array_map('trim', explode(",", $line));
                
        if($name == "" || $surname == ""){
        
            header("Location: {$page_redirect}"); /* Redirect browser */
            exit();
        }
        
        if(check_valid_date($birthdate) !== true){            
           
            $_SESSION['error_msg'] = '<div class="container">
                <div class="alert alert-danger">
                    <span>The date must be in the format dd/mm/yyyy. The date '.$birthdate.' was given</span>
                </div>
            </div>';
        
            header("Location: {$page_redirect}"); /* Redirect browser */
            exit();
        }
        
        $id = generate_new_id($counter);
        $timestamp_date = get_time($birthdate);
        
        if(save_customer($id, $name, $surname, $timestamp_date, $address)) {
            $_SESSION['success_msg'] = '<div class="container">
                <div class="alert alert-success">
                    <span>New customer(s) registered</span>
                </div>
            </div>';
        } else {
             $_SESSION['error_msg'] = '<div class="container">
                <div class="alert alert-danger">
                    <span>It happened an error while processing new customer</span>
                </div>
            </div>';
        }
         
        $counter++;
    }
    fclose($file);
    
    header("Location: {$page_redirect}"); /* Redirect browser */
    exit();