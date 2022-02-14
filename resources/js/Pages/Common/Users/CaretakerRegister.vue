<template>
  <app-layout ClassMain="bg-white">
    <div class="login-form">
      <h1 class="text-center text-yellowPrimary text-4xl pt-28 pb-10">
        Anfi ログイン
      </h1>
      <h2 style="color: #8cb012" class="text-center pb-7">
        看護師のアカウント登録
      </h2>
      <el-form
        class="w-3/12 m-auto"
        :ref="setFormRef"
        :model="formData"
        label-position="top"
        :rules="rules"
      >
        <el-form-item prop="email" label="メールアドレス">
          <el-input autocomplete="off" v-model="formData.email"></el-input>
        </el-form-item>

        <el-form-item label="パスワード" prop="password">
          <el-input
            v-model="formData.password"
            type="password"
            autocomplete="off"
          ></el-input>
        </el-form-item>

        <el-form-item label="パスワード（確認）" prop="confirmPassword">
          <el-input
            v-model="formData.confirmPassword"
            type="password"
            autocomplete="off"
          ></el-input>
        </el-form-item>

        <el-form-item prop="isAgree">
          <div class="w-full mt-1 mb-3 flex justify-between">
            <el-checkbox
              v-model="formData.isAgree"
              label="利用規約に同意する"
            ></el-checkbox>
          </div>
        </el-form-item>

        <el-form-item>
          <button
            class="btn-warning w-full font-bold text-xl"
            type="button"
            @click="onSubmitForm"
          >
            アカウント登録
          </button>
        </el-form-item>

        <div class="w-full">
          <a :href="route('show_login')" class="forgot_password"
            >すでに登録済みのキャストはログイン</a
          >
        </div>

        <el-form-item>
          <div class="flex justify-center">
            <el-button
              @click="loginWithGoogle"
              size="medium"
              class="text-center rounded-2xl button_google"
            >
              <div class="flex justify-center items-center">
                <img class="w-10 mr-2" src="/images/svg/google.svg" alt="" />
                <p>ググールアカウントでログイン</p>
              </div>
            </el-button>
          </div>
        </el-form-item>
      </el-form>
    </div>
  </app-layout>
</template>

<script>
import { reactive, ref } from "vue";
import { onError, onBefore, onFinish } from "@/Uses/request-inertia";
import { useValidator } from "@/Uses/validator";
import { Inertia } from "@inertiajs/inertia";

export default {
  name: "CaretakerRegister",

  setup() {
    const formRef = ref(null);
    const setFormRef = (el) => (formRef.value = el);

    const formOriginal = {
      email: "",
      password: "",
      confirmPassword: "",
      isAgree: null,
    };

    const formData = reactive({
      ...formOriginal,
    });

    const loginWithGoogle = (_) => {
      window.location.href = route("google.login");
    };

    const validateError = reactive({
      ...formOriginal,
    });

    let rules = reactive({
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
      password: [
        {
          required: true,
          message: "Please input",
          trigger: "blur",
        },
      ],
      isAgree: [
        {
          required: true,
          message: "Please ckick agree",
          trigger: "blur",
        },
      ],
      confirmPassword: [
        {
          required: true,
          message: "Please input",
          trigger: "blur",
        },
        {
          validator: function (rule, value, callback) {
            if (value.trim() !== formData.password) {
              return callback("Confirm password don't match!");
            }
            callback();
          },
          trigger: "change",
        },
      ],
    });

    const onSubmitForm = () => {
      formRef.value?.validate((valid) => {
        if (valid) {
          Inertia.post(route("caretaker.register.post"), formData, {
            forceFormData: true,
            onError: (errors) =>
              onError(errors, validateError, formRef.value, (errors) =>
                console.log(errors)
              ),
            onBefore,
            onFinish,
          });
        }
      });
    };

    return {
      formData,
      rules,
      setFormRef,
      formRef,
      onSubmitForm,
      loginWithGoogle,
    };
  },
};
</script>


















<style>
.el-dropdown-menu__item,
.register,
.forgot_password {
  color: #8cb012;
}
.el-popper__arrow {
  display: none !important;
}
.el-dropdown__popper.el-popper[role="tooltip"] {
  left: 61% !important;
  top: 655px !important;
}
.el-form--label-top .el-form-item__label {
  padding: 0px;
}
.el-form-item__label {
  line-height: 25px;
}
.forgot_password .el-link--inner,
.register .el-link--inner {
  color: #8cb012;
}

.forgot_password:hover,
.register:hover {
  border-bottom: 2px solid #8cb012;
}
</style>

<style scoped>
.button_google {
  margin-top: 50px;
  border-radius: 50px;
  margin-bottom: 50px;
  padding: 13px;
}
</style>
