<?php
/**
  * @var \App\View\AppView $this
  */
?>
<div class="books form content">
    <?= $this->Form->create($book) ?>
    <fieldset>
        <legend><?= __('Add Book') ?></legend>
        <?php
            echo $this->Form->input('title',['id'=>'focus']);
            echo $this->Form->input('url',['maxlength' => 150]);
            echo $this->Form->select('display_order',$select_display_order);
            echo $this->Form->hidden('laps',['value'=>1]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
