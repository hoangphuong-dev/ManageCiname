<template>
  <admin-layout v-loading="loading">
    <template #main>
      <div class="bg-white min-h-full m-4 mb-0 p-4">
        <h2 class="mb-5">お問合せ一覧</h2>

        <div class="flex mt-10">
          <div
            class="mr-11 hover:cursor-pointer hover:text-lightGreen"
            :class="{ 'tab-active': filter.type === CONTACT_TYPE_HOSPITAL }"
            @click.prevent="handleShowTab(CONTACT_TYPE_HOSPITAL)"
          >
            病院
          </div>
          <div
            class="hover:cursor-pointer hover:text-lightGreen"
            :class="{ 'tab-active': filter.type === CONTACT_TYPE_CARETAKER }"
            @click.prevent="handleShowTab(CONTACT_TYPE_CARETAKER)"
          >
            求職者
          </div>
        </div>
        <hr class="w-full border-t-2 -mt-0.5 mb-9" />

        <div class="w-full flex relative">
          <div class="w-3/4 flex items-end">
            <div class="mr-2">
              <div class="text-sm text-blackPrimary-300">閲覧ステータス</div>
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
        </div>

        <div class="mt-5">
          <data-table
            :fields="fields"
            :items="contacts.data"
            :paginate="contacts.meta"
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
            <template #question_content="{ row }">
              {{ row?.question_content.substring(0, 25).concat("...") }}
            </template>
            <template #status="{ row }">
              <p
                class="
                  py-2
                  px-5
                  w-max
                  min-w-1/2
                  rounded-100
                  text-white text-center
                "
                :class="[
                  row?.status === CONTACT_STATUS_UNREAD
                    ? 'bg-lightGreen'
                    : 'bg-blackPrimary-100',
                ]"
              >
                {{ row?.status_name }}
              </p>
            </template>
            <template #actions="{ row }">
              <div v-if="row" class="flex items-center">
                <button
                  class="py-2 px-4 rounded bg-blackPrimary-100"
                  @click="handleDelete(row)"
                >
                  <img src="/images/svg/delete.svg" alt="" />
                </button>
                <button
                  class="ml-4 py-2 px-4 rounded bg-yellowPrimary"
                  @click="$inertia.get(route('back.contacts.detail', row?.id))"
                >
                  詳細
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
import { CONTACT_STATUS_UNREAD, CONTACT_STATUS_READ } from "@/store/const.js";
import { formatDateTime } from "@/libs/datetime";

import { ref } from "vue";
import { listContact, deleteContact } from "@/API/contact.js";
import {
  CONTACT_TYPE_HOSPITAL,
  CONTACT_TYPE_CARETAKER,
} from "@/store/const.js";

export default {
  name: "Contact",
  components: {
    AdminLayout,
    SearchInput,
    DataTable,
  },
  data() {
    return {
      loading: false,
      dialogVisible: false,
      contacts: [],
      CONTACT_TYPE_HOSPITAL: CONTACT_TYPE_HOSPITAL,
      CONTACT_TYPE_CARETAKER: CONTACT_TYPE_CARETAKER,
      contacts: [],
      filter: {
        page: 1,
        limit: 10,
        status: "",
        type: CONTACT_TYPE_HOSPITAL,
      },
      statusList: [
        {
          value: "",
          label: "ALl",
        },
        {
          value: CONTACT_STATUS_UNREAD,
          label: "New",
        },
        {
          value: CONTACT_STATUS_READ,
          label: "Readed",
        },
      ],
      CONTACT_STATUS_UNREAD: CONTACT_STATUS_UNREAD,
      CONTACT_STATUS_READ: CONTACT_STATUS_READ,
      fields: [
        { key: "name", label: "病院", width: 250 },
        { key: "id", label: "ID", width: 100 },
        { key: "created_at", label: "送信日", width: 200 },
        { key: "question_content", label: "タイトル", width: 500 },
        { key: "status", label: "閲覧ステータス", width: 200 },
        { key: "actions", label: "アクション", width: 300 },
      ],
    };
  },
  created() {
    this.fetchData();
  },
  methods: {
    handleShowTab(value) {
      this.filter.type = value;
      this.fetchData();
    },
    handleCurrentPage(value) {
      this.filter.page = value;
      this.fetchData();
    },
    async fetchData() {
      this.loading = true;
      listContact(this.filter)
        .then(({ status, data }) => {
          this.contacts = status === 200 ? data : this.contacts;
        })
        .catch(() => {
          this.$message.error("Server Error");
        });
      this.loading = false;
    },
    formatDateTime,
    async handleDelete(item) {
      this.$confirm("Are you sure to delete this contact?", "Warning", {
        confirmButtonText: "OK",
        cancelButtonText: "Cancel",
        type: "warning",
      }).then(async () => {
        this.loading = true;
        await deleteContact(item.id)
          .then(async (res) => {
            this.fetchData();
            this.$message.success("Delete completed");
          })
          .catch(() => {
            this.$message.error("Server Error");
          });
        this.loading = false;
      });
    },
  },
};
</script>
<style scoped>
.tab-active {
  font-weight: bold;
  font-size: 1rem;
  line-height: 1.625rem;
  color: #a5c242;
  border-bottom: 2px solid #a5c242;
}
</style>
