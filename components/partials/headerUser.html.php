<header>
    <form-hooks>
        <form id="logout" action="/user-logout" method="post"></form>
    </form-hooks>
    <div class="left">
        <a href="./">
            <img src="<?= App\Utility\Resource::load("/style/images/movie_icon.svg") ?>" height="40px"/>
        </a>
        <h1>Top Film</h1>
    </div>
    <div class="right">
        <p><?= $_USER->getUsername(); ?> <button form="logout" type="submit" class="standardButton" name="logout">Logout</button></p>
    </div>
</header>