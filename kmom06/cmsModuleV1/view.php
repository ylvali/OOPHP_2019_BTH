<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="style/style.css">
    <link rel="stylesheet" href="style/extra.css">
    <link rel="stylesheet" href="style/normalize.min.css" />
    <link rel="icon" href="img/purpleYellowFlo.jpg" type="image/png">
</head>
<body>

<div class='nav'>
    <?php echo $navBar ?>
    <div class='cornerImg'></div>
</div>
<div class='headerImg'>  </div>
<div class='mainContent'>

    <div class='contentCenter'>
        <div id='titleBar'>
            <h1> <?php echo $route ?> </h1>
            <?php echo $navBarSub ?> <br/>
        </div>

        <?php
        // load content
        foreach($view as $seeThis) {
            include $seeThis;
        }
         ?>

    </div>
</div>

</div>
<div class='footer'>     <p> | Cms Demo |</p>
                         <p> | Blekinge Tekniska Högskola | </p>
                         <p> | 2020 | </p>
                         <p> | Ylva Sjölin |</p> </div>

</body>
</html>
