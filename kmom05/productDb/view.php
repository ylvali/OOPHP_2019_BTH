<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="style/style.css">
    <link rel="stylesheet" href="style/normalize.min.css" />
    <link rel="icon" href="img/purpleYellowFlo.jpg" type="image/png">


</head>
<body>

<div class='nav'>
    <div class='cornerImg'></div>
    <p> Product Demo | BTH 2020 | Ylva Sjölin </p>

</div>
<div class='headerImg'>  </div>
<div class='mainContent'>

    <div class='contentCenter'>
        <div id='titleBar'></div>
        <h1> Products </h1>

        <div class='btnPanel'> <p> <?php echo $btnPanel ?> </p> </div>
        <p> <?php echo $res ?> </p>
        <p> <?php echo $pageLink ?> </p>
        <p> <?php if($nrPages) {
            echo 'Page nr: ';
            echo $nrPages; } ?></p>
    </class>
    </div>

</div>
<div class='footer'>     <p> | Product Demo |</p>
                         <p> | Blekinge Tekniska Högskola | </p>
                         <p> | 2020 | </p>
                         <p> | Ylva Sjölin |</p>

                         <br/>
                         <br/>

                         <a href='index.php'> < Intro </a>

                     </div>

</body>
</html>
