<template>
  <admin-layout v-loading="loading">
    <template #main>
      <div class="bg-white min-h-full m-4 mb-0 p-4">
        <h2 class="mb-5">病院一覧</h2>

        <div class="w-full flex relative items-end">
          <div class="w-full lg:w-auto mr-2">
            <div class="text-sm text-blackPrimary-300">ステータス</div>
            <el-select
              v-model="filter.status"
              @change="fetchData"
              placeholder="Select"
            >
              <el-option
                v-for="item in statusList"
                :key="item.value"
                :label="item.label"
                :value="item.value"
              ></el-option>
            </el-select>
          </div>
          <div class="search">
            <search-input
              :filter="filter"
              @submit="fetchData"
              label="検索"
            ></search-input>
          </div>
        </div>

        <div class="mt-5">
          <data-table
            :fields="fields"
            :items="hospitals.data"
            :paginate="hospitals.meta"
            :current-page="filter.page || 1"
            disable-table-info
            footer-center
            paginate-background
            enable-select-box
            @page="handleCurrentPage"
          >
            <template #created_at="{ row }">
              <p>{{ formatDateTime(row?.created_at) }}</p>
            </template>
            <template #status="{ row }">
              <p
                class="
                  py-2
                  px-5
                  w-max
                  min-w-132
                  rounded-100
                  text-white text-center
                "
                :class="[
                  row?.status === HOSPITAL_STATUS_DONE
                    ? 'bg-lightGreen'
                    : row?.status === HOSPITAL_STATUS_DEACTIVE
                    ? 'bg-redPrimary'
                    : 'bg-yellowPrimary',
                ]"
              >
                {{ row?.status_name }}
              </p>
            </template>
            <template #actions="{ row }">
              <div v-if="row" class="flex items-center">
                <el-switch
                  v-model="row.status_switch"
                  :active-value="HOSPITAL_STATUS_DONE"
                  :inactive-value="HOSPITAL_STATUS_DEACTIVE"
                  active-color="#a5c242"
                  inactive-color="#cccccc"
                  @change="updateStatus(row, $event)"
                />
                <button
                  class="ml-4 py-2 px-4 rounded bg-yellowPrimary"
                  @click="row.id"
                >
                  詳細
                </button>
                <button
                  v-if="row.status == HOSPITAL_STATUS_PENDING"
                  class="ml-4 py-2 px-4 rounded bg-lightGreen"
                  @click="handleSendLoginInfo(row)"
                >
                  Submit login information
                </button>
              </div>
            </template>
          </data-table>
        </div>
      </div>
    </template>
  </admin-layout>
</template>

<script>
import AdminLayout from "@/Layouts/Admin/AdminLayout.vue";
import SearchInput from "@/Components/Element/SearchInput.vue";
import DataTable from "@/Components/DataTable.vue";
import {
  HOSPITAL_STATUS_DEACTIVE,
  HOSPITAL_STATUS_DONE,
  HOSPITAL_STATUS_PENDING,
} from "@/store/const.js";
import { formatDateTime } from "@/libs/datetime";
import { h } from "vue";
import { ElLoading } from "element-plus";

export default {
  name: "HospitalList",
  components: {
    AdminLayout,
    SearchInput,
    DataTable,
  },
  data() {
    return {
      loading: false,
      dialogVisible: false,
      hospitals: [],
      filter: {
        page: 1,
        limit: 10,
        status: "",
      },
      statusList: [
        {
          value: "",
          label: "全て",
        },
        {
          value: HOSPITAL_STATUS_DONE,
          label: "使用中",
        },
        {
          value: HOSPITAL_STATUS_PENDING,
          label: "承認待ち",
        },
        {
          value: HOSPITAL_STATUS_DEACTIVE,
          label: "中止",
        },
      ],
      HOSPITAL_STATUS_DEACTIVE: HOSPITAL_STATUS_DEACTIVE,
      HOSPITAL_STATUS_DONE: HOSPITAL_STATUS_DONE,
      HOSPITAL_STATUS_PENDING: HOSPITAL_STATUS_PENDING,
      fields: [
        { key: "name", label: "病院名", width: 250 },
        { key: "id", label: "ID", width: 100 },
        { key: "email", label: "登録メール", width: 250 },
        { key: "created_at", label: "登録日", width: 200 },
        { key: "status", label: "ステータス", width: 200 },
        { key: "actions", label: "アクション", width: 470 },
      ],
    };
  },
  created() {
    this.fetchData();
  },
  methods: {
    handleClose() {},
    openCreateUser() {
      this.dialogVisible = !this.dialogVisible;
    },
    handleCurrentPage(value) {
      this.filter.page = value;
      this.fetchData();
    },
    async fetchData() {
      this.loading = true;
      await this.axios
        .get(`hospitals`, { params: this.filter })
        .then(async (res) => {
          this.hospitals = res.data;
        })
        .catch(() => {
          this.$message.error("Server Error");
        });
      this.loading = false;
    },
    formatDateTime,
    async handleUpdateStatus(item, status) {
      if (item.id) {
        this.$confirm(
          `Bạn có chắc chắn thay đổi trạng thái phòng `,
          "Cảnh báo",
          {
            confirmButtonText: "Chắc chắn",
            cancelButtonText: "Hủy",
            type: "warning",
          }
        )
          .then(async () => {
            this.loading = true;
            await updateStatus(item.id, status)
              .then(async (res) => {
                this.fetchData();
                this.$message.success("Cập nhật trạng thái thành công !");
              })
              .catch(() => {
                this.fetchData();
                this.$message.error("Có lỗi trong quá trình thực thi");
              });
            this.loading = false;
          })
          .catch(() => {
            this.fetchData();
          });
      }
    },

    async handleSendLoginInfo(hospital) {
      const state = await this.$shortConfirm(
        h("p", null, [
          h(
            "span",
            null,
            "Are you sure you want to submit your account information for this store?"
          ),
          h(
            "i",
            { style: "color: teal" },
            `(${hospital.name})(${hospital.email})`
          ),
        ])
      );
      if (!state) {
        return;
      }
      this.$inertia.post(route("back.hospitals.sendLoginInfo"), {
        id: hospital.id,
      });
    },
  },
};
</script>
