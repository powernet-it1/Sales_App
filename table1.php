<?php
session_start();

$timeout_duration = 600;

if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY']) > $timeout_duration) {
    session_unset();     
    session_destroy();   
    header("Location: index.php?expired=true");
    exit();
}

$_SESSION['LAST_ACTIVITY'] = time(); 
?>


<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Page Title</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel='stylesheet' type='text/css' media='screen' href='css/table.css'>
     <style>
    #sales-data tr:hover {
      background-color: #f1f1f1;
      cursor: pointer;
    }
  </style>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous"><link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
</head>
<body class="d-flex flex-column min-vh-100">
  <!-- navbar section  -->
<?php
$username = $_SESSION['username'] ?? 'Guest';
?>
<nav style="background-color:#320303;" class="navbar navbar-expand-lg navbar-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="#"> Powernet</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
      aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" href="table1.php">Ongoing Sales</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" href="jobFinishTable.php">Finished Sales</a>
        </li>
        <!-- <li class="nav-item">
          <a class="nav-link active" href="supplierTable.php">Suppliers</a>
        </li> -->
      </ul>
      <span class="navbar-text text-white me-3">
        Logged in as: <?php echo htmlspecialchars($username); ?>
      </span>
      <a href="logout.php" class="btn btn-outline-light btn-sm">Logout</a>
    </div>
  </div>
</nav>

  <div class="container my-3">
  <h1  class="ps-3 pt-3" style="margin-left:-5%; margin-top:3%; margin-bottom:3%;">Ongoing Sales</h1>
    <div class="row">
  <!-- Left side: Filter and Search -->
  <div class="col-md-4">
      <?php if ($_SESSION['username'] === 'Wimal') : ?>
        <label for="filterByUser" class="form-label">Filter by Last Updated By:</label>
        <select id="filterByUser" class="form-select" onchange="filterTable()">
            <option value="">All</option>
            <option value="Malaka">Malaka</option>
            <option value="sanjana">Sanjana</option>
            <option value="Chinthaka">Chinthaka</option>
            <option value="Lakmal">Lakmal</option>
        </select>
      <?php endif; ?>
    </div>

    <div class="col-md-4">
      <label for="searchCustomer" class="form-label">Search by Customer Name:</label>
      <input type="text" id="searchCustomer" class="form-control" onkeyup="filterTable()" placeholder="Enter customer name...">
    </div>

  <!-- Right side: Chart -->
  <div class="col-md-4">
    <h6 class="text-center">My Sales Status Summary</h6>
    <canvas id="statusChart" height="150"></canvas>
  </div>
</div>

  <div class="px-5">
    <div class="table-responsive">
    <table class="table table-bordered">
            <thead>
              <tr style="text-align: center;">
                <th scope="col">Customer</th>
                <th scope="col">Location</th>
                <!-- <th scope="col">Description</th> -->
                <th scope="col">Contact Person</th>
                <!-- <th scope="col">Contact Person TeleNo</th>
                <th scope="col">Contact Person Email</th>
                <th scope="col">Expected Cost</th>
                <th scope="col">Profit</th>
                <th scope="col">Estimated Finish Date</th> -->
                <th scope="col">Status</th>
                <th scope="col">Sales Person</th>
                <th scope="col">Last Updated Date</th>
          
              </tr>
            </thead>
            <tbody id="sales-data">
              
            <script>
let currentPage = 1;
const perPage = 5;

function loadSalesData() {
  const customer = document.getElementById('searchCustomer')?.value || '';
  const filterByUser = document.getElementById('filterByUser')?.value || '';

  const url = `table.php?page=${currentPage}&perPage=${perPage}&customer=${encodeURIComponent(customer)}&user=${encodeURIComponent(filterByUser)}`;

  fetch(url)
    .then(response => response.json())
    .then(res => {
      const tbody = document.getElementById('sales-data');
      tbody.innerHTML = '';

      res.data.forEach(row => {
        const tr = document.createElement('tr');
        tr.style.textAlign = "center";
        tr.innerHTML = `
          <td class="customer-name">${row.cusname}</td>
          <td>${row.location}</td>
          <td>${row.contactPerson}</td>
          <td>${row.sts}</td>
          <td class="last-updated-by">${row.salesPerson}</td>
          <td>${row.lastUpdatedDate}</td>
        `;
        tr.onclick = () => window.location.href = `salesFormUpdate.php?id=${row.id}`;
        tbody.appendChild(tr);
      });

      renderPagination(res.total);
    })
    .catch(err => console.error('Load error:', err));
}

function filterTable() {
  currentPage = 1;
  loadSalesData();
}

function renderPagination(totalItems) {
  const pagination = document.getElementById('pagination');
  pagination.innerHTML = '';

  const totalPages = Math.ceil(totalItems / perPage);

  // Previous Button
  const prevBtn = document.createElement('button');
  prevBtn.className = 'btn btn-sm btn-outline-primary mx-1';
  prevBtn.textContent = 'Previous';
  prevBtn.disabled = currentPage === 1;
  prevBtn.onclick = () => {
    if (currentPage > 1) {
      currentPage--;
      loadSalesData();
    }
  };
  pagination.appendChild(prevBtn);

  // Display current page info
  const pageInfo = document.createElement('span');
  pageInfo.className = 'mx-2 align-middle';
  pageInfo.textContent = `Page ${currentPage} of ${totalPages}`;
  pagination.appendChild(pageInfo);

  // Next Button
  const nextBtn = document.createElement('button');
  nextBtn.className = 'btn btn-sm btn-outline-primary mx-1';
  nextBtn.textContent = 'Next';
  nextBtn.disabled = currentPage === totalPages;
  nextBtn.onclick = () => {
    if (currentPage < totalPages) {
      currentPage++;
      loadSalesData();
    }
  };
  pagination.appendChild(nextBtn);
}

document.addEventListener('DOMContentLoaded', () => {
  loadSalesData();
  document.getElementById('searchCustomer')?.addEventListener('keyup', filterTable);
  document.getElementById('filterByUser')?.addEventListener('change', filterTable);
});
</script>

          </tbody>
         
    </table>
   <div id="pagination" class="text-center my-3 d-flex justify-content-center align-items-center"></div>

    </div>
    </div>
            </div>
    <div class="container my-3 text-end">
      <a href="salesForm.php" class="btn btn-primary">Add New Sale</a>
    </div>
<footer style="background-color:#320303" class="mt-auto d-flex flex-column flex-md-row text-center text-md-start justify-content-between align-items-center py-4 px-4 px-xl-5">
  <div class="text-white mb-3 mb-md-0">
    Copyright © 2025. All rights reserved.
  </div>
  <div class="text-white text-end" id="footer-datetime"></div>
</footer>

<script>
let statusChart;

function loadSalesChart(user = '') {
  fetch(`salesStatusStats.php?user=${encodeURIComponent(user)}`)
    .then(response => response.json())
    .then(data => {
      if (data.error) {
        console.error(data.error);
        return;
      }

      const labels = Object.keys(data);
      const counts = Object.values(data);

      const ctx = document.getElementById('statusChart').getContext('2d');

      if (statusChart) {
        statusChart.destroy();
      }

      statusChart = new Chart(ctx, {
        type: 'bar',
        data: {
          labels: labels,
          datasets: [{
            label: 'Sales Count',
            data: counts,
            backgroundColor: [
              '#0d6efd', '#dc3545', '#198754', '#ffc107', '#6f42c1', '#20c997'
            ],
            borderColor: '#fff',
            borderWidth: 1
          }]
        },
        options: {
          responsive: true,
          plugins: {
            title: {
              display: true,
              text: 'Sales Status Distribution'
            },
            legend: {
              position: 'bottom'
            }
          }
        }
      });
    })
    .catch(error => {
      console.error('Failed to load chart data:', error);
    });
}

window.addEventListener('DOMContentLoaded', () => {
  const currentUser = "<?php echo $_SESSION['username']; ?>";
  loadSalesChart(currentUser); // default for all users

  const userFilter = document.getElementById('filterByUser');
  if (userFilter) {
    userFilter.addEventListener('change', () => {
      const selectedUser = userFilter.value || "Wimal"; // default to Wimal if empty
      loadSalesChart(selectedUser);
    });
  }
});
</script>



<script>
  function getFormattedDate() {
    const date = new Date();
    const day = date.getDate();
    const month = date.toLocaleString('default', { month: 'long' });
    const year = date.getFullYear();

    // Get day suffix (st, nd, rd, th)
    const suffix = (d) => {
      if (d > 3 && d < 21) return 'th';
      switch (d % 10) {
        case 1: return 'st';
        case 2: return 'nd';
        case 3: return 'rd';
        default: return 'th';
      }
    };

    return `${day}${suffix(day)} ${month} ${year}`;
  }

  function getFormattedTime() {
    const date = new Date();
    return date.toLocaleTimeString(); // Customize if needed
  }

  function updateFooterDateTime() {
    document.getElementById('footer-datetime').innerHTML =
      `${getFormattedDate()}<br>${getFormattedTime()}`;
  }

  updateFooterDateTime();
  setInterval(updateFooterDateTime, 1000);
</script>



</body>
</html>