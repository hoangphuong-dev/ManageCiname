<template>
    <admin-layout>
        <template #main>
            <div class="bg-white min-h-full m-4 mb-0 p-4">
                <h2 class="mb-5">Hệ thống rạp</h2>
                <div class="w-full flex relative">
                    <div class="w-3/4 flex items-end">
                        <div class="flex">
                            <el-input
                                ref="search"
                                placeholder="Tìm kiếm"
                                clearable
                                v-model="keyword"
                                @keyup.enter="searchChange()"
                            />
                        </div>
                    </div>
                </div>
                <div class="grid grid-cols-4 gap-4 mt-5">
                    <div
                        v-for="item in masterCinema"
                        :key="item"
                        class="border rounded-md p-4"
                    >
                        <h2 class="text-center">{{ item.name }}</h2>

                        <div>{{ item.cinemas_count }} rạp</div>
                        <div>{{ item.cinemas_count }} phòng</div>
                        <div class="text-center mt-6">
                            <el-button
                                size="small"
                                @click="detail(item.id)"
                                type="danger"
                            >
                                Xem chi tiết
                            </el-button>
                        </div>
                    </div>
                </div>
            </div>
        </template>
    </admin-layout>
</template>

<script>
import AdminLayout from "@/Layouts/Admin/AdminLayout.vue";
import SearchInput from "@/Components/Element/SearchInput.vue";
import Pagination from "@/Components/Pagination.vue";
import { onBefore, onFinish } from "@/Uses/request-inertia";
import { Inertia } from "@inertiajs/inertia";

export default {
    name: "MasterCinema",
    components: {
        AdminLayout,
        SearchInput,
        Pagination,
    },
    props: {
        master_cinemas: Object,
        filtersBE: Object,
    },
    computed: {
        masterCinema() {
            return this.master_cinemas.data;
        },
        filter() {
            return {
                page: this.filtersBE.page?.toInt() || 1,
                limit: this.filtersBE.limit?.toInt() || 10,
                name: this.filtersBE?.name || "",
            };
        },
    },
    data() {
        return {
            loading: false,
            total: "",
            perPage: "",
            keyword: "",
        };
    },
    methods: {
        inertia() {
            Inertia.get(
                route("superadmin.admin_info.index", this.filter),
                {},
                { onBefore, onFinish, preserveScroll: true }
            );
        },

        searchChange() {
            this.filter.name = this.keyword;
            this.inertia();
        },

        detail(province_id) {
            Inertia.get(
                route("superadmin.cinema.province", {
                    province_id: province_id,
                }),
                {},
                { onBefore, onFinish, preserveScroll: true }
            );
        },
    },
};
</script>
