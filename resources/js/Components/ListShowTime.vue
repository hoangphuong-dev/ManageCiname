<template>
  <div class="p-4">
    <div class="w-full flex relative my-4">
      <div class="w-3/4 flex items-end">
        <div class="search">
          <el-input
            ref="search"
            placeholder="Tìm tên phim ... "
            clearable
            v-model="showtime.keyword"
            @keyup.enter="searchChange()"
          />
        </div>
      </div>
      <div class="w-1/4 text-right"></div>
    </div>

    <div v-if="showtime.data.length > 0" class="grid grid-cols-4 gap-4">
      <div
        class="border rounded-md p-4"
        v-for="item in showtime.data"
        :key="item.id"
      >
        <h2
          @click="detailShowTime(item)"
          class="text-center mb-2 cursor-pointer"
        >
          {{ item.name }}
        </h2>
        <img
          :src="
            'https://i3.ytimg.com/vi/' + videoId(item) + '/maxresdefault.jpg'
          "
        />

        <div class="w-full flex my-4">
          <div class="w-2/3">{{ item.day }}</div>
          <div class="w-1/3 flex text-right">
            <h3 class="text-red-400 mr-2">{{ item.sum_show_time }}</h3>
            suất chiếu
          </div>
        </div>
      </div>
    </div>
    <div v-else><el-empty description="Không có dữ liệu"></el-empty></div>
    <!-- phan trang suất chiếu  -->
    <div
      v-if="showtime.total > showtime.perPage"
      class="w-full justify-center my-16 flex"
    >
      <pagination
        v-model="showtime.current_page"
        @current-change="handleCurrentPage"
        :page-size="Number(showtime.perPage)"
        :total="Number(showtime.total)"
      />
    </div>
  </div>
</template>

<script>
import SearchInput from "@/Components/Element/SearchInput.vue";
import Pagination from "@/Components/Pagination.vue";
import { getYoutubeId } from "@/Helpers/youtube.js";
import { listScheduleByDay } from "@/API/main.js";
export default {
  name: "ComponentShowTime",
  components: {
    SearchInput,
    Pagination,
    Edit,
  },
  props: {
    cinema: {
      type: Object,
      required: true,
    },
    rooms: {
      type: Array,
      required: true,
    },
  },

  created() {
    this.fetchData();
  },
  data() {
    return {
      showTitle: false,

      showtime: {
        data: [],
        total: "",
        current_page: "",
        keyword: "",
        perPage: "",
        filter: {
          page: 1,
          limit: 10,
          cinema_id: this.cinema.id,
        },
      },
    };
  },
  methods: {
    detailShowTime(item) {
      Inertia.get(
        route("admin.view_detail_showtimes", {
          cinema_id: item.cinema_id,
          movie_id: item.movie_id,
          day: item.day,
        }),
        {},
        { onBefore, onFinish, preserveScroll: true }
      );
    },

    videoId(row) {
      return getYoutubeId(row);
    },

    handleCurrentPage(value) {
      this.showtime.filter.page = value;
      this.fetchData();
    },

    searchChange() {
      this.showtime.filter.name = this.showtime.keyword;
      this.fetchData();
    },

    async fetchData() {
      this.loading = true;
      listScheduleByDay(this.showtime.filter)
        .then(({ status, data }) => {
          this.showtime.data = status === 200 ? data.data : this.showtime.data;
          this.showtime.total = data.meta.total;
          this.showtime.perPage = data.meta.per_page;
          this.showtime.current_page = data.meta.current_page;
        })
        .catch(() => {});
      this.loading = false;
    },
  },
};
</script>
