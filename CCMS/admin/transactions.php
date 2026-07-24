<?php

require_once "../config/database.php";
require_once "../includes/admin_auth.php";



// Search option

$search = "";

if(isset($_GET['search']))
{
    $search = mysqli_real_escape_string(
        $conn,
        $_GET['search']
    );
}




$query = "

SELECT 

credit_transactions.*,

customers.name AS customer_name,

customers.customer_code


FROM credit_transactions


INNER JOIN customers

ON credit_transactions.customer_id = customers.id



WHERE 

customers.name LIKE '%$search%'

OR customers.customer_code LIKE '%$search%'



ORDER BY transaction_date DESC


";



$result = mysqli_query(
    $conn,
    $query
);



?>



<div class="content">



<div class="page-header">


<h2>
Credit Transactions
</h2>


<a href="add_transaction.php" class="btn btn-primary">

+ Add Transaction

</a>


</div>






<div class="card">



<form method="GET">


<input

type="text"

name="search"

placeholder="Search customer..."

value="<?= htmlspecialchars($search); ?>"



>


<button class="btn btn-info">

Search

</button>


</form>



</div>







<div class="card">



<table class="table">


<thead>


<tr>

<th>Date</th>

<th>Customer</th>

<th>Type</th>

<th>Description</th>

<th>Amount</th>

<th>Action</th>


</tr>


</thead>



<tbody>



<?php



if(mysqli_num_rows($result)>0)

{


while($row=mysqli_fetch_assoc($result))

{


?>



<tr>


<td>

<?= $row['transaction_date']; ?>

</td>




<td>

<?= htmlspecialchars($row['customer_name']); ?>


<br>

<small>

<?= $row['customer_code']; ?>

</small>


</td>





<td>


<?php


if($row['type']=="credit")

{

?>

<span class="danger">

Credit Sale

</span>


<?php

}

else

{


?>


<span class="success">

Payment

</span>


<?php

}


?>


</td>






<td>

<?= htmlspecialchars($row['description']); ?>

</td>






<td>

MVR <?= number_format($row['amount'],2); ?>

</td>






<td>


<a 

href="delete_transaction.php?id=<?= $row['id']; ?>"

onclick="return confirm('Delete this transaction?')"

class="btn btn-danger">


Delete


</a>


</td>




</tr>



<?php

}

}


else

{


?>

<tr>

<td colspan="6">

No transactions found.

</td>

</tr>


<?php

}


?>



</tbody>


</table>



</div>



</div>
