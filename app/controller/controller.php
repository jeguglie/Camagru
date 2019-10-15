<?php
// -- MODEL -- \\
$path = $_SERVER['DOCUMENT_ROOT'];
require($path . '/app/model/model.php');
session_start();

// -- VIEW -- \\
function navbar(){
    require(getPath().'/app/view/navbar.php');
}
function notifications(){
    require(getPath().'/app/view/notifications.php');
}
function login(){
    require(getPath().'/app/view/login.php');
}
function wall(){
    require(getPath().'/app/view/wall.php');
}
function takepic(){
    require(getPath().'/app/view/take_pic.php');
}
function footer(){
    require(getPath().'/app/view/footer.php');
}
function user(){
    require(getPath().'/app/view/user_dashboard.php');
}

// -- New Comment
if (isset($_GET['new_comment']) && isset($_SESSION['username']) && isset($_POST['img_id']) && isset($_POST['comment'])){
    new_comment(strip_tags($_SESSION['username']), strip_tags($_POST['img_id']), strip_tags($_POST['comment']));
}

// -- User log in
if (isset($_GET['login']) && isset($_POST['submit']) && isset($_POST['username']) && isset($_POST['password'])) {
    user_log_in(strip_tags($_POST['username']), strip_tags($_POST['password']));
    header('Location: /index.php');
    exit();
}

// -- User Creation
if (isset($_GET['create']) && isset($_POST['submit']) && isset($_POST['username']) && isset($_POST['password']) && isset($_POST['password_confirm']) && isset($_POST['mail']))
{
    check_data(strip_tags($_POST['username']), strip_tags($_POST['password']), strip_tags($_POST['password_confirm']), strip_tags($_POST['mail']));
    if (!isset($_SESSION['password_not_strong']) && !isset($_SESSION['mail_error']))
        create_user(strip_tags($_POST['username']), strip_tags($_POST['password']), strip_tags($_POST['mail']));
    header('Location: /index.php');
}

// -- Load wall comments
if (isset($_GET['load_comments']) && isset($_SESSION['username']) && isset($_POST['img_id']))
{
    header("Content-Type: text/xml");
    echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>";
    echo "<list>";
    $results = load_comment(strip_tags($_POST['img_id']));
    foreach ($results as $values) {
        echo "<item comment=\"" . $values['comment'] . "\"" . " username=\"" . $values['username'] . "\"/>";
    }
    echo "</list>";
}

// -- Load wall images
if (isset($_GET['load_wall_images']) && isset($_POST['last_img_id']))
{
    header("Content-Type: text/xml");
    echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>";
    echo "<list>";
    $results = load_images_wall(strip_tags($_POST['last_img_id']));
    foreach ($results as $values)
        echo "<item username=\"" . $values['username'] . "\"" . " img_link=\"" . $values['img_link'] .  "\"" ." likes=\"" . $values['likes'] . "\"". " comments=\"" . $values['comments'] .  "\"" ." img_id=\"" . $values['id'] . "\"" . " img_filter=\"" . $values['filter'] . "\"/>";
    echo "</list>";
}

// -- Submit image
if (isset($_GET['submit_image']) && isset($_POST['filter']) && isset($_SESSION['username'])
    && isset($_POST['data']) && strlen($_POST['data']) > 50)
    submit_image(strip_tags($_SESSION['username']), strip_tags($_POST['data']), strip_tags($_POST['filter']));

// -- Add like
if (isset($_GET['add_like']) && isset($_SESSION['username']) && isset($_POST['img_id']))
    add_like(strip_tags($_POST['img_id']), strip_tags($_SESSION['username']));

// -- Change mail
if (isset($_GET['change_mail']) && isset($_SESSION['username']) && isset($_POST['mail'])
    && isset($_POST['mail_confirm']))
    change_mail(strip_tags($_SESSION['username']), strip_tags($_POST['mail']), strip_tags($_POST['mail_confirm']));

// -- Change username
if (isset($_GET['change_username']) && isset($_SESSION['username']) && isset($_POST['submit'])
    && isset($_POST['username']) && isset($_POST['username_confirm']))
    change_username(strip_tags($_SESSION['username']), strip_tags($_POST['username']), strip_tags($_POST['username_confirm']));

// -- Forgot password - Change password
if(isset($_GET['change_password_by_forgot']) && isset($_GET['username']) && isset($_GET['password_key'])
    && isset($_POST['password']) && isset($_POST['password_confirm']) && isset($_POST['submit']))
    change_password_by_forgot(strip_tags($_GET['username']), strip_tags($_GET['password_key']), strip_tags($_POST['password']), strip_tags($_POST['password_confirm']));

// -- Change password - User profile
if(isset($_SESSION['username']) && isset($_GET['change_password_by_user']) && isset($_POST['password'])
    && isset($_POST['new_password']) && isset($_POST['new_password_confirmation']) && isset($_POST['submit']))
    change_password_by_user(strip_tags($_SESSION['username']), strip_tags($_POST['password']), strip_tags($_POST['new_password']), strip_tags($_POST['new_password_confirmation']));

// -- Set comment notifications
if (isset($_GET['set_comment_notifications']) && isset($_SESSION['username']) && isset($_POST['checked']))
    set_comment_notification(strip_tags($_SESSION['username']), strip_tags($_POST['checked']));

// -- Delete image
if (isset($_GET['delete_image']) && isset($_SESSION['username']) && isset($_POST['img_id']))
    delete_image(strip_tags($_SESSION['username']), strip_tags($_POST['img_id']));

// -- Upload
if (isset($_GET['upload']) && isset($_SESSION['username']) && isset($_POST['data']) && isset($_POST['filename'])) {
    header("Content-Type: text/xml");
    echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>";
    echo "<list>";
    $target_file = upload_file(strip_tags($_POST['data']));
    if (!$target_file)
        echo "<item src=\"ERROR\"/>";
    else
        echo "<item src=\"$target_file\"/>";
    echo "</list>";
}

// -- Mail confirmation
if (isset($_GET['username']) && isset($_GET['valid_key']))
    mail_confirmation(strip_tags($_GET['username']), strip_tags($_GET['valid_key']));

// -- Mail password send link
if (isset($_GET['mail_password']) && isset($_POST['mail']) && isset($_POST['username']))
    mail_password(strip_tags($_POST['mail']), strip_tags($_POST['username']));

// -- Mail password confirmation for change password
if (isset($_GET['mail_password_confirmation']) && isset($_GET['username']) && isset($_GET['password_key']))
    mail_password_confirmation(strip_tags($_GET['username']), strip_tags($_GET['password_key']));

// -- Resend link
if (isset($_GET['resend_link'])) {
    if (isset($_SESSION['user_waiting']))
        resend_link(strip_tags($_SESSION['user_waiting']));
    else
        header('Location: /index.php');
    }