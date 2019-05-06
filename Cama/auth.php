<?php
function auth($login, $passwd)
{
    $con = connect_db();

    $req = "SELECT id_user FROM users WHERE";
    $req .= " pseudo_user = '" . test_input($login) . "' and passwd_user = '" . test_input($passwd) . "'";
    echo $req . "\n";
    $ret = return_req_result($con, $req);

    return ($ret);

}

function connect_db()
{
    $url = 'localhost';
    $user = 'root';
    $pass = '123456';
    $dbname = "camagru";

    $con = mysqli_connect($url, $user, $pass, $dbname);
    if (!$con) {
        die(' Connexion db impossible : ' . mysqli_error($con));
    }
    return ($con);
}

function start_login()
{
    if ($_POST['submit'] == "OK") {
        $id_user = auth($_POST['login'], $_POST['passwd']);


        if (count($id_user) > 0) {
            $_SESSION['loggued_on_user'] = $_POST['login'];
            $_SESSION['id_user'] = $id_user[0]["id_user"];
            header('Location: sign_in.php');
        } else {
            return (-2);
        }

    }
}
?>