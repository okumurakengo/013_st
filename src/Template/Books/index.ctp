<?php
/**
  * @var \App\View\AppView $this
  */
?>
<div class="books index content">
    <p class="add_button">
        <?= $this->Html->link('追加', ['action' => 'add'], ['id'=>'focus','class'=>'button small radius']) ?>
    </p>
    <h3><?= __('Books') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <colgroup>
            <col width="50">
            <col width="7">
            <col width="5">
            <col width="8">
            <col width="15">
            <col width="15">
        </colgroup>
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('title') ?></th>
                <th scope="col"><?= $this->Paginator->sort('status_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('laps') ?></th>
                <th scope="col">count</th>
                <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody class="tableish">
            <?= $this->element('book_list') ?>
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
    $(function() {
        var oldRanks = [];
        // 画面の中のrank一覧を保持
        $("table .item_box").each(function () {
            oldRanks.push(this.dataset.rank);
        });

        $(".tableish").sortable({
            items: '> .item_box',
            cursor: '-webkit-grabbing',
            stop: function(event, ui){
                $("body").append($('<div class="modal-backdrop in"></div>'));
                var book_id = ui.item.data('book-id');
                var src_display_order = ui.item.data('rank');
                var display_order;
                $("table .item_box").each(function () {
                    if ($(this).data('rank') === src_display_order) {
                        display_order = $("table .item_box").index(this) + 1;
                    };
                });
                updateRank(book_id,src_display_order,display_order);
            },
        });

        var updateRank = function(book_id,src_display_order,display_order) {

            $.ajax({
                url: '<?= $this->Url->build(['controller'=>'Books', 'action'=>'ajax']); ?>',
                type: 'POST',
                data: {
                    book_id           : book_id,
                    src_display_order : src_display_order,
                    display_order     : display_order
                },
            }).done(function(data) {
                $('.tableish').empty().html(data);
                $(".modal-backdrop").remove();
            }).fail(function() {
                console.log('fail');
                $(".modal-backdrop").remove();
            });
        };

    });
</script>
