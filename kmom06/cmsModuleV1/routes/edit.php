<?php

// $navBarSub = "<a href='?route=edit&&sub=page'> Page </a>";
// $navBarSub .= "<a href='?route=edit&&sub=blog&&id=$id'> Blog </a>";
if ($choice) {

    if ($choice == 'blog') {

        // Display the form for that id
        if($id) {
            $content .= ' ID: '.$id;
            // Display the form for that id
            $optionRef = 'theForm';
            $column = 'id';
            $exactVal = true; // Search exact value
            $content .= $cmsModule->search($choice, $column, $id, $exactVal, $optionRef);
            $content .= "<a href='?route=delete&&sub=blog&&id=$id'> Delete </a>";

            // The view
            $title = "The blog";
            $view[] = "view/blog.php";
        }

    } else {
        // ONLY EDITS FIRST ONE
        // Display the form for that id
            $id = 1;
            $content .= ' ID: '.$id;
            // Display the form for that id
            $optionRef = 'theForm';
            $column = 'id';
            $exactVal = true; // Search exact value
            $content .= $cmsModule->search($choice, $column, $id, $exactVal, $optionRef);

            // The view
            $title = "The page";
            $view[] = "view/page.php";
        }
    }
