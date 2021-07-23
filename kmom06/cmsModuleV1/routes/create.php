<?php
// $navBarSub .= "<a href='?route=create&&sub=blog'> Blog </a>";

require 'functionsDone.php';


if ($choice == 'blog') {
    // Get the correct data
    // render the content to the view
    $content = $cmsModule->createForm("?route=create&&sub=form");

    // The view
    $title = "The blog";
    $view[] = "view/blog.php";
}

if ($choice == 'form') {
    $content = 'create item';

    // Incoming post data from form
    // $postData = array('title', 'data');
    // * Get incoming posts and save wanted vars to an array *
    $params = $sendVar->postValue(array('title', 'path', 'data'));

    // * Set the Slug *
    $params['slug'] = $cmsModule->slugify($params['title']);

    // The filters
    $filters = $sendVar->postValue(array('bbcode', 'link', 'markdown', 'nl2br'));
    $params['filter'] = stringFromArr($filters);

    // _ Control data _
    $validVal = []; // array for recording validity

    // --> Control values
    if (!is_string($params['title'])
        ||!is_string($params['path'])
        ||!is_string($params['data'])
    ) {
        $validVal[] = false;
    } else {
        $validVal[] = true;
    }

    // --> Control slug
    $empty = $cmsModule->isEmpty(
        'blog', 'slug', $params['slug'], true
    );

    if ($empty) {
        $validVal[] = true;
    } else {
        $validVal[] = false;
    }

    // --> Control path
    $empty = $cmsModule->isEmpty(
        'blog', 'path', $params['path'], true
    );

    if ($empty) {
        $validVal[] = true;
    } else {
        $validVal[] = false;
    }

    // --> Execute or not
    $execute = true;
    if (in_array(false, $validVal)) {
        $execute = false;
        $content = "Incorrect values";
    }

    if ($execute) {
        $cmsModule->create('blog', $params);
        $content = "Blog created";
    }

    // The view
    $title = "The blog";
    $view[] = "view/blog.php";
}
