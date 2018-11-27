<!---->
<div class="footer">
    <div class="container">
        <p>Copyrights © 2015 Blog All rights reserved | Template by <a href="http://w3layouts.com/">W3layouts</a></p>
    </div>
</div>


<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<!--end slider -->


<?php \fw\core\base\View::getJs(
    array(
        WWW . '/blog/js/main.js',
        WWW . '/blog/js/move-top.js',
        WWW . '/blog/js/easing.js',
    ),
    '/blog/js/',
    'js_all_'
);
?>

<script type="text/javascript">
    jQuery(document).ready(function ($) {
        $(".scroll").click(function (event) {
            event.preventDefault();
            $('html,body').animate({scrollTop: $(this.hash).offset().top}, 900);
        });
    });
</script>
<script>
    $("span.menu").click(function () {
        $(".top-menu ul").slideToggle("slow", function () {
        });
    });
</script>
<!---->
<!----webfonts---->
<link href='http://fonts.googleapis.com/css?family=Oswald:100,400,300,700' rel='stylesheet' type='text/css'>
<link href='http://fonts.googleapis.com/css?family=Lato:100,300,400,700,900,300italic' rel='stylesheet' type='text/css'>
<?
    foreach ($scripts as $script)
    {
        echo $script;
    }
?>

</body>
</html>