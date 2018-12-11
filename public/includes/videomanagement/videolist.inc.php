<div class="row">
    <table class="small-12 medium-12 large-12 videotable">
        <thead>
            <tr>
                <th class="note">ID</th>
                <th class="note">Titel</th>
                <th class="note">Freigeschaltet</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach(\src\helpers\Helper::getAjaxData("unlocked_videos") as $row => $video) : ?>
            <tr>
                <td>[<?= $video["id"] ?>]</td>
                <td><?= $video["title"] ?></td>
                <td>
                    <label class="switch">
                        <input type="checkbox"
                               data-unlocked="<?= $video["unlocked"] ?>"
                               data-videoid="<?= $video["id"] ?>"
                               data-userid="<?= \src\helpers\Helper::getAjaxData("user_id") ?>"
                               onchange="unlock(this)" <?= ($video["unlocked"] == "TRUE") ? "checked" : "" ?>>
                        <div class="slider"></div>
                    </label>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>