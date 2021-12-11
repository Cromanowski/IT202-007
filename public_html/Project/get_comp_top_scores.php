<?php
//snippet from functions.php
function get_top_scores_for_comp($comp_id, $limit = 10)
{
    $db = getDB();
    $stmt = $db->prepare("SELECT * FROM (SELECT s.user_id, s.score, s.created, a.id as account_id OVER (PARTITION BY s.user_id ORDER BY s.score desc) as `rank` FROM Scores s
    JOIN UserComps uc on uc.user_id = s.user_id
    JOIN Competitions c on uc.competition_id = c.id
    JOIN Users a on a.user_id = s.user_id
    WHERE c.id = :cid AND s.created BETWEEN uc.created AND c.expires
    )as t where `rank` = 1 ORDER BY score desc LIMIT :limit");
    $scores = [];
    try {
        $stmt->bindValue(":cid", $comp_id, PDO::PARAM_INT);
        $stmt->bindValue(":limit", $limit, PDO::PARAM_INT);
        $stmt->execute();
        $r = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if ($r) {
            $scores = $r;
        }
    } catch (PDOException $e) {
        flash("There was a problem fetching scores, please try again later", "danger");
        error_log("List competition scores error: " . var_export($e, true));
    }
    return $scores;
}