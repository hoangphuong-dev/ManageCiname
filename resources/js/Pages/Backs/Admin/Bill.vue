   <template #main>
  <div class="bg-gray-100 min-h-full m-4 mb-0 p-4 w-11/12">
    <h2 class="mb-5">Màn Bill</h2>

    <h2 class="mb-5">Quản lý Phim</h2>
    <div class="w-full flex relative">
      <div class="w-3/4 flex items-end">
        <div class="search">
          <search-input
            :filter="filter"
            @submit="fetchData"
            label="Tìm kiếm"
          ></search-input>
        </div>

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
          </data-table>
        </div>
      </div>
    </div>
  </div>
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
      loading: false,
      fields: [
        { key: "image", label: "Ảnh", width: "300" },
        { key: "name", label: "Tên phim" },
        { key: "director", label: "Đạo diễn" },
        { key: "rated", label: "Giới hạn độ tuổi" },
        { key: "status", label: "Trạng thái" },
        { key: "action", label: "Thao tác" },
      ],
    };
  },
  methods: {},
};
</script>
