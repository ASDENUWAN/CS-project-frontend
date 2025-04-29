<style>
    .main-content-table {
        margin-left: 240px;
        padding: 20px;
        padding-top: 80px;
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    @media (max-width: 767.98px) {
        .main-content-table {
            margin-left: 0;
            padding: 80px 10px 20px;
        }
    }

    #paymentTable {
        width: 100%;
        margin-top: 20px;
    }

    #paymentTable thead th {
        background-color: #1e1e1e;
        color: #e66a11;
        border-color: #444;
    }

    #paymentTable tbody td {
        color: #f8f9fa;
        vertical-align: middle;
    }

    .table-container {
        overflow-x: auto;
        width: 100%;
    }

    .btn {
        padding: 6px 10px;
        font-size: 0.875rem;
    }

    .btn i {
        font-size: 1rem;
    }

    .top-action-bar {
        flex-wrap: wrap;
        gap: 1rem;
    }

    .top-action-bar h2 {
        margin: 0;
        color: #f8f9fa;
    }

    #responseMessage .alert {
        margin-top: 10px;
    }
</style>

<div class="main-content-table">
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="text-center">Payment List</h2>
            <a href="adminPanel.php?page=addPaymentDetails&&fd=payment" class="btn btn-success">
                <i class="bi bi-plus-circle"></i> Add Payment
            </a>
        </div>

        <div id="responseMessage" class="mt-3 text-center"></div>

        <table id="paymentTable" class="table table-bordered table-striped mt-4">

            <thead class="table-light">
                <tr class="text-center">
                    <th>Payment ID</th>
                    <th>Member ID</th>
                    <th>Member Name</th>
                    <th>Payment Type</th>
                    <th>Payment Date</th>
                    <th>Due Date</th>
                    <th>Amount</th>
                    <th>Payment Status</th>
                    <th>Edit</th>
                    <th>Delete</th>
                </tr>
            </thead>
            <tbody id="paymentTableBody">
                <!-- Data will be inserted dynamically here -->
            </tbody>
        </table>
    </div>
</div>
<script>
    async function fetchPayments() {
        try {
            const response = await fetch("http://localhost/cs/backend/paymentManagement/getPayments.php");
            const result = await response.json();

            if (result.success) {
                populateTable(result.payments);
            } else {
                showMessage(result.message, "warning");
            }
        } catch (error) {
            console.error("Error fetching payments:", error);
            showMessage("Failed to fetch payment data.", "danger");
        }
    }

    function populateTable(payments) {
        const tableBody = document.getElementById("paymentTableBody");
        tableBody.innerHTML = ""; // Clear existing data

        payments.forEach(payment => {
            const isExpired = payment.paymentStatus.toLowerCase() === "expired";

            const editButton = isExpired ?
                `<button class="btn btn-secondary" disabled title="Cannot edit expired payment">
                <i class="bi bi-pencil-fill"></i>
             </button>` :
                `<a href="adminPanel.php?page=editPaymentDetails&&fd=payment&paymentID=${payment.paymentID}" class="btn btn-warning">
                <i class="bi bi-pencil-fill"></i>
             </a>`;

            const row = `<tr class="text-center">
                      <td>${payment.paymentID}</td>
                      <td>${payment.memberID}</td>
                      <td>${payment.memberName}</td>
                      <td>${payment.paymentType}</td>
                      <td>${payment.paymentDate}</td>
                      <td>${payment.dueDate}</td>
                      <td>${payment.amount}</td>
                      <td>${payment.paymentStatus}</td>
                      <td>${editButton}</td>
                      <td>
                          <button class="btn btn-danger" onclick="deletePayment(${payment.paymentID})">
                              <i class="bi bi-trash"></i>
                          </button>
                      </td>
                    </tr>`;
            tableBody.innerHTML += row;
        });
    }


    async function deletePayment(paymentID) {
        if (confirm("Are you sure you want to delete this payment?")) {
            try {
                const response = await fetch("http://localhost/Cs/backend/paymentManagement/deletePayment.php", {
                    method: "DELETE",
                    headers: {
                        "Content-Type": "application/json"
                    },
                    body: JSON.stringify({
                        paymentID
                    }),
                });

                const result = await response.json();
                if (result.success) {
                    showMessage(result.message, "success");
                    fetchPayments(); // Reload the table
                } else {
                    showMessage(result.message, "danger");
                }
            } catch (error) {
                console.error("Error deleting payment:", error);
                showMessage("Failed to delete payment.", "danger");
            }
        }
    }

    function showMessage(message, type) {
        const responseMessage = document.getElementById("responseMessage");
        responseMessage.innerHTML = `<div class="alert alert-${type}" role="alert">${message}</div>`;
        setTimeout(() => {
            responseMessage.innerHTML = "";
        }, 800);
    }

    // Fetch payments when page loads
    fetchPayments();
</script>