$(function(){
    $( ".datepicker" ).datepicker({
        dateFormat: "yy/mm/dd"
    });

    //グラフ描画
    google.charts.load('current', {'packages':['corechart']});

    var $form = $('#graph_form');

    if($form.length) {
        var ajax_draw = function () {
            $("body").append($('<div class="modal-backdrop in"></div>'));
            $.ajax({
                url: $form.attr('action'),
                type: $form.attr('method'),
                data: {
                    start_date: $('#start_date').val(),
                    end_date: $('#end_date').val()
                }
            }).done(function (data) {
                data = $.parseJSON(data);
                google.charts.setOnLoadCallback(drawChart(data));
                $(".modal-backdrop").remove();
            }).fail(function () {
                console.log('fail');
                $(".modal-backdrop").remove();
            });
        }
        ajax_draw();
        $('#graph_button').on('click', function (e) {
            e.preventDefault();
            ajax_draw();
        });

        function drawChart(data) {
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
                    console.log(j + '     ' + value[j].count);
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
                height: 750,
                hAxis: {
                    title: '日付',
                    format: 'M/d'
                },
                vAxis: {
                    title: '%'
                },
            };
            var chart = new google.visualization.LineChart(document.getElementById('chart_div'));
            chart.draw(dataTable, options);
        }
    }
});