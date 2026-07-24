<?php

require_once "../config/database.php";
require_once "../includes/admin_auth.php";


// Check customer ID

if(!isset($_GET['id']))
{
    header("Location: customers.php");
    exit();
}



$id = intval($_GET['id']);



// Check customer exists

$check = mysqli_query(
    $conn,
    "SELECT * FROM customers WHERE id='$id'"
);



if(mysqli_num_rows($check)==0)
{

    header("Location: customers.php");
    exit();

}




// Delete customer transactions first

mysqli_query(
    $conn,

    "
    DELETE FROM credit_transactions
    WHERE customer_id='$id'
    "

);




// Delete customer account

$delete = mysqli_query(
    $conn,

    "
    DELETE FROM customers
    WHERE id='$id'
    "

);




if($delete)
{

    header(
        "Location: customers.php?msg=deleted"
    );

}
else
{

    header(
        "Location: customers.php?msg=error"
    );

}



exit();

?>
