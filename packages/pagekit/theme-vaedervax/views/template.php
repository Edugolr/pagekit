<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no, target-densityDpi=device-dpi" />
        <link href="https://fonts.googleapis.com/css?family=Cormorant+Garamond" rel="stylesheet">
        <?= $view->render('head') ?>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/uikit/3.0.0-rc.19/js/uikit.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/uikit/3.0.0-rc.19/js/uikit-icons.min.js"></script>
        <?php $view->style('custom-uikit', 'theme:css/uikit.css') ?>
        <?php $view->style('theme', 'theme:css/theme.css') ?>
        <?php $view->script('theme', 'theme:js/theme.js', 'theme-uikit') ?>

    </head>
    <body class="container">
        <!-- Render logo or title with site URL -->
        <nav class="uk-flex uk-navbar uk-navbar-container uk-light">
            <button class="uk-button uk-button-default uk-hidden@s"  type="button" uk-toggle="target: #offcanvas-nav"><span class="uk-margin-small-right" uk-icon="menu"></span></button>
            <!-- Render menu position -->
            <?php if ($view->menu()->exists('main')) : ?>
                <div class="uk-navbar-right">
                    <?= $view->menu('main', 'menu-navbar.php') ?>
                </div>
            <?php endif ?>
        </nav>

        <!-- Render widget position -->
        <?php if ($view->position()->exists('hero')) : ?>
            <div class="uk-width-expand">
                <div class="uk-height-1-1 uk-flex uk-flex-center uk-flex-middle uk-background-cover uk-light" data-src="/pagekitVaedervax/storage/horseBG.jpeg" uk-img>                        <section class="uk-grid uk-grid-match" data-uk-grid-margin>
                           <?= $view->position('hero') ?>
                           <?= $view->render('content') ?>
                </div>
            </div>

        <?php else: ?>
            <div class="uk-width-expand uk-flex">
                <div class="uk-width-1-1 uk-height-viewport">
                    <?= $view->render('content') ?>
                </div>
            </div>
        <?php endif; ?>
        
        <!-- footer -->
        <?php if ($view->position()->exists('footer')) : ?>
            <div class="footer uk-grid uk-flex">
                <div class="uk-width-1-6@s">
                    <?= $view->position('footerContact') ?>
                </div>
                <div class="uk-width-1-6@s">
                    <?= $view->position('footerService') ?>
                </div>
                <div class="uk-width-1-6@s">
                    <?= $view->position('footerInformation') ?>
                </div>
                <div class="uk-width-1-2@s uk-text-center">
                        <?= $view->position('footerSocial') ?>
                </div>
            </div>
        <?php endif; ?>
        <!-- Insert code before the closing body tag  -->

        <!-- render footer -->
        <?= $view->render('footer') ?>
    </body>
</html>
