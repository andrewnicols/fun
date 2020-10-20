<?php
ini_set('zend.assertions', 1);

$finaldir = str_pad(sys_get_temp_dir() . '/', 261, 'x');
@mkdir($finaldir, 0777, true);
$contentfile = "{$finaldir}/example_input.txt";
@unlink($contentfile);

$content = "Some example content";
file_put_contents($contentfile, $content);
assert(file_get_contents($contentfile) === $content, "Unable to read back the content");

$za = new ZipArchive();
$result = $za->open(__DIR__ . '/export.zip', ZipArchive::CREATE | ZipArchive::OVERWRITE);
assert($result, "Unable to open ZipArchive");

$result = $za->addFile($contentfile);
assert($result, "Unable to call addFile({$contentfile})");

$result = $za->close();
assert($result, "Unable to call close()");
