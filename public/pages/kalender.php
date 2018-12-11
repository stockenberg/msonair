
<div class="small-12 medium-12 large-12 columns">
    <?php include "includes/backend/nav.inc.php"; ?>
    <?php if (\src\core\Session::getStatus() == __STUDENT__) : ?>
        <?php if(\src\core\Session::get("logged_user", 0, "user_skill") != __HEAVYTONES__) : ?>
        <h5 id="details">Verfügbare Unterrichtseinheiten: </h5>
        <p class="note">Eine Unterrichtseinheit beträgt 60 Minuten.</p>
        <?php endif; ?>
        <p class="note">
            Um einen Termin zu vereinbaren, klickst du einfach auf einen Kalendereintrag, der mehr als 48 Stunden in der
            Zukunft liegt.
            Wenn du mit deiner Auswahl nicht zufrieden bist, klicke erneut auf den gebuchten Eintrag und lösche den
            Termin.
        </p>

    <?php endif; ?>
    <?php if (\src\core\Session::getStatus() == __TEACHER__) : ?>
        <p class="note">
            Um eine verfügbare Unterrichtszeiten einzutragen, klicke einfach am gewünschten Tag auf eine Zeit. Wenn du größere Zeitfenster aufziehst, werden diese beim nächsten Klick automatisch in Unterrichtseinheiten unterteilt. Beachte dabei, dass der gewählte Eintrag mehr als 48 Stunden in der Zukunft liegen muss. Durch nochmaliges Anklicken wird der Unterrichtsslot wieder gelöscht.<br/>
        </p>
    <?php endif; ?>

    <div class="calendarbox">
        <h3>Kalender</h3>
    </div>
    <div id='cal'></div>

</div>
