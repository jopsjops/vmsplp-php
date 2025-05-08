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
        }

        .search {
            position: relative;
            width: 60%;
            justify-self: center;
        }

        .search input {
            width: 100%;
            height: 40px;
            padding: 0 40px;
            font-size: 16px;
            outline: none;
            border: none;
            border-radius: 10px;
            background: #f5f5f5;
        }

        .search i {
            position: absolute;
            right: 15px;
            top: 15px;
            cursor: pointer;
        }

        .logo a {
            color: #059212;
            font-size: 24px;
            text-decoration: none;
            font-weight: bold;
        }

        .user {
            position: relative;
            width: 50px;
            height: 50px;
            left: 49px;
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

        .dropdown-content {
            transform: translateY(55px);
            display: none;
            position: absolute;
            background-color: #f9f9f9;
            min-width: 160px;
            box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
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
            margin-top: 180px;
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

        /*main content*/
        .main {
            position: absolute;
            width: calc(100% - 260px);
            min-height: calc(100vh - 60px);
            margin-left: 200px;
            padding: 20px;
            transition: margin-left 0.3s, width 0.3s; /* Smooth transition */
            display: flex;
            gap: 20px;
            flex-wrap: wrap; /* Allow content to wrap on smaller screens */
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
            position: absolute; /* Make the table fixed in place */
            top: 110px; /* Adjust top position to ensure it's below the top bar */
            left: 20px;
            right: 0;
            width: 100%; /* Ensure the table takes the full width */
            border-collapse: collapse;
            margin-top: 20px; /* Adjust top margin if needed */
            background-color: #fff; /* White background for the table */
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); /* Subtle shadow for depth */
            border-radius: 5px;
        }


        table,
        th,
        td {
            border: 1px solid #e0e0e0; /* Light gray border for a minimalistic look */
        }

        th,
        td {
            padding: 10px 15px; /* Reduced padding for a clean look */
            text-align: center; /* Left align the text for a modern style */
            font-size: 15px; /* Slightly smaller text for minimalism */
        }

        th {
            background-color: #f7f7f7; /* Light gray background for table headers */
            color: #333; /* Dark text color for readability */
            font-weight: bold; /* Make headers bold */
            text-transform: uppercase; /* All caps for headers for a minimalistic feel */
        }

        tr:nth-child(even) {
            background-color: #fafafa; /* Very light gray background for even rows */
        }

        tr:hover {
            background-color: #f1f1f1; /* Slight hover effect for rows */
        }

        td {
            color: #333; /* Dark text color for the data */
        }

        .button-group button {
    position: relative;
}

.button-group button::after {
    content: attr(data-tooltip);
    position: absolute;
    bottom: 125%;
    left: 50%;
    transform: translateX(-50%);
    background-color: #333;
    color: #fff;
    padding: 4px 8px;
    border-radius: 5px;
    white-space: nowrap;
    opacity: 0;
    transition: opacity 0.2s;
    pointer-events: none;
    font-size: 12px;
}

.button-group button:hover::after {
    opacity: 1;
}


/* Make both rows flex containers */
.top-row,
.bottom-row {
    display: flex;
    justify-content: space-between;
    gap: 4%;
}

/* Ensure forms and buttons in both rows align */
.top-row form,
.top-row button,
.bottom-row button {
    width: 48%;
    display: flex;
    justify-content: center;
    align-items: center;
}

/* Icons centered inside buttons */
.top-row i,
.bottom-row i {
    display: block;
    margin: auto;
}


.top-row button {
    width: 48%; /* Each button will take almost half of the width */
}

/* Bottom row buttons (Edit and Archive) */
.bottom-row {
    display: flex;
    justify-content: space-between;
    width: 100%;
    gap: 1px; /* Adds spacing between buttons */
}

.bottom-row button {
    width: 48%; /* Each button will take almost half of the width */
}

/* Style for individual buttons */
button {
    padding: 8px 15px;
    border: none;
    border-radius: 5px;
    color: #333;
    background-color: transparent;
    cursor: pointer;
    font-size: 14px;
    transition: background-color 0.3s ease;
}


        button.archive {
            color: #333;
            background-color: transparent;
        }


        button.add {
            width: 50px;              
            height: 50px;            
            border-radius: 50%;       
            background-color: #333; 
            color: white;             
            border: none;            
            display: flex;            
            justify-content: center;  
            align-items: center;      
            cursor: pointer;          
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1); 
            position: fixed;          
            bottom: 20px;             
            right: 20px;              
            z-index: 1000;            
        }

        button.print-pdf {
            width: 50px;              /* Set the width of the circle */
            height: 50px;             /* Set the height to be the same as the width */
            border-radius: 50%;       /* This makes the button round */
            background-color: #333; /* Background color of the button */
            color: white;             /* Icon color */
            border: none;             /* Remove border */
            display: flex;            /* Center icon inside the button */
            justify-content: center;  /* Horizontally center the icon */
            align-items: center;      /* Vertically center the icon */
            cursor: pointer;          /* Add a pointer on hover */
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1); /* Add a subtle shadow */
            position: fixed;          /* Make the button fixed to the viewport */
            bottom: 90px;             /* Distance from the bottom of the viewport */
            right: 20px;              /* Distance from the right of the viewport */
            z-index: 1000;            /* Ensure it stays on top of other elements */
        }

        button.send {
    width: 50px;              /* Set the width of the circle */
    height: 50px;             /* Set the height to match the width */
    border-radius: 50%;       /* Make the button round */
    background-color: #333;   /* Background color */
    color: white;             /* Icon color */
    border: none;             /* Remove default border */
    display: flex;            /* Center icon horizontally */
    justify-content: center;  /* Center icon horizontally */
    align-items: center;      /* Center icon vertically */
    cursor: pointer;          /* Pointer cursor on hover */
    box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1); /* Shadow effect */
    position: fixed;          /* Fixed position on screen */
    bottom: 160px;            /* Adjust position above print and add buttons */
    right: 20px;              /* Align to the right like others */
    z-index: 1000;            /* Keep above other elements */
}



        #addModal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%; /* Keep this */
            overflow: hidden; /* Make outer modal non-scrollable */
            background-color: rgba(0, 0, 0, 0.4);
        }

        #modalContent {
            background-color: #fff;
            position: relative;
            margin: 2% auto;
            padding: 20px;
            border: 1px solid #ddd;
            width: 90%;
            max-width: 700px;
            max-height: 90vh; /* Make modal content height-limited */
            overflow-y: auto;  /* Allow vertical scroll inside only */
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }


        .close {
            color: #aaa;
            float: right;
            font-size: 24px;
            font-weight: bold;
        }

        .submit-btn {
            background-color: #4CAF50; /* Green */
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.2s ease;
            margin-top: 10px;
            width: 100%;
        }

        .submit-btn:hover {
            background-color: #45a049;
            transform: scale(1.02);
        }

        .submit-btn:active {
            background-color: #3e8e41;
        }


        .close:hover,
        .close:focus {
            color: #000;
            text-decoration: none;
            cursor: pointer;
        }

        .submit-btn {
            background-color: #4CAF50; /* Green */
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.2s ease;
            margin-top: 10px;
            width: 100%;
        }

        .submit-btn:hover {
            background-color: #45a049;
            transform: scale(1.02);
        }

        .submit-btn:active {
            background-color: #3e8e41;
        }


        form label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        form input,
        form select {
            width: calc(100% - 22px);
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            margin-bottom: 10px;
        }

        .sorting-section {
        display: flex;
        align-items: center;
        margin-left: 15px; /* slight space from the search bar */
        font-size: 14px;
        }

        .sorting-section label {
            margin-right: 5px;
            font-weight: bold;
            color: #333;
        }

        .sorting-section select {
            padding: 5px 10px;
            font-size: 14px;
            border: 1px solid #ccc;
            border-radius: 5px;
            outline: none;
            background-color: #f9f9f9;
            cursor: pointer;
        }

        .switch {
            position: relative;
            display: inline-block;
            width: 50px;
            height: 24px;
        }

        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            transition: .4s;
            border-radius: 24px;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 18px;
            width: 18px;
            left: 3px;
            bottom: 3px;
            background-color: white;
            transition: .4s;
            border-radius: 50%;
        }

        input:checked+.slider {
            background-color: #4CAF50;
        }

        input:checked+.slider:before {
            transform: translateX(26px);
        }

        .status-text {
            margin-top: 5px;
            font-size: 0.9em;
        }

        .modal {
            position: fixed;
            top: 0; left: 0;
            width: 100%; height: 100%;
            background-color: rgba(0,0,0,0.4);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }
        .modal-content {
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            width: 320px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.3);
            position: relative;
        }
        .close {
            position: absolute;
            top: 10px; right: 15px;
            font-size: 20px;
            cursor: pointer;
        }

        .highlighted {
    background-color:rgb(142, 255, 181) !important; /* Light green */
    transition: background-color 0.3s ease;
}


.modal {
  position: fixed;
  top: 0; left: 0;
  width: 100%; height: 100%;
  background: rgba(0, 0, 0, 0.5);
  display: flex;
  align-items: center;
  justify-content: center;
}

.modal-content {
  background: white;
  padding: 20px;
  border-radius: 8px;
  width: 300px;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);

  /* Remove unnecessary centering that affects all children */
  position: relative;
  text-align: left;
}

#deleteBtn {
  display: block;              /* Allows margin auto to work */
  margin-left: 65px;         /* Top margin and auto left/right to center */
  background-color: #e74c3c;
  color: #fff;
  border: none;
  padding: 10px 16px;
  border-radius: 6px;
  font-size: 14px;
  cursor: pointer;
  transition: background-color 0.2s ease, transform 0.1s ease;
}

#deleteBtn:hover {
  background-color: #c0392b;
  transform: scale(1.05);
}

#deleteBtn:active {
  background-color: #a93226;
  transform: scale(0.98);
}








    </style>
</head>

<body>
    <div class="container">
        <div class="topbar">
            <div class="logo">
                <h2>VMS.</h2>
            </div>
            <div class="search">
                <input type="text" id="search" placeholder="Search">
            </div>
            
            <div class="sorting-section">
                <label for="sortDropdown">Sort By:</label>
                <select id="sortDropdown">
                    <option value="">Select Type</option>
                    <option value="name">Name (Alphabetical)</option>
                    <option value="department">Department (Alphabetical)</option>
                    <option value="date">Date</option>
                    <option value="violation">Violation</option>
                </select>
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
                <li class="active">
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
            <div class="logout">
                <a href="logout.php" onclick="return confirmLogout()">
                    <i class='bx bx-log-out'></i>
                    <span>Logout</span>
                </a>
            </div>
        </div>
        
        <div class="main">
            <h1>STUDENT VIOLATION RECORDS</h1>
            <div class="main-content">
                <div class="table-container">
                    <?php
                    // Database connection
                    include 'dbconnection.php';

                    // Fetch data from the database
                    $sql = "SELECT id, Student_ID, Student_Name, Department, Program, Violation, Offense, Status, Personnel, Date, Time, Sanction
                             FROM student_info ORDER BY Date DESC";

                    $result = $conn->query($sql);
                    ?>
                    <table id="violationTable">
                        <thead>
                            <tr>    
                                <th>Student ID</th>
                                <th>Name</th>
                                <th>Department & Program</th>
                                <th>Violation</th>
                                <th>Offense & Status</th>
                                <th>Personnel</th>
                                <th>Date & Time</th>
                                <th>Sanction</th>
                                <th>Actions</th>               
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                ?>
                                <tr id="row-<?php echo $row['id']; ?>">
                                    <td><?php echo htmlspecialchars($row['Student_ID']); ?></td>
                                    <td><?php echo htmlspecialchars($row['Student_Name']); ?></td>
                                    <td>
                                        <?php echo htmlspecialchars($row['Department'] . ' - ' . $row['Program']); ?>
                                    </td>

                                    <td><?php echo htmlspecialchars($row['Violation']); ?></td>
                                    <td>
                                        <?php echo htmlspecialchars($row['Offense']) . ' - ' . htmlspecialchars($row['Status']); ?>
                                    </td>

                                    <td><?php echo htmlspecialchars($row['Personnel']); ?></td>
                                    
                                    <td>
                                        <?php
                                            $timestamp = strtotime($row['Date'] . ' ' . $row['Time']);
                                            echo htmlspecialchars(date('m/d/Y', $timestamp)) . '<br>' . htmlspecialchars(date('h:i A', $timestamp));
                                        ?>
                                    </td>


                                    <td><?php echo htmlspecialchars($row['Sanction']); ?></td>
                                    <td>
                                    <div class="button-group">
                                        <!-- Top Row -->
                                        <div class="top-row">
                                        <!-- In your loop for each row -->
                                        <button class="upload-btn" onclick="openModal(this)" data-student-id="<?php echo $row['id']; ?>" data-tooltip="Upload Evidence">
                                        <i class="fas fa-upload"></i>
                                        </button>
                                            <!-- Activate Violation -->
                                            <button class="activate-btn" onclick="toggleActiveViolation(this)" data-row-id="row-<?php echo $row['id']; ?>" data-tooltip="Activate Violation">
                                                <i class="fas fa-toggle-on"></i>
                                            </button>
                                        </div>
                                            <!-- Bottom Row: Edit and Archive Buttons -->
                                            <div class="bottom-row">
                                            <!-- Edit Button -->
                                            <button class="edit" onclick="editRow(<?php echo $row['id']; ?>)" data-tooltip="Edit Row">
                                                <i class="fas fa-pencil-alt"></i>
                                            </button>
                                            <!-- Archive Button -->
                                            <button class="archive" onclick="openArchiveModal(<?php echo $row['id']; ?>)" data-tooltip="Archive Row">
                                                <i class="fa-solid fa-folder-plus"></i>
                                            </button>

                                            </div>
                                        </div>
                                    </td>


                                </tr>
                                <?php
                            }
                        } else {
                            echo "<tr><td colspan='11' style='text-align:center;'>No records found</td></tr>";
                        }
                        ?>
                            <tr id="noRecords" style="display:none;">
                                <td colspan="11" style="text-align:center;">No records found</td>
                            </tr>
                        </tbody>
                    </table>

                    <button id="printPdfButton" class="print-pdf" onclick="printTableToPDF()">
                        <i class='bx bx-printer'></i>
                    </button>
                    <button class="add" id="addButton" onclick="document.getElementById('addModal').style.display='block'">
                        <i class='bx bxs-add-to-queue'></i>
                    </button>

                    <button class="send" id="sendEmailButton" onclick="sendEmailToAllStudents()">
                    <i class='bx bx-mail-send'></i>
                </button>

                </div>
            </div>
        </div>
    </div>

    <div id="uploadModal" class="modal" style="display:none;">
  <div class="modal-content">
    <span onclick="closeModal()" style="float:right;cursor:pointer;">&times;</span>
    <h3>Upload Evidence</h3>
    <input type="file" id="evidenceInput" accept="image/*" onchange="previewImage(event)">
    <br><br>
    <img id="imagePreview" src="" style="max-width: 100%; display:none;" alt="Preview">
    <br><br>
    <button id="deleteBtn" style="display:none;" onclick="deleteImage()">Delete Image</button>
  </div>
</div>




    <div id="addModal">
            <div id="modalContent">
                <span class="close" onclick="document.getElementById('addModal').style.display='none'">&times;</span>
                <form id="addForm" action="add_record.php" method="post">
                    <label for="studentId">Student ID:</label>
                    <input type="text" id="studentId" name="studentId" required>

                    <label for="name">Student Name:</label>
                    <input type="text" id="name" name="name" required>

                    <label for="program">Department</label>
                        <select id="program" name="program" required>
                            <option value="">-- Select --</option>
                            <option value="CCS">CCS</option>
                            <option value="CAS">CAS</option>
                            <option value="CBA">CBA</option>
                            <option value="CON">CON</option>
                            <option value="COE">COE</option>
                            <option value="COED">COED</option>
                            <option value="CIHM">CIHM</option>
                        </select>

                    <label for="course">Program</label>
                        <select id="course" name="course" required>
                            <option value="">-- Select --</option>
                        </select>



                    <label for="violation">Violation:</label>
                    <select id="violation" name="violation" required>
                    <optgroup label="Major Offense Violations">
                            <option value="Cheating">Cheating</option>
                            <option value="Forgery & Plagiarism">Forgery & Plagiarism</option>
                            <option value="False Representation">False Representation</option>
                            <option value="Defamation">Defamation</option>
                            <option value="Substance Influence">Substance Influence</option>
                            <option value="Unauthorized Entry">Unauthorized Entry</option>
                            <option value="Theft">Theft</option>
                            <option value="Drug Possession/Use">Drug Possession/Use</option>
                            <option value="Insubordination">Insubordination</option>
                            <option value="Physical Injury">Physical Injury</option>
                            <option value="Threats & Bullying">Threats & Bullying</option>
                            <option value="Gambling">Gambling</option>
                            <option value="Hazing">Hazing</option>
                            <option value="Unauthorized Name Use">Unauthorized Name Use</option>
                            <option value="Financial Misconduct">Financial Misconduct</option>
                            <option value="Unauthorized Sales">Unauthorized Sales</option>
                            <option value="Extortion">Extortion</option>
                            <option value="Vandalism">Vandalism</option>
                            <option value="Degrading Treatment">Degrading Treatment</option>
                            <option value="Deadly Weapons">Deadly Weapons</option>
                            <option value="Abusive Behavior">Abusive Behavior</option>
                        </optgroup>
                        <optgroup label="Minor Offense Violations">
                            <option value="Policy Violation">Policy Violation</option>
                            <option value="Violating dress protocol">Violating dress protocol</option>
                            <option value="Incomplete uniform">Incomplete uniform</option>
                            <option value="Littering">Littering</option>
                            <option value="Loitering in hallways">Loitering in hallways</option>
                            <option value="Class disturbance">Class disturbance</option>
                            <option value="Shouting">Shouting</option>
                            <option value="Eating in class">Eating in class</option>
                            <option value="Public affection">Public affection</option>
                            <option value="Kissing">Kissing</option>
                            <option value="Suggestive poses">Suggestive poses</option>
                            <option value="Inappropriate touching">Inappropriate touching</option>
                            <option value="No ID card">No ID card</option>
                            <option value="Using others' ID">Using others' ID</option>
                            <option value="Caps indoors">Caps indoors</option>
                            <option value="Noise in quiet areas">Noise in quiet areas</option>
                            <option value="Discourtesy">Discourtesy</option>
                            <option value="Malicious calls">Malicious calls</option>
                            <option value="Refusing ID check">Refusing ID check</option>
                            <option value="Blocking passageways">Blocking passageways</option>
                            <option value="Unauthorized charging">Unauthorized charging</option>
                            <option value="Academic non-compliance">Academic non-compliance</option>
                        </optgroup>
                    </select>

                    <label for="offense">Offense:</label>
                    <input type="text" id="offense" name="offense" readonly required>


                    <label for="status">Status:</label>
                    <input type="text" id="status" name="status" required>

                    <label for="personnel">Personnel:</label>
                    <input type="text" id="personnel" name="personnel" required>

                    <label for="sanction">Sanction:</label>
                    <input type="text" id="sanction" name="sanction" readonly required>


                    <label for="date">Date:</label>
                    <input type="date" id="date" name="date" required>

                    <label for="time">Time:</label>
                    <input type="time" id="time" name="time" required>

                    <button type="submit" class="submit-btn">Submit</button>
                </form>
            </div>
        </div>

<!-- Archive Modal -->
<div id="archiveModal" class="modal" style="display:none;">
  <div class="modal-content">
    <span class="close" onclick="closeArchiveModal()">&times;</span>
    <h3>Archive Violation</h3>
    <form id="archiveForm" method="POST" action="transfer_student.php" enctype="multipart/form-data">
      <input type="hidden" name="student_id" id="modalStudentId">

      <label for="date_accomplished">Date Accomplished:</label>
      <input type="date" name="date_accomplished" id="dateAccomplished" required>

      <!-- Upload from Archive Modal -->
      <label for="proof">Upload Additional Proof:</label>
      <input type="file" name="proof" id="proof" accept="image/*" required>

      <!-- Hidden image from Upload Modal -->
      <input type="hidden" name="evidence_base64" id="evidenceBase64">
      <img id="archiveImagePreview" src="" style="max-width: 100%; display: none;" alt="Uploaded Proof">


      <br><br>
      <button type="submit">Submit</button>
    </form>
  </div>
</div>

    <script>
        function confirmLogout() {
            return confirm("Are you sure you want to log out?");
        }

        //Selection Process in add form by department and course
        document.getElementById('program').addEventListener('change', function () {
            const course = document.getElementById('course');
            const selectedProgram = this.value;
            
            // Clear existing options
            course.innerHTML = '';

            // Set options based on selected program
            if (selectedProgram === 'CCS') {
                const ccsOptions = ['BSCS', 'BSIT'];
                ccsOptions.forEach(option => {
                    const opt = document.createElement('option');
                    opt.value = option;
                    opt.innerHTML = option;
                    course.appendChild(opt);
                });
            } else if (selectedProgram === 'CAS') {
                const casOptions = ['AB Psych'];
                casOptions.forEach(option => {
                    const opt = document.createElement('option');
                    opt.value = option;
                    opt.innerHTML = option;
                    course.appendChild(opt);
                });
            

            } else if (selectedProgram ==='CBA') {
                const cbaOptions = ['BSBA', 'BSENT', 'BSA'];
                cbaOptions.forEach(option => {
                    const opt = document.createElement('option');
                    opt.value = option;
                    opt.innerHTML = option;
                    course.appendChild(opt);
                });
            } else if (selectedProgram === 'CON') {
                const conOptions = ['BSN'];
                conOptions.forEach(option => {
                    const opt = document.createElement('option');
                    opt.value = option;
                    opt.innerHTML = option;
                    course.appendChild(opt);
                });
            } else if (selectedProgram === 'COE') {
                const coeOptions = ['BSECE'];
                coeOptions.forEach(option => {
                    const opt = document.createElement('option');
                    opt.value = option;
                    opt.innerHTML = option;
                    course.appendChild(opt);
                });
            } else if (selectedProgram === 'COED') {
                const coedOptions = ['BEED', 'BSED'];
                coedOptions.forEach(option =>{
                    const opt = document.createElement('option');
                    opt.value = option;
                    opt.innerHTML = option;
                    course.appendChild(opt);
                });
            } else if (selectedProgram === 'CIHM') {
                const cihmOptions = ['BSHM'];
                cihmOptions.forEach(option => {
                    const opt = document.createElement('option');
                    opt.value = option;
                    opt.innerHTML = option;
                    course.appendChild(opt);
                });
            } else {
                const defaultOption = document.createElement('option');
                defaultOption.value = 'N/A';
                defaultOption.innerHTML = 'Not Applicable';
                course.appendChild(defaultOption);
            }
        });

        function openArchiveModal(id) {
  const confirmed = confirm("Has the student accomplished their sanction?");
  if (!confirmed) return;

  document.getElementById('modalStudentId').value = id;
  document.getElementById('archiveModal').style.display = 'flex';

  // Load saved image from localStorage
  const savedImage = localStorage.getItem(`evidenceImage_${id}`);
  document.getElementById('evidenceBase64').value = savedImage || '';

  // (Optional) Preview it
  const preview = document.getElementById('archiveImagePreview');
  if (preview && savedImage) {
    preview.src = savedImage;
    preview.style.display = 'block';
  }
}

function closeArchiveModal() {
  document.getElementById('archiveModal').style.display = 'none';
}

       

        function editRow(id) {
            // Confirm if the user wants to edit the specific student record
            const userConfirmed = confirm("Do you want to edit the data for this record?" + id);

            // If confirmed, redirect to the edit page with the specific ID
            if (userConfirmed) {
                const url = 'edit_record.php?id=' + id;
                window.location.href = url;
            }
        }


    // Listen for changes in the violation select
document.getElementById("violation").addEventListener("change", function() {
    const violationValue = this.value; // Get selected violation
    const offenseSelect = document.getElementById("offense");

    // Check if the violation is a major or minor offense based on the selection
    const majorOffenses = [
        "Cheating", "Forgery & Plagiarism", "False Representation", "Defamation", "Substance Influence", 
        "Unauthorized Entry", "Theft", "Drug Possession/Use", "Insubordination", "Physical Injury", 
        "Threats & Bullying", "Gambling", "Hazing", "Unauthorized Name Use", "Financial Misconduct", 
        "Unauthorized Sales", "Extortion", "Vandalism", "Degrading Treatment", "Deadly Weapons", "Abusive Behavior"
    ];

    // If the violation is a major offense, set the offense field to "Major"
    if (majorOffenses.includes(violationValue)) {
        offenseSelect.value = "Major"; // Automatically select Major
    } else {
        offenseSelect.value = "Minor"; // Automatically select Minor if not a major offense
    }
});


document.getElementById('status').addEventListener('input', updateSanction);
    document.getElementById('offense').addEventListener('change', updateSanction);

    function updateSanction() {
        const status = parseInt(document.getElementById('status').value);
        const offense = document.getElementById('offense').value;
        const sanctionInput = document.getElementById('sanction');

        let sanction = '';

        if (offense === 'Major') {
            if (status === 1) {
                sanction = 'Suspension for 60 days';
            } else if (status === 2) {
                sanction = 'Dismissal';
            } else if (status >= 3) {
                sanction = 'Expulsion';
            }
        } else if (offense === 'Minor') {
            if (status === 1) {
                sanction = 'Non-Compliance Slip + Apology Letter';
            } else if (status === 2) {
                sanction = 'Community Service + Counseling';
            }
        }

        sanctionInput.value = sanction;
    }

   


    // Your search script
    document.addEventListener("DOMContentLoaded", function () {
        const searchInput = document.getElementById("search"); // The search input
        const rows = document.querySelectorAll("#violationTable tbody tr"); // All rows in the table
        const noRecords = document.getElementById("noRecords"); // "No records found" row (hidden by default)

        // Listen for input in the search field
        searchInput.addEventListener("input", function () {
            const searchValue = this.value.toLowerCase(); // Get the input and make it lowercase
            let found = false; // To check if any row matches

            // Loop through each row in the table
            rows.forEach(row => {
                const rowText = row.innerText.toLowerCase(); // Get the row's text content and make it lowercase
                if (rowText.includes(searchValue)) {
                    row.style.display = ""; // If it matches, show the row
                    found = true;
                } else {
                    row.style.display = "none"; // If it doesn't match, hide the row
                }
            });

            // Handle "No records found" row
            if (searchValue && !found) {
                noRecords.style.display = ""; // Show if no results are found
            } else {
                noRecords.style.display = "none"; // Hide it when there are matches
            }
        });
    });




    function printTableToPDF() {
    const { jsPDF } = window.jspdf;
    const doc = new jsPDF();

    // Add a custom header
    doc.setFontSize(12); // Set smaller font size for the header
    doc.text("Student Violation Records (Active)", 105, 10, { align: "center" }); // Centered text at the top
    doc.setFontSize(8); // Set smaller font size for the date
    doc.text("Generated on: " + new Date().toLocaleDateString(), 105, 16, { align: "center" }); // Centered date below the main header

    // Add a margin for the header
    const marginTop = 20;

    // Select the table
    const table = document.getElementById("violationTable");

    // Extract headers (excluding the Actions column)
    const headers = Array.from(table.querySelectorAll("thead th"))
        .map(th => th.textContent.trim())
        .filter((_, index) => index !== table.querySelectorAll("thead th").length - 1); // Exclude "Actions"

    // Extract rows (excluding the Actions column)
    const rows = Array.from(table.querySelectorAll("tbody tr")).map(row =>
        Array.from(row.querySelectorAll("td"))
            .map(td => td.textContent.trim())
            .filter((_, index) => index !== row.querySelectorAll("td").length - 1) // Exclude "Actions"
    );

    // Generate the PDF with 30 rows per page
    doc.autoTable({
        head: [headers],
        body: rows,
        styles: { fontSize: 8, cellPadding: 2 }, // Smaller font and adjusted padding for readability
        margin: { top: marginTop, left: 10, right: 10 }, // Adjust margins
        pageBreak: 'auto', // Automatically paginate
        showHead: 'everyPage', // Show table headers on every page
        theme: 'grid', // Simple grid theme for readability
    });

    // Save the PDF
    doc.save("Student_Violation_Records.pdf");
}

    document.addEventListener("DOMContentLoaded", function () {
    const sortDropdown = document.getElementById("sortDropdown");
    const table = document.getElementById("violationTable");

    sortDropdown.addEventListener("change", function () {
        const sortType = this.value;

        // Match dropdown value to table column index
        let columnIndex;
        switch (sortType) {
            case "department":
                columnIndex = 2;
                break;
            case "name":
                columnIndex = 1;
                break;
            case "violation":
                columnIndex = 3;
                break;
            case "date":
                columnIndex = 6;
                break;
            default:
                return; // Do nothing if no valid option is selected
        }

        const tbody = table.querySelector("tbody");
        
        // Always get FRESH visible rows
        const rows = Array.from(tbody.querySelectorAll("tr"));
        const visibleRows = rows.filter(row => row.style.display !== "none");

        // Sort visible rows
        visibleRows.sort((a, b) => {
            const aText = a.querySelectorAll("td")[columnIndex]?.innerText.trim() || "";
            const bText = b.querySelectorAll("td")[columnIndex]?.innerText.trim() || "";

            if (sortType === "date") {
                return new Date(bText) - new Date(aText); // 🔁 DESCENDING
            } else {
                return aText.localeCompare(bText);
            }
        });


        // Remove ALL rows (visible and hidden)
        rows.forEach(row => tbody.removeChild(row));

        // Re-append sorted visible rows
        visibleRows.forEach(row => tbody.appendChild(row));

        // Then re-append hidden rows (still hidden)
        const hiddenRows = rows.filter(row => row.style.display === "none");
        hiddenRows.forEach(row => tbody.appendChild(row));
    });
});

function toggleActiveViolation(button) {
    const rowId = button.getAttribute('data-row-id');
    const row = document.getElementById(rowId);

    // Toggle highlight and tooltip
    if (row.classList.contains('highlighted')) {
        row.classList.remove('highlighted');
        removeActiveRow(rowId);
        button.setAttribute('data-tooltip', 'Activate Violation');
    } else {
        row.classList.add('highlighted');
        saveActiveRow(rowId);
        button.setAttribute('data-tooltip', 'Deactivate Violation');
    }
}


// Save to localStorage
function saveActiveRow(rowId) {
    let activeRows = JSON.parse(localStorage.getItem('activeRows')) || [];
    if (!activeRows.includes(rowId)) {
        activeRows.push(rowId);
        localStorage.setItem('activeRows', JSON.stringify(activeRows));
    }
}

// Remove from localStorage
function removeActiveRow(rowId) {
    let activeRows = JSON.parse(localStorage.getItem('activeRows')) || [];
    activeRows = activeRows.filter(id => id !== rowId);
    localStorage.setItem('activeRows', JSON.stringify(activeRows));
}

document.addEventListener('DOMContentLoaded', function () {
    let activeRows = JSON.parse(localStorage.getItem('activeRows')) || [];
    activeRows.forEach(rowId => {
        const row = document.getElementById(rowId);
        if (row) {
            row.classList.add('highlighted');

            // Also update the tooltip text on load
            const button = document.querySelector(`button[data-row-id="${rowId}"]`);
            if (button) {
                button.setAttribute('data-tooltip', 'Deactivate Violation');
            }
        }
    });
});



    function sendEmail(userId) {
        fetch('send_email.php?id=' + userId)
            .then(response => response.text())
            .then(data => alert(data))
            .catch(error => console.error('Error:', error));
    }

    function sendEmailToAllStudents() {
            if (confirm("Send email to all students?")) {
                fetch("send_email_all.php", {
                    method: "POST"
                })
                    .then(response => response.text())
                    .then(data => alert(data))
                    .catch(error => alert("Error: " + error));
            }
        }



        let currentStudentId = null;

        function openModal(button) {
  currentStudentId = button.getAttribute('data-student-id');
  document.getElementById('uploadModal').style.display = 'flex';

  const savedImage = localStorage.getItem(`evidenceImage_${currentStudentId}`);
  const img = document.getElementById('imagePreview');

  if (savedImage) {
    img.src = savedImage;
    img.style.display = 'block';
    document.getElementById('deleteBtn').style.display = 'inline-block';
  } else {
    img.src = '';
    img.style.display = 'none';
    document.getElementById('deleteBtn').style.display = 'none';
  }

  document.getElementById('evidenceInput').value = '';
}

function closeModal() {
  document.getElementById('uploadModal').style.display = 'none';
}

function previewImage(event) {
  const file = event.target.files[0];
  if (file && currentStudentId) {
    const reader = new FileReader();
    reader.onload = function(e) {
      const img = document.getElementById('imagePreview');
      img.src = e.target.result;
      img.style.display = 'block';
      document.getElementById('deleteBtn').style.display = 'inline-block';

      localStorage.setItem(`evidenceImage_${currentStudentId}`, e.target.result);
    };
    reader.readAsDataURL(file);
  }
}

function deleteImage() {
  const img = document.getElementById('imagePreview');
  img.src = '';
  img.style.display = 'none';
  document.getElementById('evidenceInput').value = '';
  document.getElementById('deleteBtn').style.display = 'none';

  if (currentStudentId) {
    localStorage.removeItem(`evidenceImage_${currentStudentId}`);
  }
}

// Change tooltip on hover
document.querySelectorAll('.upload-btn').forEach(button => {
  button.addEventListener('mouseenter', function () {
    const studentId = this.getAttribute('data-student-id');
    const hasImage = localStorage.getItem(`evidenceImage_${studentId}`);
    this.setAttribute('data-tooltip', hasImage ? 'View Image' : 'Upload Evidence');
  });
});





</script>
</body>
</html>
