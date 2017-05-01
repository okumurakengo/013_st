<div class="studies graph content">
    <h3>グラフ</h3>
    <form id="graph_form" action="<?= $this->Url->build(['controller'=>'Studies', 'action'=>'drawgraph']); ?>" method="post">
        <div class="row">
            <div class="medium-3 columns">
                <p>START<?= $this->Form->text('start_date',['default' => $this->Studies->start_date(), 'id' => 'start_date', 'class' => 'datepicker']) ?></p>
            </div>
            <div class="medium-3 columns">
                <p>END<?= $this->Form->text('end_date',['default' => $this->Studies->end_date(), 'id' => 'end_date', 'class' => 'datepicker']) ?></p>
            </div>
            <div class="medium-6 columns text-right end">
                <button id="graph_button">描画</button>
            </div>
        </div>
    </form>
    <div id="chart_div"></div>
</div>
