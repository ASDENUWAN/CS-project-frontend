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
                    <h2 id="form-title">Become a Member</h2>
                    <form id="register-form">
                        <input type="hidden" id="memID">
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
                        <?php if (!isset($_SESSION['user_id'])) { ?>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" class="form-control" id="password" placeholder="Enter a secure password" required>
                            </div>
                        <?php } ?>

                        <button type="submit" class="btn btn-login-submit mt-4" id="submit-button">Register</button>
                        <?php if (isset($_SESSION['user_id'])) { ?>
                            <div class="form-group mt-4" id="change-password-section" style="display: none;">
                                <label for="newPassword">New Password</label>
                                <input type="password" class="form-control" id="newPassword" placeholder="Enter new password">

                                <label for="confirmPassword" class="mt-3">Confirm New Password</label>
                                <input type="password" class="form-control" id="confirmPassword" placeholder="Confirm new password">
                                <!-- Inside #change-password-section -->
                                <button type="button" class="btn btn-warning mt-3" id="save-password-btn">Save New Password</button>

                            </div>

                            <button type="button" class="btn btn-secondary mt-3" id="change-password-btn">Change Password</button>

                        <?php } ?>
                    </form>

                    <?php if (!isset($_SESSION['user_id'])) { ?>
                        <div class="register-links">
                            <span>Already have an account? <a href="index.php?page=login">Login</a></span>
                        </div>
                    <?php } ?>

                </div>
            </div>
        </div>
    </div>
</div>
<script>
    let memID = <?php echo json_encode($_SESSION['user_id'] ?? null); ?>;
    document.addEventListener("DOMContentLoaded", function() {
        const registerForm = document.getElementById("register-form");
        const formTitle = document.getElementById("form-title");
        const submitButton = document.getElementById("submit-button");
        const memIDField = document.getElementById("memID");



        if (memID) {
            // Editing existing member
            formTitle.textContent = "Edit Member Details";
            submitButton.textContent = "Update";
            loadMemberData(memID);

            // Hide the password field when editing
            const passwordField = document.getElementById("password");
            if (passwordField) {
                passwordField.closest(".form-group").style.display = "none";
            }
        }

        async function loadMemberData(memID) {
            try {
                const response = await fetch('http://localhost/cs/backend/userManagement/getMemberByID.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        memID
                    })
                });

                const data = await response.json();
                if (data.success) {
                    const member = data.data;
                    memIDField.value = member.memID;
                    document.getElementById('memName').value = member.memName;
                    document.getElementById('memNIC').value = member.memNIC;
                    document.getElementById('mail').value = member.mail;
                    document.getElementById('mobile').value = member.mobile;
                    document.getElementById('age').value = member.age;
                    document.getElementById('address').value = member.address;
                    document.getElementById('gender').value = member.gender;
                    document.getElementById('height').value = member.height;
                    document.getElementById('weight').value = member.weight;
                } else {
                    alert(data.message);
                }
            } catch (error) {
                console.error("Error loading member:", error);
                alert("Failed to load member details.");
            }
        }

        registerForm.addEventListener("submit", async function(e) {
            e.preventDefault();

            const isEditing = !!memID; // true if memID exists

            const formData = {
                memID: memIDField.value,
                memName: document.getElementById("memName").value.trim(),
                memNIC: document.getElementById("memNIC").value.trim(),
                mail: document.getElementById("mail").value.trim(),
                mobile: document.getElementById("mobile").value.trim(),
                age: document.getElementById("age").value.trim(),
                address: document.getElementById("address").value.trim(),
                gender: document.getElementById("gender").value,
                height: document.getElementById("height").value.trim(),
                weight: document.getElementById("weight").value.trim()
            };

            if (!isEditing) {
                formData.password = document.getElementById("password").value.trim();
            }

            try {
                let apiURL = "http://localhost/cs/backend/userManagement/addMember.php";
                let method = 'POST';
                if (isEditing) {
                    apiURL = "http://localhost/cs/backend/userManagement/editMember.php";
                    method = 'PUT'
                }

                const response = await fetch(apiURL, {
                    method: method,
                    headers: {
                        "Content-Type": "application/json"
                    },
                    body: JSON.stringify(formData)
                });

                const data = await response.json();
                if (data.success) {
                    alert(data.message);
                    if (!isEditing) {
                        window.location.href = "index.php?page=login"; // After registration, go to login
                    } else {
                        window.location.reload(); // After editing, refresh page
                    }
                } else {
                    alert(data.message);
                }
            } catch (error) {
                console.error("Error submitting form:", error);
                alert("An error occurred. Please try again.");
            }
        });
    });

    document.getElementById("change-password-btn").addEventListener("click", function() {
        const passwordSection = document.getElementById("change-password-section");
        passwordSection.style.display = passwordSection.style.display === "none" ? "block" : "none";
    });

    // Separate password change submit
    async function changePassword(memID) {
        const newPassword = document.getElementById("newPassword").value.trim();
        const confirmPassword = document.getElementById("confirmPassword").value.trim();

        if (!newPassword || !confirmPassword) {
            alert("Please fill both password fields.");
            return;
        }

        if (newPassword !== confirmPassword) {
            alert("Passwords do not match.");
            return;
        }

        if (newPassword.length < 4) {
            alert("Password must be at least 5 characters long.");
            return;
        }

        try {
            const response = await fetch('http://localhost/cs/backend/userManagement/passwordManage/changePassword.php', {
                method: 'POST',
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify({
                    memID,
                    newPassword
                })
            });

            const data = await response.json();
            if (data.success) {
                alert("Password updated successfully!");
                document.getElementById("newPassword").value = "";
                document.getElementById("confirmPassword").value = "";
                document.getElementById("change-password-section").style.display = "none";
            } else {
                alert(data.message);
            }
        } catch (error) {
            console.error("Error changing password:", error);
            alert("Failed to change password.");
        }
    }
    document.getElementById("save-password-btn").addEventListener("click", async function() {
        await changePassword(memID);
    });
</script>