<?php
$navBarSub = "<a href='?route=admin&&sub=page'> Page </a>";
$navBarSub .= "<a href='?route=admin&&sub=blog'> Blog </a>";

if ($choice) {
    if($choice == 'blog') {
        // Display blog with edit / delete options
        $content = "<a href='?route=create&&sub=blog'> Create new </a>";
        $content .= 'blog admin';
        $optionRef = 'blogAdmin'; // reference for the printer
        $content .= $cmsModule->read($choice, $optionRef);
        // Plus the option to create a new post

        // The view
        $title = "The blog";
        $view[] = "view/blog.php";

    } else {
        // The only option is to edit the page,
        // so this route redirects to the edit section.
        header("Location:?route=edit&&sub=page");
        $content = 'page admin';

        // The view
        $title = "The page";
        $view[] = "view/page.php";
    }
}
