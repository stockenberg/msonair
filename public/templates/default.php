<!DOCTYPE html>
<html lang="de">
<head>
	<meta charset="UTF-8"/>
	<title>
		<?= (isset($_GET["p"]) && $_GET["p"] != "startseite") ? ucfirst($_GET["p"] . " - Musiclessons On Air") : "Musiclessons On Air " ?>
		- Lerne von den Profis
	</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
	<link rel="stylesheet" type="text/css" href="css/foundation.min.css"/>
	<meta name="google-site-verification" content="sSHEebwKZbl6V3HEns5tM8990jXyQurvy6PD7FRuKNo"/>

	<link rel="stylesheet" type="text/css" href="css/easing.css"/>
	<link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Open+Sans"/>

	<link rel="stylesheet" type="text/css" href="css/styles.css"/>
	<link rel="stylesheet" type="text/css" href="css/fullcalendar.min.css">
	<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

	<!-- ICON -->
	<link href="libraries/font-awesome-4.6.3/css/font-awesome.min.css" rel="stylesheet">
	<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
	<meta name="description"
	      content="Die Musiclessons On Air bietet qualifizierten Online-Musikunterricht für Jung und Alt, für Anfänger und Fortgeschrittene."/>
	<meta name="keywords"
	      content="musikschuleonair, musikunterricht, musizieren, Musiclessons On Air, dozenten, lehrvideos, online, online-unterricht, klavier, trompete, gitarre, gesang, saxophon, lars seniuk, deutschland, motiviert, online-musikunterricht, musikpädagogik, jazz-trompete, hamburg, berlin, musikstudent, rock, pop, jazz, rock-pop-jazz, bigband, musik-lernen, musiker"/>
</head>
<body>

<div class="off-canvas-wrap" data-offcanvas>
	<a id="top" class="scroll"></a>
	<div id="flashMessage"
	     style="display: none"><?= (!empty($this->status["flash"])) ? "<p>" . $this->status["flash"][0] . "</p>" : "" ?></div>
	<div class="inner-wrap">
		<!-- NAVIGATION BEGINN -->
		<!-- SUB-NAVI -->
		<div class="contain-to-grid show-for-large-up">
			<div class="row">
				<dl class="right sub-nav">
					<?php if (!empty(\src\core\Session::get("logged_user", 0))) : ?>
						<dt></dt>
						<dd style="margin-right: 5px;">Eingeloggt als: <?= \src\core\Session::get("logged_user", 0,
								"user_firstname") ?> <?= \src\core\Session::get("logged_user", 0,
								"user_lastname") ?></dd>
						<dd style="margin-right: 5px;"><a href="<?= __BASE__ ?>?p=profile" class="label success">Mein
						                                                                                         Bereich</a>
						</dd>
						<dd><a href="?logout=true" class="label success">Logout</a></dd>
					<?php else : ?>
						<dt></dt>
						<dd><a href="?p=registrierung" class="label secondary">Registrieren</a></dd>
						<dd><a href="?p=login" class="label success">Login</a></dd>
					<?php endif; ?>

					<!-- <dd><a data-reveal-id="login" class="label success" href="#">Login</a></dd> -->
				</dl>
				<!-- LOGO -->
				<div class="logo small-12 medium-2 medium-uncentered large-3 large-uncentered columns">
					<a href="http://www.musiclessonsonair.de"><img src="img/logo/musiclessons_logo.png"
					                                               alt="musik_onair_final.png"
					                                               title="Logo www.musiclessonsonair.de"/></a>
				</div>
				<!-- TOP-BAR-NAVI -->
				<nav class="top-bar small-12 medium-10 large-9 columns" data-topbar>
					<ul class="title-area">
						<li class="name"></li>
						<!-- Remove the class "menu-icon" to get rid of menu icon. Take out "Menu" to just have icon alone -->
						<li class="toggle-topbar menu-icon"><a href="#"><span>Menü</span></a></li>
					</ul>
					<section class="top-bar-section">
						<!-- Right Nav Section -->
						<ul class="right">
							<!---->
							<li class="active"><a href="?p=startseite">Startseite</a></li>
							<li class="has-dropdown"><a href="?p=konzept">Unterricht</a>
								<ul class="dropdown">
									<li><a href="?p=konzept">Konzept</a></li>
									<li><a href="?p=technik">Technik</a></li>
									<li><a href="?p=team">Wir über uns</a></li>
								</ul>
							</li>
							<li><a href="?p=dozenten">Dozenten</a></li>
							<li><a href="?p=instrumente">Instrumente</a></li>
							<li class="has-dropdown"><a href="?p=buchung">Buchung</a>
								<ul class="dropdown">
									<li><a href="?p=buchung">Buchung/Zahlung</a></li>
									<li><a href="?p=preise">Preise</a></li>
								</ul>
							</li>
							<li class="has-dropdown"><a href="?p=service">Service</a>
								<ul class="dropdown">
								
									<li><a href="?p=faq">FAQ</a></li>
									<li><a href="?p=news">News</a></li>
								</ul>
							</li>
							<li><a href="?p=kontakt">Kontakt</a></li>
						</ul>
					</section>
				</nav>
			</div>
		</div>
		<!-- OFF CANVAS NAVI -->
		<nav class="tab-bar hide-for-large-up">
			<section class="left-small">
				<a href="#" class="left-off-canvas-toggle menu-icon"><span></span></a>
			</section>
			<section class="middle tab-bar-section small-2 medium-1 small-centered columns">
				<img src="img/logo/musiclessons_logo.png" alt="musik_onair_final_wei%C3%9F.png"
				     title="Logo-wei%C3%9F www.musiclessonsonair.de"/></section>
		</nav>
		<!-- Off Canvas Menu -->
		<aside class="left-off-canvas-menu">
			<ul class="off-canvas-list">
				<li><a href="?p=login" class="button [secondary success alert small]">Login</a></li>
				<li><a href="?p=registrierung" class="label secondary">Registrieren</a></li>
				<li class="active"><a href="?p=">Startseite</a></li>
				<li class="has-dropdown"><a href="?p=konzept">Unterricht</a>
					<ul class="dropdown">
						<li><a href="?p=konzept">Konzept</a></li>
						<li><a href="?p=technik">Technik</a></li>
						<li><a href="?p=team">Wir über uns</a></li>
					</ul>
				</li>
				<li><a href="?p=dozenten">Dozenten</a></li>
				<li><a href="?p=instrumente">Instrumente</a></li>
				<li class="has-dropdown"><a href="?p=buchung">Buchung</a>
					<ul class="dropdown">
						<li><a href="?p=preise">Pakete</a></li>
						<!-- <li><a href="?p=pages/angebote">Angebote</a></li> -->
					</ul>
				</li>
				<li class="has-dropdown"><a href="?p=service">Service</a>
					<ul class="dropdown">
					
						<li><a href="?p=faq">FAQ</a></li>
						<li><a href="?p=news">News</a></li>
					</ul>
				</li>
				<li><a href="?p=kontakt">Kontakt</a></li>
				<li><a href="?p=agb">AGB</a></li>
				<li><a href="?p=impressum">Impressum</a></li>
				<li><a href="?p=datenschutz">Datenschutz</a></li>
				<li><a href="//www.musiclessonsonair.de/service">Hilfe</a></li>
			</ul>
		</aside>

		<!-- LOGIN -->
		<div id="login" class="reveal-modal tiny" data-reveal>
			<img src="img/logo/musiclessons_logo.png" alt="musik_onair_final.png"
			     title="Logo www.musiclessonsonair.de"/>            <!-- Form -->
			                                                        <!-- Old Form->create Zeile 210-->
			                                                        <!-- $this->Form->create('User', array('controller' => 'users', 'action' => 'login')); -->
			<form action="/users/login" id="UserDisplayForm" method="post" accept-charset="utf-8">
				<div style="display:none;"><input type="hidden" name="_method" value="POST"/></div>
				<div class="input text required"><input name="username" placeholder="Benutzername/E-Mail" maxlength="45"
				                                        type="text" id="UserUsername" required="required"/></div>
				<div class="input password required"><input name="password" placeholder="Passwort" type="password"
				                                            id="UserPassword" required="required"/></div>
				<button type="submit" class="button expand">Login</button>
			</form>
			<p>Du hast noch keinen Account?<br/> <span><a href="?p=Registers">Jetzt registrieren</a></span></p>
			<a href="#"><span>Passwort vergessen?</span></a>
			<a class="close-reveal-modal">&#215;</a>
		</div>

		<div id="content" class="main-section row">
			<?php include "pages/" . htmlentities($this->siteContent); ?>
		</div>

		<!-- close the off-canvas menu -->
		<a class="exit-off-canvas"></a>
	</div>
</div>
<div id="footer">
	<div class="left small-4 medium-4 large-4 columns">
		<a href="?p=agb">AGB</a> -
		<a href="?p=impressum">Impressum</a> -
		<a href="?p=datenschutz">Datenschutz</a> -
		<a href="?p=service">Hilfe</a>
		                         <!-- <a class="" onclick="location.href='#top'" href="#" data-reveal-id="FAQ">FAQ</a> -->
		<div id="FAQ" class="reveal-modal" data-reveal>
			<h1>FAQ´s</h1>
			<dl class="accordion" data-accordion>
				<dt></dt>
				<dd class="accordion-navigation">
					<a href="#panel1"><h5>Wie läuft der Unterricht über das Internet ab?<i
									class="right fa fa-sort-desc"></i></h5></a>
					<div id="panel1" class="content">
						<p>bei Musiclessons On Air bekommst du Live-Unterricht über das Internet und zusätzlich
						   noch Lehrvideos.</p>
						<p>Mehr zu unserem Unterrichtskonzept erfährst du hier:
							<a href="?p=konzept" title="Konzept">Konzept</a></p>
					</div>
				</dd>
				<dd class="accordion-navigation">
					<a href="#panel2"><h5>Wie schnell muss meine Internetverbindung sein und was brauche ich an
					                      Ausrüstung für meinen
					                      Computer?<i class="right fa fa-sort-desc"></i></h5></a>

					<div id="panel2" class="content">
						<p>Je schneller Ihre Internetverbindung ist, desto besser und reibungsloser läuft auch der
						   Unterricht ab.
						   Außerdem benötigst du eine gute Webcam (die eingebaute Kamera Ihres Laptops überträgt Bild
						   und
						   Ton oft nur unzureichend). Hier [LINK] haben wir dir einige Details dazu
						   aufgeschrieben.</p>
					</div>
				</dd>
				<dd class="accordion-navigation">
					<a href="#panel3"><h5>Muss ich etwas für den Unterricht installieren?<i
									class="right fa fa-sort-desc"></i></h5></a>

					<div id="panel3" class="content">
						<p>Für den Unterricht bei Musiclessons On Air musst du keine Software installieren. Der
						   Unterricht
						   findet direkt über Ihren Internetbrowser statt. Momentan funktioniert unsere Schnittstelle
						   nur unter
						   Google Chrome, Mozilla Firefox und Opera. Bitte installiere einen dieser Browser.<br/>
							<a href="?p=technik">Hier</a> haben wir dir weitere Informationen zu diesem Thema
						   zusammengestellt.</p>
					</div>
				</dd>
				<dd class="accordion-navigation">
					<a href="#panel4"><h5>Wie oft habe ich Unterricht bei meinem Dozenten?<i
									class="right fa fa-sort-desc"></i></h5></a>

					<div id="panel4" class="content">
						<p>Du kannst selbst bestimmen, wann und wie häufig du bei Ihrem Dozenten Unterricht haben
						   willst.
						   Du sind hierbei völlig flexibel und können den Unterricht Ihrem Beruf oder anderen
						   Gegebenheiten
						   anpassen. Um gut voranzukommen, empfehlen wir nach Möglichkeit alle ein bis zwei Wochen eine
						   Unterrichtsstunde bei Ihrem Dozenten zu nehmen.</p>
					</div>
				</dd>
				<dd class="accordion-navigation">
					<a href="#panel5"><h5>Kann ich mir einen Lehrer selbst aussuchen?<i
									class="right fa fa-sort-desc"></i></h5></a>

					<div id="panel5" class="content">
						<p>Ja, du kannst dir deinen Dozenten bei Musiclessons On Air selbst aussuchen und auch
						   jederzeit
						   wechseln, wenn du möchtest. In deinem Login-Bereich findest du einen Kalender, in dem alle
						   verfügbaren Zeiten der einzelnen Dozenten eingetragen sind, sodass du schnell den
						   richtigen Lehrer
						   für dich finden kannst.</p>
					</div>
				</dd>
				<dd class="accordion-navigation">
					<a href="#panel6"><h5>Die Bild- und/oder Soundqualität ist nicht so gut. Woran liegt das und was
					                      kann ich tun?<i class="right fa fa-sort-desc"></i></h5></a>

					<div id="panel6" class="content">
						<p>Bei Bild- und Soundaussetzern könnte Ihre Internetverbindung ein Problem darstellen. Wenn die
						   Qualität des von Ihnen übertragenen Signals generell nicht sehr gut ist, liegt dies
						   vermutlich an Ihrer
						   Webcam. Hier [LINK] findest du einige Empfehlungen, die wir dir zur Hardware
						   zusammengestellt
						   haben.</p>
					</div>
				</dd>
				<dd class="accordion-navigation">
					<a href="#panel7"><h5>Kann ich meine Unterrichtsstunde auch verschieben oder absagen?<i
									class="right fa fa-sort-desc"></i></h5></a>

					<div id="panel7" class="content">
						<p>Ja, die Musiclessons On Air bietet Ihnen als Serviceleistung an, Ihren Unterricht bis
						   spätestens 24
						   Stunden vor Unterrichtsbeginn zu verschieben oder abzusagen. Dies kannst du in deinem Login-
						   Bereich vornehmen.</p>
					</div>
				</dd>
				<dd class="accordion-navigation">
					<a href="#panel8"><h5>Bin ich zu alt, um ein Musikinstrument zu erlernen?<i
									class="right fa fa-sort-desc"></i></h5></a>

					<div id="panel8" class="content">
						<p>Niemand ist zu alt, um Musik zu machen oder ein Musikinstrument zu lernen, und Musizieren
						   bereitet Freude in jedem Alter. Ältere Menschen lernen nicht schlechter oder langsamer als
						   Kinder,
						   sondern anders, und bringen andere Fertigkeiten mit. Unsere pädagogisch erfahrenen Dozenten
						   unterstützen dich in jedem Alter, sodass du rasch auf deinem Instrument vorankommen und Spaß
						   am
						   Musizieren haben kannst.</p>
					</div>
				</dd>
				<dd class="accordion-navigation">
					<a href="#panel9"><h5>Wie häufig muss ich üben?<i class="right fa fa-sort-desc"></i></h5></a>

					<div id="panel9" class="content">
						<p>Generell empfiehlt es sich, möglichst häufig zu üben. Dabei ist es wichtiger, regelmäßig zu
						   üben, als
						   besonders viel an einem Tag zu üben. Aber keine Angst, man kann seine Ziele auf dem
						   Instrument
						   auch erreichen, wenn man nicht jeden Tag Zeit zum Üben hat.</p>
					</div>
				</dd>
				<dd class="accordion-navigation">
					<a href="#panel10"><h5>Gehen die Dozenten der Musiclessons On Air auf meine musikalischen Vorlieben
					                       ein?<i class="right fa fa-sort-desc"></i></h5></a>

					<div id="panel10" class="content">
						<p>Unsere Dozenten versuchen stets, den Unterricht auf Ihre musikalischen Vorlieben abzustimmen.
						   Sprich deinen Dozenten gerne an, wenn du dich für ein spezielles Lied oder eine
						   Musikrichtung
						   besonders interessieren.</p>
					</div>
				</dd>
				<dd class="accordion-navigation">
					<a href="#panel11"><h5>Können auch Minderjährige bei Musiclessons On Air Unterricht nehmen?<i
									class="right fa fa-sort-desc"></i></h5></a>

					<div id="panel11" class="content">
						<p>Ja, auch Kinder und Jugendliche unter 18 Jahren können bei Musiclessons On Air Unterricht
						   nehmen. Hierfür muss die Buchung durch einen Erziehungsberechtigten erfolgen.

						</p>
					</div>
				</dd>
				<dd class="accordion-navigation">
					<a href="#panel12"><h5>Ich bin nicht musikalisch…<i class="right fa fa-sort-desc"></i></h5></a>

					<div id="panel12" class="content">
						<p>Niemand ist unmusikalisch. Nur weil man nicht gut singen kann oder keine Noten lesen kann,
						   kann
						   man trotzdem musikalisch sein. Auch Musizieren ist lernbar.</p>
					</div>
				</dd>
				<dd class="accordion-navigation">
					<a href="#panel13"><h5>Brauche ich irgendwelche Vorbildung, um bei Musiclessons On Air Unterricht
					                       zu nehmen?<i class="right fa fa-sort-desc"></i></h5></a>

					<div id="panel13" class="content">
						<p>Nein, du brauchst keinerlei Vorkenntnisse in Notenlehre oder auf dem Instrument, um bei der
						   Musiclessons On Air Unterricht zu nehmen. Bei Bedarf bringen wir dir alles Nötige gerne
						   bei.</p>
					</div>
				</dd>
				<dd class="accordion-navigation">
					<a href="#panel14"><h5>Benötige ich Unterrichtsmaterialien?<i class="right fa fa-sort-desc"></i>
						</h5></a>

					<div id="panel14" class="content">
						<p>Nein, die Musiclessons On Air stellt Ihnen alle notwendigen Materialien zur Verfügung.</p>
					</div>
				</dd>
				<dd class="accordion-navigation">
					<a href="#panel15"><h5>Kann ich meine Unterrichtsstunden auf jemand anders übertragen?<i
									class="right fa fa-sort-desc"></i></h5></a>

					<div id="panel15" class="content">
						<p>Leider ist es nicht möglich, Unterrichtsbuchungen auf eine andere Person zu übertragen. du
						   kannst
						   aber stattdessen Gutscheine bestellen, die von einer anderen Person eingelöst werden
						   können.</p>
					</div>
				</dd>
				<dd class="accordion-navigation">
					<a href="#panel16"><h5>Was passiert bei technischen Problemen?<i class="right fa fa-sort-desc"></i>
						</h5></a>

					<div id="panel16" class="content">
						<p>Damit möglichst keine technischen Probleme dem Unterricht im Wege stehen, lies dir
						   bitte <a href="?p=technik">hier</a> die Tipps und Empfehlungen zur Technik durch und teste
						   bereits rechtzeitig vor der Unterrichtsstunde im Login-Bereich, ob deine Technik
						   funktioniert. Solltest du weitere Hilfe benötigen, schreib uns jederzeit eine
						   Nachricht über das
							<a href="?p=Contacts">Kontaktformular</a>.
						</p>
					</div>
				</dd>

			</dl>
			<a class="close-reveal-modal">&#215;</a>
		</div>
	</div>
	<div class="middle small-4 medium-4 large-4 columns">
		<a href="www.musiclessonsonair.de">&copy; www.musiclessonsonair.de</a> - <a href="#top">zum Seitenanfang</a>
	</div>
	<div class="right small-4 medium-4 large-4 columns">
		<a href="//www.facebook.com/MusikschuleOnAir" title="Zur Facebook Fanseite" target="_blank"><img
					src="img/icon/fb.png" alt="Facebook Fanpage"/> </a>

	</div>
</div>

<!-- JQuery -->
<script type="text/javascript" src="js/vendor/jquery.js"></script>
<script src="//code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<!-- Foundation -->
<script type="text/javascript" src="js/foundation/foundation.min.js"></script>
<script type="text/javascript" src="js/foundation/foundation.topbar.js"></script>
<script type="text/javascript" src="js/foundation/foundation.offcanvas.js"></script>
<script type="text/javascript" src="js/foundation/foundation.reveal.js"></script>
<!-- Modernizr -->
<script type="text/javascript" src="js/vendor/modernizr.js"></script>
<!-- Global JS Functions-->
<script type="text/javascript" src="js/Main.js"></script>

<script>
    var user = new Main({
        duuuude: <?= (!empty(\src\core\Session::get("logged_user"))) ? \src\core\Session::get("logged_user", 0,
		"user_id") : 0 ?>,
        sweeeeet: '<?= (!empty(\src\core\Session::get("logged_user"))) ? \src\core\Session::get("logged_user", 0,
			"user_intrested_in") : "none" ?>'
    });
</script>

<!-- Site Specific JS -->
<?php if (\src\helpers\Helper::getJS($this->page) != false) : ?>
	<?php foreach (\src\helpers\Helper::getJS($this->page) as $k => $script) : ?>
		<script type="text/javascript" src="js/<?= $script ?>"></script>
	<?php endforeach; ?>
<?php endif; ?>


<script type="text/javascript" src="js/metronome.js"></script>
<!-- Metronome -->
<script>

    $(document).foundation();

    $(document).ready(function () {
		/*
		 $("#RegisterBirthDate").datepicker({
		 monthNames: ['Januar', 'Februar', 'März', 'April', 'Mai', 'Juni',
		 'Juli', 'August', 'September', 'Oktober', 'November', 'Dezember'],
		 monthNamesShort: ['Jan', 'Feb', 'Mär', 'Apr', 'Mai', 'Jun',
		 'Jul', 'Aug', 'Sep', 'Okt', 'Nov', 'Dez'],
		 dayNames: ['Sonntag', 'Montag', 'Dienstag', 'Mittwoch', 'Donnerstag', 'Freitag', 'Samstag'],
		 dayNamesShort: ['So', 'Mo', 'Di', 'Mi', 'Do', 'Fr', 'Sa'],
		 dayNamesMin: ['So', 'Mo', 'Di', 'Mi', 'Do', 'Fr', 'Sa'],
		 showMonthAfterYear: false,
		 dateFormat: 'dd.mm.yy',
		 yearRange: "-70:-18",
		 changeMonth: true,
		 changeYear: true

		 });
		 */

        $(".mobileNav p").click(function () {
            $("#backend_nav").slideToggle(500);
        });

        $('.scroll').on('click', function (e) {
            var href = $(this).attr('href');
            $('html, body').animate({
                scrollTop: $(href).offset().top
            }, 'slow');
            e.preventDefault();
        });

    });

    // METRONOME
    function tick(t) {
        $("<div />").html(t % 2 === 1 ? "Tick" : "Tock").addClass("statusline").appendTo(".status");
        $("#count").html(t);
    }

    function done() {
        $("<div />").html("Done!").addClass("statusline").css("background-color", "#FFFF99").appendTo(".status");
        $("#startstop").html("start");
    }
	/*
	 var paper = Raphael("metronome_container", 200, 250);

	 var m = metronome({
	 len: 200,
	 angle: 20,
	 tick: tick,
	 complete: done,
	 paper: paper,
	 audio: "//github.com/wilson428/metronome/blob/master/tick.wav?raw=true"
	 });

	 m.make_input("#inputs");

	 m.shapes().outline.attr("fill", "#cc1212");
	 m.shapes().arm.attr("stroke", "#EEE");
	 */
    function myTrump() {
        $('#trumpet01').addClass('active');
        $('#trumpet').addClass('active');
    }

    function mySax() {
        $('#saxophon01').addClass('active');
        $('#saxophon').addClass('active');
    }

    function mySing() {
        $('#sing01').addClass('active');
        $('#sing').addClass('active');
    }

    function myGit() {
        $('#gitar01').addClass('active');
        $('#gitar').addClass('active');
    }

    function myKey() {
        $('#keyboard01').addClass('active');
        $('#keyboard').addClass('active');
    }

</script>
</body>
</html>
