<style>
    /* Login Form Container with Background Image */
    .login-container {
        min-height: calc(100vh - 160px);
        /* Adjust based on header/footer height */
        background: url("Images/bg7.jpg") no-repeat center center/cover;
        position: relative;
        display: flex;
        align-items: center;
    }

    /* Optional Overlay for Better Readability */
    .login-container::before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(5, 5, 5, 0.7);
        z-index: 1;
    }

    /* Login Card */
    .login-card {
        background-color: #1a1a1a;
        padding: 40px;
        border-radius: 10px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
        width: 100%;
        max-width: 400px;
        position: relative;
        z-index: 2;
        margin: 15px 0 15px 0;
    }

    .login-card h2 {
        text-align: center;
        margin-bottom: 30px;
        color: #ff6f00;
    }

    /* Form Controls */
    .form-control {
        background-color: #121212;
        border: 1px solid #333;
        color: #f8f9fa;
    }

    .form-control:focus {
        background-color: #1a1a1a;
        border-color: #e65c00;
        box-shadow: none;
    }

    .btn-login-submit {
        background-color: #ff6f00;
        border: none;
        color: #fff;
        padding: 10px;
        font-weight: bold;
        width: 100%;
        border-radius: 5px;
        transition: background-color 0.3s ease;
    }

    .btn-login-submit:hover {
        background-color: #e65c00;
    }

    .login-links {
        text-align: center;
        margin-top: 20px;
    }

    .login-links a {
        color: #e65c00;
        text-decoration: none;
    }

    .login-links a:hover {
        text-decoration: underline;
    }
</style>


<!-- Login Form Section with Background Image -->
<div class="login-container">
    <div class="container">
        <div class="row justify-content-start">
            <div class="col-md-6 col-lg-4 offset-lg-1">
                <div class="login-card">
                    <h2 id="form-title">Member Login</h2>

                    <!-- Toggle for Admin Login -->
                    <div class="toggle-container" style="text-align:center; margin-bottom:20px;">
                        <label style="color:#e65c00;">
                            <input type="checkbox" id="login-toggle" /> Admin Login
                        </label>
                    </div>

                    <form id="login-form">
                        <!-- For member login, this is email. For admin, this will be username. -->
                        <div class="form-group" id="user-input-group">
                            <label for="user-input" id="user-label">Email Address</label>
                            <input
                                type="email"
                                class="form-control"
                                id="user-input"
                                placeholder="Enter email"
                                required />
                        </div>
                        <div class="form-group mt-3">
                            <label for="password" id="password-label">Password</label>
                            <input
                                type="password"
                                class="form-control"
                                id="password"
                                placeholder="Enter password"
                                required />
                        </div>

                        <button type="submit" class="btn btn-login-submit mt-4">
                            Login
                        </button>
                    </form>
                    <div class="login-links">
                        <a href="index.php?page=forgetPassword">Forgot Password?</a>
                        <br />
                        <span>Don't have an account? <a href="index.php?page=member">Register</a></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const toggle = document.getElementById("login-toggle");
        const formTitle = document.getElementById("form-title");
        const userLabel = document.getElementById("user-label");
        const userInput = document.getElementById("user-input");
        const loginForm = document.getElementById("login-form");

        // Toggle change event
        toggle.addEventListener("change", function() {
            if (this.checked) {
                // Switch to admin login
                formTitle.textContent = "Admin Login";
                userLabel.textContent = "Username";
                userInput.placeholder = "Enter username";
                // Change the input type if needed (here we use text instead of email)
                userInput.type = "text";
            } else {
                // Switch back to member login
                formTitle.textContent = "Member Login";
                userLabel.textContent = "Email Address";
                userInput.placeholder = "Enter email";
                userInput.type = "email";
            }
        });

        loginForm.addEventListener("submit", async function(e) {
            e.preventDefault();

            // Determine login type based on toggle
            const isAdmin = toggle.checked;
            const url = "http://localhost/cs/backend/userManagement/";
            const endpoint = isAdmin ?
                url + "adminLog.php" :
                url + "memLog.php";

            // Gather input values
            const userValue = userInput.value.trim();
            const passwordValue = document.getElementById("password").value.trim();

            // Build the payload based on login type
            let formData = {};
            if (isAdmin) {
                formData = {
                    adUserName: userValue,
                    adPass: passwordValue
                };
            } else {
                formData = {
                    mail: userValue,
                    password: passwordValue
                };
            }

            try {
                const response = await fetch(endpoint, {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json"
                    },
                    body: JSON.stringify(formData)
                });

                const data = await response.json();
                if (data.success) {
                    // Redirect accordingly
                    window.location.href = isAdmin ?
                        "adminPanel.php" :
                        "index.php";
                } else {
                    alert(data.message);
                }
            } catch (error) {
                console.error("Error:", error);
                alert("An error occurred. Please try again.");
            }
        });

    });
</script>