<section style="margin-bottom: 30px;" class="main row">
    <div id="firstStop" class="mainHeader small-12 medium-12 large-12 columns">
        <img src="img/header/myschool_header.jpg" alt="konzept_header.jpg" title="Konzept Headerbild">
        <div class="mainHeaderTeaser small-12 medium-11 large-11 columns">
        </div>
    </div>
</section>
<hr>
<h1 style="font-size: 20px; text-align: center; font-weight: lighter;">Herzlich willkommen in deinem persönlichen Bereich</h1>
<hr>

<div class="mobileNav">
    <p>Menu</p>
</div>
<div id="backend_nav" style="">
    <dl style="margin-bottom: 30px;" class="sub-nav">
            <dd class="<?= ($_GET["p"] == "profile") ? "active" : "" ?>"><a
                    href="<?= __BASE__ ?>?p=profile">Mein Konto</a></dd>
        <?php
        /** Both Admin and Teacher have the Elements */

        /** just Admin has the Elements */
        if (\src\core\Session::getStatus() == __ADMIN__) : ?>
            <dd class="<?= ($_GET["p"] == "manage-calendar") ? "active" : "" ?>"><a
                    href="<?= __BASE__ ?>?p=manage-calendar">Kalender</a></dd>
            <dd class="<?= ($_GET["p"] == "unterrichtsraum") ? "active" : "" ?>"><a
                    href="<?= __BASE__ ?>?p=unterrichtsraum">Unterrichtsraum</a></dd>
            <dd class="<?= ($_GET["p"] == "manage-videos") ? "active" : "" ?>"><a
                    href="<?= __BASE__ ?>?p=manage-videos">Videoverwaltung</a></dd>
            <dd class="<?= ($_GET["p"] == "manage-documents") ? "active" : "" ?>"><a
                    href="<?= __BASE__ ?>?p=manage-documents">Dateiverwaltung</a></dd>
            <dd class="<?= ($_GET["p"] == "manage-students") ? "active" : "" ?>"><a
                    href="<?= __BASE__ ?>?p=manage-students">Schülerverwaltung</a></dd>
            <dd class="<?= ($_GET["p"] == "manage-lecturers") ? "active" : "" ?>"><a
                    href="<?= __BASE__ ?>?p=manage-lecturers">Dozentenverwaltung</a></dd>

        <?php endif; ?>

        <?php
        /** just Teacher has the Elements */
        if (\src\core\Session::getStatus() == __TEACHER__) : ?>
            <dd class="<?= ($_GET["p"] == "kalender") ? "active" : "" ?>"><a
                    href="<?= __BASE__ ?>?p=kalender">Kalender</a></dd>
            <dd class="<?= ($_GET["p"] == "unterrichtsraum") ? "active" : "" ?>"><a
                    href="<?= __BASE__ ?>?p=unterrichtsraum">Unterrichtsraum</a></dd>
            <?php if(\src\core\Session::get("logged_user", 0, "user_skill") != __HEAVYTONES__) :  ?>
            <dd class="<?= ($_GET["p"] == "manage-videos") ? "active" : "" ?>"><a
                    href="<?= __BASE__ ?>?p=manage-videos">Videoverwaltung</a></dd>
            <?php endif; ?>
            <dd class="<?= ($_GET["p"] == "manage-documents") ? "active" : "" ?>"><a
                    href="<?= __BASE__ ?>?p=manage-documents">Dateiverwaltung</a></dd>
        <?php endif; ?>

        <?php
        /** just Student has the Elements */
        if (\src\core\Session::getStatus() == __STUDENT__) : ?>
            <dd class="<?= ($_GET["p"] == "kalender") ? "active" : "" ?>"><a
                    href="<?= __BASE__ ?>?p=kalender">Kalender</a></dd>
            <dd class="<?= ($_GET["p"] == "unterrichtsraum") ? "active" : "" ?>"><a
                    href="<?= __BASE__ ?>?p=unterrichtsraum">Unterrichtsraum</a></dd>
            <dd class="<?= ($_GET["p"] == "dateien") ? "active" : "" ?>"><a
                    href="<?= __BASE__ ?>?p=dateien">Dateien</a></dd>
            <dd class="<?= ($_GET["p"] == "videos") ? "active" : "" ?>"><a
                    href="<?= __BASE__ ?>?p=videos">Videos</a></dd>

        <?php endif; ?>
    </dl>
</div>