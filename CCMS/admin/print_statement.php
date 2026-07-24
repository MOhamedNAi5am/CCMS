<?php

require_once "../config/database.php";
require_once "../includes/admin_auth.php";



if(!isset($_GET['id']))
{
    header("Location: customers.php");
    exit();
}



$id = intval($_GET['id']);




// Get customer details

$customer_query = mysqli_query(

$conn,

"

SELECT *

FROM customers

WHERE id='$id'

"

);



$customer = mysqli_fetch_assoc($customer_query);



if(!$customer)
{
    header("Location: customers.php");
    exit();
}






// Total credit

$credit_query = mysqli_query(

$conn,

"

SELECT SUM(amount) AS total

FROM credit_transactions

WHERE customer_id='$id'

AND type='credit'

"

);



$credit_data = mysqli_fetch_assoc($credit_query);


$total_credit = $credit_data['total'] ?? 0;






// Total payments

$payment_query = mysqli_query(

$conn,

"

SELECT SUM(amount) AS total

FROM credit_transactions

WHERE customer_id='$id'

AND type='payment'

"

);



$payment_data = mysqli_fetch_assoc($payment_query);


$total_payment = $payment_data['total'] ?? 0;




$balance = $total_credit - $total_payment;



?>





<!DOCTYPE html>

<html>

<head>


<title>

Customer Statement

</title>



<link rel="stylesheet"

href="../assets/css/style.css">



<style>

@media print{

.no-print{

display:none;

}

}



</style>



</head>




<body>





<div class="statement">





<div class="no-print">


<button

onclick="window.print()"

class="btn btn-primary">

Print

</button>



<a href="view_customer.php?id=<?= $id; ?>"

class="btn btn-secondary">

Back

</a>


</div>






<h1>

Coastal Blue

</h1>



<h2>

Customer Credit Statement

</h2>



<hr>







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

Customer Name

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




</table>









<h3>

Transaction History

</h3>





<table class="table">


<thead>


<tr>

<th>Date</th>

<th>Description</th>

<th>Type</th>

<th>Amount</th>

</tr>


</thead>




<tbody>



<?php



$transactions=mysqli_query(

$conn,

"

SELECT *

FROM credit_transactions

WHERE customer_id='$id'

ORDER BY transaction_date ASC

"

);



while($row=mysqli_fetch_assoc($transactions))

{


?>



<tr>


<td>

<?= $row['transaction_date']; ?>

</td>



<td>

<?= htmlspecialchars($row['description']); ?>

</td>




<td>


<?php

if($row['type']=="credit")

{

echo "Credit Sale";

}

else

{

echo "Payment";

}

?>


</td>




<td>

MVR <?= number_format($row['amount'],2); ?>

</td>



</tr>



<?php

}

?>



</tbody>


</table>








<div class="summary">


<h3>

Account Summary

</h3>



<p>

Total Credit:

<strong>

MVR <?= number_format($total_credit,2); ?>

</strong>

</p>



<p>

Total Payments:

<strong>

MVR <?= number_format($total_payment,2); ?>

</strong>

</p>



<p>

Outstanding Balance:

<strong>

MVR <?= number_format($balance,2); ?>

</strong>

</p>



</div>






</div>





</body>


</html>