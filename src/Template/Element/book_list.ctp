<?php foreach ($books as $book): ?>
    <tr class="item_box<?= $this->Class->books_tr_class($book->status->id) ?>" data-rank="<?= $book->display_order ?>" data-book-id="<?= $book->id ?>">
        <td><?= $this->Books->book_or_site($book->url,$book->title) ?></td>
        <td class="<?= $this->Class->books_td_class($book->status->id) ?>">
            <?= h($book->status->title) ?>
        </td>
        <td><?= h($book->laps > 1 ? $book->laps : '') ?></td>
        <td><?= h($book->created->format('Y年m月d日H:i')) ?></td>
        <td class="actions">
            <?= $this->Html->link(__('View'), ['action' => 'view', $book->id]) ?>
            <?= $this->Html->link(__('Edit'), ['action' => 'edit', $book->id]) ?>
            <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $book->id], ['confirm' => __('Are you sure you want to delete # {0}?', $book->id)]) ?>
        </td>
    </tr>
<?php endforeach; ?>
