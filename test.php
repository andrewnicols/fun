<?php

$dirperm = 02777;
$umaskperm = (($dirperm & 0777) ^ 0777);

var_dump(sys_get_temp_dir());

$newdir = sys_get_temp_dir() . '/requestdir/kvewOEfNJn9Ik6C9NxFZvWH20PewkhElwww.example.com\d401a993-c34a-4956-914f-6c7d35ede7c7\c8c7269d-0252-4623-880e-2e20f75880df/';
mkdir($newdir, $dirperm, true);

$fpc = "{$newdir}file_put_contents_example.txt";
file_put_contents($fpc, "Some content");


var_dump("----------------------------------------------------------------------------");
$zapath = "{$newdir}export.zip";
var_dump($zapath);
$za = new ZipArchive();
var_dump("Opening");
$result = $za->open($zapath, ZipArchive::CREATE | ZipArchive::OVERWRITE);
var_dump($result);
var_dump($za->getStatusString());

var_dump("Adding the file from {$fpc}");
$result = $za->addFile($fpc, basename($fpc));
var_dump("The result was {$result}");
var_dump($result);
var_dump("Status:");
var_dump($za->getStatusString());

var_dump("Closing:");
$za->close();
var_dump(file_get_contents($zapath));
