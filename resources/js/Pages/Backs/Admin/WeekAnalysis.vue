<template>
    <div class="text-xl bg-white px-4 pb-10">
        <h2 class="text-button_pink font-semibold pt-5 text-14">
            Thống kê doanh thu 7 ngày theo từng phim
        </h2>
        <data-table
            :fields="fields"
            :items="dataAccounts"
            :current-page="filter.page || 1"
            disable-table-info
            footer-center
            paginate-background
            @page="handleCurrentPage"
            class="el-table-header__black mt-5 rou"
        >
            <!-- chart -->
            <template #followers_change_chart="{ row }">
                <Line
                    :chart-options="options"
                    :chart-data="
                        getChartData(row?.data_labels, row?.post_last_week)
                    "
                    :width="120"
                    :height="20"
                    v-if="row?.post_last_week"
                />
            </template>
        </data-table>
    </div>
</template>

<script>
import DataTable from "@/Components/DataTable.vue";
import { Line } from "vue-chartjs";
import { CategoryScale } from "chart.js";
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
        dataAllAccount: { type: Array },
    },

    watch: {
        dataAllAccount: {
            handler() {
                this.getChartData();
            },
        },
    },
    data() {
        return {
            dataAccounts: [],

            loading: false,
            filter: {
                page: 1,
                limit: 6,
            },
            fields: [
                { key: "image", label: "Ảnh", width: 300, align: "center" },
                { key: "name", label: "Tên phim", width: 200, align: "center" },
                {
                    key: "avenua",
                    label: "Doanh thu 7 ngày",
                    width: 250,
                    align: "center",
                },
                {
                    key: "number_post_last_week",
                    label: "Số  lượng vé bán ra",
                    width: 250,
                    align: "center",
                },
                {
                    key: "ttttt",
                    label: "Tỉ lệ vé được bán ra",
                    align: "center",
                    width: 300,
                },
                {
                    key: "hhhhh",
                    label: "Biểu đồ doah thu 7 ngày",
                    align: "center",
                    width: 550,
                },
            ],
            isShowChart: false,
            options: {
                responsive: true,
                scales: {
                    x: {
                        display: false,
                    },
                    y: {
                        display: false,
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
        // calculatorPercen(row) {
        //     if (row) {
        //         let result = (this.calculator(row) / row?.followers) * 100;
        //         result = result.toFixed(2);
        //         if (result == "-0.00") {
        //             return (result = "0.00");
        //         }

        //         result = result > 0 ? "+" + result : result;
        //         return result;
        //     }
        // },

        calculator(row) {
            let temp = row?.old_followers ? row.old_followers : 0;
            return row?.followers - temp;
        },
        getChartData(labels, data) {
            if (!labels || !data) return;

            const chartData = {
                datasets: [
                    {
                        data: data,
                        borderColor: "#BE3D8F",
                        backgroundColor: "#BE3D8F",
                        borderWidth: 3,
                        pointRadius: 3,
                    },
                ],
                labels: labels,
            };
            return chartData;
        },

        handleCurrentPage(value) {
            this.filter.page = value;
            this.fetchData();
        },
    },
};
</script>
