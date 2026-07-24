<?php

require_once "../config/database.php";
require_once "../includes/admin_auth.php";



// Check transaction ID

if(!isset($_GET['id']))
{
    header("Location: transactions.php");
    exit();
}



$id = intval($_GET['id']);




// Check transaction exists

$check = mysqli_query(
    $conn,

    "
    SELECT *

    FROM credit_transactions

    WHERE id='$id'

    "

);




if(mysqli_num_rows($check)==0)
{

    header("Location: transactions.php");
    exit();

}





// Delete transaction


$delete = mysqli_query(

    $conn,

    "

    DELETE FROM credit_transactions

    WHERE id='$id'

    "

);





if($delete)

{

    header(

        "Location: transactions.php?msg=deleted"

    );


}

else

{

    header(

        "Location: transactions.php?msg=error"

    );

}



exit();



?>
