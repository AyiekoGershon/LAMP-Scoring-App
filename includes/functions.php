<?php
require_once __DIR__ . '/../config/database.php';

function getJudges() {
    global $pdo;
    return $pdo->query("SELECT * FROM judges WHERE is_active = TRUE")->fetchAll();
}

function getParticipants() {
    global $pdo;
    return $pdo->query("SELECT * FROM participants WHERE is_active = TRUE")->fetchAll();
}

function submitScore($judgeId, $participantId, $score, $notes = null) {
    global $pdo;
    $stmt = $pdo->prepare("INSERT INTO scores (judge_id, participant_id, score, notes) VALUES (?, ?, ?, ?)");
    return $stmt->execute([$judgeId, $participantId, $score, $notes]);
}

function getScoreboard() {
    global $pdo;
    return $pdo->query("
        SELECT p.id, p.display_name, 
               COUNT(s.score) as score_count,
               AVG(s.score) as avg_score,
               SUM(s.score) as total_score
        FROM participants p
        LEFT JOIN scores s ON p.id = s.participant_id
        GROUP BY p.id
        ORDER BY total_score DESC
    ")->fetchAll();
}
?>
