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

    #dietTable {
        width: 100%;
        margin-top: 20px;
    }

    #dietTable thead th {
        background-color: #1e1e1e;
        color: #e66a11;
        border-color: #444;
    }

    #dietTable tbody td {
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

    .search-bar-custom input::placeholder {
        color: #bbb;
    }

    .search-bar-custom input:focus {
        box-shadow: none;
        border-color: #e66a11;
    }

    .search-bar-custom .btn:hover {
        background-color: #e66a11;
        color: white;
    }
</style>

<div class="main-content-table">
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="text-center">Diet List</h2>

        </div>

        <div id="responseMessage" class="mt-3 text-center"></div>

        <table id="dietTable" class="table table-bordered table-striped mt-4">
            <thead class="table-light">
                <tr class="text-center">
                    <th>Diet ID</th>
                    <th>Diet Name</th>
                    <th>Diet Type</th>
                </tr>
            </thead>
            <tbody id="dietTableBody">
                <!-- Data will be inserted dynamically here -->
            </tbody>
        </table>
    </div>
</div>

<script>
    async function fetchDiets() {
        try {
            const response = await fetch("http://localhost/cs/backend/dietPlanManagement/getDiet.php");
            const result = await response.json();

            if (result.success) {
                populateTable(result.diets);
            } else {
                showMessage(result.message, "warning");
            }
        } catch (error) {
            console.error("Error fetching payments:", error);
            showMessage("Failed to fetch payment data.", "danger");
        }
    }

    function populateTable(diets) {
        const tableBody = document.getElementById("dietTableBody");
        tableBody.innerHTML = ""; // Clear existing data

        diets.forEach(diet => {
            const row = `<tr class="text-center">
                      <td>${diet.dietID}</td>
                      <td>${diet.dietName}</td>
                      <td>${diet.dietType}</td>
                    </tr>`;
            tableBody.innerHTML += row;
        });
    }
    fetchDiets();
</script>