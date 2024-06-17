<?php

App\Controller\Authorization\Logging::logoutAccount();

App\Routing\Router::redirect("/login");