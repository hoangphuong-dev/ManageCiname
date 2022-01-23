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
                        <div class="main-jobs__list-content">
                            {{ job.nearest_station }}
                        </div>
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
                        <div class="main-jobs__list-content">
                            {{ job.type_of_work_name }}
                        </div>
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

            <div v-if="jobSelect === indexJob" class="ml-10">
                <template v-if="jobApplies.length > 0">
                    <div v-for="(jobApply, index) in jobApplies" :key="index">
                        <div class="flex mb-5">
                            <div class="w-1/2 flex items-center text-yellowPrimary">
                                <div class="text-blackPrimary-500 mr-4 font-bold text-xl">
                                    {{ jobApply?.user?.name }}
                                </div>
                                <div class="rounded p-1 mr-2 bg-grayPrimary">ID:{{ jobApply?.user?.id }}</div>
                                <div class="rounded p-1 mr-2 bg-grayPrimary">
                                    {{ jobApply?.user?.user_info?.age }}歳
                                </div>
                                <div class="rounded p-1 mr-2 bg-grayPrimary">
                                    {{ jobApply?.user?.user_info?.gender }}
                                </div>

                                <button
                                    class="btn-warning p-1"
                                    @click="
                                        $inertia.get(
                                            route('hospital.jobs.caretaker-detail', {
                                                job_id: jobApply.job_id,
                                                caretaker_id: jobApply?.user?.id,
                                                type: jobApply.textStatus,
                                            })
                                        )
                                    "
                                >
                                    Detail
                                </button>
                            </div>
                            <div class="w-1/2 flex item-center justify-end">
                                <p>応募日時:{{ jobApply?.created_at }}</p>
                                &nbsp; &nbsp; &nbsp;
                                <div class="w-10 h-10 p-2.5 bg-lightGreen rounded-full relative flex justify-center">
                                    <el-image src="/images/svg/chat.svg"></el-image>
                                    <span class="w-4 h-4 bg-redPrimary absolute -top-1 right-0 rounded-full"></span>
                                </div>
                            </div>
                        </div>
                        <care-taker-info-table classCustom="mb-7" :caretaker="jobApply.user"></care-taker-info-table>

                        <el-row>
                            <el-col :xs="24" :md="12">
                                <step-process :jobStep="jobApply.job_post_apply" :processes="processes"></step-process>
                            </el-col>
                        </el-row>
                        <hr class="w-full my-7" />
                    </div>
                </template>
                <template v-else>
                    <el-empty description="No Data"></el-empty>
                </template>
            </div>

            <div class="lg:flex footer">
                <div class="flex lg:w-1/2">
                    <div class="w-1/2 flex items-center">
                        <img class="mr-2" src="/images/svg/jobs/star-total.svg" alt="" />
                        <div class="text-2xl font-bold">{{ job.rateCount }} お気に入り数</div>
                    </div>
                    <div class="w-1/2 flex items-center">
                        <img class="mr-2" src="/images/svg/jobs/candidate-total.svg" alt="" />
                        <div class="text-2xl font-bold">{{ job.jobApplyCount }} 応募中の人数</div>
                    </div>
                </div>
                <div class="flex justify-end lg:w-1/2">
                    <div
                        @click="showListCareTaker(indexJob)"
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
import { reactive, ref, computed } from 'vue'
import CareTakerInfoTable from '../CareTaker/CareTakerInfoTable.vue'
import StepProcess from '@/Components/Job/StepProcessJobCaretaker.vue'
import { ElLoading } from 'element-plus'
import { getListCaretakerApplyJob } from '@/API/job.js'

export default {
    components: { CareTakerInfoTable, StepProcess },
    props: {
        job: Object,
        indexJob: Number,
    },
    setup(props) {
        const jobItem = computed((_) => props.job)

        const isShowListCareTaker = ref(false)
        const jobSelect = ref('')
        const toggleShow = ref(false)

        let processes = ref([])
        let jobApplies = ref([])

        //Dummy data
        const jobStep = reactive([
            {
                job_process_id: 1,
                job_apply_status_id: 1,
                status: 1,
                updated_at: null,
            },
        ])

        const generateWorkingHour = (workingHours) => {
            try {
                return workingHours.join(' ')
            } catch (error) {
                return ''
            }
        }

        const fetchCaretakerApplyJob = async (_) => {
            let loadingService = ElLoading.service({ fullscreen: true })
            const { data, status } = await getListCaretakerApplyJob(jobItem.value.id)
            if (status === 200) {
                processes.value = [...data.processes]
                jobApplies.value = [...data.jobApply]
            } else {
                processes.value = []
                jobApplies.value = []
            }
            loadingService.close()
        }

        const showListCareTaker = async (indexJob) => {
            toggleShow.value = !toggleShow.value

            if (toggleShow.value) {
                await fetchCaretakerApplyJob()
            }

            if (jobSelect.value === indexJob) {
                jobSelect.value = ''
            } else {
                jobSelect.value = indexJob
            }
        }

        return {
            jobItem,
            toggleShow,
            jobSelect,
            isShowListCareTaker,
            jobApplies,
            showListCareTaker,
            generateWorkingHour,
            jobStep,
            processes,
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
    background-image: url(/storage/jobs/2dIAUpMUQYNXxivPmjZX6Wa9FZKCliFnmJeRauan.png);
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
