<?php

session_start();

require_once "../config/database.php";



// Check customer login

if(!isset($_SESSION['customer_id']))
{
    header("Location: login.php");
    exit();
}



$customer_id = $_SESSION['customer_id'];

$customer_name = $_SESSION['customer_name'];




// Total Credit Purchases

$credit_query = mysqli_query(

$conn,

"

SELECT SUM(amount) AS total

FROM credit_transactions

WHERE customer_id='$customer_id'

AND type='credit'

"

);



$credit_data = mysqli_fetch_assoc($credit_query);


$total_credit = $credit_data['total'] ?? 0;






// Total Payments

$payment_query = mysqli_query(

$conn,

"

SELECT SUM(amount) AS total

FROM credit_transactions

WHERE customer_id='$customer_id'

AND type='payment'

"

);



$payment_data = mysqli_fetch_assoc($payment_query);


$total_payment = $payment_data['total'] ?? 0;






// Outstanding balance

$balance = $total_credit - $total_payment;



?>





<!DOCTYPE html>

<html>

<head>


<title>

Customer Dashboard - CCMS

</title>



<link rel="stylesheet" href="../assets/css/style.css">



</head>



<body>




<?php include "../includes/customer_header.php"; ?>





<div class="content">





<div class="page-header">


<h2>

Welcome,

<?= htmlspecialchars($customer_name); ?>

</h2>



<a href="logout.php"

class="btn btn-danger">

Logout

</a>


</div>







<div class="dashboard-cards">






<div class="small-card">


<h4>

Total Purchases

</h4>


<p>

MVR <?= number_format($total_credit,2); ?>

</p>


</div>







<div class="small-card">


<h4>

Payments Made

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

Recent Transactions

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


WHERE customer_id='$customer_id'


ORDER BY transaction_date DESC


LIMIT 10


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

echo "<span class='danger'>Purchase</span>";

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

No transactions available.

</td>

</tr>



<?php

}


?>





</tbody>


</table>




</div>








<div class="quick-actions">


<a href="statement.php"

class="btn btn-primary">

Download Statement

</a>



<a href="profile.php"

class="btn btn-info">

My Profile

</a>


</div>






</div>






</body>

</html>
