<?php \src\helpers\Helper::checkRights(); ?>

<div class="small-12 medium-12 large-12 columns">
    <?php include "includes/backend/nav.inc.php"; ?>
    <h3>Videoverwaltung</h3>
    <p class="note">Hier kannst du einen Studenten aus der Liste auswählen und ihm Videos freischalten.</p>


    <?php include "includes/backend/studentlist.inc.php"; ?>
    <h3>Freigeschaltete Videos</h3>

    <div id="result">

    </div>

</div>
