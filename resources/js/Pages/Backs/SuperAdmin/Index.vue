<template>
    <admin-layout>
        <template #main>
            <div class="bg-white min-h-full m-4 mb-0 p-4">
                <h2 class="mb-5">màn thống kê toàn hệ thống</h2>
                <div class="p-2 shadow-lg">
                    <ChartAnalytic
                        :width="500"
                        :height="600"
                        :dataChart="chartData"
                    />
                </div>
            </div>
        </template>
    </admin-layout>
</template>

<script>
import AdminLayout from "@/Layouts/Admin/AdminLayout.vue";
import ChartAnalytic from "./ChartAnalytic.vue";
export default {
    name: "HomeStaff",
    components: {
        AdminLayout,
        ChartAnalytic,
    },

    data() {
        return {
            chartData: {
                datasets: [
                    {
                        label: "いいね数",
                        data: [1, 1, 1],
                        type: "line",
                        backgroundColor: "#C71585",
                        borderColor: "#C71585",
                        lineTension: 0.5,
                    },
                    {
                        label: "コメント数",
                        data: [1, 1, 1],
                        type: "bar",
                        borderColor: "#000D8D",
                        backgroundColor: "#000D8D",
                        lineTension: 0.5,
                    },
                ],
                labels: ["2022/05/29", "2022/05/29", "2022/05/29"],
            },
        };
    },
    methods: {},
};
</script>
