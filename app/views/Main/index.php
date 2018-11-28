Привет! Тут будет наглядно отображаться Ваш прогресс
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
    google.charts.load("current", {packages: ["corechart"]});
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        var data = google.visualization.arrayToDataTable([
            ['Task', 'Hours per Day'],
            ['Work', 11],
            ['Eat', 2],
            ['Commute', 2],
            ['Watch TV', 2],
            ['Sleep', 7]
        ]);

        var options = {
            title: 'My Daily Activities',
            pieHole: 0.4,
        };

        var chart = new google.visualization.PieChart(document.getElementById('donutchart'));
        chart.draw(data, options);
    }
</script>

<!--Div that will hold the pie chart-->

<div class="col s12">
    <div class="row">
        <div id="donutchart" style="width: 900px; height: 500px;"></div>
    </div>
</div>
<!--<div id="chart_div"></div>
<div id="chart_div2"></div>-->

<!--<img data-src="/workout/img/maxresdefault.jpg" class="lazy">-->

<? //php new \app\widgets\formFeedback\FormFeedback(array()); ?>