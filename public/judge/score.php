<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../includes/functions.php';

$judgeId = 1; // Hardcoded for demo
$participants = getParticipants();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $participantId = $_POST['participant_id'];
    $score = $_POST['score'];
    
    if (submitScore($judgeId, $participantId, $score)) {
        $message = "Score submitted!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Submit Scores</title>
    <link href="/assets/css/style.css" rel="stylesheet">
</head>
<body>
    <h1>Submit Scores</h1>
    
    <?php if (isset($message)): ?>
        <div class="alert"><?= $message ?></div>
    <?php endif; ?>
    
    <form method="POST">
        <select name="participant_id" required>
            <?php foreach ($participants as $p): ?>
                <option value="<?= $p['id'] ?>"><?= $p['display_name'] ?></option>
            <?php endforeach; ?>
        </select>
        
        <input type="number" name="score" min="0" max="100" step="0.1" required>
        <button type="submit">Submit Score</button>
    </form>
</body>
</html>
