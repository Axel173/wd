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
                                            <? if ($day->id == $item->day_id and $item->program_id == $program_id): ?>
                                                <li class="tab col s2"><a class="active"
                                                                          href="#tab<?= $key ?>"><?= $day['name'] ?></a>
                                                </li>
                                                <? break 1; ?>
                                            <? endif; ?>
                                        <? endforeach; ?>
                                    <? endforeach; ?>
                                </ul>
                                <? foreach ($programs['days'] as $day_key => $day): ?>
                                    <? foreach ($programs['programs_list'] as $program_list_key => $program_list): ?>
                                        <? if ($day->id == $program_list->day_id and $program_list->program_id == $program_id): ?>
                                            <div id="tab<?= $program_list_key ?>" class="col s12">
                                                <ul class="collection with-header">
                                                    <li class="collection-header">
                                                        <h4><?= $day->name ?></h4>
                                                    </li>
                                                    <? foreach ($programs['programs_list'] as $k => $i): ?>
                                                        <? if ($day->id == $i->day_id and $i->program_id == $program_id): ?>
                                                            <div class="col s12 l4 m2 center-align">
                                                                <a href="/exercise/<?= $programs['exercises'][$i->exercise_id]->alias ?>"><img
                                                                            class="responsive-img bloc_center"
                                                                            src="/uploads/images/exercises/<?= $programs['exercises'][$i->exercise_id]->preview_img ?>"></a>
                                                            </div>
                                                            <div class="col s12 l4 m5">
                                                                <ul class="collection">
                                                                    <li class="collection-item"><a href="/exercise/<?= $programs['exercises'][$i->exercise_id]->alias ?>"><?= $programs['exercises'][$i->exercise_id]->name ?></a>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                            <div class="col s12 l4 m5">
                                                                <ul class="collection">
                                                                    <li class="collection-item">Повторений: <span
                                                                                class="new badge red"
                                                                                data-badge-caption="<?= $i->repetitions ?>"></span>
                                                                        <br><br>Подходы: <span class="new badge"
                                                                                               data-badge-caption="<?= $i->way ?>"></span>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                            <div class="clearfix"></div>
                                                            <li class="divider"></li>
                                                        <? endif; ?>

                                                    <? endforeach; ?>
                                                </ul>
                                            </div>
                                            <? break; ?>
                                        <? endif; ?>
                                    <? endforeach; ?>
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
