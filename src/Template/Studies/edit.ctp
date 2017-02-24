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
                ['action' => 'delete', $study->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $study->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Studies'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Small Chapters'), ['controller' => 'SmallChapters', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Small Chapter'), ['controller' => 'SmallChapters', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Statuses'), ['controller' => 'Statuses', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Status'), ['controller' => 'Statuses', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="studies form large-9 medium-8 columns content">
    <?= $this->Form->create($study) ?>
    <fieldset>
        <legend><?= __('Edit Study') ?></legend>
        <?php
            echo $this->Form->input('user_id', ['options' => $users]);
            echo $this->Form->input('small_chapter_id', ['options' => $smallChapters]);
            echo $this->Form->input('status_id', ['options' => $statuses]);
            echo $this->Form->textarea('content', ['rows' => '10']);
            echo $this->Form->input('memo');
            echo $this->Form->input('display_order');
            echo $this->Form->input('select_flg');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
