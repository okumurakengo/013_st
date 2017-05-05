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
            echo $this->Form->select('display_order',$select_display_order);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
