<template>
  <admin-layout v-loading="loading">
    <template #main>
      <div class="bg-white min-h-full m-4 mb-0 p-4">
        <h2 class="mb-5">求職者管理</h2>

        <div class="w-full flex relative items-end">
          <div class="w-full lg:w-auto mr-2">
            <div class="text-sm text-blackPrimary-300">ステータス</div>
            <el-select v-model="filter.status" @change="fetchData" placeholder="Select">
              <el-option
                v-for="item in statusList"
                :key="item.value"
                :label="item.label"
                :value="item.value"
              ></el-option>
            </el-select>
          </div>
          <div class="search">
            <search-input :filter="filter" @submit="fetchData" label="検索"></search-input>
          </div>
        </div>

        <div class="mt-5">
          <data-table
            :fields="fields"
            :items="users.data"
            :paginate="users.meta"
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
                class="py-2 px-5 w-max min-w-132 rounded-100 text-white text-center"
                :class="[
                  row?.status === ACCOUNT_STATUS_DONE
                    ? 'bg-lightGreen'
                    : row?.status === ACCOUNT_STATUS_SUSPEND
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
                  :active-value="ACCOUNT_STATUS_DONE"
                  :inactive-value="ACCOUNT_STATUS_SUSPEND"
                  active-color="#a5c242"
                  inactive-color="#cccccc"
                  @change="updateStatus(row, $event)"
                />
                <button class="ml-4 py-2 px-4 rounded bg-yellowPrimary" @click="row.id">詳細</button>
              </div>
            </template>
          </data-table>
        </div>
      </div>
    </template>
  </admin-layout>
</template>

<script>
import AdminLayout from '@/Layouts/Admin/AdminLayout.vue'
import SearchInput from '@/Components/Element/SearchInput.vue'
import DataTable from '@/Components/DataTable.vue'
import { CARETAKER_STATUS_PENDING, ACCOUNT_STATUS_DONE, ACCOUNT_STATUS_SUSPEND } from '@/store/const.js'
import { formatDateTime } from '@/libs/datetime'
import { listUser, updateStatus } from '@/API/user.js'
export default {
  name: 'HospitalList',
  components: {
    AdminLayout,
    SearchInput,
    DataTable,
  },
  data() {
    return {
      loading: false,
      dialogVisible: false,
      users: [],
      filter: {
        page: 1,
        limit: 10,
        status: '',
      },
      statusList: [
        {
          value: '',
          label: '全て',
        },
        {
          value: ACCOUNT_STATUS_DONE,
          label: '使用中',
        },
        {
          value: ACCOUNT_STATUS_SUSPEND,
          label: '中止',
        },
      ],
      CARETAKER_STATUS_PENDING: CARETAKER_STATUS_PENDING,
      ACCOUNT_STATUS_DONE: ACCOUNT_STATUS_DONE,
      ACCOUNT_STATUS_SUSPEND: ACCOUNT_STATUS_SUSPEND,
      fields: [
        { key: 'name', label: '病院名', width: 250 },
        { key: 'id', label: 'ID', width: 100 },
        { key: 'email', label: '登録メール', width: 250 },
        { key: 'created_at', label: '登録日', width: 200 },
        { key: 'status', label: 'ステータス', width: 200 },
        { key: 'actions', label: 'アクション', width: 470 },
      ],
    }
  },
  created() {
    this.fetchData()
  },
  methods: {
    handleClose() {},
    openCreateUser() {
      this.dialogVisible = !this.dialogVisible
    },
    handleCurrentPage(value) {
      this.filter.page = value
      this.fetchData()
    },
    async fetchData() {
      this.loading = true
      await listUser(this.filter)
        .then(async (res) => {
          this.users = res.data
        })
        .catch(() => {
          this.$message.error('Server Error')
        })
      this.loading = false
    },
    formatDateTime,
    async updateStatus(row, status) {
      if (row.id) {
        this.loading = true
        await updateStatus(row.id, status)
          .then(async (res) => {
            this.$message.success('Update success')
          })
          .catch(() => {
            this.$message.error('Update Error')
          })
        this.loading = false
        this.fetchData()
      }
    },
  },
}
</script>
