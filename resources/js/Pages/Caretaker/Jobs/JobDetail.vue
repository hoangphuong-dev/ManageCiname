<template>
  <app-layout title="Dashboard">
    <div class="py-12">
      <div
        class="text-yellow-500 text-sm mb-4 hover:cursor-pointer"
        @click="goBack()"
      >
        &#60; 戻る
      </div>
      <div class="mx-auto job-detail">
        <div class="lg:flex">
          <job-detail :job="job"></job-detail>

          <!-- job related -->
          <div class="lg:w-3/12 bg-white shadow-xl px-2 py-2 lg:ml-4 h-fit">
            <h2 class="title-job-related mb-4">関連求人</h2>

            <div
              class="flex job-related py-2 cursor-pointer"
              v-for="(item, indexJob) in job_relateds"
              :key="indexJob"
              @click="$inertia.get(route('caretaker.job_detail', item.id))"
            >
              <div class="lg:w-2/6 rounded w-28 h-28 md:h-24">
                <img
                  class="w-full h-full object-cover rounded"
                  :src="getImage(item?.images[0].path)"
                />
              </div>
              <div class="w-4/6 pl-2">{{ item.name }} {{ item.id }}</div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout.vue";
import JobDetail from "@/Components/Job/JobDetail.vue";
export default {
  components: { AppLayout, JobDetail },
  props: {
    job: Object,
    job_relateds: Object,
  },
  methods: {
    goBack() {
      window.history.go(-1);
    },
  },
};
</script>

<style scoped>
.title-job-related {
  font-style: normal;
  font-weight: bold;
  font-size: 24px;
  line-height: 32px;
  align-items: center;
  color: #a5c242;
}
.job-related {
  border-bottom: 1px solid #cccccc;
}
.center {
  text-align: center;
}
</style>
