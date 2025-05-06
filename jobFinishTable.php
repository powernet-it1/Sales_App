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
      </ul>
      <span class="navbar-text text-white me-3">
        Logged in as: <?php echo htmlspecialchars($username); ?>
      </span>
      <a href="logout.php" class="btn btn-outline-light btn-sm">Logout</a>
    </div>
  </div>
</nav>

  <div class="container my-3">
  <h1 style="margin-left:-10%; margin-top:3%; margin-bottom:3%;">Finished Sales</h1>
    <div class="row">
      <div class="col-md-6">
        <label for="filterByUser" class="form-label">Filter by Last Updated By:</label>
        <select id="filterByUser" class="form-select" onchange="filterTable()">
            <option value="">All</option>
            <option value="Malaka">Malaka</option>
            <option value="sanjana">Sanjana</option>
            <option value="OtherUser">OtherUser</option>
        </select>
      </div>
      <div class="col-md-6">
        <label for="searchCustomer" class="form-label">Search by Customer Name:</label>
        <input type="text" id="searchCustomer" class="form-control" onkeyup="filterTable()" placeholder="Enter customer name...">
      </div>
    </div>
  </div>
  <div class="px-5">
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
              <style>
                #sales-data tr:hover {
                  background-color: #f1f1f1;
                  cursor: pointer;
                }
              </style>
              
            <script>
              window.onload = function () {
                  fetch('jobFinishTable_done.php')
                      .then(response => response.json())
                      .then(data => {
                          const tbody = document.getElementById('sales-data');
                          data.forEach(row => {
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

                              tr.style.cursor = "pointer";
                              tr.addEventListener('click', () => {
                                  window.location.href = `jobFinishData.php?id=${row.id}`;
                              });

                              tbody.appendChild(tr);
                              
                          });
                      })
                      .catch(error => {
                          console.error('Error fetching sales data:', error);
                      });
              }

              function filterTable() {
                const selectedUser = document.getElementById('filterByUser').value.toLowerCase();
                const searchCustomer = document.getElementById('searchCustomer').value.toLowerCase();
                const rows = document.querySelectorAll('#sales-data tr');

                rows.forEach(row => {
                  const lastUpdatedBy = row.querySelector('.last-updated-by')?.textContent.toLowerCase() || "";
                  const customerName = row.querySelector('.customer-name')?.textContent.toLowerCase() || "";

                  const matchesUser = !selectedUser || lastUpdatedBy === selectedUser;
                  const matchesCustomer = !searchCustomer || customerName.includes(searchCustomer);

                  if (matchesUser && matchesCustomer) {
                    row.style.display = "";
                  } else {
                    row.style.display = "none";
                  }
                });
              }

          </script>
          </tbody>
         
    </table>
    </div>
    <div class="container my-3 text-end">
      <a href="salesForm.php" class="btn btn-primary">Add New Sale</a>
    </div>
<footer class="mt-auto d-flex flex-column flex-md-row text-center text-md-start justify-content-between align-items-center py-4 px-4 px-xl-5 bg-primary">
  <div class="text-white mb-3 mb-md-0">
    Copyright © 2025. All rights reserved.
  </div>
  <div class="text-white text-end" id="footer-datetime"></div>
</footer>

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