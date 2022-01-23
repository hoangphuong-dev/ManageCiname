<template>
  <app-layout ClassMain="bg-white">
    <div class="login-form mb-16">
      <h1 class="text-center text-4xl pt-20 pb-10">Đăng nhập</h1>

      <el-form
        class="w-3/12 m-auto"
        :ref="setFormRef"
        :model="formData"
        label-position="top"
        :rules="rules"
      >
        <el-form-item prop="email" label="Email">
          <el-input autocomplete="off" v-model="formData.email"></el-input>
        </el-form-item>

        <el-form-item label="Mật khẩu" prop="password">
          <el-input
            v-model="formData.password"
            type="password"
            autocomplete="off"
          ></el-input>
        </el-form-item>

        <div class="w-full mt-1 mb-3 flex justify-between">
          <el-checkbox
            v-model="formData.isRemember"
            label="Ghi nhớ đăng nhập"
          ></el-checkbox>
        </div>

        <el-form-item>
          <button
            class="btn-warning w-full font-bold text-xl"
            type="button"
            @click="handleLogin"
          >
            Đăng nhập
          </button>
        </el-form-item>
        <div class="flex">
          <div class="w-1/2">
            <a :href="route('forgot-password.get')" class="forgot_password"
              >Quên mật khẩu</a
            >
          </div>
        </div>
      </el-form>
    </div>
  </app-layout>
</template>

<script>
import { reactive, ref } from "vue";
import { Inertia } from "@inertiajs/inertia";
import { onBefore, onFinish, onError } from "@/Uses/request-inertia";
import { useValidator } from "@/Uses/validator";
import AlertNoticeMixin from "@/Mixins/alert-notice";

export default {
  name: "Login",
  mixins: [AlertNoticeMixin],
  components: {},
  setup() {
    const formRef = ref(null);
    const setFormRef = (el) => (formRef.value = el);
    const obj = {
      email: "",
      password: "",
      isRemember: false,
    };
    const formData = reactive({ ...obj });

    const validateError = reactive({
      ...obj,
    });

    const rules = reactive({
      email: [
        {
          required: true,
          message: "Email không được để trống !",
          trigger: "blur",
        },
        {
          type: "email",
          message: "Email không đúng định dạng !",
          trigger: "change",
        },
        {
          validator: (rule, value, callback) =>
            useValidator(callback, validateError, "email"),
          trigger: "change",
        },
      ],
      password: [
        {
          required: true,
          message: "Mật khẩu không được để trống !",
          trigger: "blur",
        },
        {
          validator: (rule, value, callback) =>
            useValidator(callback, validateError, "password"),
          trigger: "change",
        },
      ],
    });

    const handleLogin = () => {
      formRef.value?.validate((valid) => {
        if (!valid) {
          return;
        }
        Inertia.post(route("login"), formData, {
          onBefore,
          onFinish,
          onError: (errors) => onError(errors, validateError, formRef.value),
        });
      });
    };

    return {
      formData,
      rules,
      formRef,
      setFormRef,
      handleLogin,
    };
  },
};
</script>

<style scoped>
.forgot_password:hover {
  border-bottom: 2px solid black;
}
</style>
