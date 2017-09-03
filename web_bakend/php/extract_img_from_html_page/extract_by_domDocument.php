<?php
$url = './page_to_extract.html';
$html = file_get_contents($url);

$doc = new DOMDocument();
$doc->loadHTML($html);

$tags = $doc->getElementsByTagName('img');

foreach ($tags as $tag) {
    echo $tag->getAttribute('alt');
    echo "<br>";
}