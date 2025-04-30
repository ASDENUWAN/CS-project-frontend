<!-- (Same Styles as Before) -->
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

    #memberTable {
        width: 100%;
        margin-top: 20px;
        cursor: pointer;
    }

    #memberTable thead th {
        background-color: #1e1e1e;
        color: #e66a11;
        border-color: #444;
    }

    #memberTable tbody td {
        color: #f8f9fa;
        vertical-align: middle;
    }

    .table-container {
        overflow-x: auto;
        width: 100%;
    }

    #responseMessage .alert {
        margin-top: 10px;
    }

    .search-bar {
        width: 100%;
        max-width: 400px;
        margin: 20px auto 0;
    }

    .search-bar input {
        width: 100%;
        padding: 10px;
        border-radius: 8px;
        border: 1px solid #ccc;
    }
</style>

<div class="main-content-table">
    <div class="container mt-5">
        <div class="d-flex flex-column align-items-center">
            <h2 class="text-center">Members List</h2>
            <div class="search-bar">
                <input type="text" id="searchInput" placeholder="Search by Member ID or Name..." onkeyup="filterMembers()" />
            </div>
        </div>

        <div id="responseMessage" class="mt-3 text-center"></div>

        <table id="memberTable" class="table table-bordered table-striped mt-4">
            <thead class="table-light">
                <tr class="text-center">
                    <th>Member ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Mobile</th>
                    <th>Registration Date</th>
                    <th>Remove</th>
                </tr>
            </thead>
            <tbody id="memberTableBody">
                <!-- Members will be dynamically inserted here -->
            </tbody>
        </table>
    </div>
</div>

<!-- Modal for Member Details -->
<div class="modal fade" id="memberDetailsModal" tabindex="-1" role="dialog" aria-labelledby="memberDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content" style="background-color: #1e1e1e; color: #f8f9fa;">
            <div class="modal-header">
                <h5 class="modal-title" id="memberDetailsModalLabel">Member Details</h5>
                <button type="button" class="close btn btn-danger" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="memberDetailsBody">
                <!-- Member details will be loaded here -->
            </div>
        </div>
    </div>
</div>

<script>
    let membersData = []; // Store all members globally

    async function fetchMembers() {
        try {
            const response = await fetch("http://localhost/cs/backend/userManagement/getAllMembers.php");
            const result = await response.json();

            if (result.success) {
                membersData = result.data;
                populateMemberTable(membersData);
            } else {
                showMessage(result.message, "warning");
            }
        } catch (error) {
            console.error("Error fetching members:", error);
            showMessage("Failed to fetch member data.", "danger");
        }
    }

    function populateMemberTable(members) {
        const tableBody = document.getElementById("memberTableBody");
        tableBody.innerHTML = ""; // Clear old data

        members.forEach(member => {
            const row = document.createElement("tr");
            row.classList.add("text-center");
            row.innerHTML = `
                <td>${member.memID}</td>
                <td>${member.memName}</td>
                <td>${member.mail}</td>
                <td>${member.mobile}</td>
                <td>${member.regDate}</td>
                <td>
    <button class="btn btn-danger btn-sm" onclick="event.stopPropagation(); deleteMember(${member.memID})">
      <i class="bi bi-trash-fill"></i> Remove
    </button>
  </td>
                
            `;

            // Add click event to open modal
            row.addEventListener("click", () => openMemberModal(member));

            tableBody.appendChild(row);
        });
    }
    async function deleteMember(memID) {
        if (!confirm("Are you sure you want to delete this member?")) return;

        try {
            const response = await fetch("http://localhost/cs/backend/userManagement/removeMember.php", {
                method: "DELETE",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify({
                    memID
                })
            });

            const result = await response.json();
            if (result.success) {
                showMessage(result.message, "success");
                fetchMembers(); // Refresh table
            } else {
                showMessage(result.message, "danger");
            }
        } catch (error) {
            console.error("Error deleting member:", error);
            showMessage("Error deleting member.", "danger");
        }
    }

    function openMemberModal(member) {
        const modalBody = document.getElementById("memberDetailsBody");
        modalBody.innerHTML = `
            <div class="row">
                <div class="col-md-6 mb-3"><strong>Member ID:</strong> ${member.memID}</div>
                <div class="col-md-6 mb-3"><strong>Name:</strong> ${member.memName}</div>
                <div class="col-md-6 mb-3"><strong>NIC:</strong> ${member.memNIC}</div>
                <div class="col-md-6 mb-3"><strong>Email:</strong> ${member.mail}</div>
                <div class="col-md-6 mb-3"><strong>Mobile:</strong> ${member.mobile}</div>
                <div class="col-md-6 mb-3"><strong>Age:</strong> ${member.age}</div>
                <div class="col-md-6 mb-3"><strong>Gender:</strong> ${member.gender}</div>
                <div class="col-md-6 mb-3"><strong>Height:</strong> ${member.height} cm</div>
                <div class="col-md-6 mb-3"><strong>Weight:</strong> ${member.weight} kg</div>
                <div class="col-md-6 mb-3"><strong>Address:</strong> ${member.address}</div>
                <div class="col-md-6 mb-3"><strong>Registration Date:</strong> ${member.regDate}</div>
            </div>
        `;

        // Show modal
        $('#memberDetailsModal').modal('show');
    }

    function filterMembers() {
        const searchTerm = document.getElementById("searchInput").value.toLowerCase();

        const filtered = membersData.filter(member =>
            member.memID.toLowerCase().includes(searchTerm) ||
            member.memName.toLowerCase().includes(searchTerm)
        );

        populateMemberTable(filtered);
    }

    function showMessage(message, type) {
        const responseMessage = document.getElementById("responseMessage");
        responseMessage.innerHTML = `<div class="alert alert-${type}" role="alert">${message}</div>`;
        setTimeout(() => {
            responseMessage.innerHTML = "";
        }, 800);
    }

    // Load members when page loads
    fetchMembers();
</script>

<!-- Bootstrap 4 Modal dependencies -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>