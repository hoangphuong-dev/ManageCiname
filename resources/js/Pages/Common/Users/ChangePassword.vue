<template>
    <app-layout title="Dashboard">
        <div class="login-form py-12">
            <el-row :gutter="20">
                <el-col :sm="{ span: 12, offset: 6 }" :xs="{ span: 24, offset: 0 }">
                    <el-card class="box-card">
                        <br>
                        <h1 class="text-center">Change Password</h1>
                        <br>
                        <el-form
                            :ref="setFormRef"
                            :model="formData"
                            label-width="120px"
                            label-position="top"
                            :rules="rules"
                        >
                            <el-form-item prop="email" label="Email" class="cs-lbl">
                                <el-input autocomplete="off" v-model="formData.email"></el-input>
                            </el-form-item>
                            <el-form-item label="Current Password" prop="oldPassword" class="cs-lbl">
                                <el-input v-model="formData.oldPassword" type="password" autocomplete="off"></el-input>
                            </el-form-item>
                            <el-form-item label="New Password" prop="newPassword" class="cs-lbl">
                                <el-input v-model="formData.newPassword" type="password" autocomplete="off"></el-input>
                            </el-form-item>
                            <el-form-item label="Confirm Password" prop="confirmPassword" class="cs-lbl">
                                <el-input v-model="formData.confirmPassword" type="password" autocomplete="off"></el-input>
                            </el-form-item>
                            <br>
                            <el-form-item>
                                <button class="btn-warning w-full" type="button" @click="handleChangePassword">Change</button>
                            </el-form-item>
                        </el-form>
                    </el-card>
                </el-col>
            </el-row>
        </div>
    </app-layout>
</template>

<script>
import { reactive, ref } from 'vue';
import { Inertia } from '@inertiajs/inertia';
import { onBefore, onFinish, onError } from '@/Uses/request-inertia';
import { useValidator } from '@/Uses/validator';

export default {
    name: 'LoginCommon',
    setup() {
        const formRef = ref(null);
        const setFormRef = (el) => (formRef.value = el);

        const obj = {
            email: '',
            oldPassword: '',
            newPassword: '',
            confirmPassword: ''
        };
        const formData = reactive({...obj});

        const validateError = reactive({
            ...obj,
        });

        const rules = reactive({
            email: [
                {
                    required: true,
                    message: 'Please input',
                    trigger: 'blur',
                },
                {
                    type: 'email',
                    message: 'Please input correct email address',
                    trigger: 'change',
                },
                {
                    validator: (rule, value, callback) => useValidator(callback, validateError, 'email'),
                    trigger: 'change',
                },
            ],
            oldPassword: [
                {
                    required: true,
                    message: 'Please input',
                    trigger: 'blur',
                },
                {
                    min: 8,
                    message: 'Length should be 8',
                    trigger: 'blur',
                },
            ],
            newPassword: [
                {
                    required: true,
                    message: 'Please input',
                    trigger: 'blur',
                },
                {
                    min: 8,
                    message: 'Length should be 8',
                    trigger: 'blur',
                },
            ],
            confirmPassword: [
                {
                    required: true,
                    message: 'Please input',
                    trigger: 'blur',
                },
                {
                    validator: function (rule, value, callback) {
                        if (value.trim() !== formData.newPassword) {
                            return callback("Confirm password don't match!");
                        }
                        callback();
                    },
                    trigger: 'change',
                },
                {
                    min: 8,
                    message: 'Length should be 8',
                    trigger: 'blur',
                },
            ],

        });

        const handleChangePassword = () => {
            formRef.value?.validate((valid) => {
                if (!valid) {
                    return;
                }

                Inertia.post(route('change-password.post'), formData, {
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
            handleChangePassword
        };
    },
};
</script>

<style scoped>
.el-form-item.none-margin {
    margin-bottom: 0;
}

.login-with {
    width: 100%;
    text-align: center;
}

.user-type {
    color: #4baaff;
}

.txt-caretaker {
    text-align: center;
    color: gray;
    font-size: 10px;
    line-height: 15px;
}
</style>
