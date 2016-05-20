<?php include "templates/header.php";?>
<?php include "templates/menu.php"; ?>  
<?php include "functions.php";?>


<div class="container">
<article>
    <div class="row">
        <div class="col-sm-12">
        
            <?php

            $customers = get_all_customers();
            if($customers) {

                echo "<div class='container-fluid customer_select'>";
                    echo "<h3 class='text-center'>Select an user to display informations</h3>";

                    echo "<select multiple class='form-control text-center' id='select_customer'>";
                        for($i=0; $i < count($customers); $i++){
                            echo "<option value='account.php?customer={$customers[$i]->id}'>".ucfirst($customers[$i]->name)." ".ucfirst($customers[$i]->surname)."</option>";
                        }
                    echo "</select>"; 
                echo "</div>";


                if(isset($_GET["customer"])){        
                    $customer_id = $_GET["customer"];
                    isset($_GET['order']) ? $order = $_GET['order'] : $order='asc';
                    $customer = get_customer($customer_id);
                    $customer_has_account = customer_has_accounts($customer_id);        

                    echo "<h2 class='text-center title-customer'>Customer</h2>";        

                    echo "<table class='table table-striped table-bordered table-hover text-center table-customer'>";
                    echo "<tr><th>Id</th><th>Name</th><th>Surname</th><th>Birthdate</th><th>Total money</th></tr>";
                    echo "<tr>";
                    echo "<td>{$customer->id}</td>";
                    echo "<td>".ucfirst($customer->name)."</td>";
                    echo "<td>".ucfirst($customer->surname)."</td>";
                    echo "<td>".date('d/m/Y',$customer->birthdate)."</td>";

                    if($customer_has_account) {
                        $customer_accounts = get_customer_accounts($customer_id); 

                        echo "<td>".print_customer_total_money($customer->id)."</td>";
                        write_sum_money($customers[$i]->id, print_customer_total_money($customers[$i]->id));
                        echo "</tr>";
                        echo "</table>";

                        echo "<h2 class='text-center'>Customer Accounts</h2>";
                        echo "<table class='table table-striped table-bordered table-hover text-center'>";
                        echo "<tr><th>Account Number</th><th>Balance</th><th>Withdrawals</th><th>Deposits</th></tr>";
                        for($i=0; $i<count($customer_accounts); $i++){
                            $account_number = $customer_accounts[$i]->account_number;
                            $deposits = print_account_deposits($account_number);
                            $withdrawals = print_account_withdrawals($account_number);
                            echo "<tr>";
                                echo "<td>{$account_number}</td>";
                                echo "<td>{$customer_accounts[$i]->balance}</td>";
                                echo "<td>".$withdrawals."</td>";
                                echo "<td>".$deposits."</td>";
                                write_withdrawals_deposits_account($account_number, $withdrawals, $deposits);     
                            echo "</tr>";
                        }     
                        echo "</table>";
                    } else {
                        echo '<td>0</td>';
                        echo '<h2>This customer has no accounts</h2>';
                        echo "<a href='data.php' class='text-center'>Register new accounts</a>";
                    }


                    $accounts_transactions = get_accounts_transactions($customer_accounts);
                    if($customer_has_account && $accounts_transactions) {            
                        if (isset($_GET['orderby']) && $_GET['orderby'] == 'date'){
                            $accounts_transactions = get_accounts_transactions_by_date($accounts_transactions, $order);
                        } else if (isset($_GET['orderby']) && $_GET['orderby'] == 'value'){
                            $accounts_transactions = get_accounts_transactions_by_value($accounts_transactions, $order);
                        }
                        ?>

                        <span>Order: </span>

                        <select class='text-center' id='select_order_by'>
                            <option value='' disabled>Select an property to order</option> 
                            <option value='date'>Date</option> 
                            <option value='value'>Value</option> 
                        </select>

                        <select class='text-center' id='select_order'>                
                            <option value='' disabled>Select an way to order</option> 
                            <option value='asc'>Ascending</option> 
                            <option value='desc'>Descending</option> 
                        </select>

                        <?php

                        echo "<h2 class='text-center'>Customer Accounts Transactions</h2>";
                        echo "<table class='table table-striped table-bordered table-hover text-center'>";
                        echo "<tr><th>Account Number</th><th>Transaction type</th><th>Value</th><th>Date</th></tr>";
                        for($i=0; $i<count($accounts_transactions); $i++){
                            echo "<tr>";
                                echo "<td>{$accounts_transactions[$i]->account_number}</td>";
                                echo "<td>".ucfirst($accounts_transactions[$i]->type)."</td>";
                                echo "<td>{$accounts_transactions[$i]->value}</td>";
                                echo "<td>".date('d/m/Y',$accounts_transactions[$i]->date)."</td>";
                            echo "</tr>";
                        }  
                        echo "</table>"; 
                    } else {
                        echo "<h2 class=''>There are no transactions registered for this account(s)</h2>";
                        echo "<a href='data.php' class='text-center'>Register new transactions</a>";
                    }
                } 
            } else {
                echo "<h2 class=''>There are no customers registered</h2>";
                echo "<a href='data.php' class='text-center'>Register new customer</a>";
            }
            ?>


        </div><!--col-sm-12-->
    </div><!--row-->
</article>
</div><!--container-->

<script type="text/javascript">
    var url = window.location.href;
    
    $( "#select_customer" ).change(function() {        
        $(location).attr("href", $(this).val());
    });
    
    $( "#select_order_by" ).change(function() { 
        //tests if it is the empty option
        if(!$(this).val()){
            return;        
        }
        if (url.indexOf("date") >= 0) {            
            $(location).attr("href", url.replace("date", "value"));
        } else if (url.indexOf("value") >= 0) {
            $(location).attr("href", url.replace("value", "date"));
        } else {            
            $(location).attr("href", url+'&orderby='+$(this).val());
        }
    });
    
    $( "#select_order" ).change(function() {   
        //tests if it is the empty option
        if(!$(this).val()){
            return;        
        }
        if (url.indexOf("asc") >= 0) {            
            $(location).attr("href", url.replace("asc", "desc"));
        } else if (url.indexOf("desc") >= 0) {
            $(location).attr("href", url.replace("desc", "asc"));
        } else {            
            $(location).attr("href", url+'&order='+$(this).val());
        }
    });
    
    $(document).ready(function() {
        //selecting ordering options when page loads
        if (url.indexOf("asc") >= 0) {            
            $('#select_order option[value=asc]').attr('selected','selected');
        } else if (url.indexOf("desc") >= 0) {
            $('#select_order option[value=desc]').attr('selected','selected');
        } else {            
            $('#select_order option[value=""]').attr('selected','selected');
        } 
        
        if (url.indexOf("date") >= 0) {            
            $('#select_order_by option[value=date]').attr('selected','selected');
        } else if (url.indexOf("value") >= 0) {
            $('#select_order_by option[value=value]').attr('selected','selected');
        } else {            
            $('#select_order_by option[value=""]').attr('selected','selected');
        }  
        
        $('.table-customer').insertAfter($('.title-customer'));
        
    });
    
</script>

<?php include "templates/footer.php"; ?>