<?php
use App\Model\List\Manager;
?>
<!DOCTYPE html>
<html lang="en">
<?php
include_once BASE_PATH . "/components/partials/head.html.php";
?>
<body>
<?php
include_once BASE_PATH . "/components/partials/headerUser.html.php";
include_once BASE_PATH . "/components/partials/navigationUser.html.php";
?>
<main>
<?php
$manager = Manager::get();
$manager->printUserLists();
?>
</main>
<?php
include_once BASE_PATH . "/components/partials/footer.html.php";
?>    
</body>
</html>
<?php
?>