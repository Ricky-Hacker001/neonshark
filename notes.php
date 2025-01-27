<?php
// Database Connection
$host = 'localhost'; // Update with your host
$username = 'root'; // Update with your database username
$password = ''; // Update with your database password
$dbname = 'college_notes';

$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch colleges from the database
$sql = "SELECT college_id, college_name FROM colleges";
$result = $conn->query($sql);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notes</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/styles.css">
    <style>
    </style>
</head>
<body>
<?php include('includes/navbar.php'); ?>
    <div class="container">
        <h1 class="text-center mb-4">List of Colleges</h1>
        <div class="row pt-4">
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '
                        <div class="col-md-4 col-sm-6 mb-4">
                            <div class="card college-card">
                                <div class="card-body">
                                    <h2 class="card-title">' . htmlspecialchars($row['college_name']) . '</h2>
                                    <a href="college-notes.php?college_id=' . $row['college_id'] . '" class="btn btn-primary">View Departments</a>
                                </div>
                            </div>
                        </div>
                    ';
                }
            } else {
                echo '<p class="text-center">No colleges found.</p>';
            }
            ?>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
