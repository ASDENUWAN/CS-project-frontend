<!-- Top Navbar -->
<div class="top-navbar d-flex align-items-center justify-content-between px-3 flex-wrap">
    <!-- Sidebar Toggle Button for small screens -->
    <button class="btn btn-sm text-light d-md-none" id="sidebarToggle">
        <i class="bi bi-list" style="font-size: 1.5rem;"></i>
    </button>

    <a href="#" class="navbar-brand">Admin Panel</a>

    <!-- Topbar Collapse Toggle -->
    <button class="btn btn-sm text-light d-md-none" type="button" data-toggle="collapse" data-target="#topbarContent"
        aria-controls="topbarContent" aria-expanded="false" aria-label="Toggle navigation">
        <i class="bi bi-three-dots-vertical" style="font-size: 1.5rem;"></i>
    </button>

    <!-- Collapsible Content -->
    <div class="collapse d-md-flex align-items-center" id="topbarContent">
        <ul class="nav align-items-center ml-md-auto">
            <li class="nav-item">
                <a class="nav-link" href="#"><i class="bi bi-bell"></i></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#"><i class="bi bi-envelope"></i></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <i class="bi bi-person-circle"></i> <?php echo $_SESSION['admin_username'] ?>
                </a>
            </li>
            <a href="logout.php" class="btn btn-login ml-3" onclick="return confirm('Are you sure you want to log out?');">
                <i class="bi bi-box-arrow-right"></i>
                <span>Logout</span>
            </a>
        </ul>
    </div>
</div>