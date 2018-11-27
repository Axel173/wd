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
            <form action="/personal/reset" method="post">
                <div class="input-field">
                    <input id="password" class="validate" type="password" name="password">
                    <label for="password">Новый пароль*</label>
                    <?= isset($_SESSION['form_data']['errors']['password']) ? $_SESSION['form_data']['errors']['password'] : ''; ?>

                </div>
                <div class="input-field">
                    <input id="password_repeat" class="validate" type="password" name="password_repeat">
                    <label for="password_repeat">Повторить пароль*</label>
                    <?= isset($_SESSION['form_data']['errors']['password_repeat']) ? $_SESSION['form_data']['errors']['password_repeat'] : ''; ?>
                </div>

                <?= isset($_SESSION['form_data']['errors']['social']) ? $_SESSION['form_data']['errors']['social'] : ''; ?>

                    <div class="input-field">
                        <div class="g-recaptcha" style="transform: translateX(-28px) scale(0.9);"
                             data-sitekey="6Ld0mHYUAAAAAI5QdaIWmP2JVpAOjob47ABK8xjr"></div>
                    </div>

                <div>
                    <button class="btn-large right waves-effect waves-light" type="submit" name="action">Сбросить
                    </button>
                </div>
                <br>
                <?php if (isset($_SESSION['form_data'])) unset($_SESSION['form_data']) ?>
            </form>
        </div>
    </div>

<? else: ?>
    вы уже авторизованы
<? endif; ?>
