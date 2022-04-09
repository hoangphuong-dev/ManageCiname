<template>
  <div class="w-full flex relative">
    <div class="w-11/12 flex items-end">
      <div class="search flex">
        <search-input :filter="filter" label="Tìm kiếm"></search-input>
      </div>
    </div>
    <div class="w-1/12 text-center">
      <el-button type="danger" @click="exchangePoint()">Đổi điểm</el-button>
    </div>
  </div>

  <div class="mt-5">
    <!-- datatable  -->
    <div class="mt-5">
      <data-table
        :fields="fields"
        :items="vouchers.data"
        :paginate="vouchers"
        :current-page="filter.page || 1"
        disable-table-info
        footer-center
        paginate-background
        enable-select-box
        @page="handleCurrentPage"
      >
        <template #created_at="{ row }">
          <div>{{ formatDateTime(row?.created_at) }}</div>
        </template>
        <template #expiration_date="{ row }">
          <div>{{ formatDateTime(row?.expiration_date) }}</div>
        </template>
        <template #status="{ row }">
          <div class="text-center">
            <el-button
              @click="copyCode(row?.code)"
              v-if="row?.status == 0"
              type="success"
              >Chưa dùng</el-button
            >
            <el-button v-if="row?.status == 1" type="danger"
              >Đã sử dụng
            </el-button>

            {{}}
          </div>
        </template>
      </data-table>

      <!-- dialog đổi điểm  -->

      <el-dialog title="Đổi điểm lấy voucher" v-model="dialogForm">
        <el-form
          class="text-center w-full"
          ref="formData"
          :model="formData"
          label-position="top"
          :rules="rules"
        >
          <div>
            <h2>Quy định đổi điểm</h2>
            <p>10000 points = 1 voucher(10 % tổng hóa đơn)</p>
            <p>20000 points = 1 voucher(20 % tổng hóa đơn)</p>
            <p>50000 points = 1 voucher(50 % tổng hóa đơn)</p>
            <br />
            <p>Bạn có thể sử dụng voucher để mua vé khi đã đăng nhập</p>
            <p>Sau khi nua vé => Nhập mã code của voucher .</p>
            <p>Bạn sẽ được chiết khấu vào tổng hóa đơn mua vé</p>
          </div>

          <h3>Số điểm khả dụng : {{ member_card.accumulating_point }}</h3>
          <!-- Nhập điểm quy đổi -->

          <el-form-item prop="chooseVoucher">
            <el-radio-group v-model="formData.chooseVoucher">
              <el-radio
                v-for="item in listVoucher"
                @click="vouchered(item)"
                :key="item.type"
                v-model="item.type"
                :label="item.type"
                :disabled="item.point > member_card.accumulating_point"
                >{{ item.title + item.need_point }}</el-radio
              >
              <br />
            </el-radio-group>
          </el-form-item>

          <!-- submit -->
          <div class="text-center">
            <el-button @click="onSubmit">Quy đổi</el-button>
          </div>
        </el-form>
      </el-dialog>
    </div>
  </div>
</template>

<script>
import SearchInput from "@/Components/Element/SearchInput.vue";
import { getYoutubeId } from "@/Helpers/youtube.js";
import { Inertia } from "@inertiajs/inertia";
import DataTable from "@/Components/DataTable.vue";
import { onBefore, onFinish } from "@/Uses/request-inertia";
import { detailBill } from "@/API/main.js";
import { formatDateTime } from "@/libs/datetime.js";
import { copyText } from "vue3-clipboard";
import { ref } from "vue";
import { ElMessage } from "element-plus";

export default {
  name: "ViewBillComponent",
  props: {
    vouchers: Object,
    member_card: Object,
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
      container: ref(null),
      dialogForm: false,
      bill_detail: "",
      filter: {
        page: 1,
        limit: 12,
      },
      listVoucher: [
        {
          point: 10000,
          type: 10,
          title: "Giảm 10 % tổng hóa đơn",
          need_point: " (Cần 1000 point)",
        },
        {
          point: 20000,
          type: 20,
          title: "Giảm 20 % tổng hóa đơn",
          need_point: " (Cần 2000 point)",
        },
        {
          point: 50000,
          type: 50,
          title: "Giảm 50 % tổng hóa đơn",
          need_point: " (Cần 5000 point)",
        },
      ],

      formData: {
        chooseVoucher: "",
        title: "",
      },
      rules: {
        chooseVoucher: [
          {
            required: true,
            message: "Voucher quy đổi chưa được chọn !",
            trigger: "change",
          },
        ],
      },

      fields: [
        { key: "created_at", label: "Thời gian tạo" },
        { key: "code", label: "Mã code", width: "150" },
        { key: "title", label: "Nội dung" },
        { key: "expiration_date", label: "Hạn sử dụng" },
        { key: "status", label: "Trạng thái" },
      ],
    };
  },
  methods: {
    copyCode(code) {
      copyText(code, undefined, (error, event) => {
        if (event) {
          ElMessage({
            showClose: true,
            message: "Copied",
            type: "success",
          });
        }
      });
    },
    exchangePoint() {
      this.dialogForm = true;
    },
    vouchered(item) {
      this.formData.title = item.title;
      this.formData.need_point = item.point;
    },

    async onSubmit() {
      this.$refs["formData"].validate((valid) => {
        if (valid) {
          Inertia.post(
            route("customer.exchange-point"),
            { ...this.formData },
            {
              onBefore,
              onFinish,
              preserveScroll: true,
              onError: (e) => console.log(e),
              onSuccess: (_) => {
                this.formData.chooseVoucher = "";
                this.dialogForm = !this.dialogForm;
              },
            }
          );
        }
      });
    },

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