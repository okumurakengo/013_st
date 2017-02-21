<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Big Chapter'), ['action' => 'edit', $bigChapter->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Big Chapter'), ['action' => 'delete', $bigChapter->id], ['confirm' => __('Are you sure you want to delete # {0}?', $bigChapter->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Big Chapters'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Big Chapter'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Books'), ['controller' => 'Books', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Book'), ['controller' => 'Books', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Middle Chapters'), ['controller' => 'MiddleChapters', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Middle Chapter'), ['controller' => 'MiddleChapters', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="bigChapters view large-9 medium-8 columns content">
    <h3><?= h($bigChapter->title) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Book') ?></th>
            <td><?= $bigChapter->has('book') ? $this->Html->link($bigChapter->book->title, ['controller' => 'Books', 'action' => 'view', $bigChapter->book->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Title') ?></th>
            <td><?= h($bigChapter->title) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($bigChapter->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Display Order') ?></th>
            <td><?= $this->Number->format($bigChapter->display_order) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($bigChapter->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($bigChapter->modified) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Select Flg') ?></th>
            <td><?= $bigChapter->select_flg ? __('Yes') : __('No'); ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Middle Chapters') ?></h4>
        <?php if (!empty($bigChapter->middle_chapters)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Big Chapter Id') ?></th>
                <th scope="col"><?= __('Title') ?></th>
                <th scope="col"><?= __('Display Order') ?></th>
                <th scope="col"><?= __('Select Flg') ?></th>
                <th scope="col"><?= __('Created') ?></th>
                <th scope="col"><?= __('Modified') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($bigChapter->middle_chapters as $middleChapters): ?>
            <tr>
                <td><?= h($middleChapters->id) ?></td>
                <td><?= h($middleChapters->big_chapter_id) ?></td>
                <td><?= h($middleChapters->title) ?></td>
                <td><?= h($middleChapters->display_order) ?></td>
                <td><?= h($middleChapters->select_flg) ?></td>
                <td><?= h($middleChapters->created) ?></td>
                <td><?= h($middleChapters->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'MiddleChapters', 'action' => 'view', $middleChapters->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'MiddleChapters', 'action' => 'edit', $middleChapters->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'MiddleChapters', 'action' => 'delete', $middleChapters->id], ['confirm' => __('Are you sure you want to delete # {0}?', $middleChapters->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
