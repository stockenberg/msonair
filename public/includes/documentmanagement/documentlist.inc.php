<div class="row">
    <table class="small-12 medium-12 large-12 videotable">
        <thead>
        <tr class="row">
            <th class="note small-12 medium-12 large-6">Titel</th>
            <th class="note small-12 medium-12 large-4">Freigeschalten</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach(\src\helpers\Helper::getAjaxData("unlocked_files") as $row => $file) : ?>
            <tr class="row">
                <td class="small-12 medium-12 large-6"><a target="_blank" href="<?= __ASSETS__ ?>/files/<?= $file["title"] ?>"><?= $file["title"] ?></a></td>
                <td class="small-12 medium-12 large-4">
                    <label class="switch">
                        <input type="checkbox"
                               data-unlocked="<?= $file["unlocked"] ?>"
                               data-fileid="<?= $file["id"] ?>"
                               data-userid="<?= \src\helpers\Helper::getAjaxData("user_id") ?>"
                               onchange="unlock(this)" <?= ($file["unlocked"] == "TRUE") ? "checked" : "" ?>>
                        <div class="slider"></div>
                    </label>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>