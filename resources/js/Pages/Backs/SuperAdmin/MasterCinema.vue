<template>
    <admin-layout>
        <template #main>
            <div class="bg-white min-h-full m-4 mb-0 p-4">
                <h2 class="mb-5">Hệ thống rạp</h2>

                <div class="w-full flex relative">
                    <div class="w-3/4"></div>
                    <div class="w-1/4 flex items-end">
                        <el-input
                            v-model="keyword"
                            placeholder="Tìm kiếm tỉnh, thành phố ..."
                            clearable
                        />
                        <div class="btn-primary bg-red-400 h-10 -ml-1 z-10">
                            <img class="mt-1" src="/images/search.svg" />
                        </div>
                    </div>
                </div>

                <div
                    v-if="listProvince.length > 0"
                    class="grid grid-cols-8 gap-4 mt-5"
                >
                    <div
                        @click="
                            this.$inertia.get(
                                route('superadmin.cinema.province', item.id)
                            )
                        "
                        v-for="item in listProvince"
                        :key="item"
                        class="border text-center cursor-pointer rounded-md p-4 shadow-lg hover:border-red-300"
                    >
                        <h3>{{ item.name }}</h3>
                        <div>{{ item.cinemas_count }} rạp</div>
                    </div>
                </div>
                <div v-else>
                    <el-empty description="Không có dữ liệu "></el-empty>
                </div>
            </div>
        </template>
    </admin-layout>
</template>

<script>
import AdminLayout from "@/Layouts/Admin/AdminLayout.vue";

export default {
    name: "MasterCinema",
    components: {
        AdminLayout,
    },
    props: {
        masterCinema: { type: Array, require: true },
    },

    data() {
        return {
            keyword: null,
        };
    },

    computed: {
        listProvince() {
            if (this.keyword) {
                return this.masterCinema.filter((item) => {
                    return this.keyword
                        .toLowerCase()
                        .split(" ")
                        .every((v) => item.name.toLowerCase().includes(v));
                });
            } else {
                return this.masterCinema;
            }
        },
    },
};
</script>
