<!-- Main Content -->
<div class="main-content mt-5 pt-4">
    <div class="container-fluid">
        <!-- Dashboard Heading -->
        <div class="row mb-4">
            <div class="col">
                <h2 class="font-weight-bold">Dashboard</h2>
                <p class="text-muted">Welcome to your admin dashboard.</p>
            </div>
        </div>

        <!-- Cards Row -->
        <div class="row">
            <div class="col-md-3">
                <div class="card text-center">
                    <div class="card-body">
                        <h5>Total Users</h5>
                        <p class="display-4" id="totalUsers">0</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-center">
                    <div class="card-body">
                        <h5>Total Trainers</h5>
                        <p class="display-4" id="totalTrainers">0</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-center">
                    <div class="card-body">
                        <h5>Total Operators</h5>
                        <p class="display-4" id="totalOperators">0</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-center">
                    <div class="card-body">
                        <h5>Total Managers</h5>
                        <p class="display-4" id="totalManagers">0</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Example Chart/Table Row -->
        <div class="row">
            <!-- Chart Placeholder -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Monthly Revenue</h5>
                        <p class="font-weight-bold">Total Income for This Month: Rs.<span id="monthlyIncomeTotal">0</span></p>
                        <!-- Monthly revenue chart -->
                        <canvas id="monthlyRevenueChart" style="height: 300px; border-radius: 6px;"></canvas>
                    </div>
                </div>
            </div>

            <!-- Table -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Recent Orders</h5>
                        <div class="table-responsive">
                            <table class="table table-dark table-striped">
                                <thead>
                                    <tr>
                                        <th>Order ID</th>
                                        <th>User</th>
                                        <th>Date</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>#0012</td>
                                        <td>Alex</td>
                                        <td>2025-02-12</td>
                                        <td>
                                            <span class="badge badge-success">Completed</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>#0013</td>
                                        <td>Jordan</td>
                                        <td>2025-02-14</td>
                                        <td>
                                            <span class="badge badge-warning">Pending</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>#0014</td>
                                        <td>Maria</td>
                                        <td>2025-02-15</td>
                                        <td>
                                            <span class="badge badge-danger">Canceled</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>#0015</td>
                                        <td>Chris</td>
                                        <td>2025-02-16</td>
                                        <td>
                                            <span class="badge badge-success">Completed</span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Fetch data for monthly revenue from the backend
    fetch('http://localhost/Cs/backend/paymentManagement/getMonthlyRevenue.php')
        .then(response => response.json())
        .then(data => {
            let totalIncome = 0;
            let dates = [];
            let amounts = [];

            // Process the data
            data.data.forEach(entry => {

                const paymentDate = new Date(entry.date);
                const formattedDate = paymentDate.toLocaleDateString();

                dates.push(formattedDate);
                amounts.push(entry.amount);
                totalIncome += entry.amount;
            });

            // Update the total income display
            document.getElementById('monthlyIncomeTotal').textContent = totalIncome.toFixed(2);

            // Create the monthly revenue chart
            const ctx = document.getElementById('monthlyRevenueChart').getContext('2d');
            new Chart(ctx, {
                type: 'line', // Change this to 'bar' if you want a bar chart
                data: {
                    labels: dates, // X-axis labels (dates)
                    datasets: [{
                        label: 'Monthly Revenue',
                        data: amounts, // Y-axis data (income)
                        borderColor: '#4caf50',
                        backgroundColor: 'rgba(76, 175, 80, 0.2)',
                        fill: true,
                        tension: 0.4,
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        x: {
                            title: {
                                display: true,
                                text: 'Date',
                            }
                        },
                        y: {
                            title: {
                                display: true,
                                text: 'Revenue (Rs.)',
                            },
                            beginAtZero: true
                        }
                    }
                }
            });
        })
        .catch(error => console.error('Error fetching monthly revenue data:', error));

    // Fetch total users from the backend
    fetch('http://localhost/Cs/backend/userManagement/getTotalUsers.php')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.getElementById('totalUsers').textContent = data.totalUsers;
            } else {
                console.error('Error fetching total users:', data.message);
            }
        })
        .catch(error => console.error('Error fetching total users:', error));
    // Fetch role-wise user counts from the backend
    fetch('http://localhost/cs/backend/userManagement/getAdminCountsByRole.php')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.getElementById('totalUsers').textContent = data.totalUsers;
                document.getElementById('totalManagers').textContent = data.totalManagers;
                document.getElementById('totalOperators').textContent = data.totalOperators;
                document.getElementById('totalTrainers').textContent = data.totalTrainers;
            } else {
                console.error('Error fetching role counts:', data.message);
            }
        })
        .catch(error => console.error('Error fetching role counts:', error));
</script>