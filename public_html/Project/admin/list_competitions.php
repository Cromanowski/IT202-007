<?php
require_once(__DIR__ . "../../../../partials/nav.php");
if (!has_role("Admin")) {
    flash("You don't have permission to view this page", "warning");
    redirect('home.php');
}
is_logged_in(true);
$db = getDB();

//handle page load
//TODO fix join
$per_page = 10;
    $query = "SELECT count(1) as total FROM UserComps where user_id = :uid";
    
    paginate($query, [":uid"=>get_user_id()], $per_page);
    $params = [":uid"=>get_user_id(), ":offset"=>$offset, ":count"=>$per_page];
    
    $stmt =$db->prepare("SELECT Competitions.id, comp_name, min_participants, current_participants, reward, duration, min_score, join_fee, expires,
    IF(comp_id is null, 0, 1) as joined,  CONCAT(first_place_per,'% - ', second_place_per, '% - ', third_place_per, '%') as place FROM Competitions
    LEFT JOIN (SELECT * FROM UserComps WHERE user_id = :uid) as uc ON uc.comp_id = Competitions.id WHERE expires > current_timestamp() AND paid_out < 1 
    ORDER BY duration desc LIMIT :offset, :count");
    
    foreach ($params as $key => $value){
        $type = is_int($value) ? PDO::PARAM_INT : PDO::PARAM_STR;
        $stmt->bindValue($key, $value, $type);
      }
    $params = null;

    $db = getDB();
      
    $stmt->execute($params);
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);


try {
    $stmt->execute([":uid" => get_user_id()]);
    $r = $stmt->fetchAll();
    if ($r) {   
        $results = $r;
    }
} catch (PDOException $e) {
    flash("There was a problem fetching competitions, please try again later", "danger");
    error_log("List competitions error: " . var_export($e, true));
}
?>
<div class="container-fluid">
    <h1>List Competitions</h1>
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
            <?php if (count($results) > 0) : ?>
                <?php foreach ($results as $row) : ?>
                    <tr>
                        <td><?php se($row, "comp_name"); ?> </td>
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
                                    <input type="hidden" name="cost" value="<?php se($row, 'join_fee', 0); ?>" />
                                </form>
                            <?php endif; ?>
                            <a class="btn btn-secondary" href="edit_competitions.php?id=<?php se($row, 'id'); ?>">Edit</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else : ?>
                <tr>
                    <td colspan="100%">No active competitions</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
<?php
require_once(__DIR__ . "../../pagination.php");