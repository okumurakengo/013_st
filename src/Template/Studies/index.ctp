<?php
/**
  * @var \App\View\AppView $this
  */
$parser = new \cebe\markdown\MarkdownExtra();
?>
<div class="studies index content">
    <?= $this->Form->create('',['id' => 'search']) ?>
    <fieldset>
        <legend><?= __('検索') ?></legend>
        <div class="row">
            <div class="medium-2 columns">技術書名</div>
            <div class="medium-10 columns"><?= $this->Form->select('books', $selectBooks, [$searchBooks, 'id'=>'books']) ?></div>
        </div>
    </fieldset>
    <?= $this->Form->end() ?>
    <p class="add_button">
        <?= $this->Html->link('追加', ['action' => 'add'], ['id'=>'focus','class'=>'button small radius']) ?>
    </p>
    <h3><?= __('Studies') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <colgroup>
            <col width="5">
            <col width="60">
            <col width="15">
            <col width="5">
            <col width="15">
        </colgroup>
        <thead>
            <tr>
                <th scope="col"></th>
                <th scope="col"></th>
                <th scope="col"></th>
                <th scope="col"></th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($studies as $study): ?>
                <?php
                $tr_class = '';
                if($study->status->id === 4){
                    $tr_class = 'non_target';
                }
                ?>
            <tr class="<?= $tr_class ?>">
                <td rowspan="3"><?= $study->id ?></td>
                <td colspan="4">
                    <?= $study->has('small_chapter') ?
                        $this->Html->link(
                            $study->small_chapter->middle_chapter->big_chapter->display_order.'. '.$study->small_chapter->middle_chapter->big_chapter->title,
                            ['controller' => 'BigChapters', 'action' => 'view', $study->small_chapter->middle_chapter->big_chapter->id]
                        ) : '' ?>
                    &nbsp;>&nbsp;
                    <?= $study->has('small_chapter') ?
                        $this->Html->link(
                            $study->small_chapter->middle_chapter->display_order.'. '.$study->small_chapter->middle_chapter->title,
                            ['controller' => 'MiddleChapters', 'action' => 'view', $study->small_chapter->middle_chapter->id]
                        ) : '' ?>
                    &nbsp;>&nbsp;
                    <?= $study->has('small_chapter') ?
                        $this->Html->link(
                            $study->small_chapter->display_order.'. '.$study->small_chapter->title, ['controller' => 'SmallChapters', 'action' => 'view', $study->small_chapter->id]
                        ) : '' ?>
                </td>
            </tr>
            <tr class="<?= $tr_class ?>">
                <td class="study_content" colspan="4">
                    <pre><?= $parser->parse($study->content)?></pre>
                </td>
            </tr>
            <tr class="<?= $tr_class ?>">
                <td>
                    <?= $study->has('status') ? $this->Html->link($study->status->title, ['controller' => 'Statuses', 'action' => 'view', $study->status->id]) : '' ?>
                </td>
                <td><?= h($study->created->format('Y年m月d日H:i')) ?></td>
                <td><?= h($study->laps > 1 ? $study->laps.'週目' : '') ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $study->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $study->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $study->id], ['confirm' => __('Are you sure you want to delete # {0}?', $study->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></p>
    </div>
</div>
<script>

    var books = document.getElementById('books');
    var target = document.getElementById('search');
    books.onchange = function(){

        target.method = "post";
        target.submit();

    }

</script>
