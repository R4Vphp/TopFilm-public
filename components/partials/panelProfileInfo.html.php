<div class='panel'>
    <h2><?= $_USER->getUsername(); ?> <span>(<?= round($_USER->getWatchedTime() / 60, 0); ?> h)</span></h2>
    <div class='content'>
        <table>
            <tr>
                <td><p class="details">Account created:</p></td><td><?= date("d/m/Y", $_USER->getRegisterDate()); ?></td>
            </tr>
            <tr>
                <td><p class="details">Change password:</p></td><td><a href="/profile/change-password">here</a></td>
            </tr>
            <tr>
                <td><p class="details">Login history:</p></td><td><a href="/profile/login-history">here</a></td>
            </tr>
        </table>
    </div>
</div>