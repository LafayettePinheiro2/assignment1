<?php include "templates/header.php";?>
<?php include "templates/menu.php"; ?>  
<?php include "functions.php";?>

<div class="container">
<article>
    <div class="row">
        <div class="col-sm-12">

<?php
$customers = get_all_customers();
$accounts = get_all_accounts();
?>
            
<?php if($customers) { ?>
            
    <div class="well center-block" style="max-width:400px">
        <button class="btn btn-default btn-lg btn-block" type="button">Total number of customers: <?php echo count($customers); ?></button>
        <button class="btn btn-default btn-lg btn-block" type="button">Total number of accounts: <?php echo count($accounts); ?></button>
    </div>   

<?php 
    echo "<h2 class='text-center'>Customers and accounts</h2>";
    echo "<table class='table table-striped table-bordered table-hover text-center'>";
    echo "<thead><tr><th>Customer Id</th><th>Name</th><th>Surname</th><th>Birthdate</th><th>Accounts</th><th>Total Accounts</th><th>Sum of money</th></tr></thead>";
    
    for($i=0; $i<count($customers); $i++){
        echo "<tr>";
        echo "<td>{$customers[$i]->id}</td>";
        echo "<td>".ucfirst($customers[$i]->name)."</td>";
        echo "<td>".ucfirst($customers[$i]->surname)."</td>";
        echo "<td>".date('d/m/Y',$customers[$i]->birthdate)."</td>";
        
        echo "<td>";
        $sum_accounts = 0;
             
        if($accounts = get_customer_accounts($customers[$i]->id)) {        
            echo "<table class='table'>";
            echo "<tr><th>Account Number</th><th>Balance</th><th>Withdrawals</th><th>Deposits</th></tr>";

            for($j=0; $j<count($accounts);$j++){
                if($accounts[$j]->account_holder == $customers[$i]->id){
                    $sum_accounts += 1;
                    $account_number = $accounts[$j]->account_number;
                    echo "<tr>";
                    echo "<td>{$account_number}</td>";
                    echo "<td>{$accounts[$j]->balance}</td>";
                    
                    if(accounts_has_transactions($accounts)) {
                        $withdrawals = print_account_withdrawals($account_number);
                        $deposits = print_account_deposits($account_number);

                        echo "<td>".$withdrawals."</td>";
                        echo "<td>".$deposits."</td>";   
                        write_withdrawals_deposits_account($account_number, $withdrawals, $deposits);                
                        echo "</tr>";        
                        
                    } else {
                        echo "<td>0</td>";
                        echo "<td>0</td>";                                         
                        echo "</tr>"; 
                    }

                } 
            }

            echo "</table>";

            echo "</td>";
            echo "<td>";
                echo $sum_accounts;
            echo "</td>";
            
            if(customer_has_accounts($customers[$i]->id)) {
                echo "<td>".print_customer_total_money($customers[$i]->id)."</td>";
                write_sum_money($customers[$i]->id, print_customer_total_money($customers[$i]->id));  
            } else {
                echo "<td>0</td>";
            }            
            
            echo "</tr>";
        
        } else {
            echo "No accounts for this customer</td><td>0</td><td>0</td></tr>";
        }
        
    }
} else {    
    echo "<h2 class=''>There are no customers registered</h2>";
    echo "<a href='data.php' class='text-center'>Register new customer</a>";
}
?>
    
</table>

        </div><!--col-sm-12-->
    </div><!--row-->
</article>
</div><!--container-->
        
<?php include "templates/footer.php";?>