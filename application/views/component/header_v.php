<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="utf-8">
    <meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Zliczacz godzinowo-posiłkowy</title>

    <meta name="robots" content="noindex, nofollow">
    <meta name="description" content="">
    <meta name="author" content="daru79">

    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/lib/bootstrap-2.1.1/css/bootstrap.min.css'); ?>">
    <link rel="stylesheet" type="text/css" href="<?php print base_url('assets/lib/font-awesome/css/font-awesome.css'); ?>">
    <link rel="stylesheet" type="text/css" href="<?php print base_url('assets/css/theme.css'); ?>">
    <link rel="stylesheet" type="text/css" href="<?php print base_url('assets/css/custom.css'); ?>">

    <script src="<?php print base_url('assets/lib/jquery-1.7.2.min.js'); ?>"></script>
    <script src="<?php print base_url('assets/lib/bootstrap-2.1.1/js/bootstrap.min.js'); ?>"></script>

    <!-- In-place editing assets => https://vitalets.github.io/x-editable/index.html -->
    <link rel="stylesheet" type="text/css" href="<?php print base_url('assets/lib/bootstrap-editable-1.5.1/bootstrap-editable/css/bootstrap-editable.css'); ?>">
    <script src="<?php print base_url('assets/lib/bootstrap-editable-1.5.1/bootstrap-editable/js/bootstrap-editable.min.js'); ?>"></script>
    <!-- /.In-place editing assets => https://vitalets.github.io/x-editable/index.html -->
    
    <!-- Custom JS file -->
    <script src="<?php print base_url('assets/js/custom.js'); ?>"></script>
    <!-- /Custom JS file -->

    <!-- Demo page code -->

    <style type="text/css">
        #line-chart {
            height:300px;
            width:800px;
            margin: 0px auto;
            margin-top: 1em;
        }
        .brand { font-family: georgia, serif; }
        .brand .first {
            color: #ccc;
            font-style: italic;
        }
        .brand .second {
            color: #fff;
            font-weight: bold;
        }
    </style>

    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <!-- Le fav and touch icons -->
    <link rel="shortcut icon" href="../assets/ico/favicon.ico">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="../assets/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="../assets/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="../assets/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="../assets/ico/apple-touch-icon-57-precomposed.png">
</head>

<!--[if lt IE 7 ]> <body class="ie ie6"> <![endif]-->
<!--[if IE 7 ]> <body class="ie ie7 "> <![endif]-->
<!--[if IE 8 ]> <body class="ie ie8 "> <![endif]-->
<!--[if IE 9 ]> <body class="ie ie9 "> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!-->
<body class="">
<!--<![endif]-->