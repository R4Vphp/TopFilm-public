<?php
use App\Controller\Movie\Rater;
use App\Utility\Time;
?>
<label>
        <li class='listTile <?= ($this->watched ? "watched" : null); ?>'>
            <input form="regrouper<?= $this->originListId ?? 0 ?>" type='checkbox' class='checkboxInput hidden' name='selectedMovies[]' value='<?= $this->id?>'>
            <div class='top-info'>
                <h4>
                    <b><?= $this->polishTitle; ?></b>
                    <span>(<?= $this->productionYear; ?>)</span>
                    <?php
                    if($this->isNew()){
                    ?>
                    <b class='highlight'>Recent upload!</b>
                    <?php
                    }
                    ?>
                </h4>
                <p>
                <?= ($this->watched ? ($this->rating == 0 ? "?" : $this->rating)."/10" : null) ?>
                <span><?= Time::formatTime($this->getDuration() * Time::MINUTE); ?></span></p>
            </div>
            <div class='further-info'>
                <div class='details'>

                <p><?= (($this->polishTitle != $this->originalTitle) ? $this->originalTitle : null) ?></p> 
                <p><span><?= $this->director->getFullName() ?></span></p>

                <form-hooks>
                    <form id="rater<?= $this->id ?>" action="/movie-rate" method="post"></form>
                </form-hooks>
                <span>Rating:</span>
                <select form="rater<?= $this->id ?>" name="movieRating">
                    <?php Rater::options($this->getRating()); ?>
                </select>
                <button form="rater<?= $this->id ?>" type="submit" class="standardButton" name="RATE" value="<?= $this->id ?>" >Rate</button>
                </div>
                <a href='<?= $this->generateLink(); ?>' target='_blank' class='filmwebImage'>
                    <img src='<?= $this->generateImage(); ?>' width='75px' />
                </a>
            </div>
        </li>
    </label>