<template>
    <div class="dialog-evaluation">
        <el-dialog v-model="dialogVisibleDetail" width="60%" :title="'求人評価'">
            <el-form label-position="top" :model="formData" :ref="setFormRef" :rules="rules">
                <div class="flex mb-8 text-lightGreen text-2xl font-bold">
                    <div class="w-1/2 text-center">
                        <div class="mb-4">面接～採用までのスムーズさ</div>
                        <rating @onEvaluate="formData.favorable_interview = $event"></rating>
                    </div>
                    <div class="w-1/2 text-center">
                        <div class="mb-4">面接の雰囲気の良さ</div>
                        <rating @onEvaluate="formData.atmosphere_interview = $event"></rating>
                    </div>
                </div>

                <el-form-item label="コメント" prop="content" :error="$errors.first('content')">
                    <el-input v-model="formData.content" placeholder="content" :rows="6" type="textarea"></el-input>
                </el-form-item>
            </el-form>

            <template #footer>
                <span class="dialog-footer flex justify-center gap-3">
                    <button class="btn-info" type="info" @click="handleClose">キャンセル</button>
                    <button class="btn-primary" type="info" @click="submitEvaluate">送信</button>
                </span>
            </template>
        </el-dialog>
    </div>
</template>

<script>
import { reactive, ref } from 'vue'
import Rating from '../Rating.vue'
import { ElMessage } from 'element-plus'
import { commentJob } from '../../API/user.js'
import { toFormData } from '@/libs/form'
export default {
    name: 'CommentForm',
    components: { Rating },
    props: {
        dialogVisibleDetail: Boolean,
        jobId: Number,
    },
    emits: ['closeDialog'],
    setup({ jobId }, { emit }) {
        const formRef = ref(null)
        const setFormRef = (el) => (formRef.value = el)

        const formData = reactive({
            content: '',
        })

        const handleClose = (_) => {
            formData.content = ''
            emit('closeDialog')
        }

        let rules = reactive({
            content: [
                {
                    required: true,
                    message: 'Please input',
                    trigger: 'blur',
                },
            ],
        })

        const submitEvaluate = async (_) => {
            formRef.value?.validate(async (valid) => {
                if (valid) {
                    await commentJob(jobId, toFormData({ ...formData }, '', { indices: true }))
                        .then(async (res) => {
                            ElMessage.success('Comment success.')
                            handleClose()
                        })
                        .catch(() => {
                            ElMessage.error('Oops, this is a error message.')
                        })
                }
            })
        }

        return { formData, submitEvaluate, handleClose, formRef, setFormRef, rules }
    },
}
</script>

<style>
</style>
