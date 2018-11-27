<!DOCTYPE HTML>
<html>
<head>
    <?php \fw\core\base\View::getMeta() ?>
    <?php \fw\core\base\View::getCss(
        array(
            WWW . '/blog/css/bootstrap.css',
            WWW . '/blog/css/style.css',
        ),
        PUBLIC_CACHE,
        'css_all_',
        3600
    );
    ?>

    <!--<link href="/blog/css/bootstrap.css" rel='stylesheet' type='text/css' />
    <link href="/blog/css/style.css" rel='stylesheet' type='text/css' />-->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

</head>
<body>
<!---header---->

<div class="header">
    <div class="container">
        <div class="logo">
            <a href="/"><img src="/blog/images/logo.jpg" title=""/></a>
        </div>
        <!---start-top-nav---->
        <div class="top-menu">
            <div class="search">
                <form>
                    <input type="text" placeholder="" required="">
                    <input type="submit" value=""/>
                </form>
            </div>
            <span class="menu"> </span>
            <ul>
                <li class="active"><a href="/">HOME</a></li>
                <li><a href="web/about.html">ABOUT</a></li>
                <li><a href="web/contact.html">CONTACT</a></li>
                <div class="clearfix"></div>
            </ul>
        </div>
        <div class="clearfix"></div>

        <!---//End-top-nav---->
    </div>
</div>

<!--/header-->