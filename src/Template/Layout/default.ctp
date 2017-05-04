<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @since         0.10.0
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

$cakeDescription = 'CakePHP: the rapid development php framework';
?>
<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?= $cakeDescription ?>:
        <?= $this->fetch('title') ?>
    </title>
    <?= $this->Html->meta('icon') ?>

    <?= $this->Html->css('base.css') ?>
    <?= $this->Html->css('cake.css') ?>
    <?= $this->Html->css('style.css') ?>

    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

    <?= $this->Html->script('script.js') ?>
    <?= file_exists('js/' . $script = strtolower($this->request->params['controller']) . '.js') ? $this->Html->script($script) : '' ?>

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
</head>
<body>
    <nav class="top-bar expanded" data-topbar role="navigation">
        <ul class="title-area large-3 medium-4 columns">
            <li class="name">
                <h1><a href=""><?= $this->fetch('title') ?></a></h1>
            </li>
        </ul>
        <div class="top-bar-section">
            <ul class="right">
                <ul>
                    <li><?= $this->Html->link('技術書一覧', ['controller' => 'Books', 'action' => 'index']) ?></li>
                    <li><?= $this->Html->link('大分類一覧', ['controller' => 'BigChapters', 'action' => 'index']) ?></li>
                    <li><?= $this->Html->link('中分類一覧', ['controller' => 'MiddleChapters', 'action' => 'index']) ?></li>
                    <li><?= $this->Html->link('小分類一覧', ['controller' => 'SmallChapters', 'action' => 'index']) ?></li>
                </ul>
                <ul>
                    <li><?= $this->Html->link('勉強結果一覧', ['controller' => 'Studies', 'action' => 'index']) ?></li>
                    <li><?= $this->Html->link('解析対象一覧', ['controller' => 'Projects', 'action' => 'index']) ?></li>
                    <li><?= $this->Html->link('フォルダ構成', ['controller' => 'SourceCodes', 'action' => 'index']) ?></li>
                    <li><?= $this->Html->link('解析結果一覧', ['controller' => 'Analyses', 'action' => 'index']) ?></li>
                </ul>
                <li><?= $this->Html->link('グラフ', ['controller' => 'Studies', 'action' => 'graph']) ?></li>
            </ul>
        </div>
    </nav>
    <?= $this->Flash->render() ?>
    <div class="container clearfix">
        <?= $this->fetch('content') ?>
    </div>
    <footer>
    </footer>
</body>
</html>
