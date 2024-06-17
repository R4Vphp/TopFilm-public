<!DOCTYPE html>
<html lang="en">
<?php
require_once("../components/headDefault.html.php");
require_once("../components/headUser.html.php");
?>
<body>
<?php
require_once("../components/headerUser.html.php");
require_once("../components/navigationUser.html.php");
?>
<main>
<?php
$manager = new ListManager;
$manager->setUserLists($list = ListManager::single($_GET[0] ?? 0));
$manager->printUserLists();
require_once("../components/panelListEdit.html.php");
?>
</main>
<?php
require_once("../components/footer.html.php");
?>    
</body>
</html>