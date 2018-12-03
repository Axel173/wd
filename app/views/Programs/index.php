<? //debug($programs); ?>
<? if (isset($programs)): ?>
    <? foreach ($programs['programs'] as $program_key => $program): ?>
        <ul class="collapsible popout">
            <li>
                <div class="collapsible-header"><i class="material-icons">bookmark</i><?= $program->name ?>
                </div>
                <div class="collapsible-body">
                    <div class="col s12">
                        <div class="row">
                            <div class="col s12">
                                <ul class="tabs workout-tabs">

                                    <? $program_id = $program->id;
                                    foreach ($programs['days'] as $day_key => $day): ?>
                                        <? foreach ($programs['programs_list'] as $key => $item): ?>
                                            <? if ($day->id == $item->day_id and $item->id == $program_id): ?>
                                                <li class="tab col s2"><a class="active"
                                                                          href="#tab<?= $key ?>"><?= $day['name'] ?></a>
                                                </li>
                                                <? break; ?>
                                            <? endif; ?>
                                        <? endforeach; ?>
                                    <? endforeach; ?>
                                </ul>

                                <? foreach ($programs['programs_list'] as $program_list_key => $program_list): ?>
                                    <? if ($program_list->program_id == $program->id): ?>
                                        <div id="tab<?= $program_list_key ?>" class="col s12">
                                            <ul class="collection with-header">
                                                <li class="collection-header">
                                                    <h4><?= $programs['days'][$program_list->day_id]->name ?></h4></li>
                                                <? foreach ($programs['exercises'] as $exercise_key => $exercise): ?>
                                                    <? if ($program_list->exercise_id == $exercise->id): ?>
                                                        <div class="col s12 l4 m2 center-align">
                                                            <img class="responsive-img bloc_center"
                                                                 src="/uploads/images/exercises/<?= $exercise->preview_img ?>">
                                                        </div>
                                                        <div class="col s12 l4 m5">
                                                            <ul class="collection">
                                                                <li class="collection-item"><?= $exercise->name ?>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                        <div class="col s12 l4 m5">
                                                            <ul class="collection">
                                                                <li class="collection-item">Повторений: <span
                                                                            class="new badge red"
                                                                            data-badge-caption="<?= $program_list->repetitions ?>"></span>
                                                                    <br><br>Подходы: <span class="new badge"
                                                                                           data-badge-caption="<?= $program_list->way ?>"></span>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                        <div class="clearfix"></div>
                                                        <li class="divider"></li>
                                                    <? endif; ?>
                                                <? endforeach; ?>
                                            </ul>
                                        </div>
                                    <? endif; ?>

                                <? endforeach; ?>

                            </div>
                        </div>
                    </div>
                </div>
            </li>
        </ul>
    <? endforeach; ?>
<? else: ?>
    Привет! Тут будет список программ
<? endif; ?>

<!--<ul class="collapsible popout">
    <li>
        <div class="collapsible-header"><i class="material-icons">bookmark</i>Начальная программа
        </div>
        <div class="collapsible-body">
            <div class="col s12">
                <div class="row">
                    <div class="col s12">
                        <ul class="tabs workout-tabs" id="tabs-swipe">
                            <li class="tab col s2"><a class="active" href="#tab1">Понедельник</a></li>
                        </ul>

                        <div id="tab1" class="col s12">
                            <ul class="collection with-header">
                                <li class="collection-header"><h4>Пятница</h4></li>
                                <div class="col s12 l4 m2 center-align">
                                    <img class="responsive-img bloc_center"
                                         src="/uploads/images/exercises/poperemennoe-sgibanie.jpg">
                                </div>
                                <div class="col s12 l4 m5">
                                    <ul class="collection">
                                        <li class="collection-item">Концентрированное сгибание одной руки с гантелью
                                        </li>
                                    </ul>
                                </div>
                                <div class="col s12 l4 m5">
                                    <ul class="collection">
                                        <li class="collection-item">Повторений: <span class="new badge red"
                                                                                      data-badge-caption="8"></span>
                                            <br><br>Подходы: <span class="new badge" data-badge-caption="4"></span>
                                        </li>
                                    </ul>
                                </div>
                                <div class="clearfix"></div>
                                <li class="divider"></li>
                                <div class="col s12 l4 m2 center-align">
                                    <img class="responsive-img bloc_center"
                                         src="/uploads/images/exercises/poperemennoe-sgibanie.jpg">
                                </div>
                                <div class="col s12 l4 m5">
                                    <ul class="collection">
                                        <li class="collection-item">Концентрированное сгибание одной руки с гантелью
                                        </li>
                                    </ul>
                                </div>
                                <div class="col s12 l4 m5">
                                    <ul class="collection">
                                        <li class="collection-item">Повторений: <span class="new badge red"
                                                                                      data-badge-caption="8"></span>
                                            <br><br>Подходы: <span class="new badge" data-badge-caption="4"></span>
                                        </li>
                                    </ul>
                                </div>
                                <div class="clearfix"></div>
                                <li class="divider"></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </li>
</ul>-->


