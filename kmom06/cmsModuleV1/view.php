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
    <p> </p>
</div>
<div class='mainContent'>

    <div class='contentCenter'>
        <div id='titleBar'>

            <?php echo $navBar ?> <br/>
        </div>
        <p> SubNav: <?php echo $navBarSub ?> </p> <br/>
        <p> Chosen: <?php echo $choice ?> </p> <br/>
        <?php echo $content ?>

    </div>
    </div>

</div>
<div class='footer'>     <p> | Cms Demo |</p>
                         <p> | Blekinge Tekniska Högskola | </p>
                         <p> | 2020 | </p>
                         <p> | Ylva Sjölin |</p> </div>

</body>
</html>
