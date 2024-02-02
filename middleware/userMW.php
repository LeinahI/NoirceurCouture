<?php
include(__DIR__ . '/../models/checkSession.php');

if (!isset($_SESSION['auth'])) {
    redirect('login.php', 'Log in to continue');
}

checkUserValidityAndRedirect($_SESSION['auth_user']['user_ID']);