<template>
    <app-layout>
        <div class="pb-12">
            <div class="mx-auto messenger-window__custom">
                <div class="w-full">
                    <h3 class="text-center my-10">Hệ thống rạp PHC</h3>
                    <div class="w-full grid grid-cols-9 gap-4 border-b-2">
                        <div
                            v-for="item in provinces"
                            :key="item.id"
                            class="shadow-lg text-center mb-6 border-2 rounded cursor-pointer grid w-40 p-2 h-20 mr-4 hover:border-red-200"
                            :class="{
                                isActive: activeProvince == item.id,
                            }"
                            @click="getCineme(item.id)"
                        >
                            <span class="mt-1 text-base font-bold">
                                {{ item.name }}
                            </span>
                            <p class="my-2">{{ item.cinemas_count }} rạp</p>
                        </div>
                    </div>

                    <!-- Chọn rạp  -->
                    <h3 class="text-center my-10">Chọn rạp</h3>
                    <div class="w-full grid grid-cols-6 gap-4 min-h-64">
                        <div
                            v-for="item in cinemas"
                            :key="item.id"
                            @click="
                                this.$inertia.get(
                                    route('view-movie-by-cinema', item.id)
                                )
                            "
                            class="shadow-lg text-center mb-6 border-2 rounded cursor-pointer grid w-56 p-2 h-20 mr-4"
                        >
                            <span class="mt-2 text-base">
                                {{ item.name }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout.vue";
import { getCinemaByProvince } from "@/API/main.js";

export default {
    components: { AppLayout },

    props: {
        provinces: { type: Object, required: true },
    },

    data: function () {
        return {
            activeProvince: "",
            cinemas: [],
            loading: false,
        };
    },

    methods: {
        getCineme(id) {
            this.activeProvince = id;
            this.fetchDataCinema(id);
        },

        async fetchDataCinema(id) {
            getCinemaByProvince(id)
                .then(({ status, data }) => {
                    this.cinemas = data;
                })
                .catch(() => {});
        },
    },
};
</script>

<style lang="css">
.el-carousel__container {
    height: 650px;
}

.isActive {
    background: #f56c6c;
    color: white;
}
</style>
