<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $middleChapter->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $middleChapter->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Middle Chapters'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Big Chapters'), ['controller' => 'BigChapters', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Big Chapter'), ['controller' => 'BigChapters', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Small Chapters'), ['controller' => 'SmallChapters', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Small Chapter'), ['controller' => 'SmallChapters', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="middleChapters form large-9 medium-8 columns content">
    <?= $this->Form->create($middleChapter) ?>
    <fieldset>
        <legend><?= __('Edit Middle Chapter') ?></legend>
        <?php
            echo $this->Form->input('big_chapter_id', ['options' => $bigChapters]);
            echo $this->Form->input('title');
            echo $this->Form->input('display_order');
            echo $this->Form->input('select_flg');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
