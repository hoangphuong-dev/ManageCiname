<template>
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
            <el-button size="small" @click="detailBill(row?.id)" type="danger">
              Xem chi tiết
            </el-button>
          </div>
        </template>
      </data-table>
    </div>
  </div>
</template>

<script>
import SearchInput from "@/Components/Element/SearchInput.vue";
import DataTable from "@/Components/DataTable.vue";
export default {
  name: "ViewBillComponent",
  props: {
    bills: Object,
  },
  components: {
    SearchInput,
    DataTable,
  },
  data() {
    return {
      filter: {
        page: 1,
        limit: 12,
      },
      fields: [
        { key: "id", label: "Mã hoa don", width: "120" },
        { key: "name", label: "Tên người đặt" },
        { key: "phone", label: "Số điện thoại" },
        { key: "email", label: "Email" },
        { key: "total_money", label: "Tổng tiền" },
        { key: "action", label: "Thao tác" },
      ],
    };
  },
  methods: {
    handleCurrentPage() {
      return 1;
    },
  },
};
</script>