<style>
<?php include 'styles.css'; ?>
</style>
<?php
$id = get_user_id();
$db = getDB();
    $per_page = 10;
    $query = "SELECT count(1) as total FROM Scores where id = :uid";
    
    paginate($query, [":uid"=>get_user_id()], $per_page);
    $params = [":uid"=>get_user_id(), ":offset"=>$offset, ":count"=>$per_page];
    
    $stmt =$db->prepare("SELECT score, created from Scores where user_id = :uid ORDER BY score desc LIMIT :offset, :count");
    
    foreach ($params as $key => $value){
        $type = is_int($value) ? PDO::PARAM_INT : PDO::PARAM_STR;
        $stmt->bindValue($key, $value, $type);
      }
    $params = null;

    $db = getDB();
      
    $stmt->execute($params);
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    
    $db = getDB();
    $per_page = 10;
    $query = "SELECT count(1) as total FROM Scores where id = :uid";
    
    paginate($query, [":uid"=>get_user_id()], $per_page);
    $params = [":uid"=>get_user_id(), ":offset"=>$offset, ":count"=>$per_page];
    
    $stmt =$db->prepare("SELECT score, created from Scores where user_id = :uid ORDER BY created desc LIMIT :offset, :count");
    
    foreach ($params as $key => $value){
        $type = is_int($value) ? PDO::PARAM_INT : PDO::PARAM_STR;
        $stmt->bindValue($key, $value, $type);
      }
    $params = null;

    $db = getDB();
      
    $stmt->execute($params);
    $results2 = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>
<table>
    <tr>
    <td id = 'top'>        
    <h2 >Top 10 scores</h2>
        <?php
            if (!$results || count($results) == 0) : ?>
                <div id = scores>
                <li>
                    <td colspan="100%">No scores available</td>
                </li>
            <?php else : ?>
                <?php foreach ($results as $result) : ?>
                    <ul>
                            <li>Score : <?php se($result, "score"); ?> </li>
                            <li>Date: <?php se($result, "created"); ?> </li>
                        </ul>
                    <?php endforeach; ?>
        <?php endif; ?>
    </td>
    <td id = 'recent'>
    <h2>Most recent scores</h2>
        <?php
            if (!$results2 || count($results2) == 0) : ?>
                <li>
                    <td colspan="100%">No scores available</td>
                </li>
            <?php else : ?>  
                <?php foreach ($results2 as $result2) : ?>
                        <ul>
                        <li>Score : <?php se($result2, "score"); ?> </li>
                            <li>Date: <?php se($result2, "created"); ?></li>
                        </ul>
                    <?php endforeach; ?>
                </div>
        
        </td>        <?php endif; ?>
    </tr>
    </table>
