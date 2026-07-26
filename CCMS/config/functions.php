<?php

function sanitize($data)
{
    return htmlspecialchars(trim($data));
}

function formatCurrency($amount)
{
    return number_format($amount, 2);
}

function generateCustomerID($conn)
{
    $query = $conn->query("SELECT COUNT(*) AS total FROM users WHERE role='customer'");
    $row = $query->fetch_assoc();

    $next = $row['total'] + 1;

    return "CUS" . str_pad($next, 3, "0", STR_PAD_LEFT);
}

?>
