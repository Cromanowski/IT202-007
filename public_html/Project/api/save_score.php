<?php
require_once(__DIR__ . "/../../../lib/functions.php");
session_start();
$user_id = get_user_id();
$score = se($_POST, "score", 0, false);
error_log($score);
error_log($user_id);
if ($user_id <= 0) {
    error_log("User not logged in");
    http_response_code(403);
}
else{
    $db = getDB();
    $stmt = $db->prepare("INSERT INTO Scores (score, user_id) VALUES(:score, :id)");
    $stmt->execute([":score" => $score, ":id" => $user_id]);
}

?>