<?php
require_once(__DIR__ . "/../../partials/nav.php");
is_logged_in(true);
$db = getDB();
//handle join
if (isset($_POST["join"])) {
    $user_id = get_user_id();
    $comp_id = se($_POST, "comp_id", 0, false);
    $cost = se($_POST, "join_cost", 0, false);
    join_competition($comp_id, $user_id, $cost);
}
$id = se($_GET, "id", -1, false);
var_export($id);
if ($id < 1) {
    flash("Invalid competition", "danger");
    redirect("list_competitions.php");
}
$per_page = 5;
paginate("SELECT count(1) as total FROM Competitions WHERE expires > current_timestamp() AND paid_out < 1");
//handle page load
$stmt = $db->prepare("SELECT Competitions.id, comp_name, min_participants, current_participants, reward, duration, min_score, join_fee, expires,
CONCAT(first_place_per,'% - ', second_place_per, '% - ', third_place_per, '%') as place FROM Competitions WHERE id = :cid ORDER BY duration desc");
$row = [];
$comp = "";
try {
    $stmt->execute([":cid" => $id]);
    $r = $stmt->fetch();
    if ($r) {
        $row = $r;
        $comp = se($r, "title", "", false);
    }
} catch (PDOException $e) {
    flash("There was a problem fetching competitions, please try again later", "danger");
    error_log("List competitions error: " . var_export($e, true));
}
?>
<div class="container-fluid">
    <h1>View Competition: <?php se($comp); ?></h1>
    <table class="table text-light">
        <thead>
            <th>Title</th>
            <th>Participants</th>
            <th>Reward</th>
            <th>Min Score</th>
            <th>Expires</th>
            <th>Actions</th>
        </thead>
        <tbody>
            <?php if (count($row) > 0) : ?>
                <td><?php se($row, "title"); ?></td>
                <td><?php se($row, "current_participants"); ?>/<?php se($row, "min_participants"); ?></td>
                <td><?php se($row, "current_reward"); ?><br>Payout: <?php se($row, "place", "-"); ?></td>
                <td><?php se($row, "min_score"); ?></td>
                <td><?php se($row, "expires", "-"); ?></td>
                <td>
                    <?php if (se($row, "joined", 0, false)) : ?>
                        <button class="btn btn-primary disabled" onclick="event.preventDefault()" disabled>Already Joined</button>
                    <?php else : ?>
                        <form method="POST">
                            <input type="hidden" name="comp_id" value="<?php se($row, 'id'); ?>" />
                            <input type="hidden" name="cost" value="<?php se($row, 'join_cost', 0); ?>" />
                            <input type="submit" name="join" class="btn btn-primary" value="Join (Cost: <?php se($row, "join_cost", 0) ?>)" />
                        </form>
                    <?php endif; ?>
                </td>
            <?php else : ?>
                <tr>
                    <td colspan="100%">No active competitins</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
    <?php
    $title = $comp . " Top Scores";
    $scores = get_top_scores_for_comp($id, 10);
    ?>
    <div class="container-fluid">
    <h1>Leaderboard: </h1>
    <table class="table text-light">
        <thead>
            <th>User ID</th>
            <th>Score</th>
            <th>Created</th>
            <th>Username</th>
        </thead>
        <?php foreach ($scores as $row) : ?>
        <tbody>
                <td><?php se($row, "user_id"); ?></td>
                <td><?php se($row, "score"); ?></td>
                <td><?php se($row, "created"); ?></td>
                <td><?php se($row, "username"); ?></td>              
        </tbody>
        <?php endforeach; ?>
    </table>
</div>