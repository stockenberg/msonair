<?php \src\helpers\Helper::checkRights(); ?>

<div class="small-12 medium-12 large-12 columns">
    <?php include "includes/backend/nav.inc.php"; ?>
    <h3>Kalender Verwalten</h3>
    <p class="note">Zieht im Kalender einen Terminslot auf, um ihn für die Buchung zur verfügung zustellen. Wenn ein
        Termin aufgezogen wurde, erscheint der Titel nicht gleich. Klickt dafür aus dem Kalender raus, dann wird der
        Titel angezeigt. Wenn bereits ein Termin an dem Tag und zur gleichen Zeit existiert, geht einfach in die
        Tagesansicht und erstellt den Termin in dem freien Bereich auf der rechten Seite.</p>
    <p class="note">Zum löschen eines Termins, klickt einfach auf den Termin der gelöscht werden soll.</p>

    <div class="row">
        <button class="colors filter all">Alle</button>
        <span style="text-decoration: none;">#</span>
        <button class="colors filter guitar">Gitarre</button>
        <button class="colors filter piano">Klavier</button>
        <button class="colors filter sax">Saxophon</button>
        <button class="colors filter trumpet">Trompete</button>
        <button class="colors filter voice">Gesang</button>
    </div>

    <div class="calendarbox">
        <h3>Kalender</h3>
    </div>
    <div id='cal'></div>


</div>
