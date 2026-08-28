<?php
require __DIR__ . '/admin-auth.php';

adminLogout();

header('Location: admin-login.php');
exit;
