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

    .table-container {
        overflow-x: auto;
        width: 100%;
    }

    table {
        width: 100%;
        margin-top: 20px;
    }

    table thead th {
        background-color: #1e1e1e;
        color: #e66a11;
        border-color: #444;
        text-align: center;
    }

    table tbody td {
        color: #f8f9fa;
        vertical-align: middle;
        text-align: center;
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

    #planNotFound .alert {
        margin-top: 10px;
    }
</style>

<div class="main-content-table">
    <div class="container mt-5">

        <!-- Title -->
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="text-center">Workout Plan Details</h2>
        </div>

        <!-- Not Found Message -->
        <div id="planNotFound" class="alert alert-warning mt-4 text-center" style="display: none;">
            Workout Plan not found!
        </div>

        <!-- Plan Details Content -->
        <div id="planDetails" style="display: none;">
            <div class="bg-dark p-4 rounded mb-4 mt-4 w-100">
                <p><strong>ID:</strong> <span id="planID"></span></p>
                <p><strong>Name:</strong> <span id="planName"></span></p>
            </div>

            <!-- Exercise Details Tables -->
            <div id="exerciseDetails" class="w-100"></div>

            <div class="mt-4 d-flex justify-content-center flex-wrap">
                <button id="backBtn" class="btn btn-secondary mx-3 my-2">
                    <i class="bi bi-arrow-left"></i> Back to Plans
                </button>
            </div>

        </div>

    </div>
</div>

<script>
    const params = new URLSearchParams(window.location.search);
    const wpID = params.get('wpID');

    const planDetailsDiv = document.getElementById('planDetails');
    const planNotFoundDiv = document.getElementById('planNotFound');
    const planIDSpan = document.getElementById('planID');
    const planNameSpan = document.getElementById('planName');
    const exerciseDetailsDiv = document.getElementById('exerciseDetails');
    const editBtn = document.getElementById('editBtn');
    const deleteBtn = document.getElementById('deleteBtn');
    const backBtn = document.getElementById('backBtn');

    if (!wpID) {
        planNotFoundDiv.innerText = "No workout plan ID provided!";
        planNotFoundDiv.style.display = 'block';
    } else {
        fetchPlanDetails(wpID);
    }

    async function fetchPlanDetails(wpID) {
        try {
            const response = await fetch('http://localhost/cs/backend/exPlanManagement/getPlan.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    wpID
                })
            });

            const result = await response.json();

            if (!result.success) {
                planNotFoundDiv.innerText = result.message || 'Workout Plan not found!';
                planNotFoundDiv.style.display = 'block';
                return;
            }

            const plan = result.workout_plan;
            planIDSpan.textContent = plan.wpID;
            planNameSpan.textContent = plan.wpName;

            // Group exercises by exType
            const exerciseGroups = {};
            result.exercises.forEach(ex => {
                if (!exerciseGroups[ex.exType]) exerciseGroups[ex.exType] = [];
                exerciseGroups[ex.exType].push(ex);
            });

            exerciseDetailsDiv.innerHTML = '';

            for (const [exType, exercises] of Object.entries(exerciseGroups)) {
                const tableHtml = `
          <h4 class="mt-5 text-center text-warning">${exType}</h4>
          <div class="table-container">
            <table class="table table-bordered table-striped table-dark mt-3">
              <thead>
                <tr>
                  <th>Exercise Name</th>
                  <th>Set 1</th>
                  <th>Set 2</th>
                  <th>Set 3</th>
                  <th>Set 4</th>
                </tr>
              </thead>
              <tbody>
                ${exercises.map(ex => `
                  <tr>
                    <td>${ex.exName}</td>
                    <td>${ex.s1}</td>
                    <td>${ex.s2}</td>
                    <td>${ex.s3}</td>
                    <td>${ex.s4}</td>
                  </tr>
                `).join('')}
              </tbody>
            </table>
          </div>
        `;
                exerciseDetailsDiv.innerHTML += tableHtml;
            }

            planDetailsDiv.style.display = 'block';

        } catch (error) {
            console.error(error);
            planNotFoundDiv.innerText = "Error loading workout plan details.";
            planNotFoundDiv.style.display = 'block';
        }
    }


    backBtn.addEventListener('click', () => {
        window.location.href = 'adminPanel.php?page=allPlans&&fd=scheduleassign';
    });
</script>

<!-- Bootstrap Icons -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">