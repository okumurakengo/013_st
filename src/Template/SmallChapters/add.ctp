<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Small Chapters'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Middle Chapters'), ['controller' => 'MiddleChapters', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Middle Chapter'), ['controller' => 'MiddleChapters', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Studies'), ['controller' => 'Studies', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Study'), ['controller' => 'Studies', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="smallChapters form large-9 medium-8 columns content">
    <?= $this->Form->create('',['id' => 'search']) ?>
    <fieldset>
        <legend><?= __('検索') ?></legend>
        <div class="row">
            <div class="medium-2 columns">技術書名</div>
            <div class="medium-10 columns"><?= $this->Form->select('books', $selectBooks, [$searchBooks, 'id'=>'books']) ?></div>
            <div class="medium-2 columns">中分類</div>
            <div class="medium-10 columns"><?= $this->Form->select('middle_chapter_id',$selectMiddleChapters, ['default' => [$searchMiddleChapters], 'id'=>'middle_chapters']) ?></div>
        </div>
        <?=$this->Form->hidden('search' ,['value'=> 'search' ]) ?>
    </fieldset>
    <?= $this->Form->end() ?>
    <?= $this->Form->create($smallChapter) ?>
    <fieldset>
        <legend>小分類登録</legend>
        <?php
            echo $this->Form->input('title');
            echo $this->Form->select('display_order',$select_display_order,['default' => [count($select_display_order)]]);
            echo $this->Form->input('select_flg');
        ?>
        <input type="hidden" name="books" value="<?= $searchBooks ?>">
        <input type="hidden" name="middle_chapter_id" value="<?= $searchMiddleChapters ?>">
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
<script>

    var books = document.getElementById('books');
    var middle_chapters = document.getElementById('middle_chapters');
    var target = document.getElementById('search');
    books.onchange = function(){
        change_submit();
    }
    middle_chapters.onchange = function(){
        change_submit();
    }
    function change_submit() {

        target.method = "post";
        target.submit();

    }

</script>
