<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://fonts.googleapis.com/css?family=Cormorant+Garamond" rel="stylesheet">
        <?= $view->render('head') ?>
        <?php $view->style('custom-uikit', 'theme:css/uikit.css') ?>
        <?php $view->style('theme', 'theme:css/theme.css') ?>
        <?php $view->script('theme', 'theme:js/theme.js') ?>

    </head>
    <body class="uk-light">

         <div class="uk-offcanvas-content">
        <!-- Render logo or title with site URL -->


        <nav class="uk-navbar uk-navbar-container">
            <!-- Render menu position -->
            <?php if ($view->menu()->exists('main')) : ?>
                <div class="uk-navbar-right">
                    <?= $view->menu('main', 'menu-navbar.php') ?>
                </div>
            <?php endif ?>
        </nav>

        <!-- Render widget position -->
        <?php if ($view->position()->exists('sidebar')) : ?>
            <?= $view->position('sidebar') ?>
        <?php endif; ?>

        <!-- Render content -->
        <div class="uk-width-expand">
        <div class="uk-background-cover uk-height-viewport " style="background-image: url('/pagekitVaedervax/storage/horseBG.jpeg');">
            <?= $view->render('content') ?>
        </div>
        </div>

        <!-- footer -->
        <?php if ($view->position()->exists('footer')) : ?>
            <div class="footer uk-grid">
                <div class="uk-width-1-6">
                    <?= $view->position('footerContact') ?>
                </div>
                <div class="uk-width-1-6">
                    <?= $view->position('footerService') ?>
                </div>
                <div class="uk-width-1-6">
                    <?= $view->position('footerInformation') ?>
                </div>
                <div class="uk-width-1-2 uk-text-center">
                        <?= $view->position('footerSocial') ?>
                </div>

            </div>
        <?php endif; ?>
        <!-- Insert code before the closing body tag  -->

        <!-- render footer -->
        <?= $view->render('footer') ?>
        </div>
    </body>
</html>
