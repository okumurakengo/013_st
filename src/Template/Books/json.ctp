<div class="books form content">
    <?= $this->Form->create($book,['id'=>'json_form','enctype'=>'multipart/form-data']) ?>
    <fieldset>
        <legend><?= __('Add Book') ?></legend>
        <label for="exampleFileUpload" class="button">Upload JSON</label>
        <?=$this->Form->control('json', ['type' => 'file','id'=>'exampleFileUpload','class'=>'show-for-sr'])?>
    </fieldset>
    <?= $this->Form->end() ?>
    <?= $error ?>
</div>
<script>
    $('#exampleFileUpload').on('change',function () {
       $('#json_form').submit();
    });
</script>