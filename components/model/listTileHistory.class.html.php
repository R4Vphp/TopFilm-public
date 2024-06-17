<?php

$time = date("d/m/Y H:i:s", $e["occuredAt"]);
$ip = $e["ipAddress"];
$feedback = ($e["succeeded"] ? self::LOGIN_SUCCEEDED : self::LOGIN_FAILED);

?>
<label>
    <li class='listTile'>
        <div class='top-info'>
            <h4><?= $time; ?> <span><?= $feedback; ?></span></h4>
            <p><?= $ip; ?></p>
        </div>
    </li>
</label>