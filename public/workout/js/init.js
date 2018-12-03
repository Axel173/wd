/*(function ($) {
    $(function () {
        $('.sidenav').sidenav();
    }); // end of document ready
})(jQuery); // end of jQuery name space*/
function progressPage() {
    progressBar = document.getElementById('progress');
    progressBar.style.width = "25%";
    document.addEventListener('readystatechange', function () {
        progressBar.style.width = "50%";
    });
    document.addEventListener('DOMContentLoaded', function () {
        progressBar.style.width = "75%";
    });

    window.onload = function () {
        progressBar.style.width = "100%";
    };
}

function showErrorModal(title, body) {
    var elem = document.createElement('div');
    elem.innerHTML = '<div class="modal-content">\n' +
        '      <h4>' + title + '</h4>\n' +
        '      <p>' + body + '</p>\n' +
        '    </div>\n' +
        '    <div class="modal-footer">\n' +
        '      <a class="modal-close waves-effect waves-green btn-flat">Закрыть</a>\n' +
        '    </div>';
    elem.setAttribute('id', 'modalError');
    elem.setAttribute('class', 'modal');
    document.body.appendChild(elem);

    var elem = document.getElementById('modalError');
    var instances = M.Modal.init(elem, {});

    var instance = M.Modal.getInstance(elem);

    instance.open();

    //document.querySelector('body').
}

function showOverlay() {
    var elem = document.createElement('div');
    elem.setAttribute('id', 'loading_overlay');
    /*elem.setAttribute('class', 'modal-overlay');
    elem.style.opacity = "0.5";
    elem.style.display = "block";*/
    elem.innerHTML = '<div class="preloader-wrapper big active" style="position: fixed;display: block;top: 50%;right: 50%; margin-right: -32px; z-index: 1026;">\n' +
        '      <div class="spinner-layer">\n' +
        '      <div class="circle-clipper left">\n' +
        '        <div class="circle"></div>\n' +
        '      </div><div class="gap-patch">\n' +
        '        <div class="circle"></div>\n' +
        '      </div><div class="circle-clipper right">\n' +
        '        <div class="circle"></div>\n' +
        '      </div>\n' +
        '    </div></div><div class="modal-overlay" style="opacity: 0.3; display: block;"></div>';
    document.body.appendChild(elem);
}

function hideOverlay() {
    var elem = document.getElementById('loading_overlay');
    elem.remove();
}

progressPage();

document.addEventListener('DOMContentLoaded', function () {
        var res;
        jQuery('document').ready(function () {

            jQuery(document).on('click', 'a.ajax', function (e) {
                //console.log(this);
                e.preventDefault();
                var href = $(this).attr('href');

                // Getting Content
                getContent(href, true);
            });
        });

        // Adding popstate event listener to handle browser back button
        window.addEventListener("popstate", function (e) {
            console.log(e);
            // Update Content
            getContent(location.href, false);
            document.title = history.state.title;
        });

        function getContent(url, addEntry) {
            showOverlay();
            progressBar = document.getElementById('progress');
            progressBar.style.width = "25%";
            $.ajax({
                url: url,
                type: 'GET',
                /*data: {
                    answers: code,
                    endTimeTest: endTimeTest
                },*/
                async: true,
                cache: false,
                success: function (res) {
                    try {
                        jsonRes = JSON.parse(res);
                        if (jsonRes.data) {

                            $('.section:eq(0)').html(jsonRes.data.attributes.body);
                        }

                        if (addEntry == true) {

                            var stateData = {
                                "location": url,
                                "title": jsonRes.data.attributes.title
                            };
                            console.log(stateData);

                            // Add History Entry using pushState
                            history.pushState(stateData, '', url);
                            document.title = jsonRes.data.attributes.title;
                        }

                        progressBar.style.width = "50%";

                    } catch (err) {
                        showErrorModal('Произошла ошибка', err);
                        // обработка ошибки
                    }
                    //$('.section:eq(0)').html(jsonRes.template);
                },
                error: function (jqxhr, status, errorMsg) {
                    showErrorModal('Не получилось выполнить запрос', 'Статус: ' + status + '<br> Ошибка: ' + errorMsg);
                },
                complete: function (data) {
                    hideOverlay();
                    progressBar.style.width = "100%";
                    //$('.ajax-loader').hide();
                }
            });
        }

        M.AutoInit();

        var datepickerElems = document.querySelectorAll('.datepicker');
        var datepickerInstances = M.Datepicker.init(datepickerElems, {
            format: 'yyyy.mm.dd',
            yearRange: 40,
            maxDate: now = new Date(),
            i18n: {
                months:
                    [
                        'Январь',
                        'Февраль',
                        'Март',
                        'Апрель',
                        'Май',
                        'Июнь',
                        'Июль',
                        'Август',
                        'Сентябрь',
                        'Октябрь',
                        'Ноябрь',
                        'Декабрь'
                    ],
                cancel: 'Отмена',
                clear: 'Очистить',
                done: 'Ок',
                monthsShort:
                    [
                        'Янв',
                        'Фев',
                        'Март',
                        'Апр',
                        'Май',
                        'Июнь',
                        'Июль',
                        'Авг',
                        'Сен',
                        'Окт',
                        'Ноя',
                        'Дек'
                    ],
                weekdays:
                    [
                        'Понедельник',
                        'Вторник',
                        'Среда',
                        'Четверг',
                        'Пятница',
                        'Суббота',
                        'Воскресенье'
                    ],
                weekdaysShort:
                    [
                        'Пон',
                        'Вто',
                        'Сре',
                        'Чет',
                        'Пят',
                        'Суб',
                        'Вос'
                    ],
                weekdaysAbbrev: ['П', 'В', 'С', 'Ч', 'П', 'С', 'В'],
            },
            autoClose: true
        });

        /*для сложных вычислений*/
        /*function doSomething (progressFn [, дополнительные аргументы]) {
            // Выполняем инициализацию
            (function () {
                // Делаем вычисления...
                if (*условие для продолжения) {
                    // Уведомляем приложение о текущем прогрессе
                    progressFn(значение, всего);
                    // Обрабатываем следующий кусок
                    setTimeout(arguments.callee, 0);
                }
            })();
        }*/
        /*для сложных вычислений*/
    }
);



