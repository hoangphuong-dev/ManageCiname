<template>
  <div class="w-full flex relative">
    <div class="w-3/4 flex items-end">
      <div class="search">
        <search-input :filter="filter" label="Tìm kiếm"></search-input>
      </div>
    </div>
  </div>

  <div style="min-height: 500px" class="mt-5">
    <!-- datatable  -->
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

      <template #created_at="{ row }">
        <div>{{ formatDateTime(row?.created_at) }}</div>
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

    <!-- chi tiết hóa đơn  -->
    <el-dialog title="Chi tiết hóa đơn" v-model="dialogForm">
      <!-- Thông tin phim -->
      <div class="w-full shadow-lg p-4 my-6">
        <h2>Thông tin phim</h2>
        <div class="flex mt-6">
          <div class="w-2/3">
            <div class="w-full flex">
              <div class="w-1/3 border-dashed border-2 p-1 border-b-0">
                Tên phim
              </div>
              <div
                class="w-2/3 border-dashed border-2 p-1 border-b-0 border-l-0"
              >
                {{ bill_detail.bill?.showtime?.movie.name }}
              </div>
            </div>
            <div class="w-full flex">
              <div class="w-1/3 border-dashed border-2 p-1 border-b-0">
                Đạo diễn
              </div>
              <div
                class="w-2/3 border-dashed border-2 p-1 border-b-0 border-l-0"
              >
                {{ bill_detail.bill?.showtime?.movie.director }}
              </div>
            </div>
            <div class="w-full flex">
              <div class="w-1/3 border-dashed border-2 p-1 border-b-0">
                Thời lượng
              </div>
              <div
                class="w-2/3 border-dashed border-2 p-1 border-b-0 border-l-0"
              >
                {{ bill_detail.bill?.showtime?.movie.movie_length }} phút
              </div>
            </div>
            <div class="w-full flex">
              <div class="w-1/3 border-dashed border-2 p-1 border-b-0">
                Rated
              </div>
              <div
                class="w-2/3 border-dashed border-2 p-1 border-b-0 border-l-0"
              >
                Cấm trẻ dưới {{ bill_detail.bill?.showtime?.movie.rated }} tuổi
              </div>
            </div>
            <div class="w-full flex">
              <div class="w-1/3 border-dashed border-2 p-1">Thể loại</div>
              <div class="w-2/3 border-dashed border-2 p-1 border-l-0">
                Hài hước , ngôn tình
              </div>
            </div>
          </div>
          <div class="w-1/3">
            <img
              class="rounded"
              :src="
                'https://i3.ytimg.com/vi/' +
                videoId(bill_detail.bill?.showtime?.movie) +
                '/maxresdefault.jpg'
              "
            />
          </div>
        </div>
      </div>
      <!-- end thông tin phim  -->

      <!-- Thông tin suất chiếu  -->
      <div class="w-full shadow-lg p-4 mb-6 mt-10">
        <h2 class="mb-4">Thông tin suất chiếu</h2>

        <div class="flex">
          <!-- thông tin suất chiếu  -->
          <div class="w-1/2 mr-32">
            <h3>Suất chiếu</h3>
            <div class="w-full flex">
              <div class="w-1/3 border-dashed border-2 p-2 border-b-0">
                Ngày chiếu
              </div>
              <div
                class="w-2/3 border-dashed border-2 p-2 border-b-0 border-l-0"
              >
                <h3>
                  {{ bill_detail.bill?.showtime?.time_start.substr(0, 10) }}
                </h3>
              </div>
            </div>
            <div class="w-full flex">
              <div class="w-1/3 border-dashed border-2 p-2 border-b-0">
                Giờ bắt đầu
              </div>
              <div
                class="w-2/3 border-dashed border-2 p-2 border-b-0 border-l-0"
              >
                <h3>
                  {{ bill_detail.bill?.showtime?.time_start.substr(10, 6) }}
                </h3>
              </div>
            </div>
            <div class="w-full flex">
              <div class="w-1/3 border-dashed border-2 p-2">Giờ kết thúc</div>
              <div class="w-2/3 border-dashed border-2 p-2 border-l-0">
                <h3>
                  {{ bill_detail.bill?.showtime?.time_end.substr(10, 6) }}
                </h3>
              </div>
            </div>
          </div>
          <!-- end thông tin suất chiếu -->

          <!-- thông tin phòng chiếu  -->
          <div class="w-1/2">
            <h3>Thông tin phòng</h3>
            <div class="w-full flex">
              <div class="w-1/3 border-dashed border-2 p-2 border-b-0">
                Phòng chiếu
              </div>
              <div
                class="w-2/3 border-dashed border-2 p-2 border-b-0 border-l-0"
              >
                <h3>{{ bill_detail.bill?.showtime?.room.name }}</h3>
              </div>
            </div>

            <div class="w-full flex">
              <div class="w-1/3 border-dashed border-2 p-2">Ghế đã chọn</div>
              <div class="w-2/3 border-dashed border-2 p-2 border-l-0">
                <p v-for="item in bill_detail?.tickets" :key="item.id">
                  {{ item?.seat?.row_name + item?.seat?.columns_number }}
                  <span>({{ item?.seat?.seat_type.name }} )</span>
                </p>
              </div>
            </div>
          </div>
          <!-- end thông tin phòng chiếu -->
        </div>
      </div>
      <!-- end thông tin suất chiếu  -->
    </el-dialog>
  </div>
</template>

<script>
import SearchInput from "@/Components/Element/SearchInput.vue";
import { getYoutubeId } from "@/Helpers/youtube.js";
import DataTable from "@/Components/DataTable.vue";
import { formatDateTime } from "@/libs/datetime.js";
import { detailBill } from "@/API/main.js";
export default {
  name: "ViewBillComponent",
  props: {
    bills: Object,
  },
  components: {
    SearchInput,
    DataTable,
  },
  setup() {
    return {
      formatDateTime,
    };
  },

  data() {
    return {
      dialogForm: false,
      bill_detail: "",
      filter: {
        page: 1,
        limit: 12,
      },
      fields: [
        { key: "id", label: "Mã hóa đơn", width: "120" },
        { key: "created_at", label: "Ngày tạo" },
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

    videoId(row) {
      return getYoutubeId(row);
    },
    async detailBill(id) {
      this.dialogForm = true;

      detailBill(id)
        .then(({ data }) => {
          this.bill_detail = data;
        })
        .catch(() => {});
      this.loading = false;
    },
  },
};
</script>