<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="icon" type="image/png" sizes="32x32" href="img/plp.png">
    <title>Admin</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.25/jspdf.plugin.autotable.min.js"></script>
    <?php
        include 'dbconnection.php'; // Ensure this connects to violationsdb

        // Get distinct users and event types
        $users = [];

        $userResult = $conn->query("SELECT DISTINCT username FROM audit_trail ORDER BY username");
        while ($row = $userResult->fetch_assoc()) {
            $users[] = $row['username'];
        }


        // Get all logs
        $logsResult = $conn->query("SELECT username, action, message, event_type, timestamp FROM audit_trail ORDER BY timestamp DESC");
        $logs = $logsResult ? $logsResult->fetch_all(MYSQLI_ASSOC) : [];

        $conn->close();
    ?>


    <style>
        * {
            padding: 0;
            margin: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        /*topbar*/
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
            transform: translateY(-6px);
        }

        .logo a {
            color: #059212;
            font-size: 24px;
            text-decoration: none;
            font-weight: bold;
        }


        /*sidebar*/
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
            color: #333;
            /* Always dark font */
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
            border-radius: 50%;
            /* Makes the logo circular */
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
            position: absolute;  /* Use absolute to anchor within the sidebar */
            bottom: 25px;         /* Same visual offset as translateY(70px) */
            width: 100%;          /* Optional: full width of sidebar */
            text-align: center;
            padding: 10px;
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

        /*main content*/
        .main {
            position: absolute;
            width: calc(100% - 260px);
            min-height: calc(100vh - 60px);
            margin-left: 200px;
            padding: 20px;
            transition: margin-left 0.3s, width 0.3s;
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
            
        }

        .main h1 {
            margin-top: 70px;
            margin-bottom: 20px;
            color: #059212;
        }

        .main-content {
            display: flex;
            flex-wrap: wrap;
        }

        .main-content .table-container {
            flex: 2;
            display: flex;
            flex-direction: column;
        }

        .main-content #charts {
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 20px;
            padding-left: 30px;
            padding-top: 30px;
            padding-top: 30px;
            padding-bottom: 30px;
            margin-left: 20px;
            margin-right: 10px;
            border-radius: 10px 10px 0 0;
            background-color: transparent;
            outline: #059212;
            outline-style: auto;
        }


        table {
            position: absolute;
            /* Make the table fixed in place */
            top: 110px;
            /* Adjust top position to ensure it's below the top bar */
            left: 20px;
            right: 0;
            width: 100%;
            /* Ensure the table takes the full width */
            border-collapse: collapse;
            margin-top: 20px;
            /* Adjust top margin if needed */
            background-color: #fff;
            /* White background for the table */
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            /* Subtle shadow for depth */
            border-radius: 5px;
        }


        table,
        th,
        td {
            border: 1px solid #e0e0e0;
            /* Light gray border for a minimalistic look */
        }

        th,
        td {
            padding: 10px 15px;
            /* Reduced padding for a clean look */
            text-align: center;
            /* Left align the text for a modern style */
            font-size: 15px;
            /* Slightly smaller text for minimalism */
        }

        th {
            background-color: #f7f7f7;
            /* Light gray background for table headers */
            color: #333;
            /* Dark text color for readability */
            font-weight: bold;
            /* Make headers bold */
            text-transform: uppercase;
            /* All caps for headers for a minimalistic feel */
        }

        tr:nth-child(even) {
            background-color: #fafafa;
            /* Very light gray background for even rows */
        }

        tr:hover {
            background-color: #f1f1f1;
            /* Slight hover effect for rows */
        }

        td {
            color: #333;
            /* Dark text color for the data */
        }

       .sorting-section {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            align-items: center;
            margin-bottom: 20px;
            padding: 10px 15px;
            background-color: transparent; /* Removed background */
            border-radius: 8px;
            box-shadow: none; /* Optional: removed box shadow too */
            transform: translateY(4px);
        }

        .sorting-section label {
            display: flex;
            align-items: center;
            gap: 8px;
            font-weight: 600;
            color: #333;
        }

        .sorting-section select {
            padding: 6px 12px;
            border: 1px solid #ccc;
            border-radius: 6px;
            background-color: #fff;
            font-size: 14px;
            color: #333;
            cursor: pointer;
            transition: border-color 0.3s ease;
        }

        .sorting-section select:focus {
            border-color: #059212;
            outline: none;
        }

        .sorting-section i.fa-list {
            font-size: 16px;
        }

        #eventDateFilter {
            padding: 6px 10px;
            font-size: 14px;
            border-radius: 4px;
            border: 1px solid #ccc;
            outline: none;
            transition: border-color 0.3s;
        }

        #eventDateFilter:hover,
        #eventDateFilter:focus {
            border-color: #007bff;
        }

        label i.fa-calendar-days {
            color: #555;
            font-size: 16px;
            vertical-align: middle;
        }


        .pagination-btn {
            display: inline-block;
            margin: 5px 6px;
            padding: 6px 12px;
            border: 1px solid #006400;
            border-radius: 5px;
            color: #006400;
            text-decoration: none;
            font-weight: bold;
            transition: background 0.2s ease;
        }

        .pagination-btn i {
            vertical-align: middle;
            font-size: 18px;
        }

        .pagination-btn:hover {
            background-color: #006400;
            color: white;
        }

        .pagination-current {
            background-color: #006400;
            color: white;
            cursor: default;
            pointer-events: none;
        }

        .pagination-disabled {
            color: #aaa;
            border-color: #aaa;
            cursor: not-allowed;
            pointer-events: none;
            background-color: #f1f1f1;
        }


        .pagination-ellipsis {
            display: inline-block;
            padding: 6px 12px;
            color: #666;
            font-weight: bold;
        }

        .pagination-btn.disabled {
            color: #999;
            border-color: #999;
            pointer-events: none;
            cursor: default;
        }



        
    </style>
</head>

<body>
    <div class="container">
        <div class="topbar">
            <div class="logo">
                <h2>VMS.</h2>
            </div>
            <div class="sorting-section">
            <label for="sortDropdown" title="Sort By">
                <i class="fa-solid fa-list"></i>
            </label>
                <label>
                    <select id="userFilter">
                        <option value="all">User: All</option>
                        <?php foreach ($users as $user): ?>
                        <option value="<?= htmlspecialchars($user) ?>"><?= htmlspecialchars($user) ?></option>
                        <?php endforeach; ?>
                    </select>
                </label>    
                <label>
                    <input type="date" id="eventDateFilter" name="eventDateFilter" />
                </label>
            </div>
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
            <li>
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
            <li class="active">
                <a href="audit_trail.php">
                    <i class='bx bx-history'></i>
                    <div>Audit Trail</div>
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

    <div class="main">
        <h1>AUDIT TRAIL</h1>
        <div class="main-content">
            <div class="table-container">
                <table id="violationTable">
                    <thead>
                        <tr>
                            <th>Timestamp</th>
                            <th>User</th>
                            <th>Message</th>
                            <th>Event Type</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (!empty($logs)) {
                            $selectedUser = isset($_GET['user']) ? trim($_GET['user']) : 'all';
                            $currentPage = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
                            $logsPerPage = 10;

                            // Filter logs by user
                            if ($selectedUser !== 'all') {
                                $filteredLogs = array_filter($logs, function($log) use ($selectedUser) {
                                    return strtolower($log['username']) === strtolower($selectedUser);
                                });
                            } else {
                                $filteredLogs = $logs;
                            }

                            // Sort logs by timestamp (newest first)
                            usort($filteredLogs, function ($a, $b) {
                                return strtotime($b['timestamp']) - strtotime($a['timestamp']);
                            });

                            $totalLogs = count($filteredLogs);
                            $totalPages = max(1, ceil($totalLogs / $logsPerPage));
                            $offset = ($currentPage - 1) * $logsPerPage;
                            $latestLogs = array_slice($filteredLogs, $offset, $logsPerPage);
                            $rowCount = count($latestLogs);

                            // Display log rows
                            foreach ($latestLogs as $log) {
                                echo '<tr>';
                                echo '<td>' . htmlspecialchars($log['timestamp']) . '</td>';
                                echo '<td>' . htmlspecialchars($log['username']) . '</td>';
                                echo '<td>' . htmlspecialchars($log['message']) . '</td>';
                                echo '<td>' . htmlspecialchars($log['event_type']) . '</td>';
                                echo '</tr>';
                            }

                            // Fill remaining rows if less than 10
                            for ($i = $rowCount; $i < $logsPerPage; $i++) {
                                echo '<tr><td colspan="4" style="text-align: center; color: #999;">N/A</td></tr>';
                            }

                            // If no logs found for the user
                            if ($rowCount === 0) {
                                echo '<tr><td colspan="4" style="text-align: center; color: #999;">No logs found for this user.</td></tr>';
                                for ($i = 1; $i < $logsPerPage; $i++) {
                                    echo '<tr><td colspan="4" style="text-align: center; color: #999;">N/A</td></tr>';
                                }
                            }

                            // Pagination controls
                            echo '<tr><td colspan="4" style="text-align: center;">';

                            // Previous Button (always visible, disabled if no prev)
                            if ($currentPage > 1) {
                                echo '<a href="?user=' . urlencode($selectedUser) . '&page=' . ($currentPage - 1) . '" class="pagination-btn">';
                                echo '<i class="bx bx-left-arrow-alt"></i> Previous</a>';
                            } else {
                                echo '<span class="pagination-btn disabled"><i class="bx bx-left-arrow-alt"></i> Previous</span>';
                            }

                            // Function to output page button or span
                            function pageBtn($page, $currentPage, $selectedUser) {
                                if ($page == $currentPage) {
                                    return '<span class="pagination-btn pagination-current">' . $page . '</span>';
                                } else {
                                    return '<a href="?user=' . urlencode($selectedUser) . '&page=' . $page . '" class="pagination-btn">' . $page . '</a>';
                                }
                            }

                            // Show max 5 pages with ellipses
                            if ($totalPages <= 5) {
                                // Show all pages if <= 5
                                for ($i = 1; $i <= $totalPages; $i++) {
                                    echo pageBtn($i, $currentPage, $selectedUser);
                                }
                            } else {
                                // Always show first page
                                echo pageBtn(1, $currentPage, $selectedUser);

                                // Determine range of pages around current page
                                $start = max(2, $currentPage - 1);
                                $end = min($totalPages - 1, $currentPage + 1);

                                // Ellipsis after first page if needed
                                if ($start > 2) {
                                    echo '<span class="pagination-ellipsis">...</span>';
                                }

                                // Pages in the middle
                                for ($i = $start; $i <= $end; $i++) {
                                    echo pageBtn($i, $currentPage, $selectedUser);
                                }

                                // Ellipsis before last page if needed
                                if ($end < $totalPages - 1) {
                                    echo '<span class="pagination-ellipsis">...</span>';
                                }

                                // Always show last page
                                echo pageBtn($totalPages, $currentPage, $selectedUser);
                            }

                            // Next Button (always visible, disabled if no next)
                            if ($currentPage < $totalPages) {
                                echo '<a href="?user=' . urlencode($selectedUser) . '&page=' . ($currentPage + 1) . '" class="pagination-btn">';
                                echo 'Next <i class="bx bx-right-arrow-alt"></i></a>';
                            } else {
                                echo '<span class="pagination-btn disabled">Next <i class="bx bx-right-arrow-alt"></i></span>';
                            }

                            echo '</td></tr>';
                        } else {
                            // No logs at all
                            echo '<tr><td colspan="4" style="text-align: center; color: #999;">No audit records found.</td></tr>';
                            for ($i = 1; $i < 10; $i++) {
                                echo '<tr><td colspan="4" style="text-align: center; color: #999;">N/A</td></tr>';
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    </div>

    <script>
        function confirmLogout() {
            return confirm("Are you sure you want to log out?");
        }

        document.addEventListener('DOMContentLoaded', function () {
            const userFilter = document.getElementById('userFilter');
            const eventDateFilter = document.getElementById('eventDateFilter');
            const rows = document.querySelectorAll('#violationTable tbody tr');

            function filterByUser() {
                const selectedUser = userFilter.value.trim().toLowerCase();
                let matchCount = 0;

                rows.forEach(row => {
                    const user = row.children[1].textContent.trim().toLowerCase();

                    if (selectedUser === 'all' || user === selectedUser) {
                        row.style.display = '';
                        matchCount++;
                    } else {
                        row.style.display = 'none';
                    }
                });

                showOrHideNoLogsMessage(matchCount, 'user');
            }

            function filterByDate() {
                const selectedDate = eventDateFilter.value;
                let matchCount = 0;

                rows.forEach(row => {
                    const dateCell = row.cells[0]?.textContent?.trim().split(' ')[0]; // Get only date part

                    if (!selectedDate || selectedDate === dateCell) {
                        row.style.display = '';
                        matchCount++;
                    } else {
                        row.style.display = 'none';
                    }
                });

                showOrHideNoLogsMessage(matchCount, 'date');
            }

            function showOrHideNoLogsMessage(count, type) {
                const oldMessage = document.getElementById('noLogsRow');
                if (oldMessage) oldMessage.remove();

                if (count === 0) {
                    const tbody = document.querySelector('#violationTable tbody');
                    const newRow = document.createElement('tr');
                    newRow.id = 'noLogsRow';

                    const message = type === 'user' 
                        ? 'No logs found for this user.' 
                        : 'No logs found on this date.';

                    newRow.innerHTML = `<td colspan="4" style="text-align: center; color: #999;">${message}</td>`;
                    tbody.appendChild(newRow);
                }
            }

            // Attach event listeners separately
            userFilter.addEventListener('change', filterByUser);
            eventDateFilter.addEventListener('change', filterByDate);

            
        });



        document.addEventListener('DOMContentLoaded', function () {
            const dateInput = document.getElementById('eventDateFilter');

            function setTodayDate() {
                const today = new Date();
                const yyyy = today.getFullYear();
                const mm = String(today.getMonth() + 1).padStart(2, '0');
                const dd = String(today.getDate()).padStart(2, '0');
                const formattedToday = `${yyyy}-${mm}-${dd}`;

                dateInput.value = formattedToday;   // Set today's date as default
                dateInput.max = formattedToday;     // Lock future dates
            }

            setTodayDate();
        });
    </script>
</body>

</html>