<?php

require_once "../config/database.php";
require_once "../includes/admin_auth.php";


$message = "";



// Add transaction

if(isset($_POST['add_transaction']))
{


    $customer_id = intval($_POST['customer_id']);


    $type = $_POST['type'];


    $amount = mysqli_real_escape_string(
        $conn,
        $_POST['amount']
    );


    $description = mysqli_real_escape_string(
        $conn,
        $_POST['description']
    );



    $date = date("Y-m-d");




    if($amount <= 0)
    {


        $message = "

        <div class='alert error'>

        Amount must be greater than zero.

        </div>

        ";

    }

    else

    {



        $insert = "

        INSERT INTO credit_transactions

        (

        customer_id,

        type,

        amount,

        description,

        transaction_date

        )


        VALUES


        (

        '$customer_id',

        '$type',

        '$amount',

        '$description',

        '$date'

        )


        ";



        if(mysqli_query($conn,$insert))

        {


            $message = "

            <div class='alert success'>

            Transaction added successfully.

            </div>

            ";


        }

        else

        {


            $message = "

            <div class='alert error'>

            Failed to add transaction.

            </div>

            ";

        }



    }



}




// Get customers


$customers = mysqli_query(
    $conn,

    "

    SELECT *

    FROM customers

    WHERE status='active'

    ORDER BY name ASC

    "

);



?>



<div class="content">



<div class="page-header">


<h2>
Add Credit Transaction
</h2>



<a href="transactions.php"

class="btn btn-secondary">

Back

</a>



</div>





<?= $message ?>





<div class="card">



<form method="POST">






<div class="form-group">


<label>

Select Customer

</label>



<select name="customer_id" required>


<option value="">

-- Select Customer --

</option>



<?php


while($customer=mysqli_fetch_assoc($customers))

{


?>


<option value="<?= $customer['id']; ?>">


<?= htmlspecialchars($customer['name']); ?>


(<?= $customer['customer_code']; ?>)


</option>



<?php

}

?>


</select>


</div>








<div class="form-group">


<label>

Transaction Type

</label>



<select name="type" required>


<option value="credit">

Credit Sale

</option>



<option value="payment">

Payment Received

</option>



</select>


</div>








<div class="form-group">


<label>

Amount (MVR)

</label>


<input

type="number"

name="amount"

step="0.01"

required>


</div>








<div class="form-group">


<label>

Description

</label>


<textarea

name="description"

placeholder="Example: Grocery items purchased">

</textarea>


</div>






<button

type="submit"

name="add_transaction"

class="btn btn-primary">


Save Transaction


</button>





</form>




</div>



</div>
