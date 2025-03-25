<?php
session_start();
require_once($_SERVER['DOCUMENT_ROOT'].'/StyleVerse/config/config.php');

$userId = $_SESSION['id'] ?? null;
if (!$userId) {
    echo json_encode([]); // no user logged in
    exit;
}

$stmt = $pdo->prepare("SELECT user_message, bot_reply, created_at FROM chat_logs WHERE user_id = ? ORDER BY created_at ASC");
$stmt->execute([$userId]);
$chats = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($chats);
