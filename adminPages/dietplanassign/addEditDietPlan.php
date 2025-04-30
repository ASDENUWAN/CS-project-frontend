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
        <h2 id="formTitle" class="text-center">Assign Diet Plan</h2>
        <form id="dietPlanForm" class="mt-4 shadow p-4 rounded">
            <input type="hidden" id="dietPlan_number" name="dietPlan_number">

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="memberID" class="form-label">Member ID</label>
                    <input type="text" id="memberID" name="memberID" class="form-control" placeholder="Enter member ID" oninput="fetchMemberData('id')">
                </div>

                <div class="col-md-6 mb-3">
                    <label for="memberNIC" class="form-label">Member NIC</label>
                    <input type="text" id="memberNIC" name="memberNIC" class="form-control" placeholder="Enter NIC" oninput="fetchMemberData('nic')">
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 mb-1">
                    <label for="dietID" class="form-label">Diet ID</label>
                </div>

                <div class="col-md-3 mb-1 text-center d-flex justify-content-center align-items-center">
                    <!-- Link between the two labels -->
                    <a href="adminPanel.php?page=displayDietDetails&&fd=dietplanassign" id="viewDietsLink" class="btn btn-link p-0" style="color: orange;">View Diets</a>
                </div>

                <div class="col-md-5 mb-1">
                    <label for="dietName" class="form-label">Diet Name</label>
                </div>
            </div>

            <div class="row">
                <div class="col-md-5 mb-3">
                    <input type="text" id="dietID" name="dietID" class="form-control" placeholder="Enter diet ID" required>
                </div>

                <div class="col-md-2 mb-3">
                    <!-- Empty column just for spacing -->
                </div>

                <div class="col-md-5 mb-3">
                    <input type="text" id="dietName" name="dietName" class="form-control" placeholder="Enter diet Name" required>
                </div>
            </div>

            <div class="mb-3">
                <label for="startDate" class="form-label">Start Date</label>
                <input type="date" id="startDate" name="startDate" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Time Period</label>
                <div class="d-flex gap-3 flex-wrap-radio">
                    <div class="form-check">
                        <input type="radio" name="dietDuration" value="1 Month" class="form-check-input" id="oneMonth">
                        <label for="oneMonth" class="form-check-label">1 Month</label>
                    </div>
                    <div class="form-check">
                        <input type="radio" name="dietDuration" value="2 Months" class="form-check-input" id="twoMonth">
                        <label for="twoMonth" class="form-check-label">2 Months</label>
                    </div>
                    <div class="form-check">
                        <input type="radio" name="dietDuration" value="3 Months" class="form-check-input" id="threeMonth">
                        <label for="threeMonth" class="form-check-label">3 Months</label>
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <label for="endDate" class="form-label">End Date</label>
                <input type="date" id="endDate" name="endDate" class="form-control" readonly>
            </div>

            <div class="mb-3">
                <label for="dpStatus" class="form-label">Diet Plan Status</label>
                <select id="dpStatus" name="dpStatus" class="form-control custom-select" required>
                    <option value="" disabled selected class="placeholder-option">Choose diet plan status</option>
                    <option value="notStarted">Not Started</option>
                    <option value="active">Active</option>
                    <option value="deactive">Deactive</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="height" class="form-label">Height (cm)</label>
                <input type="number" id="height" name="height" class="form-control" placeholder="Enter height of the member" required min="0" step="0.01">
            </div>

            <div class="mb-3">
                <label for="weightKG" class="form-label">Weight (kg)</label>
                <input type="number" id="weightKG" name="weightKG" class="form-control" placeholder="Enter weight of the member" required min="0" step="0.01">
            </div>


            <button type="submit" class="btn btn-sub w-100">Save Diet Plan</button>
        </form>

        <div id="responseMessage" class="mt-3 text-center"></div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    async function fetchMemberData(inputType) {
        let memberID = document.getElementById("memberID").value.trim();
        let memberNIC = document.getElementById("memberNIC").value.trim();

        let requestData = {};

        // If member ID is cleared, reset the NIC
        if (inputType === "memID" && memberID === "") {
            document.getElementById("memberNIC").value = "";
            return;
        }

        // If member NIC is cleared, reset the ID
        if (inputType === "memNIC" && memberNIC === "") {
            document.getElementById("memberID").value = "";
            return;
        }

        if (inputType === "memID") {
            requestData = {
                memberID: memberID
            };
        } else {
            requestData = {
                memberNIC: memberNIC
            };
        }

        fetch("http://localhost/Cs/backend/userManagement/getMemberIdNicDIET.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify(requestData)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    if (inputType === "memID") {
                        document.getElementById("memberNIC").classList.remove("text-danger");
                        document.getElementById("memberNIC").value = data.memberData.memNIC || "";
                    } else {
                        document.getElementById("memberID").classList.remove("text-danger");
                        document.getElementById("memberID").value = data.memberData.memID || "";
                    }
                } else {
                    if (inputType === "memID") {
                        document.getElementById("memberNIC").value = "Not Found";
                        document.getElementById("memberNIC").classList.add("text-danger");
                    } else {
                        document.getElementById("memberID").value = "Not Found";
                        document.getElementById("memberID").classList.add("text-danger");
                    }

                    // Clear the "Not Found" after some seconds
                    setTimeout(() => {
                        if (inputType === "memID") {
                            document.getElementById("memberNIC").value = "";
                            document.getElementById("memberNIC").classList.remove("text-danger");
                        } else {
                            document.getElementById("memberID").value = "";
                            document.getElementById("memberID").classList.remove("text-danger");
                        }
                    }, 16000000);
                }
            })
            .catch(error => console.error("Error:", error));
    }

    async function fetchDietData(inputTypeD) {
        let dietID = document.getElementById("dietID").value.trim();
        let dietName = document.getElementById("dietName").value.trim();

        let requestDData = {};

        // If diet ID is cleared, reset the diet name
        if (inputTypeD === "dietID" && dietID === "") {
            document.getElementById("dietName").value = "";
            return;
        }

        // If deit name is cleared, reset the diet ID
        if (inputTypeD === "dietName" && dietName === "") {
            document.getElementById("dietID").value = "";
            return;
        }

        if (inputTypeD === "dietID") {
            requestDData = {
                dietID: dietID
            };
        } else {
            requestDData = {
                dietName: dietName
            };
        }

        fetch("http://localhost/cs/backend/dietPlanManagement/getDietIDName.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify(requestDData)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    if (inputTypeD === "dietID") {
                        document.getElementById("dietName").classList.remove("text-danger");
                        document.getElementById("dietName").value = data.dietData.dietName || "";
                    } else {
                        document.getElementById("dietID").classList.remove("text-danger");
                        document.getElementById("dietID").value = data.dietData.dietID || "";
                    }
                } else {
                    if (inputTypeD === "dietID") {
                        document.getElementById("dietName").value = "Not Found";
                        document.getElementById("dietName").classList.add("text-danger");
                    } else {
                        document.getElementById("dietID").value = "Not Found";
                        document.getElementById("dietID").classList.add("text-danger");
                    }

                    // Clear the "Not Found" after some seconds
                    setTimeout(() => {
                        if (inputTypeD === "dietID") {
                            document.getElementById("dietName").value = "";
                            document.getElementById("dietName").classList.remove("text-danger");
                        } else {
                            document.getElementById("dietID").value = "";
                            document.getElementById("dietID").classList.remove("text-danger");
                        }
                    }, 5000);
                }
            })
            .catch(error => console.error("Error:", error));
    }


    document.addEventListener("DOMContentLoaded", async function() {
        if (document.getElementById("formTitle").innerText = "Assign Diet Plan") {
            document.getElementById("memberID").addEventListener("blur", function() {
                fetchMemberData("memID");
            });

            document.getElementById("memberNIC").addEventListener("blur", function() {
                fetchMemberData("memNIC");
            });

            document.getElementById("dietID").addEventListener("blur", function() {
                fetchDietData("dietID");
            });

            document.getElementById("dietName").addEventListener("blur", function() {
                fetchDietData("dietName");
            });
        }

        // Handiling edit mode
        const urlParams = new URLSearchParams(window.location.search);
        const dietPlan_number = urlParams.get("dietPlan_number");

        if (dietPlan_number) {
            document.getElementById("formTitle").innerText = "Edit Diet Plan";
            fetchDietPlanDetails(dietPlan_number);

            //  Disable memberID field in edit mode
            document.getElementById("memberID").setAttribute("readonly", true);
            document.getElementById("memberNIC").setAttribute("readonly", true);
        } else {
            document.getElementById("formTitle").innerText = "Assign Diet Plan";

            //  Ensure memberID field is editable in add mode
            document.getElementById("memberID").removeAttribute("readonly");
            document.getElementById("memberNIC").removeAttribute("readonly");
        }
    });

    async function fetchDietPlanDetails(dietPlan_number) {
        try {
            const response = await fetch("http://localhost/cs/backend/dietAssigningManagement/getDietPlan.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify({
                    dietPlan_number
                }),
            });
            const result = await response.json();

            if (result.success) {
                document.getElementById("dietPlan_number").value = result.dietplan.dietPlan_number;
                document.getElementById("memberID").value = result.dietplan.memberID;
                document.getElementById("dietID").value = result.dietplan.dietID;
                document.getElementById("startDate").value = result.dietplan.startDate;
                document.getElementById("endDate").value = result.dietplan.endDate;
                document.getElementById("dpStatus").value = result.dietplan.dpStatus;
                document.getElementById("height").value = result.dietplan.height;
                document.getElementById("weightKG").value = result.dietplan.weightKG;

                // Fetch and display NIC based on memberID
                fetchMemberNIC(result.dietplan.memberID);

                // Auto fetch and fill diet name
                fetchDietName(result.dietplan.dietID);
            } else {
                showMessage(result.message, "danger");
            }
        } catch (error) {
            console.error("Error fetching diet plan details:", error);
            showMessage("Failed to fetch diet plan details.", "danger");
        }
    }

    async function fetchMemberNIC(memberID) {
        try {
            const response = await fetch("http://localhost/cs/backend/dietPlanManagement/getMemberIdNic.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify({
                    memberID
                }),
            });

            const data = await response.json();
            if (data.success) {
                document.getElementById("memberNIC").value = data.memberData.memNIC || "";
                document.getElementById("memberNIC").setAttribute("readonly", true);
            } else {
                document.getElementById("memberNIC").value = "NIC Not Found";
                document.getElementById("memberNIC").setAttribute("readonly", true);
            }
        } catch (error) {
            console.error("Error fetching member NIC:", error);
        }
    }

    async function fetchDietName(dietID) {
        try {
            const response = await fetch("http://localhost/cs/backend/dietPlanManagement/getDietIDName.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify({
                    dietID
                }),
            });

            const data = await response.json();
            if (data.success) {
                document.getElementById("dietName").value = data.dietData.dietName || "";
                document.getElementById("dietName").setAttribute("readonly", true);
            } else {
                document.getElementById("dietName").value = "Diet Name Not Found";
                document.getElementById("dietName").setAttribute("readonly", true);
            }
        } catch (error) {
            console.error("Error fetching diet name:", error);
        }
    }

    document.getElementById("dietPlanForm").addEventListener("submit", async function(event) {
        event.preventDefault();

        const dietPlan_number = document.getElementById("dietPlan_number").value.trim();
        const memberID = document.getElementById("memberID").value.trim();
        const dietID = document.getElementById("dietID").value.trim();
        const startDate = document.getElementById("startDate").value.trim();
        const endDate = document.getElementById("endDate").value.trim();
        const dpStatus = document.getElementById("dpStatus").value.trim();
        const height = document.getElementById("height").value.trim();
        const weightKG = document.getElementById("weightKG").value.trim();

        if (!memberID || !dietID || !startDate || !endDate || !dpStatus || !height || !weightKG) {
            showMessage("All fields are required.", "danger");
            return;
        }

        const dietPlanData = {
            dietPlan_number,
            memberID,
            dietID,
            startDate,
            endDate,
            dpStatus,
            height,
            weightKG
        };
        const method = dietPlan_number ? "PUT" : "POST";
        const url = dietPlan_number ?
            "http://localhost/cs/backend/dietAssigningManagement/updateDietPlan.php" :
            "http://localhost/cs/backend/dietAssigningManagement/addDietPlan.php";

        try {
            const response = await fetch(url, {
                method,
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify(dietPlanData),
            });

            const result = await response.json();

            if (result.success) {
                showMessage(result.message, "success");
                setTimeout(() => {
                    window.location.href = "adminPanel.php?page=displayDietPlans&&fd=dietplanassign";
                }, 600);
            } else {
                showMessage(result.message, "danger");
            }
        } catch (error) {
            console.error("Error:", error);
            showMessage("An error occurred. Please try again.", "danger");
        }
    });

    document.addEventListener("DOMContentLoaded", function() {
        // Attach event listeners to diet duration radio buttons and start date input
        document.querySelectorAll('input[name="dietDuration"]').forEach(radio => {
            radio.addEventListener("change", function() {
                calculateEndDate();
                updateDietPlanStatus();
            });
        });

        document.getElementById("startDate").addEventListener("change", function() {
            calculateEndDate();
            updateDietPlanStatus();
        });

        document.getElementById("endDate").addEventListener("change", updateDietPlanStatus);

        // If editing existing data, update status once everything is loaded
        setTimeout(() => {
            updateDietPlanStatus();
        }, 2000); // Delay slightly to let form load
    });

    function calculateEndDate() {
        const startDate = document.getElementById("startDate").value;
        const endDateInput = document.getElementById("endDate");

        if (!startDate) {
            endDateInput.value = "";
            return;
        }

        const selectedDuration = document.querySelector('input[name="dietDuration"]:checked');
        if (!selectedDuration) {
            endDateInput.value = "";
            return;
        }

        let monthsToAdd = 0;
        if (selectedDuration.value === "1 Month") {
            monthsToAdd = 1;
        } else if (selectedDuration.value === "2 Months") {
            monthsToAdd = 2;
        } else if (selectedDuration.value === "3 Months") {
            monthsToAdd = 3;
        }

        const date = new Date(startDate);
        date.setMonth(date.getMonth() + monthsToAdd);

        const formattedEndDate = date.toISOString().split("T")[0];
        endDateInput.value = formattedEndDate;

        // After setting end date, update the diet plan status too
        updateDietPlanStatus();
    }

    function updateDietPlanStatus() {
        const startDateValue = document.getElementById("startDate").value;
        const endDateValue = document.getElementById("endDate").value;
        const dpStatusInput = document.getElementById("dpStatus"); // Assuming ID is "dpStatus"

        if (!startDateValue || !endDateValue) {
            dpStatusInput.value = "";
            return;
        }

        const today = new Date();
        today.setHours(0, 0, 0, 0); // Remove time part for accurate comparison

        const startDate = new Date(startDateValue);
        const endDate = new Date(endDateValue);

        if (today < startDate) {
            dpStatusInput.value = "notStarted";
        } else if (today >= startDate && today <= endDate) {
            dpStatusInput.value = "active";
        } else if (today > endDate) {
            dpStatusInput.value = "deactive";
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