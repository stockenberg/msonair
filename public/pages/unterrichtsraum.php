<div class="small-12 medium-12 large-12 columns">
    <?php include "includes/backend/nav.inc.php"; ?>
    <h3>Deine nächsten Unterrichtstermine</h3>
    <?php if(\src\core\Session::getStatus() == __STUDENT__ ) :  ?>
    <p class="note">Sobald du im Kalender einen Unterrichtstermin bei deinem Dozenten
        vereinbart hast, findest du hier den Link zu eurem virtuellen Unterrichtsraum.</p>
    <?php elseif (\src\core\Session::getStatus() == __TEACHER__) : ?>
    <p class="note">
        Sobald ein Schüler einen Unterrichtstermin bei dir gebucht hat, findest du hier den Link zu eurem virtuellen Unterrichtsraum.
    </p>
    <?php endif; ?>
    <?php
    if (!empty($this->global->rooms)) :
        foreach ($this->global->rooms as $row => $room) :
            $name = (\src\core\Session::getStatus() == __TEACHER__
                || \src\core\Session::getStatus() == __ADMIN__)
                ? $room["user_firstname"] . " " . $room["user_lastname"]
                : $room["calendar_event_user_name"];
            ?>
            <div class="row">
                <a target="_blank" class="button small-12 medium-12 large-12"
                   href="<?= __BASE__ ?>?p=raum&raum=<?= $room["room_hash"] ?><?= (\src\core\Session::getStatus() === __STUDENT__) ? "&user=" . $room["user_id"] ?? "" : "" ?>">
                    <?= date("d.m.Y - H:i", strtotime($room["calendar_event_start"])) ?> Uhr
                    bis <?= date("H:i", strtotime($room["calendar_event_end"])) ?> Uhr
                    - mit <?= $name ?></a>
            </div>
        <?php endforeach;
    endif;
    ?>

</div>
