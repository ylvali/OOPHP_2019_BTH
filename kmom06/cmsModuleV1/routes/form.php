<?php
// Should update the database with the correct values from $_POST
// Table, column name & new value

// $navBarSub .= "<a href='?route=form&&sub=blog";

require 'functionsDone.php';

if ($choice) {
    if ($choice == 'blog') {
        // * Get incoming posts and save wanted vars to an array *
        $params = $sendVar->postValue(array('id', 'title', 'path', 'data'));

        // * Set the filters *
        // Get the wanted POST values - filters - and save as db param
        $filters = $sendVar->
            postValue(array('bbcode', 'link', 'markdown', 'nl2br'));
        $params['filter'] = stringFromArr($filters);

        // * Set the Slug *
        $params['slug'] = $cmsModule->slugify($params['title']);

        // _ Control data _
        $validVal = []; // array for recording validity

        // --> Control values
        if (!is_string($params['id'])
            ||!is_string($params['title'])
            ||!is_string($params['path'])
            ||!is_string($params['data'])
        ) {
            $validVal[] = false;
        } else {
            $validVal[] = true;
        }

        // --> Control slug
        $data = $cmsModule->search(
            'blog', 'id', $params['id'], true,
            'noPrint'
        );

         // Is the slug identical as before?
        if ($params['slug'] == $data[0]->slug) {
             $validVal[] = true;
        } else {
             // Check if new slug is available
            $empty = $cmsModule->isEmpty(
                'blog', 'slug', $params['slug'], true
            );
            if ($empty) {
                $validVal[] = true;
            } else {
                $validVal[] = false;
            }
        }

        // --> Control path

        // Is the path identical as before?
        if ($params['path'] == $data[0]->path) {
            $validVal[] = true;
        } else {
            // Check if new path is available
            $empty = $cmsModule->isEmpty(
                'blog', 'path', $params['path'], true
            );

            if ($empty) {
                    $validVal[] = true;
            } else {
                    $validVal[] = false;
            }
        }

        // --> Execute or not
        $execute = true;
        if (in_array(false, $validVal)) {
            $execute = false;
            $content = "Incorrect values";
        }

        if ($execute) {
            $cmsModule->update('blog', $params, 'id', $params['id']);
            $content = "Values updated";
        }

        // _ The view _
        $title = "The blog";
        $view[] = "view/blog.php";
    };

    if ($choice == 'page') {
        // Should update the database with the correct values from $_POST
        // Table, column name & new value

        // Incoming post data
        $postData = array('id', 'title', 'data');

        // The filters
        $filtersAvailable = array('bbcode', 'link', 'markdown', 'nl2br');

        // Get the corresponding set filters from $_POST
        $filters = $sendVar->postValue($filtersAvailable);

        // Create a coma seperated string from the filter array
        $theFilters = "";
        foreach ($filters as $filter => $value) {
            if (!is_numeric($value)) {
                $theFilters .= "$value,";
            }
        }
        $theFilters = rtrim($theFilters, ","); // remove last coma


        // Security value control
        // Shall be improved :) to be a function
        if (!is_string($postData[0])
            ||!is_string($postData[1])
            ||!is_string($postData[2])
        ) {
            $content = "The values are incorrect";

        } else {
            // Get the corresponding post values
            $params = $sendVar->postValue($postData);

            // Set values for databases
            $params['filter'] = $theFilters;
            $idVar = 'id';
            $idVal = $params[$idVar];

            $cmsModule->update($choice, $params, $idVar, $idVal);

            $content = 'The changes to the page are done';
        }

        // The view
        $title = "The blog";
        $view[] = "view/page.php";
    }
}
