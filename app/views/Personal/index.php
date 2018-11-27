<? if (!isset($_SESSION['user']) and !isset($_COOKIE['key'])): ?>
    <div class="card card-login">
        <div class="card-login-splash">
            <div class="wrapper center-align">
                <!--<h3>Аккаунт</h3>-->
                <a class="btn-large waves-effect waves-light" href="/personal/reg">Регистрация</a>
            </div>

        </div>
        <div class="card-login-splash" style="background-image: url('../workout/img/maxresdefault.jpg')";>
            <div class="wrapper center-align">
                <!--<h3>Аккаунт</h3>-->
                <a class="btn-large waves-effect waves-light" href="/personal/login">Войти</a>
            </div>

        </div>
    </div>

    <?
    if (isset($_SESSION['vk_user'])) {
        $user = $_SESSION['vk_user'];
        unset($_SESSION['vk_user']);
    }
    ?>


<? else: ?>
    вы уже авторизованы
<? endif; ?>
