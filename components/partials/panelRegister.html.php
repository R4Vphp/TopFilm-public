<div class='panel'>
    <form-hooks>
        <form id="register" action="/user-register" method="post"></form>
    </form-hooks>
    <h2>Create an account</h2>
    <div class='content'>
        <table>
            <tr><td><label>Username:<label></td><td><input form="register" class="inputField" id='username' name='username' type='text' autocomplete="off" autofocus /></td></tr>
            <tr><td><label>Password:<label></td><td><input form="register" class="inputField" id='password' name='password' type='password' autocomplete="off" /></td></tr>
            <tr><td><label>Confirm password:<label></td><td><input form="register" class="inputField" id='confirmPassword' name='confirmPassword' type='password' autocomplete="off" /></td></tr>
            <tr><td><label>Registration token:<label></td><td><input form="register" class="inputField" id='registrationToken' name='registrationToken' type='text' autocomplete="off" placeholder="XXXX-XXXX"/></td></tr>
            <tr><td><button form="register" class='standardButton' type='submit' >Register</button></td></tr>
        </table>
    </div>
</div>