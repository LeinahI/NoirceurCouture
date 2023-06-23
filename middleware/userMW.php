<?php
if (!isset($_SESSION['auth'])) {
    redirect('login.php', 'Log in to continue');
}
