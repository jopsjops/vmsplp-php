<?php
// Enable error reporting for debugging during development
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Headers to allow cross-origin access and POST requests
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

include 'dbconnection.php';

// Function to get the count of unique students by department
function getDepartmentCount($conn, $department) {
    $stmt = $conn->prepare("SELECT COUNT(DISTINCT Student_Name) AS total FROM student_info WHERE Department = ?");
    $stmt->bind_param("s", $department);
    $stmt->execute();
    $result = $stmt->get_result();
    $total = 0;

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $total = $row['total'];
    }
    
    $stmt->close();
    return $total;
}

// Get counts for each department
$departments = ['CCS', 'CAS', 'CBA', 'CON', 'COE', 'COED', 'CIHM'];
$departmentCounts = [];
foreach ($departments as $dept) {
    $departmentCounts[$dept] = getDepartmentCount($conn, $dept);
}

// Fetch the count of violations grouped by Violation type
$graphData = [];
$sql = "SELECT Violation, COUNT(*) AS total_violations FROM student_info GROUP BY Violation ORDER BY total_violations DESC";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $graphData[] = [$row['Violation'], (int)$row['total_violations']];
    }
}

// Output the JSON data
json_encode($graphData);
json_encode($departmentCounts);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="icon" type="image/png" sizes="32x32" href="img/plp.png">
    <title>Admin Dashboard</title>
    <style>
  * {
            padding: 0;
            margin: 0;
            box-sizing: border-box;
            font-family: 'poppins', sans-serif;
        }
        
        /* topbar */
        .topbar {
            position: fixed;
            background: #fff;
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.08);
            width: 100%;
            height: 60px;
            padding: 0 20px;
            display: grid;
            grid-template-columns: 2fr 10fr 0.4fr 1fr;
            align-items: center;
            z-index: 1;
        }

        .logo h2 {
            color: #059212;
        }

        .user {
            position: relative;
            width: 50px;
            height: 50px;
            left: 1148px;
        }

        .dropdown-content {
            transform: translateY(55px);
            display: none;
            position: absolute;
            background-color: #f9f9f9;
            min-width: 160px;
            box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
            z-index: 1;
        }

        .dropdown-content a {
            color: black;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
        }

        .dropdown-content a:hover {
            background-color: #f1f1f1;
        }

        .dropdown-content ul{
            display: flex;
            flex-direction: column;
        }

        .user img {
            position: absolute;
            top: 0;
            left: 0;
            height: 100%;
            width: 100%;
            object-fit: cover;
        }

        .user:hover{
            cursor: pointer;
        }

        /* side bar */
        .sidebar {
            position: fixed;
            top: 60px;
            width: 60px;
            height: calc(100% - 60px);
            background: #059212;
            overflow-x: hidden;
            overflow-y: auto;
            transition: width 0.3s;
            white-space: nowrap;
            z-index: 1;
        }

        .sidebar:hover {
            width: 260px;
        }

        .sidebar ul {
            margin-top: 20px;
            display: flex;
            flex-direction: column;
        }

        .sidebar ul li {
            width: 100%;
            list-style: none;
            margin: 5px;
        }

        .sidebar ul li a {
            width: 100%;
            text-decoration: none;
            color: #fff;
            height: 60px;
            display: flex;
            align-items: center;
            transition: color 0.2s, background-color 0.2s;
            border-radius: 10px 0 0 10px;
        }

        .sidebar ul li a i {
            min-width: 60px;
            font-size: 24px;
            text-align: center;
        }

        .sidebar ul li.dash a {
            color: #059212;
            background: #f5f5f5;
        }

        .sidebar ul li a:hover {
            color: #059212;
            background: #f5f5f5;
        }

        .sidebar ul li span {
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            transition: opacity 0.3s;
        }

        .sidebar:hover ~ .main {
            margin-left: 260px; /* Sidebar expanded */
            
        }

        /* main section */
        .main{
            position: absolute;
            top: 60px;
            width: calc(100% - 260px);
            min-height: calc(100vh - 60px);
            margin-left: 60px;
            padding: 20px;
            transition: margin-left 0.3s, width 0.3s; /* Smooth transition */
            
        }

        .cards {
            width: 100%; /* Ensure it occupies the full width of the main container */
            padding: 30px 40px;
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); /* Responsive layout */
            grid-gap: 35px;
            min-height: 30vh; 
            transition: grid-template-columns 0.3s ease; /* Smooth transition when sidebar expands */
        }


        .cards .card {
            padding: 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 7px 25px 0 rgba(0, 0, 0, 0.3);
            cursor: pointer;
            transition: transform 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        .cards .card.ccs {
            background: #a2a5a5;
        }

        .cards .card.cas {
            background: #ab3fbc;
        }

        .cards .card.cba {
            background: #e6d540;
        }

        .cards .card.con {
            background: #fa90d7;
        }

        .cards .card.coe {
            background: #de993f;
        }

        .cards .card.coed {
            background: #4169E1;
        }

        .cards .card.cihm {
            background: #950c00;
        }

        .number {
            font-size: 35px;
            font-weight: 500;
            color: #ffffff;
        }

        .card-name {
            color: #ffffff;
            font-weight: 600;
        }

        .icon-box img {
            width: 80px;
            height: auto;
            transform: translateY(12px);
            margin-right: -15px;
        }

        .cards .card:hover {
            transform: scale(1.05);
        }

        /* Table styling */
       
        .charts-container {
        display: flex;
        flex-wrap: wrap; /* Ensure charts adjust for smaller screens */
        gap: 20px; /* Space between charts */
            justify-content: center;
        }
        .chart {
            flex: 1 1 45%; /* Each chart takes up to 45% of the row width */
            max-width: 600px; /* Optional: limit max width */
        }
        canvas {
            width: 100%; /* Ensure canvas scales properly */
            height: 300px; /* Set fixed height for charts */
        }

        .charts-container h3{
            margin-top: 70px;
            margin-bottom: 20px;
            color: #059212;
        }

    </style>
</head>
<body>
    <div class="container">
        <div class="topbar">
            <div class="logo">
                <h2>SSO.</h2>
            </div>
            <div class="user">
                <img src="img/plp.png" alt="Profile Image" id="profileImage">
                <div class="dropdown-content" id="dropdownContent">
                <a href="admin_changepass.php" id="changePasswordButton"><i class='bx bx-lock'></i> Change Password</a>
                    <a href="index.php" id="logoutButton"><i class='bx bx-log-out'></i> Log Out</a>
                </div>
            </div>
        </div>
        <div class="sidebar">
            <ul>
                <li class="dash">
                    <a href="dashboarddb.php">
                        <i class='bx bxs-dashboard'></i>
                        <div>Dashboard</div>
                    </a>
                </li>
                <li>
                    <a href="students_page.php">
                        <i class='bx bxs-group'></i>
                        <div>Students</div>
                    </a>
                </li>
                <li>
                    <a href="prediction.php">
                        <i class='fas fa-chart-line'></i>
                        <div>Predictions</div>
                    </a>
                </li>
                <li class="archive">
                    <a href="archive.php">
                        <i class='bx bxs-archive'></i>
                        <div>Archive</div>
                    </a>
                </li>
                <li class="tables">
                    <a href="view_semviolation.php">
                        <i class='bx bx-table'></i>
                        <div>View Tables</div>
                    </a>
                </li>
            </ul>
        </div>
        <div class="main" id="main-content">
        <div class="cards">
                <?php foreach ($departmentCounts as $dept => $count): ?>
                    <a href="<?php echo strtolower($dept); ?>_page.php" style="text-decoration: none;">
                        <div class="card <?php echo strtolower($dept); ?>">
                            <div class="card-content">
                                <div class="number"><?php echo $count; ?></div>
                                <div class="card-name"><?php echo $dept; ?></div>
                            </div>
                            <div class="icon-box">
                                <?php
                                $imageFile = strtolower($dept) === 'con' ? 'con_con.png' : strtolower($dept) . '.png'; 
                                ?>
                                <img src="img/<?php echo $imageFile; ?>" alt="<?php echo $dept; ?>">
                            </div>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>


            <div class="charts-container">
                <div class="chart">
                    <h3>Violation Trends</h3>
                    <canvas id="violationsLineChart"></canvas>
                </div>
                <div class="chart">
                    <h3>Number of Students per Department</h3>
                    <canvas id="studentsBarChart"></canvas>
                </div>
            </div>


            <?php
            // Close the database connection
            $conn->close();
            ?>
        </div>
    </div>
    
    <script>
    document.getElementById("profileImage").onclick = function() {
        var dropdown = document.getElementById("dropdownContent");
        dropdown.style.display = (dropdown.style.display === "none" || dropdown.style.display === "") ? "block" : "none";
    }

    window.onclick = function(event) {
        if (!event.target.matches('#profileImage')) {
            var dropdowns = document.getElementsByClassName("dropdown-content");
            for (var i = 0; i < dropdowns.length; i++) {
                var openDropdown = dropdowns[i];
                if (openDropdown.style.display === "block") {
                    openDropdown.style.display = "none";
                }
            }
        }
    }

    document.getElementById("logoutButton").onclick = function(event) {
        var confirmLogout = confirm("Are you sure you want to log out?");
        if (!confirmLogout) {
            event.preventDefault();
        }
    };

    // Fetch the violation trend data from the PHP backend
    const violationData = <?php echo json_encode($graphData); ?>;

    console.log(violationData); // Debugging: Ensure data is passed correctly

    // Prepare data for the chart
    const labels = violationData.map(item => item[0]); // Violation types
    const data = violationData.map(item => item[1]);   // Violation counts

    // Initialize the line chart
    const ctx = document.getElementById('violationsLineChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Number of Violations',
                data: data,
                borderColor: '#059212', // Green to match the website theme
                backgroundColor: 'rgba(5, 146, 18, 0.2)', // Lighter green with transparency
                borderWidth: 2,
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: true,
                    position: 'top'
                },
                tooltip: {
                    enabled: true
                }
            },
            scales: {
                x: {
                    title: {
                        display: true,
                        text: 'Violations'
                    }
                },
                y: {
                    title: {
                        display: true,
                        text: 'Count'
                    },
                    beginAtZero: true
                }
            }
        }
    });

    const departmentData = <?php echo json_encode($departmentCounts); ?>; // Department data from PHP
    const departmentLabels = Object.keys(departmentData); // Department names
    const departmentCounts = Object.values(departmentData); // Student counts

    // Define colors for each department
    const departmentColors = {
        CCS: 'rgba(162, 165, 165, 0.5)', // Light teal
        CON: 'rgba(250, 144, 215, 0.5)', // Light red
        CBA: 'rgba(230, 213, 64, 0.5)', // Light yellow
        CIHM: 'rgba(149, 12, 0, 0.5)', // Light blue
        CAS: 'rgba(171, 63, 188, 0.5)', // Light purple
        COED: 'rgba(65, 105, 225, 0.5)', // Light orange
        COE: 'rgba(222, 153, 63, 0.5)'  // Light gray
    };

    // Map colors to the departments
    const backgroundColors = departmentLabels.map(dept => departmentColors[dept] || 'rgba(0, 0, 0, 0.5)'); // Default to black if not matched
    const borderColors = departmentLabels.map(dept => departmentColors[dept].replace('0.5', '1') || 'rgba(0, 0, 0, 1)'); // Full opacity for borders

    // Initialize the bar chart
    const ctx2 = document.getElementById('studentsBarChart').getContext('2d');
    new Chart(ctx2, {
        type: 'bar',
        data: {
            labels: departmentLabels,
            datasets: [{
                label: 'Number of Students',
                data: departmentCounts,
                backgroundColor: backgroundColors,
                borderColor: borderColors,
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: true,
                    position: 'top'
                },
                tooltip: {
                    enabled: true
                }
            },
            scales: {
                x: {
                    title: {
                        display: true,
                        text: 'Department'
                    }
                },
                y: {
                    title: {
                        display: true,
                        text: 'Student Count'
                    },
                    beginAtZero: true
                }
            }
        }
    });


    </script>
</body>
</html> 