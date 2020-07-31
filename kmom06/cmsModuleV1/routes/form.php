<?php

// $navBarSub .= "<a href='?route=form&&sub=blog";
if ($choice) {
    if ($choice == 'blog') {
        // Should update the database with the correct values from $_POST
        // Table, column name & new value

        // Incoming post data
        $postData = array('id', 'title', 'path', 'data');

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
            $idVar = 'id';
            $idVal = $params[$idVar];

            $cmsModule->update($choice, $params, $idVar, $idVal);

            $content = 'The changes to the blog are done';
        } else {
            $content = 'The title is in use already';
        }

        // The view
        $title = "The blog";
        $view[] = "view/blog.php";
        };

    if ($choice == 'page') {
        // Should update the database with the correct values from $_POST
        // Table, column name & new value

        // Incoming post data
        $postData = array('id', 'title', 'data');

        // Get the corresponding post values
        $params = $sendVar->postValue($postData);
        $idVar = 'id';
        $idVal = $params[$idVar];

        $cmsModule->update($choice, $params, $idVar, $idVal);

        $content = 'The changes to the page are done';

        // The view
        $title = "The blog";
        $view[] = "view/page.php";
    }
}
