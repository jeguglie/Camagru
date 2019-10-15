<?php
class PDO2 extends PDO
{
    private static $_instance;
    /* Constructeur hérité de PDO */
    public function __construct ()
    {}
    /* Singleton */
    public static function getInstance ()
    {
        require(getPath().'/config/database.php');
        if (!isset (self::$_instance))
        {
            try
            {
                self::$_instance = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
                self::$_instance->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
                self::$_instance->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
            }
            catch (PDOException $e)
            {
                die($e->getMessage());
            }
        }
        return (self::$_instance) ;
    }
}
function getPath(){
    return $path = $_SERVER['DOCUMENT_ROOT'];
}
function dbConnect(){
    $bdd = PDO2::getInstance();
    return $bdd;
}
function add_like($img_id, $username){
    $bdd = dbConnect();
    $dislike = false;
    try
    {
        $request = $bdd->prepare("SELECT * FROM pictures WHERE id=:id");
        $request->execute(['id' => $img_id]);
        $results = $request->fetch();
    }
    catch (Exception $e)
    {
        die($e->getMessage());
    }
    // Get number of likes
    $likes = $results['likes'];

    try
    {
        $request = $bdd->prepare("SELECT * FROM likes");
        $request->execute();
        $results = $request->fetchAll(PDO::FETCH_ASSOC);
    }
    catch (Exception $e)
    {
        die($e->getMessage());
    }
    // Check if username already liked img_id
    foreach ($results as $value)
    {
        if ($value['username'] == $username && $img_id == $value['img_id']){
            $dislike = true;
        }
    }

    // Delete row (dislike)
    if ($dislike == true && $likes > 0)
    {
        try
        {
            $request = $bdd->prepare('DELETE FROM likes WHERE username=:username AND img_id=:id');
            $request->bindValue(':username', $username);
            $request->bindValue(':id', $img_id);
            $request->execute();
        }
        catch (Exception $e)
        {
            die($e->getMessage());
        }
        $likes = $likes - 1;
        try
        {
            $request = $bdd->prepare('UPDATE pictures SET likes=:likes WHERE id=:id');
            $request->bindParam(':likes', $likes);
            $request->bindParam(':id', $img_id);
            $request->execute();
        }
        catch (Exception $e)
        {
            die($e->getMessage());
        }
    }
    else
    {
        $likes = $likes + 1;
        try
        {
            $request = $bdd->prepare('UPDATE pictures SET likes=:likes WHERE id=:id');
            $request->bindParam(':likes', $likes);
            $request->bindParam(':id', $img_id);
            $request->execute();
        }
        catch (Exception $e)
        {
            die($e->getMessage());
        }
        // Add row username => like
        try
        {
            $request = $bdd->prepare('INSERT INTO likes(username, img_id) VALUES (?, ?)');
            $request->bindParam(1, $username);
            $request->bindParam(2, $img_id);
            $request->execute();
        }
        catch (Exception $e)
        {
            die($e->getMessage());
        }
    }
};
function new_comment($username, $img_id, $comment){
    $bdd = dbConnect();
    $comment_date = date('Y-m-d');
    try {
        $request = $bdd->prepare('INSERT INTO comments(img_id, comment, username, date) VALUES (?, ?, ?, ?)');
        $request->bindParam(1, $img_id);
        $request->bindParam(2, $comment);
        $request->bindParam(3, $username);
        $request->bindParam(4, $comment_date);
        $request->execute();
    } catch (Exception $e) {
        die($e->getMessage());
    }
    // Get username of img_id
    try {
        $request = $bdd->prepare('SELECT username FROM pictures WHERE id = ?');
        $request->bindParam(1, $img_id);
        $request->execute();
        $result = $request->fetch();
    } catch (Exception $e) {
        die($e->getMessage());
    }
    $username_comment = $result['username'];

    // Get mail of username
    try {
        $request = $bdd->prepare('SELECT mail, new_comment FROM users WHERE username = ?');
        $request->bindParam(1, $username_comment);
        $request->execute();
        $results = $request->fetch();
    } catch (Exception $e) {
        die($e->getMessage());
    }
    echo json_encode(array($results['new_comment'], $results['mail']));
    if ($results['new_comment'] == 1) {
        $destinataire = $results['mail'];
        $sujet = "Camagru | New comment";
        $entete = "From: camagru@jeguglie.tk";

        $message = "Hello $username_comment !
        A new comment has been posted on your image.
 
		---------------
		Ceci est un mail automatique, Merci de ne pas y répondre.";
        mail($destinataire, $sujet, $message, $entete);
    }
}
function change_mail($username, $mail, $mail_confirm){
    $bdd = dbConnect();
    // Check Mail
    if (!filter_var($mail, FILTER_VALIDATE_EMAIL)){
        $_SESSION['change_mail'] = "not_valid";
        header('Location: /index.php?profile');
        exit();
    }

    // Check if mail is same
    if (strcmp($mail, $mail_confirm) != 0){
        $_SESSION['change_mail'] = "not_same";
        header('Location: /index.php?profile');
        exit();
    }

    // Check if mail exists
    try
    {
        $query = $bdd->query('SELECT * FROM users');
        $query->execute();
        while ($results = $query->fetch())
        {
            if ($results['mail'] == strcmp($mail, $results['mail']))
            {
                $_SESSION['change_mail'] = "used";
                header('Location: /index.php?profile');
                exit();
            }
        }
    }
    catch (Exception $e)
    {
        die($e->getMessage());
    }
    try {
        $request = $bdd->prepare("UPDATE users SET mail=:mail WHERE username like :username");
        $request->bindParam(':mail', $mail);
        $request->bindParam(':username', $username);
        $request->execute();
        $request->closeCursor();
        $_SESSION['change_mail'] = "updated";
    }
    catch (Exception $e)
    {
        $_SESSION['change_mail'] = "error";
        die($e->getMessage());
    }
    header('Location: /index.php?profile');
}
function change_username($username, $new_username, $new_username_confirm){
    $bdd = dbConnect();
    if (strcmp($new_username, $new_username_confirm) != 0){
        $_SESSION['change_username'] = "not_same";
        header('Location: /index.php?profile');
        exit();
    }
    else
        unset($_SESSION['change_username']);

    // Check if username exists
    try
    {
        $query = $bdd->query('SELECT * FROM users');
        $query->execute();
        while ($results = $query->fetch())
        {
            if ($results['username'] == strcasecmp($new_username, $results['username']))
            {
                $_SESSION['change_username'] = "used";
                header('Location: /index.php?profile');
                exit();
            }
        }
    }
    catch (Exception $e)
    {
        die($e->getMessage());
    }
    try
    {
        if (isset($_SESSION['change_username']))
            unset($_SESSION['change_username']);
        $request = $bdd->prepare("UPDATE users SET username=:new_username WHERE username like :username");
        $request->bindParam(':new_username', $new_username);
        $request->bindParam(':username', $username);
        $request->execute();
        $_SESSION['username'] = $new_username;
        $_SESSION['change_username'] = "updated";
    }
    catch (Exception $e)
    {
        $_SESSION['change_username'] = "error";
        die($e->getMessage());
    }
    try
    {
        $request = $bdd->prepare("UPDATE comments SET username=:new_username WHERE username like :username");
        $request->bindParam(':new_username', $new_username);
        $request->bindParam(':username', $username);
        $request->execute();
    }
    catch (Exception $e)
    {
        $_SESSION['change_username'] = "error";
        die($e->getMessage());
    }
    try
    {
        $request = $bdd->prepare("UPDATE likes SET username=:new_username WHERE username like :username");
        $request->bindParam(':new_username', $new_username);
        $request->bindParam(':username', $username);
        $request->execute();
    }
    catch (Exception $e)
    {
        $_SESSION['change_username'] = "error";
        die($e->getMessage());
    }
    try
    {
        $request = $bdd->prepare("UPDATE pictures SET username=:new_username WHERE username like :username");
        $request->bindParam(':new_username', $new_username);
        $request->bindParam(':username', $username);
        $request->execute();
    }
    catch (Exception $e)
    {
        $_SESSION['change_username'] = "error";
        die($e->getMessage());
    }
    header('Location: /index.php?profile');
}
function delete_image($username, $img_id){
    $bdd = dbConnect();
    try
    {
        $request = $bdd->prepare("DELETE FROM pictures WHERE username = ? AND id = ?");
        $request->bindParam(1, $username);
        $request->bindParam(2, $img_id);
        $request->execute();
    }
    catch (Exception $e)
    {
        die($e->getMessage());
    }
}
function load_comment($img_id){
    sleep(1);
    $bdd = dbConnect();
    try
    {
        $request = $bdd->prepare("SELECT * FROM comments WHERE img_id = ?");
        $request->bindParam(1, $img_id);
        $request->execute();
        $results = $request->fetchAll(PDO::FETCH_ASSOC);
    }
    catch (Exception $e)
    {
        die($e->getMessage());
    }
    return $results;
}
function load_images_wall($img_id){
    $bdd = dbConnect();
    $img_id_last = 0;
    $images = array();
    $i = 0;
    try {
        $request = $bdd->prepare("SELECT * FROM pictures WHERE id BETWEEN ? AND ? - 1 ORDER BY id DESC LIMIT 3");
        $request->bindParam(1, $img_id_last);
        $request->bindParam(2, $img_id);
        $request->execute();
        $results = $request->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        die($e->getMessage());
    }
    foreach ($results as $values) {
        $img_id = $values['id'];
        try {
            $request2 = $bdd->prepare("SELECT * FROM comments WHERE img_id = ?");
            $request2->bindParam(1, $img_id);
            $request2->execute();
            $results2 = $request2->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            die($e->getMessage());
        }
        $images[$i]['username'] = $values['username'];
        $images[$i]['img_link'] = $values['img_link'];
        $images[$i]['likes'] = $values['likes'];
        $images[$i]['comments'] = sizeof($results2);
        $images[$i]['id'] = $values['id'];
        $images[$i]['filter'] = $values['img_filter'];
        $i++;
    }
    return $images;
}
function logout(){
    ob_start();
    session_start();
    session_unset();
    session_regenerate_id(true);
    session_unset();
    session_destroy();
    session_write_close();
    setcookie(session_name(),'',0,'/');
    header('Location: ../../index.php');
}
function set_comment_notification($username, $checked){
    $bdd = dbConnect();
    $checked = $checked == true ? 1 : 0;
    try
    {
        $request = $bdd->prepare("UPDATE users SET new_comment = ? WHERE username = ?");
        $request->bindParam(1, $checked);
        $request->bindParam(2, $username);
        $request->execute();
    }
    catch (Exception $e)
    {
        die($e->getMessage());
    }
}
function submit_image($username, $data, $filter){
    $bdd = dbConnect();
    $data = str_replace(' ', '+', $data);
    $base64 = preg_replace('#^data:image/\w+;base64,#i', '', $data); // Remove data:image/..
    $type = explode('/', explode(';', $data)[0])[1]; // Get type of data image

    if (($type == "jpeg" || $type == "jpg" || $type == "png") && check_base64_image($base64, $type)) {
        $data = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $data));
        $img_link = "/app/public/images/wall/" . date('Y-m-d-m-s') . '.png';
        $img_date = date('Y-m-d');
        file_put_contents(getPath().'/app/public/images/wall/' . date('Y-m-d-m-s') . '.png', $data);
        try
        {
            $request = $bdd->prepare("INSERT INTO pictures (username, img_link, date, img_filter) VALUES (?, ?, ?, ?)");
            $request->bindParam(1, $username);
            $request->bindParam(2, $img_link);
            $request->bindParam(3, $img_date);
            $request->bindParam(4, $filter);
            $request->execute();
        }
        catch (Exception $e)
        {
            die($e->getMessage());
        }
    }
}
function check_base64_image($base64, $type)
{

    // Create image
    $img = imagecreatefromstring(base64_decode($base64));

    // If img is not valid
    if (!$img)
        return false;
    // Save file
    $type == "png" ? imagepng($img, 'tmp.png') : false; // If png
    $type == "jpg" || $type == "jpeg" ? imagejpeg($img, 'tmp.jpg') : false; // If jpg or jpeg
    $info = getimagesize('tmp.png');

    // Delete file
    unlink('tmp.' . $type);

    // Check Width and Heigth
    if ($info[0] > 0 && $info[1] > 0 && $info['mime'])
        return true;
    return false;
}
function get_lasts_images($username){
    $bdd = dbConnect();
    try
    {
        $request = $bdd->prepare("SELECT * FROM pictures WHERE username=:username");
        $request->bindValue(':username', $username);
        $request->execute();
        $results = $request->fetchAll(PDO::FETCH_ASSOC);
    }
    catch (Exception $e)
    {
        die($e->getMessage());
    }
    return $results;
}
function upload_file($data){

    $data = str_replace(' ', '+', $data); // Set ' ' by ' + '
    $type = explode('/', explode(';', $data)[0])[1]; // Get type of data image
    $base64 = preg_replace('#^data:image/\w+;base64,#i', '', $data); // Remove data:image/..
    if ($type == "jpeg" || $type == "jpg" || $type == "png" && check_base64_image($base64, $type)) {

        $data = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $data));
        $target_file = '/app/public/images/uploads/' . date('Y-m-d-m-s') . '.' . $type;
        file_put_contents(getPath().$target_file, $data);
        return $target_file;

    } else {
        return NULL;
    }
}
function create_user($username, $password, $mail){
    $bdd = dbConnect();
    $valid_key = md5(microtime(TRUE)*100000);
    try
    {
        $request = $bdd->prepare('INSERT INTO users(username, password, mail, valid_key) VALUES (:username, :password, :mail, :valid_key)');
        $request->execute(array(
            'username' => $username,
            'password' => hash('whirlpool', $password),
            'mail' => $mail,
            'valid_key' => $valid_key,
        ));
        $request->closeCursor();
    }
    catch (Exception $e)
    {
        die($e->getMessage());
    }
    $destinataire = $mail;
    $sujet = "Activer votre compte" ;
    $entete = "From: camagru@jeguglie.tk" ;

    $message = 'Bienvenue sur Camagru !
 		Pour activer votre compte, veuillez cliquer sur le lien ci-dessous ou copier/coller dans votre navigateur internet.

		http://www.jeguglie.tk/app/controller/controller.php?username='.urlencode($username).'&valid_key='.urlencode($valid_key).'
 
		---------------
		Ceci est un mail automatique, Merci de ne pas y répondre.';
    mail($destinataire, $sujet, $message, $entete) ;
    $_SESSION['mail_success'] = "waiting";
}
function check_data($username, $password, $password_confirm, $mail){
    $bdd = dbConnect();
    $uppercase = preg_match('@[A-Z]@', $password);
    $lowercase = preg_match('@[a-z]@', $password);
    $number = preg_match('@[0-9]@', $password);
    $specialChars = preg_match('@[^\w]@', $password);

    if (isset($_SESSION['username_used']))
        unset($_SESSION['username_used']);
    if (strcmp($password, $password_confirm) != 0)
        $_SESSION['password_not_same'] = "";
    else
        unset($_SESSION['password_not_same']);

    if (!$uppercase || !$lowercase || !$specialChars || !$number || strlen($password) < 5)
        $_SESSION['password_not_strong'] = "";
    else
        unset($_SESSION['password_not_strong']);

    if (!filter_var($mail, FILTER_VALIDATE_EMAIL))
        $_SESSION['mail_error'] = "";
    else
        unset($_SESSION['mail_error']);


    unset($_SESSION['username_used']);
    try
    {
        $query = $bdd->query('SELECT * FROM users');
        $query->execute();
        while ($results = $query->fetch())
        {
            if ($results['username'] == strcasecmp($username, $results['username']))
            {
                $_SESSION['username_used'] = $username;
                header('Location: /index.php');
                exit();
            }
        }
    }
    catch (Exception $e)
    {
        die($e->getMessage());
    }

    if (isset($_SESSION['mail_error']) || isset($_SESSION['password_not_same']) || isset($_SESSION['password_not_strong']) || isset($_SESSION['username_used'])) {
        header('Location: /index.php');
        exit();
    }
}
function user_log_in($username, $password){
    $bdd = dbConnect();
    try
    {
        $query = $bdd->query('SELECT * FROM users');
        $query->execute();
        while ($results = $query->fetch())
        {
            if ($results['username'] == $username && $results['password'] == hash('whirlpool', $password))
            {
                if ($results['active'] == 0){
                    $_SESSION['mail_success'] = "waiting";
                    $_SESSION['user_waiting'] = $username;
                    header('Location: /index.php');
                    exit();
                }
                else {
                    $_SESSION['username'] = $username;
                }
            }
        }
        if ($_SESSION['username'] !=  $_POST['username'])
        {
            $_SESSION['username_error'] = "";
            unset($_SESSION['username']);
        }
    }
    catch (Exception $e)
    {
        die($e->getMessage());
    }
    header('Location: /index.php');
}
function mail_password_confirmation($username, $password_key){
    $bdd = dbConnect();
    unset($_SESSION['mail_password_send']);
    $bdd_password_key = NULL;
    try
    {
        $request = $bdd->prepare("SELECT password_key FROM users WHERE username like :username ");
        if ($request->execute(array(':username' => $username)) && $row = $request->fetch())
        {
            $bdd_password_key = $row['password_key'];
        }
        $request->closeCursor();
    }
    catch (Exception $e)
    {
        die($e->getMessage());
    }

    if ($password_key == $bdd_password_key)
    {
        $_SESSION['password_key'] = $password_key;
        $_SESSION['username_change_password'] = $username;
        $_SESSION['change_password'] = "authorized";
    }
    else
        $_SESSION['change_password'] = "error_key";
    return $bdd_password_key;
}
function get_pictures_wall(){
    $bdd = dbConnect();
    $results = null;
    try
    {
        $request = $bdd->prepare("SELECT * FROM pictures WHERE 1 ORDER BY id DESC");
        $request->execute();
        $results = $request->fetchAll(PDO::FETCH_ASSOC);
    }
    catch (Exception $e)
    {
        die($e->getMessage());
    }
    return $results;
}
function getNbComment($img_id){
    $bdd = dbConnect();
    try
    {
        $request = $bdd->prepare("SELECT * FROM comments WHERE img_id= ?");
        $request->bindParam(1, $img_id);
        $request->execute();
        $results = $request->fetchAll(PDO::FETCH_ASSOC);
    }
    catch (Exception $e)
    {
        die($e->getMessage());
    }
    return $results;
}
function check_mail_activate($username){
    $bdd = dbConnect();
    try
    {
        $request = $bdd->prepare('SELECT new_comment FROM users WHERE username = ?');
        $request->bindParam(1, $username);
        $request->execute();
        $results = $request->fetch();
    }
    catch (Exception $e)
    {
        die($e->getMessage());
    }
    return $results;
}
function mail_confirmation($username, $valid_key){
    $bdd = dbConnect();
    $request = $bdd->prepare("SELECT valid_key,active FROM users WHERE username like :username ");
    if ($request->execute(array(':username' => $username)) && $row = $request->fetch())
    {
        $bdd_key = $row['valid_key'];
        $active = $row['active'];
    }
    if ($active == '1')
        $_SESSION['mail_success'] = "already";
    else
    {
        if ($valid_key == $bdd_key)
        {
            $_SESSION['mail_success'] = "success";
            $request = $bdd->prepare("UPDATE users SET active = 1 WHERE username like :username");
            $request->bindParam(':username', $username);
            $request->execute();
            $request->closeCursor();
        }
        else
            $_SESSION['mail_success'] = "false";
    }
    header('Location: /index.php');
}
function mail_password($mail, $username){
    $bdd = dbConnect();
    try
    {
        $request = $bdd->prepare("SELECT mail FROM users WHERE mail like :mail");
        if ($request->execute(array(':mail' => $mail)) && $row = $request->fetch())
        {
            $mail = $row['mail'];
            $password_key = md5(microtime(TRUE)*100000);
            $request = $bdd->prepare("UPDATE users SET password_key=:password_key WHERE mail like :mail");
            $request->bindParam(':password_key', $password_key);
            $request->bindParam(':mail', $mail);
            $request->execute();
            $request->closeCursor();

            $destinataire = $mail;
            $sujet = "Reset your password" ;
            $entete = "From: camagru@jeguglie.tk" ;
            $message = 'Suite à votre demande, voici le lien de reinitialisation de votre mot de passe :

		    http://www.jeguglie.tk/index.php?login&mail_password_confirmation&username='.urlencode($username).'&password_key='.urlencode($password_key).'
 
		    ---------------
		    Ceci est un mail automatique, Merci de ne pas y répondre.';
            mail($destinataire, $sujet, $message, $entete);
            $_SESSION['mail_password_send'] = "waiting";
        }
        else
            $_SESSION['mail_password_send'] = "error";
    }
    catch (Exception $e)
    {
        die($e->getMessage());
    }
    header('Location: /index.php');
}
function resend_link($username){
    $bdd = dbConnect();
    $send_link = NULL;
    try
    {
        $request = $bdd->prepare("SELECT valid_key,mail,send_link FROM users WHERE username like :username ");
        if ($request->execute(array(':username' => $username)) && $row = $request->fetch())
        {
            $valid_key = $row['valid_key'];
            $mail = $row['mail'];
            $send_link = $row['send_link'];
        }
    }
    catch (Exception $e)
    {
        die($e->getMessage());
    }
    if ($send_link < 5)
    {
        $send_link = $send_link + 1;
        try
        {
            $request = $bdd->prepare("UPDATE users SET send_link=:send_link WHERE username like :username");
            $request->bindParam(':send_link', $send_link);
            $request->bindParam(':username', $username);
            $request->execute();
            $request->closeCursor();
        }
        catch (Exception $e)
        {
            die($e->getMessage());
        }
        $destinataire = $mail;
        $sujet = "Activer votre compte" ;
        $entete = "From: camagru@jeguglie.tk" ;
        $message = 'Bienvenue sur Camagru !
 		Pour activer votre compte, veuillez cliquer sur le lien ci-dessous ou copier/coller dans votre navigateur internet.
 		http://www.jeguglie.tk/app/controller/controller.php?username='.urlencode($username).'&valid_key='.urlencode($valid_key).'
 		---------------
 		Ceci est un mail automatique, Merci de ne pas y répondre.';
        mail($destinataire, $sujet, $message, $entete);
        $_SESSION['mail_success'] = "resend";
    }
    else
    {
        $_SESSION['mail_success'] = "max_links";
    }
    unset($_SESSION['user_waiting']);
    header('Location: /index.php');
}
function change_password_by_forgot($username, $password_key, $password, $password_confirm){
    $bdd = dbConnect();
    $bdd_password_key = NULL;
    if (strcmp($password, $password_confirm) != 0){
        $_SESSION['change_password_success'] = "not_same";
        header("Location: http://www.jeguglie.tk/index.php?login&mail_password_confirmation&username=$username&password_key=$password_key");
        exit();
    }
    try
    {
        $request = $bdd->prepare("SELECT password_key FROM users WHERE username like :username");
        if ($request->execute(array(':username' => $username)) && $row = $request->fetch())
            $bdd_password_key = $row['password_key'];
        $request->closeCursor();
    }
    catch (Exception $e)
    {
        die($e->getMessage());
    }
    if ($bdd_password_key == $password_key)
    {
        $new_password_key = md5(microtime(TRUE)*100000);
        $_SESSION['change_password_success'] = "password_updated";
        try
        {
            $request = $bdd->prepare("UPDATE users SET password=:password , password_key=:new_password_key WHERE username like :username");
            $request->bindParam(':password', hash('whirlpool', $password));
            $request->bindParam(':new_password_key', $new_password_key);
            $request->bindParam(':username', $username);
            $request->execute();
            $request->closeCursor();
        }
        catch (Exception $e)
        {
            die($e->getMessage());
        }
    }
    else
        $_SESSION['change_password_success'] = "error_key";
    header('Location: /index.php');
}
function change_password_by_user($username, $password, $new_password, $new_password_confirmation){
    $bdd = dbConnect();
    $bdd_password = NULL;
    if (strcmp($new_password, $new_password_confirmation) != 0){
        $_SESSION['change_password_success'] = "not_same";
        header("Location: /index.php?profile");
        exit();
    }
    try
    {
        $request = $bdd->prepare("SELECT password FROM users WHERE username=:username");
        if ($request->execute(array(':username' => $username)) && $row = $request->fetch())
            $bdd_password = $row['password'];
    }
    catch (Exception $e)
    {
        die($e->getMessage());
    }
    if (strcmp($bdd_password, hash('whirlpool', $password)) == 0)
    {
        $_SESSION['change_password_success'] = "password_updated";
        try
        {
            $request = $bdd->prepare("UPDATE users SET password=:password WHERE username like :username");
            $request->bindParam(':password', hash('whirlpool', $new_password));
            $request->bindParam(':username', $username);
            $request->execute();
        }
        catch (Exception $e)
        {
            die($e->getMessage());
        }
    }
    else
        $_SESSION['change_password_success'] = "error_old_password";
    header('Location: /index.php?profile');
}
