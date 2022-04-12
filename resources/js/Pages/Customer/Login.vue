<template>
  <app-layout>
    <div class="py-12">
      <div class="mx-auto messenger-window__custom">
        <div class="w-full">
          <div class="main-jobs">
            <el-card class="box-card w-1/2 m-auto my-20">
              <h1 class="text-center">Đăng nhập</h1>
              <el-form
                :ref="setFormRef"
                :model="formData"
                label-width="120px"
                label-position="top"
                :rules="rules"
              >
                <el-form-item prop="email" label="Email" class="cs-lbl">
                  <el-input
                    autocomplete="off"
                    v-model="formData.email"
                    @keyup.enter="handleLogin"
                  ></el-input>
                </el-form-item>
                <el-form-item
                  label="Mật khẩu"
                  prop="password"
                  class="none-margin cs-lbl"
                >
                  <el-input
                    v-model="formData.password"
                    type="password"
                    autocomplete="off"
                    @keyup.enter="handleLogin"
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
                    class="btn-warning w-full"
                    type="button"
                    @click="handleLogin"
                  >
                    Đăng nhập
                  </button>
                </el-form-item>
              </el-form>
              <div class="text-right">
                <a class="cursor-pointer" @click="forgotPass()"
                  >Quên mật khẩu</a
                >
              </div>
            </el-card>
          </div>
        </div>
      </div>
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
  name: "LoginAdmin",
  mixins: [AlertNoticeMixin],
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
          message: "Emai không được để trống !",
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

        Inertia.post(route("customer.login"), formData, {
          onBefore,
          onFinish,
          onError: (errors) =>
            onError(errors, validateError, formRef.value, (errors) =>
              console.log(errors)
            ),
        });
      });
    };

    const forgotPass = () => {
      Inertia.get(route("customer.forgot_pasword"), {});
    };

    return {
      formData,
      rules,
      formRef,
      setFormRef,
      handleLogin,
      forgotPass,
    };
  },
};
</script>