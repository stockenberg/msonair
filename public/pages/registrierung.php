<?php // Include Form-Step compared with get-param ?>
<div class="small-12 medium-12 large-12 columns">
    <!-- Registers         -->
    <!-- REGISTERFORM -->
    <section class="main row">
        <div id="firstStop" class="mainHeader small-12 medium-12 large-12 columns">
            <img src="img/header/register_header_1.jpg" alt="konzept_header.jpg" title="Konzept Headerbild">
        </div>
    </section>
    <hr>
    <h1 style="font-size: 30px; text-align: center; font-weight: lighter;">Hier kannst du dich schnell und unkompliziert
        für Musiclessons On Air anmelden.</h1>
    <hr>

    <form action="" id="register" method="post">
        <div id="register" class="panel row">
            <div class="left small-12 large-12 cloumns">
                <h3>Deine persönlichen Daten</h3>
                <div class="small-12 large-5 columns">
                    <div class="input text required">
                        <input name="register[firstname]" class="overviewData" placeholder="Vorname" maxlength="45"
                               type="text" id="RegisterFirstname" value="" required="required">
                    </div>
                    <p class="error note"><?= \src\core\Status::get("firstname") ?></p>
                    <div class="input text required"><input class="overviewData" name="register[lastname]"
                                                            placeholder="Nachname" maxlength="45" type="text"
                                                            id="RegisterLastname" value="" required="required"></div>
                    <p class="error note"><?= @$this->status["lastname"] ?></p>
                    <span data-tooltip="" aria-haspopup="true" class="has-tip" data-selector="tooltip-itsqbx4u0"
                          title="">?</span>
                    <div class="input checkbox"><input type="checkbox" name="register[childsAccount]" value="1"
                                                       id="RegisterChildsAccount">
                        <label for="RegisterChildsAccount">Ich registriere mich für mein Kind.</label>
                    </div>
                    <div class="input text"><input name="register[childsName]" placeholder="Name Tochter / Sohn"
                                                   value=""
                                                   maxlength="90" type="text" id="RegisterChildsName"></div>
                    <p class="error note"><?= @$this->status["childsName"] ?></p>
                    <div class="input email required"><input name="register[email]" class="overviewData"
                                                             placeholder="E-Mail-Adresse"
                                                             value=""
                                                             type="email" id="RegisterEmail" required="required"></div>
                    <p class="error note"><?= @$this->status["email"] ?></p>
                    <div class="input text required"><input name="register[username]"
                                                            class="overviewData username_input"
                                                            placeholder="Benutzername"
                                                            value=""
                                                            onchange="check();"
                                                            maxlength="45" type="text" id="RegisterUsername"
                                                            required="required"></div>
                    <p class="error note username"><?= @$this->status["username"] ?></p>
                    <div class="input date"><label for="RegisterBirthDtDay">Bitte Geburtsdatum eingeben</label>
                        <input name="register[birthDate]" class=" overviewData username_input"
                               placeholder="tt.mm.yyyy"
                               value=""
                               maxlength="45" type="text" id="RegisterBirthDate"
                               required="required">
                    </div>
                    <p class="error note"><?= \src\core\Status::get("birthDate") ?></p>
                </div>
                <div class="small-12 large-6 columns">
                    <div class="input text required"><input class="overviewData" name="register[street]"
                                                            placeholder="Straße &amp; Hausnummer" maxlength="45"
                                                            value=""
                                                            type="text" id="RegisterStreet" required="required"></div>
                    <p class="error note"><?= @$this->status["street"] ?></p>
                    <div class="input text required"><input class="overviewData" name="register[postcode]"
                                                            placeholder="PLZ"
                                                            maxlength="45" type="text" id="RegisterPostcode"
                                                            value=""
                                                            required="required"></div>
                    <p class="error note"><?= @$this->status["postcode"] ?></p>
                    <div class="input text required"><input class="overviewData" name="register[city]"
                                                            placeholder="Stadt"
                                                            value=""
                                                            maxlength="45" type="text" id="RegisterCity"
                                                            required="required"></div>
                    <p class="error note"><?= @$this->status["city"] ?></p>
                    <label for="RegisterGeschlecht">Geschlecht</label><select name="register[gender]"
                                                                              class="overviewData"
                                                                              id="RegisterGender" required="required">
                        <option selected value="">bitte wählen...</option>
                        <option value="male">Männlich</option>
                        <option value="female">weiblich</option>
                    </select>
                    <p class="error note"><?= @$this->status["gender"] ?></p>
                    <label for="RegisterWelchesInstrumentMöchtenSieErlernen?">Wähle bitte ein Instrument</label><select
                            name="register[instrument]" id="RegisterIntrestedIn" class="overviewData"
                            required="required">
                        <option selected value="">bitte wählen...</option>
                        <option value="guitar">Gitarre</option>
                        <option value="trumpet">Trompete</option>
                        <option value="sax">Saxophon</option>
                        <option value="piano">Klavier</option>
                        <option value="voice">Gesang</option>
                        <option value="coupon">Gutscheincode</option>
                    </select>
                    <p class="error note"><?= @$this->status["instrument"] ?></p>
                    <br>
                </div>
            </div>
            <button class="expand button small next instrument changeCoupon">Weiter zur Dozenten-Auswahl</button>
        </div>


        <div class="panel row beginner opacityhidden">
            <h3 style="margin-top: 20px; margin-left: 10px;">Wähle nun einen Dozenten oder löse deinen Gutscheincode ein.</h3>
            <div class="large-12 columns panel">
                <ul class="tabs" data-tab="">
                    <li class="tab-title"><a href="#panel2-2"><h5>Dozentenübersicht</h5></a></li>
                    <li class="tab-title"><a href="#panel2-3"><h5>Gutschein einlösen</h5></a></li>
                    <!--
                    <li class="tab-title"><a href="#panel2-3"><h5>Gutscheincode einlösen</h5></a></li>
                    <li class="tab-title"><a href="#panel2-4"><h5>Gutschein bestellen</h5></a></li> -->
                </ul>
                <div class="tabs-content">

                    <div class="content active clearfix" id="panel2-2">
                        <p class="error note packageId"><?= @$this->status["packageId"] ?></p>
                        <p class="error note packageId"><?= @$this->status["lessonCount"] ?></p>
                        <p class="noinstrument">Bitte wähle oben ein Instrument.</p>

                        <?php
                        /**
                         * @var \src\objects\Package $package
                         */
                        foreach ($this->package as $row => $package) : ?>
                            <?php if ($package->getPackageSkill() == __INTERMEDIATE__) : ?>
                                <div class="small-12 large-4 pull-left advancedPackage <?= $package->getPackageInstrument() ?>"
                                     data-id="<?= $package->getPackageId() ?>" style=" padding: 10px;">
                                    <ul class="pricing-table">
                                        <li class="title"><?= preg_replace("/[(].*[)]/i", "",
                                                $package->getPackageName()) ?></li>
                                        <li class="image" style="text-align: center"><img
                                                    alt="<?= $package->getPackageName() ?>" height="200"
                                                    src="img/dozenten/<?= $package->getPackageImage() ?>"/></li>
                                        <li class="price"><?= $package->getPackagePrice() ?> €</li>
                                        <li class="bullet-item"><a href="?p=dozenten" target="_blank">zur Dozentenübersicht</a></li>
                                        <li class="count">
                                            <label for=""
                                                   style="display: none;"><?= $package->getPackageName() ?></label>
                                            <select class="overviewData" id="">
                                                <option selected value="">Stundenanzahl wählen</option>
                                                <?php for ($i = 1; $i <= 10; $i++) : ?>
                                                    <option value="<?= $i ?>"><?= $i ?> Stunde(n)
                                                        für <?= number_format($package->getPackagePrice() * $i, 2, ",",
                                                            ".") ?> €
                                                    </option>
                                                    <?php if($package->getPackageBookingCountMax() !== NULL) : ?>
                                                        <?php break; ?>
                                                    <?php endif; ?>
                                                <?php endfor; ?>
                                            </select>
                                        </li>
                                    </ul>
                                </div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                    <div class="content" id="panel2-3">
                        <h3 style="margin-left: 10px;">Gutscheincode einlösen</h3>
                        <div class="">
                            <p style="margin-left: 10px;">Wenn du einen Gutscheincode von Musiclessons On Air hast, kannst du ihn hier einlösen.</p>
                            <div style="padding: 10px;">
                                <div class="input text">
                                    <input placeholder="Gutscheincode" onkeyup="removeRequire(this)" class="overviewData" name="register[coupon_code]" type="text" id="couponCode">
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <input type="hidden" class="hidden_id" name="register[packageId]" value="">
            <button class="expand button small next paymentbutton">Bitte wähle deine Zahlungsweise</button>

        </div>

        <section class="row panel opacityhidden">
            <h3>Zahlungsweise Wählen</h3>
            <div class="paymentform">
                <p>
                    <input type="radio" placeholder="Bezahlung" form="register" checked="checked" class="prepaid overviewPayment" required
                           id="prepaid" value="1" name="register[payment]">
                    <label for="prepaid">Vorkasse</label>
                </p>
                <p>
                    <input type="radio" placeholder="Bezahlung" form="register" class="paypal overviewPayment" required
                           id="paypal" value="2" name="register[payment]">
                    <label for="paypal">PayPal</label>
                </p>

            </div>


            <button class="expand button small next">Weiter zum Abschluss der Registrierung
            </button>
        </section>

        <section class="row panel opacityhidden fromCoupon">
            <div>
                <div style="height: 300px; overflow-y: scroll; background-color: #fafafa; margin-bottom: 20px; border: thin solid #ddd; padding: 20px;">
                    <h3>AGB Musikschule On Air UG (haftungsbeschränkt)</h3>
                    <h4>Vertragsgegenstand:</h4>

                    <p>Die Musiclessons On Air bietet Musikunterricht über das Internet an. Nach Vertragsabschluss,
                        der mit der
                        Buchung durch den Dienstberechtigten, nachfolgend Schüler genannt, zwischen dem Schüler und
                        dem
                        Dienstverpflichteten, nachfolgend Musiclessons On Air genannt, zustande kommt, hat der Schüler
                        die
                        Berechtigung, bei den Dozenten der Musiclessons On Air Unterricht zu bekommen. Zusätzlich erhält
                        der
                        Schüler, sofern er das entsprechende Angebot der Musiclessons On Air gebucht hat, in seinem
                        Login-Bereich
                        auch Zugriff auf Lehrvideos, die die Unterrichtsinhalte wiederholen, vertiefen und erweitern.
                    </p>
                    <h4>Technik:</h4>

                    <p>Der Unterricht zwischen Dozent und Schüler findet über das Internet statt. Für den
                        Internetzugang sowie
                        für die notwendige periphere Ausstattung des Computers (Mikrofon, Kopfhörer oder Lautsprecher,
                        Webcam)
                        sorgt der Schüler eigenständig. Die Musiclessons On Air übernimmt keine Haftung für
                        technische Probleme,
                        die durch mangelhafte Hard- oder Software auf Seite des Schülers oder Störungen des Internets
                        verursacht
                        wurden. Die Musiclessons On Air verwendet für den Live-Unterricht die Schnittstelle WebRTC.
                        Diese Technik
                        ist für die Browser Mozilla Firefox, Google Chrome und Opera optimiert und wird vom Windows
                        Internet
                        Explorer nicht unterstützt. Der Schüler sorgt selbstständig für die Installation eines der
                        geeigneten
                        Browser. Die Funktionsfähigkeit der Technik kann nach Buchung über den verschickten Test-Link
                        geprüft
                        werden. Sollte trotz korrekter Installation eines der oben genannten Browser und Installation
                        geeigneter
                        Hardware die Nutzung von WebRTC nicht möglich sein, bietet die Musiclessons On Air
                        gegebenenfalls Unterricht
                        über Skype als Alternative an. Die technischen Probleme, verbunden mit dem Wunsch, Skype als
                        Alternative zu
                        verwenden, müssen bis spätestens 48 Stunden vor Beginn der ersten Unterrichtsstunde bei der
                        Musikschule On
                        Air schriftlich via E-Mail angemeldet werden. Es besteht keinerlei Anspruch auf Unterricht via
                        Skype bei der
                        Musiclessons On Air, und die Musiclessons On Air behält sich das Recht vor, den Vertrag in diesem
                        Fall zu
                        widerrufen. In diesem Fall sind alle bereits getätigten Zahlungen zurückzugewähren. Die
                        Musiclessons On Air
                        ist berechtigt, gelegentlich und, wenn möglich, zu akzeptablen Zeiten und in akzeptablem
                        zeitlichen Umfang
                        Wartungsarbeiten an Software, Login-Bereich und Website durchzuführen. In diesem Zeitraum kann
                        der Schüler
                        u.U. nicht auf die Funktionen der Musiclessons On Air (beispielsweise die Lehrvideos etc.)
                        zugreifen.
                    </p>
                    <h4>Nutzung:</h4>

                    <p>Für die Nutzung der Leistungen der Musiclessons On Air ist eine gültige E-Mail-Adresse
                        erforderlich. Es ist
                        ein Passwort zu wählen, dass gängigen Sicherheitsanforderungen genügt. Das Passwort darf nicht
                        an Dritte
                        weitergegeben werden.</p>

                    <p>
                        Die Nutzung des Zugangs zum Login-Bereich der Musiclessons On Air darf nur zu privaten Zwecken
                        erfolgen, eine
                        kommerzielle oder gewerbliche Nutzung oder die öffentliche Vorführung ist nur mit
                        ausdrücklicher
                        schriftlicher Genehmigung erlaubt.</p>

                    <p>
                        Die Buchungen bei Musiclessons On Air sind personengebunden, d.h. es darf nur eine Person
                        mit einem
                        Account lernen. Die Stunden sind nicht übertragbar. Der Lernende kann jedoch die Hilfe
                        Dritter, zum Beispiel seiner Familienmitglieder, bei der Nutzung der Inhalte der Musikschule On
                        Air in
                        Anspruch nehmen.
                    </p>

                    <p> Die Inhalte (z.B. Videos, Noten, Mitschnitte von Seiten des Lehrers) aber auch Logos, Designs,
                        Kennzeichen
                        etc. der Musiclessons On Air aber auch Logos, Designs, Kennzeichen etc. der Musiclessons On Air
                        sind Eigentum
                        der Musikschule On Air UG (haftungsbeschränkt) und als solche durch geltendes Recht vor
                        Reproduktion,
                        Verfremdung o.ä. geschützt.
                    </p>
                    <h4>Unterricht für Minderjährige:</h4>

                    <p>Die Musiclessons On Air bietet keine Produkte zum Kauf durch Minderjährige an. Sollte dennoch
                        ein Abonnement
                        von einem Minderjährigen ohne das Wissen der Eltern erworben werden, so sind die Eltern an die
                        vom Gesetz
                        vorgegebene elterliche Aufsichtspflicht gebunden und haften für ihre Kinder.<br> Wenn
                        Minderjährige vor
                        ihrem 18. Geburtstag Unterricht bei Musiclessons On Air nehmen wollen, so sind Anmeldung und
                        Abschluss
                        des Vertrages stellvertretend durch einen Erziehungsberechtigten vorzunehmen.</p>
                    <h4>Unterrichtszeiten, -absagen und -ausfall:</h4>

                    <p>Die Musiclessons On Air ist bemüht, ihren Schülern möglichst viele Zeitfenster für den
                        Unterricht zur
                        Verfügung zu stellen. Es besteht jedoch kein Anspruch des Schülers auf seine Wunschzeiten
                        sowie seinen
                        Wunschdozenten.</p>

                    <p>
                        Termine können durch den Schüler über das Buchungssystem im Login-Bereich verbindlich gebucht
                        werden. Die
                        Buchung kann bis spätestens 48 Stunden vor Beginn der Unterrichtsstunde erfolgen. Bei
                        Verhinderung muss die
                        Unterrichtsstunde bis spätestens 24 Stunden vor Beginn der Unterrichtsstunde abgesagt werden.
                        Spätere
                        Absagen, egal aus welchem Grund, können leider nicht berücksichtigt werden und werden vom
                        Stundenkonto
                        abgezogen.</p>

                    <p>
                        Bei Unterrichtsausfall durch Verschulden der Musiclessons On Air (z.B. bei Krankheit des
                        Dozenten) wird
                        voller Stundenausgleich geleistet. Darüber hinausgehende Kosten- bzw. Haftungsansprüche
                        können nicht
                        geltend gemacht werden. Bei dauerhaftem Ausfall eines Dozenten ist die Musiclessons On Air
                        berechtigt, einen
                        Ersatzlehrer zu stellen.</p>
                    <h4>Verfall von Unterrichtsstunden:</h4>

                    <p>Unterrichtsstunden müssen bis spätestens sechs Monate nach Zahlungseingang in Anspruch
                        genommen werden.
                        Andernfalls verfällt der Anspruch auf die Unterrichtsstunden und der Vertrag wird als erfüllt
                        angesehen.
                        Ausnahmeregelungen bedürfen der ausdrücklichen schriftlichen Zustimmung durch die Musikschule
                        On Air.</p>
                    <h4>Lehrer und Inhalte:</h4>

                    <p>Die Musiclessons On Air wählt ihre Dozenten sorgfältig aus und ist bemüht, einen qualifizierten
                        und
                        reibungslosen Unterrichtsablauf zu bieten. Schulische Leistungsverbesserungen oder die
                        Erzielung des
                        gewünschten Lernerfolgs hängen von vielen Faktoren, insbesondere von der aktiven Mitarbeit des
                        Schülers,
                        ab. Eine Garantie auf Leistungsverbesserungen kann daher nicht übernommen werden.<br>
                        Für eventuelle inhaltliche Fehler oder Falschangaben in den Lehrvideos oder den
                        Unterrichtsstunden
                        übernimmt die Musiclessons On Air keinerlei Haftung.</p>
                    <h4>Kündigung von Seite der Musiclessons On Air:</h4>

                    <p>Die Musiclessons On Air behält sich das Recht vor, Verträge auch nach Ablauf der gesetzlichen
                        Widerrufsfrist
                        zu kündigen, sofern ein wichtiger Grund vorliegt. Ein wichtiger Grund liegt beispielsweise
                        dann vor, wenn
                        Schüler Unterrichtsmaterial unerlaubt verbreiten, den Betrieb der Musiclessons On Air stören
                        oder
                        unverhältnismäßig häufig Unterrichtsstunden kurzfristig absagen. Im Falle einer Kündigung von
                        Seite der
                        Musiclessons On Air sind etwaig geleistete Zahlungen in entsprechendem Maße zurückzugewähren.
                        Wurden die
                        Leistungen bereits teilweise erfüllt, wenn beispielsweise bereits ein der Teil der
                        Unterrichtsstunden
                        erteilt wurde und der Zugang zu den Lehrvideos bereits bestand, so sind die
                        Zahlungsverpflichtungen u.U. nur
                        anteilig zurückzugewähren bzw. müssen anteilig für die in Anspruch genommenen Leistungen
                        erfüllt
                        werden.</p>
                    <h4>Gutscheine:</h4>

                    <p>Gutscheine für die Musiclessons On Air können innerhalb der geltenden Gültigkeitsfrist bei der
                        Musikschule
                        On Air eingelöst werden. Eine Barauszahlung ist nicht möglich. Nach Ablauf der Frist besteht
                        keinerlei
                        Anspruch auf Anerkennung des Gutscheins. Bei käuflichem Erwerb der Gutscheine gelten die oben
                        aufgeführten
                        Widerrufsbedingungen. Für das Einlösen der Gutscheine bei Musiclessons On Air ist eine
                        Registrierung wie
                        oben beschrieben sowie die Zustimmung zu den AGB der Musiclessons On Air durch den Schüler, der
                        die Stunden
                        in Anspruch nimmt, notwendig.</p>
                    <h4>Sonderaktionen:</h4>

                    <p>Bei Sonderaktionen (z.B. Unterrichtsstunden bei bekannten Musikern etc.) gelten die gleichen
                        Bedingungen wie
                        oben aufgeführt. In der Regel sind die Stundenkontingente begrenzt und es besteht kein
                        Anspruch auf Buchung
                        oder die Wunschzeiten des Schülers für die Unterrichtsstunden. Es gelten die oben
                        aufgeführten
                        gesetzlichen Widerrufsbedingungen. Die gebuchten Unterrichtsstunden müssen innerhalb der
                        angegebenen Frist
                        eingelöst werden.</p>
                    <h4>Datenschutz:</h4>

                    <p>Wir wissen Ihr Vertrauen zu schätzen und wenden äußerste Sorgfalt an, um Ihre persönlichen
                        Daten vor
                        unbefugtem Zugriff zu schützen. Es gelten die allgemeinen Datenschutzbestimmungen.</p>
                    <h4>Anwendbares Recht:</h4>

                    <p>Es gilt das Recht der Bundesrepublik Deutschland unter Ausschluss des UN-Kaufrechts.
                        Gerichtsstand ist der
                        Firmensitz der Musikschule On Air UG (haftungsbeschränkt).</p>
                    <h4>Schlussklausel:</h4>

                    <p>Sollten einzelne Bestimmungen dieser AGB unwirksam oder undurchführbar sein oder nach
                        Vertragsschluss
                        unwirksam oder undurchführbar werden, so wird dadurch die Wirksamkeit des Vertrages im Übrigen
                        nicht
                        berührt. An die Stelle der unwirksamen oder undurchführbaren Bestimmung soll diejenige
                        wirksame und
                        durchführbare Regelung treten, deren Wirkungen der wirtschaftlichen Zielsetzung möglichst nahe
                        kommen, die
                        die Vertragsparteien mit der unwirksamen beziehungsweise undurchführbaren Bestimmung verfolgt
                        haben. Die
                        vorstehenden Bestimmungen gelten entsprechend für den Fall, dass sich der Vertrag als
                        lückenhaft erweist.
                        § 139 BGB gilt als ausgeschlossen.</p>

                </div>
                <hr>
                <div style="height: 300px; overflow-y: scroll; background-color: #fafafa; border: thin solid #ddd; padding: 20px;">
                    <h4>Widerrufsrecht:</h4>

                    <p>Sie können Ihre Vertragserklärung innerhalb von 14 Tagen ohne Angabe von Gründen in Textform
                        (z. B. Brief,
                        Fax, E-Mail) widerrufen. Die Frist beginnt nach Erhalt dieser Belehrung in Textform, jedoch
                        nicht vor
                        Vertragsschluss und auch nicht vor Erfüllung unserer Informationspflichten gemäß Artikel 246 §
                        2 in
                        Verbindung mit § 1 Absatz 1 und 2 EGBGB sowie unserer Pflichten gemäß § 312g Absatz 1 Satz 1
                        BGB in
                        Verbindung mit Artikel 246 § 3 EGBGB. Zur Wahrung der Widerrufsfrist genügt die rechtzeitige
                        Absendung des
                        Widerrufs. Der Widerruf ist zu richten an:</p>

                    <p><b>Musikschule On Air UG (haftungsbeschränkt)<br>
                            Am Hange 86<br> 22844 Norderstedt</b></p>

                    <p>Im Falle eines wirksamen Widerrufs sind die beiderseits empfangenen Leistungen
                        zurückzugewähren und ggf.
                        gezogene Nutzungen (z.B. Zinsen) herauszugeben. Wurden die Leistungen bereits teilweise
                        erfüllt, wenn
                        beispielsweise bereits ein der Teil der Unterrichtsstunden erteilt wurde und der Zugang zu den
                        Lehrvideos
                        bereits bestand, so sind die Zahlungsverpflichtungen u.U. nur anteilig zurückzugewähren bzw.
                        müssen
                        anteilig für die in Anspruch genommenen Leistungen erfüllt werden. Verpflichtungen zur
                        Erstattung von
                        Zahlungen müssen innerhalb von 30 Tagen erfüllt werden. Die Frist beginnt für Sie mit der
                        Absendung Ihrer
                        Widerrufserklärung, für uns mit deren Empfang.</p>

                    <p>Ihr Widerrufsrecht erlischt vorzeitig, wenn der Vertrag von beiden Seiten auf Ihren
                        ausdrücklichen Wunsch
                        vollständig erfüllt ist, bevor Sie Ihr Widerrufsrecht ausgeübt haben.</p>

                </div>
            </div>
            <div>
                <p style="margin-top: 10px;">
                    <input type="checkbox" name="register[termsOfUse]" form="register" required id="agb" value="1"
                           class="agb">
                    <label for="agb"> Ich habe die AGB gelesen und akzeptiere sie.</label>
                </p>

                <p>
                    <input type="checkbox" name="register[recall]" form="register" required value="1" id="widerruf"
                           class="widerruf">
                    <label for="widerruf">Ich habe die Widerrufsbelehrung gelesen und akzeptiere sie.</label>
                </p>

                <p>
                    <input type="submit" class="button success alert right" name="register[submit]"
                           value="Kostenpflichtig bestellen" id="submit">
                    <!-- Bestellung abschließen  -->
                </p>
            </div>
        </section>
    </form>
</div>

