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
                            class="shadow-lg mb-6 border-2 rounded cursor-pointer grid w-36 p-2 h-14 mr-4 hover:border-red-200"
                            :class="{
                                isActive: activeProvince == item.id,
                            }"
                            @click="getCineme(item.id)"
                        >
                            <span class="mt-1 text-base">
                                {{ item.name }}
                            </span>
                        </div>
                    </div>

                    <!-- Chọn rạp  -->
                    <!-- <h3 class="text-center my-4">Chọn rạp</h3>
                    <div class="w-full grid grid-cols-6 gap-4 min-h-64">
                        <div
                            v-for="item in cinemas"
                            :key="item.id"
                            @click="viewShowTime(item.id)"
                            class="shadow-lg mb-6 border-2 rounded cursor-pointer grid w-56 p-2 h-20 mr-4"
                        >
                            <span class="mt-2 text-base">
                                {{ item.name }}
                            </span>
                        </div>
                    </div> -->
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
import SelectFilter from "@/Components/Element/SelectFilter.vue";
import MovieItem from "@/Components/MovieItem.vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import Pagination from "@/Components/Pagination.vue";
import SearchInput from "@/Components/Element/SearchInput.vue";
import { Inertia } from "@inertiajs/inertia";
import { onBefore, onFinish } from "@/Uses/request-inertia";
import { getYoutubeId } from "@/Helpers/youtube.js";

export default {
    components: { Pagination, AppLayout, SearchInput, SelectFilter, MovieItem },

    props: {
        provinces: { type: Object, required: true },
    },

    data: function () {
        return {
            loading: false,
        };
    },

    computed: {
        // filter() {
        //     const display = this.filtersBE?.display?.toInt();
        //     const movie_genre = this.filtersBE?.movie_genre?.toInt();
        //     const redirect = this.filtersBE?.redirect;
        //     return {
        //         page: this.filtersBE.page?.toInt() || 1,
        //         limit: this.filtersBE.limit?.toInt() || 12,
        //         name: this.filtersBE?.name || null,
        //         display:
        //             display == null || typeof display === "undefined"
        //                 ? null
        //                 : display,
        //         movie_genre:
        //             movie_genre == null || typeof movie_genre === "undefined"
        //                 ? null
        //                 : movie_genre,
        //         redirect:
        //             redirect == null || typeof redirect === "undefined"
        //                 ? null
        //                 : redirect,
        //     };
        // },
    },

    methods: {
        inertia() {
            Inertia.get(
                route("home", this.filter),
                {},
                { onBefore, onFinish, preserveScroll: true }
            );
        },

        handleCurrentPage(value) {
            this.filter.page = value;
            this.inertia();
        },

        onFilter(value, type) {
            if (type === "display") {
                this.filter.display = value;
            } else if (type === "movie_genre") {
                this.filter.movie_genre = value;
            }
            this.filter.page = 1;
            this.inertia();
        },

        detail(id) {
            Inertia.get(route("movie.detail", id), { onBefore, onFinish });
        },

        videoId(row) {
            return getYoutubeId(row);
        },

        getCineme(id) {
            this.activeProvince = id;
            this.formData.province_id = id;
            this.fetchDataCinema(id);
        },
    },
};
</script>

<style lang="css">
.el-carousel__container {
    height: 650px;
}
</style>
