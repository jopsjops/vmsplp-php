<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

include 'dbconnection.php';

if ($conn->connect_error) {
    die(json_encode(["status" => "error", "message" => "Connection failed: " . $conn->connect_error]));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = file_get_contents('php://input');
    $data = json_decode($input, true);

    // Check required fields
    if (isset($data['studentId'], $data['studentName'], $data['department'], $data['program'], $data['violation'], $data['offense'], $data['personnelName'], $data['date'], $data['time'], $data['email'])) {
        
        $studentId = $data['studentId'];
        $studentName = $data['studentName'];
        $department = $data['department'];
        $program = $data['program'];
        $violation = $data['violation'];
        $offense = $data['offense'];
        $personnelName = $data['personnelName'];
        $date = $data['date'];
        $time = $data['time'];
        $email = $data['email'];

        // Get total violation count from both student_info and archive_info
        $stmt = $conn->prepare("
            SELECT COUNT(*) AS violation_count FROM (
                SELECT Student_ID FROM student_info WHERE Student_ID = ?
                UNION ALL
                SELECT Student_ID FROM archive_info WHERE Student_ID = ?
            ) AS combined
        ");
        $stmt->bind_param("ss", $studentId, $studentId);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $statusCount = intval($row['violation_count']) + 1;
        $stmt->close();

        $status = $statusCount . " Violation" . ($statusCount > 1 ? "s" : "");

        // Escalate Minor to Major if 3 or more total violations
        if ($offense === 'Minor' && $statusCount >= 3) {
            $offense = 'Major';
        }

        // Determine sanction based on offense and count
        $sanction = '';
        if ($offense === 'Major') {
            if ($statusCount === 1) {
                $sanction = 'Suspension for 60 days';
            } else if ($statusCount === 2) {
                $sanction = 'Dismissal';
            } else if ($statusCount >= 3) {
                $sanction = 'Expulsion';
            }
        } else if ($offense === 'Minor') {
            if ($statusCount === 1) {
                $sanction = 'Non-Compliance Slip + Apology Letter';
            } else if ($statusCount === 2) {
                $sanction = 'Community Service + Counseling';
            }
        }

        // Insert violation record
        $stmt = $conn->prepare("INSERT INTO student_info (Student_ID, Student_Name, Department, Program, Violation, Offense, Status, Personnel, Date, Time, Email, Sanction) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssssssssss", $studentId, $studentName, $department, $program, $violation, $offense, $status, $personnelName, $date, $time, $email, $sanction);

        if ($stmt->execute()) {
            echo json_encode([
                "status" => "success",
                "message" => "Violation recorded",
                "violationCount" => $status,
                "offense" => $offense,
                "sanction" => $sanction
            ]);
        } else {
            echo json_encode(["status" => "error", "message" => "Error: " . $stmt->error]);
        }

        $stmt->close();
    } else {
        echo json_encode(["status" => "error", "message" => "Required fields are missing"]);
    }
} else {
    http_response_code(405);
    echo json_encode(["status" => "error", "message" => "Method not allowed"]);
}

$conn->close();
?>
