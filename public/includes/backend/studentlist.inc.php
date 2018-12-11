<?php $optgrp = ["Gitarre", "Trompete", "Gesang", "Klavier", "Saxophon"] ?>
<form>
    <label for="studentSelect">Studentenwähler</label>
    <select onchange="__get(this, '<?= ($_GET["p"]) ?>')" name="studentSelect" id="studentSelect">
        <option value="" disabled selected>Bitte Studenten wählen:</option>
        <?php if(\src\core\Session::getStatus() == __ADMIN__)  : ?>
        <?php foreach ($optgrp as $instrument) : ?>
            <optgroup label="<?= $instrument ?>">
                <?php foreach ($this->global->studentlist as $row => $student) : ?>
                    <?php if (\src\helpers\Helper::translateIntresedIn($student["user_intrested_in"]) == $instrument) : ?>
                        <option class="value" value="<?= $student["user_id"] ?>">
                            <?= $student["user_lastname"] ?>, <?= $student["user_firstname"] ?></option>
                    <?php endif; ?>
                <?php endforeach; ?>
            </optgroup>
        <?php endforeach; ?>
        <?php else : ?>
            <?php foreach ($this->global->studentlist as $row => $student) : ?>
                <?php if ($student["user_intrested_in"] == \src\core\Session::get("logged_user", 0, "user_intrested_in")) : ?>
                    <option class="value" value="<?= $student["user_id"] ?>">
                        <?= $student["user_lastname"] ?>, <?= $student["user_firstname"] ?></option>
                <?php endif; ?>
            <?php endforeach; ?>
        <?php endif; ?>
    </select>
</form>