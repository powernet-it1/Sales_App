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
    <title>Supplier Table</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel='stylesheet' type='text/css' media='screen' href='css/table.css'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body class="d-flex flex-column min-vh-100">
<?php
$username = $_SESSION['username'] ?? 'Guest';
?>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
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
        <li class="nav-item">
          <a class="nav-link active" href="supplierTable.php">Suppliers</a>
        </li>
      </ul>
      <span class="navbar-text text-white me-3">
        Logged in as: <?php echo htmlspecialchars($username); ?>
      </span>
      <a href="logout.php" class="btn btn-outline-light btn-sm">Logout</a>
    </div>
  </div>
</nav>

<div class="container my-3">
  <h1 class="ps-3 pt-3" style="margin-left:-5%; margin-top:3%; margin-bottom:3%;">Supplier List</h1>
  <div class="row">
    <div class="col-md-6">
      <label for="filterBySupplier" class="form-label">Filter by Category:</label>
      <select id="filterBySupplier" class="form-select" onchange="filterTable()">
        <option value="">All</option>
        <option value="Computers & Accessories">Computers & Accessories</option>
        <option value="Electrical Items">Electrical Items</option>
        <option value="Network Items">Network Accessories</option>
        <option value="Cables">Cables</option>
      </select>
    </div>
    <div class="col-md-6">
      <label for="searchSupplier" class="form-label">Search by Supplier Name:</label>
      <input type="text" id="searchSupplier" class="form-control" onkeyup="filterTable()" placeholder="Enter supplier name...">
    </div>
  </div>
</div>

<div class="px-5">
  <div class="table-responsive">
    <table class="table table-bordered">
      <thead>
        <tr style="text-align: center;">
          <th scope="col">Supplier</th>
          <th scope="col">Location</th>
          <th scope="col">Category</th>
          <th scope="col">Email</th>
          <th scope="col">Contact No</th>
        </tr>
      </thead>
      <tbody id="supplier-data">
        <style>
          #supplier-data tr:hover {
            background-color: #f1f1f1;
            cursor: pointer;
          }
        </style>
      </tbody>
    </table>
  </div>
</div>

<div class="container my-3 text-end">
  <a href="supplierRegister.php" class="btn btn-primary">Add New Supplier</a>
</div>

<footer class="mt-auto d-flex flex-column flex-md-row text-center text-md-start justify-content-between align-items-center py-4 px-4 px-xl-5 bg-primary">
  <div class="text-white mb-3 mb-md-0">
    Copyright © 2025. All rights reserved.
  </div>
  <div class="text-white text-end" id="footer-datetime"></div>
</footer>

<script>
  window.onload = function () {
    fetch('supplierTable_done.php')
      .then(response => response.json())
      .then(data => {
        const tbody = document.getElementById('supplier-data');
        data.forEach(row => {
          const tr = document.createElement('tr');
          tr.style.textAlign = "center";
          tr.innerHTML = `
            <td class="supplier-name">${row.supname}</td>
            <td>${row.location}</td>
            <td class="category">${row.category}</td>
            <td>${row.email}</td>
            <td>${row.contactNo}</td>
          `;
          tr.style.cursor = "pointer";
          tr.addEventListener('click', () => {
            window.location.href = `supplierView.php?id=${row.id}`;
          });
          tbody.appendChild(tr);
        });
      })
      .catch(error => {
        console.error('Error fetching supplier data:', error);
      });
  };

  function filterTable() {
    const selectedCategory = document.getElementById('filterBySupplier').value.toLowerCase();
    const searchSupplier = document.getElementById('searchSupplier').value.toLowerCase();
    const rows = document.querySelectorAll('#supplier-data tr');

    rows.forEach(row => {
      const category = row.querySelector('.category')?.textContent.toLowerCase() || "";
      const supplierName = row.querySelector('.supplier-name')?.textContent.toLowerCase() || "";

      const matchesCategory = !selectedCategory || category === selectedCategory;
      const matchesSupplier = !searchSupplier || supplierName.includes(searchSupplier);

      if (matchesCategory && matchesSupplier) {
        row.style.display = "";
      } else {
        row.style.display = "none";
      }
    });
  }

  function getFormattedDate() {
    const date = new Date();
    const day = date.getDate();
    const month = date.toLocaleString('default', { month: 'long' });
    const year = date.getFullYear();

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
    return date.toLocaleTimeString();
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
