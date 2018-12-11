<div class="small-12 medium-12 large-12 columns">
    <!-- Preise         -->
    <section class="main row">
        <div id="firstStop" class="mainHeader small-12 medium-12 large-12 columns">
            <img src="img/header/paket_header.jpg" alt="konzept_header.jpg" title="Konzept Headerbild">
            <div class="mainHeaderTeaser small-12 medium-11 large-11 columns">
            </div>
        </div>
    </section>
    <hr>
    <h1 style="font-size: 30px; text-align: center; font-weight: lighter;">Unsere Preise</h1>
    <hr>
    <section id="mainContent" class="row">
        <div class="small-12 medium-12 large-12 columns">
            <p>
                Das Besondere: Du musst nicht einmal einen Jahresvertrag abschließen, sondern kannst einfach so
                viele Stunden buchen, wie du möchtest. </p>
        </div>
    </section>

    <div class="row">
        <ul class="tabs" data-tab="">
            <li class="tab-title"><a href="#panel2-3"><h5>Geschenkgutscheine</h5></a></li>
            <li class="tab-title active"><a href="#panel2-4"><h5>Preise nach Dozenten</h5></a></li>
            <li class="tab-title"><a href="#panel2-5"><h5>Specials</h5></a></li>
        </ul>
        <div class="tabs-content">
            <div class="content" id="panel2-3">
                <p>Mache Freunden oder Verwandten eine ganz besondere Freude
                    und verschenke Unterricht bei Musiclessons On Air.</p>
                <a href="<?= __BASE__ ?>?p=gutschein" class="button success alert" title="Hier geht es zum Gutschein">Gutschein
                    bestellen</a>
            </div>
            <div class="content active clearfix" id="panel2-4">
                <select name="" id="filterLecturer">
                    <option disabled selected>Wähle ein Instrument...</option>
                    <option value="sax">Saxophon</option>
                    <option value="trumpet">Trompete</option>
                    <option value="guitar">Gitarre</option>
                    <option value="piano">Klavier</option>
                    <option value="voice">Gesang</option>
                </select>
                <?php
                /**
                 * @var \src\objects\Package $package
                 */
                foreach ($this->package as $row => $package) : ?>
                    <?php if ($package->getPackageSkill() == __INTERMEDIATE__) : ?>
                        <div class="small-12 large-4 pull-left advancedPackage <?= $package->getPackageInstrument() ?>"
                             data-id="<?= $package->getPackageId() ?>" style=" display: block; padding: 10px;">
                            <ul class="pricing-table">
                                <li class="title"><?= preg_replace("/[(].*[)]/i", "",
                                        $package->getPackageName()) ?></li>
                                <li class="image" style="text-align: center"><img
                                            alt="<?= $package->getPackageName() ?>" height="200"
                                            src="img/dozenten/<?= $package->getPackageImage() ?>"/></li>
                                <li class="price"><select name="" id="">
                                        <?php for ($i = 1; $i <= 10; $i++) : ?>
                                            <option value="<?= $i ?>"><?= $i ?> Stunde(n)
                                                für <?= number_format($package->getPackagePrice() * $i, 2, ",",
                                                    ".") ?> €
                                            </option>
                                            <?php if($package->getPackageBookingCountMax() !== NULL) : ?>
                                                <?php break; ?>
                                            <?php endif; ?>
                                        <?php endfor; ?>
                                    </select></li>
                                <li class="bullet-item"><?= \src\helpers\Helper::translateIntresedIn($package->getPackageInstrument()) ?></li>
                                <li class="bullet-item"><a href="?p=dozenten" target="_blank">zur Dozentenübersicht</a>
                                </li>
                                <li class="bullet-item"><a href="?p=registrierung" target="_blank">Jetzt buchen</a></li>
                            </ul>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
            <div class="content" id="panel2-5">
                <p>Viele berühmte Musiker geben Coachings und Unterricht bei Musiclessons On Air. Abonniere den
                    Newsletter, um kein Angebot zu verpassen. Dieser informiert dich regelmäßig über Angebote und News
                    und kann selbstverständlich jederzeit ganz unkompliziert wieder abbestellt werden.</p>

                <form action="">
                    <div class="input text required">
                        <input name="newsletter[email]" class="col-md-5" placeholder="E-Mail-Adresse"
                               maxlength="95" type="email"
                               required="required">

                        <input type="checkbox" required name="newsletter[check]" value="Value 1"
                               id="ModelFieldValue1"><label for="ModelFieldValue1">Bitte sendet mir
                            euren Newsletter zu.</label>
                    </div>
                    <div class="checkbox"></div>
                    <div class="input submit required">
                        <input type="submit" class="button" value="Newsletter abonnieren">
                    </div>
                </form>
            </div>

        </div>
    </div>