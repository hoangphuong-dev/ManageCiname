<template>
    <section class="HospitalForm my-8 bg-white px-10 py-6">
        <h1 class="mb-10 text-lightGreen">プロフィル情報</h1>
        <el-form label-position="top" :model="formData" ref="hospitalFormRef" :rules="rules">
            <el-form-item class="w-full text-lightGreen">
                <upload-image
                    classImage="form-image"
                    :listImage="listImage"
                    @uploadImage="handleUploadImage"
                    @removeImage="removeImage"
                ></upload-image>
            </el-form-item>

            <div class="flex w-full mt-5 gap-4">
                <div class="w-3/4">
                    <el-form-item label="病院名" prop="name" :error="$errors.first('name')">
                        <el-input v-model="formData.name" placeholder="name"></el-input>
                    </el-form-item>
                </div>
                <div class="w-1/4">
                    <el-form-item
                        label="Loại cơ sở y tế"
                        prop="hospital_type_id"
                        :error="$errors.first('hospital_type_id')"
                    >
                        <el-select class="w-full" v-model="formData.hospital_type_id" placeholder="Select">
                            <el-option
                                v-for="hospitalType in hospitalTypes"
                                :key="hospitalType.id"
                                :label="hospitalType.name"
                                :value="hospitalType.id"
                            ></el-option>
                        </el-select>
                    </el-form-item>
                </div>
            </div>

            <el-form-item label="住所" prop="address" :error="$errors.first('address')">
                <el-input v-model="formData.address" placeholder="address"></el-input>
            </el-form-item>

            <div class="flex w-full mb-4 gap-4">
                <div class="w-1/3">
                    <el-form-item label="メールアドレス" prop="email" :error="$errors.first('email')">
                        <el-input v-model="formData.email" placeholder="email"></el-input>
                    </el-form-item>
                </div>
                <div class="w-1/3">
                    <el-form-item label="電話番号" prop="phone" :error="$errors.first('phone')">
                        <el-input v-model="formData.phone" placeholder="phone number"></el-input>
                    </el-form-item>
                </div>
            </div>

            <el-form-item label="事業内容" prop="content" :error="$errors.first('content')">
                <el-input v-model="formData.content" :rows="10" type="textarea" placeholder="content"></el-input>
            </el-form-item>

            <div class="my-10 flex gap-4">
                <button class="btn-info min-w-132" @click.prevent="onSubmit">キャンセル</button>
                <button class="btn-warning min-w-132" @click.prevent="onSubmit">登録</button>
            </div>
        </el-form>
    </section>
</template>

<script>
import UploadImage from '@/Components/Profile/UploadImage.vue'
import { updateProfile } from '../../API/hospital.js'
import { toFormData } from '@/libs/form'
export default {
    name: 'HospitalForm',
    components: { UploadImage },
    props: {
        hospitalTypes: {
            type: Array,
            defaul: [],
        },
        hospital: Object,
    },

    data() {
        return {
            formData: {
                image: [],
                image_new: [],
                name: '',
                hospital_type_id: '',
                address: '',
                email: '',
                phone: '',
                content: '',
            },
            listImage: [],
            imagesDelete: [],
            rules: {
                name: [
                    {
                        required: true,
                        message: 'Please input name',
                        trigger: 'blur',
                    },
                ],
                hospital_type_id: [
                    {
                        required: true,
                        message: 'Please select hospital type',
                        trigger: 'change',
                    },
                ],
                address: [
                    {
                        required: true,
                        message: 'Please input address',
                        trigger: 'blur',
                    },
                ],
                email: [
                    {
                        required: true,
                        message: 'Please input address',
                        trigger: 'blur',
                    },
                ],
                phone: [
                    {
                        required: true,
                        message: 'Please input address',
                        trigger: 'blur',
                    },
                ],
                content: [
                    {
                        required: true,
                        message: 'Please input address',
                        trigger: 'blur',
                    },
                ],
            },
        }
    },
    created() {
        this.initData()
    },
    methods: {
        initData() {
            this.formData.image = this.hospital?.hospital_info?.image
            this.listImage = this.hospital?.hospital_info?.images

            this.formData.name = this.hospital.name
            this.formData.email = this.hospital?.email
            this.formData.hospital_type_id = this.hospital?.hospital_info?.hospital_type_id
            this.formData.address = this.hospital?.hospital_info?.address
            this.formData.phone = this.hospital?.hospital_info?.phone
            this.formData.content = this.hospital?.hospital_info?.content
        },
        async onSubmit() {
            this.$refs['hospitalFormRef'].validate(async (valid) => {
                if (valid) {
                    this.formData.image_delete = this.imagesDelete
                    await updateProfile(toFormData({ ...this.formData, _method: 'PUT' }, '', { indices: true }))
                        .then(async (res) => {
                            this.$message.success('Update success')
                            this.$inertia.visit(route('hospital.profile'))
                        })
                        .catch(() => {
                            this.$message.error('Server Error')
                        })
                }
            })
        },
        handleUploadImage(image) {
            this.formData.image_new.push(image)
        },
        removeImage(image) {
            const index = this.listImage.indexOf(image)
            const index1 = this.formData.image_new.indexOf(image)
            if (index !== -1) {
                this.listImage.splice(index, 1)

                const imageDelete = this.formData.image[index]
                this.imagesDelete.push(imageDelete)
                this.formData.image.splice(index, 1)
            }
        },
    },
}
</script>

<style>
.HospitalForm .form-image {
    width: 13.75rem;
    height: 13.75rem;
}
.HospitalForm .el-form-item {
    margin-bottom: 1rem;
}
.HospitalForm .el-form-item__label {
    font-size: 0.875rem;
    line-height: 0.875rem;
}
.HospitalForm .el-form-item__error {
    position: relative;
}
</style>
