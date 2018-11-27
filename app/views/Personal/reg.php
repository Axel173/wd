<? if (!isset($_SESSION['user']) and !isset($_COOKIE['key'])): ?>
    <div class="card card-login">
        <div class="card-login-splash hide-on-small-only" style="background-image: url('../workout/img/maxresdefault.jpg')";>
            <div class="wrapper center-align">
                <!--<h3>Аккаунт</h3>-->
                <a class="btn-large waves-effect waves-light" href="/personal/login">Войти</a>
            </div>

        </div>
        <div class="card-content">
            <span class="card-title">Зарегистрироваться</span>
            <form action="/personal/reg" method="post">
                <div class="input-field">
                    <input id="login" class="validate" type="text" name="login" minlength="4"
                           value="<?= isset($_SESSION['form_data']['login']) ? h($_SESSION['form_data']['login']) : ''; ?>">
                    <label for="login" class="">Никнейм*</label>
                    <?= isset($_SESSION['form_data']['errors']['login']) ? $_SESSION['form_data']['errors']['login'] : ''; ?>
                </div>
                <div class="input-field">
                    <input id="email" class="validate" type="email" name="email"
                           value="<?= isset($_SESSION['form_data']['email']) ? h($_SESSION['form_data']['email']) : ''; ?>">
                    <label for="email" class="">E-mail*</label>
                    <?= isset($_SESSION['form_data']['errors']['email']) ? $_SESSION['form_data']['errors']['email'] : ''; ?>
                </div>
                <div class="input-field">
                    <input id="password" class="validate" type="password" name="password">
                    <label for="password">Пароль*</label>
                    <?= isset($_SESSION['form_data']['errors']['password']) ? $_SESSION['form_data']['errors']['password'] : ''; ?>

                </div>
                <div class="input-field">
                    <input id="password_repeat" class="validate" type="password" name="password_repeat">
                    <label for="password_repeat">Повторить пароль*</label>
                    <?= isset($_SESSION['form_data']['errors']['password_repeat']) ? $_SESSION['form_data']['errors']['password_repeat'] : ''; ?>
                </div>

                <label>
                    <input type="checkbox" class="filled-in" name="remember">
                    <span>Запомнить меня</span>
                </label>
                <br><br>

                <div class="container">
                    <div class="row center">
                        <div class="col s4 16">
                            <a href="/personal/reg?auth=vk" class="waves-effect waves-light">
                                <img src="https://png.icons8.com/color/50/000000/vk-com.png">
                            </a>
                        </div>
                        <div class="col s4 16">
                            <a href="/personal/reg?auth=fb" class="waves-effect waves-light">
                                <img src="https://png.icons8.com/color/50/000000/facebook.png">
                            </a>
                        </div>
                        <div class="col s4 16">
                            <a href="/personal/reg?auth=tw" class="waves-effect waves-light">
                                <img src="https://png.icons8.com/color/50/000000/twitter.png">
                            </a>
                        </div>
                    </div>
                </div>
                <?= isset($_SESSION['form_data']['errors']['social']) ? $_SESSION['form_data']['errors']['social'] : ''; ?>
                <div class="input-field">
                    <div class="g-recaptcha" style="transform: translateX(-28px) scale(0.9);"
                         data-sitekey="6Ld0mHYUAAAAAI5QdaIWmP2JVpAOjob47ABK8xjr"></div>
                </div>
                <?= isset($_SESSION['form_data']['errors']['recaptcha']) ? $_SESSION['form_data']['errors']['recaptcha'] : ''; ?>

                <div>
                    <button class="btn-large right waves-effect waves-light" type="submit" name="action">
                        Зарегистрироваться
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
