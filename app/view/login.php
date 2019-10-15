<?php

if (isset($_GET['forgot']))
{
    $error = "";
    if (isset($_SESSION['change_password_success']) && $_SESSION['change_password_success'] == "not_same"){
        $error = "<p class=\"help is-danger\">Passwords are not identicals</p>";
    }
    echo "
    <div id=\"login-section\" class=\"section animate\">
        <div class=\"container\">
            <div class=\"login\">
                <form action=\"/app/controller/controller.php?mail_password\" method=\"POST\">
                    <h1 id=\"special_title\" class=\"title\">
                        Reset your password
                    </h1>
                    <div class=\"field\">
                        <p class=\"control has-icons-left has-icons-right\">
                            <input class=\"input is-medium\" type=\"text\" name=\"username\" placeholder=\"Username\" required>
                            <span class=\"icon is-medium is-left\">
                                <i class=\"fas fa-user-circle\"></i>
                            </span>
                        </p>
                    </div>
                    <div class=\"field\">
                        <p class=\"control has-icons-left has-icons-right\">
                            <input class=\"input is-medium\" name=\"mail\" type=\"mail\" placeholder=\"Mail\" required>
                            <span class=\"icon is-medium is-left\">
                                <i class=\"fas fa-envelope\"></i>
                            </span>
                        </p>
                    </div>
                    $error
                    <input id=\"login_button\" style=\"width: 100%\" type=\"submit\" name=\"submit\" value=\"Send mail\" class=\"button is-small is-success\">
                </form>
            </div>
        </div>
    </div>";
}

else if (isset($_GET['login']) && isset($_GET['mail_password_confirmation']) && isset($_GET['username']) && isset($_GET['password_key']))
{
  $bdd_password_key = mail_password_confirmation($_GET['username'], $_GET['password_key']);
  $error = "";
  if (isset($_SESSION['change_password_success']) && $_SESSION['change_password_success'] == "not_same")
      $error = "<p class=\"help is-danger\">Passwords are not identicals.</p>";
  if ($_GET['password_key'] == $bdd_password_key)
  {
      $password_key = $_GET['password_key'];
      $username = $_GET['username'];
    echo "  <div id=\"login-section\" class=\"section animate\">
                <div class=\"container\">
                    <div class=\"login\">
                        <form action=\"/app/controller/controller.php?change_password_by_forgot&username=$username&password_key=$password_key\" method=\"POST\">
                            <h1 id=\"special_title\" class=\"title\">Reset your password</h1>
                            <div class=\"field\">
                                <p class=\"control has-icons-left has-icons-right\">
                                    <input class=\"input is-medium\" name=\"password\" type=\"password\" placeholder=\"New Password\" required>
                                    <span class=\"icon is-medium is-left\">
                                        <i class=\"fas fa-lock\"></i>
                                    </span>
                                </p>
                            </div>
                            <div class=\"field\">
                                <p class=\"control has-icons-left has-icons-right\">
                                    <input class=\"input is-medium\" name=\"password_confirm\" type=\"password\" placeholder=\"Confirm New Password\" required>
                                        <span class=\"icon is-medium is-left\">
                                            <i class=\"fas fa-lock\"></i>
                                        </span>
                                </p>
                                $error
                            </div>
                            <input id=\"login_button\" style=\"width: 100%\" type=\"submit\" name=\"submit\" value=\"Change password\" class=\"button is-small is-success\">
                        </form>
                    </div>
                </div>
            </div>";
  }
}
else
{
    if (!isset($_SESSION['username']))
    {
        $error = array();
        if (isset($_SESSION['username_error'])){
            $error[0] = "<p class=\"help is-danger\">Wrong username or password</p>";
            unset($_SESSION['username_error']);
        }
        if (isset($_SESSION['username_used'])) {
            $error[1] = "<p class=\"help is-danger\">Username is already used</p>";
            unset($_SESSION['username_used']);
        }
        if (isset($_SESSION['password_not_strong']))
            $error[2] = "<p class=\"help is-danger\">Password not strong</p>";
        if (isset($_SESSION['password_not_same']))
            $error[3] = "<p class=\"help is-danger\">Passwords are not identicals</p>";
        if (isset($_SESSION['mail_error']))
            $error[4] = "<p class=\"help is-danger\">Not a valid mail.</p>";

        echo "  <div id=\"login-section\" class=\"section animate\">
                    <div class=\"container\">
                        <div class=\"login\">
                            <form action=\"/app/controller/controller.php?login\" method=\"POST\">
                                <h1 id=\"special_title\" class=\"title\">Log in to Camagru</h1>
                                <div class=\"field\">
                                    <p class=\"control has-icons-left has-icons-right\">
                                        <input class=\"input is-medium\" type=\"text\" name=\"username\" placeholder=\"Username\" required>
                                        <span class=\"icon is-medium is-left\">
                                            <i class=\"fas fa-user-circle\"></i>
                                        </span>
                                    </p>
                                </div>
                                <div class=\"field\">
                                    <p class=\"control has-icons-left\">
                                        <input class=\"input is-medium\" name=\"password\" type=\"password\" placeholder=\"Password\">
                                        <span class=\"icon is-medium is-left\">
                                            <i class=\"fas fa-lock\"></i>
                                        </span>
                                    </p>
                                    $error[0]
                                </div>
                                <input id=\"login_button\" style=\"width: 100%\" type=\"submit\" name=\"submit\" value=\"Sign in\" class=\"button is-small is-success\">
                            </form>
                            <p id=\"forgot-password\">
                                <a href=\"/index.php?forgot\">Forgot or change your password ?</a>
                            </p>
                            <h1 style=\"padding-top:0.6em\" id=\"special_title\" class=\"title\">Or create an account</h1>
                            <form action=\"/app/controller/controller.php?create\" method=\"POST\">
                                <div class=\"field\">
                                    <p class=\"control has-icons-left has-icons-right\">
                                        <input class=\"input is-medium\" type=\"text\" name=\"username\" placeholder=\"Username\" required>
                                        <span class=\"icon is-medium is-left\">
                                            <i class=\"fas fa-user-circle\"></i>
                                        </span>
                                    </p>
                                    $error[1]
                                </div>
                                <div class=\"field\">
                                    <p class=\"control has-icons-left\">
                                        <input class=\"input is-medium\" name=\"password\" type=\"password\" placeholder=\"Password\" required>
                                        <span class=\"icon is-medium is-left\">
                                            <i class=\"fas fa-lock\"></i>
                                        </span>
                                    </p>
                                    $error[2]
                                </div>
                                <div class=\"field\">
                                    <p class=\"control has-icons-left\">
                                        <input class=\"input is-medium\" name=\"password_confirm\" type=\"password\" placeholder=\"Confirm Password\" required>
                                        <span class=\"icon is-medium is-left\">
                                            <i class=\"fas fa-lock\"></i>
                                        </span>
                                    </p>
                                    $error[3]
                                </div>
                                <div class=\"field\">
                                    <p class=\"control has-icons-left\">
                                        <input class=\"input is-medium\" name=\"mail\" type=\"mail\" placeholder=\"Mail\" required>
                                        <span class=\"icon is-medium is-left\">
                                            <i class=\"fas fa-envelope\"></i>
                                        </span>
                                    </p>
                                    $error[4]
                                </div>
                                <input id=\"login_button user_connect\" style=\"width: 100%\" type=\"submit\" name=\"submit\" value=\"Register account\" class=\"button is-small is-success last\">
                            </form>
                        </div>
                    </div>
                </div>";
    }
}
