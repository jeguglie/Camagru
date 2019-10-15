<?php
    $results = check_mail_activate($_SESSION['username']);
    $mail_activate = $results['new_comment'] == 1 ? 1 : false;
?>
<div class="hero animate">
    <div class="hero-body">
        <div style="padding-top: 0em;" class="container has-text-centered">
            <h1 id="title_top">Manage your profile</h1>
        </div>
    </div>
</div>
<div id="login-section" class="section animate">
    <div class="container">
        <div class="login">
            <div class="icon_profile">
                <span class="icon is-medium is-left">
                    <i class="fas fa-envelope-open-text"></i>
                </span>
            </div></br>
            <h1 id="special_title" class="title">New comments notifications</h1>
            <div class="field has-text-centered">
                <label class="checkbox">
                    <input id="mail_activate" type="checkbox"<?php if ($mail_activate == 1)echo " checked";?>> Send notifications by mail
                </label>
            </div>
            </br></br></br>
            <form action="/app/controller/controller.php?change_username" method="POST">
                <div class="icon_profile">
                    <span class="icon is-medium is-left">
                        <i class="fas fa-user-circle"></i>
                    </span>
                </div></br>
                <h1 id="special_title" class="title">Change your username</h1>
                <div class="field">
                    <p class="control has-icons-left has-icons-right">
                        <input class="input is-medium" name="username" type="mail" placeholder="New Username" required>
                        <span class="icon is-medium is-left">
                            <i class="fas fa-user-circle"></i>
                        </span>
                    </p>
                </div>
                <div class="field">
                    <p class="control has-icons-left has-icons-right">
                        <input class="input is-medium" name="username_confirm" type="mail" placeholder="Confirm New Username" required>
                        <span class="icon is-medium is-left">
                            <i class="fas fa-user-circle"></i>
                        </span>
                    </p>
                          <?php if (isset($_SESSION['change_username'])) {
                                    if ($_SESSION['change_username'] == "not_same")
                                        echo '<p class="help is-danger">Usernames are not identicals</p>';
                                    else if ($_SESSION['change_username'] = "used")
                                        echo '<p class="help is-danger">Username is already used</p>';
                                    unset($_SESSION['change_username']);
                                    }
                          ?>
                </div>
                <input id="login_button change_username" style="width: 100%" type="submit" name="submit" value="Change Username" class="button is-small is-success"></br></br> </br>
            </form></br>
            <form action="/app/controller/controller.php?change_password_by_user" method="POST">
                <div class="icon_profile">
                    <span class="icon is-medium is-left">
                        <i class="fas fa-lock"></i>
                    </span>
                </div></br>
                <h1 id="special_title" class="title">Change your password</h1>
                <div class="field">
                    <p class="control has-icons-left has-icons-right">
                        <input class="input is-medium" name="password" type="password" placeholder="Password" required>
                        <span class="icon is-medium is-left">
                            <i class="fas fa-lock"></i>
                        </span>
                    </p>
                </div>
                <div class="field">
                    <p class="control has-icons-left has-icons-right">
                        <input class="input is-medium" name="new_password" type="password" placeholder="New Password" required>
                        <span class="icon is-medium is-left">
                            <i class="fas fa-lock"></i>
                        </span>
                    </p>
                </div>
                <div class="field">
                    <p class="control has-icons-left has-icons-right">
                        <input class="input is-medium" name="new_password_confirmation" type="password" placeholder="Confirm New Password" required>
                        <span class="icon is-medium is-left">
                            <i class="fas fa-lock"></i>
                        </span>
                    </p>
                    <?php if (isset($_SESSION['change_password_success'])) {
                        if ($_SESSION['change_password_success'] == "not_same")
                            echo '<p class="help is-danger">Passwords are not identicals</p>';
                        if ($_SESSION['change_password_success'] == "error_old_password")
                            echo '<p class="help is-danger">Actual password is wrong</p>';
                        unset($_SESSION['change_password_success']);
                    }
                    ?>
                </div>
                <input id="login_button change_password" style="width: 100%" type="submit" name="submit" value="Change Password" class="button is-small is-success"></br> </br> </br>
            </form></br>
            <form action="/app/controller/controller.php?change_mail" method="POST">
                <div class="icon_profile">
                    <span class="icon is-medium is-left">
                        <i class="fas fa-envelope"></i>
                    </span>
                </div></br>
                <h1 id="special_title" class="title">Change your mail<h1>
                <div class="field">
                    <p class="control has-icons-left has-icons-right">
                        <input class="input is-medium" name="mail" type="mail" placeholder="New Mail" required>
                        <span class="icon is-medium is-left">
                            <i class="fas fa-envelope"></i>
                        </span>
                    </p>
                </div>
                <div class="field">
                    <p class="control has-icons-left has-icons-right">
                        <input class="input is-medium" name="mail_confirm" type="mail" placeholder="Confirm New Mail" required>
                        <span class="icon is-medium is-left">
                            <i class="fas fa-envelope"></i>
                        </span>
                    </p>
                    <?php
                    if (isset($_SESSION['change_mail']))
                    {
                        if ($_SESSION['change_mail'] == "not_same")
                            echo '<p class="help is-danger">Mails are not identicals</p>';
                        if ($_SESSION['change_mail'] == "used")
                            echo '<p class="help is-danger">This mail is already used</p>';
                        if ($_SESSION['change_mail'] == "not_valid")
                            echo '<p class="help is-danger">Not a valid mail</p>';
                        unset($_SESSION['change_mail']);
                    }
                    ?>
                </div>
                <input id="login_button change_mail" style="width: 100%" type="submit" name="submit" value="Change Mail" class="button is-small is-success">
            </form>
        </div>
    </div>
</div>

<script>
    let mail_activate = document.querySelector('#mail_activate');
    mail_activate.addEventListener('change', function(){
        let checked = this.checked;
        checked = checked == false ? 0 : 1;
        var hr = new XMLHttpRequest();
        var url = "/app/controller/controller.php?set_comment_notifications";
        var vars = "checked=" + checked;

        hr.open("POST", url, true);
        hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        hr.setRequestHeader('cache-control', 'no-cache, must-revalidate, post-check=0, pre-check=0');
        hr.send(vars);
    });
</script>
