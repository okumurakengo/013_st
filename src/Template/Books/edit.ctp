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
                ['action' => 'delete', $book->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $book->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Books'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Big Chapters'), ['controller' => 'BigChapters', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Big Chapter'), ['controller' => 'BigChapters', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="books form large-9 medium-8 columns content">
    <?= $this->Form->create($book) ?>
    <fieldset>
        <legend><?= __('Edit Book') ?></legend>
        <div class="row">
            <div class="medium-12 columns"><?= $this->Form->input('title') ?></div>
            <div class="medium-12 columns"><?= $this->Form->input('url') ?></div>
            <div class="medium-12 columns"><?= $this->Form->select('display_order',$select_display_order) ?></div>
            <div class="medium-6 columns"><?= $this->Form->select('status_id' ,$select_status) ?></div>
            <div class="medium-6 columns"><?= $this->Form->number('laps') ?></div>
        </div>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
