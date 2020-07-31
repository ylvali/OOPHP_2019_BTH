<?php

// Display the full page through a slug
if ($slug) {
    $optionRef = 'blog';
    $column = 'slug';
    $table = 'blog';
    $exactVal = true; // Search exact value
    $content = $cmsModule->search($table, $column, $slug, $exactVal, $optionRef);

    // The view
    $title = "The blog";
    $view[] = "view/page.php";
}
