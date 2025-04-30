<style>
    .nav-link.active {
        color: #e65c00 !important;
        border-radius: 5px;
    }

    .nav-link.active i {
        color: #e65c00;
    }
</style>
<?php
$role = strtolower($_SESSION['admin_role'] ?? 'guest');
$cfd = $_GET['fd'] ?? 'adminDash';
?>

<nav class="sidebar d-md-block">
    <div class="logo-container">
        <img src="Images/logo.png" alt="Logo" />
    </div>
    <ul class="nav flex-column">
        <li class="nav-item">
            <a class="nav-link <?php echo ($cfd === 'adminDash') ? 'active' : ''; ?>" href="adminPanel.php?page=adminDash">
                <i class="bi bi-speedometer2"></i> Dashboard
            </a>
        </li>

        <?php if ($role === "manager"): ?>
            <li class="nav-item">
                <a class="nav-link <?php echo ($cfd === 'members') ? 'active' : ''; ?>" href="adminPanel.php?page=displayMembers&&fd=members">
                    <i class="bi bi-people"></i> Members
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo ($cfd === 'admin') ? 'active' : ''; ?>" href="adminPanel.php?page=displayAdminsDetails&&fd=admin">
                    <i class="bi bi-people-fill"></i> Our Team
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo ($cfd === 'payment') ? 'active' : ''; ?>" href="adminPanel.php?page=viewPaymentdetails&&fd=payment">
                    <i class="bi bi-cash-stack"></i> Payment History
                </a>
            </li>

        <?php elseif ($role === "operator"): ?>
            <li class="nav-item">
                <a class="nav-link <?php echo ($cfd === 'members') ? 'active' : ''; ?>" href="adminPanel.php?page=manageMembers&&fd=members">
                    <i class="bi bi-people"></i> Members Manage
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo ($cfd === 'admin') ? 'active' : ''; ?>" href="adminPanel.php?page=displayAdminsDetails&&fd=admin">
                    <i class="bi bi-people-fill"></i> Our Team Manage
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo ($cfd === 'payment') ? 'active' : ''; ?>" href="adminPanel.php?page=displayPayments&&fd=payment">
                    <i class="bi bi-cash-stack"></i> Payment History Manage
                </a>
            </li>

        <?php elseif ($role === "trainer"): ?>
            <li class="nav-item">
                <a class="nav-link <?php echo ($cfd === 'members') ? 'active' : ''; ?>" href="adminPanel.php?page=displayMembers&&fd=members">
                    <i class="bi bi-people"></i> Members
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo ($cfd === 'schedules') ? 'active' : ''; ?>" href="adminPanel.php?page=allplans&&fd=schedules">
                    <i class="bi bi-calendar3"></i> Workout Plan Manage
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo ($cfd === 'scheduleassign') ? 'active' : ''; ?>" href="adminPanel.php?page=displaySchedulesDetails&&fd=scheduleassign">
                    <i class="bi bi-calendar3"></i> Schedule Manage
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo ($cfd === 'dietplans') ? 'active' : ''; ?>" href="adminPanel.php?page=displayDietPlans&&fd=dietplans">
                    <i class="bi bi-card-checklist"></i> DietMeal Manage
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo ($cfd === 'dietplanassign') ? 'active' : ''; ?>" href="adminPanel.php?page=displayDietPlans&&fd=dietplanassign">
                    <i class="bi bi-card-checklist"></i> Diet Plan Manage
                </a>
            </li>


        <?php else: ?>
            <li class="nav-item">
                <a class="nav-link" href="#"><i class="bi bi-info-circle"></i> No Role Defined</a>
            </li>
        <?php endif; ?>
    </ul>
</nav>