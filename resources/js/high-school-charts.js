import Chart, { Legend, Ticks } from 'chart.js/auto';
import { color } from 'chart.js/helpers';
window.Chart = Chart;
import ChartDataLabels from 'chartjs-plugin-datalabels';
import OutLabelsPlugin from 'chartjs-plugin-piechart-outlabels-aars';

// Fuente
const font_family="'Hanken Grotesk', sans-serif";

// Colores
const colors=["#263ca0ff","#8ba37eff","#ffde24ff","#263ca0ff","#ffde24ff","#263ca0ff","#ffde24ff","#263ca0ff","#ffde24ff","#198622ff","#198622ff"];

Chart.defaults.datasets.line.pointRadius=10
Chart.defaults.datasets.line.pointHoverRadius=10
Chart.defaults.scales.linear.grid={
    drawTicks: true,
    tickLength: 30
}

Chart.register({
    id: "HideScalesForStackedBars",
    beforeInit(chart) {
        if (chart.config.type == "bar" && chart.config.options?.scales?.x?.stacked && chart.options?.scales?.y?.stacked){
            let max;
            chart.data.datasets.forEach(val => max += val);
            chart.config.options.scales.y.max=max;
            chart.config.options.scales.x.display=false;
            chart.config.options.scales.y.ticks.display=false;
            chart.config.options.scales.y.border.display=false;
            chart.config.options.scales.y.grid={
                display: false,
                drawBorder: false,
                drawTicks: false,
            };
            chart.legend.position="right";
        }
    }
})
Chart.register(ChartDataLabels);
Chart.register(OutLabelsPlugin);

Chart.defaults.plugins.datalabels.clamp=true
Chart.defaults.plugins.datalabels.formatter=(value,context)=>{
    if(context.chart.config.type=="pie"){
        const total = context.chart.data.datasets[0].data.reduce((sum, val) => sum + val, 0);
        const percentage = ((value / total) * 100).toFixed(1); // Calculate percentage
        const label = context.chart.data.labels[context.dataIndex]
        return `${label}\n${percentage}%`; // Display percentage
    }else{
        return value.toLocaleString()
    }
}
Chart.defaults.plugins.datalabels.display = ctx => !(ctx.chart.config.type=="pie")

// Configuración de fuentes
Chart.defaults.font.family=font_family;
Chart.defaults.plugins.datalabels.font.weight=900;
Chart.defaults.plugins.datalabels.font.size=11;
Chart.defaults.plugins.outlabels.font.size=12;
Chart.defaults.plugins.outlabels.font.weight=900;

// Configuración de color
Chart.register({
    id: "priorityColors",
    beforeDatasetUpdate(chart, args, options){
        if(chart.config.type=="pie"){
            const dataset = chart.data.datasets[args.index];
            const values = dataset.data;
            const colors=options.colors;
            if(!Array.isArray(values) || !Array.isArray(colors)) return;
            const order =values.map((v,i) => ({value: v, index: i}));
            order.sort((a,b)=>b.value-a.value);
            const result = new Array(values.length);
            order.forEach((item,i)=>{
                result[item.index]=colors[i%colors.length];
            });
            dataset.backgroundColor=result;
        }
    },
    beforeUpdate(chart,args,options){
        const colors = options.colors;
        const datasets = chart.data.datasets;
        if(!datasets || datasets.length === 0) return;
        const numOfCats=datasets[0].data.length;
        const totals=Array(numOfCats).fill(0);
        datasets.forEach(ds=>{
            ds.data.forEach((v,i)=>{
                totals[i] += v;
            });
        });
        console.log(totals)
        const order=totals.map((v,i)=>({total: v, index: i})).sort((a,b)=>b.total-a.total);
        const colsPerCol=new Array(numOfCats);
        order.forEach((item,pos)=>{
            colsPerCol[item.index]=colors[pos % colors.length];
        });
        datasets.forEach(ds=>{
            ds.backgroundColor=ds.data.map((_,i)=>colsPerCol[i]);
        });
    }
});
Chart.defaults.plugins.priorityColors.colors=colors;
Chart.defaults.plugins.outlabels={
    percentPrecision: 3,
    valuePrecision: 3,
    borderRadius: 5, // Border radius of Label
    borderWidth: 0, // Thickness of border
    color: 'white', // Font color
    display: true,
    lineWidth: 1, // Thickness of line between chart arc and Label
    padding: 5,
    stretch: 50, // The length between chart arc and Label
    text: (ctx) => {
        // Format percentage with 2 decimal places
        const percentage = (ctx.percent).toFixed(2);
        return `%l: ${percentage}%`;
    },
    textAlign: "center"
};
// Desactivación de recursos interactivos
Chart.defaults.plugins.tooltip.enabled=false;
Chart.defaults.plugins.legend.onClick=null;
Chart.defaults.plugins.legend.labels.usePointStyle=true;
Chart.defaults.animation=false;

Chart.overrides.pie.aspectRatio=4/3;
