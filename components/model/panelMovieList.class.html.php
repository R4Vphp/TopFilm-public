<?php
use App\Model\User;
use App\Model\List\Manager;
use App\Controller\List\Sorting;

$elements = $this->setElements($this->load());
?>
<div class='panel'>
    <form-hooks>
        <form id="browser<?= $this->id ?>" action="/list-browse" method="post"></form>
        <form id="regrouper<?= $this->id ?>" action="/movie-selection-regroup" method="post"></form>
    </form-hooks>

    <h2><?= $this->title; ?> <span>(<?= $this->size; ?>)</span></h2>

    <div class="content">
        <input form="browser<?= $this->id ?>" type="hidden" name="initialList" value="<?= $this->id; ?>" />
        <input form="browser<?= $this->id ?>" type="text" class="inputField" name="userQuery" value="<?= $this->getBrowser()->getQuery() ?>" placeholder="TYPE HERE..."/>
        <select form="browser<?= $this->id ?>" name="orderBy">
            <?php
            Sorting::print($this->getBrowser()->getSorting());
            ?>
        </select>
        <button form="browser<?= $this->id ?>" type="submit" class="standardButton" value="search">Search</button>
    </div>
    <div class="content limit">
        <?php $this->printElements($elements); ?>
    </div>
    <div class='content'>
        <p class='selectedMovies'>Selected movies:</p>
        <hr>
        <input form="regrouper<?= $this->id ?>" type="hidden" name="initialList" value="<?= $this->id ?>" />

        <button form="regrouper<?= $this->id ?>" class="standardButton" type="submit" name="operation" value="MOVE" >Move</button>
        <button form="regrouper<?= $this->id ?>" class="standardButton" type="submit" name="operation" value="COPY" >Copy</button>
        <select form="regrouper<?= $this->id ?>" name="targetList">
            <option value="0">Target list</option>
            <?php Manager::get()->printAsOption($this->id); ?>
        </select>
        /
        <button form="regrouper<?= $this->id ?>" class="standardButton" type="submit" name="operation" value="STATUS" >Set</button>
        <select form="regrouper<?= $this->id ?>" name="groupStatus">
            <option value="1">Watched</option>
            <option value="0">Not watched</option>
        </select>
        <hr>
        <button form="regrouper<?= $this->id ?>" class="standardButton" type="submit" name="operation" value="DELETE" >Delete</button>
    </div>
</div>
