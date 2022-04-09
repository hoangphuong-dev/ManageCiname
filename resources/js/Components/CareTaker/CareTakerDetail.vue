<template>
  <section class="CareTakerInfo flex my-8">
    <div class="w-3/4 bg-white px-6 py-7">
      <div class="flex mb-5">
        <div class="w-1/2 flex items-center text-yellowPrimary">
          <div class="text-blackPrimary-500 mr-4">東龍太郎</div>
          <div class="rounded p-1 mr-2 bg-grayPrimary">
            ID:{{ caretaker.id }}
          </div>
          <div class="rounded p-1 mr-2 bg-grayPrimary">
            {{ caretakerData?.user_info?.age }}歳
          </div>
          <div class="rounded p-1 bg-grayPrimary">
            {{ caretakerData?.user_info?.gender }}
          </div>
        </div>
        <div class="w-1/2 flex item-center justify-end">
          <div class="btn-primary mr-4">連絡する</div>
          <div
            class="
              w-10
              h-10
              p-2.5
              bg-lightGreen
              rounded-full
              relative
              flex
              justify-center
            "
          >
            <el-image src="/images/svg/chat.svg"></el-image>
            <span
              class="w-4 h-4 bg-redPrimary absolute -top-1 right-0 rounded-full"
            ></span>
          </div>
        </div>
      </div>

      <care-taker-info-table :caretaker="caretakerData"></care-taker-info-table>
      <hr class="w-full mt-6" />

      <div>
        <div class="mb-3 mt-4">求人詳細</div>
        <p v-html="caretakerData?.user_info?.pr_myself"></p>
      </div>

      <div class="mt-4 border border-grayBorder">
        <div class="flex flex-wrap min-h-64 border-b-gray">
          <h3 class="w-1/5 px-3 bg-grayPrimary flex items-center">氏名</h3>
          <div class="w-4/5 flex px-3 items-center">
            {{ caretakerData?.name }}
          </div>
        </div>
        <div class="flex flex-wrap min-h-64 border-b-gray">
          <h3 class="w-1/5 px-3 bg-grayPrimary flex items-center">生年月日</h3>
          <div class="w-4/5 flex px-3 items-center">
            {{ caretakerData?.user_info?.birthday }}
          </div>
        </div>
        <div class="flex flex-wrap min-h-64 border-b-gray">
          <h3 class="w-1/5 px-3 bg-grayPrimary flex items-center">現住所</h3>
          <div class="w-4/5 flex px-3 items-center">
            {{ caretakerData?.user_info?.address }}
          </div>
        </div>
        <div class="flex flex-wrap min-h-64 border-b-gray">
          <h3 class="w-1/5 px-3 bg-grayPrimary flex items-center">
            現住所以外に連絡を希望する場合の住所
          </h3>
          <div class="w-4/5 flex px-3 items-center">
            {{ caretakerData?.user_info?.address_other }}
          </div>
        </div>
        <div class="flex flex-wrap min-h-64 border-b-gray">
          <h3 class="w-1/5 px-3 bg-grayPrimary flex items-center">学歴</h3>
          <div class="w-4/5 flex px-3 items-center">
            <span
              v-for="(education, index) in caretakerData?.educations"
              :key="index"
            >
              {{ education.name }}
            </span>
          </div>
        </div>
        <div class="flex flex-wrap min-h-64 border-b-gray">
          <h3 class="w-1/5 px-3 bg-grayPrimary flex items-center">職歴</h3>
          <div class="w-4/5 flex px-3 items-center">
            <span
              v-for="(experience, index) in caretakerData?.experiences"
              :key="index"
            >
              {{ experience.name }}
            </span>
          </div>
        </div>
        <div class="flex flex-wrap min-h-64 border-b-gray">
          <h3 class="w-1/5 px-3 bg-grayPrimary flex items-center">
            免許・資格（取得予定資格を含む）
          </h3>
          <div class="w-4/5 flex px-3 items-center">
            <span
              v-for="(qualification, index) in caretakerData?.qualifications"
              :key="index"
            >
              {{ qualification.name }}
            </span>
          </div>
        </div>
        <div class="flex flex-wrap min-h-64 border-b-gray">
          <h3 class="w-1/5 px-3 bg-grayPrimary flex items-center">
            健康状態※選択式
          </h3>
          <div class="w-4/5 flex px-3 items-center">
            {{ caretakerData?.user_info?.health_detail }}
          </div>
        </div>
      </div>

      <div class="timeline mt-10">
        <h3 class="mb-7">選考管理</h3>

        <div v-for="(item, i) in processes" :key="i" class="flex timeline-step">
          <div class="mr-6 relative">
            <div class="step-line h-full w-6 flex items-center justify-center">
              <div class="h-full w-1 mt-2 bg-blackPrimary-200"></div>
            </div>
            <div
              class="
                w-4
                h-4
                absolute
                top-1
                ml-1
                rounded-full
                bg-white
                shadow
                text-center
                border border-solid border-blackPrimary-200
              "
            ></div>
          </div>
          <div class="text-blackPrimary-500 mb-6">
            <h4
              :style="{
                color: getStatusProcess(item.id) !== 3 ? '#1f1f1f' : '#bcbcbc',
              }"
              class="border-none"
            >
              Step {{ i + 1 }}
            </h4>
            <div class="flex">
              <div
                class="w-52 rounded py-2 px-4"
                :class="getClassProcess(item.id)"
              >
                {{ item.content }}
              </div>
              <template v-if="getStatusProcess(item.id) === 0">
                <button
                  class="ml-5 btn-success"
                  @click="onDoneProcess(item.id)"
                >
                  合格
                </button>
                <button
                  class="ml-2 btn-warning"
                  @click="onRejectProcess(item.id)"
                >
                  不合格
                </button>
              </template>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="w-1/4 ml-5 bg-white p-4">
      <h2 class="mb-4 text-lightGreen">関連求職者</h2>
      <p>
        Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod
        tempor incididun
      </p>
      <hr class="w-full mt-3 mb-5" />

      <div
        v-for="(item, i) in [1, 2, 3, 4, 5]"
        :key="i"
        class="candidate-related"
      >
        <div class="flex">
          <div class="w-24">
            <img
              class="h-full w-full"
              src="https://via.placeholder.com/96x96"
              alt=""
            />
          </div>
          <div class="ml-4">
            <div class="text-2xl text-blackPrimary-500 mb-2">東龍太郎</div>
            <div>
              <span class="rounded-2xl p-1 mr-2 bg-grayPrimary text-sm"
                >男性</span
              >
              <span class="rounded-2xl p-1 bg-grayPrimary text-sm">34歳</span>
            </div>
          </div>
        </div>
        <div class="flex mt-2.5">
          <div
            v-for="(item, i) in [1, 2, 3, 4]"
            :key="i"
            class="rounded-2xl py-2 px-3.5 mr-2 bg-grayPrimary text-sm"
          >
            病院
          </div>
        </div>
        <hr class="w-full mt-3 mb-5" />
      </div>
    </div>
  </section>
</template>

<script>
import SearchInput from "@/Components/Element/SearchInput.vue";
import CareTakerInfoTable from "@/Components/CareTaker/CareTakerInfoTable.vue";
import { Inertia } from "@inertiajs/inertia";
import { onBefore, onFinish } from "@/Uses/request-inertia";

export default {
  name: "CareTakerDetail",
  props: {
    caretaker: {
      required: true,
    },
    job: {
      required: true,
    },
  },
  components: { SearchInput, CareTakerInfoTable },
  computed: {
    caretakerData() {
      return this.caretaker.data;
    },
    jobData() {
      return this.job.data;
    },
    processes() {
      return this.jobData.processes;
    },

    jobApply() {
      const jobPostApply = this.getJobApply()?.job_post_apply || [];
      let arrMap = [];
      for (const item of jobPostApply) {
        arrMap["_" + item.job_process_id] = item.status;
      }

      return arrMap;
    },
    jobApplyStatusId() {
      return this.jobData?.jobApply?.id || null;
    },
  },
  methods: {
    getJobApply() {
      const jobPostApply = this.jobData?.jobApply;
      return Array.isArray(jobPostApply) ? jobPostApply.last() : jobPostApply;
    },
    getStatusProcess(processId) {
      const status = this.jobApply["_" + processId];
      return typeof status === "undefined" ? 3 : status;
    },
    getClassProcess(processId) {
      const status = this.getStatusProcess(processId);
      if (status === 2) {
        return {
          "done-process": true,
        };
      }

      if (status === 0) {
        return {
          "current-process": true,
        };
      }

      if (status === 1) {
        return {
          "reject-process": true,
        };
      }

      if (status === 3) {
        return {
          "un-process": true,
        };
      }
    },
    onProcess(processId, status) {
      Inertia.post(
        route("hospital.jobs.caretaker-process"),
        {
          processId,
          jobApplyStatusId: this.jobApplyStatusId,
          ...route().params,
          status,
        },
        {
          preserveScroll: true,
          onBefore,
          onFinish,
        }
      );
    },
    onDoneProcess(processId) {
      this.onProcess(processId, "done");
    },
    onRejectProcess(processId) {
      this.onProcess(processId, "reject");
    },
  },
};
</script>

<style>
.CareTakerInfo .timeline .timeline-step:last-child .step-line {
  height: 0;
}

.done-process,
.reject-process {
  background-color: #ff7777;
  color: white;
  font-weight: bold;
}

.reject-process {
  background-color: #fca442;
}

.current-process {
  background-color: white;
  border: 1px solid #cccccc;
  color: #979797;
}

.un-process {
  background-color: white;
  border: 1px solid #ebe8e8;
  color: #ebe8e8;
}

.border-none {
  border-style: none !important;
}
</style>
