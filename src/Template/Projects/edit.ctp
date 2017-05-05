<?php
/**
  * @var \App\View\AppView $this
  */
?>
<div class="projects form content">
    <?= $this->Form->create($project) ?>
    <fieldset>
        <legend><?= __('Edit Project') ?></legend>
        <div class="row">
            <div class="medium-12 columns"><?= $this->Form->input('title') ?></div>
            <div class="medium-12 columns"><?= $this->Form->input('url') ?></div>
            <div class="medium-6 columns"><?= $this->Form->select('display_order',$select_display_order) ?></div>
            <div class="medium-6 columns"><?= $this->Form->select('status_id' ,$select_status) ?></div>
        </div>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
