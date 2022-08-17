<template>
    <div class="my-6">
        <Bar
            :chart-data="dataChart"
            :chart-options="chartOptions"
            :height="150"
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
        dataChart: { label: [], datasets: [] },
        maxAxisA: { type: Number, default: null },
        maxAxisB: { type: Number, default: null },
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
                                if (label == "FFF") {
                                    label += ": " + context.parsed.y + " %";
                                } else {
                                    label += ": " + context.parsed.y;
                                }
                                return label;
                            },
                        },
                    },
                },
                datalabels: {
                    display: false,
                },
                legend: {
                    display: true,
                },
                scales: {
                    A: {
                        type: "linear",
                        position: "left",
                        grid: {
                            display: false,
                        },
                        max: this.maxAxisA,
                        ticks: {
                            stepSize: this.maxAxisA / 20,
                        },
                    },
                    B: {
                        type: "linear",
                        position: "right",
                        grid: {
                            display: true,
                        },
                        max: this.maxAxisB,
                        ticks: {
                            stepSize: this.maxAxisB / 10000,
                        },
                    },
                },
            },
        };
    },

    mounted() {
        this.hiddenLegend();
    },
    methods: {
        hiddenLegend() {
            // if (this.max_post) {
            this.chartOptions.plugins.legend.display = true;
            // } else {
            // this.chartOptions.plugins.legend.display = false;
            // }
        },
    },
};
</script>
