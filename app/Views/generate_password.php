<?php

$password = 'your_password'; // Change this to the password you want to hash
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);
echo "Hashed Password: " . $hashedPassword;
