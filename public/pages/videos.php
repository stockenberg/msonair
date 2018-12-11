<div class="small-12 medium-12 large-12 columns">
    <?php include "includes/backend/nav.inc.php"; ?>

    <h3>Meine Videos</h3>
    <p class="note">Hier findest du Lehrvideos, die dein Dozent für dich freischaltet.
    </p>
    <div class="flex-video" style="display: none;">
        <video autoplay="autoplay" controls="controls" id="video">
            <source type="video/mp4" src="">
        </video>
    </div>
    <?php foreach ($this->global->videos as $row => $video) : ?>
        <div class="row">
            <a class="button small-12 medium-12 large-12" href="#"
               onclick="videoLoad(event, '<?= __ASSETS__ . 'videos/lessons/' . \src\core\Session::get("logged_user", 0,
                   "user_intrested_in") . '/' . $video["video_title"] ?>')"
            ><?= $video["video_title"] ?></a>
        </div>
    <?php endforeach; ?>

</div>
