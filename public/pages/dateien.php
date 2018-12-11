<div class="small-12 medium-12 large-12">
    <?php include "includes/backend/nav.inc.php"; ?>

    <h3>Meine Dateien</h3>
    <p class="note">Hier findest du Dateien, die dein Dozent für dich hochlädt.</p>
        <?php foreach ($this->global->files as $row => $file) :
            $name = explode(".", $file["filepool_filename"]);
            $path = __ASSETS__ . 'files/' . $file['filepool_filename'];
            ?>
            <div class="row">
                <a target="_blank" class="button small-12 medium-12 large-12" download="<?= __ASSETS__ ?>/files/<?= $file["filepool_filename"] ?>"
                   href="<?= __ASSETS__ ?>/files/<?= $file["filepool_filename"] ?>"><?= $name[0] ?></a>
            </div>
        <?php endforeach; ?>
</div>
