<template>
    <div class="main-jobs__item">
        <div class="main-jobs__title">
            <div class="hover:cursor-pointer" @click="$inertia.get(route('caretaker.job_detail', job?.id))">
                {{ job.name }}
            </div>
        </div>
        <div class="main-jobs__detail">
            <div class="grid grid-cols-1 lg:grid-cols-2">
                <div>
                    <div class="el-tag--border" v-if="(jobItem.tags || []).length > 0">
                        <el-tag
                            v-for="(item, indexTag) in jobItem.tags"
                            :key="indexTag"
                            effect="plain"
                            class="el-tag--radius el-tag--background el-tag--padding"
                        >
                            {{ item.name }}
                        </el-tag>
                    </div>

                    <div
                        class="flex"
                        :style="{
                            'border-top': (jobItem.tags || []).length === 0 ? '1px dashed #979797' : null,
                        }"
                    >
                        <div class="flex flex-col justify-center items-center main-jobs__list-label">
                            <el-image :src="`/images/svg/jobs/building.svg`"></el-image>
                            <div>会社名</div>
                        </div>
                        <div class="main-jobs__list-content">
                            {{ job.hospital_name }}
                        </div>
                    </div>

                    <div class="flex">
                        <div class="flex flex-col justify-center items-center main-jobs__list-label">
                            <el-image :src="`/images/svg/jobs/address.svg`"></el-image>
                            <div>住所</div>
                        </div>
                        <div class="main-jobs__list-content">
                            {{ jobItem.address }}
                        </div>
                    </div>

                    <div class="flex">
                        <div class="flex flex-col justify-center items-center main-jobs__list-label">
                            <el-image :src="`/images/svg/jobs/salary.svg`"></el-image>
                            <div>年収</div>
                        </div>
                        <div class="main-jobs__list-content">
                            {{ jobItem.annual_income_min }}万円～{{ jobItem.annual_income_max }}万円程度
                        </div>
                    </div>

                    <div class="flex">
                        <div class="flex flex-col justify-center items-center main-jobs__list-label">
                            <el-image :src="`/images/svg/jobs/train.svg`"></el-image>
                            <div>最寄り駅</div>
                        </div>
                        <div class="main-jobs__list-content">{{ job.nearest_station }}</div>
                    </div>

                    <div class="flex">
                        <div class="flex flex-col justify-center items-center main-jobs__list-label">
                            <el-image :src="`/images/svg/jobs/time.svg`"></el-image>
                            <div>勤務時間</div>
                        </div>
                        <div class="main-jobs__list-content">
                            {{ generateWorkingHour(jobItem.working_hours) }}
                        </div>
                    </div>

                    <div class="flex">
                        <div class="flex flex-col justify-center items-center main-jobs__list-label">
                            <el-image :src="`/images/svg/jobs/calendar.svg`"></el-image>
                            <div>休暇制度</div>
                        </div>
                        <div class="main-jobs__list-content">
                            {{ generateWorkingHour(jobItem.holidays) }}
                        </div>
                    </div>

                    <div class="flex">
                        <div class="flex flex-col justify-center items-center main-jobs__list-label">
                            <el-image :src="`/images/svg/Vector.svg`"></el-image>
                            <div>雇用形態</div>
                        </div>
                        <div class="main-jobs__list-content">{{ job.type_of_work_name }}</div>
                    </div>
                </div>
                <div
                    class="main-jobs__img"
                    :style="{
                        'background-image': `url(${(jobItem?.images || [])[0]?.url})`,
                    }"
                ></div>
            </div>
            <hr class="w-full my-6" />

            <!-- Show comment -->
            <div v-if="jobSelect === indexJob" class="ml-10">
                <div v-for="(comment, index) in comments" :key="index">
                    <div class="flex">
                        <div class="w-2/3 text-base text-blackPrimary-500 mb-4">
                            {{ comment.content }}
                        </div>
                        <div class="w-1/3 flex justify-end">
                            <div class="mr-2 text-blackPrimary-300">表示・非表示</div>
                            <el-switch
                                v-model="comment.status"
                                :active-value="COMMENT_STATUS_SHOW"
                                :inactive-value="COMMENT_STATUS_HIDE"
                                active-color="#a5c242"
                                inactive-color="#cccccc"
                                @change="handleChangeStatusComment(comment.id, $event)"
                            />
                        </div>
                    </div>
                    <div class="flex items-center text-blackPrimary-300">
                        <div class="w-2/3 flex items-center">
                            <div class="w-16 h-16">
                                <el-image class="h-full w-full" :src="comment?.user?.avatar_url" alt="" />
                            </div>
                            <div class="font-bold text-blackPrimary-500 text-xl mx-5">{{ comment?.user?.name }}</div>
                            <div class="py-1.5 px-2 bg-grayPrimary rounded">ID: {{ comment?.user?.id }}</div>
                        </div>
                        <div class="w-1/3 text-right">レビュー日時: {{ formatDateTime(comment.created_at) }}</div>
                    </div>
                    <hr class="w-full mt-8 mb-6" />
                </div>

                <div class="w-full mb-4 text-center table-paginattion">
                    <el-pagination
                        :page-size="Number(pages.per_page)"
                        :pager-count="5"
                        layout="prev, pager, next"
                        :total="Number(pages.total)"
                        :current-page="filter.page || 1"
                        :background="true"
                        @current-change="handleCurrentChange"
                    ></el-pagination>
                </div>
            </div>

            <div class="lg:flex footer">
                <div class="flex lg:w-1/2">
                    <div class="w-1/2 flex items-center">
                        <img class="mr-2" src="/images/svg/comment.svg" alt="" />
                        <div class="text-2xl font-bold">レビュー数：8件</div>
                    </div>
                </div>
                <div class="flex justify-end lg:w-1/2">
                    <div
                        @click="showListComment(indexJob)"
                        class="
                            flex
                            items-center
                            justify-center
                            py-2
                            px-4
                            hover:cursor-pointer
                            text-yellowPrimary
                            border border-solid border-yellowPrimary
                            rounded
                        "
                    >
                        <span class="mr-1">{{ toggleShow ? '省略' : '応募詳細' }}</span>
                        <svg
                            :class="{ 'rotate-180': toggleShow }"
                            xmlns="http://www.w3.org/2000/svg"
                            width="18"
                            height="11"
                            viewBox="0 0 18 11"
                            fill="none"
                        >
                            <path d="M1 1L9 9L17 0.999999" stroke="#FCA442" stroke-width="2" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import { reactive, ref } from 'vue'
import CareTakerInfoTable from '../CareTaker/CareTakerInfoTable.vue'
import { listCommentJob, updateStatusComment } from '../../API/hospital.js'
import { ElMessageBox, ElMessage } from 'element-plus'
import { formatDateTime } from '@/libs/datetime'
import { COMMENT_STATUS_SHOW, COMMENT_STATUS_HIDE } from '@/store/const.js'

export default {
    components: { CareTakerInfoTable },
    props: {
        job: Object,
        indexJob: Number,
    },
    setup(props) {
        const jobItem = reactive(props.job)
        const jobSelect = ref('')
        const status = ref(0)
        const toggleShow = ref(false)

        const generateWorkingHour = (workingHours) => {
            try {
                return workingHours.join(' ')
            } catch (error) {
                return ''
            }
        }

        const showListComment = async (indexJob) => {
            toggleShow.value = !toggleShow.value
            if (jobSelect.value === indexJob) {
                jobSelect.value = ''
            } else {
                await getListComment()
                jobSelect.value = indexJob
            }
        }

        const pages = ref([])
        const filter = reactive({
            page: 1,
            limit: 10,
        })
        const comments = ref([])
        const getListComment = async (_) => {
            await listCommentJob(jobItem.id, filter)
                .then(async ({ data }) => {
                    comments.value = data.data
                    pages.value = data.meta
                })
                .catch(() => {
                    ElMessage.error('Oops, this is a error message.')
                })
        }

        const handleCurrentChange = (page) => {
            filter.page = page
            getListComment()
        }

        const handleChangeStatusComment = async (commentId, status) => {
            ElMessageBox.confirm('Are you sure to change this?', 'Warning', {
                confirmButtonText: 'OK',
                cancelButtonText: 'Cancel',
                type: 'warning',
            })
                .then(async () => {
                    await updateStatusComment(commentId, status)
                        .then(async (res) => {
                            ElMessage.success('Update success.')
                        })
                        .catch(() => {
                            getListComment()
                            ElMessage.error('Oops, this is a error message.')
                        })
                })
                .catch(() => {
                    ElMessage.info('Canceled.')
                    getListComment()
                })
        }

        return {
            jobItem,
            jobSelect,
            showListComment,
            generateWorkingHour,
            toggleShow,
            status,
            comments,
            formatDateTime,
            getListComment,
            pages,
            filter,
            handleCurrentChange,
            handleChangeStatusComment,
            COMMENT_STATUS_SHOW,
            COMMENT_STATUS_HIDE,
        }
    },
}
</script>

<style scoped>
.main-jobs__item {
    background: #ffffff;
    border: 1px solid #cccccc;
    border-radius: 8px;
    position: relative;
    padding: 50px 40px 50px 40px;
    margin-bottom: 24px;
}
.main-jobs__star {
    width: 76px;
    height: 76px;
    border: 1px solid #fca442;
    border-bottom-left-radius: 100%;
    border-top-right-radius: 8px;
    position: absolute;
    top: -1px;
    right: -1px;
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 100;
}
.main-jobs__star-img {
    margin-top: -15px;
    margin-right: -15px;
}
.main-jobs__title {
    font-style: normal;
    font-weight: bold;
    font-size: 24px;
    line-height: 32px;
    margin-bottom: 32px;
    color: #8cb012;
}
.el-tag--border {
    border: 1px dashed #979797;
    padding: 11px 25px;
}
.el-tag--background {
    background: #f5f5f5;
    border-radius: 16px;
    border: none;
    color: #5b5b5b;
}
.el-tag--padding {
    margin-bottom: 10px;
}
.main-jobs__list-label {
    width: 100px;
    border: 1px dashed #979797;
    border-top: none;
    padding-top: 10px;
    padding-bottom: 10px;
}
.main-jobs__list-content {
    display: flex;
    align-items: center;
    width: 100%;
    padding-left: 28px;
    border-right: 1px dashed #979797;
    border-bottom: 1px dashed #979797;
}
.main-jobs__img {
    background-color: pink;
    background-size: cover;
}
.footer__button {
    text-decoration: none;
    background-color: #92c948;
    color: #fff;
    padding: 7px 10px;
    border-top: 1px solid #cccccc;
    border-radius: 8px;
    font-style: normal;
    font-weight: bold;
    font-size: 24px;
    line-height: 32px;
}
.footer__button--color {
    background-color: #fca442;
}
.footer__button--margin {
    margin-left: 80px;
}
.footer__couting {
    background: #f5f5f5;
    border-radius: 4px;
    padding: 0px 3px;
}
.footer__couting > span {
    font-style: normal;
    font-weight: normal;
    font-size: 14px;
    list-style: 100%;
    color: #5b5b5b;
}

@media (max-width: 1200px) {
    .footer__button {
        padding: 7px 65px;
    }
}
@media (max-width: 1024px) {
    .footer__button {
        padding: 7px 20px;
        font-size: 16px;
    }
    .footer__couting {
        padding: 0px;
    }
}
@media (max-width: 768px) {
    .main-jobs__img {
        height: 350px;
    }
    .footer__button {
        font-size: 16px;
    }
    .div_button {
        width: 100%;
        font-size: 20px;
    }
    .div_footer__couting {
        margin-top: 20px;
    }
    .footer__couting {
        padding: 10px 3px;
    }
}
@media (max-width: 992px) {
    .main-jobs__img {
        height: 350px;
    }
}
@media (max-width: 640px) {
    .footer__couting {
        width: 40%;
    }
}
@media (max-width: 425px) {
    .footer__button {
        width: 100%;
        padding: 5px;
    }
    .main-job__foverite {
        flex: none;
    }

    .footer__couting {
        width: auto;
        padding: 10px 3px;
    }
}
@media (max-width: 320px) {
    .footer__button {
        width: 100%;
        padding: 5px;
        font-size: 12px;
    }
    .im-star {
        width: 25px !important;
        margin-right: 2px;
    }
}

.rate_counter {
    font-weight: bold;
    color: #fba442;
    margin-top: 3px;
    white-space: nowrap;
}

.favorite-job {
    background: #fba442;
}

@media (max-width: 480px) {
    .im-star {
        width: 30px;
        margin-right: 4px;
    }
}

.bg-reapply {
    background-color: #ff0000ad;
}
</style>
