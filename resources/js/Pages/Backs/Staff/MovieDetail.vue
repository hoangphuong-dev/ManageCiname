<template>
    <admin-layout v-loading="loading">
        <template #main>
            <div class="bg-white min-h-full sm:m-4 mb-0 p-4">
                <h2 class="mb-5 text-red-400">Xem chi tiết phim</h2>
                <MovieDetail :movie="movie" />
            </div>
        </template>
    </admin-layout>
</template>

<script>
import MovieDetail from "@/Components/MovieDetail.vue";
import { getYoutubeId } from "@/Helpers/youtube.js";
import { Inertia } from "@inertiajs/inertia";
import { onBefore, onFinish } from "@/Uses/request-inertia";
import AdminLayout from "@/Layouts/Admin/AdminLayout.vue";
import * as Movie from "@/store/const.js";

export default {
    components: {
        AdminLayout,
        MovieDetail,
    },

    props: {
        movie: { type: Object, required: true },
    },

    data: function () {
        return {
            MOVIE_ACTIVE: Movie.MOVIE_ACTIVE,
            MOVIE_DEACTIVE: Movie.MOVIE_DEACTIVE,
            loading: false,
        };
    },

    computed: {
        // filter() {
        //     const display = this.filtersBE?.display;
        //     const movie_genre = this.filtersBE?.movie_genre?.toInt();
        //     const redirect = this.filtersBE?.redirect;
        //     return {
        //         page: this.filtersBE.page?.toInt() || 1,
        //         limit: this.filtersBE.limit?.toInt() || 12,
        //         name: this.filtersBE?.name || null,
        //         display: display || null,
        //         movie_genre:
        //             movie_genre == null || typeof movie_genre === "undefined"
        //                 ? null
        //                 : movie_genre,
        //     };
        // },
    },

    methods: {
        // inertia() {
        //     Inertia.get(
        //         route("staff.movie-now-showing", this.filter),
        //         {},
        //         { onBefore, onFinish, preserveScroll: true }
        //     );
        // },
        // detail(id) {
        //     Inertia.get(route("movie.detail", id), { onBefore, onFinish });
        // },
        // videoId(row) {
        //     return getYoutubeId(row);
        // },
        // handleCurrentPage(value) {
        //     this.filter.page = value;
        //     this.inertia();
        // },
        // onFilter(value, type) {
        //     if (type === "movie_genre") {
        //         this.filter.movie_genre = value;
        //     }
        //     this.filter.page = 1;
        //     this.inertia();
        // },
    },
};
</script>
