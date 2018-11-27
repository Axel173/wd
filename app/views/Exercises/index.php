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

<div class="col s12">
    <div class="row">
        <? if (isset($exercises)): ?>
            <? if ($exercises): ?>
                <? foreach ($exercises as $exercise): ?>
                    <div class="exercise col s12 xl3 l6 m6">
                        <div class="card hoverable">
                            <div class="card-image "><a class="ajax" href="/exercise/<?= $exercise['alias'] ?>"><img
                                            class="bloc_center"
                                            src="/uploads/images/exercises/<?= $exercise['preview_img'] !== '' ? $exercise['preview_img'] : $exercise['main_img'] ?>"></a>
                            </div>
                            <li tabindex="-1" class="divider"></li>
                            <div class="card-content center-align">
                                <a class="ajax" href="/exercise/<?= $exercise['alias'] ?>"><span><?= $exercise['name'] ?></a></span>
                            </div>
                        </div>
                    </div>
                <? endforeach; ?>
            <? endif; ?>
        <? endif; ?>
    </div>
</div>

<?= $pagination ?>
