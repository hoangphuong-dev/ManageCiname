<template>
    <app-layout ClassMain="bg-white">
        <div class="py-12">
            <div class="mx-auto messenger-window__custom mb-6">
                <div class="bg-white overflow-hidden  md:px-16 md:py-5 px-8 py-3">
                    <div class="w-full">
                        <section class="HospitalForm bg-white max-w-7xl mx-auto px-10 py-6">
                            <h1 class="mb-10 text-lightGreen text-center">プロフィル情報</h1>

                            <el-form label-position="top" :model="formData" :ref="setFormRef" :rules="rules">
                                <el-form-item class="w-full mb-4 text-lightGreen">
                                    <upload-image
                                        classImage="form-image"
                                        @uploadImage="handleUploadImage"
                                        @removeImage="removeImage"
                                    ></upload-image>
                                    <div class="el-form-item__error" v-if="formData.listImage?.length == 0 && isSubmit">
                                        {{ rules.listImage.msg }}
                                    </div>
                                </el-form-item>

                                <div class="flex w-full mt-6 gap-4">
                                    <div class="w-3/4">
                                        <el-form-item label="病院名" prop="name">
                                            <el-input v-model="formData.name"></el-input>
                                        </el-form-item>
                                    </div>
                                    <div class="w-1/4">
                                        <el-form-item label="Loại cơ sở y tế" prop="hospitalType">
                                            <el-select
                                                class="w-full"
                                                v-model="formData.hospitalType"
                                                placeholder="Select"
                                            >
                                                <el-option
                                                    v-for="item in hospitalTypes"
                                                    :key="item.id"
                                                    :label="item.name"
                                                    :value="item.id"
                                                ></el-option>
                                            </el-select>
                                        </el-form-item>
                                    </div>
                                </div>

                                <el-form-item class="mt-6" label="住所" prop="address">
                                    <el-input v-model="formData.address"></el-input>
                                </el-form-item>

                                <div class="flex w-full mt-6 gap-4">
                                    <div class="w-1/3">
                                        <el-form-item label="メールアドレス" prop="email">
                                            <el-input v-model="formData.email"></el-input>
                                        </el-form-item>
                                    </div>
                                    <div class="w-1/3">
                                        <el-form-item label="電話番号" prop="phone">
                                            <el-input v-model="formData.phone"></el-input>
                                        </el-form-item>
                                    </div>
                                </div>

                                <el-form-item label="事業内容" class="mt-6" prop="content">
                                    <el-input v-model="formData.content" :rows="10" type="textarea"></el-input>
                                </el-form-item>

                                <div class="my-10 flex justify-center mt-6">
                                    <button class="btn-info mr-4" type="button">キャンセル</button>
                                    <button class="btn-warning" @click="onSubmitForm" type="button">登録</button>
                                </div>
                            </el-form>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
import UploadImage from '@/Components/UploadImage.vue';
import { reactive, ref } from 'vue';
import { onError, onBefore, onFinish } from '@/Uses/request-inertia';
import { useValidator } from '@/Uses/validator';
import { Inertia } from '@inertiajs/inertia';

export default {
    name: 'HospitalRegister',
    components: {
        UploadImage,
    },
    props: {
        hospitalTypes: {
            type: Array,
            required: true,
        },
    },
    setup() {
        const formRef = ref(null);
        const setFormRef = (el) => (formRef.value = el);

        const formOriginal = {
            name: '',
            hospitalType: null,
            listImage: [],
            address: '',
            email: '',
            phone: '',
            content: '',
        };

        const formData = reactive({ ...formOriginal });

        const validateError = reactive({
            ...formOriginal,
            hospitalType: '',
            listImage: '',
        });

        let rules = reactive({
            name: [
                {
                    required: true,
                    message: 'Please input',
                    trigger: 'blur',
                },
            ],
            address: [
                {
                    required: true,
                    message: 'Please input',
                    trigger: 'change',
                },
            ],
            phone: [
                {
                    required: true,
                    message: 'Please input',
                    trigger: 'blur',
                },
                {
                    validator: function(err, value, callback) {
                        let val = value.replace(/\s+/g, ' ');
                        if(!(val.length >= 9 && val.length <= 12) || value.includes(' ')) {
                            return callback('Please input correct phone number');
                        }
                        callback();
                    },
                    trigger: 'change',
                },
            ],
            hospitalType: [
                {
                    required: true,
                    message: 'Please input',
                    trigger: 'blur',
                },
            ],
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
            listImage: {
                msg: 'Please input',
            },
        });

        const isSubmit = ref(false);

        const handleUploadImage = (image) => {
            if (image) {
                formData.listImage.push(image);
            }
        };

        const removeImage = (index) => {
            formData.listImage.splice(index, 1);
        };

        const onSubmitForm = () => {
            isSubmit.value = true;
            formRef.value?.validate((valid) => {
                if (valid) {
                    Inertia.post(route('hospital.register.post'), formData, {
                        forceFormData: true,
                        onError: (errors) => onError(errors, validateError, formRef.value),
                        onBefore,
                        onFinish,
                    });
                }
            });
        };

        return {
            formData,
            rules,
            validateError,
            isSubmit,
            setFormRef,
            formRef,
            handleUploadImage,
            removeImage,
            onSubmitForm,
        };
    },
};
</script>

<style>
.HospitalForm .form-image {
    width: 13.75rem;
    height: 13.75rem;
}

.HospitalForm .el-form-item {
    margin-bottom: 0;
}

.HospitalForm .el-form-item__label {
    font-size: 0.875rem;
    line-height: 0.875rem;
}
</style>
