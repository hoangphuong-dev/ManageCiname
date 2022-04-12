<template>
  <div class="w-1/2 m-auto">
    <h2 class="text-center">Quên mật khẩu</h2>

    <el-form
      ref="formData"
      :model="formData"
      label-position="top"
      :rules="rules"
    >
      <el-form-item prop="email" label="Email">
        <el-input v-model="formData.email" @keyup.enter="submit()"></el-input>
      </el-form-item>

      <div class="text-center">
        <el-button @click="submit()" type="danger"> Quên mật khẩu</el-button>
      </div>
    </el-form>
  </div>
</template>

<script>
import { Inertia } from "@inertiajs/inertia";
import { onBefore, onFinish } from "@/Uses/request-inertia";
export default {
  name: "ForgotPassword",

  data() {
    return {
      formData: {
        email: "",
      },
      rules: {
        email: [
          {
            required: true,
            message: "Trường này không được để trống",
            trigger: "blur",
          },
          {
            type: "email",
            message: "Email không đúng định dạng",
            trigger: "change",
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
            route("customer.forgot_pasword", this.formData),
            {},
            { onBefore, onFinish, preserveScroll: true }
          );
        }
      });
    },
  },
};
</script>