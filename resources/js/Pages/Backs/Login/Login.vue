<template>
    <div class="login-form py-12 mt-32">
        <el-row :gutter="20">
            <el-col :sm="{ span: 12, offset: 6 }" :xs="{ span: 24, offset: 0 }">
                <el-card class="box-card">
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

                Inertia.post(route("back.login.post"), formData, {
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
            setFormRef,
            handleLogin
        };
    },
};
</script>
