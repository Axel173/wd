<? if (!isset($_SESSION['user']) and !isset($_COOKIE['key'])): ?>
    <div class="card card-login">
        <div class="card-login-splash hide-on-small-only">
            <div class="wrapper center-align">
                <!--<h3>Аккаунт</h3>-->
                <a class="btn-large waves-effect waves-light" href="/personal/reg">Регистрация</a>
            </div>

        </div>
        <div class="card-content">
            <span class="card-title">Войти</span>
            <form action="/personal/login" method="post">
                <div class="input-field">
                    <input id="email" class="validate" type="text" name="email">
                    <label for="email" class="">E-mail*</label>
                </div>
                <div class="input-field">
                    <input id="password" class="validate" type="password" name="password">
                    <label for="password">Пароль*</label>
                </div>

                <label>
                    <input type="checkbox" class="filled-in" name="remember">
                    <span>Запомнить меня</span>
                </label>
                <br><br>

                <div class="container">
                    <div class="row center">
                        <div class="col s4 16">
                            <a href="/personal/login?auth=vk" class="waves-effect waves-light">
                                <img src="https://png.icons8.com/color/50/000000/vk-com.png">
                            </a>
                        </div>
                        <div class="col s4 16">
                            <a href="/personal/login?auth=fb" class="waves-effect waves-light">
                                <img src="https://png.icons8.com/color/50/000000/facebook.png">
                            </a>
                        </div>
                        <div class="col s4 16">
                            <a href="/personal/login?auth=tw" class="waves-effect waves-light">
                                <img src="https://png.icons8.com/color/50/000000/twitter.png">
                            </a>
                        </div>
                    </div>
                </div>
                <?if(isset($_SESSION['auth']['count']) and $_SESSION['auth']['count'] > 5):?>
                    <div class="input-field">
                        <div class="g-recaptcha" style="transform: translateX(-28px) scale(0.9);"
                             data-sitekey="6Ld0mHYUAAAAAI5QdaIWmP2JVpAOjob47ABK8xjr"></div>
                    </div>
                <?endif;?>
                <div>
                    <a href="#!">Забыли пароль?</a>
                    <button class="btn-large right waves-effect waves-light" type="submit" name="action">Войти
                    </button>
                </div>
                <br>

            </form>
        </div>
    </div>

    <?
    if (isset($_SESSION['vk_user'])) {
        $user = $_SESSION['vk_user'];
        debug($user);
        unset($_SESSION['vk_user']);
    }
    ?>


<? else: ?>
    вы уже авторизованы
<? endif; ?>
