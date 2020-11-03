<?php

// Compare blog file name and title remain same ,this mean blog post title and it's it which is placed into url will remain same.
$id = strtolower($entry->getId());
$title = strtolower($entry->getTitle());

$tmp = str_replace('-', ' ', substr($id, 11));
if ($tmp != $title) {
    echo $id;
    exit;
}