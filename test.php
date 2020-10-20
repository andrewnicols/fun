<?php

$basedir = sys_get_temp_dir() . '/tests/';
$baselength = strlen($basedir);

for ($i = $baselength + 1; $i < $baselength + 400; $i++) {
    rm($basedir);
    if (!test_zip_with_file_length($basedir, $i)) {
        break;
    }
}

function test_zip_with_file_length(string $basedir, int $length): bool {
    $dirperm = 02777;
    $umaskperm = (($dirperm & 0777) ^ 0777);

    $filename = "input.json";

    $finaldir = str_pad($basedir, $length, 'x');

    error_log(sprintf(
        "\n" .
        "============================================================================\n" .
        "== Testing with length:\t%d\n" .
        "== %s",
        $length,
        $finaldir
    ));

    mkdir($finaldir, $dirperm, true);

    $contentfile = "{$finaldir}/{$filename}";
    $content = file_put_contents($contentfile, "This is some example content");

    if (!file_exists($contentfile)) {
        error_log("Could not create a file in {$contentfile}");
        return false;
    }

    $zippath = sys_get_temp_dir() . '/export.zip';
    @unlink($zippath);
    $za = new ZipArchive();
    $result = $za->open($zippath, ZipArchive::CREATE | ZipArchive::OVERWRITE);
    error_log(sprintf(
        "    Opened the zip file (%s): %s",
        var_export($result, true),
        $za->getStatusString()
    ));

    error_log(sprintf(
        "        Adding file from %s",
        $contentfile
    ));


    $result = $za->addFile($contentfile, basename($contentfile));
    error_log(sprintf(
        "        Added file to zip file (%s): %s (%s)",
        var_export($result, true),
        $za->getStatusString(),
        $contentfile
    ));

    error_log(sprintf(
        "    Closing"
    ));
    $za->close();

    error_log(sprintf(
        "    Closed (%s):\n\t%s\n\n",
        var_export(file_exists($zippath), true),
        file_get_contents($zippath)
    ));

    return true;
}

function rm(string $path) {
    $files = array_diff(scandir($path), ['.', '..']);
    foreach ($files as $file) {
        $filepath ="{$path}/{$file}";
        if (is_dir($filepath)) {
            rm($filepath);
        } else {
            unlink($filepath);
        }
    }

    rmdir($path);
}
