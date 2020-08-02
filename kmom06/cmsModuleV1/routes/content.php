<?php

$navBarSub = "<a href='?route=content&&sub=page'> Page </a>";
$navBarSub .= "<a href='?route=content&&sub=blog'> Blog </a>";
if ($choice) {

    if ($choice == 'blog') {
        $content = $cmsModule->read($choice, $choice);

        // The view
        $title = "The blog";
        $view[] = "view/blog.php";

    } else {
        // Display only one, nr 1
        $id = 1;
        $optionRef = 'page'; // printer ref
        $column = 'id';
        $exactVal = true; // Search exact value
        $content = $cmsModule->search($choice, $column, $id, $exactVal, $optionRef);

        // The view
        $title = "The page";
        $view[] = "view/page.php";
    }
}
