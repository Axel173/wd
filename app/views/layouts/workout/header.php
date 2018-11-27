<!DOCTYPE html>
<html lang="ru">
<head>
    <title><?=$this->getTitle();?></title>
    <?=$this->getMeta();?>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0"/>

    <!-- CSS  -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <!-- Compiled and minified CSS -->
    <link type="text/css" rel="stylesheet" href="/workout/css/materialize.min.css"  media="screen,projection"/>

    <link href="/workout/css/style.css" type="text/css" rel="stylesheet" media="screen,projection"/>
</head>
<body>
<header>
    <nav class="grey darken-3" role="navigation">
        <div class="nav-wrapper container"><a id="logo-container" href="/" class="brand-logo">WD</a>
            <ul class="right hide-on-med-and-down">
                <? if (isset($_SESSION['user'])): ?>
                    <li <?= is_active($this->route['controller'], ['Tranings'])?>><a href="/tranings/">Мои тренировки</a></li>
                    <li <?= is_active($this->route['controller'], ['Programs'])?>><a href="/programs/">Программы</a></li>
                    <li <?= is_active($this->route['controller'], ['Exercises', 'Exercise'])?>><a href="/exercises/">Упражнения</a></li>
                    <li><a href="/personal/logout">Выйти</a></li>
                <? else : ?>
                    <li<?= is_active($this->route['url'], 'personal/login')?>><a href="/personal/login"><i class="material-icons left">account_box</i>Авторизация</a></li>
                    <li<?= is_active($this->route['url'], 'personal/reg')?>><a href="/personal/reg"><i class="material-icons left">perm_identity</i>Регистрация</a></li>
                <? endif; ?>
            </ul>

            <ul id="nav-mobile" class="sidenav">
                <? if (isset($_SESSION['user'])): ?>
                    <li <?= is_active($this->route['controller'], ['Tranings'])?>><a href="/tranings/">Мои тренировки</a></li>
                    <li <?= is_active($this->route['controller'], ['Programs'])?>><a href="/programs/">Программы</a></li>
                    <li <?= is_active($this->route['controller'], ['Exercises', 'Exercise'])?>><a href="/exercises/">Упражнения</a></li>
                    <li><a href="/personal/logout">Выйти</a></li>
                <? else : ?>
                    <li<?= is_active($this->route['url'], ['personal/login'])?>><a href="/personal/login"><i class="material-icons left">account_box</i>Авторизация</a></li>
                    <li<?= is_active($this->route['url'], ['personal/reg'])?>><a href="/personal/reg"><i class="material-icons left">perm_identity</i>Регистрация</a></li>
                <? endif; ?>
            </ul>
            <a href="#" data-target="nav-mobile" class="sidenav-trigger"><i class="material-icons">menu</i></a>
        </div>
    </nav>
</header>
<div class="progress" style="margin: 0">
    <div class="determinate" id="progress" style="width: 0%"></div>
</div>

<?//dd($this->route);?>