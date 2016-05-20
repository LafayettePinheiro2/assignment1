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
    <div class="row">
        <div class="col-md-6">  
            <form action="upload_customer.php" method="post" enctype="multipart/form-data">
                <h2>1) Upload New Customers</h2>
                <p>The file must be .csv and each customer at one line</p>
                <div class="form-group">
                    <label for="exampleInputFile">Select file to upload</label>
                    <input type="file" name="fileToUpload" id="customerUpload">
                    <p class="help-block">Format: Name, Surname, Birthdate (dd/mm/yyyy), Address</p>
                </div>
                <input disabled type="submit" value="Upload File" name="submit" id="submit_customer">
            </form>
        </div><!--col-md-6--> 
        
        <div class="col-md-6">
            <form action="upload_account.php" method="post" enctype="multipart/form-data">
                <h2>2) Upload New Accounts</h2>
                <p>The file must be .csv and each account in one line</p>
                <div class="form-group">
                    <label for="exampleInputFile">Select file to upload</label>
                    <input type="file" name="fileToUpload" id="accountUpload">
                    <p class="help-block">Account Holder Id, Currency, Balance</p>
                </div>
                <input disabled type="submit" value="Upload File" name="submit" id="submit_account">
            </form>
        </div><!--col-md-6--> 
        
        <div class="col-md-6">              
            <form action="upload_transaction.php" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <h2>3) Upload New Transactions</h2>
                    <label for="exampleInputEmail1">The file must be .csv and each transaction in one line</label>
                </div>
                <div class="form-group">
                    <label for="exampleInputFile">Select file to upload</label>
                    <input type="file" name="fileToUpload" id="transactionUpload">
                    <p class="help-block">Type of transaction (deposit or withdrawal), Value, Account number, Date (dd/mm/yyyy)</p>
                </div>
                <input disabled type="submit" value="Upload File" name="submit" id="submit_transaction">
            </form> 
        </div><!--col-md-16-->
        
    </div><!--row-->
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

