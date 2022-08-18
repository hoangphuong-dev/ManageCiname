<template>
    <admin-layout>
        <template #main>
            <div class="bg-white min-h-full m-4 mb-0 p-4">
                <h2 class="mb-5">Thống kê của rạp</h2>
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

                    <ChartAnalytic :dataChart="chartData" />
                </div>
                <div class="mb-10 shadow-xl">
                    <WeekAnalysis :movieAnalysis="movieAnalysis" />
                </div>
            </div>
        </template>
    </admin-layout>
</template>

<script>
import AdminLayout from "@/Layouts/Admin/AdminLayout.vue";
import ChartAnalytic from "../SuperAdmin/ChartAnalytic.vue";
import WeekAnalysis from "./WeekAnalysis.vue";
import DateFilter from "@/Components/Element/DateFilter.vue";
import { Inertia } from "@inertiajs/inertia";
import { onBefore, onFinish } from "@/Uses/request-inertia";

export default {
    name: "Analysis",
    components: {
        AdminLayout,
        ChartAnalytic,
        WeekAnalysis,
        DateFilter,
    },

    props: {
        revenuaCinema: { type: Object, require: true },
        movieAnalysis: { type: Object, require: true },
        filtersBE: { type: Object, require: true },
    },

    data() {
        return {
            chartData: {
                datasets: [
                    {
                        label: "Số vé đã bán",
                        data: this.revenuaCinema?.arrTicket,
                        type: "line",
                        backgroundColor: "#6A5BCD",
                        borderColor: "#6A5BCD",
                        lineTension: 0.5,
                        yAxisID: "A",
                    },
                    {
                        label: "Doanh số",
                        data: this.revenuaCinema?.arrRenua,
                        type: "bar",
                        backgroundColor: "#F0C478",
                        borderColor: "#F0C478",
                        lineTension: 0.5,
                        yAxisID: "B",
                    },
                ],
                labels: this.revenuaCinema?.dataLabel,
            },
        };
    },

    computed: {
        filter() {
            let selected_month = this.filtersBE?.selected_month;

            return {
                selected_month:
                    selected_month == undefined
                        ? new Date().toISOString()
                        : selected_month,
            };
        },
    },

    methods: {
        onFilter(value, type) {
            if (type == "created_at") {
                this.filter.selected_month = value;
            }

            this.inertia();
        },

        inertia() {
            Inertia.get(
                route("admin.home", this.filter),
                {},
                { onBefore, onFinish, preserveScroll: true }
            );
        },
    },
};
</script>
