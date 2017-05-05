<?php
/**
  * @var \App\View\AppView $this
  */
?>
<div class="projects form content">
    <?= $this->Form->create($project) ?>
    <fieldset>
        <legend><?= __('Add Project') ?></legend>
        <?php
            echo $this->Form->input('title');
            echo $this->Form->input('url');
            echo $this->Form->input('display_order');
            echo $this->Form->input('status_id', ['options' => $statuses]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
