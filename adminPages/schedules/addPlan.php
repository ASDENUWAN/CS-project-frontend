<style>
    body {
        background-color: #070707;
        color: #f8f9fa;
        font-family: "Arial", sans-serif;
    }

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

    .container {
        background-color: #000;
        padding: 30px;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(255, 102, 0, 0.5);
        width: 100%;
        max-width: 900px;
    }

    h2 {
        color: #e65c00;
        font-weight: bold;
        text-align: center;
    }

    label {
        font-weight: bold;
        color: #f8f9fa;
    }

    .form-control,
    .custom-select {
        background-color: #1b1b1b;
        color: #f8f9fa;
        border: 1px solid #e65c00;
    }

    .form-control::placeholder,
    .custom-select {
        color: #888;
    }

    .form-control:focus,
    .custom-select:focus {
        background-color: #1b1b1b;
        color: #f8f9fa;
        border-color: #ff6f00;
        box-shadow: 0 0 8px rgba(230, 92, 0, 0.7);
    }

    .card-header {
        background-color: #1b1b1b;
        border-bottom: none;
    }

    .card-header button {
        color: #e65c00;
        font-weight: bold;
        background: none;
        border: none;
        width: 100%;
        text-align: left;
        padding: 0.75rem 1.25rem;
    }

    .card-header button:hover {
        color: #ff6f00;
    }

    .card-body {
        background-color: #121212;
    }

    .selected-exercises {
        margin-top: 30px;
    }

    .exercise-card {
        background-color: #1e1e1e;
        border: 1px solid #e65c00;
        border-radius: 10px;
        padding: 15px;
        margin-bottom: 15px;
        box-shadow: 0 0 8px rgba(255, 102, 0, 0.3);
        position: relative;
    }

    .exercise-card h5 {
        color: #ff6f00;
        font-weight: bold;
        margin-bottom: 10px;
    }

    .close-btn {
        position: absolute;
        top: 8px;
        right: 10px;
        background: transparent;
        border: none;
        font-size: 20px;
        color: #ff4d4d;
        cursor: pointer;
    }

    .btn-sub {
        background-color: #e66a11;
        color: #fff;
        font-weight: bold;
        border-radius: 25px;
        width: 100%;
        margin-top: 1.5rem;
        transition: background-color 0.3s ease;
    }

    .btn-sub:hover {
        background-color: #e65c00;
    }

    #responseMessage .alert {
        margin-top: 20px;
    }
</style>

<div class="main-content-form">
    <div class="container">
        <h2>Create Workout Plan</h2>

        <form id="workoutForm" class="mt-4">
            <!-- Plan Name -->
            <div class="form-group">
                <label for="wpName">Workout Plan Name</label>
                <input type="text" class="form-control" id="wpName" name="wpName" placeholder="Enter plan name" required>
            </div>

            <!-- Accordion Exercise Categories -->
            <h4 class="text-center text-warning mt-4">Select Exercises</h4>
            <div id="exerciseAccordion" class="accordion mb-3" role="tablist"></div>

            <!-- Selected Exercises Section -->
            <div class="selected-exercises">
                <h4 class="text-warning mb-3">Selected Exercises</h4>
                <div id="selectedExercises" class="row"></div>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="btn btn-sub">Submit Workout Plan</button>
        </form>

        <!-- Success/Error Message -->
        <div id="responseMessage" class="mt-3 text-center"></div>
    </div>
</div>

<!-- Bootstrap 4.5.2 Scripts -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const exercises = {
            "Chest": ["Bench Press", "Dumbbell Press", "Chest Press", "Inclined Dumbbell Press", "Machine Flies", "Dumbbell Flies", "Inclined Flies", "Cable Crossover"],
            "Back": ["Barbell Row", "One Arm Dumbbell Row", "Pull-ups", "Bent-over Rows", "Reverse Fly", "Cable Row", "Lat Pull Down", "Cable Pull Down", "Back Press"],
            "Biceps": ["Bicep Curls", "Hammer Curls", "Spider Curl", "Barbell Curl", "Cross Body H Curl", "Preacher Curl", "Cable Curl", "Inclined Curl", "Wrist Curl"],
            "Triceps": ["Extension", "Skull Crushers", "Lying Down Tricep", "Dumbbell Kick Back", "Push Down", "Dips with Weight", "Cable Kick Back"],
            "Shoulders": ["Shoulder Press", "Lateral Raises", "Front Raises", "Upright", "Barbell Shoulder Press", "Front Press", "Shrugs"],
            "Legs": ["Squats", "Leg Press", "Half Squat", "Calfs", "Leg Curl", "Leg Extension", "Stiffed Leg Deadlift", "Lunges", "Walking Lunges"]
        };

        const setOptions = [6, 8, 10, 12, 15, 20];
        const selectedExercises = {};

        const exerciseAccordion = document.getElementById("exerciseAccordion");
        const selectedExercisesDiv = document.getElementById("selectedExercises");

        // Render Accordion
        let index = 0;
        for (const [category, exercisesList] of Object.entries(exercises)) {
            let collapseId = `collapse${index}`;
            exerciseAccordion.innerHTML += `
                <div class="card">
                    <div class="card-header" id="heading${index}">
                        <h5 class="mb-0">
                            <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#${collapseId}" aria-expanded="false" aria-controls="${collapseId}">
                                ${category}
                            </button>
                        </h5>
                    </div>
                    <div id="${collapseId}" class="collapse" aria-labelledby="heading${index}" data-parent="#exerciseAccordion">
                        <div class="card-body">
                            ${exercisesList.map(ex => `
                            <div class="form-check mb-2">
                                <input class="form-check-input exercise-checkbox" type="checkbox" id="${ex.replace(/\s/g, '')}" data-name="${ex}" data-category="${category}">
                                <label class="form-check-label" for="${ex.replace(/\s/g, '')}">${ex}</label>
                            </div>`).join('')}
                        </div>
                    </div>
                </div>
                `;
            index++;
        }

        document.addEventListener('change', (e) => {
            if (e.target.classList.contains('exercise-checkbox')) {
                const exName = e.target.getAttribute('data-name');
                const exType = e.target.getAttribute('data-category');
                const exId = e.target.id;

                if (e.target.checked) {
                    addSelectedExercise(exId, exName, exType);
                } else {
                    document.getElementById(`card-${exId}`).remove();
                    delete selectedExercises[exId];
                }
            }
        });

        function addSelectedExercise(id, name, type) {
            if (selectedExercises[id]) return;

            selectedExercises[id] = {
                exName: name,
                exType: type
            };

            const card = document.createElement('div');
            card.className = 'col-md-6';
            card.id = `card-${id}`;
            card.innerHTML = `
                    <div class="exercise-card">
                        <button type="button" class="close-btn" onclick="removeExercise('${id}')">&times;</button>
                        <h5>${name} (${type})</h5>
                        ${[1, 2, 3, 4].map(i => `
                            <div class="form-group">
                                <label>Set ${i}</label>
                                <select class="custom-select set-select" id="set${i}-${id}" onchange="validateSets('${id}')">
                                    <option value="">--</option>
                                    ${setOptions.map(value => `<option value="${value}">${value}</option>`).join('')}
                                </select>
                            </div>`).join('')}
                    </div>
                `;
            selectedExercisesDiv.appendChild(card);
        }

        window.removeExercise = function(id) {
            document.getElementById(`card-${id}`).remove();
            document.getElementById(id).checked = false;
            delete selectedExercises[id];
        }

        window.validateSets = function(id) {
            const set1 = document.getElementById(`set1-${id}`).value;
            const set2 = document.getElementById(`set2-${id}`).value;
            const set3 = document.getElementById(`set3-${id}`).value;
            const set4 = document.getElementById(`set4-${id}`).value;

            if (!set1 && (set2 || set3 || set4)) {
                alert("Fill Set 1 first before filling Set 2, 3, or 4!");
                document.getElementById(`set2-${id}`).value = "";
                document.getElementById(`set3-${id}`).value = "";
                document.getElementById(`set4-${id}`).value = "";
            }
            if (set2 && !set1) document.getElementById(`set2-${id}`).value = "";
            if (set3 && !set2) document.getElementById(`set3-${id}`).value = "";
            if (set4 && !set3) document.getElementById(`set4-${id}`).value = "";
        }

        document.getElementById("workoutForm").addEventListener("submit", async function(e) {
            e.preventDefault();

            const wpName = document.getElementById("wpName").value.trim();
            if (!wpName) {
                showMessage("Please enter a workout plan name.", "danger");
                return;
            }

            const exercisesList = [];
            Object.keys(selectedExercises).forEach(id => {
                const set1 = parseInt(document.getElementById(`set1-${id}`).value) || 0;
                const set2 = parseInt(document.getElementById(`set2-${id}`).value) || 0;
                const set3 = parseInt(document.getElementById(`set3-${id}`).value) || 0;
                const set4 = parseInt(document.getElementById(`set4-${id}`).value) || 0;

                if (set1) {
                    exercisesList.push({
                        exName: selectedExercises[id].exName,
                        exType: selectedExercises[id].exType,
                        s1: set1,
                        s2: set2,
                        s3: set3,
                        s4: set4
                    });
                }
            });

            if (exercisesList.length === 0) {
                showMessage("Please select and fill at least one exercise properly.", "danger");
                return;
            }

            try {
                const response = await fetch("http://localhost/cs/backend/exPlanManagement/addPlan.php", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json"
                    },
                    body: JSON.stringify({
                        wpName,
                        exercises: exercisesList
                    })
                });

                const result = await response.json();
                showMessage(result.message, result.success ? "success" : "danger");

                if (result.success) {
                    document.getElementById("workoutForm").reset();
                    selectedExercisesDiv.innerHTML = '';
                    window.location.href = "adminPanel.php?page=allPlans&&fd=schedules";

                }
            } catch (error) {
                console.error(error);
                showMessage("An unexpected error occurred.", "danger");
            }
        });

        function showMessage(message, type) {
            const responseMessage = document.getElementById("responseMessage");
            responseMessage.innerHTML = `<div class="alert alert-${type}" role="alert">${message}</div>`;
            setTimeout(() => {
                responseMessage.innerHTML = "";
            }, 2500);
        }
    });
</script>

</body>

</html>