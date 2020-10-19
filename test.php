<?php

$dirperm = 02777;
$umaskperm = (($dirperm & 0777) ^ 0777);

var_dump(sys_get_temp_dir());

$newdir = sys_get_temp_dir() . '/newdir/some/other/dir/';
mkdir($newdir, $dirperm, true);

$fpc = "{$newdir}fpc.zip";
file_put_contents($fpc, "Some content");
var_dump(file_get_contents($fpc));


$zapath = "{$newdir}archive.zip";
$za = new ZipArchive();
$za->open($zapath, ZipArchive::CREATE | ZipArchive::OVERWRITE);
var_dump($za->getStatusString());

$result = $za->addFile($fpc, basename($fpc));
var_dump($result);
var_dump($za->getStatusString());

$za->close();
var_dump($za->getStatusString());
var_dump(file_get_contents($zapath));
