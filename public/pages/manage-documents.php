<?php \src\helpers\Helper::checkRights(); ?>

<div class="small-12 medium-12 large-12 columns">
    <?php include "includes/backend/nav.inc.php"; ?>
    <h3>Dokumentenverwaltung</h3>
    <p class="note">Lade ein Dokument in den allgemeinen Dokumentenpool hoch. Lade anschließend einen Studenten und
        weise ihm die gewünschten Dokumente zu. Wenn das Dokument schon hochgeladen ist, reicht eine Zuweisung an den
        Stundenten.</p>

    <?php include "includes/backend/studentlist.inc.php"; ?>
    <h3>Dokumente des Benutzers</h3>
    <div id="result">
        <p>... bitte wähle einen Schüler aus der Liste</p>
    </div>

    <h3>Dokumentenpool</h3>
    <div class="row">
        <div class="documentpool small-12 medium-12 large-8 columns">
            <table class="small-12 medium-12 large-11">
                <thead>
                <tr>
                    <th class="note">ID</th>
                    <th class="note">Dateiname</th>
                    <th class="note">Erstellt am:</th>
                    <th class="note" style="text-align: center">Löschen</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($this->global->files as $row => $file) : ?>
                    <tr>
                        <td><?= $file["filepool_id"] ?></td>
                        <td>
                            <a href="<?= __ASSETS__ ?>/files/<?= $file["filepool_filename"] ?>"
                               target="_blank"><?= $file["filepool_filename"] ?></a>
                        </td>
                        <td><?= date("d.m.Y - H:i", strtotime($file["filepool_created"])) ?></td>
                        <td style="text-align: center"><a href="<?= __BASE__ ?>?p=manage-documents&action=delete&delete=<?= $file["filepool_id"] ?>"><i
                                    class="fa fa-times" aria-hidden="true"></i></a></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <div class="upload small-12 medium-12 large-4 columns"
             style="padding: 30px; background: #eee; border-radius: 10px;">
            <h5>Neues Dokument hochladen</h5>
            <form action="" method="post" enctype="multipart/form-data">
                <div>
                    <input type="file" name="upload[file]" value="" id="">
                    <input type="submit" class="button small-12 medium-12 large-12" name="upload[submit]"
                           value="Hochladen">
                </div>
            </form>
        </div>
    </div>

</div>
