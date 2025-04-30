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

    #scheduleTable {
        width: 100%;
        margin-top: 20px;
    }

    #scheduleTable thead th {
        background-color: #1e1e1e;
        color: #e66a11;
        border-color: #444;
    }

    #scheduleTable tbody td {
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
        <div class="d-flex justify-content-between align-items-center top-action-bar">
            <h2 class="text-center">Member Schedules</h2>
            <a href="adminPanel.php?page=addScheduleDetails&&fd=scheduleassign" class="btn btn-success">
                <i class="bi bi-plus-circle"></i> Add Schedule
            </a>
        </div>

        <div id="responseMessage" class="mt-3 text-center"></div>

        <div class="table-container">
            <table id="scheduleTable" class="table table-bordered table-striped mt-4">
                <thead class="table-light">
                    <tr class="text-center">
                        <th>Schedule ID</th>
                        <th>Member ID</th>
                        <th>MPlan ID</th>
                        <th>MPlan Name</th>
                        <th>Duration Type</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Status</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody id="scheduleTableBody">
                    <!-- Data will be inserted dynamically here -->
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    async function fetchSchedules() {
        try {
            const response = await fetch("http://localhost/Cs/backend/scheduleManagement/getSchedules.php");
            const result = await response.json();

            if (result.success) {
                populateTable(result.schedules);
            } else {
                showMessage(result.message, "warning");
            }
        } catch (error) {
            console.error("Error fetching schedules:", error);
            showMessage("Failed to fetch schedule data.", "danger");
        }
    }

    function populateTable(schedules) {
        const tableBody = document.getElementById("scheduleTableBody");
        tableBody.innerHTML = ""; // Clear existing data

        schedules.forEach(schedule => {
            const isExpired = schedule.scheduleStatus.toLowerCase() === "expired";

            const editButton = isExpired ?
                `<button class="btn btn-secondary" disabled title="Cannot edit expired schedule">
                    <i class="bi bi-pencil-fill"></i>
               </button>` :
                `<a href="adminPanel.php?page=editScheduleDetails&&fd=scheduleassign&memberSID=${schedule.memberSID}" class="btn btn-warning">
                    <i class="bi bi-pencil-fill"></i>
               </a>`;

            const row = `<tr class="text-center">
                      <td>${schedule.memberSID}</td>
                      <td>${schedule.memberID}</td>
                      <td>${schedule.mpID}</td>
                      <td>${schedule.mplanName}</td>
                      <td>${schedule.scheduleDuration}</td>
                      <td>${schedule.sDate}</td>
                      <td>${schedule.eDate}</td>
                      <td>${schedule.scheduleStatus}</td>
                      <td>${editButton}</td>
                      <td>
                          <button class="btn btn-danger" onclick="deleteSchedule(${schedule.memberSID})">
                              <i class="bi bi-trash"></i>
                          </button>
                      </td>
                    </tr>`;
            tableBody.innerHTML += row;
        });
    }



    async function deleteSchedule(memberSID) {
        if (confirm("Are you sure you want to delete this schedule?")) {
            try {
                const response = await fetch("http://localhost/Cs/backend/scheduleManagement/removeSchedule.php", {
                    method: "DELETE",
                    headers: {
                        "Content-Type": "application/json"
                    },
                    body: JSON.stringify({
                        memberSID
                    }),
                });

                const result = await response.json();
                if (result.success) {
                    showMessage(result.message, "success");
                    fetchSchedules(); // Reload the table
                } else {
                    showMessage(result.message, "danger");
                }
            } catch (error) {
                console.error("Error deleting schedule:", error);
                showMessage("Failed to delete schedule.", "danger");
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

    // Fetch schedules when page loads
    fetchSchedules();
</script>