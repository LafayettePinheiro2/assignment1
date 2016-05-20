<?php 
session_start();
include "templates/header.php";
include "templates/menu.php";  
include "functions.php";
?>

<?php
if( ! empty($_SESSION['error_msg']))
{
    echo $_SESSION['error_msg'];
    unset($_SESSION['error_msg']);
}

if( ! empty($_SESSION['success_msg']))
{
    echo $_SESSION['success_msg'];
    unset($_SESSION['success_msg']);
}

?>

<div class="container">
<article>
    <div class="row">
        <div class="col-sm-11">            
            
            <form action="upload_customer.php" method="post" enctype="multipart/form-data">
                <h2>Upload New Customer</h2>
                <p>The file must be .csv and each customer at one line in the following format</p>
                <p><strong>Name, Surname, Birthdate (dd/mm/yyyy), Address</strong></p>
                
                <p>Select file to upload:</p>
                <input type="file" name="fileToUpload" id="customerUpload">
                <input disabled type="submit" value="Upload File" name="submit" id="submit_customer">
            </form>
            
            
        </div><!--col-sm-11-->
    </div><!--row-->
</article>
</div><!--container-->

<div class="container">
<article>
    <div class="row">
        <div class="col-sm-11">            
            
            <form action="upload_account.php" method="post" enctype="multipart/form-data">
                <h2>Upload New Account</h2>
                <p>The file must be .csv and each account at one line in the following format</p>
                <p><strong>Account Holder Id, Currency, Balance</strong></p>
                <p>Select file to upload:</p>
                <input type="file" name="fileToUpload" id="accountUpload">
                <input disabled type="submit" value="Upload File" name="submit" id="submit_account">
            </form>
            
            
        </div><!--col-sm-11-->
    </div><!--row-->
</article>
</div><!--container-->


<div class="container">
<article>
    <div class="row">
        <div class="col-sm-11">            
            
            <form action="upload_transaction.php" method="post" enctype="multipart/form-data">
                <h2>Upload New Transaction</h2>
                <p>The file must be .csv and each transaction at one line in the following format</p>
                <p><strong>Type of transaction (deposit or withdrawal), Value, Account number, Date (dd/mm/yyyy)</strong></p>
                <p>Select file to upload:</p>
                <input type="file" name="fileToUpload" id="transactionUpload">
                <input disabled type="submit" value="Upload File" name="submit" id="submit_transaction">
            </form>            
            
        </div><!--col-sm-11-->
    </div><!--row-->
</article>
</div><!--container-->



<script type="text/javascript">
    $('#customerUpload').on('change', function(e){
        $('#submit_customer').removeAttr('disabled');
    });
    $('#accountUpload').on('change', function(e){
        $('#submit_account').removeAttr('disabled');
    });
    $('#transactionUpload').on('change', function(e){
        $('#submit_transaction').removeAttr('disabled');
    });
</script>


<?php include "templates/footer.php";?>

