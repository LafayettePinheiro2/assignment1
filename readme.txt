Assignment 1 of Programming for the Web 2.

This application consists in main 3 pages.

   * Customers.php: display all customers registered at /files/customers.csv file, with the informations about 
each customer and informations about each customers' account. When showing dinamic information, such as
total money, number of deposits and number of withdrawals, this values are read from the files, showed at
the application, and then written back to the files.

    * Accounts.php: The name of all the customers registered is shown at a dropdown menu, where by clicking
at some customer, the url of the page is changed in order to show the informations about accounts and transactions of 
this specific customer. If the user has account(s) and the account has transaction(s), this is shown down in the page, 
and when showing the transactions, there is two dropdown menus, where you can change 
the order of transactions list. By selecting the option date or value at this dropdown menu, the url is changed is 
the transactions are ordered by the chosen property. Also aside it there is the option of ordering
ascending or descending. By just clicking one of this options  the url is changed and the results
display as well. When showing dinamic information, such as total money, number of deposits and 
number of withdrawals, this value is read from the files, showed at the application,
and then written back to the files.

    * Data.php: At this page you can upload new customers, transactions or accounts by uploading 
a csv file. If the data at the csv file are correct, this data will be processed and appended at this customers.csv
or accounts.csv or transactions.csv under the folder files. To upload an account, you need to put a valid
user id inside the csv file with the account. To upload an transaction , you need to put a valid account number
inside the csv file with the transaction. The dates in any of this csv files that you may want to upload
should be at the dd/mm/yyyy format.

    - Example of valid customer.csv file to be uploaded for customers:        
        This is the format = [CUSTOMER_NAME], [CUSTOMER_SURNAME], [BIRTHDATE(dd/mm/yyyy)], [CUSTOMER_ADDRESS]

        Examples:
        Maria, Tiao, 11/01/1991, qd 1 lt 1
        Joao, Barbosa, 10/11/1990, qd 2 lt 2
        Janaina, Pereira, 05/01/1983, qd 3 lt 3


    - Example of valid accounts.csv file to be uploaded for accounts: (ACCOUNT_HOLDER is the id of some customer, and
    needs to be an valid ID).
        This is the format = [ACCOUNT_HOLDER], [CURRENCY], [BALANCE]

        Examples:
        1, dollar, 500
        2, nok, 900
        3, euro, 1200
        4, euro, 420


    - Example of valid transactions.csv file to be uploaded for transactions:  (ACCOUNT_NUMBER needs to be an valid account
    number, already registered at this application; transaction type must be deposit or withdrawal, lowercase or uppercase).
        This is the format = [TRANSACTION_TYPE], [VALUE], [ACCOUNT_NUMBER], [DATE(dd/mm/yyyy)]

        Examples
        deposit, 1100, 1, 10/10/2010
        withdrawal, 2200, 1, 01/11/2011
        withdrawal, 2200, 2, 08/11/2011
        deposit, 2200, 3, 09/08/2009

        
    In any of this upload options, the application will iterate over the file, and append each record to the respective file
if the data is correctly.


There is some initial data at this files in order to demonstrate how the applications works.

It was used the css of Twitter Bootstrap at the design of this pages, in order to aggregate some more knowledge
to me while doing the work. Also it was used jQuery to manipulate the URLs by just clicking at some
options, such as ordering the transactions.

One smooth detail about executing this application is: the user of your localhost needs
permission to read and write and even create files at the /files folder inside this application,
in order to read and write data to the .csv files. Without correctly permissions at the machine
where you execute it, will happen some error.



Lafayette Pinheiro
150262