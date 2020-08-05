<?php

function fix_html_content($input) {
    $previouserrors = libxml_use_internal_errors(true);

    $domdoc = new DOMDocument('1.0', 'UTF-8');
    $domdoc->loadHTML($input, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

    libxml_clear_errors();
    libxml_use_internal_errors($previouserrors);

    var_dump("============================================================================");
    var_dump($input);
    var_dump($domdoc->saveHTML());
}

fix_html_content('</div><p>Hello</p>');
