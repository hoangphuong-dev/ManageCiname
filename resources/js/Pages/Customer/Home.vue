<template>
    <app-layout>
        <div class="pb-12">
            <div class="mx-auto messenger-window__custom">
                <div class="w-full">
                    <div class="main-jobs">
                        <!-- slider -->
                        <div class="w-full">
                            <h2 class="text-center my-6">
                                Phim Hot đang công chiếu
                            </h2>
                            <el-carousel indicator-position="outside">
                                <el-carousel-item
                                    class="cursor-pointer rounded"
                                    v-for="item in movieHot"
                                    :key="item.id"
                                    @click="detail(item.id)"
                                >
                                    <img
                                        class="min-w-full h-min-h-full"
                                        :src="
                                            'https://i3.ytimg.com/vi/' +
                                            videoId(item) +
                                            '/maxresdefault.jpg'
                                        "
                                    />
                                </el-carousel-item>
                            </el-carousel>
                        </div>

                        <div
                            class="w-full py-10 mb-2 border-dashed border-t-2 border-b-2 border-red-300"
                        >
                            <div class="flex">
                                <div class="w-1/2">
                                    <SearchInput
                                        :filter="filter"
                                        v-model="filter.name"
                                        label="Tìm tên phim ... "
                                        @submit="onFilter"
                                    />
                                </div>

                                <div class="ml-10 -mt-5 w-1/2 flex">
                                    <SelectFilter
                                        :type="'movie_genre'"
                                        :modelSelect="filter.movie_genre"
                                        :listOption="movieGenre"
                                        @onchangeFilter="onFilter"
                                    />
                                </div>
                            </div>
                        </div>

                        <!-- show phim -->
                        <div class="w-full">
                            <h2 class="text-center">Danh sách chọn phim</h2>
                            <MovieItem :movies="movies" />
                        </div>

                        <div
                            v-if="movies.meta.total > movies.meta.per_page"
                            class="w-full justify-center my-16 flex"
                        >
                            <Pagination
                                v-model="movies.meta.current_page"
                                @current-change="handleCurrentPage"
                                :page-size="Number(movies.meta.per_page)"
                                :total="Number(movies.meta.total)"
                            />
                        </div>
                    </div>
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
        movies: {
            type: Object,
            required: true,
        },
        movieGenre: {
            type: Object,
            required: true,
        },
        movieHot: {
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
            loading: false,
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
    },
};
</script>

<style lang="css">
.el-carousel__container {
    height: 650px;
}
</style>
