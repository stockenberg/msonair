<div class="small-12 medium-12 large-12 columns">
    <!-- Success         -->
    <section class="main row">
        <div id="firstStop" class="mainHeader small-12 medium-12 large-12 columns">
            <img src="img/header/register_header_1.jpg" alt="konzept_header.jpg" title="Konzept Headerbild">
            <div class="mainHeaderTeaser small-12 medium-11 large-11 columns">

            </div>
        </div>
    </section>
    <hr>
    <h1 style="font-size: 30px; text-align: center; font-weight: lighter;">Hoppla, da ist ein Fehler passiert.</h1>
    <hr>
    <section class="row panel" style="margin-top: 20px;">
        <div class="small-12 columns">
            <div class="small-12 medium-6 large-6 columns">
                <?php if(isset($_GET["couponFail"])) :  ?>
                    <h4>Fehler bei der Registrierung</h4>
                <?php else: ?>
                    <h4>Fehler bei der Bezahlung</h4>
                    <p>Bei der von dir gewählten Bezahlmethode ist ein Fehler aufgetreten.</p>
                <?php endif; ?>

                <p>
                    Es könnte sein, dass du das Bezahlverfahren manuell abgebrochen hast. Sollte das nicht zutreffen,
                    kontaktiere uns bitte unter <a href="mailto:info@musiclessonsonair.de">info@musiclessonsonair.de</a></p>
                <a href="<?= $_SERVER["PHP_SELF"] ?>?p=startseite">zurück zur Startseite</a>

            </div>
        </div>
    </section>
</div>