<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Book'), ['action' => 'edit', $book->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Book'), ['action' => 'delete', $book->id], ['confirm' => __('Are you sure you want to delete # {0}?', $book->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Books'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Book'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Big Chapters'), ['controller' => 'BigChapters', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Big Chapter'), ['controller' => 'BigChapters', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="books view large-9 medium-8 columns content">
    <h3><?= h($book->title) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Title') ?></th>
            <td><?= h($book->title) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($book->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Display Order') ?></th>
            <td><?= $this->Number->format($book->display_order) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($book->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($book->modified) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Select Flg') ?></th>
            <td><?= $book->select_flg ? __('Yes') : __('No'); ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Big Chapters') ?></h4>
        <?php if (!empty($book->big_chapters)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Book Id') ?></th>
                <th scope="col"><?= __('Title') ?></th>
                <th scope="col"><?= __('Display Order') ?></th>
                <th scope="col"><?= __('Select Flg') ?></th>
                <th scope="col"><?= __('Created') ?></th>
                <th scope="col"><?= __('Modified') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($book->big_chapters as $bigChapters): ?>
            <tr>
                <td><?= h($bigChapters->id) ?></td>
                <td><?= h($bigChapters->book_id) ?></td>
                <td><?= h($bigChapters->title) ?></td>
                <td><?= h($bigChapters->display_order) ?></td>
                <td><?= h($bigChapters->select_flg) ?></td>
                <td><?= h($bigChapters->created) ?></td>
                <td><?= h($bigChapters->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'BigChapters', 'action' => 'view', $bigChapters->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'BigChapters', 'action' => 'edit', $bigChapters->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'BigChapters', 'action' => 'delete', $bigChapters->id], ['confirm' => __('Are you sure you want to delete # {0}?', $bigChapters->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
