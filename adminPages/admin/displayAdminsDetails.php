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

    #adminTable {
        width: 100%;
        margin-top: 20px;
    }

    #adminTable thead th {
        background-color: #1e1e1e;
        color: #e66a11;
        border-color: #444;
    }

    #adminTable tbody td {
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
            <h2 class="text-center">Admin List</h2>
        </div>

        <div id="responseMessage" class="mt-3 text-center"></div>

        <table id="adminTable" class="table table-bordered table-striped mt-4">

            <thead class="table-light">
                <tr class="text-center">
                    <th>Username</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Role</th>

                </tr>
            </thead>
            <tbody id="adminTableBody">
                <!-- Data will be inserted dynamically here -->
            </tbody>
        </table>
    </div>
</div>

<script>
    async function fetchAdmins() {
        try {
            const response = await fetch("http://localhost/cs/backend/userManagement/getAdmins.php");
            const result = await response.json();

            if (result.success) {
                populateTable(result.admins);
            } else {
                showMessage(result.message, "warning");
            }
        } catch (error) {
            console.error("Error fetching admins:", error);
            showMessage("Failed to fetch admin data.", "danger");
        }
    }

    function populateTable(admins) {
        const tableBody = document.getElementById("adminTableBody");
        tableBody.innerHTML = ""; // Clear existing data

        admins.forEach(admin => {
            const isManager = admin.adRole.toLowerCase() === "manager";



            const row = `<tr class="text-center">
                        <td>${admin.adUserName}</td>
                        <td>${admin.adName}</td>
                        <td>${admin.adMail}</td>
                        <td>${admin.adPhone}</td>
                        <td>${admin.adRole}</td>
                       
                    </tr>`;
            tableBody.innerHTML += row;
        });
    }




    function showMessage(message, type) {
        const responseMessage = document.getElementById("responseMessage");
        responseMessage.innerHTML = `<div class="alert alert-${type}" role="alert">${message}</div>`;
        setTimeout(() => {
            responseMessage.innerHTML = "";
        }, 800);
    }

    // Fetch admins when page loads
    fetchAdmins();
</script>