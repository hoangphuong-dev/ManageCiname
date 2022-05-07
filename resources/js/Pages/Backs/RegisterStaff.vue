<template>
  <div class="login-form py-12 mt-32">
    <el-row :gutter="20">
      <el-col :sm="{ span: 12, offset: 6 }" :xs="{ span: 24, offset: 0 }">
        <el-card class="box-card">
          <h1 class="text-center">Đăng ký nhân viên</h1>
          <el-form
            :ref="formRegister"
            :model="formData"
            label-width="120px"
            label-position="top"
            :rules="rules"
          >
            <el-form-item prop="name" label="Họ tên">
              <el-input autocomplete="off" v-model="formData.name"></el-input>
            </el-form-item>

            <el-form-item prop="email" label="Email">
              <el-input autocomplete="off" v-model="formData.email"></el-input>
            </el-form-item>

            <el-form-item prop="phone" label="Số điện thoại">
              <el-input autocomplete="off" v-model="formData.phone"></el-input>
            </el-form-item>

            <el-form-item label="Chọn thành phố" prop="province_id">
              <el-select
                class="w-full"
                v-model="formData.province_id"
                clearable
              >
                <el-option
                  v-for="item in provinces"
                  :key="item.id"
                  :label="item.name"
                  :value="item.id"
                  @click="getCinemeByProvincce(item.id)"
                ></el-option>
              </el-select>
            </el-form-item>

            <el-form-item label="Chọn rạp làm việc" prop="cinema_id">
              <el-select class="w-full" v-model="formData.cinema_id" clearable>
                <el-option
                  v-for="item in cinemas"
                  :key="item.id"
                  :label="item.name"
                  :value="item.id"
                >
                  <div class="flex">
                    <div class="w-1/3">Rạp : {{ item.name }}</div>
                    <div class="w-2/3 text-right">
                      Địa chỉ : {{ item.address }}
                    </div>
                  </div>
                </el-option>
              </el-select>
            </el-form-item>

            <div class="w-full">
              <el-form-item prop="isAgree">
                <el-checkbox
                  v-model="formData.isAgree"
                  label="Đồng ý với điều khoản"
                ></el-checkbox>
              </el-form-item>
            </div>
            <el-form-item>
              <button
                class="btn-warning w-full"
                type="button"
                @click="submitForm"
              >
                Đăng ký
              </button>
            </el-form-item>
          </el-form>
        </el-card>
      </el-col>
    </el-row>
  </div>
</template>

<script>
import { reactive, ref } from "vue";
import { Inertia } from "@inertiajs/inertia";
import { onBefore, onFinish, onError } from "@/Uses/request-inertia";
import { useValidator } from "@/Uses/validator";
import AlertNoticeMixin from "@/Mixins/alert-notice";
import { getCinemaByProvince } from "@/API/main.js";

export default {
  name: "LoginAdmin",
  mixins: [AlertNoticeMixin],

  props: {
    provinces: {
      type: Object,
      require: true,
    },
  },
  data() {
    return {
      cinemas: [],
    };
  },
  methods: {
    async getCinemeByProvincce(province_id) {
      this.loading = true;
      await getCinemaByProvince(province_id)
        .then((res) => {
          this.cinemas = res.status === 200 ? res.data : [];
        })
        .catch(() => {});
      this.loading = false;
    },
  },

  setup() {
    const formRef = ref(null);
    const formRegister = (el) => (formRef.value = el);

    const obj = {
      name: "",
      email: "",
      phone: "",
      province_id: "",
      cinema_id: "",
      isAgree: false,
    };
    const formData = reactive({ ...obj });

    const validateError = reactive({
      ...obj,
    });

    const rules = reactive({
      name: [
        {
          required: true,
          message: "Trường này không được bỏ trống!",
          trigger: "blur",
        },
      ],
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
      phone: [
        {
          required: true,
          message: "Số điện thoại không được để trống !",
          trigger: "blur",
        },
      ],
      province_id: [
        {
          required: true,
          message: "Trường này không được để trống !",
          trigger: "blur",
        },
      ],
      cinema_id: [
        {
          required: true,
          message: "Trường này không được để trống !",
          trigger: "blur",
        },
      ],
      isAgree: [
        {
          required: true,
          message: "Vui lòng đồng ý với điều khoản!",
          trigger: "change",
        },
        {
          validator: function (rule, value, callback) {
            if (value == false) {
              return callback("Vui lòng đồng ý với điều khoản!");
            }
            callback();
          },
          trigger: "change",
        },
      ],
    });

    const submitForm = () => {
      formRef.value?.validate((valid) => {
        if (!valid) {
          return;
        }
        Inertia.post(route("back.staff.register"), formData, {
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
      formRegister,
      submitForm,
    };
  },
};
</script>
