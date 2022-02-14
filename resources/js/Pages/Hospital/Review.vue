<template>
  <app-layout title="Dashboard">
    <div class="py-12">
      <div class="mx-auto messenger-window__custom">
        <div class="w-full">
          <div class="block lg:flex mb-5">
            <div class="w-full lg:w-1/2 flex">
              <search-input :filter="filter" @submit="fetchData"></search-input>
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

          <div class="mb-5 text-base font-bold">{{ pages.total }}件</div>
          <div class="main-jobs">
            <hospital-job-review v-for="(job, indexJob) in jobs" :key="indexJob" :job="job" :indexJob="indexJob" />
          </div>
        </div>
      </div>
    </div>
  </app-layout>
</template>

<script>
import HospitalJobReview from '@/Components/Job/HospitalJobReview.vue'
import SearchInput from '@/Components/Element/SearchInput.vue'
import { listJob } from '@/API/job.js'

export default {
  name: 'Review',
  components: { HospitalJobReview, SearchInput },
  created() {
    this.fetchData()
  },
  data: function () {
    return {
      jobs: [],
      loading: false,
      pages: '',
      filter: {
        page: 1,
        limit: 10,
      },
    }
  },
  methods: {
    handleCurrentPage(value) {
      this.filter.page = value
      this.fetchData()
    },
    async fetchData() {
      this.loading = true
      await listJob(this.filter)
        .then(async (res) => {
          this.jobs = res.data.data
          this.pages = res.data.meta
        })
        .catch(() => {})
      this.loading = false
    },
    handleCurrentChange(page) {
      this.filter.page = page
      this.fetchData()
    },
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
