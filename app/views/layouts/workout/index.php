<? include("header.php"); ?>
<main class="valign-wrapper">
    <div class="container">
        <div class="section">
            <?php if (isset($_SESSION['error'])): ?>
                <div class="red-text">
                    <?= $_SESSION['error'];
                    unset($_SESSION['error']) ?>
                </div>
            <?php endif; ?>
            <?php if (isset($_SESSION['success'])): ?>
                <div class="green-text">
                    <?= $_SESSION['success'];
                    unset($_SESSION['success']) ?>
                </div>
            <?php endif; ?>
            <?= $content ?>
        </div>
    </div>
</main>
<? include("footer.php"); ?>
