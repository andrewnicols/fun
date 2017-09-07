<?php

$dbhost = '127.0.0.1';
$dbuser = 'root';
$dbpass = null;
$dbname = 'testdb';
$dbport = 3306;
$dbsocket = '';

$c = new mysqli($dbhost, $dbuser, $dbpass, $dbname, $dbport, $dbsocket);
var_dump($c->connect_error);

$dbpass = '';
$c = new mysqli($dbhost, $dbuser, $dbpass, $dbname, $dbport, $dbsocket);
var_dump($c->connect_error);
