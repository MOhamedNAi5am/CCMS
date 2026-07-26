<div class="col-md-3 col-lg-2 p-0">

    <div class="bg-dark text-white vh-100">

        <div class="p-3 border-bottom">

            <h4 class="text-center">
                Admin Panel
            </h4>

            <p class="text-center mb-0">
                <?php echo htmlspecialchars($_SESSION['name']); ?>
            </p>

        </div>

        <div class="list-group list-group-flush">

            <a href="dashboard.php"
               class="list-group-item list-group-item-action bg-dark text-white">

                <i class="bi bi-speedometer2"></i>

                Dashboard

            </a>

            <a href="customers.php"
               class="list-group-item list-group-item-action bg-dark text-white">

                <i class="bi bi-people"></i>

                Customers

            </a>

            <a href="add_customer.php"
               class="list-group-item list-group-item-action bg-dark text-white">

                <i class="bi bi-person-plus"></i>

                Add Customer

            </a>

            <a href="credit_sale.php"
               class="list-group-item list-group-item-action bg-dark text-white">

                <i class="bi bi-cart-plus"></i>

                Credit Sales

            </a>

            <a href="payment.php"
               class="list-group-item list-group-item-action bg-dark text-white">

                <i class="bi bi-cash-stack"></i>

                Payments

            </a>

            <a href="transactions.php"
               class="list-group-item list-group-item-action bg-dark text-white">

                <i class="bi bi-receipt"></i>

                Transactions

            </a>

            <a href="reports.php"
               class="list-group-item list-group-item-action bg-dark text-white">

                <i class="bi bi-file-earmark-text"></i>

                Reports

            </a>

            <a href="../auth/change_password.php"
               class="list-group-item list-group-item-action bg-dark text-white">

                <i class="bi bi-key"></i>

                Change Password

            </a>

            <a href="../auth/logout.php"
               class="list-group-item list-group-item-action bg-danger text-white">

                <i class="bi bi-box-arrow-right"></i>

                Logout

            </a>

        </div>

    </div>

</div>
