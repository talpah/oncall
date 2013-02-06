<?php 
    $baseFragment = dirname($_SERVER['SCRIPT_URL']).'/';
    
?>
<!DOCTYPE html>
<html>
<head>
    <title>onCall</title>
    <link rel="stylesheet" type="text/css" href="<?php echo $baseFragment; ?>assets/css/html5reset-1.6.1.css" media="all">
    <link rel="stylesheet" type="text/css" href="<?php echo $baseFragment; ?>assets/css/oncall.css" media="all">
    <link href='http://fonts.googleapis.com/css?family=Julius+Sans+One' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Averia+Libre' rel='stylesheet' type='text/css'>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
    <script type="text/javascript" src="<?php echo $baseFragment; ?>assets/js/data-table.js"></script>
    <script type="text/javascript" src="<?php echo $baseFragment; ?>assets/js/oncall.js"></script>
</head>
<body>
<div id="menu">
    <ul class="menu top">
        <li>
            <a href="/">Main</a>
            <ul class="menu sub">
                <li><a href="search">Search</a></li>
            </ul>
        </li>
        <li>
            <a href="/today">Today</a>
        </li>
        <li>
            <a href="/week">This week</a>
        </li>
        <li>
            <a href="/month">This month</a>
        </li>
    </ul>
</div>
<div id="tagline">
    <div id="user">Cosmin I.</div>
    <div id="quickactions">
        <button id="hilightme">Show on grid</button>
    </div>
</div>
<div id="main">
    <div class="dataTable" id="dataTable"></div>
</div>

</body>
</html>