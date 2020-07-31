<?php
// $navBarSub .= "<a href='?route=create&&sub=blog'> Blog </a>";

if ($choice == 'blog') {
    // Get the correct data
    // render the content to the view
    $formAction = "?route=create&&sub=form";
    $content = $cmsModule->createForm($formAction);

    // The view
    $title = "The blog";
    $view[] = "view/blog.php";
}

if ($choice == 'form') {
    // Get the values from $_POST
    $content = 'create item';

    // Incoming post data
    $postData = array('title', 'data');

    // Get the corresponding post values
    $params = $sendVar->postValue($postData);
    $params['slug'] = $cmsModule->slugify($params['title']); //slug

    $optionRef = 'noPrint'; // for the printer
    $column = 'slug';
    $table = 'blog';
    $exactVal = true; // Search exact value
    $slug = $params['slug'];

    // Check so slug not in use already
    $empty = $cmsModule->isEmpty($table, $column, $slug, $exactVal, $optionRef);

    if ($empty) {
        $cmsModule->create($table, $params);
        $content = 'The update is completed.';
    } else {
        $content = 'The title is in use.';
    }

    // The view
    $title = "The blog";
    $view[] = "view/blog.php";
}
