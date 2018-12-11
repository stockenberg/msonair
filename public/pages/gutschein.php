<div class="small-12 medium-12 large-12 columns">

    <section class="main row">
        <div id="firstStop" class="mainHeader small-12 medium-12 large-12 columns">
            <?php if (isset($_GET["ht"])) : ?>
                <img src="img/heavytones_fb.jpg" alt="konzept_header.jpg" style="border: thin solid #ccc;"
                     title="Konzept Headerbild">
            <?php else: ?>
                <img src="img/header/register_header_1.jpg" alt="konzept_header.jpg" title="Konzept Headerbild">
            <?php endif; ?>
            <div class="mainHeaderTeaser small-12 medium-11 large-11 columns">
            </div>
        </div>
    </section>
    <hr>
    <h1 style="font-size: 30px; text-align: center; font-weight: lighter;">Hier kannst du, schnell und unkompliziert,
        Freude verschenken.</h1>
    <hr>
    <form id="coupon" action="#" method="post">

        <div id="coupon" class="panel row">

            <div class="small-12 medium-12 large-12">
                <h3>Wähle ein Instrument</h3>
                <select name="" id="filterLecturer">
                    <option disabled selected>Bitte wählen...</option>
                    <option value="sax">Saxophon</option>
                    <option value="trumpet">Trompete</option>
                    <option value="guitar">Gitarre</option>
                    <option value="piano">Klavier</option>
                    <option value="voice">Gesang</option>
                </select>
                <h3>Wähle einen Dozenten für den Gutschein</h3>
                <div class="row">

                    <div class="tabs-content">

                        <div class="content active" id="panel2-2">
                            <div class="dozenten clearfix">
                                <p><?= \src\core\Status::get("packageId") ?></p>
                                <p><?= \src\core\Status::get("lessonCount") ?></p>
                                <?php
                                /**
                                 * @var \src\objects\Package $package
                                 */
                                foreach ($this->package as $row => $package) : ?>
                                    <?php if ($package->getPackageSkill() == __INTERMEDIATE__) : ?>
                                        <div class="small-12 large-4 pull-left advancedPackage <?= $package->getPackageInstrument() ?>"
                                             data-id="<?= $package->getPackageId() ?>"
                                             style=" display: block; padding: 10px;">
                                            <ul class="pricing-table">
                                                <li class="title"><?= preg_replace("/[(].*[)]/i", "",
                                                        $package->getPackageName()) ?></li>
                                                <li class="image" style="text-align: center"><img
                                                            alt="<?= $package->getPackageName() ?>" height="200"
                                                            src="img/dozenten/<?= $package->getPackageImage() ?>"/></li>
                                                <li class="price"><?= $package->getPackagePrice() ?> €</li>
                                                <li class="bullet-item"><?= \src\helpers\Helper::translateIntresedIn($package->getPackageInstrument()) ?></li>
                                                <li class="bullet-item"><a href="?p=dozenten" target="_blank">zur
                                                        Dozentenübersicht</a></li>
                                                <li class="count">
                                                    <label for=""
                                                           style="display: none;"><?= $package->getPackageName() ?></label>
                                                    <select class="overviewData" name="coupon[lessonCount]"
                                                            form="coupon" id="">
                                                        <option selected value="false">Stundenanzahl wählen</option>
                                                        <?php for ($i = 1; $i <= 10; $i++) : ?>
                                                            <option value="<?= $i ?>"><?= $i ?> Stunde(n)
                                                                für <?= number_format($package->getPackagePrice() * $i,
                                                                    2,
                                                                    ",",
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
                            <div class="input" style="margin-top: 20px;">
                                <a class="small-12 medium-12 large-12 button next" disabled="disabled" onclick="showForm(this);">weiter</a>
                            </div>
                        </div>
                    </div>
                </div>

                <p class="note"><?= \src\core\Status::get("type") ?? "" ?></p>
                <div class="form" style="display: none;">
                    <p class="note">Die mit einem Sternchen (*) markierten Felder benötigen wir für die fehlerfreie
                        Verarbeitung
                        deiner Bestellung.</p>
                    <div class="small-12 medium-5 large-5 columns">
                        <h3>Rechnungsanschrift</h3>
                        <select name="coupon[gender]" required id="" class="small-12 medium-12 large-12">
                            <option disabled selected>Bitte Anrede wählen</option>
                            <option value="male">
                                Herr
                            </option>
                            <option value="female">
                                Frau
                            </option>
                        </select>
                        <p class="note"><?= \src\core\Status::get("gender") ?></p>

                        <div class="input text  small-12 medium-12 large-12">
                            <label for="firstname">*Vorname</label>
                            <input type="text" id="firstname" required name="coupon[firstname]"
                                   value="">
                            <p class="note"><?= \src\core\Status::get("firstname") ?? "" ?></p>
                        </div>
                        <div class="input text  small-12 medium-12 large-12">
                            <label for="lastname">*Nachname</label>
                            <input type="text" name="coupon[lastname]" required id="lastname"
                                   value="">
                            <p class="note"><?= \src\core\Status::get("lastname") ?? "" ?></p>
                        </div>
                        <div class="input text  small-12 medium-12 large-12">
                            <label for="street">*Straße</label>
                            <input type="text" name="coupon[street]" required id="street"
                                   value="">
                            <p class="note"><?= \src\core\Status::get("street") ?? "" ?></p>
                        </div>
                        <div class="input text  small-12 medium-3 large-3 columns">
                            <label for="postcode">*Postleitzahl</label>
                            <input type="text" name="coupon[postcode]" required id="postcode"
                                   value="">
                            <p class="note"><?= \src\core\Status::get("postcode") ?? "" ?></p>
                        </div>
                        <div class="input text  small-12 medium-9 large-9 pull-right columns">
                            <label for="city">*Stadt</label>
                            <input type="text" name="coupon[city]" required id="city"
                                   value=""
                            >
                            <p class="note"><?= \src\core\Status::get("city") ?? "" ?></p>
                        </div>
                        <div class="input text  small-12 medium-12 large-12">
                            <label for="email">*E-Mail-Adresse</label>
                            <input type="text" name="coupon[email]" required id="email"
                                   value="">
                            <p class="note"><?= \src\core\Status::get("email") ?? "" ?></p>
                        </div>
                        <div class="input text  small-12 medium-12 large-12">
                            <label for="phone">Telefonnummer (für schnelle Kontaktaufnahme)</label>
                            <input type="text" name="coupon[phone]" id="phone"
                                   value="">
                            <p class="note"><?= \src\core\Status::get("phone") ?? "" ?></p>
                        </div>
                    </div>
                    <div class="small-12 medium-6 large-6 pull-right columns">
                        <h3>Ist der Gutschein für einen Freund?</h3>
                        <div class="clearfix">
                            <div class="input radio small-1 medium-1 large-1 pull-left columns">
                                <label for="yes">Ja</label>
                                <input type="radio"
                                       name="coupon[friend]"
                                       value="yes" id="yes">
                            </div>
                            <div class="input radio small-11 medium-11 large-11 pull-left columns">
                                <label for="no">Nein</label>
                                <input type="radio"
                                       name="coupon[friend]"
                                       value="no" id="no">
                            </div>
                        </div>
                        <div class="friendsinput" style="display: none;">
                            <select name="coupon[friends_gender]" required id="" class="small-12 medium-12 large-12">
                                <option disabled selected value="false">Bitte Anrede wählen</option>
                                <option value="male">
                                    Herr
                                </option>
                                <option value="female">
                                    Frau
                                </option>
                            </select>
                            <div class="input text  small-12 medium-12 large-12">
                                <label for="firstname_recipient">Vorname des Empfängers</label>
                                <input type="text" name="coupon[firstname_recipient]" id="firstname_recipient"
                                       value="">
                                <p class="note"><?= \src\core\Status::get("firstname_recipient") ?? "" ?></p>
                            </div>
                            <div class="input text  small-12 medium-12 large-12">
                                <label for="lastname_recipient">Nachname des Empfängers</label>
                                <input type="text" name="coupon[lastname_recipient]" id="lastname_recipient"
                                       value="">
                                <p class="note"><?= \src\core\Status::get("lastname_recipient") ?? "" ?></p>
                            </div>
                        </div>

                        <h3 style="margin-top: 20px;">*Wie möchtest du zahlen?</h3>
                        <p class="note"><?= \src\core\Status::get("payment") ?? "" ?></p>
                        <div class="input radio ">
                            <input name="coupon[payment]"
                                   type="radio" id="prepaid" required value="prepaid">
                            <label for="prepaid" style="margin-bottom: 10px;">Vorkasse</label>
                        </div>

                        <div class="input radio ">
                            <input name="coupon[payment]" required type="radio" id="paypal" value="paypal">
                            <label for="paypal" style="margin-bottom: 10px;">Paypal</label>
                        </div>
                        <h3>*Abschluss</h3>
                        <div class="input checkbox ">
                            <input type="checkbox"
                                   name="coupon[agb]" id="agb" required value="yes"><label for="agb">*Ich bin mit den <a
                                        href="?p=datenschutz">Datenschutzbestimmungen</a> und <a href="?p=agb">Nutzungsbedingungen</a>
                                einverstanden.</label>
                        </div>
                        <p class="note"><?= \src\core\Status::get("agb") ?? "" ?></p>
                        <div class="input checkbox">
                            <input type="hidden" name="data[Register][newsletter]" id="RegisterNewsletter_" value="0">
                            <input type="checkbox" name="data[Register][newsletter]" value="1" id="RegisterNewsletter">
                            <label for="RegisterNewsletter">
                                Bitte sendet mir den Newsletter von Musiclessons On Air zu.
                            </label>
                        </div>
                        <div>
                            <input type="submit" name="coupon[submit]" style="margin-top: 20px;"
                                   class="button small-12 medium-12 large-12"
                                   value="Bestellung bestätigen" id="submit">
                            <input type="hidden" form="coupon" class="hidden_id" name="coupon[packageId]" value="">
                        </div>
                    </div>
                </div>
    </form>
</div>
</div>
</div>