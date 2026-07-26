<div class="col-md-3 col-lg-2 p-0">

    <div class="bg-primary text-white vh-100">

        <div class="p-3 border-bottom">

            <h4 class="text-center">

                Customer

            </h4>

            <p class="text-center mb-0">

                <?php echo htmlspecialchars($_SESSION['name']); ?>

            </p>

        </div>

        <div class="list-group list-group-flush">

            <a href="dashboard.php"
               class="list-group-item list-group-item-action">

                <i class="bi bi-speedometer2"></i>

                Dashboard

            </a>

            <a href="transactions.php"
               class="list-group-item list-group-item-action">

                <i class="bi bi-clock-history"></i>

                Transactions

            </a>

            <a href="profile.php"
               class="list-group-item list-group-item-action">

                <i class="bi bi-person-circle"></i>

                My Profile

            </a>

            <a href="../auth/change_password.php"
               class="list-group-item list-group-item-action">

                <i class="bi bi-key"></i>

                Change Password

            </a>

            <a href="../auth/logout.php"
               class="list-group-item list-group-item-action text-danger">

                <i class="bi bi-box-arrow-right"></i>

                Logout

            </a>

        </div>

    </div>

</div>
