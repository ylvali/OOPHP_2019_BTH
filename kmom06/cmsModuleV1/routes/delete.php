<?php

// $navBarSub .= "<a href='?route=delete&&sub=blog&&id=$id'> Blog </a>";
if ($choice) {
    if ($choice == 'blog') {

        // Delete that id
        if ($id) {

            $content = "Are you sure?";
            $content .= "<a href='?route=delete&&sub=
                    blog&&id=$id&&confirm=yes'> Yes </a>";

            // Avoid errors with confirming the delete
            if ($confirm) {
                $column = 'id';
                $cmsModule->softDelete($choice, $column, $id);

                $content = 'blog deleted';
            }
        }

    } else {
        // Display the edit page
        $content = 'delete page';
    }

    // The view
    $title = "The blog";
    $view[] = "view/blog.php";
}
