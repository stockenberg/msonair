<?php \src\helpers\Helper::checkRights(); ?>

<div class="small-12 medium-12 large-12 columns">
    <?php include "includes/backend/nav.inc.php"; ?>
    <h3>Dozenten verwalten</h3>

    <div class="row">
        <div class="documentpool small-12 medium-12 large-6 columns">
            <table class="small-12 medium-12 large-11">
                <thead>
                <tr>
                    <th class="note">Name</th>
                    <th class="note">Instrument</th>
                    <th class="note">Erstellt</th>
                    <th class="note">Edit</th>
                </tr>
                </thead>
                <tbody>
                <?php if(!empty($this->global->lecturers)) : ?>
                <?php foreach ($this->global->lecturers as $row => $lecturer) : ?>
                    <tr class="<?= $lecturer["user_id"] ?>">
                        <td class="small-5 medium-5 large-5 name"><?= $lecturer["user_lastname"] ?>,
                            <?= $lecturer["user_firstname"] ?></td>
                        <td class="small-4 medium-4 large-4"><?= \src\helpers\Helper::translateIntresedIn($lecturer["user_intrested_in"]) ?></td>
                        <td class="small-3 medium-3 large-3"><?= date("d.m.Y",
                                strtotime($lecturer["user_created"])) ?></td>
                        <td class="small-4 medium-4 large-4"><i class="right fa fa-gears"
                                                                onclick="getEdit(<?= $lecturer["user_id"] ?>);"></i>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
        <div class="upload small-12 medium-12 large-6 columns"
             style="padding: 30px; background: #eee; border-radius: 10px;">
            <h5>Neuen Dozenten anlegen</h5>
            <form id="UserDisplayForm" method="post">
                <fieldset>
                        <?php foreach ($this->global->lecturers[0] as $key => $data) : ?>
                            <?php if ($key !== "user_id" && $key != "user_package_id"
                                && $key != "user_lessoncount" && $key != "user_completed_payment"
                                && $key != "user_created" && $key != "user_password"): ?>
                                <div class='input text'>
                                    <label for="<?= $key ?>"><?= $this->global->labels[$key] ?></label>
                                    <input name='user[<?= $key ?>]' id="<?= $key ?>" type='text' />
                                </div>
                            <?php endif; ?>
                        <?php endforeach;  ?>
                </fieldset>
                <input type="submit" value="Speichern" name="user[submit]" class="button small-12 medium-12 large-12">
            </form>
        </div>
    </div>

</div>
