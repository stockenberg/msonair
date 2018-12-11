<div class="small-12 medium-12 large-12 columns">
    <!-- Success         -->
    <section class="main row">
        <div id="firstStop" class="mainHeader small-12 medium-12 large-12 columns">
            <img src="img/header/register_header_1.jpg" alt="konzept_header.jpg" title="Konzept Headerbild">        <div class="mainHeaderTeaser small-12 medium-11 large-11 columns">

            </div>
        </div>
    </section>
    <hr>
    <h1 style="font-size: 30px; text-align: center; font-weight: lighter;">Vielen Dank für deine Bestellung bei Musiclessons On Air.</h1>
    <hr>
    <section class="row panel" style="margin-top: 20px;">
        <div class="small-12 columns">
            <?php if(!isset($_GET["token"]) && !isset($_GET["coupon"])): ?>
                <div class="small-12 medium-6 large-6 columns">
                    <h4>Vielen Dank für deine Bestellung.</h4>
                    <p>Wir haben dir soeben die Rechnung per E-Mail zugeschickt. Bitte überweise den Rechnungsbetrag auf das in der Rechnung aufgeführte Konto.</p>

                    <p>
                        Sobald der Betrag auf unserem Konto eingegangen ist, bekommst du den Gutschein per E-Mail zugesendet. <br/><a href="<?= __BASE__ ?>?p=startseite">zurück zur Startseite</a></p>
                    <p></p>
                </div>
                <div class="small-12 medium-5 medium-offset-1 large-5 large-offset-1 columns">
                    <h4>Bankdaten für die Vorkassezahlung</h4>
                    <table>
                        <tbody>
                        <tr>
                            <td>Kontoinhaber: </td>
                            <td>Musikschule On Air UG</td>
                        </tr>
                        <tr>
                            <td>IBAN: </td>
                            <td>DE55 7002 2200 0020 2222 98</td>
                        </tr>
                        <tr>
                            <td>BIC: </td>
                            <td>FDDODEMMXXX</td>
                        </tr>
                        <tr>
                            <td>Verwendungszweck: </td>
                            <?php $model = new \src\model\Model(); ?>
                            <td>201601300<?= $model->getLastInvoiceID()[0]["invoice_id"] ?></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <?php if(!isset($_GET["coupon"])) : ?>
                <div class="small-12 medium-12 large-12 columns">
                    <h4>Vielen Dank für deine Bestellung.</h4>
                    <p>Wir haben dir den Gutschein per E-Mail zugesendet. <br/><a href="<?= __BASE__ ?>?p=startseite">zurück zur Startseite</a></p>
                </div>
                <?php else: ?>
            <div class="small-12 medium-12 large-12 columns">

                <h4>Vielen Dank! Dein Gutschein wurde erfolgreich eingelöst.</h4>

                <p>Wir haben dir soeben eine E-Mail zugesendet. Über den Link in der E-Mail kannst du dir ein Passwort einrichten und dich anschließend in deinen persönlichen Bereich einloggen.</p>

                <p>Falls du keine E-Mail erhalten haben solltest, sieh einmal im Spam-Ordner nach. <br />Manchmal verirren sich die E-Mails dort hin.</p>
            </div>

            <?php endif; ?>
            <?php endif; ?>
        </div>
    </section>
</div>


