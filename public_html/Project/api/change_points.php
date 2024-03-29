<?php
require_once(__DIR__ . "/../../../lib/functions.php");
session_start();
$user_id = get_user_id();
$points = se($_POST, "points", 0, false);
$reason = se($_POST, "reason", 0, false);
error_log($points);
error_log($user_id);
if ($user_id <= 0) {
    error_log("User not logged in");
    http_response_code(403);
}
else{
    $db = getDB();
    $stmt = $db->prepare("INSERT INTO Points (user_id, point_change, reason) VALUES(:id, :point_change, :reason)");
    $stmt->execute([":point_change" => $points, ":id" => $user_id, ":reason" => $reason]);
    
    $stmt = $db->prepare("UPDATE Users SET points = (SELECT ifnull(SUM(point_change),0) FROM Points WHERE user_id = :id) where id = :id");
    $stmt->execute([":id" => $user_id]);
    
    $stmt = $db->prepare("SELECT points FROM Users WHERE user_id = :id");
    $points = $stmt->execute([":id" => $user_id]);
    $r = $stmt->fetch(PDO::FETCH_ASSOC);
    $_SESSION["user"]["points"] = (int)se($r, "points", 0, false);
}