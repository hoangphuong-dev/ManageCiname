<template>
    <div class="my-6">
        <Bar
            :chart-data="dataChart"
            :chart-options="chartOptions"
            :height="200"
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
                        // callbacks: {
                        //     label: function (context) {
                        //         let label = context.dataset.label || "";
                        //         if (label == "エンゲージメント率") {
                        //             label += ": " + context.parsed.y + " %";
                        //         } else {
                        //             label += ": " + context.parsed.y;
                        //         }
                        //         return label;
                        //     },
                        // },
                    },
                },
            },
        };
    },
    methods: {},
};
</script>
