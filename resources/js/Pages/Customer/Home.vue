<template>
  <app-layout>
    <div class="py-12">
      <div class="mx-auto messenger-window__custom">
        <div class="w-full">
          <div class="main-jobs">
            <!-- slider -->
            <div class="w-full">
              <div class="w-4/5 m-auto border-white h-44">
                <carousel :items-to-show="1.5">
                  <slide v-for="slide in 10" :key="slide">
                    <div class="h-28 w-full bg-red-50">FFFFFF</div>
                  </slide>
                </carousel>
              </div>
            </div>

            <!-- button filter  -->
            <div
              class="
                w-full
                pt-8
                pb-16
                mb-2
                border-dashed border-t-2 border-b-2 border-red-300
              "
            >
              <el-form>
                <div class="flex">
                  <div class="w-1/2">
                    <el-form-item label="Tìm theo từ khóa">
                      <el-input
                        ref="search"
                        v-model="movies.keyword"
                        placeholder="Tìm tên phim ... "
                        clearable
                        @keyup.enter="searchChange()"
                      />
                    </el-form-item>
                  </div>

                  <div class="w-1/2">
                    <el-select
                      class="ml-4"
                      v-model="movies.search_movie_genre"
                      clearable
                      placeholder="Chọn thể loại"
                    >
                      <el-option
                        v-for="item in movie_genres.data"
                        :key="item.id"
                        :label="item.name"
                        :value="item.id"
                        @click="searchType()"
                      ></el-option>
                    </el-select>
                  </div>
                </div>
              </el-form>
            </div>

            <!-- show phim -->
            <div class="w-full">
              <h2 class="text-center">Danh sách chọn phim</h2>
              <div
                v-if="movies.data.length > 0"
                class="grid grid-cols-4 gap-6 mt-5"
              >
                <div
                  v-for="item in movies.data"
                  :key="item.id"
                  class="border rounded-md p-4"
                >
                  <img
                    :src="
                      'https://i3.ytimg.com/vi/' +
                      videoId(item) +
                      '/maxresdefault.jpg'
                    "
                  />

                  <h2 class="text-center my-2">{{ item.name }}</h2>
                  <div class="w-full text-center">
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
              <div v-else>
                <el-empty description="Không có dữ liệu"></el-empty>
              </div>
            </div>

            <!-- phan trang suất chiếu  -->
            <div
              v-if="movies.total > movies.perPage"
              class="w-full justify-center my-16 flex"
            >
              <pagination
                v-model="movies.current_page"
                @current-change="handleCurrentPage"
                :page-size="Number(movies.perPage)"
                :total="Number(movies.total)"
              />
            </div>
          </div>
        </div>
      </div>
    </div>
  </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout.vue";
import Pagination from "@/Components/Pagination.vue";
import { getYoutubeId } from "@/Helpers/youtube.js";
import { listMovie } from "@/API/main.js";
import { Inertia } from "@inertiajs/inertia";
import { onBefore, onFinish } from "@/Uses/request-inertia";
import "vue3-carousel/dist/carousel.css";
import { Carousel, Slide } from "vue3-carousel";

export default {
  components: { Slide, Carousel, Pagination, AppLayout },
  props: {
    movie_genres: Object,
  },
  created() {
    this.fetchData();
  },
  data: function () {
    return {
      loading: false,
      movies: {
        data: [],
        total: "",
        current_page: "",
        keyword: "",
        search_movie_genre: "",
        perPage: "",
        filter: {
          page: 1,
          limit: 12,
          action: "1", // lấy những film active
        },
      },
    };
  },
  methods: {
    detail(id) {
      Inertia.get(route("movie.detail", id), { onBefore, onFinish });
    },

    videoId(row) {
      return getYoutubeId(row);
    },

    handleCurrentPage(value) {
      this.movies.filter.page = value;
      this.fetchData();
    },

    searchChange() {
      this.movies.filter.name = this.movies.keyword;
      this.fetchData();
    },

    searchType() {
      this.movies.filter.movie_genre = this.movies.search_movie_genre;
      this.fetchData();
    },

    async fetchData() {
      this.loading = true;
      listMovie(this.movies.filter)
        .then(({ status, data }) => {
          this.movies.data = status === 200 ? data.data : this.movies.data;
          this.movies.total = data.meta.total;
          this.movies.perPage = data.meta.per_page;
          this.movies.current_page = data.meta.current_page;
        })
        .catch(() => {});
      this.loading = false;
    },
  },
};
</script>
