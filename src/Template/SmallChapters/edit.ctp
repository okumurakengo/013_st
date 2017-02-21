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
                ['action' => 'delete', $smallChapter->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $smallChapter->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Small Chapters'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Middle Chapters'), ['controller' => 'MiddleChapters', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Middle Chapter'), ['controller' => 'MiddleChapters', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Studies'), ['controller' => 'Studies', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Study'), ['controller' => 'Studies', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="smallChapters form large-9 medium-8 columns content">
    <?= $this->Form->create($smallChapter) ?>
    <fieldset>
        <legend><?= __('Edit Small Chapter') ?></legend>
        <?php
            echo $this->Form->input('middle_chapter_id', ['options' => $middleChapters]);
            echo $this->Form->input('title');
            echo $this->Form->input('display_order');
            echo $this->Form->input('select_flg');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
