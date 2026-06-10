<?php
$host='gateway01.eu-central-1.prod.aws.tidbcloud.com;port=4000';
$user='vm9FimKwWsTDEEo.root';
$pass='vHALzwg865u9ztZg';
try {
    $db = new PDO("mysql:host=$host", $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::MYSQL_ATTR_SSL_CA => __DIR__ . '/cacert.pem',
        PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT => true
    ]);
    echo "CONNECTED SUCCESS!\n";
} catch (Exception $e) {
    echo "FAILED: " . $e->getMessage() . "\n";
}
