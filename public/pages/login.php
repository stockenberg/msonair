<div class="small-12 medium-12 large-12 columns">
    <!-- Users         -->
    <section class="main row">
        <div id="firstStop" class="mainHeader small-12 medium-12 large-12 columns">
            <img src="img/header/kontakt_header.jpg" alt="konzept_header.jpg" title="Konzept Headerbild">
            <div class="mainHeaderTeaser small-12 medium-11 large-11 columns">
            </div>
        </div>
    </section>
    <hr>
    <h1 style="font-size: 30px; text-align: center; font-weight: lighter;">Hier geht es zum Unterricht</h1>
    <hr>    <section class="row panel">
        <div class="users form small-12 large-8 large-offset-2 medium-8 medium-offset-2 columns">
            <form action="<?= __BASE__ ?>?p=login&action=login" id="UserLoginForm" method="post" accept-charset="utf-8">
                <div style="display:none;"><input type="hidden" name="_method" value="POST"></div>
                <h3>
                    Bitte Benutzernamen und Passwort eingeben </h3>
                <div class="input text required"><label for="UserUsername">Benutzername</label><input
                        name="data[Login][username]" maxlength="45" type="text" id="UserUsername" required="required">
                </div>
                <div class="input password required"><label for="UserPassword">Passwort</label><input
                        name="data[Login][password]" type="password" id="UserPassword" required="required"></div>
                <div>
                    <a href="<?= __BASE__ ?>?p=passwort-vergessen">Passwort vergessen?</a>
                </div>
                <div class="input submit">
                    <div class="submit"><input class="button tiny small-12" name="data[Login][submit]" type="submit" value="Login"></div>
                </div>
            </form>
        </div>

    </section>
</div>