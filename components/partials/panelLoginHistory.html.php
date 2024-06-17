<?php
use App\Model\LoginHistory;

$history = new LoginHistory;
$elements = LoginHistory::load();
?>
<div class='panel'>
    <h2>Login history <span>(<?= count($elements); ?>)</span></h2>
    <div class="content limit">
        <?php $history->printElements($elements); ?>
    </div>
</div>
