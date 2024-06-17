<div class='panel'>
    <form-hooks>
        <form id="login" action="/user-login" method="post"></form>
    </form-hooks>
    <h2>Login to your account</h2>
    <div class='content'>
        <table>
            <tr><td><label>Username:<label></td><td><input form="login" class="inputField" id='username' name='username' type='text' autocomplete="off" autofocus /></td></tr>
            <tr><td><label>Password:<label></td><td><input form="login" class="inputField" id='password' name='password' type='password' autocomplete="off" /></td></tr>
            <tr><td><button form="login" class='standardButton' type='submit' >Login</button></td></tr>
        </table>
    </div>
</div>