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

  body {
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

  .main-content-form .form-control,
  .main-content-form .form-select {
    background-color: #1b1b1b;
    color: #f8f9fa;
    border: 1px solid #e65c00;
  }

  .main-content-form .form-control::placeholder {
    color: #888;
  }

  .main-content-form .form-control:focus,
  .main-content-form .form-select:focus {
    background-color: #1b1b1b;
    color: #f8f9fa;
    border-color: #ff6f00;
    box-shadow: 0 0 8px rgba(230, 92, 0, 0.7);
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

  /* Beautiful Select Field Styling */
  .main-content-form select.form-select {
    background-color: #1b1b1b;
    color: #f8f9fa;
    border: 1px solid #e65c00;
    padding: 10px 10px;
    border-radius: 8px;
    appearance: none;
    background-position: right 10px center;
    background-size: 18px 18px;
    transition: border-color 0.3s ease, box-shadow 0.3s ease;
  }

  .main-content-form select.form-select:focus {
    border-color: #ff6f00;
    box-shadow: 0 0 8px rgba(230, 92, 0, 0.7);
    background-color: #1b1b1b;
    color: #f8f9fa;
  }
</style>

<div class="main-content-form">
  <div class="container">
    <h2 class="text-center mb-4">Add Diet & Meals</h2>

    <form id="dietForm" novalidate>
      <!-- Diet Name -->
      <div class="mb-3">
        <label for="dietName" class="form-label">Diet Name</label>
        <input type="text" class="form-control" id="dietName" placeholder="Enter diet name" required>
        <div class="invalid-feedback">
          Please enter a diet name.
        </div>
      </div>

      <!-- Diet Type (Dropdown) -->
      <div class="mb-3">
        <label for="dietType" class="form-label">Diet Type</label>
        <select class="form-select" id="dietType" required>
          <option value="">Select Diet Type</option>
          <option value="Bulking">Bulking</option>
          <option value="Cutting">Cutting</option>
          <option value="Vegan">Vegan</option>
        </select>
        <div class="invalid-feedback">
          Please select a diet type.
        </div>
      </div>

      <!-- Meal Entries -->
      <h5 class="mb-3" style="color:#e65c00;">Meals</h5>

      <div class="mb-3">
        <label class="form-label">Breakfast</label>
        <textarea class="form-control" id="breakfast" rows="2" placeholder="Enter food items for breakfast"></textarea>
      </div>

      <div class="mb-3">
        <label class="form-label">Lunch</label>
        <textarea class="form-control" id="lunch" rows="2" placeholder="Enter food items for lunch"></textarea>
      </div>

      <div class="mb-3">
        <label class="form-label">Dinner</label>
        <textarea class="form-control" id="dinner" rows="2" placeholder="Enter food items for dinner"></textarea>
      </div>

      <!-- Submit Button -->
      <button type="submit" class="btn btn-sub">Submit</button>
    </form>

    <!-- Response Message -->
    <div id="responseMessage" class="mt-4"></div>
  </div>
</div>

<script>
  // Fetch all diets when the page loads
  window.addEventListener("DOMContentLoaded", async () => {
    try {
      const response = await fetch("http://localhost/cs/backend/DietPlanManagement/getalldiet.php");
      const data = await response.json();
      if (data.success) {
        allDiets = data.diets;
      } else {
        console.error("Failed to fetch diets");
      }
    } catch (error) {
      console.error("Error fetching diets:", error);
    }
  });

  // Listen for changes in the dietName input field
  document.getElementById("dietName").addEventListener("input", function() {
    const enteredName = this.value.trim().toLowerCase();

    const matchedDiet = allDiets.find(diet => diet.dietName.toLowerCase() === enteredName);

    if (matchedDiet) {
      document.getElementById("dietType").value = matchedDiet.dietType || "";
      document.getElementById("breakfast").value = matchedDiet.Breakfast ? matchedDiet.Breakfast.replace(/,/g, ', ') : "";
      document.getElementById("lunch").value = matchedDiet.Lunch ? matchedDiet.Lunch.replace(/,/g, ', ') : "";
      document.getElementById("dinner").value = matchedDiet.Dinner ? matchedDiet.Dinner.replace(/,/g, ', ') : "";
    } else {
      document.getElementById("dietType").value = "";
      document.getElementById("breakfast").value = "";
      document.getElementById("lunch").value = "";
      document.getElementById("dinner").value = "";
    }
  });

  document.getElementById("dietForm").addEventListener("submit", async function(e) {
    e.preventDefault();

    const form = e.target;

    if (!form.checkValidity()) {
      e.stopPropagation();
      form.classList.add('was-validated');
      return;
    }

    let dietName = document.getElementById("dietName").value.trim();
    let dietType = document.getElementById("dietType").value.trim();

    let meals = [{
        mealType: "Breakfast",
        foodItems: document.getElementById("breakfast").value.trim()
      },
      {
        mealType: "Lunch",
        foodItems: document.getElementById("lunch").value.trim()
      },
      {
        mealType: "Dinner",
        foodItems: document.getElementById("dinner").value.trim()
      }
    ];

    if (meals.every(meal => meal.foodItems === "")) {
      showMessage("Please enter at least one meal.", "danger");
      return;
    }

    let dietData = {
      dietName: dietName,
      dietType: dietType,
      meals: meals.filter(meal => meal.foodItems !== "")
    };

    try {
      const response = await fetch("http://localhost/cs/backend/DietPlanManagement/addDiet.php", {
        method: "POST",
        headers: {
          "Content-Type": "application/json"
        },
        body: JSON.stringify(dietData),
      });

      const result = await response.json();

      if (result.success) {
        showMessage(result.message, "success");
        form.reset();
        form.classList.remove('was-validated');
        window.location.href = "adminPanel.php?page=displayDietPlans&&fd=dietplans"
      } else {
        showMessage(result.message, "danger");
      }
    } catch (error) {
      console.error("Error:", error);
      showMessage("An error occurred. Please try again.", "danger");
    }
  });

  function showMessage(message, type) {
    const responseMessage = document.getElementById("responseMessage");
    responseMessage.innerHTML = `<div class="alert alert-${type}" role="alert">${message}</div>`;
    setTimeout(() => {
      responseMessage.innerHTML = "";
    }, 4500);
  }
</script>