<? if (!isset($_SESSION['user']) and !isset($_COOKIE['key'])): ?>
    <div class="card card-login">
        <div class="card-login-splash hide-on-small-only">
            <div class="wrapper center-align">
                <!--<h3>Аккаунт</h3>-->
                <a class="btn-large waves-effect waves-light" href="/personal/reg">Регистрация</a>
            </div>

        </div>
        <div class="card-content">
            <span class="card-title">Восстановление пароля</span>
            <form action="/personal/restoration" method="post">
                <div class="input-field">
                    <input id="email" class="validate" type="email" name="email">
                    <label for="email" class="">E-mail*</label>
                </div>
                <p>Что бы восстановить свой пароль, нужно ввести свой email, к которому привязан Ваш аккаунт</p>
                <br><br>
                <?= isset($_SESSION['form_data']['errors']['not_found']) ? $_SESSION['form_data']['errors']['not_found'] : ''; ?>

                <? if (isset($_SESSION['auth']['count']) and $_SESSION['auth']['count'] > 5): ?>
                    <div class="input-field">
                        <div class="g-recaptcha" style="transform: translateX(-28px) scale(0.9);"
                             data-sitekey="6Ld0mHYUAAAAAI5QdaIWmP2JVpAOjob47ABK8xjr"></div>
                    </div>
                <? endif; ?>
                <div>
                    <button class="btn-large right waves-effect waves-light" type="submit" name="action">Сбросить пароль
                    </button>
                </div>
                <br>
                <?php if (isset($_SESSION['form_data'])) unset($_SESSION['form_data']) ?>
            </form>
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
