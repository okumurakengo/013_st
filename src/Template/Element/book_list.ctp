<?php foreach ($books as $book): ?>
    <tr class="item_box <?= $this->Books->status_tr_class($book->status->id) ?>" data-rank="<?= $book->display_order ?>" data-book-id="<?= $book->id ?>">
        <td><?= $this->Books->site_judgment($book->url,$book->title) ?></td>
        <td class="<?= $this->Books->status_td_class($book->status->id) ?>">
            <?= h($book->status->title) ?>
        </td>
        <td><?= h($book->laps > 1 ? $book->laps : '') ?></td>
        <td class="text-right"><?= h($this->Books->book_count($book->StudiesCount['count']))?> / <?=h($this->Books->book_count($book->SmallCount['count']))?></td>
        <td class="text-right"><?= h($this->Books->percent($book->StudiesCount['count'],$book->SmallCount['count']))?>%</td>
        <td><?= h($this->Books->date_format($book->created)) ?></td>
        <td class="actions">
            <?= $this->Html->link(__('View'), ['action' => 'view', $book->id]) ?>
            <?= $this->Html->link(__('Edit'), ['action' => 'edit', $book->id]) ?>
            <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $book->id], ['confirm' => __('Are you sure you want to delete # {0}?', $book->id)]) ?>
        </td>
    </tr>
<?php endforeach; ?>
