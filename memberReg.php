<style>
    /* Registration Form Container with Background Image */
    .register-container {
        min-height: calc(100vh - 160px);
        /* Adjust based on header/footer height */
        background: url("Images/bg3.jpg") no-repeat center center/cover;
        position: relative;
        display: flex;
        align-items: center;
    }

    /* Optional Overlay for Better Readability */
    .register-container::before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(5, 5, 5, 0.6);
        z-index: 1;
    }

    /* Registration Card */
    .register-card {
        background-color: rgba(26, 26, 26, 0.6);
        padding: 40px;
        border-radius: 10px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        width: 100%;
        max-width: 500px;
        position: relative;
        z-index: 2;
        margin: 15px;
        color: #f8f9fa;
    }

    .register-card h2 {
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

    .register-links {
        text-align: center;
        margin-top: 20px;
    }

    .register-links a {
        color: #e65c00;
        text-decoration: none;
    }

    .register-links a:hover {
        text-decoration: underline;
    }
</style>
<!-- Registration Form Section with Background Image -->
<div class="register-container">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="register-card">
                    <h2>Become a Member</h2>
                    <form id="register-form">
                        <!-- Full Name -->
                        <div class="form-group">
                            <label for="memName">Full Name</label>
                            <input type="text" class="form-control" id="memName" placeholder="Enter your full name" required>
                        </div>
                        <div class="form-group">
                            <label for="memNIC">NIC</label>
                            <input type="text" class="form-control" id="memNIC" placeholder="Enter your NIC" required>
                        </div>
                        <!-- Email Address -->
                        <div class="form-group">
                            <label for="mail">Email Address</label>
                            <input type="email" class="form-control" id="mail" placeholder="Enter your email" required>
                        </div>
                        <!-- Mobile -->
                        <div class="form-group">
                            <label for="mobile">Mobile</label>
                            <input type="text" class="form-control" id="mobile" placeholder="Enter your mobile number" required>
                        </div>
                        <!-- Age -->
                        <div class="form-group">
                            <label for="age">Age</label>
                            <input type="number" class="form-control" id="age" placeholder="Enter your age" required>
                        </div>
                        <!-- Address -->
                        <div class="form-group">
                            <label for="address">Address</label>
                            <textarea class="form-control" id="address" rows="2" placeholder="Enter your address" required></textarea>
                        </div>
                        <!-- Gender -->
                        <div class="form-group">
                            <label for="gender">Gender</label>
                            <select class="form-control" id="gender" required>
                                <option value="">Select Gender</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                        <!-- Height -->
                        <div class="form-group">
                            <label for="height">Height (cm)</label>
                            <input type="number" step="0.1" class="form-control" id="height" placeholder="Enter your height">
                        </div>
                        <!-- Weight -->
                        <div class="form-group">
                            <label for="weight">Weight (kg)</label>
                            <input type="number" step="0.1" class="form-control" id="weight" placeholder="Enter your weight">
                        </div>
                        <!-- Password -->
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" id="password" placeholder="Enter a secure password" required>
                        </div>
                        <button type="submit" class="btn btn-login-submit mt-4">Register</button>
                    </form>
                    <div class="register-links">
                        <span>Already have an account? <a href="login.php">Login</a></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript for Form Submission -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const registerForm = document.getElementById("register-form");

        registerForm.addEventListener("submit", async function(e) {
            e.preventDefault();

            // Collect form data
            const memName = document.getElementById("memName").value.trim();
            const mail = document.getElementById("mail").value.trim();
            const mobile = document.getElementById("mobile").value.trim();
            const memNIC = document.getElementById("memNIC").value.trim(); // NEW LINE
            const age = document.getElementById("age").value.trim();
            const address = document.getElementById("address").value.trim();
            const gender = document.getElementById("gender").value;
            const height = document.getElementById("height").value.trim();
            const weight = document.getElementById("weight").value.trim();
            const password = document.getElementById("password").value.trim();

            // Build the payload (include memNIC)
            const formData = {
                memName,
                mail,
                mobile,
                memNIC, // NEW LINE
                age,
                address,
                gender,
                height,
                weight,
                password
            };

            try {
                const response = await fetch("http://localhost/cs/backend/userManagement/addMember.php", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json"
                    },
                    body: JSON.stringify(formData)
                });

                const data = await response.json();
                if (data.success) {
                    alert(data.message);
                    // Redirect to login page (or automatically log the user in)
                    window.location.href = "index.php?page=login";
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