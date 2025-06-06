<?php 



?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Library Admin Panel</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      display: flex;
      min-height: 100vh;
    }
    .sidebar {
      width: 250px;
      background-color: #343a40;
      color: white;
    }
    .sidebar a {
      color: white;
      text-decoration: none;
      display: block;
      padding: 15px;
    }
    .sidebar a:hover {
      background-color: #495057;
    }
    .main {
      flex-grow: 1;
      padding: 20px;
    }
    .table-responsive {
      max-height: 500px;
    }
  </style>
</head>
<body>

  <!-- Sidebar -->
  <div class="sidebar p-3">
    <h4 class="text-center mb-4">Admin Panel</h4>
    <a href="<?php header("Location: index.php") ?>">Logout</a>
  </div>

  <!-- Main content -->
  <div class="main">
    <h2>Borrow Records</h2>
    <div class="table-responsive mt-4">
      <table class="table table-bordered table-striped">
        <thead class="table-dark">
          <tr>
            <th>Student Name</th>
            <th>Book Title</th>
            <th>Borrowed Date</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <!-- Replace these rows with PHP or database-generated rows -->
          <tr>
            <td>Jane Doe</td>
            <td>To Kill a Mockingbird</td>
            <td>2025-06-04</td>
            <td>
              <form action="delete_record.php" method="POST" onsubmit="return confirm('Are you sure you want to delete this record?');">
                <input type="hidden" name="record_id" value="1"> <!-- Replace with real ID -->
                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
              </form>
            </td>
          </tr>
          <tr>
            <td>John Smith</td>
            <td>1984</td>
            <td>2025-06-02</td>
            <td>
              <form action="delete_record.php" method="POST" onsubmit="return confirm('Are you sure you want to delete this record?');">
                <input type="hidden" name="record_id" value="2"> <!-- Replace with real ID -->
                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
              </form>
            </td>
          </tr>
          <!-- Example rows end -->
        </tbody>
      </table>
    </div>
  </div>

</body>
</html>
