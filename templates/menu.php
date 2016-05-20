<nav class="navbar navbar-default">
    <div class="container">
        <div class="navbar-header">
            <button class="navbar-toggle collapsed" data-target=".navbar-collapse" data-toggle="collapse" type="button">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="index.php">Assignment 1</a>
            
            <?php $page_name = $_SERVER['SCRIPT_NAME']; ?>
            <ul class="nav navbar-nav">
                <li class="<?php echo (strpos($page_name, 'customers.php') > 0  ? 'active' : ''); ?>">
                    <a href="customers.php">Customers</a>
                </li>
                <li class="<?php echo (strpos($page_name, 'account.php') > 0  ? 'active' : ''); ?>">
                    <a href="account.php">Accounts</a>
                </li>
                <li class="<?php echo (strpos($page_name, 'data.php') > 0  ? 'active' : ''); ?>">
                    <a href="data.php">Data</a>
                </li>
            </ul>
        </div>
    </div>
</nav> 