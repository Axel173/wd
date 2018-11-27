<?php new \app\widgets\menu\Menu([
    'tpl' => APP . '/widgets/menu/workout/exercises.php',
    //'tpl' => WWW . '/menu/select.php',
    'container' => 'div',
    'class' => 'collection row exercises_menu',
    'table' => 'groups',
    'cache' => 1,
    'cacheKey' => 'exercises'.$this->route['url'],
    'route' => $this->route
]); ?>

<? //debug($exercise); ?>
<? if (isset($exercise)): ?>
    <h1><?=$exercise['name']?></h1>
    <img class="responsive-img left" src="/uploads/images/exercises/<?= $exercise['main_img'] !== '' ? $exercise['main_img'] : $exercise['preview_img'] ?>">
    <p><?=$exercise['description']?></p>
<div class="clearfix"></div>
<? endif; ?>