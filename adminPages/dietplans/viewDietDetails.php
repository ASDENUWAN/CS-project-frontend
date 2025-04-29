<style>
  body {
    background: linear-gradient(135deg, #0d0d0d 0%, #1a1a1a 100%);
    color: #f1f1f1;
    font-family: "Poppins", sans-serif;
    margin: 0;
    padding: 0;
    min-height: 100vh;
  }

  .main-content {
    margin-left: 240px;
    padding: 20px;
    padding-top: 80px;
    display: flex;
    flex-direction: column;
    align-items: center;
  }

  @media (max-width: 767.98px) {
    .main-content {
      margin-left: 0;
      padding: 80px 15px 20px;
    }
  }

  .container {
    background: #121212;
    padding: 40px 30px;
    border-radius: 15px;
    box-shadow: 0 4px 15px rgba(255, 102, 0, 0.4);
    width: 100%;
    max-width: 700px;
    transition: all 0.3s ease;
  }

  .container:hover {
    box-shadow: 0 6px 20px rgba(255, 102, 0, 0.6);
  }

  h2 {
    color: #ff6a00;
    font-weight: 700;
    text-align: center;
    margin-bottom: 30px;
  }

  .diet-detail {
    margin-bottom: 20px;
  }

  .diet-detail label {
    font-weight: 600;
    color: #bbb;
    font-size: 1rem;
    margin-bottom: 5px;
    display: block;
  }

  .diet-detail p {
    background-color: #1f1f1f;
    padding: 10px 15px;
    border-radius: 8px;
    margin: 0;
    font-size: 1rem;
    color: #f8f9fa;
  }

  .section-title {
    color: #ff6a00;
    font-size: 1.2rem;
    font-weight: 600;
    margin-top: 30px;
    margin-bottom: 15px;
    text-align: center;
  }

  .btn-back {
    background: linear-gradient(135deg, #ff6a00 0%, #e65c00 100%);
    color: #fff;
    font-weight: 600;
    border: none;
    border-radius: 30px;
    width: 100%;
    padding: 12px;
    font-size: 1rem;
    margin-top: 30px;
    transition: background 0.3s ease;
  }

  .btn-back:hover {
    background: linear-gradient(135deg, #e65c00 0%, #cc4c00 100%);
  }
</style>

<div class="main-content">
  <div class="container">
    <h2 id="formTitle">View Diet Plan</h2>

    <div id="dietDetails" class="diet-detail">
      <!-- Diet Name -->
      <div class="mb-3">
        <label for="dietName" class="form-label">Diet Name</label>
        <p id="dietName">Loading...</p>
      </div>

      <!-- Diet Type -->
      <div class="mb-3">
        <label for="dietType" class="form-label">Diet Type</label>
        <p id="dietType">Loading...</p>
      </div>

      <!-- Meal Entries -->
      <div class="section-title">Meals</div>

      <div class="mb-3">
        <label class="form-label">Breakfast</label>
        <p id="breakfast">Loading...</p>
      </div>

      <div class="mb-3">
        <label class="form-label">Lunch</label>
        <p id="lunch">Loading...</p>
      </div>

      <div class="mb-3">
        <label class="form-label">Dinner</label>
        <p id="dinner">Loading...</p>
      </div>

      <button class="btn btn-back" onclick="window.location.href='adminPanel.php?page=displayDietPlans&&fd=dietplans'">Back to Diet Plans</button>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>


<script>
  document.addEventListener("DOMContentLoaded", async function() {
    const urlParams = new URLSearchParams(window.location.search);
    const dietID = urlParams.get("dietID");

    if (dietID) {
      fetchDietDetails(dietID);
    }
  });

  async function fetchDietDetails(dietID) {
    try {
      const response = await fetch("http://localhost/cs/backend/DietPlanManagement/getDietMeal.php", {
        method: "POST",
        headers: {
          "Content-Type": "application/json"
        },
        body: JSON.stringify({
          dietID
        })
      });

      const result = await response.json();

      if (result.success) {
        document.getElementById("dietName").textContent = result.diet.dietName;
        document.getElementById("dietType").textContent = result.diet.dietType;

        // Assuming result.diet.meals is an array of meal objects
        const meals = result.meals;
        if (meals) {
          const breakfast = meals.find(meal => meal.mealType === "Breakfast");
          const lunch = meals.find(meal => meal.mealType === "Lunch");
          const dinner = meals.find(meal => meal.mealType === "Dinner");

          document.getElementById("breakfast").textContent = breakfast ? breakfast.foodItems : 'Not available';
          document.getElementById("lunch").textContent = lunch ? lunch.foodItems : 'Not available';
          document.getElementById("dinner").textContent = dinner ? dinner.foodItems : 'Not available';
        }
      } else {
        showMessage(result.message, "danger");
      }
    } catch (error) {
      console.error("Error fetching diet details:", error);
      showMessage("Failed to fetch diet details.", "danger");
    }
  }

  function showMessage(message, type) {
    const responseMessage = document.getElementById("responseMessage");
    responseMessage.innerHTML = `<div class="alert alert-${type}" role="alert">${message}</div>`;
    setTimeout(() => {
      responseMessage.innerHTML = "";
    }, 4500);
  }
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>