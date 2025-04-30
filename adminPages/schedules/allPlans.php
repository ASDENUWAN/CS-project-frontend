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

    #plansTable {
        width: 100%;
        margin-top: 20px;
    }

    #plansTable thead th {
        background-color: #1e1e1e;
        color: #e66a11;
        border-color: #444;
        text-align: center;
    }

    #plansTable tbody td {
        color: #f8f9fa;
        vertical-align: middle;
        text-align: center;
    }

    .table-container {
        overflow-x: auto;
        width: 100%;
    }

    .input-group {
        max-width: 400px;
        margin-bottom: 10px;
    }

    .form-label {
        color: #f8f9fa;
        font-weight: 600;
    }

    #noResults {
        margin-top: 10px;
        width: 100%;
        max-width: 400px;
        text-align: center;
    }

    h2.text-center {
        color: #f8f9fa;
        margin-bottom: 1rem;
    }

    .container.mt-5 {
        background-color: #121212;
        padding: 20px 30px;
        border-radius: 8px;
    }

    .btn {
        padding: 6px 12px;
        font-size: 0.875rem;
        cursor: pointer;
    }

    .btn-secondary {
        background-color: #6c757d;
        border: none;
        color: white;
    }

    .btn-secondary:hover {
        background-color: #5a6268;
    }

    .btn-success {
        background-color: #28a745;
        border: none;
        color: white;
        margin-left: auto;
    }

    .btn-success:hover {
        background-color: #218838;
    }

    .top-bar {
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 20px;
    }
</style>

<div class="main-content-table">
    <div class="container mt-5">

        <!-- Top bar: Title + Add New Button -->
        <div class="top-bar">
            <h2 class="text-center">Workout Plans</h2>
            <a href="adminPanel.php?page=addPlan&&fd=schedules" class="btn btn-success">
                <i class="bi bi-plus-circle"></i> Add New Plan
            </a>
        </div>

        <!-- Search Input Only -->
        <div class="mb-3">
            <label for="searchInput" class="form-label">Enter Workout Plan ID</label>
            <div class="input-group">
                <input type="number" class="form-control" id="searchInput" placeholder="Enter wpID..." />
                <button class="btn btn-secondary" id="resetBtn">Reset</button>
            </div>
        </div>

        <!-- No Results Message -->
        <div id="noResults" class="alert alert-warning" style="display:none;">
            No workout plan found!
        </div>

        <!-- Plans Table -->
        <div class="table-container">
            <table class="table table-bordered" id="plansTable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Workout Plan Name</th>
                    </tr>
                </thead>
                <tbody id="plansTableBody"></tbody>
            </table>
        </div>
    </div>
</div>

<script>
    let allPlans = [];

    async function fetchPlans() {
        try {
            const response = await fetch("http://localhost/cs/backend/exPlanManagement/getWorkout.php");
            const result = await response.json();

            if (result.success) {

                allPlans = result.plans.sort((a, b) => a.wpID - b.wpID);

                displayPlans(allPlans);
            } else {
                alert(result.message || "Failed to fetch workout plans.");
            }
        } catch (error) {
            console.error(error);
            alert("Error fetching plans.");
        }
    }


    function displayPlans(plans) {
        const tableBody = document.getElementById("plansTableBody");
        const plansTable = document.getElementById("plansTable");
        const noResults = document.getElementById("noResults");

        tableBody.innerHTML = "";

        if (plans.length === 0) {
            plansTable.style.display = "none";
            noResults.style.display = "block";
            return;
        }

        plansTable.style.display = "table";
        noResults.style.display = "none";

        plans.forEach(plan => {
            const row = document.createElement("tr");
            row.innerHTML = `<td>${plan.wpID}</td><td>${plan.wpName}</td>`;

            row.style.cursor = "pointer";
            row.addEventListener("click", function() {
                window.location.href = `adminPanel.php?page=planDetails&&fd=schedules&&wpID=${plan.wpID}`;
            });

            tableBody.appendChild(row);
        });
    }

    document.getElementById("searchInput").addEventListener("input", function() {
        const inputValue = this.value.trim();

        if (inputValue === "") {
            displayPlans(allPlans);
            return;
        }

        const filtered = allPlans.filter(plan => String(plan.wpID) === inputValue);
        displayPlans(filtered);
    });

    document.getElementById("resetBtn").addEventListener("click", function() {
        document.getElementById("searchInput").value = "";
        displayPlans(allPlans);
    });

    fetchPlans();
</script>

<!-- Bootstrap Icons for plus icon -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">