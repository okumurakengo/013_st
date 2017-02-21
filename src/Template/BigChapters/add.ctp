<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Big Chapters'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Books'), ['controller' => 'Books', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Book'), ['controller' => 'Books', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Middle Chapters'), ['controller' => 'MiddleChapters', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Middle Chapter'), ['controller' => 'MiddleChapters', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="bigChapters form large-9 medium-8 columns content">
    <?= $this->Form->create($bigChapter) ?>
    <fieldset>
        <legend><?= __('Add Big Chapter') ?></legend>
        <?php
            echo $this->Form->input('book_id', ['options' => $books]);
            echo $this->Form->input('title');
            echo $this->Form->input('display_order');
            echo $this->Form->input('select_flg');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
