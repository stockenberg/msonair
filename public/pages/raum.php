<div class="small-12 medium-12 large-12 columns">
    <?php include "includes/backend/nav.inc.php"; ?>
    <h3>Willkommen im Unterricht <a href="" style="display: none; font-size: 14px;" class="button tiny small-4 medium-4 large-4 gears" data-status="close">Video-Einstellungen</a></h3>
    <div class="small-12 medium-12 large-12 settings" style="display: none;">
        <h5>Audiogeräte</h5>
        <div class="inputs_audio"></div>
        <h5>Videogeräte</h5>
        <div class="inputs_video"></div>
        <br/><br/>
        <div class="reload">
            <button onclick="start();" class="button done">Einstellungen anwenden und Verbindung neu laden</button>
        </div>
    </div>
    <div class="small-12 medium-12 large-12" style="margin: 40px 0px;">
        <button onclick="start();" class="button start">Video Starten</button>
    </div>

    <div class="small-2 medium-2 large-2 columns room" style="display: none;">
        <video class="small-12 medium-12 large-12" id="localVideo"></video>
    </div>


    <div class="small-10 medium-10 large-10 columns room" style="display: none;">
        <div class="small-12 medium-12 large-12" id="remoteVideos"></div>
    </div>


</div>
<?php if (\src\core\Session::getStatus() == __STUDENT__) : ?>

    <div class="small-12 medium-12 large-12" style="margin-top: 10px;">
        <a href="<?= __BASE__ ?>?p=profile"
           class="button small-12 medium-12 large-12" onclick="return window.confirm('Willst du den Unterrichtsraum verlassen?')">Unterricht verlassen.</a>
    </div>

<?php endif; ?>
<?php if (\src\core\Session::getStatus() != __STUDENT__) : ?>

    <div class="small-12 medium-12 large-12" style="margin-top: 10px;">
        <a href="<?= __BASE__ ?>?p=raum&action=complete&raum=<?= $_GET["raum"] ?>&user=<?= $_GET["user"] ?>"
           class="button small-12 medium-12 large-12" onclick="return window.confirm('Bist du sicher?')">Stunde hat
            stattgefunden und kann abgerechnet werden.</a>
    </div>

<?php endif; ?>
