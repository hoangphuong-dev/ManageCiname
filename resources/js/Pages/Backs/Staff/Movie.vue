<template>
    <admin-layout v-loading="loading">
        <template #main>
            <div class="bg-white min-h-full sm:m-4 mb-0 p-4">
                <h2 class="mb-5 text-red-400">Phim đang chiếu</h2>
                <div class="w-full flex relative">
                    <div class="w-4/5 flex items-end">
                        <SelectFilter
                            :type="'display'"
                            :modelSelect="filter.display"
                            :listOption="pageDisplay"
                            @onchangeFilter="onFilter"
                        />
                        <SelectFilter
                            :type="'movie_genre'"
                            :modelSelect="filter.movie_genre"
                            :listOption="movieGenre"
                            @onchangeFilter="onFilter"
                        />
                        <SearchInput
                            :filter="filter"
                            v-model="filter.name"
                            label="Tìm kiếm"
                            @submit="onFilter"
                        />
                    </div>
                </div>
            </div>
        </template>
    </admin-layout>
</template>

<script>
import SelectFilter from "@/Components/Element/SelectFilter.vue";
import Pagination from "@/Components/Pagination.vue";
import SearchInput from "@/Components/Element/SearchInput.vue";
import { getYoutubeId } from "@/Helpers/youtube.js";
import { Inertia } from "@inertiajs/inertia";
import { onBefore, onFinish } from "@/Uses/request-inertia";
import AdminLayout from "@/Layouts/Admin/AdminLayout.vue";
import * as Movie from "@/store/const.js";

export default {
    components: { Pagination, AdminLayout, SearchInput, SelectFilter },

    props: {
        movies: {
            type: Object,
            required: true,
        },
        movieGenre: {
            type: Object,
            required: true,
        },
        filtersBE: {
            type: Object,
            required: true,
        },
    },

    data: function () {
        return {
            MOVIE_ACTIVE: Movie.MOVIE_ACTIVE,
            MOVIE_DEACTIVE: Movie.MOVIE_DEACTIVE,
            loading: false,

            pageDisplay: [
                { name: "Tất cả", id: 0 },
                { name: "Đang công chiếu", id: Movie.MOVIE_NOW_SHOWING },
                { name: "Sắp công chiếu", id: Movie.MOVIE_COMMING_SOON },
            ],
        };
    },

    computed: {
        filter() {
            const display = this.filtersBE?.display?.toInt();
            const movie_genre = this.filtersBE?.movie_genre?.toInt();
            const redirect = this.filtersBE?.redirect;
            return {
                page: this.filtersBE.page?.toInt() || 1,
                limit: this.filtersBE.limit?.toInt() || 12,
                name: this.filtersBE?.name || null,
                display:
                    display == null || typeof display === "undefined"
                        ? null
                        : display,
                movie_genre:
                    movie_genre == null || typeof movie_genre === "undefined"
                        ? null
                        : movie_genre,
                redirect:
                    redirect == null || typeof redirect === "undefined"
                        ? null
                        : redirect,
            };
        },
    },

    methods: {
        inertia() {
            Inertia.get(
                route("home", this.filter),
                {},
                { onBefore, onFinish, preserveScroll: true }
            );
        },

        detail(id) {
            Inertia.get(route("movie.detail", id), { onBefore, onFinish });
        },

        videoId(row) {
            return getYoutubeId(row);
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
    },
};
</script>
