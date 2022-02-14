<template>
  <admin-layout v-loading="loading">
    <template #main>
      <div class="bg-white min-h-full m-4 mb-0 p-4">
        <h2 class="mb-5">お問合せの詳細</h2>
        <div class="breadcrumb w-full text-sm mb-5">
          <span class="text-blackPrimary-500">お問合せ管理 /</span>
          <span class="text-lightGreen">お問合せ詳細</span>
        </div>

        <div class="w-full">
          <hr class="w-full" />
          <div class="my-3 lg:my-6 flex flex-wrap">
            <div class="w-full lg:w-1/3">
              <label>配信者:</label>
              {{ contact.name }}
            </div>
            <div class="w-full lg:w-1/3">
              <label>アカウント種類:</label>
              {{ contact.company_name }}
            </div>
            <div class="w-full lg:w-1/3">
              <label>配信日:</label>
              {{ formatDateTime(contact?.created_at) }}
            </div>
          </div>
          <hr class="w-full" />
        </div>
        <div class="title mb-4 mt-6 text-base font-bold text-black"></div>
        <div>
          {{ contact.question_content }}
        </div>
        <div class="mt-6">
          <el-form ref="formData" :model="contact" label-position="top">
            <el-form-item label="Content of the answer">
              <el-input
                v-model="contact.answer_content"
                :rows="7"
                type="textarea"
                placeholder="Please input"
                :inline-message="$errors.check('answer_content')"
                :error="$errors.first('answer_content')"
              />
            </el-form-item>
          </el-form>

          <div class="dialog-footer flex gap-2.5">
            <button class="btn-info" type="info" @click="$inertia.visit(route('back.contacts'))">キャンセル</button>
            <button class="btn-primary" @click="onSubmit">登録</button>
          </div>
        </div>
      </div>
    </template>
  </admin-layout>
</template>

<script>
import AdminLayout from '@/Layouts/Admin/AdminLayout.vue'
import { formatDateTime } from '@/libs/datetime'
import { updateContact } from '@/API/contact.js'
export default {
  name: 'ContactDetail',
  components: {
    AdminLayout,
  },
  props: {
    contact: {
      require: true,
      type: Object,
    },
  },
  data() {
    return {
      loading: false,
    }
  },
  methods: {
    formatDateTime,
    async onSubmit() {
      this.loading = true
      await updateContact(this.contact.id, {
        answer_content: this.contact.answer_content,
      })
        .then(async (res) => {
          this.$message.success('Update completed')
          this.$inertia.visit(route('back.contacts'))
        })
        .catch(() => {
          this.$message.error('Server Error')
        })
      this.loading = false
    },
  },
}
</script>
