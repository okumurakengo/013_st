<?php foreach ($books as $book): ?>
    <tr class="item_box" data-rank="<?= $book->display_order ?>" data-book-id="<?= $book->id ?>">
        <td>
            <?php if($book->url !== ''): ?>
                <a href="<?= h($book->url) ?>" target="_blank"><?= h($book->title) ?></a>
            <?php else: ?>
                <?= h($book->title) ?>
            <?php endif; ?>
        </td>
        <td><?= h($book->created->format('Y年m月d日H:i')) ?></td>
        <td><?= h($book->modified->format('Y年m月d日H:i')) ?></td>
        <td class="actions">
            <?= $this->Html->link(__('View'), ['action' => 'view', $book->id]) ?>
            <?= $this->Html->link(__('Edit'), ['action' => 'edit', $book->id]) ?>
            <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $book->id], ['confirm' => __('Are you sure you want to delete # {0}?', $book->id)]) ?>
        </td>
    </tr>
<?php endforeach; ?>
