<div class="small-12 medium-12 large-12 columns">
    <!-- News         -->
    <section class="main row">
        <div id="firstStop" class="mainHeader small-12 medium-12 large-12 columns">
            <img src="img/header/news_header.jpg" alt="News, Specials und Angebote">
            <div class="mainHeaderTeaser small-12 medium-11 large-11 columns">

            </div>
        </div>
    </section>
    <hr>
    <h1 style="font-size: 30px; text-align: center; font-weight: lighter;"><?= $_POST["success"] ?? "Spezialangebote und Neuigkeiten rund um die
        Musikschule
        On Air"?></h1>
    <hr>
    <section id="mainContent">
        <div class="row">
            <div class="small-12 medium-7 large-7 columns">
                <h3>News / Specials / Angebote</h3>
                <p>
                    Exklusive Coachings mit dem Ausnahmetrompeter <br> <strong>Ingolf Burkhardt</strong>.
                    Im Juni 2017 unterrichtet der Trompeter der <strong>NDR Bigband</strong> und Yamaha Artist bei Musiclessons On Air.
                </p>
                <!--
                <p>Auf dieser Seite präsentieren wir Spezialangebote und Neuigkeiten rund um Musiclessons On Air.
                    Wenn du gerne auf dem Laufenden gehalten werden möchtest, kannst du auch unseren Newsletter
                    abonnieren. Dieser informiert dich regelmäßig über Angebote und News und kann selbstverständlich
                    jederzeit ganz unkompliziert wieder abbestellt werden.
                </p> -->
            </div>
            <div class="small-12 medium-4 large-4 columns">
                <h3>Anmeldung Newsletter</h3>
                <form action="" id="ContactDisplayForm" method="post" accept-charset="utf-8">
                    <div class="input email required">
                        <input name="newsletter[email]" placeholder="E-Mail-Adresse" type="email" id="ContactEmail"
                               required="required">
                    </div>
                    <div class="checkbox">
                        <input type="checkbox" name="newsletter[accepted]" value="1" id="ModelFieldValue1">
                        <label for="ModelFieldValue1">Bitte sendet mir euren Newsletter zu.</label>
                    </div>
                    <input type="submit" class="expand button small" name="newsletter[submit]" value="Senden">
                </form>
            </div>
        </div>
    </section>
</div>