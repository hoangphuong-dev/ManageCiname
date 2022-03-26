<template>
  <admin-layout v-loading="loading">
    <template #main>
      <div class="bg-white min-h-full m-4 mb-0 p-4">
        <h2 class="mb-5">Quản lý hoa don</h2>
        <div class="w-full flex relative">
          <div class="w-3/4 flex items-end">
            <div class="search">
              <search-input :filter="filter" label="Tìm kiếm"></search-input>
            </div>
          </div>
        </div>

        <div class="mt-5">
          <!-- datatable  -->
          <div class="mt-5">
            <data-table
              :fields="fields"
              :items="bills.data"
              :paginate="bills.meta"
              :current-page="filter.page || 1"
              disable-table-info
              footer-center
              paginate-background
              enable-select-box
              @page="handleCurrentPage"
            >
              <template #name="{ row }">
                <div>{{ row?.user.name }}</div>
              </template>

              <template #phone="{ row }">
                <div>{{ row?.user.phone }}</div>
              </template>

              <template #email="{ row }">
                <div>{{ row?.user.email }}</div>
              </template>

              <template #total_money="{ row }">
                <div>{{ row?.total_money }} VNĐ</div>
              </template>

              <template #action="{ row }">
                <div>
                  <el-button
                    size="small"
                    @click="detailBill(row?.id)"
                    type="danger"
                  >
                    Xem chi tiết
                  </el-button>
                </div>
              </template>
            </data-table>
          </div>
        </div>
      </div>
    </template>
  </admin-layout>
</template>

<script>
import AdminLayout from "@/Layouts/Admin/AdminLayout.vue";
import SearchInput from "@/Components/Element/SearchInput.vue";
import DataTable from "@/Components/DataTable.vue";
export default {
  name: "BillAdmin",
  props: {
    bills: Object,
  },
  components: {
    AdminLayout,
    SearchInput,
    DataTable,
  },
  data() {
    return {
      filter: {
        page: 1,
        limit: 12,
      },
      loading: false,
      fields: [
        { key: "id", label: "Mã đơn hàng", width: "120" },
        { key: "name", label: "Tên người đặt" },
        { key: "phone", label: "Số điện thoại" },
        { key: "email", label: "Email" },
        { key: "total_money", label: "Tổng tiền" },
        { key: "action", label: "Thao tác" },
      ],
    };
  },
  methods: {},
};
</script>
