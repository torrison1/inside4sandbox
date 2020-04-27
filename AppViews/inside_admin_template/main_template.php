<!doctype html>
<html lang="en">
<head>
    <!-- //i--- Google Analytics Code place ; inside_core ; torrison ; 01.08.2018 ; 10a ; blue ---/ -->
    <?=$inside4_website->ga_code()?>

    <!-- //i--- $seo_title - set in Controller ; inside_core ; torrison ; 01.08.2018 ; 1 ---/ -->
    <title><?= $seo_title?></title>

    <!-- //i--- $seo_description - set in Controller ; inside_core ; torrison ; 01.08.2018 ; 3 ---/ -->
    <meta name="description" content="<?=$seo_description?>">

    <!-- //i--- UTF-8 charset ; inside_core ; torrison ; 01.08.2018 ; 4 ---/ -->
    <meta charset="utf-8">

    <meta name="author" content="Digital-Outsourcing.com">

    <!-- //i--- Viewport for Mobile ; inside_core ; torrison ; 01.08.2018 ; 2 ---/ -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- ---------------------- Social Meta Data ---------------------- -->
    <!-- //i--- Social Tags ; inside_core ; torrison ; 01.08.2018 ; s1 ---/ -->
    <meta property="og:title" content="<?=$seo_title?>" />
    <meta property="og:description" content="<?=$seo_description?>" />

    <meta property="og:url" content="<?='https://'.$_SERVER['HTTP_HOST']?>" />
    <meta property="fb:app_id" content="<?=$inside4_website->config['facebook']['app_id']?>" />


    <meta property="og:image" content="<?=$inside4_website->config['facebook']['fb_img_url']?>" />
    <meta property="og:image:width" content="400" />
    <link rel="image_src" href="<?=$inside4_website->config['facebook']['fb_img_url']?>" />
    <meta itemprop="image" content="<?=$inside4_website->config['facebook']['fb_img_url']?>">


    <!-- //i--- favicon.ico ; inside_core ; torrison ; 01.08.2018 ; 8 ---/ -->
    <link rel="icon" href="/theme_core/favicon.ico">

    <!-- //i--- bootstrap-4.0 ; inside_core ; torrison ; 01.08.2018 ; 5 ---/ -->
    <!-- Bootstrap core CSS -->
    <link href="/Public/Bootstrap/bootstrap.min.css" rel="stylesheet">

    <!-- //i--- core.css ; inside_core ; torrison ; 01.08.2018 ; 6 ---/ -->
    <!-- Custom styles for this template -->
    <link href="/Public/AppFront/app_default_template/css/core.css" rel="stylesheet">

    <!-- Font -->
    <link href="https://fonts.googleapis.com/css?family=Ubuntu+Condensed" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">

    <!-- //i--- MAIN STYLE.CSS ; inside_core ; torrison ; 01.08.2018 ; 7 ---/ -->
    <!-- ... -->

    <!-- //i--- JQuery 1.11.3 OR Slim JQuery ; inside_core ; torrison ; 01.08.2018 ; 15 ---/ -->
    <script src="https://code.jquery.com/jquery-1.11.3.js"></script>
    <script>window.jQuery || document.write('<script src="js/vendor/jquery-slim.min.js"><\/script>')</script>

    <!-- //i--- JQuery UI 1.10.1 ; inside_core ; torrison ; 01.08.2018 ; 16 ---/ -->
    <script src="/Public/JQuery/jquery-ui-1.10.1.custom.min.js"></script>

    <!-- //i--- JQuery.Form ; inside_core ; torrison ; 01.08.2018 ; 17 ---/ -->
    <script src="/Public/JQuery/jquery.form.js"></script>

    <!-- //i--- JQuery.Cookie ; inside_core ; torrison ; 01.08.2018 ; 17a ---/ -->
    <script src="/Public/JQuery/jquery.cookie.js"></script>


    <!-- //i--- Include /views/outside/pages/" . $page_center."_head.php" in HEAD ; inside_template ; torrison ; 15.08.2018 ; 12 ---/ -->
    <?php
    if (@file_exists("AppViews/".$template_folder."/Pages/" . $page_center."_head.php"))
    {
        include "AppViews/".$template_folder."/Pages/" . $page_center."_head.php";

    }
    ?>

</head>

<body>

<b>Menu Tree</b>

<!-- //i--- Content insert from: 'outside/pages/' . $page_center ; inside_core ; torrison ; 01.08.2018 ; 12 ---/ -->
<?php include "AppViews/".$template_folder."/Pages/" . $page_center.".php" ?>

<!-- //i--- Template Footer Scripts ; inside_core ; torrison ; 01.08.2018 ; 14 ---/ -->
<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<!--
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
-->

<script src="/Public/Bootstrap/popper.min.js"></script>
<script src="/Public/Bootstrap/bootstrap.js"></script>
<script src="/Public/Bootstrap/holder.min.js"></script>
<script src="/Public/AppFront/app_default_template/js/custom.js"></script>

<!-- //i--- Common JavaScript file : custom.js ; inside_core ; torrison ; 01.08.2018 ; 19 ---/ -->
<!-- ... -->

<!-- //i--- Include /views/outside/pages/" . $page_center."_footer.php" before END /body ; inside_core ; torrison ; 01.08.2018 ; 20 ---/ -->
<?php

if (@file_exists("AppViews/".$template_folder."/Pages/" . $page_center."_footer.php"))
{
    include "AppViews/".$template_folder."/Pages/" . $page_center."_footer.php";

}
?>

</body>
</html>