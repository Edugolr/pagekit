<?php $view->script('post', 'blog:app/bundle/post.js', 'vue') ?>

<div class=" uk-flex-center uk-text-center">
<article class="uk-margin-auto uk-card uk-card-default uk-card body uk-width-5-6">

    <?php if ($image = $post->get('image.src')): ?>
    <img src="<?= $image ?>" alt="<?= $post->get('image.alt') ?>">
    <?php endif ?>

    <h1 class="uk-article-title uk-link-heading"><?= $post->title ?></h1>

    <p class="uk-article-meta ">
        <?= __('Written by %name% on %date%', ['%name%' => $post->user->name, '%date%' => '<time datetime="'.$post->date->format(\DateTime::W3C).'" v-cloak>{{ "'.$post->date->format(\DateTime::W3C).'" | date "longDate" }}</time>' ]) ?>
    </p>

    <div class="uk-margin"><?= $post->content ?></div>

    <?= $view->render('blog/comments.php') ?>

</article>
</div>
