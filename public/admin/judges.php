<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../includes/functions.php';

$judges = getJudges();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $judgeCode = $_POST['judge_code'];
    $displayName = $_POST['display_name'];
    
    $stmt = $pdo->prepare("INSERT INTO judges (judge_code, display_name) VALUES (?, ?)");
    if ($stmt->execute([$judgeCode, $displayName])) {
        $message = "Judge added successfully!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Judges</title>
    <link href="/assets/css/style.css" rel="stylesheet">
</head>
<body>
    <h1>Manage Judges</h1>
    
    <?php if (isset($message)): ?>
        <div class="alert"><?= $message ?></div>
    <?php endif; ?>
    
    <form method="POST">
        <input type="text" name="judge_code" placeholder="Judge Code" required>
        <input type="text" name="display_name" placeholder="Display Name" required>
        <button type="submit">Add Judge</button>
    </form>
    
    <h2>Current Judges</h2>
    <ul>
        <?php foreach ($judges as $judge): ?>
            <li><?= $judge['judge_code'] ?> - <?= $judge['display_name'] ?></li>
        <?php endforeach; ?>
    </ul>
</body>
</html>
