<template>
    <admin-layout>
        <template #main>
            <div class="bg-white min-h-full m-4 mb-0 p-4">
                <h2 class="mb-5">Hệ thống rạp</h2>
                <div class="grid grid-cols-8 gap-4 mt-5">
                    <div
                        @click="
                            this.$inertia.get(
                                route('superadmin.cinema.province', item.id)
                            )
                        "
                        v-for="item in masterCinema"
                        :key="item"
                        class="border text-center cursor-pointer rounded-md p-4 shadow-lg hover:border-red-300"
                    >
                        <h3>{{ item.name }}</h3>
                        <div>{{ item.cinemas_count }} rạp</div>
                    </div>
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
        masterCinema: { type: Object, require: true },
    },
};
</script>
