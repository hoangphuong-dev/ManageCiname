<template>
    <div>
        <Bar
            :chart-data="dataChart"
            :width="width"
            :height="height"
            :chart-options="chartOptions"
            :max_post="max_post"
            :max_engagement="max_engagement"
        />
    </div>
</template>

<script>
import { Bar } from "vue-chartjs";
import { Line } from "vue-chartjs";
import { CategoryScale } from "chart.js";
import {
    Chart,
    Title,
    Tooltip,
    Legend,
    BarElement,
    LinearScale,
    LineController,
    LineElement,
    PointElement,
} from "chart.js";

Chart.register(
    Title,
    Tooltip,
    Legend,
    BarElement,
    CategoryScale,
    LinearScale,
    LineController,
    LineElement,
    PointElement
);

export default {
    name: "BarChart",
    components: { Bar, Line },
    props: {
        chartId: { type: String, default: "bar-chart" },
        datasetIdKey: { type: String, default: "label" },
        width: { type: Number, default: 400 },
        height: { type: Number, default: 400 },
        cssClasses: { default: "", type: String },
        styles: { type: Object, default: () => {} },
        dataChart: { label: [], datasets: [] },
        max_post: { type: Number, default: 0 },
        max_engagement: { type: Number, default: 0 },
    },
    data() {
        return {
            chartOptions: {
                plugins: {
                    legend: {
                        display: true,
                    },
                    tooltip: {
                        enabled: true,
                        callbacks: {
                            label: function (context) {
                                let label = context.dataset.label || "";
                                if (label == "エンゲージメント率") {
                                    label += ": " + context.parsed.y + " %";
                                } else {
                                    label += ": " + context.parsed.y;
                                }
                                return label;
                            },
                        },
                    },
                },
            },
        };
    },
    methods: {},
};
</script>
