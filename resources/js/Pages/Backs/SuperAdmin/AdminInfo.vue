<template>
  <admin-layout>
    <template #main>
      <div class="bg-white min-h-full m-4 mb-0 p-4">
        <div class="w-full flex relative my-10">
          <div class="w-3/4 flex items-end">
            <div class="search">
              <search-input label="Tìm kiếm"></search-input>
            </div>
          </div>
          <div class="w-1/4 text-right">
            <el-button>Thêm Admin</el-button>
          </div>
        </div>
        <div class="grid grid-cols-4 gap-4">
          <div
            v-for="index in 6"
            :key="index"
            class="border rounded-md p-4 cursor-pointer"
          >
            <h2 class="text-center">Thanh Hóa</h2>
            <div class="flex">
              <h3 class="w-1/2">Sở hữu :</h3>
              <div>Hoàng Phương</div>
            </div>
            <div class="flex">
              <h3 class="w-1/2">Rạp :</h3>
              <div>10 rạp</div>
            </div>
            <div class="flex">
              <h3 class="w-1/2">Phòng :</h3>
              <div>105 phòng</div>
            </div>
          </div>
        </div>
        <!-- phan trang  -->
        <div class="w-full justify-center my-10">
          <pagination :page-size="5" :total="25" />
        </div>
      </div>
    </template>
  </admin-layout>
</template>

<script>
import AdminLayout from "@/Layouts/Admin/AdminLayout.vue";
import SearchInput from "@/Components/Element/SearchInput.vue";
import Pagination from "@/Components/Pagination.vue";
export default {
  name: "HomeStaff",
  components: {
    AdminLayout,
    SearchInput,
    Pagination,
  },
  data() {
    return {};
  },
  methods: {},
};
</script>
