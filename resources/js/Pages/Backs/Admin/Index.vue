<template>
    <admin-layout>
        <template #main>
            <div class="bg-white min-h-full m-4 mb-0 p-4">
                <h2 class="mb-5">màn thống kê toàn hệ thống</h2>
                <div class="p-2 mb-10 shadow-lg">
                    <ChartAnalytic :dataChart="chartData" />
                </div>
                <div class="p-2 mb-10 shadow-xl">
                    <WeekAnalysis />
                </div>
            </div>
        </template>
    </admin-layout>
</template>

<script>
import AdminLayout from "@/Layouts/Admin/AdminLayout.vue";
import ChartAnalytic from "../SuperAdmin/ChartAnalytic.vue";
import WeekAnalysis from "./WeekAnalysis.vue";
export default {
    name: "HomeStaff",
    components: {
        AdminLayout,
        ChartAnalytic,
        WeekAnalysis,
    },

    data() {
        return {
            chartData: {
                datasets: [
                    {
                        label: "chart 1",
                        data: [2, 1, 6, 7, 8, 5, 4, 1],
                        type: "line",
                        backgroundColor: "#C71585",
                        borderColor: "#C71585",
                        lineTension: 0.5,
                    },
                    {
                        label: "chart 2",
                        data: [1, 5, 3, 7, 9, 5, 3, 2],
                        type: "bar",
                        borderColor: "#000D8D",
                        backgroundColor: "#000D8D",
                        lineTension: 0.5,
                    },
                ],
                labels: [
                    "2022/05/29",
                    "2022/05/29",
                    "2022/05/29",
                    "2022/05/29",
                    "2022/05/29",
                    "2022/05/29",
                    "2022/05/29",
                    "2022/05/29",
                ],
            },
        };
    },
    methods: {},
};
</script>
