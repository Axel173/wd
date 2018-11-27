<footer class="page-footer grey darken-3">
    <div class="container">
        <div class="row">
            <div class="col l6 s12">
                <h5 class="white-text">О Workout Diary</h5>
                <p class="grey-text text-lighten-4">Workout Diary (дневник тренировок) - Ваша персональная веб версия
                    дневника тренировок. Выбирайте тренировочные программы из сборника, или же составляйте
                    свою программу из сборника упражнений. Отмечайте свои результаты и следите за свои прогрессом.</p>
            </div>
            <div class="col l3 s12">
                <h5 class="white-text">Меню</h5>
                <ul>
                    <? if (isset($_SESSION['user'])): ?>
                        <li><a class="white-text" href="/tranings/">Мои
                                тренировки</a></li>
                        <li><a class="white-text" href="/programs/">Программы</a>
                        </li>
                        <li><a class="white-text" href="/exercises/">Упражнения</a>
                        </li>
                    <? else : ?>
                        <li><a class="white-text" href="/personal/login">Авторизация</a></li>
                        <li><a class="white-text" href="/personal/reg">Регистрация</a></li>
                    <? endif; ?>
                </ul>
            </div>
            <div class="col l3 s12">
                <h5 class="white-text">Connect</h5>
                <ul>
                    <li><a class="white-text" href="#!">Link 1</a></li>
                    <li><a class="white-text" href="#!">Link 2</a></li>
                    <li><a class="white-text" href="#!">Link 3</a></li>
                    <li><a class="white-text" href="#!">Link 4</a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="footer-copyright">
        <div class="container">
            Made by <a class="orange-text text-lighten-3" href="http://materializecss.com">Materialize</a>
        </div>
    </div>
</footer>

<!-- Load jquery, if not yet loaded -->
<script defer src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
<!-- Load lazyload.js -->
<script defer src="/workout/js/lazyload.min.js"></script>
<script>
    /*document.addEventListener('DOMContentLoaded', function () {
        // Ваш скрипт
        jQuery('.lazy').lazyload();
    }, false);*/
</script>

<!-- Compiled and minified JavaScript -->
<script defer src="/workout/js/materialize.min.js"></script>

<script defer src="/workout/js/init.js"></script>
<script defer src='https://www.google.com/recaptcha/api.js'></script>
</body>
</html>