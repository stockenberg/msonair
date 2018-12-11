<div class="small-12 medium-12 large-12 columns">
    <!-- Success         -->
    <section class="main row">
        <div id="firstStop" class="mainHeader small-12 medium-12 large-12 columns">
            <img src="img/header/register_header_1.jpg" alt="konzept_header.jpg" title="Konzept Headerbild">        <div class="mainHeaderTeaser small-12 medium-11 large-11 columns">

            </div>
        </div>
    </section>
    <hr>
    <h1 style="font-size: 30px; text-align: center; font-weight: lighter;">Vielen Dank für deine Anmeldung bei Musiclessons On Air.</h1>
    <hr>
    <section class="row panel" style="margin-top: 20px;">
        <div class="small-12 columns">
            <?php if(isset($_GET["prepaid"]) && !isset($_GET["token"])): ?>
                <div class="small-12 medium-6 large-6 columns">
                <h4>Bald kann es losgehen.</h4>
                <p>
                    Wir haben dir soeben die Rechnung per E-Mail zugeschickt. Bitte überweise den Rechnungsbetrag auf das in der Rechnung aufgeführte Konto.
                    <br/><br/>Wir haben dir soeben eine E-Mail zugesandt, in der du einen Link findest, über den du dein Passwort für den Login-Bereich festlegen kannst. Falls du keine E-Mail erhalten haben solltest, sieh einmal im Spam-Ordner nach. Manchmal verirren sich die E-Mails dort hin.</p>

                <p>
                    Sobald der Rechnungsbetrag auf unserem Konto eingegangen ist, kannst du im Login-Bereich deinen ersten Unterrichtstermin auswählen.
                </p>
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
            <div class="small-12 medium-12 large-12 columns">
                <h4>Bald kann es losgehen.</h4>
                <p>Wir haben dir soeben eine E-Mail zugesendet. <br ><br />
                    In dieser findest du unter anderem einen Link, über den du dir ein Passwort erstellen kannst. <br />
                    Anschließend hast du bereits Zugang zum Login-Bereich und kannst dort deinen ersten Unterrichtstermin aussuchen.
                    <br /><br/>
                    Falls du keine E-Mail erhalten haben solltest, sieh einmal im Spam-Ordner nach. Manchmal verirren sich die E-Mails dort hin.</p>
                </div>
            <?php endif; ?>
        </div>
    </section>
</div>