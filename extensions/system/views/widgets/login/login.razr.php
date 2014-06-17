<form class="uk-form" action="@url.route('@system/auth/authenticate')" method="post">

    <div class="uk-form-row">
        <input class="uk-width-1-1" type="text" name="credentials[username]" value="@last_username" placeholder="@trans('username')" autofocus>
    </div>
    <div class="uk-form-row">
        <input class="uk-width-1-1" type="password" name="credentials[password]" value="" placeholder="@trans('password')">
    </div>
    <div class="uk-form-row">
        <input class="uk-button uk-button-primary uk-width-1-1" type="submit" value="@trans('Login')">
    </div>
    
    <p>
        <label><input type="checkbox" name="@remember_me_param"> @trans('Remember Me')</label>
        <br><a href="@url.route('@system/resetpassword')">@trans('Forgot Password?')</a>
        @if (app.option.get('system:user.registration', 'admin') != 'admin')
        <br><a href="@url.route('@system/registration')">@trans('Sign up')</a>
        @endif
    </p>

    <input type="hidden" name="redirect" value="@redirect">
    @token()
</form>