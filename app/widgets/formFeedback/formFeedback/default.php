<form action="<?=$this->action?>" method="<?=$this->method?>">
    <?foreach ($fields as $key => $field):?>

    <?endforeach;?>
</form>
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
    <?= isset($_SESSION['form_data']['errors']['not_found']) ? $_SESSION['form_data']['errors']['not_found'] : ''; ?>
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
    <?= isset($_SESSION['form_data']['errors']['social']) ? $_SESSION['form_data']['errors']['social'] : ''; ?>
    <? if (isset($_SESSION['auth']['count']) and $_SESSION['auth']['count'] > 5): ?>
        <div class="input-field">
            <div class="g-recaptcha" style="transform: translateX(-28px) scale(0.9);"
                 data-sitekey="6Ld0mHYUAAAAAI5QdaIWmP2JVpAOjob47ABK8xjr"></div>
        </div>
    <? endif; ?>
    <div>
        <a href="/personal/restoration">Забыли пароль?</a>
        <button class="btn-large right waves-effect waves-light" type="submit" name="action">Войти
        </button>
    </div>
    <br>
    <?php if (isset($_SESSION['form_data'])) unset($_SESSION['form_data']) ?>
</form>