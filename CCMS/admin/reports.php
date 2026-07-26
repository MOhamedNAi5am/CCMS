<?php

require_once "../config/database.php";
require_once "../includes/admin_auth.php";



// Total customers

$customer_result = mysqli_query(

$conn,

"SELECT COUNT(*) AS total FROM customers"

);

$customer_data = mysqli_fetch_assoc($customer_result);

$total_customers = $customer_data['total'];





// Total credit

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






// Total payments

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





$outstanding = $total_credit - $total_payment;



?>



<div class="content">



<div class="page-header">


<h2>

Credit Reports

</h2>



<button onclick="window.print()"

class="btn btn-primary">

Print Report

</button>


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

Credit Issued

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

Outstanding

</h4>


<p>

MVR <?= number_format($outstanding,2); ?>

</p>


</div>





</div>









<div class="card">


<h3>

Customer Balance Report

</h3>





<table class="table">


<thead>


<tr>


<th>

Customer

</th>


<th>

Phone

</th>


<th>

Total Credit

</th>


<th>

Total Payment

</th>


<th>

Balance

</th>


</tr>


</thead>




<tbody>



<?php



$customers = mysqli_query(

$conn,

"

SELECT *

FROM customers

ORDER BY name ASC

"

);





while($customer=mysqli_fetch_assoc($customers))

{


$id=$customer['id'];





$credit=mysqli_query(

$conn,

"

SELECT SUM(amount) AS total

FROM credit_transactions

WHERE customer_id='$id'

AND type='credit'

"

);



$c=mysqli_fetch_assoc($credit);


$total_c=$c['total'] ?? 0;





$payment=mysqli_query(

$conn,

"

SELECT SUM(amount) AS total

FROM credit_transactions

WHERE customer_id='$id'

AND type='payment'

"

);



$p=mysqli_fetch_assoc($payment);


$total_p=$p['total'] ?? 0;



$balance=$total_c-$total_p;



?>



<tr>


<td>

<?= htmlspecialchars($customer['name']); ?>

</td>



<td>

<?= htmlspecialchars($customer['phone']); ?>

</td>



<td>

MVR <?= number_format($total_c,2); ?>

</td>



<td>

MVR <?= number_format($total_p,2); ?>

</td>



<td>

<?php

if($balance>0)

{

echo "MVR ".number_format($balance,2);

}

else

{

echo "Paid";

}

?>


</td>


</tr>



<?php

}

?>



</tbody>


</table>



</div>




</div>
