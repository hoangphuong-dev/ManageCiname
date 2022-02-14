<template>
    <div class="login-form py-12 mt-32">
        <el-row :gutter="20">
            <el-col :sm="{ span: 12, offset: 6 }" :xs="{ span: 24, offset: 0 }">
                <el-card class="box-card">
                    <h1 class="text-center">Dang ky nhan vien</h1>
                    <el-form
                        :ref="formRegister"
                        :model="formData"
                        label-width="120px"
                        label-position="top"
                        :rules="rules"
                    >
                        <el-form-item prop="name" label="Ho ten">
                            <el-input
                                autocomplete="off"
                                v-model="formData.name"
                            ></el-input>
                        </el-form-item>

                        <el-form-item prop="email" label="Email">
                            <el-input
                                autocomplete="off"
                                v-model="formData.email"
                            ></el-input>
                        </el-form-item>

                        <el-form-item prop="phone" label="So dien thoai">
                            <el-input
                                autocomplete="off"
                                v-model="formData.phone"
                            ></el-input>
                        </el-form-item>

                        <div class="w-full mt-1 mb-3 flex justify-between">
                            <el-checkbox
                                v-model="formData.isAgree"
                                label="Dong y "
                            ></el-checkbox>
                        </div>
                        <el-form-item>
                            <button
                                class="btn-warning w-full"
                                type="button"
                                @click="submitForm"
                            >
                                Dang ky
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
import AlertNoticeMixin from '@/Mixins/alert-notice';

export default {
    name: "LoginAdmin",
    mixins: [
        AlertNoticeMixin
    ],
    setup() {
        const formRef = ref(null);
        const formRegister = (el) => (formRef.value = el);

        const obj = {
            name: "",
            email: "",
            phone: "",
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
                    message: "Mật khẩu không được để trống !",
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
                    message: "Phone không được để trống !",
                    trigger: "blur",
                },
            ],
            isAgree: [
                {
                    required: true,
                    message: "Phone không được để trống !",
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
                        onError(errors, validateError, formRef.value, errors => console.log(errors)),
                });
            });
        };

        return {
            formData,
            rules,
            formRef,
            formRegister,
            submitForm
        };
    },
};
</script>
