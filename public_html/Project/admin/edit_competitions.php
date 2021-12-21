<?php
require_once(__DIR__ . "../../../../partials/nav.php");
if (!has_role("Admin")) {
    flash("You don't have permission to view this page", "warning");
    redirect('home.php');
}

is_logged_in(true);
$payout_options = ['34-33-33', '40-35-25', '50-30-20', '60-25-15', '70-20-10', '80-15-5', '100-0-0'];

//save

$comp_id = se($_GET, "id", -1, false);
var_export($comp_id);
?>

<div class="container-fluid">
    <h1>Edit Competition</h1>
    <form method="POST", id='edit_comp'>
        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input id="title" name="title" class="form-control" />
        </div>
        <div class="mb-3">
            <label for="reward" class="form-label">Starting Reward</label>
            <input id="reward" type="number" name="starting_reward" class="form-control"  placeholfr=">= 1" min="1" />
        </div>
        <div class="mb-3">
            <label for="ms" class="form-label">Min. Score</label>
            <input id="ms" name="min_score" type="number" class="form-control" placeholder=">= 1" min="1" />
        </div>
        <div class="mb-3">
            <label for="mp" class="form-label">Min. Participants</label>
            <input id="mp" name="min_participants" type="number" class="form-control" placeholder=">= 3" min="3" />
        </div>
        <div class="mb-3">
            <label for="jc" class="form-label">Join Cost</label>
            <input id="jc" name="join_cost" type="number" class="form-control" placeholder=">= 0" min="0" />
        </div>
        <div class="mb-3">
            <label for="duration" class="form-label">Duration (in Days)</label>
            <input id="duration" name="duration" type="number" class="form-control" placeholder=">= 3" min="3" />
        </div>
        <div class="mb-3">
            <label for="po" class="form-label">Payout Option</label>
            <select id="po" name="payout_option" class="form-control">
                <?php foreach ($payout_options as $po) : ?>
                    <option value="<?php se($po, 'id'); ?>"><?php se($po, 'place'); ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-3">
            <input type="submit" value="Edit Competition" class="btn btn-primary" />
        </div>
    </form>
    <script>
        $('#edit_comp').submit(function() {
           console.log('It worked');
           event.preventDefault();
           $.post("../api/edit_competition_api.php", {
                 comp_id: <?php se($_GET, "id");?>,
                 title: this.title.value,
                 starting_reward: this.starting_reward.value,
                 min_score: this.min_score.value,
                 participants: this.min_participants.value,
                 fee: this.join_cost.value,
                 duration: this.duration.value,
                 payout_option: this.payout_option.value
               }, (resp, status, xhr) => {
                   console.log(resp, status, xhr);
                   let data = JSON.parse(resp);
                   flash(data.message, "success");
                   console.log("success");
               },
                (xhr, status, error) => {
                   console.log(xhr, status, error);
               }
           );
       }
       );
    </script>
</div>
