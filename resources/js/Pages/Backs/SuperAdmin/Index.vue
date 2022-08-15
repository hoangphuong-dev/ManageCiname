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
            <div class="bg-white min-h-full m-4 mb-0 p-4">
                <h2 class="mb-5">Doanh thu chi tiết khu vực</h2>
                <SelectFilter
                    :type="'province'"
                    :modelSelect="filter.province"
                    :listOption="listProvince"
                    @onchangeFilter="onFilter"
                />

                <div class="p-2 shadow-lg">
                    <ChartAnalytic :dataChart="chartDataByProvinceDetail" />
                </div>
            </div>
        </template>
    </admin-layout>
</template>

<script>
import AdminLayout from "@/Layouts/Admin/AdminLayout.vue";
import ChartAnalytic from "./ChartAnalytic.vue";
import { Inertia } from "@inertiajs/inertia";
import { onBefore, onFinish } from "@/Uses/request-inertia";
import DateFilter from "@/Components/Element/DateFilter.vue";
import SelectFilter from "@/Components/Element/SelectFilter.vue";

export default {
    name: "Index",
    components: {
        AdminLayout,
        ChartAnalytic,
        DateFilter,
        SelectFilter,
    },

    props: {
        filtersBE: { type: Object, require: true },
        listProvince: { type: Array, require: true },
        revenuaProvince: { type: Object, require: true },
        revenuaProvinceDetail: { type: Object, require: true },
    },

    data() {
        return {
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

            chartDataByProvinceDetail: {
                datasets: [
                    {
                        label: "Số vé đã bán",
                        data: this.revenuaProvinceDetail.ticketOrdered,
                        type: "line",
                        backgroundColor: "#6A5BCD",
                        borderColor: "#6A5BCD",
                        lineTension: 0.5,
                        yAxisID: "A",
                    },
                    {
                        label: "Doanh số",
                        data: this.revenuaProvinceDetail.revenua,
                        type: "bar",
                        backgroundColor: "#F0C478",
                        borderColor: "#F0C478",
                        lineTension: 0.5,
                        yAxisID: "B",
                    },
                ],
                labels: this.revenuaProvinceDetail.cinemas,
            },
        };
    },

    computed: {
        filter() {
            let selected_month = this.filtersBE?.selected_month;
            const province = this.filtersBE?.province?.toInt();

            return {
                selected_month:
                    selected_month == undefined
                        ? new Date().toISOString()
                        : selected_month,
                province:
                    province == null || typeof province === "undefined"
                        ? this.listProvince[0].id
                        : province,
            };
        },
    },

    methods: {
        onFilter(value, type) {
            if (type == "province") {
                this.filter.province = value;
            } else if (type == "created_at") {
                this.filter.selected_month = value;
            }

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
