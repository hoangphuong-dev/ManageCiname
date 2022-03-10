<template>
  <admin-layout>
    <template #main>
      <div class="bg-white min-h-full m-4 mb-0 p-4">
        <h2 class="mb-5">Hệ thống rạp</h2>
        <div class="w-full flex relative">
          <div class="w-3/4 flex items-end">
            <div class="search">
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
            v-for="item in master_cinemas"
            :key="item"
            class="border rounded-md p-4 cursor-pointer"
            @click="detail(item)"
          >
            <h2 class="text-center">{{ item.name }}</h2>
            <div>{{ item.count_cinema }} rạp</div>
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
  name: "AdminInfo",
  components: {
    AdminLayout,
    SearchInput,
    Pagination,
  },
  props: {
    master_cinemas: Object,
  },
  data() {
    return {
      loading: false,
      dialogVisible: false,
      total: "",
      perPage: "",
      keyword: "",
      admins: [],
      filter: {
        page: 1,
        limit: 10,
      },
    };
  },
  methods: {
    searchChange() {
      this.filter.name = this.keyword;
      this.$emit("handleFilter");
    },
    detail(province_id) {
      Inertia.get(
        route("superadmin.cinema.province", { province_id: province_id }),
        {},
        { onBefore, onFinish, preserveScroll: true }
      );
    },
  },
};
</script>
