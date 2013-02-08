<!DOCTYPE html>
<html>
<head>
    <title>onCall Exception</title>
    <link rel="stylesheet" type="text/css" href="/assets/css/html5reset-1.6.1.css" media="all">
    <link rel="stylesheet" type="text/css" href="/assets/css/oncall.css" media="all">
    <link href='http://fonts.googleapis.com/css?family=Julius+Sans+One' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Averia+Libre' rel='stylesheet' type='text/css'>
    <link href='http://code.jquery.com/ui/1.10.0/themes/base/jquery-ui.css' rel='stylesheet' type='text/css'>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
    <script type="text/javascript" src="http://code.jquery.com/ui/1.10.0/jquery-ui.js"></script>
</head>
<body>
<div id="menu">
    <ul class="menu top">
        <li>
            <a href="/">Projects</a>
            <ul class="menu sub">
                <li><a href="/proj1">Proj1</a></li>
            </ul>
        </li>
        <li>
            <a href="/today">Today</a>
        </li>
    </ul>
</div>
<div id="tagline">
    <div id="user">An error ocurred</div>
</div>
<div id="main">
<h1>
<?php echo $exception->getMessage(); ?>
</h1>
<br />
<pre>
    <?php 
        var_dump($exception);
    ?>
</pre>    
</div>

</body>
</html>