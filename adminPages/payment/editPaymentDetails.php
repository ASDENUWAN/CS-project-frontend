<style>
    .main-content-form {
        margin-left: 240px;
        padding: 20px;
        padding-top: 80px;
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    @media (max-width: 767.98px) {
        .main-content-form {
            margin-left: 0;
            padding: 80px 10px 20px;
        }
    }

    .main-content-form body {
        background-color: #070707;
        color: #f8f9fa;
        font-family: "Arial", sans-serif;
    }

    .main-content-form .container {
        background-color: #000;
        padding: 30px;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(255, 102, 0, 0.5);
        width: 100%;
        max-width: 700px;
    }

    .main-content-form h2 {
        color: #e65c00;
        font-weight: bold;
    }

    .main-content-form label {
        font-weight: bold;
        color: #f8f9fa;
    }

    .main-content-form #dueDate {
        background-color: #262626 !important;
        color: #f8f9fa !important;
        border: 1px solid #e65c00;
    }

    .main-content-form .form-control {
        background-color: #1b1b1b;
        color: #f8f9fa;
        border: 1px solid #e65c00;
    }

    .main-content-form .form-control::placeholder {
        color: #888;
    }

    .main-content-form .form-control:focus {
        background-color: #1b1b1b;
        color: #f8f9fa;
        border-color: #ff6f00;
        box-shadow: 0 0 8px rgba(230, 92, 0, 0.7);
    }

    .main-content-form .form-check-label {
        color: #f8f9fa;
    }

    .main-content-form .btn-primary {
        background-color: #e66a11;
        border-color: #e66a11;
        color: #fff;
        font-weight: bold;
        border-radius: 25px;
        transition: background-color 0.3s ease;
        width: 100%;
        margin-top: 1rem;
    }

    .main-content-form .btn-primary:hover {
        background-color: #e65c00;
    }

    .main-content-form .text-danger {
        color: #ff4d37 !important;
    }

    .main-content-form .flex-wrap-radio {
        flex-wrap: wrap;
        gap: 15px;
    }

    @media (max-width: 768px) {
        .main-content-form .flex-wrap-radio {
            flex-direction: column !important;
            padding: 20px 0;
        }

        .main-content-form .form-check {
            width: 100%;
        }
    }
</style>

<div class="main-content-form">
    <div class="container mt-5">
        <h2 id="formTitle" class="text-center">Edit Payment</h2>
        <form id="paymentForm" class="mt-4 shadow p-4 rounded">
            <input type="hidden" id="paymentID" name="paymentID">

            <div class="mb-3">
                <label for="memberID" class="form-label">Member ID</label>
                <input type="text" id="memberID" name="memberID" class="form-control" disabled>
            </div>

            <div class="mb-3">
                <label for="memberName" class="form-label">Member Name</label>
                <input type="text" id="memberName" name="memberName" class="form-control" disabled>
            </div>

            <div class="mb-3">
                <label class="form-label">Payment Type</label>
                <div class="d-flex gap-3 flex-wrap-radio">
                    <div class="form-check">
                        <input type="radio" name="paymentType" value="1 Month" class="form-check-input" id="oneMonth">
                        <label for="oneMonth" class="form-check-label">1 Month</label>
                    </div>
                    <div class="form-check">
                        <input type="radio" name="paymentType" value="6 Months" class="form-check-input" id="sixMonths">
                        <label for="sixMonths" class="form-check-label">6 Months</label>
                    </div>
                    <div class="form-check">
                        <input type="radio" name="paymentType" value="1 Year" class="form-check-input" id="oneYear">
                        <label for="oneYear" class="form-check-label">1 Year</label>
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <label for="paymentDate" class="form-label">Payment Date</label>
                <input type="date" id="paymentDate" name="paymentDate" class="form-control">
            </div>

            <div class="mb-3">
                <label for="dueDate" class="form-label">Due Date</label>
                <input type="date" id="dueDate" name="dueDate" class="form-control" readonly>
            </div>

            <div class="mb-3">
                <label for="amount" class="form-label">Amount</label>
                <select id="amount" name="amount" class="form-control">
                    <option value="5000">5000</option>
                    <option value="21000">21000</option>
                    <option value="40000">40000</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="paymentStatus" class="form-label">Payment Status</label>
                <input type=text id="paymentStatus" name="paymentStatus" class="form-control" readonly>
            </div>

            <button type="submit" class="btn btn-primary w-100">Save Changes</button>
        </form>

        <div id="responseMessage" class="mt-3 text-center"></div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", async function() {
        const urlParams = new URLSearchParams(window.location.search);
        const paymentID = urlParams.get("paymentID");

        if (paymentID) {
            document.getElementById("formTitle").innerText = "Edit Payment";
            fetchPaymentDetails(paymentID);
        }
    });


    document.addEventListener("DOMContentLoaded", function() {
        // Attach event listeners to radio buttons and payment date input
        document.querySelectorAll('input[name="paymentType"]').forEach(radio => {
            radio.addEventListener("change", calculateDueDate);
        });

        document.getElementById("paymentDate").addEventListener("change", calculateDueDate);
    });

    function calculateDueDate() {
        const paymentDate = document.getElementById("paymentDate").value;
        const dueDateInput = document.getElementById("dueDate");

        if (!paymentDate) {
            dueDateInput.value = "";
            return;
        }

        const selectedType = document.querySelector('input[name="paymentType"]:checked');
        if (!selectedType) {
            dueDateInput.value = "";
            return;
        }

        let daysToAdd = 0;
        if (selectedType.value === "1 Month") {
            daysToAdd = 30;
        } else if (selectedType.value === "6 Months") {
            daysToAdd = 180;
        } else if (selectedType.value === "1 Year") {
            daysToAdd = 365;
        }

        const date = new Date(paymentDate);
        date.setDate(date.getDate() + daysToAdd);

        const formattedDueDate = date.toISOString().split("T")[0];
        dueDateInput.value = formattedDueDate;
    }

    async function fetchPaymentDetails(paymentID) {
        try {
            const response = await fetch("http://localhost/cs/backend/paymentManagement/getPayment.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify({
                    paymentID
                }),
            });

            const result = await response.json();

            if (result.success) {
                document.getElementById("paymentID").value = result.payment.paymentID;
                document.getElementById("memberID").value = result.payment.memberID;
                document.getElementById("memberName").value = result.payment.memberName;
                document.getElementById("paymentDate").value = result.payment.paymentDate;
                document.getElementById("dueDate").value = result.payment.dueDate;
                document.getElementById("amount").value = result.payment.amount;
                document.getElementById("paymentStatus").value = result.payment.paymentStatus;

                // Set the selected payment type radio button
                document.querySelectorAll('input[name="paymentType"]').forEach(radio => {
                    if (radio.value === result.payment.paymentType) {
                        radio.checked = true;
                    }
                });
            } else {
                showMessage(result.message, "danger");
            }
        } catch (error) {
            console.error("Error fetching payment details:", error);
            showMessage("Failed to fetch payment details.", "danger");
        }
    }

    document.getElementById("paymentForm").addEventListener("submit", async function(event) {
        event.preventDefault();

        const paymentID = document.getElementById("paymentID").value.trim();
        const memberID = document.getElementById("memberID").value.trim();
        const memberName = document.getElementById("memberName").value.trim();
        const paymentType = document.querySelector('input[name="paymentType"]:checked')?.value || "";
        const paymentDate = document.getElementById("paymentDate").value.trim();
        const dueDate = document.getElementById("dueDate").value.trim();
        const amount = document.getElementById("amount").value.trim();
        const paymentStatus = document.getElementById("paymentStatus").value.trim();

        if (!paymentID) {
            showMessage("Invalid operation. Payment ID is required.", "danger");
            return;
        }

        if (!memberID || !memberName || !paymentType || !paymentDate || !dueDate || !amount || !paymentStatus) {
            showMessage("All fields are required.", "danger");
            return;
        }

        const paymentData = {
            paymentID,
            memberID,
            memberName,
            paymentType,
            paymentDate,
            dueDate,
            amount,
            paymentStatus
        };
        const method = "PUT";
        const url = "http://localhost/cs/backend/paymentManagement/updatePayment.php";
        try {
            const response = await fetch(url, {
                method,
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify(paymentData),
            });

            const result = await response.json();

            if (result.success) {
                showMessage(result.message, "success");
                setTimeout(() => {
                    window.location.href = "adminPanel.php?page=displayPayments&&fd=payment";
                }, 600);
            } else {
                showMessage(result.message, "danger");
            }
        } catch (error) {
            console.error("Error:", error);
            showMessage("An error occurred. Please try again.", "danger");
        }
    });

    function showMessage(message, type) {
        const responseMessage = document.getElementById("responseMessage");
        responseMessage.innerHTML = `<div class="alert alert-${type}" role="alert">${message}</div>`;
        setTimeout(() => {
            responseMessage.innerHTML = "";
        }, 1500);
    }
</script>