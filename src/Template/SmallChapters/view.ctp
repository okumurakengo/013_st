<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Small Chapter'), ['action' => 'edit', $smallChapter->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Small Chapter'), ['action' => 'delete', $smallChapter->id], ['confirm' => __('Are you sure you want to delete # {0}?', $smallChapter->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Small Chapters'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Small Chapter'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Middle Chapters'), ['controller' => 'MiddleChapters', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Middle Chapter'), ['controller' => 'MiddleChapters', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Studies'), ['controller' => 'Studies', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Study'), ['controller' => 'Studies', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="smallChapters view large-9 medium-8 columns content">
    <h3><?= h($smallChapter->title) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Middle Chapter') ?></th>
            <td><?= $smallChapter->has('middle_chapter') ? $this->Html->link($smallChapter->middle_chapter->title, ['controller' => 'MiddleChapters', 'action' => 'view', $smallChapter->middle_chapter->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Title') ?></th>
            <td><?= h($smallChapter->title) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($smallChapter->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Display Order') ?></th>
            <td><?= $this->Number->format($smallChapter->display_order) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($smallChapter->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($smallChapter->modified) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Select Flg') ?></th>
            <td><?= $smallChapter->select_flg ? __('Yes') : __('No'); ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Studies') ?></h4>
        <?php if (!empty($smallChapter->studies)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('User Id') ?></th>
                <th scope="col"><?= __('Small Chapter Id') ?></th>
                <th scope="col"><?= __('Content') ?></th>
                <th scope="col"><?= __('Memo') ?></th>
                <th scope="col"><?= __('Display Order') ?></th>
                <th scope="col"><?= __('Select Flg') ?></th>
                <th scope="col"><?= __('Created') ?></th>
                <th scope="col"><?= __('Modified') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($smallChapter->studies as $studies): ?>
            <tr>
                <td><?= h($studies->id) ?></td>
                <td><?= h($studies->user_id) ?></td>
                <td><?= h($studies->small_chapter_id) ?></td>
                <td><?= h($studies->content) ?></td>
                <td><?= h($studies->memo) ?></td>
                <td><?= h($studies->display_order) ?></td>
                <td><?= h($studies->select_flg) ?></td>
                <td><?= h($studies->created) ?></td>
                <td><?= h($studies->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Studies', 'action' => 'view', $studies->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Studies', 'action' => 'edit', $studies->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Studies', 'action' => 'delete', $studies->id], ['confirm' => __('Are you sure you want to delete # {0}?', $studies->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
