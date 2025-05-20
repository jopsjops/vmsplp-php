<?php
include 'dbconnection.php'; // Ensure this connects to violationsdb

// Get distinct users and event types
$users = [];
$eventTypes = [];

$userResult = $conn->query("SELECT DISTINCT username FROM audit_trail ORDER BY username");
while ($row = $userResult->fetch_assoc()) {
    $users[] = $row['username'];
}

$eventResult = $conn->query("SELECT DISTINCT event_type FROM audit_trail ORDER BY event_type");
while ($row = $eventResult->fetch_assoc()) {
    $eventTypes[] = $row['event_type'];
}

// Get all logs
$logsResult = $conn->query("SELECT username, action, message, event_type, timestamp FROM audit_trail ORDER BY timestamp DESC");
$logs = $logsResult ? $logsResult->fetch_all(MYSQLI_ASSOC) : [];

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Audit Trail</title>
  <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f7f9fc;
      padding: 40px;
    }
    .audit-container {
      background: #fff;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.05);
    }
    .audit-header {
      font-size: 24px;
      margin-bottom: 5px;
    }
    .audit-subheader {
      font-size: 14px;
      color: #777;
      margin-bottom: 20px;
    }
    .filters {
      display: flex;
      gap: 10px;
      margin-bottom: 20px;
    }
    select {
      padding: 8px 12px;
      border-radius: 6px;
      border: 1px solid #ccc;
    }
    table {
      width: 100%;
      border-collapse: collapse;
    }
    th {
      text-align: left;
      font-weight: 600;
      font-size: 14px;
      color: #555;
      border-bottom: 2px solid #ddd;
      padding: 12px;
    }
    td {
      padding: 12px;
      font-size: 14px;
      border-bottom: 1px solid #eee;
    }
    .view-link {
      color: #007bff;
      text-decoration: none;
    }
    .view-link:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>

<div class="audit-container">
  <div class="audit-header">Audit Trail</div>

  <div class="filters">
    <label>
      <select id="userFilter">
        <option value="all">User: All</option>
        <?php foreach ($users as $user): ?>
          <option value="<?= htmlspecialchars($user) ?>"><?= htmlspecialchars($user) ?></option>
        <?php endforeach; ?>
      </select>
    </label>
    <label>
      <select id="eventFilter">
        <option value="all">Event Type: All</option>
        <?php foreach ($eventTypes as $event): ?>
          <option value="<?= htmlspecialchars($event) ?>"><?= htmlspecialchars($event) ?></option>
        <?php endforeach; ?>
      </select>
    </label>
  </div>

  <table id="auditTable">
    <thead>
      <tr>
        <th>Date & Time</th>
        <th>User</th>
        <th>Message</th>
        <th>Event Type</th>
        <th></th>
      </tr>
    </thead>
    <tbody>
      <?php if (!empty($logs)): ?>
        <?php foreach ($logs as $log): ?>
          <tr>
            <td><?= htmlspecialchars($log['timestamp']) ?></td>
            <td><?= htmlspecialchars($log['username']) ?></td>
            <td><?= htmlspecialchars($log['message']) ?></td>
            <td><?= htmlspecialchars($log['event_type']) ?></td>
            <td></td>
          </tr>
        <?php endforeach; ?>
      <?php else: ?>
        <tr><td colspan="5">No audit records found.</td></tr>
      <?php endif; ?>
    </tbody>
  </table>
</div>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    const userFilter = document.getElementById('userFilter');
    const eventFilter = document.getElementById('eventFilter');
    const rows = document.querySelectorAll('#auditTable tbody tr');

    function filterTable() {
      const selectedUser = userFilter.value;
      const selectedEvent = eventFilter.value;

      rows.forEach(row => {
        const user = row.children[1].textContent;
        const event = row.children[3].textContent;

        const showRow =
          (selectedUser === 'all' || user === selectedUser) &&
          (selectedEvent === 'all' || event === selectedEvent);

        row.style.display = showRow ? '' : 'none';
      });
    }

    userFilter.addEventListener('change', filterTable);
    eventFilter.addEventListener('change', filterTable);
  });
</script>

</body>
</html>
