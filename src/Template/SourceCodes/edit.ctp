<?php
/**
  * @var \App\View\AppView $this
  */
?>
<div class="sourceCodes form content">
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
