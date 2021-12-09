<?php
require_once(__DIR__ . "/../../partials/nav.php");
is_logged_in(true);
$payout_options = ['34-33-33', '40-35-25', '50-30-20', '60-25-15', '70-20-10', '80-15-5', '100-0-0'];

//save

?>

<div class="container-fluid">
    <h1>Create Competition</h1>
    <form method="POST", id='create_comp'>
        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input id="title" name="title" class="form-control" />
        </div>
        <div class="mb-3">
            <label for="reward" class="form-label">Starting Reward</label>
            <input id="reward" type="number" name="starting_reward" class="form-control" onchange="updateCost()" placeholfr=">= 1" min="1" />
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
            <input id="jc" name="join_cost" type="number" class="form-control" onchange="updateCost()" placeholder=">= 0" min="0" />
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
            <input type="submit" value="Create Competition (Cost: 2)" class="btn btn-primary" />
        </div>
    </form>
    <script>
        function updateCost() {
            let starting = parseInt(document.getElementById("reward").value || 0) + 1;
            let join = parseInt(document.getElementById("jc").value || 0);
            if (join < 0) {
                join = 1;
            }
            let cost = starting + join;
            document.querySelector("[type=submit]").value = `Create Competition (Cost: ${cost})`;
        }
        $('#create_comp').submit(function() {
            $.post("api/create_competitions_api.php", {
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
            let starting = parseInt(document.getElementById("reward").value || 0) + 1;
            let join = parseInt(document.getElementById("jc").value || 0);
            if (join < 0) {
                join = 1;
            }
            let cost = starting + join;
            $.post("api/change_points.php", {
                points: cost * -1,
                reason: "Created competition"
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
            });
    </script>
</div>
<?php
?>