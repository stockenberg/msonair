<?php \src\helpers\Helper::checkRights(); ?>

<div class="small-12 medium-12 large-12 columns">
    <?php include "includes/backend/nav.inc.php"; ?>
    <h3>Alle Schüler</h3>

    <ul class="inline-list">
        <?php foreach ($this->students->letters as $key => $letter) : ?>
            <li><a href="#<?= $letter ?>" class="student-nav <?= $letter ?>"><?= $letter ?></a></li>
        <?php endforeach; ?>
    </ul>
    <?php foreach ($this->students->letters as $key => $letter) : ?>
        <div class="users <?= $letter ?>">
            <h4 class="letter" id="<?= $letter ?>"><?= $letter ?></h4>
            <ul>
                <?php foreach ($this->students->allStudents as $row => $student): ?>
                    <?php if (substr($student["user_lastname"], 0, 1) === $letter) : ?>
                        <li class="clearfix">[<?= $student["user_id"] ?>] - <strong><?= $student["user_lastname"] ?>,
                                <?= $student["user_firstname"] ?></strong> | Schüler
                            für: <?= \src\helpers\Helper::translateIntresedIn($student["user_intrested_in"]) ?> |
                            Stunden: <?= $student["user_lessoncount"] ?>
                            <i class="right fa fa-gears"></i>
                            <?= (\src\core\Session::getStatus() == __ADMIN__) ? '<button data-student-id="' . $student["user_id"] . '" data-action="student-delete" class="right hidden button tiny alert msonair_red">Löschen</button>' : "" ?>
                            <button data-student-id="<?= $student["user_id"] ?>" data-action="student-edit"
                                    class="right hidden button tiny" style="background: #ec971f;">Edit
                            </button>
                            <button data-student-id="<?= $student["user_id"] ?>" data-action="student-invoices"
                                    class="right hidden button tiny success">Alle Rechnungen
                            </button>
                        </li>
                    <?php endif; ?>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endforeach; ?>

</div>
