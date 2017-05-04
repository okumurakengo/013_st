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
                ['action' => 'delete', $sourceCode->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $sourceCode->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Source Codes'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Projects'), ['controller' => 'Projects', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Project'), ['controller' => 'Projects', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Source Codes'), ['controller' => 'SourceCodes', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Source Code'), ['controller' => 'SourceCodes', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Analyses'), ['controller' => 'Analyses', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Analysis'), ['controller' => 'Analyses', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="sourceCodes form large-9 medium-8 columns content">
    <?= $this->Form->create($sourceCode) ?>
    <fieldset>
        <legend><?= __('Edit Source Code') ?></legend>
        <?php
            echo $this->Form->input('project_id', ['options' => $projects]);
            echo $this->Form->input('source_code_id');
            echo $this->Form->input('directory_flg');
            echo $this->Form->input('name');
            echo $this->Form->input('code');
            echo $this->Form->input('display_order');
            echo $this->Form->input('select_flg');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
