<template>
    <admin-layout>
        <template #main>
            <div class="bg-white min-h-full m-4 mb-0 p-4">
                <h2 class="mb-5">Doanh thu theo khu vực</h2>
                <div class="p-2 shadow-lg">
                    <div class="w-2/10 float-right mb-6">
                        <DateFilter
                            :title="'Chọn tháng'"
                            :type="'created_at'"
                            :typeDate="'month'"
                            :modelSelect="filter.selected_month"
                            @onchangeFilter="onFilter"
                        />
                    </div>
                    <ChartAnalytic :dataChart="chartDataByProvince" />
                </div>
            </div>
            <!-- <div class="bg-white min-h-full m-4 mb-0 p-4">
                <h2 class="mb-5">Doanh thu chi tiết khu vực</h2>
                <el-select
                    v-model="provinceSelected"
                    placeholder="Chọn khu vực"
                >
                    <el-option
                        v-for="item in listProvince"
                        :key="item.id"
                        :label="item.name"
                        :value="item.id"
                    ></el-option>
                </el-select>

                <div class="w-2/10 float-right mb-6">
                    <el-date-picker
                        v-model="month_detail"
                        type="month"
                        placeholder="Chọn tháng"
                    />
                </div>
                <div class="p-2 shadow-lg">
                    <ChartAnalytic :dataChart="chartData" />
                </div>
            </div> -->
        </template>
    </admin-layout>
</template>

<script>
import AdminLayout from "@/Layouts/Admin/AdminLayout.vue";
import ChartAnalytic from "./ChartAnalytic.vue";
import { Inertia } from "@inertiajs/inertia";
import { onBefore, onFinish } from "@/Uses/request-inertia";
import DateFilter from "@/Components/Element/DateFilter.vue";

export default {
    name: "Index",
    components: {
        AdminLayout,
        ChartAnalytic,
        DateFilter,
    },

    props: {
        revenuaProvince: { type: Object, require: true },
        listProvince: { type: Object, require: true },
        filtersBE: { type: Object, require: true },
    },

    data() {
        return {
            provinceSelected: "",
            currentMonth: "",
            month_detail: "",
            chartDataByProvince: {
                datasets: [
                    {
                        label: "Số vé đã bán",
                        data: this.revenuaProvince.ticketOrdered,
                        type: "line",
                        backgroundColor: "#6A5BCD",
                        borderColor: "#6A5BCD",
                        lineTension: 0.5,
                        yAxisID: "A",
                    },
                    {
                        label: "Doanh số",
                        data: this.revenuaProvince.revenua,
                        type: "bar",
                        backgroundColor: "#F0C478",
                        borderColor: "#F0C478",
                        lineTension: 0.5,
                        yAxisID: "B",
                    },
                ],
                labels: this.revenuaProvince.provinces,
            },

            // chartData: {
            //     datasets: [
            //         {
            //             label: "chart 1",
            //             data: [2, 1, 6, 7, 8, 5, 4, 1],
            //             type: "line",
            //             backgroundColor: "#C71585",
            //             borderColor: "#C71585",
            //             lineTension: 0.5,
            //         },
            //         // {
            //         //     label: "chart 2",
            //         //     data: [1, 5, 3, 7, 9, 5, 3, 2],
            //         //     type: "bar",
            //         //     borderColor: "#000D8D",
            //         //     backgroundColor: "#000D8D",
            //         //     lineTension: 0.5,
            //         // },
            //     ],
            //     labels: [
            //         "2022/05/29",
            //         "2022/05/29",
            //         "2022/05/29",
            //         "2022/05/29",
            //         "2022/05/29",
            //         "2022/05/29",
            //         "2022/05/29",
            //         "2022/05/29",
            //     ],
            // },
        };
    },

    computed: {
        filter() {
            let selected_month = this.filtersBE?.selected_month;
            return {
                selected_month: selected_month == undefined ? new Date().toISOString() : selected_month,
                // month_detail: this.filtersBE?.month_detail || new Date(),
            };
        },
    },

    methods: {
        onFilter(value, type) {
            this.filter.selected_month = value;
            this.inertia();
        },

        inertia() {
            Inertia.get(
                route("superadmin.home", this.filter),
                {},
                { onBefore, onFinish, preserveScroll: true }
            );
        },
    },
};
</script>
