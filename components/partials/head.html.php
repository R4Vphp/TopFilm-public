<?php
use App\Utility\Resource;

$_USER = App\Model\User::getLogged();
?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= Resource::load("/style/style.css") ?>">
    <link rel="shortcut icon" href="<?= Resource::load("/style/images/movie_icon.svg") ?>">
    <title>TopFilm</title>
</head>
<!--
    <?php
        var_dump($_SESSION)
    ?>
-->