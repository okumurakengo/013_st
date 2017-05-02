$(function(){
    $( ".datepicker" ).datepicker({
        dateFormat: "yy/mm/dd"
    });

    //グラフ描画
    google.charts.load('current', {'packages':['corechart']});

    var $form_studies = $('#graph_form_studies');
    var $form_day = $('#graph_form_day');

    if($form_studies.length && $form_day.length) {

        var ajax_draw_exe = function (cat,status) {
            var url,type,start_date,end_date,cat,past

            switch(cat){
                case 'studies':
                    url = $form_studies.attr('action');
                    type = $form_studies.attr('method');
                    start_date = $('#start_date_studies').val();
                    end_date = $('#end_date_studies').val();
                    cat = $form_studies.data('cat');
                    past = '';
                    break;
                case 'day':
                    url = $form_day.attr('action');
                    type = $form_day.attr('method');
                    start_date = $('#start_date_day').val();
                    end_date = $('#end_date_day').val();
                    cat = $form_day.data('cat');
                    past = $('#past').val();
                    break;
            }

            $.ajax({
                url: url,
                type: type,
                data: {
                    start_date: start_date,
                    end_date: end_date,
                    cat: cat,
                    past: past
                }
            }).done(function (data) {
                console.log(data);
                data = $.parseJSON(data);

                switch(cat){
                    case 'studies':
                        google.charts.setOnLoadCallback(drawChart_studies(data));
                        break;
                    case 'day':
                        google.charts.setOnLoadCallback(drawChart_day(data));
                        break;
                }

            }).fail(function (jqXHR, textStatus, errorThrown) {
                console.log('fail');
            }).always(function(jqXHR, textStatus) {
                if(status !== 'hide') {
                    hideloader();
                }
            });
        }

        var ajax_draw = function () {
            showloader();

            ajax_draw_exe('studies','load');
            ajax_draw_exe('day','hide');
        };

        ajax_draw();

        $('#graph_studies_button').on('click', function (e) {
            e.preventDefault();

            showloader();
            ajax_draw_exe('studies','button');
        });
        $('#graph_day_button').on('click', function (e) {
            e.preventDefault();

            showloader();
            ajax_draw_exe('day','button');
        });

    }

    function drawChart_studies(data) {
        var dataTable = new google.visualization.DataTable();
        dataTable.addColumn('datetime', '日時');
        $.each(data[0], function (i, value) {
            dataTable.addColumn('number', value.title);
        });

        var rows = [];
        var subrows = [];
        $.each(data, function (i, value) {
            subrows = [
                new Date(value[0].date.Y,
                    value[0].date.m - 1,
                    value[0].date.d),
            ];
            $.each(data[0], function (j, value2) {
                subrows.push(
                    (Math.floor(
                            (value[j].count / value[j].schapter_total) * 1000)
                    ) / 10
                );
            });

            rows.push(subrows);
        });
        dataTable.addRows(rows);
        var options = {
            title: '比率グラフ',
            width: '100%',
            height: 700,
            hAxis: {
                title: '日付',
                format: 'M/d'
            },
            vAxis: {
                title: '%'
            },
        };
        var chart = new google.visualization.LineChart(document.getElementById('chart_div_studies'));
        chart.draw(dataTable, options);
    }

    function drawChart_day(data) {
        for(var i=0;i<data.length;i++){
            if(i !== 0) {
                data[i][0] = new Date(data[i][0])
            }
        }
        var data = google.visualization.arrayToDataTable(data);

        var options = {
            title: '1日の勉強量',
            hAxis: {
                title: '日時',
                titleTextStyle: {color: '#333'},
                format: 'M/d'
            },
            vAxis: {
                minValue: 0,
            }
        };

        var chart = new google.visualization.AreaChart(document.getElementById('chart_div_day'));
        chart.draw(data, options);
    }

    function showloader(){
        $("body").append($('<div class="modal-backdrop in"></div>'));
    }
    function hideloader() {
        $(".modal-backdrop").remove();
    }
});