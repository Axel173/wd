<? require("header.php"); ?>

<div class="content">
    <div class="container">

        <div class="content-grids">
            <div class="col-md-8 content-main">
                <div class="content-grid">

                    <?php if (isset($_SESSION['error'])): ?>
                        <div class="alert alert-danger">
                            <?= $_SESSION['error'];
                            unset($_SESSION['error']) ?>
                        </div>
                    <?php endif; ?>

                    <?php if (isset($_SESSION['success'])): ?>
                        <div class="alert alert-success">
                            <?= $_SESSION['success'];
                            unset($_SESSION['success']) ?>
                        </div>
                    <?php endif; ?>

                    <?= $content; ?>
                </div>
            </div>
            <div class="col-md-4 content-right">
                <?php $this->getPart('inc/sidebar'); ?>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
</div>

<? require("footer.php"); ?>