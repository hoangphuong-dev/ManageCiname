<template>
  <div class="JobCreate px-6 py-5 my-8 bg-white h-full">
    <div class="flex mb-8">
      <h1 class="w-1/2 text-lightGreen">{{ job?.id ? 'Edit job' : '求人原稿の登録' }}</h1>
      <div class="w-1/2 text-right">
        <button class="btn-info mr-4" @click="$inertia.visit(route('hospital.jobs.list'))">キャンセル</button>
        <button class="btn-light-green" @click="onSubmit">登録</button>
      </div>
    </div>

    <!-- Upload file -->
    <div class="w-full text-lightGreen">
      <upload-image :listImage="listImage" @uploadImage="handleUploadImage" @removeImage="removeImage"></upload-image>
    </div>

    <div class="flex mt-10">
      <div
        class="mr-11 hover:cursor-pointer hover:text-lightGreen"
        :class="{ 'tab-active': !showJobProcess }"
        @click.prevent="showJobProcess = false"
      >
        Thêm thông tin job
      </div>
      <div
        class="hover:cursor-pointer hover:text-lightGreen"
        :class="{ 'tab-active': showJobProcess }"
        @click.prevent="showJobProcess = true"
      >
        Quy trình tuyển dụng
      </div>
    </div>
    <hr class="w-full border-t-2 -mt-0.5 mb-9" />

    <el-form label-position="top" :model="formData" ref="jobFormRef" :rules="rules">
      <!-- Thêm thông tin job -->
      <div v-show="!showJobProcess" class="job-information w-full">
        <el-form-item label="求人キャッチコピー" prop="name" :error="$errors.first('name')">
          <el-input v-model="formData.name" placeholder="Name"></el-input>
        </el-form-item>

        <el-form-item label="病院名" prop="hospital_name" :error="$errors.first('hospital_name')">
          <el-input v-model="formData.hospital_name" placeholder="Hospital name"></el-input>
        </el-form-item>

        <el-form-item label="勤務地住所" prop="address" :error="$errors.first('address')">
          <el-input v-model="formData.address" placeholder="Address"></el-input>
        </el-form-item>

        <div class="flex">
          <div class="w-1/2 pr-2">
            <el-form-item label="最寄り駅・アクセス" prop="nearest_station" :error="$errors.first('nearest_station')">
              <el-input v-model="formData.nearest_station" placeholder="Ga gần nhất"></el-input>
            </el-form-item>
          </div>
          <div class="w-1/2 pl-2">
            <el-form-item label="ググールマップリンク" prop="map_station" :error="$errors.first('map_station')">
              <el-input v-model="formData.map_station" placeholder="Google map liên kết"></el-input>
            </el-form-item>
          </div>
        </div>

        <el-form-item label="当院の強み" prop="advantages" :error="$errors.first('advantages')">
          <el-input v-model="formData.advantages" placeholder="advantages" :rows="8" type="textarea"></el-input>
        </el-form-item>

        <div class="block lg:flex">
          <el-form-item class="w-full lg:w-1/2 lg:pr-5" label="給与">
            <div class="flex">
              <el-form-item class="w-1/2 pr-1.5" prop="wage_min" :error="$errors.first('wage_min')">
                <el-input v-model="formData.wage_min" placeholder="Min"></el-input>
                <span class="absolute right-3 top-1/2 text-yellowPrimary">Yên</span>
              </el-form-item>
              <el-form-item class="w-1/2 pl-1.5" prop="wage_min" :error="$errors.first('wage_min')">
                <el-input v-model="formData.wage_max" placeholder="Max"></el-input>
                <span class="absolute right-3 top-1/2 text-yellowPrimary">Yên</span>
              </el-form-item>
            </div>
          </el-form-item>

          <el-form-item class="w-full lg:w-1/2 lg:pl-5" label="年収">
            <div class="flex">
              <el-form-item class="w-1/2 pr-1.5" prop="annual_income_min" :error="$errors.first('annual_income_min')">
                <el-input v-model="formData.annual_income_min" placeholder="Min"></el-input>
                <span class="absolute right-3 top-1/2 text-yellowPrimary">Yên</span>
              </el-form-item>
              <el-form-item class="w-1/2 pl-1.5" prop="annual_income_max" :error="$errors.first('annual_income_max')">
                <el-input v-model="formData.annual_income_max" placeholder="Max"></el-input>
                <span class="absolute right-3 top-1/2 text-yellowPrimary">Yên</span>
              </el-form-item>
            </div>
          </el-form-item>
        </div>

        <el-form-item class="w-full" label="雇用形態" prop="type_of_work" :error="$errors.first('type_of_work')">
          <el-radio-group v-model="formData.type_of_work">
            <el-radio class="min-w-132 justify-center" :label="1" border>正社員</el-radio>
            <el-radio class="min-w-132 justify-center" :label="0" border>パートタイム</el-radio>
          </el-radio-group>
        </el-form-item>

        <el-form-item class="w-full" label="勤務時間" prop="working_hours" :error="$errors.first('working_hours')">
          <el-checkbox-group v-model="formData.working_hours">
            <el-checkbox
              v-for="(workingHour, index) in workingHourList"
              :key="index"
              :label="workingHour"
              class="min-w-132 justify-center"
              border
            >
              {{ workingHour }}
            </el-checkbox>
          </el-checkbox-group>
        </el-form-item>

        <el-form-item class="w-full" label="休暇" prop="holidays" :error="$errors.first('holidays')">
          <el-checkbox-group v-model="formData.holidays">
            <el-checkbox
              v-for="(holiday, index) in holidayList"
              :key="index"
              :label="holiday"
              border
              class="min-w-132 justify-center"
            >
              {{ holiday }}
            </el-checkbox>
          </el-checkbox-group>
        </el-form-item>

        <el-form-item
          class="w-52 mt-2"
          label="年間休日数"
          prop="number_annual_holidays"
          :error="$errors.first('number_annual_holidays')"
        >
          <el-input v-model="formData.number_annual_holidays" placeholder="Number of annual holidays"></el-input>
        </el-form-item>

        <el-form-item label="募集業務内容" prop="description" :error="$errors.first('description')">
          <el-input v-model="formData.description" :rows="8" type="textarea" placeholder="description"></el-input>
        </el-form-item>

        <el-form-item label="募集業務内容" prop="occupation" :error="$errors.first('occupation')">
          <el-select class="w-full" v-model="formData.occupation" multiple placeholder="Select occupation">
            <el-option
              v-for="(item, index) in occupationList"
              :key="index"
              :label="item.name"
              :value="item.value"
            ></el-option>
          </el-select>
        </el-form-item>

        <div class="mt-8">
          <div class="font-bold mb-4">応募条件</div>
          <el-form-item label="〇〇資格をお持ちの方" prop="certificate" :error="$errors.first('certificate')">
            <el-select class="w-full" v-model="formData.certificate" multiple placeholder="Select certificate">
              <el-option
                v-for="(item, index) in occupationList"
                :key="index"
                :label="item.name"
                :value="item.value"
              ></el-option>
            </el-select>
          </el-form-item>

          <el-form-item label="臨床経験〇年以上" prop="years_experience" :error="$errors.first('years_experience')">
            <el-select class="w-full" v-model="formData.years_experience" placeholder="Years experience">
              <el-option
                v-for="(item, index) in occupationList"
                :key="index"
                :label="item.name"
                :value="item.value"
              ></el-option>
            </el-select>
          </el-form-item>

          <el-form-item label="〇〇のスキルあり" prop="skills" :error="$errors.first('skills')">
            <el-select class="w-full" v-model="formData.skills" multiple placeholder="Select skills">
              <el-option
                v-for="(item, index) in occupationList"
                :key="index"
                :label="item.name"
                :value="item.value"
              ></el-option>
            </el-select>
          </el-form-item>

          <el-form-item label="福利厚生・手当" prop="experience_priority" :error="$errors.first('experience_priority')">
            <el-select class="w-full" v-model="formData.experience_priority" multiple placeholder="Experience priority">
              <el-option
                v-for="(item, index) in occupationList"
                :key="index"
                :label="item.name"
                :value="item.value"
              ></el-option>
            </el-select>
          </el-form-item>

          <el-form-item label="〇〇経験者は優遇" prop="benefits" :error="$errors.first('benefits')">
            <el-select class="w-full" v-model="formData.benefits" multiple placeholder="Select benefits">
              <el-option
                v-for="(item, index) in occupationList"
                :key="index"
                :label="item.name"
                :value="item.value"
              ></el-option>
            </el-select>
          </el-form-item>
        </div>

        <div>
          <div class="font-bold mb-4">法人情報</div>
          <div class="flex gap-3">
            <el-form-item class="w-5/6" label="法人名" prop="comapany_name" :error="$errors.first('comapany_name')">
              <el-input v-model="formData.comapany_name" placeholder="comapany name"></el-input>
            </el-form-item>

            <el-form-item
              class="w-1/6"
              label="設立年"
              prop="comapany_establishment"
              :error="$errors.first('comapany_establishment')"
            >
              <el-date-picker
                v-model="formData.comapany_establishment"
                type="date"
                class="w-full"
                placeholder="Comapany establishment"
              ></el-date-picker>
            </el-form-item>
          </div>

          <el-form-item label="法人紹介" prop="comapany_introduce" :error="$errors.first('comapany_introduce')">
            <el-input
              v-model="formData.comapany_introduce"
              :rows="8"
              type="textarea"
              placeholder="comapany introduce"
            ></el-input>
          </el-form-item>
        </div>
      </div>

      <!-- Quy trình tuyển dụng -->
      <div v-show="showJobProcess" class="job-process w-full">
        <el-form-item
          v-for="(process, index) in formData.job_process"
          :key="index"
          :label="'ステップ' + (index + 1)"
          :prop="'job_process.' + index + '.content'"
          :rules="{
            required: true,
            message: 'process can not be null',
            trigger: 'blur',
          }"
        >
          <div class="flex flex-wrap mb-2.5">
            <div class="w-1/4">
              <el-input v-model="process.content"></el-input>
            </div>
            <button
              v-if="index > 2 || process.id"
              class="ml-5 px-4 h-10 rounded cursor-pointer"
              @click.prevent="removeProcess(process)"
            >
              <img src="/images/svg/delete.svg" class="p-2.5 h-10 w-10 bg-white rounded" />
            </button>
          </div>
        </el-form-item>
        <button class="mt-4 bg-lightGreen rounded text-white btn-light-green" @click.prevent="addProcess">
          + Thêm bước
        </button>
      </div>
    </el-form>

    <div class="mb-9 mt-5 flex justify-center">
      <button class="btn-info mr-4" @click="$inertia.visit(route('hospital.jobs.list'))">キャンセル</button>
      <button class="btn-warning" @click="onSubmit">登録</button>
    </div>
  </div>
</template>

<script>
import UploadImage from '@/Components/UploadImage.vue'
import { updateJob, createJob, checkDeleteProcess } from '../../API/job.js'
import { toFormData } from '@/libs/form'
import { reactive, ref } from 'vue'
export default {
  name: 'JobForm',
  props: {
    job: {
      type: Object,
      required: false,
    },
  },
  components: { UploadImage },
  data() {
    return {
      loading: false,
      showJobProcess: false,
      formData: {
        images: [],
        name: '',
        hospital_name: '',
        address: '',
        nearest_station: '',
        map_station: '',
        advantages: '',
        wage_min: '',
        wage_max: '',
        annual_income_min: '',
        annual_income_max: '',
        type_of_work: '',
        working_hours: [],
        holidays: [],
        number_annual_holidays: '',
        description: '',
        occupation: [],
        certificate: '',
        years_experience: '',
        skills: '',
        experience_priority: '',
        benefits: [],
        comapany_name: '',
        comapany_establishment: '',
        comapany_introduce: '',
        job_process: [
          { content: '', order: 1 },
          { content: '', order: 2 },
          { content: '', order: 3 },
        ],
      },
      jobProcessDelete: [],
      imagesDelete: [],
      listImage: [],
      workingHourList: ['日勤', '準夜', '深夜', '夜勤', 'パート '],
      holidayList: [
        '週休二日制 ',
        '日曜日',
        '祝日',
        '年次休暇',
        '産前産後休暇',
        '年末年始休暇',
        '夏季休暇',
        '介護休暇 ',
        'その他 ',
      ],
      occupationList: [
        {
          value: 'Option1',
          name: 'Option1',
        },
        {
          value: 'Option2',
          name: 'Option2',
        },
      ],
      rules: {
        name: {
          required: true,
          message: 'Please input this',
          trigger: 'blur',
        },
        hospital_name: {
          required: true,
          message: 'Please input this',
          trigger: 'blur',
        },
        address: {
          required: true,
          message: 'Please input this',
          trigger: 'blur',
        },
        nearest_station: {
          required: true,
          message: 'Please input this',
          trigger: 'blur',
        },
        map_station: {
          required: true,
          message: 'Please input this',
          trigger: 'blur',
        },
        advantages: {
          required: true,
          message: 'Please input this',
          trigger: 'blur',
        },
        description: {
          required: true,
          message: 'Please input this',
          trigger: 'blur',
        },
        wage_min: {
          required: true,
          message: 'Please input this',
          trigger: 'blur',
        },
        wage_max: {
          required: true,
          message: 'Please input this',
          trigger: 'blur',
        },
        annual_income_min: {
          required: true,
          message: 'Please input this',
          trigger: 'blur',
        },
        annual_income_max: {
          required: true,
          message: 'Please input this',
          trigger: 'blur',
        },
        type_of_work: {
          required: true,
          message: 'Please input this',
          trigger: 'blur',
        },
        working_hours: {
          required: true,
          message: 'Please input this',
          trigger: 'blur',
        },
        holidays: {
          required: true,
          message: 'Please input this',
          trigger: 'blur',
        },
        number_annual_holidays: {
          required: true,
          message: 'Please input this',
          trigger: 'blur',
        },
        occupation: {
          required: true,
          message: 'Please input this',
          trigger: 'blur',
        },
        certificate: {
          required: true,
          message: 'Please input this',
          trigger: 'blur',
        },
        years_experience: {
          required: true,
          message: 'Please input this',
          trigger: 'blur',
        },
        skills: {
          required: true,
          message: 'Please input this',
          trigger: 'blur',
        },
        experience_priority: {
          required: true,
          message: 'Please input this',
          trigger: 'blur',
        },
        benefits: {
          required: true,
          message: 'Please input this',
          trigger: 'blur',
        },
        comapany_name: {
          required: true,
          message: 'Please input this',
          trigger: 'blur',
        },
        comapany_establishment: {
          required: true,
          message: 'Please input this',
          trigger: 'blur',
        },
        comapany_introduce: {
          required: true,
          message: 'Please input this',
          trigger: 'blur',
        },
      },
    }
  },
  async created() {
    await this.initEditJob()
  },
  methods: {
    initEditJob() {
      if (this.job) {
        this.formData = {
          ...this.job,
          job_process: this.job.processes.data,
          images: this.job.images.data,
        }
        this.listImage = [...this.formData.images]
      }
    },
    handleUploadImage(image) {
      if (image) {
        this.formData.images.push(image)
      }
    },
    removeImage(image) {
      const index = this.formData.images.indexOf(image)
      this.formData.images.splice(index, 1)

      if (image?.id) {
        this.imagesDelete.push({ id: image.id, path: image.path })
      }
    },
    addProcess() {
      const orderMax = Math.max.apply(
        Math,
        this.formData.job_process.map(function (process) {
          return process.order
        })
      )

      this.formData.job_process.push({
        content: '',
        order: orderMax + 1,
      })
    },
    removeProcess(process) {
      this.$confirm('Are you sure to delete this process?', 'Warning', {
        confirmButtonText: 'OK',
        cancelButtonText: 'Cancel',
        type: 'warning',
      }).then(async () => {
        const index = this.formData.job_process.indexOf(process)

        if (process.id) {
          await checkDeleteProcess(this.job.id, process.id).then(({ data }) => {
            if (data) {
              this.formData.job_process.splice(index, 1)
              this.jobProcessDelete.push(process.id)
            } else {
              this.$message.error('Không thể xoá bước này')
            }
          })
        } else {
          this.formData.job_process.splice(index, 1)
        }
      })
    },
    async onSubmit() {
      this.$refs['jobFormRef'].validate(async (valid) => {
        if (valid) {
          const jobId = this.job ? this.job?.id : null
          this.loading = true
          if (jobId) {
            await this.updateJob(jobId)
          } else {
            await this.createJob()
          }
          this.loading = false
        }
      })
    },
    async createJob() {
      await createJob(toFormData({ ...this.formData }, '', { indices: true }))
        .then(async (res) => {
          this.$message.success('Create success')
          this.$inertia.visit(route('hospital.jobs.list'))
        })
        .catch(() => {
          this.$message.error('Server Error')
        })
    },
    async updateJob(jobId) {
      this.formData.job_process_delete = this.jobProcessDelete
      this.formData.images = this.formData.images.filter((image) => {
        return !image.id
      })
      this.formData.images_delete = this.imagesDelete

      await updateJob(jobId, toFormData({ ...this.formData, _method: 'PUT' }, '', { indices: true }))
        .then(async (res) => {
          this.$message.success('Update success')
          this.$inertia.visit(route('hospital.jobs.list'))
        })
        .catch(() => {
          this.$message.error('Server Error')
        })
    },
  },
}
</script>
<style>
.JobCreate .tab-active {
  font-weight: bold;
  font-size: 1rem;
  line-height: 1.625rem;
  color: #a5c242;
  border-bottom: 2px solid #a5c242;
}
.JobCreate .el-form-item {
  margin-bottom: 1rem;
}
.JobCreate .el-form-item__content {
  line-height: 0;
}
.JobCreate .el-form-item__label {
  margin-bottom: 0;
  line-height: 0.875rem;
}
.JobCreate .el-radio.is-bordered + .el-radio.is-bordered,
.JobCreate .el-checkbox.is-bordered + .el-checkbox.is-bordered {
  margin-left: 0px;
}
.JobCreate .el-radio,
.JobCreate .el-checkbox {
  margin-right: 0.75rem;
}
.JobCreate .el-radio .el-radio__input,
.JobCreate .el-checkbox .el-checkbox__input {
  display: none;
}
.JobCreate .el-form-item__error {
  position: relative;
}
</style>
