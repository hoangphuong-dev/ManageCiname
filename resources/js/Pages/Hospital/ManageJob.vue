<template>
  <app-layout v-loading="loading">
    <section class="JobManage my-8">
      <div class="block lg:flex">
        <div class="w-full lg:w-1/2 flex">
          <search-input :filter="filter" @submit="fetchData"></search-input>
          <button class="btn-primary ml-4" @click="$inertia.visit(route('hospital.jobs.create'))">+ 新規登録</button>
        </div>

        <div class="w-full lg:w-1/2 lg:text-right table-paginattion">
          <el-pagination
            :page-size="Number(pages.per_page)"
            :pager-count="5"
            layout="prev, pager, next"
            :total="Number(pages.total)"
            :current-page="filter.page || 1"
            :background="true"
            @current-change="handleCurrentChange"
          ></el-pagination>
        </div>
      </div>

      <div class="mt-6 px-4 pb-7 bg-white">
        <div v-for="(job, index) in jobs" :key="index" class="jop-item-wraper pt-6">
          <div class="flex">
            <div class="w-1/5 mr-5">
              <el-image
                v-if="job.images.length"
                class="w-full min-w-124 h-32 object-cove rounded"
                :src="job.images[0].url"
                alt=""
              ></el-image>
              <el-image v-else class="w-full min-w-124 h-32 object-cove rounded" src="" alt=""></el-image>
            </div>
            <div
              class="job-title w-3/5 hover:cursor-pointer"
              @click="$inertia.get(route('hospital.jobs.edit', job?.id))"
            >
              {{ job.name }}
            </div>
            <div class="w-2/5 text-right relative">
              <div class="job-time">応募日時: {{ formatDateTime(job.created_at) }}</div>
              <div
                class="job-status absolute bottom-0 right-0 rounded-100 py-2 px-4 bg-grayPrimary"
                :class="job.status_name == '公開中' ? 'text-bluePrimary' : 'text-lightGreen'"
              >
                {{ job.status_name }}
              </div>
            </div>
          </div>
          <hr class="w-full mt-6" />
        </div>
      </div>
    </section>
  </app-layout>
</template>

<script>
import SearchInput from '@/Components/Element/SearchInput.vue'
import AppLayout from '../../Layouts/AppLayout.vue'
import { reactive, ref } from 'vue'
import { listJob } from '@/API/job.js'
import { formatDateTime } from '@/libs/datetime'
export default {
  name: 'Manage',
  components: { SearchInput, AppLayout },
  setup() {
    const loading = ref(false)
    const jobs = ref([])
    const pages = ref([])
    const filter = reactive({
      page: 1,
      limit: 10,
    })

    const fetchData = () => {
      loading.value = true
      listJob(filter)
        .then(async (res) => {
          jobs.value = res.data.data
          pages.value = res.data.meta
        })
        .catch(() => {})
      loading.value = false
    }

    fetchData()

    const handleCurrentChange = (page) => {
      filter.page = page
      fetchData()
    }
    return { jobs, loading, pages, filter, fetchData, handleCurrentChange, formatDateTime }
  },
}
</script>

<style>
.table-paginattion .el-icon {
  display: flex !important;
  justify-content: center;
  align-items: center;
}
.table-paginattion .el-pager {
  display: inline-flex;
}
.table-paginattion .el-pager .number {
  background-color: white !important;
}
.table-paginattion .el-pager .active {
  color: #a5c242 !important;
  border: 1px solid #a5c242;
  border-radius: 4px;
}
</style>
