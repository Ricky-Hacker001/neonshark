<?php
// Start session
session_start();

// Include database connection
include('db_connection.php'); // Ensure this file exists and connects to your database

// Check if `college_id` is passed
if (!isset($_GET['college_id'])) {
    die('Invalid request. College ID is missing.');
}

// Get the `college_id` from the URL
$college_id = intval($_GET['college_id']);

// Fetch college details
$college_query = "SELECT college_name FROM colleges WHERE college_id = ?";
$stmt = $conn->prepare($college_query);
$stmt->bind_param("i", $college_id);
$stmt->execute();
$college_result = $stmt->get_result();

if ($college_result->num_rows === 0) {
    die('Invalid College ID.');
}

$college = $college_result->fetch_assoc();

// Fetch departments for the college
$dept_query = "SELECT dept_id, dept_name FROM departments WHERE college_id = ?";
$stmt = $conn->prepare($dept_query);
$stmt->bind_param("i", $college_id);
$stmt->execute();
$dept_result = $stmt->get_result();

// Fetch semesters for the selected department
$semester_query = "SELECT DISTINCT semester FROM semesters";
$semester_result = $conn->query($semester_query);

// Handle filtering based on selected department and semester
$selected_dept = isset($_GET['dept_id']) ? intval($_GET['dept_id']) : null;
$selected_semester = isset($_GET['semester']) ? intval($_GET['semester']) : null;

// Fetch subjects based on filters
$subject_query = "SELECT s.subject_name, s.subject_id 
                  FROM subjects s
                  INNER JOIN semesters sem ON s.sem_id = sem.sem_id
                  INNER JOIN departments d ON sem.dept_id = d.dept_id
                  WHERE d.college_id = ?";
$types = "i";
$params = [$college_id];

if ($selected_dept) {
    $subject_query .= " AND d.dept_id = ?";
    $types .= "i";
    $params[] = $selected_dept;
}

if ($selected_semester) {
    $subject_query .= " AND sem.semester = ?";
    $types .= "i";
    $params[] = $selected_semester;
}

$stmt = $conn->prepare($subject_query);
$stmt->bind_param($types, ...$params);
$stmt->execute();
$subject_result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($college['college_name']); ?> - Notes</title>
    <link rel="stylesheet" href="styles.css"> <!-- Ensure styles.css exists -->
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .container {
            display: flex;
            flex-wrap: wrap;
            margin: 20px;
        }
        .left-section {
            flex: 25%;
            border-right: 1px solid #ddd;
            padding: 15px;
        }
        .right-section {
            flex: 75%;
            padding: 15px;
        }
        .section {
            margin-bottom: 20px;
        }
        .section h3 {
            margin-bottom: 10px;
        }
        .subjects-list {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }
        .subject-card {
            border: 1px solid #ddd;
            padding: 10px;
            width: calc(33% - 20px);
            text-align: center;
            background: #f9f9f9;
        }
        .subject-card:hover {
            background: #f1f1f1;
        }
    </style>
</head>
<body>
    <h1>Notes for <?php echo htmlspecialchars($college['college_name']); ?></h1>
    <div class="container">
        <!-- Left Section -->
        <div class="left-section">
            <!-- Academic Year -->
            <div class="section">
                <h3>Semesters</h3>
                <ul>
                    <?php while ($sem = $semester_result->fetch_assoc()): ?>
                        <li>
                            <a href="?college_id=<?php echo $college_id; ?>&semester=<?php echo $sem['semester']; ?>">
                                Semester <?php echo $sem['semester']; ?>
                            </a>
                        </li>
                    <?php endwhile; ?>
                </ul>
            </div>

            <!-- Departments -->
            <div class="section">
                <h3>Departments</h3>
                <ul>
                    <?php while ($dept = $dept_result->fetch_assoc()): ?>
                        <li>
                            <a href="?college_id=<?php echo $college_id; ?>&dept_id=<?php echo $dept['dept_id']; ?>">
                                <?php echo htmlspecialchars($dept['dept_name']); ?>
                            </a>
                        </li>
                    <?php endwhile; ?>
                </ul>
            </div>
        </div>

        <!-- Right Section -->
        <div class="right-section">
            <h2>Subjects</h2>
            <div class="subjects-list">
                <?php if ($subject_result->num_rows > 0): ?>
                    <?php while ($subject = $subject_result->fetch_assoc()): ?>
                        <div class="subject-card">
                            <?php echo htmlspecialchars($subject['subject_name']); ?>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <p>No subjects found for the selected filters.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>
