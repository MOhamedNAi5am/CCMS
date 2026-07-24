<?php

require_once "../config/database.php";
require_once "../includes/admin_auth.php";


if(!isset($_GET['id']))
{
    header("Location: customers.php");
    exit();
}


$id = intval($_GET['id']);



// Get customer information

$customer_query = mysqli_query(
    $conn,
    "SELECT * FROM customers WHERE id='$id'"
);


$customer = mysqli_fetch_assoc($customer_query);



if(!$customer)
{
    header("Location: customers.php");
    exit();
}



// Total Credit Sales

$credit_query = mysqli_query(
    $conn,
    "
    SELECT SUM(amount) AS total_credit
    FROM credit_transactions
    WHERE customer_id='$id'
    AND type='credit'
    "
);


$credit_data = mysqli_fetch_assoc($credit_query);


$total_credit = $credit_data['total_credit'] ?? 0;



// Total Payments

$payment_query = mysqli_query(
    $conn,
    "
    SELECT SUM(amount) AS total_payment
    FROM credit_transactions
    WHERE customer_id='$id'
    AND type='payment'
    "
);


$payment_data = mysqli_fetch_assoc($payment_query);


$total_payment = $payment_data['total_payment'] ?? 0;



// Outstanding balance

$balance = $total_credit - $total_payment;



?>



<div class="content">



<div class="page-header">


<h2>
Customer Profile
</h2>


<a href="customers.php" class="btn btn-secondary">
Back
</a>


</div>




<div class="card profile-card">


<h3>
Customer Information
</h3>


<table class="details">


<tr>

<td>
Customer ID
</td>

<td>
<?= $customer['customer_code']; ?>
</td>

</tr>



<tr>

<td>
Name
</td>

<td>
<?= htmlspecialchars($customer['name']); ?>
</td>

</tr>



<tr>

<td>
Phone
</td>

<td>
<?= htmlspecialchars($customer['phone']); ?>
</td>

</tr>



<tr>

<td>
Email
</td>

<td>
<?= htmlspecialchars($customer['email']); ?>
</td>

</tr>



<tr>

<td>
Address
</td>

<td>
<?= htmlspecialchars($customer['address']); ?>
</td>

</tr>



<tr>

<td>
Account Status
</td>

<td>

<?= ucfirst($customer['status']); ?>

</td>

</tr>


</table>


</div>






<div class="dashboard-cards">



<div class="small-card">

<h4>
Total Credit
</h4>

<p>
MVR <?= number_format($total_credit,2); ?>
</p>


</div>



<div class="small-card">

<h4>
Total Payments
</h4>


<p>
MVR <?= number_format($total_payment,2); ?>
</p>


</div>



<div class="small-card">

<h4>
Outstanding Balance
</h4>


<p>

<?php

if($balance > 0)
{

echo "MVR ".number_format($balance,2);

}

else

{

echo "Paid";

}

?>

</p>


</div>



</div>








<div class="card">


<h3>
Transaction History
</h3>



<table class="table">


<thead>

<tr>

<th>Date</th>

<th>Type</th>

<th>Description</th>

<th>Amount</th>

</tr>


</thead>




<tbody>



<?php


$transactions = mysqli_query(
$conn,

"

SELECT *

FROM credit_transactions

WHERE customer_id='$id'

ORDER BY transaction_date DESC

"

);



if(mysqli_num_rows($transactions)>0)

{


while($row=mysqli_fetch_assoc($transactions))

{


?>

<tr>


<td>

<?= $row['transaction_date']; ?>

</td>



<td>


<?php

if($row['type']=="credit")
{

echo "<span class='danger'>Credit Sale</span>";

}

else

{

echo "<span class='success'>Payment</span>";

}

?>


</td>




<td>

<?= htmlspecialchars($row['description']); ?>

</td>




<td>

MVR <?= number_format($row['amount'],2); ?>

</td>


</tr>



<?php

}


}

else

{


?>


<tr>

<td colspan="4">

No transactions found.

</td>

</tr>


<?php

}


?>



</tbody>


</table>


</div>







<div class="print-area">


<a 

href="print_statement.php?id=<?= $id; ?>"

class="btn btn-primary">

Print Customer Statement

</a>


</div>




</div>
