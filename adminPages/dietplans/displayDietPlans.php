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

    #dietPlanTable td {
        max-width: 200px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    #dietPlanTable td a {
        color: #e66a11;
        text-decoration: none;
    }

    #dietPlanTable td.clicked {
        background-color: #ff6f00;
        color: #fff;
    }

    #dietPlanTable td span {
        cursor: pointer;
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
            <a href="adminPanel.php?page=addDietPlans&&fd=dietplans" class="btn btn-success">
                <i class="bi bi-plus-circle"></i> Add Diet Plan
            </a>
        </div>

        <div id="responseMessage" class="mt-3 text-center"></div>

        <table id="dietPlanTable" class="table table-bordered table-striped mt-4">
            <thead class="table-light">
                <tr class="text-center">
                    <th>Diet ID</th>
                    <th>Diet Name</th>
                    <th>Diet Type</th>
                    <th>Breakfast</th>
                    <th>Lunch</th>
                    <th>Dinner</th>
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
    document.addEventListener('DOMContentLoaded', fetchDietPlans);

    async function fetchDietPlans() {
        try {
            const response = await fetch("http://localhost/cs/backend/DietPlanManagement/getalldiet.php");
            const result = await response.json();

            if (result.success) {
                allPlans = result.diets.sort((a, b) => a.dietID - b.dietID);
                populateDietTable(allPlans);
            } else {
                showMessage(result.message, "warning");
            }
        } catch (error) {
            console.error("Error fetching diet plans:", error);
            showMessage("Failed to fetch diet plans.", "danger");
        }
    }

    function populateDietTable(diets) {
        const tableBody = document.getElementById("dietPlanTableBody");
        tableBody.innerHTML = ""; // Clear existing data

        diets.forEach(diet => {
            const row = `<tr class="text-center" onclick="openDietForm(${diet.dietID})">
                          <td>${limitText(diet.dietID)}</td>
                          <td>${limitText(diet.dietName)}</td>
                          <td>${limitText(diet.dietType)}</td>
                          <td>${limitText(diet.Breakfast)}</td>
                          <td>${limitText(diet.Lunch)}</td>
                          <td>${limitText(diet.Dinner)}</td>
                          <td>
                              <a href="adminPanel.php?page=editDietPlans&&fd=dietplans&dietID=${diet.dietID}" class="btn btn-warning">
                                  <i class="bi bi-pencil-fill"></i>
                              </a>
                          </td>
                          <td>
                              <button class="btn btn-danger" onclick="deleteDiet(${diet.dietID})">
                                  <i class="bi bi-trash"></i>
                              </button>
                          </td>
                        </tr>`;
            tableBody.innerHTML += row;
        });
    }

    function limitText(text) {
        if (text) {
            let words = text.split(" ");
            if (words.length > 3) {
                return words.slice(0, 3).join(" ") + "...";
            }
            return text;
        }
        return "-";
    }

    function openDietForm(dietID) {
        // Redirect to viewDietDetails page with the dietID as a query parameter
        window.location.href = `adminPanel.php?page=viewDietDetails&&fd=dietplans&dietID=${dietID}`;
    }

    async function deleteDiet(dietID) {
        event.stopPropagation(); // Prevent triggering openDietForm
        if (confirm("Are you sure you want to delete this diet plan?")) {
            try {
                const response = await fetch("http://localhost/cs/backend/DietPlanManagement/removeDiet.php", {
                    method: "DELETE",
                    headers: {
                        "Content-Type": "application/json"
                    },
                    body: JSON.stringify({
                        dietID
                    })
                });

                const result = await response.json();
                if (result.success) {
                    showMessage(result.message, "success");
                    fetchDietPlans(); // Reload the table
                } else {
                    showMessage(result.message, "danger");
                }
            } catch (error) {
                console.error("Error deleting diet:", error);
                showMessage("Failed to delete diet plan.", "danger");
            }
        }
    }

    function showMessage(message, type) {
        const responseMessage = document.getElementById("responseMessage");
        responseMessage.innerHTML = `<div class="alert alert-${type}" role="alert">${message}</div>`;
        setTimeout(() => {
            responseMessage.innerHTML = "";
        }, 1500);
    }
</script>