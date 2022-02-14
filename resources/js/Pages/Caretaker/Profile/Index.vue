<template>
  <app-layout>
    <div class="CareTakerPofile my-8">
      <el-form label-position="top" :model="formData" ref="profileFormRef" :rules="rules">
        <!-- Profile -->
        <section class="profile bg-white mb-6 md:px-6 md:py-5 px-4 py-3 shadow-xl">
          <h1 class="text-lightGreen mb-10">プロフィル情報</h1>
          <div class="text-blackPrimary-500 mb-6">個人情報</div>

          <div class="flex mb-2 gap-5">
            <div class="w-1/2">
              <el-form-item label="雇用形態" prop="degree_type" :error="$errors.first('degree_type')">
                <el-radio-group class="radio-border" v-model="formData.degree_type">
                  <el-radio class="min-w-132 justify-center" :label="1" border>正看護師</el-radio>
                  <el-radio class="min-w-132 justify-center" :label="2" border>准看護師</el-radio>
                  <el-radio class="min-w-132 justify-center" :label="3" border>助産師</el-radio>
                </el-radio-group>
              </el-form-item>
            </div>

            <div class="w-1/2">
              <el-form-item label="年代" prop="age_type" :error="$errors.first('age_type')">
                <el-radio-group class="radio-border" v-model="formData.age_type">
                  <el-radio class="min-w-124 justify-center" :label="1" border>～25</el-radio>
                  <el-radio class="min-w-124 justify-center" :label="2" border>26～30</el-radio>
                  <el-radio class="min-w-124 justify-center" :label="3" border>31～40</el-radio>
                  <el-radio class="min-w-124 justify-center" :label="4" border>41～</el-radio>
                </el-radio-group>
              </el-form-item>
            </div>
          </div>

          <div class="flex mb-2 gap-5">
            <div class="w-1/2">
              <el-form-item label="メールアドレス" prop="email" :error="$errors.first('email')">
                <el-input v-model="formData.email" placeholder="Email"></el-input>
              </el-form-item>
            </div>

            <div class="w-1/2">
              <el-form-item label="居住地郵便番号" prop="postal_code" :error="$errors.first('postal_code')">
                <el-input v-model="formData.postal_code" placeholder="Postal code"></el-input>
              </el-form-item>
            </div>
          </div>

          <div class="flex mb-5">
            <label class="text-base mr-10">パスワード</label>
            <img
              @click.prevent="editPassword = !editPassword"
              class="hover:cursor-pointer"
              src="/images/svg/edit.svg"
              alt=""
            />
          </div>
          <template v-if="editPassword">
            <el-form-item prop="password" :error="$errors.first('password')">
              <el-input v-model="formData.password" placeholder="Name" type="password" show-password></el-input>
            </el-form-item>

            <div class="flex gap-5">
              <el-form-item class="w-1/2" prop="password_new" :error="$errors.first('password_new')">
                <el-input
                  v-model="formData.password_new"
                  placeholder="New Password"
                  type="password"
                  show-password
                ></el-input>
              </el-form-item>
              <el-form-item
                class="w-1/2"
                prop="password_new_confirmation"
                :error="$errors.first('password_new_confirmation')"
              >
                <el-input
                  v-model="formData.password_new_confirmation"
                  placeholder="New password confirm"
                  type="password"
                  show-password
                ></el-input>
              </el-form-item>
            </div>
          </template>
        </section>

        <!-- CV -->
        <section class="cv-info bg-white md:px-6 md:py-5 px-4 py-3 shadow-xl">
          <div class="text-blackPrimary-500 mb-6">履歴書</div>
          <div class="flex gap-10">
            <div class="w-1/6 mb-2">
              <div
                class="w-48 h-60 flex justify-center items-center border rounded hover:cursor-pointer"
                @click="$refs.inputUpload.click()"
              >
                <div class="xl:flex flex-col justify-center items-center" v-if="!imagePreview">
                  <el-image src="/images/svg/upload.svg"></el-image>
                  <p class="text-lightGreen">アップロード</p>
                </div>
                <img v-else :src="imagePreview" class="rounded w-full h-full object-cover" />
                <input class="hidden" ref="inputUpload" type="file" @change="handleFileChange($event)" />
              </div>
            </div>
            <div class="w-5/6">
              <div class="text-base mb-3">氏名</div>
              <div class="flex w-full gap-5">
                <div class="w-1/3">
                  <el-form-item label="漢字" prop="name_kana" :error="$errors.first('name_kana')">
                    <el-input v-model="formData.name_kana" placeholder="name_kana"></el-input>
                  </el-form-item>
                </div>
                <div class="w-1/3">
                  <el-form-item label="フリガナ" prop="name_kana_given" :error="$errors.first('name_kana_given')">
                    <el-input v-model="formData.name_kana_given" placeholder="name_kana_given"></el-input>
                  </el-form-item>
                </div>
                <div class="w-1/3">
                  <el-form-item label="満歳" prop="full_age" :error="$errors.first('full_age')">
                    <el-input v-model="formData.full_age" placeholder="Full age"></el-input>
                  </el-form-item>
                </div>
              </div>

              <div class="flex w-full gap-5">
                <div class="w-1/3">
                  <el-form-item label="生年月日" prop="birthday" :error="$errors.first('birthday')">
                    <el-date-picker
                      v-model="formData.birthday"
                      class="w-full"
                      type="date"
                      placeholder="Pick a day"
                    ></el-date-picker>
                  </el-form-item>
                </div>
                <div class="w-1/3">
                  <el-form-item label="電話番号" prop="phone" :error="$errors.first('phone')">
                    <el-input v-model="formData.phone" placeholder="phone"></el-input>
                  </el-form-item>
                </div>
                <div class="w-1/3">
                  <el-form-item label="性別" prop="gender" :error="$errors.first('gender')">
                    <el-radio-group class="radio-border" v-model="formData.gender">
                      <el-radio class="w-20 justify-center" :label="0" border>女性</el-radio>
                      <el-radio class="w-20 justify-center" :label="1" border>男</el-radio>
                    </el-radio-group>
                  </el-form-item>
                </div>
              </div>
            </div>
          </div>

          <!-- Địa chỉ -->
          <h3 class="mb-3 mt-5">現住所</h3>
          <el-form-item label="住所" prop="address" :error="$errors.first('address')">
            <el-input v-model="formData.address" placeholder="address"></el-input>
          </el-form-item>
          <el-form-item label="住所" prop="address_furigana" :error="$errors.first('address_furigana')">
            <el-input v-model="formData.address_furigana" placeholder="address_furigana"></el-input>
          </el-form-item>

          <!-- Địa chỉ liên hệ khác -->
          <h3 class="mt-5">住所</h3>
          <div class="my-4 text-blackPrimary-300">※現住所とは違う住所に連絡したい場合に記入</div>
          <div class="flex gap-5">
            <el-form-item
              class="w-1/4"
              label="郵便番号 "
              prop="address_other_code"
              :error="$errors.first('address_other_code')"
            >
              <el-input v-model="formData.address_other_code" placeholder="address_other_code"></el-input>
            </el-form-item>
            <el-form-item class="w-3/4" label="住所" prop="type_of_work" :error="$errors.first('address_other')">
              <el-input v-model="formData.address_other" placeholder="address_other"></el-input>
            </el-form-item>
          </div>
          <el-form-item label="フリガナ" prop="address_other_furigana" :error="$errors.first('address_other_furigana')">
            <el-input v-model="formData.address_other_furigana" placeholder="address_other_furigana"></el-input>
          </el-form-item>

          <!-- Nền tảng giáo dục -->
          <h3 class="mt-5">学歴</h3>
          <div v-for="(education, indexEducational) in formData.education" :key="indexEducational" class="flex gap-5">
            <div class="w-2/5">
              <el-form-item
                label="学校名"
                :prop="'education.' + indexEducational + '.name'"
                :error="$errors.first('education')"
              >
                <el-input v-model="education.name" placeholder="Name"></el-input>
              </el-form-item>
            </div>
            <div class="w-1/5">
              <el-form-item label="修学ステータス" :prop="'education.' + indexEducational + '.status'">
                <el-select v-model="education.status" placeholder="Select" class="w-full">
                  <el-option
                    v-for="item in options"
                    :key="item.value"
                    :label="item.label"
                    :value="item.value"
                  ></el-option>
                </el-select>
              </el-form-item>
            </div>
            <div class="w-1/5">
              <el-form-item label="入学年月" :prop="'education.' + indexEducational + '.start_date'">
                <el-date-picker
                  v-model="education.start_date"
                  class="w-full"
                  type="date"
                  placeholder="Pick a day"
                ></el-date-picker>
              </el-form-item>
            </div>
            <div class="w-1/5">
              <el-form-item label="卒業年月" :prop="'education.' + indexEducational + '.end_date'">
                <el-date-picker
                  v-model="education.end_date"
                  class="w-full"
                  type="date"
                  placeholder="Pick a day"
                ></el-date-picker>
              </el-form-item>
            </div>
            <div class="w-16 md:pt-6">
              <button
                v-if="indexEducational > 0"
                class="ml-5 h-10 rounded cursor-pointer"
                @click.prevent="removeEducation(education)"
              >
                <img src="/images/svg/delete.svg" class="p-2.5 h-10 w-10 bg-gray-300 rounded" />
              </button>
            </div>
          </div>
          <button class="btn-primary" @click.prevent="addEducatical">+ 学歴追加</button>

          <!-- Kinh nghiem lam viec -->
          <el-form-item class="mt-8" label="職歴">
            <el-radio-group v-model="formData.has_experiences">
              <el-radio :label="1">あり</el-radio>
              <el-radio :label="0">なし</el-radio>
            </el-radio-group>
          </el-form-item>
          <!-- Kinh nghiem lam viec chi tiet -->
          <div>
            <div
              v-for="(experience, indexExperience) in formData.experiences"
              :key="indexExperience"
              class="flex gap-5"
            >
              <div class="w-1/4">
                <el-form-item label="勤務先" :prop="'experiences.' + indexExperience + '.name'">
                  <el-input v-model="experience.name" placeholder="Name"></el-input>
                </el-form-item>
              </div>
              <div class="w-1/4">
                <el-form-item label="勤務期間" :prop="'experiences.' + indexExperience + '.time'">
                  <el-input v-model="experience.time" placeholder="Time"></el-input>
                </el-form-item>
              </div>
              <div class="w-1/4 pl-10">
                <el-form-item label="雇用形態" :prop="'experiences.' + indexExperience + '.type'">
                  <el-radio-group v-model="experience.type">
                    <el-radio :label="1">あり</el-radio>
                    <el-radio :label="2">なし</el-radio>
                  </el-radio-group>
                </el-form-item>
              </div>
              <div class="w-16 md:pt-6">
                <button
                  v-if="indexExperience > 0"
                  class="ml-5 h-10 rounded cursor-pointer"
                  @click.prevent="removeExperience(experience)"
                >
                  <img src="/images/svg/delete.svg" class="p-2.5 h-10 w-10 bg-gray-300 rounded" />
                </button>
              </div>
            </div>
            <button class="btn-primary" @click.prevent="addExperience">+ 勤務先追加</button>
          </div>

          <!-- Giấy phép / Bằng cấp -->
          <h3 class="mt-8 mb-4">免許・資格（取得予定資格を含む）</h3>
          <div
            v-for="(qualification, indexQualification) in formData.qualifications"
            :key="indexQualification"
            class="flex gap-5"
          >
            <div class="w-1/2">
              <el-form-item label="居住地郵便番号" :prop="'qualifications.' + indexQualification + '.name'">
                <el-input v-model="qualification.name" placeholder="Name"></el-input>
              </el-form-item>
            </div>
            <div class="w-1/2 flex gap-5">
              <div class="w-1/2">
                <el-form-item label="居住地郵便番号" :prop="'qualifications.' + indexQualification + '.status'">
                  <el-select v-model="qualification.status" placeholder="Select" class="w-full">
                    <el-option
                      v-for="(item, index) in options"
                      :key="index"
                      :label="item.label"
                      :value="index"
                    ></el-option>
                  </el-select>
                </el-form-item>
              </div>
              <div class="w-1/2">
                <el-form-item label="居住地郵便番号" :prop="'qualifications.' + indexQualification + '.date'">
                  <el-date-picker
                    v-model="qualification.date"
                    class="w-full"
                    type="date"
                    placeholder="Pick a day"
                  ></el-date-picker>
                </el-form-item>
              </div>
            </div>
            <div class="w-16 md:pt-6">
              <button
                v-if="indexQualification > 0"
                class="ml-5 h-10 rounded cursor-pointer"
                @click.prevent="removeQualification(qualification)"
              >
                <img src="/images/svg/delete.svg" class="p-2.5 h-10 w-10 bg-gray-300 rounded" />
              </button>
            </div>
          </div>
          <button class="btn-primary" @click.prevent="addQualification">+ 学歴追加</button>

          <!-- Ngành học sở trường -->
          <h3 class="mt-5">得意学科</h3>
          <el-form-item prop="forte_majors" :error="$errors.first('forte_majors')">
            <el-input v-model="formData.forte_majors" placeholder="forte_majors" :rows="5" type="textarea"></el-input>
          </el-form-item>

          <!-- Sở thích -->
          <h3 class="mt-5">趣味</h3>
          <el-form-item prop="hobby" :error="$errors.first('hobby')">
            <el-input v-model="formData.hobby" placeholder="hobby" :rows="5" type="textarea"></el-input>
          </el-form-item>

          <!-- Hoạt động thể thao / văn hóa -->
          <h3 class="mt-5">スポーツ・文化活動</h3>
          <el-form-item prop="sports_cultural" :error="$errors.first('sports_cultural')">
            <el-input
              v-model="formData.sports_cultural"
              placeholder="sports_cultural"
              :rows="5"
              type="textarea"
            ></el-input>
          </el-form-item>

          <!-- Tình trạng sức khỏe -->
          <h3 class="mt-5">健康状態※選択式</h3>
          <el-form-item prop="health_status" :error="$errors.first('health_status')">
            <el-radio-group v-model="formData.health_status">
              <el-radio :label="3">あり</el-radio>
              <el-radio :label="6">なし</el-radio>
            </el-radio-group>
          </el-form-item>
          <!-- Tình trạng sức khỏe chi tiet -->
          <div class="mt-4">
            <el-form-item label="治療詳細（任意）" prop="health_detail" :error="$errors.first('health_detail')">
              <el-input v-model="formData.health_detail" placeholder="Name" :rows="5" type="textarea"></el-input>
            </el-form-item>
          </div>

          <!-- PR bản thân -->
          <div class="mt-4">
            <el-form-item label="自己PR" prop="pr_myself" :error="$errors.first('pr_myself')">
              <el-input v-model="formData.pr_myself" placeholder="pr_myself" :rows="5" type="textarea"></el-input>
            </el-form-item>
          </div>

          <!-- Động cơ xin việc -->
          <div class="mt-4">
            <el-form-item label="志望動機" prop="job_target" :error="$errors.first('job_target')">
              <el-input v-model="formData.job_target" placeholder="job_target" :rows="5" type="textarea"></el-input>
            </el-form-item>
          </div>

          <div class="w-full text-right">
            <button class="btn-warning w-44">PDF出力</button>
          </div>
        </section>

        <div class="bg-white pb-9 pt-5 flex justify-center">
          <button class="btn-info mr-4" @click.prevent="$inertia.visit(route('hospital.jobs.list'))">キャンセル</button>
          <button class="btn-warning" @click.prevent="onSubmit">登録</button>
        </div>
      </el-form>
    </div>
  </app-layout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout.vue'
import { updateProfile } from '../../../API/user.js'
import { toFormData } from '@/libs/form'

export default {
  name: 'Profile',
  components: { AppLayout },
  props: {
    caretaker: Object,
  },
  data() {
    return {
      loading: false,
      showJobProcess: false,
      editPassword: false,
      formData: {
        image: '',
        name_kana: '',
        name_kana_given: '',
        degree_type: '',
        age_type: '',
        email: '',
        postal_code: '',
        password: '',
        birthday: '',
        full_age: '',
        gender: '',
        phone: '',
        address: '',
        address_furigana: '',
        address_furigana: '',
        address_other_code: '',
        address_other: '',
        address_other_furigana: '',
        forte_majors: '',
        hobby: '',
        sports_cultural: '',
        health_status: '',
        health_detail: '',
        pr_myself: '',
        job_target: '',
        education: [
          {
            name: '',
            status: '',
            start_date: '',
            end_date: '',
          },
        ],
      },
      educationDelete: [],
      experiencesDelete: [],
      qualificationsDelete: [],
      imagePreview: '',
      rules: {
        email: {
          required: true,
          message: 'Please input this',
          trigger: 'blur',
        },
        postal_code: {
          required: true,
          message: 'Please input this',
          trigger: 'blur',
        },
        name_kana: {
          required: true,
          message: 'Please input this',
          trigger: 'blur',
        },
        name_kana_given: {
          required: true,
          message: 'Please input this',
          trigger: 'blur',
        },
      },
      options: [
        {
          value: 'Option1',
          label: 'Option1',
        },
        {
          value: 'Option2',
          label: 'Option2',
        },
      ],
    }
  },
  async created() {
    await this.initData()
  },
  methods: {
    initData() {
      this.formData = { ...this.caretaker.user_info }
      this.imagePreview = this.caretaker.avatar
      this.formData.name = this.caretaker.name
      this.formData.email = this.caretaker.email
      this.formData.education = this.caretaker?.educations
      this.formData.has_experiences = this.caretaker?.has_experiences
      this.formData.experiences = this.caretaker?.experiences
      this.formData.qualifications = this.caretaker?.qualifications

      if (this.formData.education.length === 0) {
        this.addEducatical()
      }
      if (this.formData.experiences.length === 0) {
        this.addExperience()
      }
      if (this.formData.qualifications.length === 0) {
        this.addQualification()
      }
    },
    handleFileChange(e) {
      const files = e.target.files || e.dataTransfer.files
      if (files.length) {
        const image = files[0]
        if (!image.name.match(/.(jpg|jpeg|png)$/i)) {
          return this.$message.error('Error ...')
        }

        let reader = new FileReader()
        reader.onload = (e) => {
          this.imagePreview = e.target.result
        }
        this.formData.image = image
        reader.readAsDataURL(image)
      }
    },
    addEducatical() {
      this.formData.education.push({
        name: '',
        status: '',
        start_date: '',
        end_date: '',
      })
    },
    removeEducation(item) {
      this.$confirm('Are you sure to delete this item?', 'Warning', {
        confirmButtonText: 'OK',
        cancelButtonText: 'Cancel',
        type: 'warning',
      }).then(() => {
        const index = this.formData.education.indexOf(item)
        if (index !== -1) {
          this.formData.education.splice(index, 1)
        }
        if (item.id) {
          this.educationDelete.push(item.id)
        }
      })
    },

    addExperience() {
      this.formData.experiences.push({
        name: '',
        time: '',
        type: '',
      })
    },
    removeExperience(item) {
      this.$confirm('Are you sure to delete this item?', 'Warning', {
        confirmButtonText: 'OK',
        cancelButtonText: 'Cancel',
        type: 'warning',
      }).then(() => {
        const index = this.formData.experiences.indexOf(item)
        if (index !== -1) {
          this.formData.experiences.splice(index, 1)
        }
        if (item.id) {
          this.experiencesDelete.push(item.id)
        }
      })
    },

    addQualification() {
      this.formData.qualifications.push({
        name: '',
        status: '',
        date: '',
      })
    },
    removeQualification(item) {
      this.$confirm('Are you sure to delete this item?', 'Warning', {
        confirmButtonText: 'OK',
        cancelButtonText: 'Cancel',
        type: 'warning',
      }).then(() => {
        const index = this.formData.qualifications.indexOf(item)
        if (index !== -1) {
          this.formData.qualifications.splice(index, 1)
        }
        if (item.id) {
          this.qualificationsDelete.push(item.id)
        }
      })
    },

    onSubmit() {
      this.$refs['profileFormRef'].validate(async (valid) => {
        if (valid) {
          this.formData.education_delete = this.educationDelete
          this.formData.experiences_delete = this.experiencesDelete
          this.formData.qualifications_delete = this.qualificationsDelete

          await updateProfile(toFormData({ ...this.formData, _method: 'PUT' }, '', { indices: true }))
            .then(async (res) => {
              this.$message.success('Update success')
              //   this.$inertia.visit(route('hospital.profile'))
            })
            .catch(() => {
              this.$message.error('Server Error')
            })
        }
      })
    },
  },
}
</script>
<style>
.CareTakerPofile .tab-active {
  font-weight: bold;
  font-size: 1rem;
  line-height: 1.625rem;
  color: #a5c242;
  border-bottom: 2px solid #a5c242;
}
.CareTakerPofile .el-form-item {
  margin-bottom: 1rem;
}
.CareTakerPofile .el-form-item__content {
  line-height: 0;
}
.CareTakerPofile .el-form-item__label {
  margin-bottom: 0;
  line-height: 0.875rem;
}
.CareTakerPofile .el-radio.is-bordered + .el-radio.is-bordered,
.CareTakerPofile .el-checkbox.is-bordered + .el-checkbox.is-bordered {
  margin-left: 0px;
}
.CareTakerPofile .el-radio,
.CareTakerPofile .el-checkbox {
  margin-right: 0.75rem;
}
.CareTakerPofile .radio-border .el-radio .el-radio__input,
.CareTakerPofile .el-checkbox .el-checkbox__input {
  display: none;
}
.CareTakerPofile .el-form-item__error {
  position: relative;
}
.CareTakerPofile .el-date-editor.el-input {
  width: 100%;
}
</style>
