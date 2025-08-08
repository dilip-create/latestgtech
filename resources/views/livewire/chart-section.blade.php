<div
    x-data="{
        chart: null,
        init() {
            this.renderChart(@js($chartData));
        },
        renderChart(dataPoints) {
            if (this.chart) this.chart.destroy?.();

            this.chart = new CanvasJS.Chart('chartContainer', {
                animationEnabled: true,
                theme: 'light1',
                title: {
                    text: 'Deposit Chart - Last {{ $days }} Days'
                },
                axisY: {
                    title: 'Deposits (Currency)'
                },
                data: [{
                    type: 'column',
                    showInLegend: true,
                    legendText: 'Deposit Amount',
                    dataPoints: dataPoints
                }]
            });

            this.chart.render();
        },
        reload(newData) {
            this.renderChart(newData);
        }
    }"
    x-init="init()"
    x-on:chart-updated.window="reload($event.detail)"
>

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Deposit Overview</h4>
            <div class="btn-group">
                {{-- <button class="btn btn-secondary" wire:click="loadChartData(7)">Last 7 Days</button> --}}
                <button class="btn btn-secondary" wire:click="loadChartData(30)">Last 30 Days</button>
                <button class="btn btn-secondary" wire:click="loadChartData(90)">Last 90 Days</button>
                <button class="btn btn-secondary" wire:click="loadChartData(365)">Last 365 Days</button>
            </div>
        </div>
        <div class="card-body">
            <div id="chartContainer" style="height: 430px; width: 100%;"></div>
        </div>
    </div>
</div>

<script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>
