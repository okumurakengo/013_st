<?php
/**
  * @var \App\View\AppView $this
  */
?>
<div class="studies form content">
    <?= $this->Form->create('',['id' => 'search']) ?>
    <fieldset>
        <legend><?= __('検索') ?></legend>
        <div class="row">
            <div class="medium-2 columns">技術書名</div>
            <div class="medium-10 columns"><?= $this->Form->select('books', $selectBooks, [$searchBooks, 'id'=>'books']) ?></div>
            <div class="medium-2 columns">大分類</div>
            <div class="medium-10 columns"><?= $this->Form->select('big_chapters', $selectBigChapters, ['id'=>'big_chapters', 'default'=>$searchBigChapters]) ?></div>
        </div>
        <input type="hidden" id="big_chapters_flg" name="big_chapters_flg" value="0">
        <?=$this->Form->hidden('search' ,['value'=> 'search' ]) ?>
    </fieldset>
    <?= $this->Form->end() ?>
    <?= $this->Form->create($study) ?>
    <fieldset>
        <legend><?= __('Add Study') ?></legend>
        <div class="row">
            <div class="medium-2 columns">
                <?= $this->Form->input('user_id', ['options' => $users]); ?>
            </div>
            <div class="medium-2 columns">
                ステータス<?= $this->Form->select('status_id', $statuses, ['default' => 5]); ?>
            </div>
            <div class="medium-8 columns end">
                小分類<?= $this->Form->select('small_chapter_id',$selectSmallChapters, ['id'=>'small_chapters', 'default'=>$searchSmallChapters]) ?>
            </div>
        </div>
        内容<?= $this->Form->textarea('content', ['rows' => '10']); ?>
        メモ<?= $this->Form->textarea('memo', ['rows' => '7']); ?>
        <?= $this->Form->input('display_order'); ?>
        <?= $this->Form->input('select_flg'); ?>
        <input type="hidden" name="books" value="<?= $searchBooks ?>">
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
<script>

    var books = document.getElementById('books');
    var big_chapters = document.getElementById('big_chapters');
    var target = document.getElementById('search');

    var big_chapters_flg = document.getElementById('big_chapters_flg');

    books.onchange = function(){
        change_submit();
    }
    big_chapters.onchange = function(){
        big_chapters_flg.value = "1";
        change_submit();
    }
    function change_submit() {

        target.method = "post";
        target.submit();

    }

</script>
