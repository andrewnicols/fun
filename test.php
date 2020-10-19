<?php

$dirperm = 02777;
$umaskperm = (($dirperm & 0777) ^ 0777);

var_dump(sys_get_temp_dir());

$newdir = sys_get_temp_dir() . '\requestdir/24zxX8s03Hv2nJtZDps0Gy4qFdCdNRW8www.example.com\4a630054-1e6b-4d56-ae74-c75349c5f9c7\6231eaae-5d75-45d0-80f1-ebd39ddf164f/';
mkdir($newdir, $dirperm, true);

$fpc = "{$newdir}fpc.zip";
file_put_contents($fpc, "Some content");
var_dump(file_get_contents($fpc));


$zapath = "{$newdir}export.zip";
$za = new ZipArchive();
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
