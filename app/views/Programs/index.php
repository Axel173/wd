<? //debug($programs); ?>
<? if (isset($programs)): ?>
    <? foreach ($programs as $program_key => $program): ?>
        <ul class="collapsible popout">
            <li>
                <div class="collapsible-header avatar"><i class="material-icons">bookmark</i><?= $program['name'] ?>
                    <? if (isset($program['user'])): ?>
                        <img title="<?= $program['user'][$program['user_id']]['name'] . ' ' . $program['user'][$program['user_id']]['surname'] ?>" src="/uploads/images/users/<?= $program['user'][$program['user_id']]['avatar'] ?>" alt=""
                             class="collapsible-header__avatar circle">
                    <? endif; ?>

                </div>
                <div class="collapsible-body">
                    <div class="col s12">
                        <div class="row">
                            <div class="col s12">
                                <ul class="tabs workout-tabs">
                                    <? foreach ($program['days'] as $day_key => $day): ?>

                                        <li class="tab col s2"><a class="active"
                                                                  href="#tab<?= reset($day['programs_list'])['id'] ?>"><?= $day['name'] ?></a>
                                        </li>
                                    <? endforeach; ?>
                                </ul>
                                <? foreach ($program['days'] as $day_key => $day): ?>
                                    <div id="tab<?= reset($day['programs_list'])['id'] ?>" class="col s12">
                                        <ul class="collection with-header">
                                            <li class="collection-header">
                                                <h4><?= $day['name'] ?></h4>
                                            </li>
                                            <? foreach ($day['programs_list'] as $list_key => $list): ?>
                                                <div class="col s12 l4 m2 center-align">
                                                    <a href="/exercise/<?= $list['exercise']['alias'] ?>"><img
                                                                class="responsive-img bloc_center"
                                                                src="/uploads/images/exercises/<?= $list['exercise']['preview_img'] ?>"></a>
                                                </div>
                                                <div class="col s12 l4 m5">
                                                    <ul class="collection">
                                                        <li class="collection-item"><a
                                                                    href="/exercise/<?= $list['exercise']['alias'] ?>"><?= $list['exercise']['name'] ?></a>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <div class="col s12 l4 m5">
                                                    <ul class="collection">
                                                        <li class="collection-item">Повторений: <span
                                                                    class="new badge red"
                                                                    data-badge-caption="<?= $list['repetitions'] ?>"></span>
                                                            <br><br>Подходы: <span class="new badge"
                                                                                   data-badge-caption="<?= $list['way'] ?>"></span>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <div class="clearfix"></div>
                                                <li class="divider"></li>
                                            <? endforeach; ?>
                                        </ul>
                                    </div>
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
