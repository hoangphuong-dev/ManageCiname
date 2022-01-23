<template>
  <app-layout ClassMain="bg-white">
    <div class="login-form py-12">
      <el-row :gutter="20">
        <el-col :sm="{ span: 12, offset: 6 }" :xs="{ span: 24, offset: 0 }">
          <h1 class="text-center mt-16">Forgot Password</h1>
          <el-form
            :ref="setFormRef"
            :model="formData"
            label-position="top"
            :rules="rules"
          >
            <el-form-item prop="email" label="Email">
              <el-input autocomplete="off" v-model="formData.email"></el-input>
            </el-form-item>
            <br />
            <el-form-item>
              <button
                class="btn-warning w-full mb-52 mt-2"
                type="button"
                @click="handleChangePassword"
              >
                Submit
              </button>
            </el-form-item>
          </el-form>
        </el-col>
      </el-row>
    </div>
  </app-layout>
</template>

<script>
import { reactive, ref } from "vue";
import { Inertia } from "@inertiajs/inertia";
import { onBefore, onFinish, onError } from "@/Uses/request-inertia";
import { useValidator } from "@/Uses/validator";

export default {
  name: "LoginCommon",
  setup() {
    const formRef = ref(null);
    const setFormRef = (el) => (formRef.value = el);

    const obj = {
      email: "",
    };
    const formData = reactive({ ...obj });

    const validateError = reactive({
      ...obj,
    });

    const rules = reactive({
      email: [
        {
          required: true,
          message: "Please input",
          trigger: "blur",
        },
        {
          type: "email",
          message: "Please input correct email address",
          trigger: "change",
        },
        {
          validator: (rule, value, callback) =>
            useValidator(callback, validateError, "email"),
          trigger: "change",
        },
      ],
    });

    const handleChangePassword = () => {
      formRef.value?.validate((valid) => {
        if (!valid) {
          return;
        }

        Inertia.post(route("forgot-password.post"), formData, {
          onBefore,
          onFinish,
          onError: (errors) =>
            onError(errors, validateError, formRef.value, (errors) =>
              console.log(errors)
            ),
        });
      });
    };

    return {
      formData,
      rules,
      formRef,
      setFormRef,
      handleChangePassword,
    };
  },
};
</script>
