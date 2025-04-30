<style>
    /* Forgot Password Section */
    .forgot-password-container {
        min-height: calc(100vh - 160px);
        background: url("Images/bg7.jpg") no-repeat center center/cover;
        position: relative;
        display: flex;
        align-items: center;
    }

    .forgot-password-container::before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(5, 5, 5, 0.7);
        z-index: 1;
    }

    .forgot-card {
        background-color: #1a1a1a;
        padding: 40px;
        border-radius: 10px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
        width: 100%;
        max-width: 400px;
        position: relative;
        z-index: 2;
        margin: 15px;
        color: #f8f9fa;
    }

    .forgot-card h2,
    .forgot-card h4 {
        text-align: center;
        margin-bottom: 20px;
        color: #ff6f00;
    }

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

    .btn-forgot-submit {
        background-color: #ff6f00;
        border: none;
        color: #fff;
        padding: 10px;
        font-weight: bold;
        width: 100%;
        border-radius: 5px;
        transition: background-color 0.3s ease;
    }

    .btn-forgot-submit:hover {
        background-color: #e65c00;
    }
</style>

<!-- Forgot Password Full Section -->
<div class="forgot-password-container">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="forgot-card">
                    <h2>Forgot Password</h2>

                    <!-- Step 1: Enter Email -->
                    <form id="forgot-email-form">
                        <div class="form-group">
                            <label for="forgot-email">Enter Your Registered Email</label>
                            <input type="email" id="forgot-email" class="form-control" placeholder="Enter your email" required>
                        </div>
                        <button type="submit" class="btn-forgot-submit mt-4">Send Verification Code</button>
                    </form>

                    <!-- Step 2: Enter Verification Code -->
                    <div id="verify-code-section" style="display: none; margin-top: 30px;">
                        <h4>Enter Verification Code</h4>
                        <form id="verify-code-form">
                            <div class="form-group">
                                <label for="verification-code">Verification Code</label>
                                <input type="text" id="verification-code" class="form-control" placeholder="Enter code" required>
                            </div>
                            <button type="submit" class="btn-forgot-submit mt-4">Verify Code</button>
                        </form>
                    </div>

                    <!-- Step 3: Reset Password -->
                    <div id="reset-password-section" style="display: none; margin-top: 30px;">
                        <h4>Reset Password</h4>
                        <form id="reset-password-form">
                            <div class="form-group">
                                <label for="new-password">New Password</label>
                                <input type="password" id="new-password" class="form-control" placeholder="Enter new password" required>
                            </div>
                            <div class="form-group mt-3">
                                <label for="confirm-password">Confirm New Password</label>
                                <input type="password" id="confirm-password" class="form-control" placeholder="Confirm new password" required>
                            </div>
                            <button type="submit" class="btn-forgot-submit mt-4">Reset Password</button>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript -->
<script>
    let currentEmail = ""; // Save email to send everywhere

    const forgotEmailForm = document.getElementById("forgot-email-form");
    const verifyCodeSection = document.getElementById("verify-code-section");
    const verifyCodeForm = document.getElementById("verify-code-form");
    const resetPasswordSection = document.getElementById("reset-password-section");
    const resetPasswordForm = document.getElementById("reset-password-form");

    // Send Verification Code
    forgotEmailForm.addEventListener("submit", async function(e) {
        e.preventDefault();
        const email = document.getElementById("forgot-email").value.trim();
        if (!email) {
            Swal.fire('Error', 'Please enter your email.', 'error');
            return;
        }
        try {
            const response = await fetch('http://localhost/cs/backend/userManagement/passwordManage/sendResetCode.php', {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify({
                    mail: email
                })
            });
            const data = await response.json();
            if (data.success) {
                Swal.fire('Success', 'Verification code sent to your email.', 'success');
                currentEmail = email;
                // Hide email form
                forgotEmailForm.style.display = "none";
                // Show verify code form
                verifyCodeSection.style.display = "block";
            } else {
                Swal.fire('Error', data.message, 'error');
            }
        } catch (error) {
            console.error("Error sending reset code:", error);
            Swal.fire('Error', 'Something went wrong. Try again later.', 'error');
        }
    });

    // Verify Code
    verifyCodeForm.addEventListener("submit", async function(e) {
        e.preventDefault();
        const code = document.getElementById("verification-code").value.trim();
        if (!code) {
            Swal.fire('Error', 'Please enter the verification code.', 'error');
            return;
        }
        try {
            const response = await fetch('http://localhost/cs/backend/userManagement/passwordManage/verifyResetCode.php', {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify({
                    mail: currentEmail,
                    code: code
                })
            });
            const data = await response.json();
            if (data.success) {
                Swal.fire('Success', 'Code verified. You can now reset your password.', 'success');
                // Hide verify code form
                verifyCodeSection.style.display = "none";
                // Show reset password form
                resetPasswordSection.style.display = "block";
            } else {
                Swal.fire('Error', data.message, 'error');
            }
        } catch (error) {
            console.error("Error verifying code:", error);
            Swal.fire('Error', 'Verification failed. Try again.', 'error');
        }
    });

    // Reset Password
    resetPasswordForm.addEventListener("submit", async function(e) {
        e.preventDefault();
        const newPassword = document.getElementById("new-password").value.trim();
        const confirmPassword = document.getElementById("confirm-password").value.trim();

        if (!newPassword || !confirmPassword) {
            Swal.fire('Error', 'Please fill all password fields.', 'error');
            return;
        }
        if (newPassword !== confirmPassword) {
            Swal.fire('Error', 'Passwords do not match.', 'error');
            return;
        }
        if (newPassword.length < 6) {
            Swal.fire('Error', 'Password must be at least 6 characters.', 'error');
            return;
        }

        try {
            const response = await fetch('http://localhost/cs/backend/userManagement/passwordManage/resetPassword.php', {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify({
                    mail: currentEmail,
                    newPassword: newPassword
                })
            });
            const data = await response.json();
            if (data.success) {
                await Swal.fire('Success', 'Password reset successfully! Please login now.', 'success');
                window.location.href = "index.php?page=login";
            } else {
                Swal.fire('Error', data.message, 'error');
            }
        } catch (error) {
            console.error("Error resetting password:", error);
            Swal.fire('Error', 'Something went wrong. Try again.', 'error');
        }
    });
</script>