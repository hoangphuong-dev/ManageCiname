<template>
    <div class="text-xl bg-white px-4 pb-10">
        <h2 class="text-button_pink font-semibold pt-5 text-14">
            Thống kê doanh thu theo từng phim
        </h2>
        <data-table
            :fields="fields"
            :items="movieAnalysis"
            disable-table-info
            footer-center
            paginate-background
            class="mt-5"
        >
            <template #image="{ row }">
                <img
                    :src="
                        'https://i3.ytimg.com/vi/' +
                        videoId(row) +
                        '/maxresdefault.jpg'
                    "
                    alt="ảnh từ youtube"
                />
            </template>

            <template #sumPrice="{ row }">
                <p>{{ row?.sumPrice.toLocaleString() }} VNĐ</p>
            </template>

            <template #percent="{ row }">
                <p>{{ row?.percent ? row?.percent.toFixed(2) : 0 }}%</p>
            </template>

            <template #chart="{ row }">
                <Line
                    :chart-options="chartOptions"
                    :chart-data="getChartData(row?.labelWeek, row?.dataChart)"
                    :width="120"
                    :height="20"
                    v-if="row"
                />
            </template>
        </data-table>
    </div>
</template>

<script>
import DataTable from "@/Components/DataTable.vue";
import { Line } from "vue-chartjs";
import { CategoryScale } from "chart.js";
import { getYoutubeId } from "@/Helpers/youtube.js";
import {
    Chart as ChartJS,
    Title,
    Tooltip,
    Legend,
    BarElement,
    LinearScale,
    LineController,
    LineElement,
    PointElement,
} from "chart.js";

ChartJS.register(
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
    components: { DataTable, Line },
    props: {
        movieAnalysis: { type: Array, require: true },
    },
    data() {
        return {
            dataAccounts: [],
            loading: false,

            fields: [
                { key: "image", label: "Ảnh", align: "center" },
                { key: "name", label: "Tên phim", width: 200, align: "center" },
                {
                    key: "sumPrice",
                    label: "Doanh thu",
                    width: 200,
                    align: "center",
                },
                {
                    key: "ticketCount",
                    label: "Số  lượng vé bán ra",
                    width: 150,
                    align: "center",
                },
                {
                    key: "percent",
                    label: "Tỉ lệ vé bán được",
                    align: "center",
                    width: 200,
                },
                {
                    key: "chart",
                    label: "Biểu đồ doanh thu 7 ngày gần nhất",
                    align: "center",
                    width: 600,
                },
            ],
            isShowChart: false,
            chartOptions: {
                responsive: true,
                scales: {
                    x: {
                        ticks: {
                            display: false, //this will remove only the label
                        },
                    },
                    y: {
                        grid: {
                            display: true,
                            borderDash: [2],
                            borderDashOffset: 2,
                        },
                    },
                },
                plugins: {
                    legend: false,
                    title: false,
                    datalabels: {
                        display: false,
                    },
                },
                layout: {
                    padding: {
                        left: 2,
                        right: 2,
                    },
                },
            },
        };
    },
    methods: {
        videoId(row) {
            return getYoutubeId(row);
        },

        getChartData(labels, data) {
            const chartData = {
                datasets: [
                    {
                        data: data ?? [],
                        borderColor: "#5264CD",
                        backgroundColor: "#5264CD",
                        borderWidth: 3,
                        pointRadius: 3,
                        label: "Doanh thu",
                    },
                ],
                labels: labels ?? [],
            };
            return chartData;
        },
    },
};
</script>
