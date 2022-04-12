<template>
  <div class="w-1/2 m-auto">
    <h2 class="text-center">Thay đổi mật khẩu</h2>

    <el-form
      ref="formData"
      :model="formData"
      label-position="top"
      :rules="rules"
    >
      <el-form-item prop="password" label="Nhập mật khẩu mới">
        <el-input type="password" v-model="formData.password"></el-input>
      </el-form-item>

      <el-form-item prop="password_confirmation" label="Xác nhận mật khẩu mới">
        <el-input
          type="password"
          v-model="formData.password_confirmation"
        ></el-input>
      </el-form-item>

      <div class="text-center">
        <el-button @click="submit()" type="danger"> Thay đổi</el-button>
      </div>
    </el-form>
  </div>
</template>

<script>
import { Inertia } from "@inertiajs/inertia";
import { onBefore, onFinish } from "@/Uses/request-inertia";
export default {
  name: "ForgotPassword",

  props: {
    id: String,
  },

  data() {
    return {
      formData: {
        id: this.id,
        password: "",
        password_confirmation: "",
      },
      rules: {
        password: [
          {
            required: true,
            message: "Trường này không được để trống",
            trigger: "blur",
          },
        ],
        password_confirmation: [
          {
            required: true,
            message: "Trường này không được để trống",
            trigger: "blur",
          },
        ],
      },
    };
  },
  methods: {
    async submit() {
      this.$refs["formData"].validate((valid) => {
        if (valid) {
          Inertia.post(
            route("confirm_forgot_password", this.formData),
            {},
            { onBefore, onFinish, preserveScroll: true }
          );
        }
      });
    },
  },
};
</script>