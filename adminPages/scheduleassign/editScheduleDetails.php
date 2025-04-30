<!-- Include Bootstrap CSS (if not already included) -->
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

    .main-content-form .btn-sub {
        background-color: #e66a11;
        color: #fff;
        font-weight: bold;
        border-radius: 25px;
        transition: background-color 0.3s ease;
        width: 100%;
        margin-top: 1rem;
    }

    .main-content-form .btn-sub:hover {
        background-color: #e65c00;
    }

    .main-content-form .text-danger {
        color: white !important;
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
        <h2 id="formTitle" class="text-center">Add Member Schedule</h2>
        <form id="scheduleForm" class="mt-4 shadow p-4 rounded">

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="memberID" class="form-label">Member ID</label>
                    <input type="text" id="memberID" name="memberID" class="form-control" placeholder="Enter member ID" readonly>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="mpID" class="form-label">MPlan ID</label>
                    <input type="text" id="mpID" name="mpID" class="form-control" placeholder="Enter MPlan ID" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label for="mplanName" class="form-label">MPlan Name</label>
                    <input type="text" id="mplanName" name="mplanName" class="form-control" placeholder="Enter Mplan name" required>
                </div>
                <div class="col-md-6 mb-2">
                    <button type="button" class="btn btn-sub ms-2" onclick="goToViewPlans()">View</button>
                </div>
            </div>


            <div class="mb-3">
                <label class="form-label">Schedule Duration Type</label>
                <div class="d-flex gap-3 flex-wrap-radio">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="scheduleDuration" id="duration1" value="1 month" required>
                        <label class="form-check-label" for="duration1">1 Month</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="scheduleDuration" id="duration3" value="3 months">
                        <label class="form-check-label" for="duration3">3 Months</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="scheduleDuration" id="duration6" value="6 months">
                        <label class="form-check-label" for="duration6">6 Months</label>
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <label for="sDate" class="form-label">Start Date</label>
                <input type="date" id="sDate" name="sDate" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="eDate" class="form-label">End Date</label>
                <input type="date" id="eDate" name="eDate" class="form-control" readonly>
            </div>

            <div class="mb-3">
                <label for="scheduleStatus" class="form-label">Schedule Status</label>
                <input type="text" id="scheduleStatus" name="scheduleStatus" class="form-control" readonly>
            </div>

            <button type="submit" class="btn btn-sub w-100 ">Save Schedule</button>
        </form>

        <div id="responseMessage" class="mt-3 text-center"></div>
    </div>
</div>

<!-- Include Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    const urlParams = new URLSearchParams(window.location.search);
    const memberSID = urlParams.get("memberSID");
    document.addEventListener("DOMContentLoaded", async function() {


        if (memberSID) {
            document.getElementById("formTitle").innerText = "Edit Member Schedule";
            fetchScheduleDetails(memberSID);
        }
    });


    async function fetchScheduleDetails(memberSID) {
        try {
            const response = await fetch("http://localhost/Cs/backend/scheduleManagement/getSchedule.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                },
                body: JSON.stringify({
                    memberSID: memberSID
                }),
            });

            const data = await response.json();

            if (data.success) {
                const schedule = data.schedule;
                document.getElementById("memberID").value = schedule.memberID;
                document.getElementById("mpID").value = schedule.mpID;
                document.getElementById("mplanName").value = schedule.mplanName;
                document.querySelector(`input[name="scheduleDuration"][value="${schedule.scheduleDuration}"]`)?.click();
                document.getElementById("sDate").value = schedule.sDate;
                document.getElementById("eDate").value = schedule.eDate;
                document.getElementById("scheduleStatus").value = schedule.scheduleStatus;
            } else {
                showMessage(data.message || "Failed to load schedule", "danger");
            }
        } catch (error) {
            console.error("Error fetching schedule details:", error);
            showMessage("An error occurred while fetching schedule details.", "danger");
        }
    }

    document.getElementById("scheduleForm").addEventListener("submit", async function(event) {
        event.preventDefault();

        const memberID = document.getElementById("memberID").value.trim();
        const mpID = document.getElementById("mpID").value.trim();
        const mplanName = document.getElementById("mplanName").value.trim();
        const scheduleDuration = document.querySelector('input[name="scheduleDuration"]:checked')?.value || "";
        const sDate = document.getElementById("sDate").value.trim();
        const eDate = document.getElementById("eDate").value.trim();
        const scheduleStatus = document.getElementById("scheduleStatus").value.trim();

        if (!memberID || !mpID || !mplanName || !scheduleDuration || !sDate || !eDate || !scheduleStatus) {
            showMessage("All fields are required.", "danger");
            return;
        }

        if (mpID === "Not Found" || mplanName === "Not Found") {
            showMessage("Invalid Plan ID or Plan Name. Please enter a valid one.", "danger");
            return;
        }


        const scheduleData = {
            memberSID: memberSID, // Include this for updating existing
            memberID,
            mpID,
            mplanName,
            scheduleDuration,
            sDate,
            eDate,
            scheduleStatus
        };

        const method = "PUT";
        const url = "http://localhost/Cs/backend/scheduleManagement/updateSchedule.php";

        try {
            const response = await fetch(url, {
                method,
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify(scheduleData),
            });

            const result = await response.json();

            if (result.success) {
                showMessage(result.message, "success");
                setTimeout(() => {
                    window.location.href = "adminPanel.php?page=displaySchedulesDetails&&fd=scheduleassign";
                }, 600);
            } else {
                showMessage(result.message, "danger");
            }
        } catch (error) {
            console.error("Error:", error);
            showMessage("An error occurred. Please try again.", "danger");
        }
    });

    //Get planName and planID from workout_plan Table
    async function fetchPlanData(inputType) {
        let wpID = document.getElementById("mpID").value.trim();
        let wpName = document.getElementById("mplanName").value.trim();

        let requestData = {};

        // If plan ID is cleared, reset the plan name
        if (inputType === "id" && wpID === "") {
            document.getElementById("mplanName").value = "";
            return;
        }

        // If plan name is cleared, reset the plan ID
        if (inputType === "name" && wpName === "") {
            document.getElementById("mpID").value = "";
            return;
        }

        if (inputType === "id") {
            requestData = {
                wpID: wpID
            };
        } else {
            requestData = {
                wpName: wpName
            };
        }

        fetch("http://localhost/Cs/backend/exPlanManagement/getPlanIDName.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify(requestData)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    if (inputType === "id") {
                        document.getElementById("mplanName").classList.remove("text-danger");
                        document.getElementById("mplanName").value = data.planData.wpName || "";
                    } else {
                        document.getElementById("mpID").classList.remove("text-danger");
                        document.getElementById("mpID").value = data.planData.wpID || "";
                    }
                } else {
                    if (inputType === "id") {
                        document.getElementById("mplanName").value = "Not Found";
                        document.getElementById("mplanName").classList.add("text-danger");
                    } else {
                        document.getElementById("mpID").value = "Not Found";
                        document.getElementById("mpID").classList.add("text-danger");
                    }

                    setTimeout(() => {
                        if (inputType === "id") {
                            document.getElementById("mplanName").value = "";
                            document.getElementById("mplanName").classList.remove("text-danger");
                        } else {
                            document.getElementById("mpID").value = "";
                            document.getElementById("mpID").classList.remove("text-danger");
                        }
                    }, 16000000);
                }
            })
            .catch(error => console.error("Error:", error));
    }


    document.addEventListener("DOMContentLoaded", function() {
        const mpIDInput = document.getElementById("mpID");
        const mplanNameInput = document.getElementById("mplanName");

        mpIDInput.addEventListener("input", function() {
            if (mpIDInput.value.trim() !== "") {
                fetchPlanData('id');
            } else {
                mplanNameInput.value = "";
            }
        });

        mplanNameInput.addEventListener("input", function() {
            if (mplanNameInput.value.trim() !== "") {
                fetchPlanData('name');
            } else {
                mpIDInput.value = "";
            }
        });
    });

    //Change the date according to input filed
    function updateEndDate() {
        const sDateInput = document.getElementById("sDate");
        const eDateInput = document.getElementById("eDate");
        const durationInput = document.querySelector('input[name="scheduleDuration"]:checked');

        if (!sDateInput.value || !durationInput) {
            eDateInput.value = "";
            return;
        }

        const startDate = new Date(sDateInput.value);
        const durationValue = durationInput.value;

        let monthsToAdd = 0;
        if (durationValue === "1 month") monthsToAdd = 1;
        else if (durationValue === "3 months") monthsToAdd = 3;
        else if (durationValue === "6 months") monthsToAdd = 6;

        const endDate = new Date(startDate);
        endDate.setMonth(endDate.getMonth() + monthsToAdd);

        // Format as yyyy-mm-dd
        const formattedEndDate = endDate.toISOString().split("T")[0];
        eDateInput.value = formattedEndDate;
    }

    // Attach listeners after DOM is ready
    document.addEventListener("DOMContentLoaded", function() {
        document.getElementById("sDate").addEventListener("change", updateEndDate);

        const durationRadios = document.querySelectorAll('input[name="scheduleDuration"]');
        durationRadios.forEach(radio => {
            radio.addEventListener("change", updateEndDate);
        });
    });

    function showMessage(message, type) {
        const responseMessage = document.getElementById("responseMessage");
        responseMessage.innerHTML = `<div class="alert alert-${type}" role="alert">${message}</div>`;
        setTimeout(() => {
            responseMessage.innerHTML = "";
        }, 4500);
    }

    function goToViewPlans() {
        window.location.href = `adminPanel.php?page=allPlans&&fd=scheduleassign&&memberSID=${memberSID}`;
    }
</script>