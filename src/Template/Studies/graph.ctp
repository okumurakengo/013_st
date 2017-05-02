<div class="studies graph content">
    <h3>グラフ</h3>
    <form id="graph_form_day" action="<?= $this->Url->build(['controller'=>'Studies', 'action'=>'drawgraph']); ?>" method="post" data-cat="day">
        <div class="row">
            <div class="medium-3 columns">
                <p>START<?= $this->Form->text('start_date_day',['default' => $this->Studies->start_date('day'), 'id' => 'start_date_day', 'class' => 'datepicker']) ?></p>
            </div>
            <div class="medium-3 columns">
                <p>END<?= $this->Form->text('end_date_day',['default' => $this->Studies->end_date(), 'id' => 'end_date_day', 'class' => 'datepicker']) ?></p>
            </div>
            <div class="medium-3 columns">
                <p>過去分<?= $this->Form->number('past',['default' => 1, 'id' => 'past']) ?></p>
            </div>
            <div class="medium-3 columns text-right end">
                <button id="graph_day_button">描画</button>
            </div>
        </div>
    </form>
    <div id="chart_div_day" style="width: 100%; height: 350px;"></div>

    <hr />

    <form id="graph_form_studies" action="<?= $this->Url->build(['controller'=>'Studies', 'action'=>'drawgraph']); ?>" method="post" data-cat="studies">
        <div class="row">
            <div class="medium-3 columns">
                <p>START<?= $this->Form->text('start_date_studies',['default' => $this->Studies->start_date('studies'), 'id' => 'start_date_studies', 'class' => 'datepicker']) ?></p>
            </div>
            <div class="medium-3 columns">
                <p>END<?= $this->Form->text('end_date_studies',['default' => $this->Studies->end_date(), 'id' => 'end_date_studies', 'class' => 'datepicker']) ?></p>
            </div>
            <div class="medium-6 columns text-right end">
                <button id="graph_studies_button">描画</button>
            </div>
        </div>
    </form>
    <div id="chart_div_studies"></div>
</div>
