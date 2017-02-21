<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Middle Chapter'), ['action' => 'edit', $middleChapter->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Middle Chapter'), ['action' => 'delete', $middleChapter->id], ['confirm' => __('Are you sure you want to delete # {0}?', $middleChapter->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Middle Chapters'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Middle Chapter'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Big Chapters'), ['controller' => 'BigChapters', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Big Chapter'), ['controller' => 'BigChapters', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Small Chapters'), ['controller' => 'SmallChapters', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Small Chapter'), ['controller' => 'SmallChapters', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="middleChapters view large-9 medium-8 columns content">
    <h3><?= h($middleChapter->title) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Big Chapter') ?></th>
            <td><?= $middleChapter->has('big_chapter') ? $this->Html->link($middleChapter->big_chapter->title, ['controller' => 'BigChapters', 'action' => 'view', $middleChapter->big_chapter->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Title') ?></th>
            <td><?= h($middleChapter->title) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($middleChapter->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Display Order') ?></th>
            <td><?= $this->Number->format($middleChapter->display_order) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($middleChapter->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($middleChapter->modified) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Select Flg') ?></th>
            <td><?= $middleChapter->select_flg ? __('Yes') : __('No'); ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Small Chapters') ?></h4>
        <?php if (!empty($middleChapter->small_chapters)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Middle Chapter Id') ?></th>
                <th scope="col"><?= __('Title') ?></th>
                <th scope="col"><?= __('Display Order') ?></th>
                <th scope="col"><?= __('Select Flg') ?></th>
                <th scope="col"><?= __('Created') ?></th>
                <th scope="col"><?= __('Modified') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($middleChapter->small_chapters as $smallChapters): ?>
            <tr>
                <td><?= h($smallChapters->id) ?></td>
                <td><?= h($smallChapters->middle_chapter_id) ?></td>
                <td><?= h($smallChapters->title) ?></td>
                <td><?= h($smallChapters->display_order) ?></td>
                <td><?= h($smallChapters->select_flg) ?></td>
                <td><?= h($smallChapters->created) ?></td>
                <td><?= h($smallChapters->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'SmallChapters', 'action' => 'view', $smallChapters->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'SmallChapters', 'action' => 'edit', $smallChapters->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'SmallChapters', 'action' => 'delete', $smallChapters->id], ['confirm' => __('Are you sure you want to delete # {0}?', $smallChapters->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
