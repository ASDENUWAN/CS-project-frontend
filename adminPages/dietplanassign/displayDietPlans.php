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

    #dietPlanTable {
        width: 100%;
        margin-top: 20px;
    }

    #dietPlanTable thead th {
        background-color: #1e1e1e;
        color: #e66a11;
        border-color: #444;
    }

    #dietPlanTable tbody td {
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
            <h2 class="text-center">Diet Plan List</h2>
            <a href="adminPanel.php?page=addEditDietPlan&&fd=dietplanassign" class="btn btn-success">
                <i class="bi bi-plus-circle"></i> Add Diet Plans
            </a>
        </div>

        <div id="responseMessage" class="mt-3 text-center"></div>

        <table id="dietPlanTable" class="table table-bordered table-striped mt-4">
            <thead class="table-light">
                <tr class="text-center">
                    <th>Diet Plan Number</th>
                    <th>Member ID</th>
                    <th>Diet ID</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Status</th>
                    <th>Height (cm)</th>
                    <th>Weight (kg)</th>
                    <th>Edit</th>
                    <th>Delete</th>
                </tr>
            </thead>
            <tbody id="dietPlanTableBody">
                <!-- Data will be inserted dynamically here -->
            </tbody>
        </table>
    </div>
</div>

<script>
    async function fetchDietPlans() {
        try {
            const response = await fetch("http://localhost/cs/backend/dietAssigningManagement/getDietPlans.php");
            const result = await response.json();

            if (result.success) {
                populateTable(result.dietPlans);
            } else {
                showMessage(result.message, "warning");
            }
        } catch (error) {
            console.error("Error fetching diet plans:", error);
            showMessage("Failed to fetch diet plan data.", "danger");
        }
    }

    function populateTable(dietPlans) {
        const tableBody = document.getElementById("dietPlanTableBody");
        tableBody.innerHTML = ""; // Clear existing data

        dietPlans.forEach(dietp => {
            const row = `<tr class="text-center">
                      <td>${dietp.dietPlan_number}</td>
                      <td>${dietp.memberID}</td>
                      <td>${dietp.dietID}</td>
                      <td>${dietp.startDate}</td>
                      <td>${dietp.endDate}</td>
                      <td>${dietp.dpStatus}</td>
                      <td>${dietp.height}</td>
                      <td>${dietp.weightKG}</td>
                      <td>
                       <a href="adminPanel.php?page=addEditDietPlan&&fd=dietplanassign&dietPlan_number=${dietp.dietPlan_number}" class="btn btn-warning">
                            <i class="bi bi-pencil-fill"></i>
                        </a>
                    </td>
                      <td>
                          <button class="btn btn-danger" onclick="deleteDietPlan(${dietp.dietPlan_number})">
                              <i class="bi bi-trash"></i>
                          </button>
                      </td>
                    </tr>`;
            tableBody.innerHTML += row;
        });
    }

    async function deleteDietPlan(dietPlan_number) {
        if (confirm("Are you sure you want to delete this diet plan?")) {
            try {
                const response = await fetch("http://localhost/cs/backend/dietAssigningManagement/removeDietPlaln.php", {
                    method: "DELETE",
                    headers: {
                        "Content-Type": "application/json"
                    },
                    body: JSON.stringify({
                        dietPlan_number
                    }),
                });

                const result = await response.json();
                if (result.success) {
                    showMessage(result.message, "success");
                    fetchDietPlans(); // Reload the table
                } else {
                    showMessage(result.message, "danger");
                }
            } catch (error) {
                console.error("Error deleting diet plan:", error);
                showMessage("Failed to delete diet plan.", "danger");
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

    // Fetch diet plan when page loads
    fetchDietPlans();
</script>