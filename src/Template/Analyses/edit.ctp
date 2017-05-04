<?php
/**
  * @var \App\View\AppView $this
  */
?>
<div class="analyses form content">
    <?= $this->Form->create($analysis) ?>
    <fieldset>
        <legend><?= __('Edit Analysis') ?></legend>
        <?php
            echo $this->Form->input('user_id', ['options' => $users]);
            echo $this->Form->input('source_code_id', ['options' => $sourceCodes]);
            echo $this->Form->input('status_id', ['options' => $statuses]);
            echo $this->Form->input('content');
            echo $this->Form->input('display_order');
            echo $this->Form->input('select_flg');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
