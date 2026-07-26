<?php

require_once "../config/database.php";
require_once "../includes/admin_auth.php";



// Total Customers

$customer_count = mysqli_query(

$conn,

"SELECT COUNT(*) AS total FROM customers"

);


$customers = mysqli_fetch_assoc($customer_count);

$total_customers = $customers['total'];





// Total Credit

$credit_result = mysqli_query(

$conn,

"

SELECT SUM(amount) AS total

FROM credit_transactions

WHERE type='credit'

"

);


$credit_data = mysqli_fetch_assoc($credit_result);


$total_credit = $credit_data['total'] ?? 0;





// Total Payments


$payment_result = mysqli_query(

$conn,

"

SELECT SUM(amount) AS total

FROM credit_transactions

WHERE type='payment'

"

);



$payment_data = mysqli_fetch_assoc($payment_result);



$total_payment = $payment_data['total'] ?? 0;






// Outstanding balance


$outstanding = $total_credit - $total_payment;




?>



<div class="content">



<div class="page-header">


<h2>

Admin Dashboard

</h2>


</div>







<div class="dashboard-cards">





<div class="small-card">


<h4>

Total Customers

</h4>


<p>

<?= $total_customers; ?>

</p>


</div>







<div class="small-card">


<h4>

Total Credit Sales

</h4>


<p>

MVR <?= number_format($total_credit,2); ?>

</p>


</div>







<div class="small-card">


<h4>

Payments Received

</h4>


<p>

MVR <?= number_format($total_payment,2); ?>

</p>


</div>








<div class="small-card">


<h4>

Outstanding Amount

</h4>


<p>


MVR <?= number_format($outstanding,2); ?>


</p>


</div>





</div>










<div class="card">


<h3>

Recent Transactions

</h3>




<table class="table">


<thead>


<tr>


<th>Date</th>

<th>Customer</th>

<th>Type</th>

<th>Amount</th>


</tr>


</thead>



<tbody>



<?php



$recent = mysqli_query(

$conn,


"

SELECT 

credit_transactions.*,

customers.name


FROM credit_transactions


INNER JOIN customers

ON credit_transactions.customer_id = customers.id


ORDER BY id DESC

LIMIT 10


"

);




while($row=mysqli_fetch_assoc($recent))

{


?>



<tr>



<td>

<?= $row['transaction_date']; ?>

</td>




<td>

<?= htmlspecialchars($row['name']); ?>

</td>




<td>


<?php

if($row['type']=="credit")

{

echo "<span class='danger'>Credit</span>";

}

else

{

echo "<span class='success'>Payment</span>";

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



</div>








<div class="quick-actions">


<h3>

Quick Actions

</h3>



<a href="add_customer.php"

class="btn btn-primary">

Add Customer

</a>




<a href="add_transaction.php"

class="btn btn-primary">

Add Transaction

</a>





<a href="customers.php"

class="btn btn-info">

Manage Customers

</a>




<a href="transactions.php"

class="btn btn-info">

View Transactions

</a>



</div>





</div>
