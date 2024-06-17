<?php

$id = $list->getListId();
$title = $list->getTitle();
$size = $list->getElementsCount();
$counter = ($size ? $size : count($list->load()));

?>
<label>
    <li class='listTile'>
        <div class='top-info'>
            <h4>
                <b><?= $title; ?></b>
                <span>(<?= $counter; ?>)</span>
            </h4>
        </div>
    </li>
</label>