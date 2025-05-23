<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../includes/functions.php';

$scoreboard = getScoreboard();

if (empty($scoreboard)) {
    die("No scoreboard data found. Please check if participants and scores exist in database.");
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Competition Scoreboard</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        tr:nth-child(even) { background-color: #f9f9f9; }
    </style>
</head>
<body>
    <h1>Live Scoreboard</h1>
    
    <table>
        <tr>
            <th>Rank</th>
            <th>Participant</th>
            <th>Total Score</th>
            <th>Average</th>
            <th># of Scores</th>
        </tr>
        <?php foreach ($scoreboard as $index => $entry): ?>
        <tr>
            <td><?= $index + 1 ?></td>
            <td><?= htmlspecialchars($entry['display_name']) ?></td>
            <td><?= number_format($entry['total_score'], 2) ?></td>
            <td><?= number_format($entry['avg_score'], 2) ?></td>
            <td><?= $entry['score_count'] ?></td>
        </tr>
        <?php endforeach; ?>
    </table>

    <script>
    // Auto-refresh every 30 seconds
    setTimeout(() => location.reload(), 30000);
    </script>
</body>
</html>
