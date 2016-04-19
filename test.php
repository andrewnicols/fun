<?php

function testme($text) {
	$domdoc = new DOMDocument();

    $domdoc->loadHTML($text, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
    array_map(function ($link) {
        !$link->hasAttribute('target') && $link->setAttribute('target', '_blank');
        if (strpos($link->getAttribute('rel'), 'noreferrer') === false) {
            $link->setAttribute('rel', trim($link->getAttribute('rel') . ' noreferrer'));
        }
    }, iterator_to_array($domdoc->getElementsByTagName('a')));
    $text = trim($domdoc->saveHTML());

    var_dump($domdoc->getElementsByTagName('a'));

    return $text;
}

$text = '<a href="https://www.youtube.com/watch?v=JeimE8Wz6e4">Hey, that\'s pretty good!</a>';
var_dump(testme($text));
