<div class="small-12 medium-12 large-12 columns">
    <!-- Instrumente         -->
    <div style="width:0px; height:0px; visibility: hidden;">
        <img src="img/instrumente/trumpet_weis.jpg" alt="Trompete" title="zum Instrument Trompete">    <img src="img/instrumente/trumpet.jpg" alt="Trompete" title="zum Instrument Trompete">    <img src="img/instrumente/saxophon_weis.jpg" alt="Saxophone" title="zum Instrument Saxophone">    <img src="img/instrumente/saxophon.jpg" alt="Saxophone" title="zum Instrument Saxophone">    <img src="img/instrumente/sing_weis.jpg" alt="Mikrofone für Gesang" title="zu Gesang">    <img src="img/instrumente/sing.jpg" alt="Mikrofone für Gesang" title="zu Gesang">    <img src="img/instrumente/gitarre_weis.jpg" alt="Gitarre" title="zum Instrument Gitarre">    <img src="img/instrumente/gitarre.jpg" alt="Gitarre" title="zum Instrument Gitarre">    <img src="img/instrumente/klavier_kombi_weis.jpg" alt="Klavier" title="zum Instrument Klavier">    <img src="img/instrumente/klavier_kombi.jpg" alt="Klavier" title="zum Instrument Klavier"></div>

    <section class="mainInstrumente row show30 ">
        <a href="#trumpet01" onclick="myTrump()">
            <figure style="border: none;" class="trumpet large-3 columns">
                <figcaption><h5>Trompete</h5></figcaption>
            </figure>
        </a>
        <a href="#saxophon01" onclick="mySax()">
            <figure class="saxophon large-3 columns">
                <figcaption><h5>Saxophon</h5></figcaption>
            </figure>
        </a>
        <a href="#sing01" onclick="mySing()">
            <figure class="sing large-3 columns">
                <figcaption><h5>Gesang</h5></figcaption>
            </figure>
        </a>
        <a href="#gitar01" onclick="myGit()">
            <figure class="gitar large-3 columns">
                <figcaption><h5>Gitarre</h5></figcaption>
            </figure>
        </a>
        <a href="#keyboard01" onclick="myKey()">
            <figure class="keyboard large-3 columns">
                <figcaption><h5>Klavier / Keyboard</h5></figcaption>
            </figure>
        </a>
    </section>
    <section class="mainInstrumente row hide30">
        <a style="margin-bottom: 5px;" href="#trumpet01" class="button success alert expand" onclick="myTrump()">Trompete</a>
        <a style="margin-bottom: 5px;" href="#saxophon01" class="button success alert expand" onclick="mySax()">Saxophon</a>
        <a style="margin-bottom: 5px;" href="#sing01" class="button success alert expand" onclick="mySing()">Gesang</a>
        <a style="margin-bottom: 5px;" href="#gitar01" class="button success alert expand" onclick="myGit()">Gitarre</a>
        <a href="#keyboard01" class="button success alert expand" onclick="myKey()">Klavier / Keyboard</a>
    </section>
    <section id="mainContentInstrumente">
        <h3>Die Unterrichtsfächer der Musiclessons On Air</h3>

        <p>Hier findest du eine Übersicht der Instrumente, die du bei Musiclessons On Air erlernen kannst. Wenn du auf
            eines der Instrumente klicken, erhälst du mehr Informationen. Wir erweitern ständig unser Angebot, um dir
            noch mehr Fächer anbieten zu können. Wenn du
            Wünsche für weitere Instrumente hast, kannst du uns auch gerne eine Nachricht senden.</p>
        <a href="<?= __BASE__ ?>?p=kontakt" class="button success alert" title="Zum Kontaktformular der Musiclessons On Air">Zum Kontaktformular</a>
        <dl class="accordion" data-accordion="">
            <dt></dt>
            <dd id="trumpet01" class="accordion-navigation">
                <a href="#trumpet"><h5>Trompete</h5></a>

                <div id="trumpet" class="content">
                    <div class="row">
                        <div class="pic small-12 medium-4 large-4 columns">
                            <p><img src="img/instrumente/trumpet_2.jpg" alt="Mann spielt Trompete"></p>
                        </div>
                        <div class="content small-12 medium-8 large-8 columns">
                            <p>Egal ob im Blasorchester, einer Bigband oder einfach für dich selbst, mit der Trompete kann man
                                überall spielen. Und kaum ein Instrument ist so anspruchsvoll wie die Trompete. Egal ob der Ansatz,
                                die richtige Atmung, Tonhöhe, Ausdauer, Stoß, Sound, Phrasierung oder Improvisation – unsere Top-Profis
                                können dir bei allen musikalischen und technischen Problemen helfen. Dein Dozent
                                beantwortet gerne deine Fragen, geht individuell auf deine Probleme ein und gibt dir Übungen, die
                                dich auf deinem Instrument weiterbringen.
                            </p>
                            <a class="right" href="#top"><span>nach oben</span></a>
                        </div>
                    </div>
                </div>
            </dd>
            <dd id="saxophon01" class="accordion-navigation">
                <a href="#saxophon"><h5>Saxophon</h5></a>

                <div id="saxophon" class="content">
                    <div class="row">
                        <div class="pic small-12 medium-4 large-4 columns">
                            <p><img src="img/instrumente/saxophon_2.jpg" alt="Mann spielt Saxophon"></p>
                        </div>
                        <div class="content small-12 medium-8 large-8 columns">
                            <p>Egal ob Tenor-, Alt-, oder Sopransaxophon, egal ob Blasorchester, Bigband, Jazztrio oder einfach für
                                dich selbst, unsere Dozenten helfen dir, deine individuellen Ziele zu erreichen. Du willst besser
                                improvisieren oder schnellere Läufe spielen können? Du möchtest etwas über die richtige Atmung,
                                den Anstoß oder Fingertechnik lernen? Dein professioneller Coach beantwortet gerne deine Fragen,
                                geht individuell auf deine Probleme ein und gibt dir Übungen, die dich auf deinem Instrument
                                weiterbringen.
                            </p>
                            <a class="right" href="#top"><span>nach oben</span></a>
                        </div>
                    </div>
                </div>
            </dd>
            <dd id="sing01" class="accordion-navigation">
                <a href="#sing"><h5>Gesang (Pop/Rock/Jazz)</h5></a>

                <div id="sing" class="content">
                    <div class="row">
                        <div class="pic small-12 medium-4 large-4 columns">

                            <p><img src="img/instrumente/sing_2.jpg" alt="Singende Frau am Laptop"></p>
                        </div>
                        <div class="content small-12 medium-8 large-8 columns">
                            <p>Wie singe ich gesund? Wie schaffe ich es, einen kräftigen und coolen Sound zu bekommen? Wie kann
                                ich meinen Tonumfang erweitern? Egal ob im Chor, mit Band oder einfach für dich zu Hause – unsere
                                Dozenten helfen dir, alles aus deiner Stimme herauszuholen.
                            </p>
                            <a class="right" href="#top"><span>nach oben</span></a>
                        </div>
                    </div>
                </div>
            </dd>
            <dd id="gitar01" class="accordion-navigation">
                <a href="#gitar"><h5>Gitarre</h5></a>

                <div id="gitar" class="content">
                    <div class="row">
                        <div class="pic small-12 medium-4 large-4 columns">
                            <p><img src="img/instrumente/gitarre_2.jpg" alt="Mann lernt Gitarre am Online"></p>
                        </div>
                        <div class="content small-12 medium-8 large-8 columns">
                            <p>Egal ob Akustik- oder E-Gitarre, egal ob du Solos oder Akkordbegleitungen spielen willst, ob es dir um
                                einen fetten Sound oder Fingertechnik geht – unsere Dozenten gehen gerne auf deine Wünsche ein.
                                Schau den Profis auf die Hände und lerne neue Tipps und Tricks – für schnellen Fortschritt auf dem
                                Instrument und Spaß am Musizieren.
                            </p>
                            <a class="right" href="#top"><span>nach oben</span></a>
                        </div>
                    </div>
                </div>
            </dd>
            <dd id="keyboard01" class="accordion-navigation">
                <a href="#keyboard"><h5>Klavier/Keyboard</h5></a>

                <div id="keyboard" class="content ">
                    <div class="row">
                        <div class="pic small-12 medium-4 large-4 columns">
                            <p><img src="img/instrumente/klavier_kombi_2.jpg" alt="Klavier Lernen"></p>
                        </div>
                        <div class="content small-12 medium-8 large-8 columns">
                            <p>Wie kann ich schneller spielen? Wie benutze ich das Pedal bei klassischen Stücken sauberer? Wie
                                improvisiere ich besser? Welche Fingerübungen helfen mir am besten? Egal ob du lieber Pop, Jazz,
                                Blues oder Klassik auf dem Klavier oder Keyboard spielst – unsere Dozenten gehen gerne auf deine
                                Wünsche ein. Du erhältst wertvolle Tipps und Übungen und kannst den Profis auf die Finger schauen
                                – für schnellen Fortschritt auf dem Instrument und Spaß am Musizieren.
                            </p>
                            <a class="right" href="#top"><span>nach oben</span></a>
                        </div>
                    </div>
                </div>
            </dd>
        </dl>
    </section>            </div>