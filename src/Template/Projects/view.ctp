<?php
/**
  * @var \App\View\AppView $this
  */
?>
<div class="projects view content">
    <h3><?= h($project->title) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Title') ?></th>
            <td><?= h($project->title) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Url') ?></th>
            <td><?= h($project->url) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Status') ?></th>
            <td><?= $project->has('status') ? $this->Html->link($project->status->title, ['controller' => 'Statuses', 'action' => 'view', $project->status->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($project->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Display Order') ?></th>
            <td><?= $this->Number->format($project->display_order) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($this->Projects->date_format($project->created)) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($this->Projects->date_format($project->modified)) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Select Flg') ?></th>
            <td><?= $project->select_flg ? __('Yes') : __('No'); ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Source Codes') ?></h4>
        <?php if (!empty($project->source_codes)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('folder Id') ?></th>
                <th scope="col"><?= __('Directory Flg') ?></th>
                <th scope="col"><?= __('Name') ?></th>
            </tr>
            <?php foreach ($project->source_codes as $sourceCodes): ?>
            <tr>
                <td><?= h($sourceCodes->id) ?></td>
                <td><?= h($sourceCodes->source_code_id) ?></td>
                <td><?= h($sourceCodes->directory_flg) ?></td>
                <td><?= h($sourceCodes->name) ?></td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
