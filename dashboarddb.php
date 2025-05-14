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

// Function to return the department's color based on its name
function getDepartmentColor($department) {
    return isset($colors[$department]) ? $colors[$department] : '#FFFFFF';  // Default to white if not found
}

$gaugeColors = [
    'CCS' => 'rgba(97, 99, 99, 1)',       // Darker gray-blue
    'CBA' => 'rgba(166, 154, 25, 1)',     // Darker gold/yellow
    'CAS' => 'rgba(75, 0, 130, 1)',         // Darker maroon
    'COE' => 'rgba(204, 85, 0, 1)',     // Darker purple
    'COED' => 'rgba(33, 65, 170, 1)',     // Darker royal blue
    'CIHM' => 'rgba(99, 8, 0, 1)',     // Darker navy blue
    'CON' => 'rgba(180, 70, 150, 1)',     // Darker pink/magenta
];





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
            font-family: 'Poppins', sans-serif;
        }

        /* Topbar */
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

        .dropdown-content ul {
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

        .user:hover {
            cursor: pointer;
        }

        /* Sidebar */
        .sidebar {
            position: fixed;
            top: 60px;
            width: 200px;
            height: calc(100% - 60px);
            background: #fff;
            overflow-x: hidden;
            overflow-y: auto;
            white-space: nowrap;
            z-index: 1;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
        }

        /* Sidebar list */
        .sidebar ul {
            margin-top: 20px;
            display: flex;
            flex-direction: column;
        }

        /* Sidebar list items */
        .sidebar ul li {
            width: 100%;
            list-style: none;
            margin: 5px;
            position: relative;
        }

        /* Sidebar icons */
        .sidebar ul li a i {
            min-width: 60px;
            font-size: 24px;
            text-align: center;
        }

        /* Sidebar links */
        .sidebar ul li a {
            width: 100%;
            text-decoration: none;
            color: #333; /* Always dark font */
            height: 60px;
            display: flex;
            align-items: center;
            transition: background-color 0.2s;
            border-radius: 10px 0 0 10px;
            padding-left: 10px;
        }

        .sidebar ul li a::before {
            content: "";
            position: absolute;
            left: 0;
            top: 10px;
            width: 5px;
            height: 40px;
            background-color: #059212;
            border-radius: 5px;
            opacity: 0;
            transform: scaleY(0);
            transition: all 0.3s ease;
        }

                /* Hover effect */
                .sidebar ul li a:hover::before {
            opacity: 1;
            transform: scaleY(1);
        }

        /* ✅ Active tab: Only shows a green side bar */
        .sidebar ul li.active::before {
            content: "";
            position: absolute;
            left: 0;
            top: 10px;
            width: 5px;
            height: 40px;
            background-color: #059212;
            border-radius: 5px;
        }

        .profile {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 20px;
            background-color: #f5f5f5;
            border-bottom: 1px solid #ddd;
        }

        .profile-logo img {
            width: 45px;
            height: 45px;
            border-radius: 50%; /* Makes the logo circular */
            object-fit: cover;
        }

        .profile-info span {
            font-size: 12px;
            color: #777;
        }

        .profile-info h4 {
            margin: 0;
            font-size: 16px;
            color: #333;
        }


        .logout {
            transform: translateY(70px);
            padding: 10px;
            text-align: center;
        }

        .logout a {
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            color: #333;
        }

        .logout i {
            margin-right: 8px;
        }

        /* Main section */
        .main {
            position: absolute;
            top: 60px;
            width: calc(100% - 260px);
            min-height: calc(100vh - 60px);
            margin-left: 200px;
            padding: 20px;
            transition: margin-left 0.3s, width 0.3s; /* Smooth transition */
            display: flex;
            justify-content: space-between; /* Align the cards and charts */
            gap: 20px;
            flex-wrap: wrap; /* Allow content to wrap on smaller screens */
        }

        .charts-container {
            flex: 1 1 45%; /* Takes up 45% of the available space */
            display: flex;
            flex-direction: column;
            gap: 20px;
            padding: 20px;
        }

        .cards {
            flex: 1 1 25%; /* Takes up 45% of the available space */
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(140px, 1fr)); /* Adjusting the card size */
            grid-gap: 15px;
            min-height: 30vh;
            justify-self: flex-end; /* Align cards to the right */
            padding: 20px;
            margin-left: 20px
        }

        .icon-box {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-bottom: 10px; /* Adjust the space below the icon */
            width: 100%; /* Ensure the container takes full width */
        }

        .icon-box img {
            width: 100px; /* Adjust the width as needed */
            height: auto;
            max-width: 100px; /* Ensure the image doesn't grow larger than desired */
            margin: 0; /* Remove any margin */
            display: block; /* Ensures image is displayed as a block element */
        }


        .card-content {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 5px;
        }

        .number {
            font-size: 35px;
            font-weight: 500;
            color: black;
        }

        .card-name {
            color: black;
            font-weight: 600;
        }

        /* Charts container styling */
        /* General Styling for Charts and Cards Container */
        /* Cards Section - Grid with 2 Columns */
        .cards {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
            padding: 10px;
            justify-content: center;
        }

        /* Charts Section */
        .charts-container {
            display: flex;
            flex-direction: column; /* stack charts vertically */
            align-items: center;     /* center horizontally */
            justify-content: center; /* optional: center vertically if it has height */
            gap: 20px;
            width: 100%;
        }

        /* Individual Chart Box */
        .charts-container .chart {
            width: 100%;
            max-width: 700px; /* your original value */
            background: #fff;
            padding: 30px;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            transition: transform 0.3s ease;
        }


        .charts-container .chart:hover {
            transform: translateY(-5px);
        }

        /* Canvas Scaling */
        canvas {
            width: 100%;
            height: 200px;
        }

        /* Chart Title */
        .charts-container h3 {
            margin-top: 0;
            margin-bottom: 20px;
            color: #059212;
            font-size: 22px;
            font-weight: 600;
            text-align: center;
        }

        /* Individual Card */
        .card {
            position: relative;
            width: 100%;
            height: 200px;
            border-radius: 20px;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            transition: transform 0.3s ease;
        }


        .card {
            position: relative;
            width: 200px;
            height: 200px;
            border-radius: 20px;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            transition: transform 0.3s ease;
        }

        /* .card.ccs {
            background-image: url('img/ccs.png');
            background-size: cover;
        }

        .card.cba {
            background-image: url('img/cba.png');
            background-size: cover;
        }

        .card.cas {
            background-image: url('img/cas.png');
            background-size: cover;
        }

        .card.coe {
            background-image: url('img/coe.png');
            background-size: cover;
        }

        .card.coed {
            background-image: url('img/coed.png');
            background-size: cover;
        }

        .card.cihm {
            background-image: url('img/cihm.png');
            background-size: cover;
        }

        .card.con {
            background-image: url('img/con_con.png');
            background-size: cover;
        } */

        .gauge-container {
            position: relative;
            width: 100%;
            height: 100%;
        }
        .gauge {
            width: 130px; /* Adjust the width */
            height: 130px; /* Adjust the height */
            margin: 0 auto; /* Center the gauge if needed */
        }


        .logo-overlay {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 2;
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 10px;
        }

        .logo-overlay img {
            width: 90px;
            height: 90px;
        }

        .hover-info {
            position: absolute;
            bottom: 15px;
            left: 50%;
            transform: translateX(-50%);
            opacity: 0;
            background: rgba(0, 0, 0, 0.7);
            color: #fff;
            padding: 6px 12px;
            border-radius: 12px;
            font-size: 14px;
            transition: opacity 0.3s ease;
            z-index: 3;
        }

        .card:hover .hover-info {
            opacity: 1;
        }

        .card:hover{
            transform: translateY(-5px);
        }


        
    </style>
</head>
<body>
    <div class="container">
        <div class="topbar">
            <div class="logo">
                <h2>VMS.</h2>
            </div>
            
        </div>
        <div class="sidebar">
            <div class="profile">
                <div class="profile-logo">
                    <img src="img/plp.png" alt="Logo">
                </div>
                <div class="profile-info">
                    <span>Welcome,</span>
                    <h4>Admin</h4>
                </div>
            </div>
            <ul>
                <li class="active">
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
                        <div>Data Analysis</div>
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
                <li>
                    <a href="reference_page.php">
                        <i class='bx bx-book-open'></i>
                        <div>Reference</div>
                    </a>
                </li>
            </ul>
            <div class="logout">
                <a href="logout.php" onclick="return confirmLogout()">
                    <i class='bx bx-log-out'></i>
                    <span>Logout</span>
                </a>
            </div>
        </div>
        <div class="main" id="main-content">
        <div class="cards">
            <?php foreach ($departmentCounts as $dept => $count): ?>
                <a href="<?php echo strtolower($dept); ?>_page.php" style="text-decoration: none;">
                    <div class="card <?php echo strtolower($dept); ?>" style="background-color: <?php echo getDepartmentColor($dept); ?>;">
                        <div class="gauge-container">
                            <!-- Gauge Chart -->
                            <canvas class="gauge"
                                data-count="<?php echo $count; ?>"
                                data-color="<?php echo $gaugeColors[$dept] ?? '#059212'; ?>">
                            </canvas>

                            <!-- Department Logo -->
                            <div class="logo-overlay">
                                <?php
                                $imageFile = strtolower($dept) === 'con' ? 'con_con.png' : strtolower($dept) . '.png'; 
                                ?>
                                <img src="img/<?php echo $imageFile; ?>" alt="<?php echo $dept; ?>">
                            </div>

                            <!-- Hover Text -->
                            <div class="hover-info">
                                <?php echo $dept; ?> <br>
                                <?php echo $count; ?> Students
                            </div>
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
                    <h3>Students per Department</h3>
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
    function confirmLogout() {
        return confirm("Are you sure you want to log out?");
    }

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

    // Get all sidebar links
    const sidebarLinks = document.querySelectorAll('.sidebar ul li a');

    // Add click event listener to each sidebar link
    sidebarLinks.forEach(link => {
        link.addEventListener('click', function() {
            // Remove the 'active' class from all sidebar items
            sidebarLinks.forEach(item => item.closest('li').classList.remove('active'));

            // Add 'active' class to the clicked item
            this.closest('li').classList.add('active');
        });
    });


    document.querySelectorAll('.gauge').forEach((canvas) => {
    const count = parseInt(canvas.dataset.count);
    const max = 100;
    const color = canvas.dataset.color;

    new Chart(canvas, {
        type: 'doughnut',
        data: {
            datasets: [{
                data: [count, max - count],
                backgroundColor: [color, '#e0e0e0'],
                borderWidth: 0,
                cutout: '75%',
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                tooltip: { enabled: false },
                legend: { display: false }
            }
        }
    });
});
    </script>
</body>
</html> 