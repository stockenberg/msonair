<form id="UserDisplayForm" method="post">
    <fieldset>
    <?php foreach(\src\helpers\Helper::getAjaxData("user_edit")[0] as $key => $data) : ?>
        <div class='input text'>
            <label for="<?= $key ?>"><?= \src\helpers\Helper::getAjaxData("labels")[$key] ?></label>
            <input
                <?=
                ($key == "user_id" || $key == "user_intrested_in" || $key == "user_package_id")
                ? "disabled"
                : ""
                ?>
                onchange="changeData(this, <?= \src\helpers\Helper::getAjaxData("user_edit")[0]["user_id"] ?>)"
                name='user[<?= $key ?>]'
                value='<?= $data ?>'
                type='text'
                id='<?= $key ?>'>
        </div>
    <?php endforeach; ?>
    </fieldset>
</form>
