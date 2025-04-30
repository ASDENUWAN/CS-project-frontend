<!-- Navbar -->
<nav class="navbar navbar-expand-md navbar-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="index.php">
            <img src="Images/logo.png" alt="Logo" class="logo-size" />
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse"
            data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false"
            aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mr-auto" id="navLinks">
                <li class="nav-item">
                    <a class="nav-link" href="index.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="index.php?page=about">About</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="index.php?page=services">Services</a>
                </li>

                <?php if (isset($_SESSION['user_id'])): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?page=mySchedule&&fd=member">My Schedule</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?page=myDietPlans&&fd=member">My Diet Plans</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?page=myPayments&&fd=member">My Payments</a>
                    </li>
                <?php endif; ?>
                <li class="nav-item">
                    <a class="nav-link" href="index.php?page=contact">Contact</a>
                </li>
            </ul>

            <?php if (isset($_SESSION['user_id'])): ?>
                <a href="index.php?page=member" class="btn btn-header">
                    Hi, <?php echo htmlspecialchars($_SESSION['mem_name']); ?>
                </a>
            <?php else: ?>
                <a href="index.php?page=member" class="btn btn-header">Become a Member</a>
            <?php endif; ?>
        </div>

        <?php if (isset($_SESSION['user_id'])): ?>
            <a href="logout.php" class="btn btn-login ml-3" onclick="return confirm('Are you sure you want to log out?');">
                <i class="bi bi-box-arrow-right"></i>
                <span>Logout</span>
            </a>
        <?php else: ?>
            <a href="index.php?page=login" class="btn btn-login ml-3">
                <i class="bi bi-person-circle"></i>
                <span>Login</span>
            </a>
        <?php endif; ?>
    </div>
</nav>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const links = document.querySelectorAll(".nav-link");
        const currentURL = window.location.href;

        links.forEach(link => {
            // Make the clicked tab active immediately
            link.addEventListener("click", function() {
                links.forEach(l => l.classList.remove("active"));
                this.classList.add("active");
            });

            // Auto-highlight tab if URL matches (important for page reload)
            if (currentURL.includes(link.getAttribute("href"))) {
                links.forEach(l => l.classList.remove("active"));
                link.classList.add("active");
            }
        });
    });
</script>