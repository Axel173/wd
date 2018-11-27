<? if (!isset($_SESSION['user']) and !isset($_COOKIE['key'])): ?>
    <div class="card card-login">
        <!--<div class="card-login-splash hide-on-small-only">
            <div class="wrapper center-align">
                <!--<h3>Аккаунт</h3>-->
        <!--<a class="btn-large waves-effect waves-light" href="/personal/login">Авторизация</a>
    </div>
</div>-->
        <div class="card-content">
            <span class="card-title">Зарегистрироваться</span>
            <form action="/personal/reg" method="post">
                <!--<div class="input-field">
                    <input id="login" class="validate" type="text" name="login"
                           value="<? /*= isset($_SESSION['form_data']['login']) ? h($_SESSION['form_data']['login']) : ''; */ ?>">
                    <label for="login" class="">Логин</label>
                </div>-->
                <div class="input-field">
                    <input id="email" class="validate" type="text" name="email"
                           value="<?= isset($_SESSION['form_data']['email']) ? h($_SESSION['form_data']['email']) : ''; ?>">
                    <label for="email" class="">E-mail*</label>
                </div>
                <div class="input-field">
                    <input id="name" class="validate" type="text" name="name"
                           value="<?= isset($_SESSION['form_data']['name']) ? h($_SESSION['form_data']['name']) : ''; ?>">
                    <label for="name" class="">Имя*</label>
                </div>
                <div class="input-field">
                    <input id="surname" class="validate" type="text" name="surname"
                           value="<?= isset($_SESSION['form_data']['surname']) ? h($_SESSION['form_data']['surname']) : ''; ?>">
                    <label for="surname" class="">Фамилия</label>
                </div>
                <div class="input-field">
                    <input id="birthday" class="datepicker" type="text" name="birthday"
                           value="<?= isset($_SESSION['form_data']['birthday']) ? h($_SESSION['form_data']['birthday']) : ''; ?>">
                    <label for="birthday" class="">Дата рождения</label>
                </div>
                <div class="input-field">
                    <input id="password" class="validate" type="password" name="password">
                    <label for="password">Пароль*</label>
                </div>
                <div class="input-field">
                    <input id="password_repeat" class="validate" type="password" name="password_repeat">
                    <label for="password_repeat">Повторить пароль*</label>
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
                <div class="input-field">
                    <div class="g-recaptcha" style="transform: translateX(-28px) scale(0.9);"
                         data-sitekey="6Ld0mHYUAAAAAI5QdaIWmP2JVpAOjob47ABK8xjr"></div>
                </div>
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
