<template>
    <div class="main-jobs__item">
        <div
            class="main-jobs__star cursor-pointer"
            :class="{ 'favorite-job': job?.isFavorite || false }"
            @click="onFavoriteClick"
        >
            <el-image
                class="main-jobs__star-img"
                src="/images/svg/star.svg"
            ></el-image>
        </div>
        <div class="main-jobs__title">
            <div>{{ job.name }}</div>
        </div>
        <div class="main-job__foverite flex mb-6">
            <div class="w-10/12">
                <el-image
                    class="mr-4 im-star"
                    :src="
                        rateAverage >= 1
                            ? '/images/svg/jobs/pink-heart.svg'
                            : '/images/svg/jobs/gray-heart.svg'
                    "
                ></el-image>
                <el-image
                    class="mr-4 im-star"
                    :src="
                        rateAverage >= 2
                            ? '/images/svg/jobs/pink-heart.svg'
                            : '/images/svg/jobs/gray-heart.svg'
                    "
                ></el-image>
                <el-image
                    class="mr-4 im-star"
                    :src="
                        rateAverage >= 3
                            ? '/images/svg/jobs/pink-heart.svg'
                            : '/images/svg/jobs/gray-heart.svg'
                    "
                ></el-image>
                <el-image
                    class="mr-4 im-star"
                    :src="
                        rateAverage >= 4
                            ? '/images/svg/jobs/pink-heart.svg'
                            : '/images/svg/jobs/gray-heart.svg'
                    "
                ></el-image>
                <el-image
                    class="mr-4 im-star"
                    :src="
                        rateAverage >= 5
                            ? '/images/svg/jobs/pink-heart.svg'
                            : '/images/svg/jobs/gray-heart.svg'
                    "
                ></el-image>
            </div>
            <div class="w-2/12 text-right">
                <div class="flex items-center justify-end">
                    <img src="/images/svg/jobs/people.svg" alt="" />
                    &nbsp;
                    <p class="rate_counter">
                        {{ job.rate_count || 0 }} Rating
                    </p>
                </div>
            </div>
        </div>
        <div class="main-jobs__detail">
            <div class="grid grid-cols-1 lg:grid-cols-2">
                <div>
                    <div
                        class="el-tag--border"
                        v-if="(job.tags || []).length > 0"
                    >
                        <el-tag
                            v-for="(item, indexTag) in job.tags"
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
                            'border-top':
                                (job.tags || []).length === 0
                                    ? '1px dashed #979797'
                                    : null,
                        }"
                    >
                        <div
                            class="flex flex-col justify-center items-center main-jobs__list-label"
                        >
                            <el-image
                                :src="`/images/svg/jobs/building.svg`"
                            ></el-image>
                            <div>会社名</div>
                        </div>
                        <div class="main-jobs__list-content">
                            {{job.hospital_name}}
                        </div>
                    </div>

                    <div class="flex">
                        <div
                            class="flex flex-col justify-center items-center main-jobs__list-label"
                        >
                            <el-image
                                :src="`/images/svg/jobs/address.svg`"
                            ></el-image>
                            <div>住所</div>
                        </div>
                        <div class="main-jobs__list-content">
                            {{ job.address }}
                        </div>
                    </div>

                    <div class="flex">
                        <div
                            class="flex flex-col justify-center items-center main-jobs__list-label"
                        >
                            <el-image
                                :src="`/images/svg/jobs/salary.svg`"
                            ></el-image>
                            <div>年収</div>
                        </div>
                        <div class="main-jobs__list-content">
                            {{ job.annual_income_min }}万円～{{
                                job.annual_income_max
                            }}万円程度
                        </div>
                    </div>

                    <div class="flex">
                        <div
                            class="flex flex-col justify-center items-center main-jobs__list-label"
                        >
                            <el-image
                                :src="`/images/svg/jobs/train.svg`"
                            ></el-image>
                            <div>最寄り駅</div>
                        </div>
                        <div class="main-jobs__list-content">{{ job.nearest_station }}</div>
                    </div>

                    <div class="flex">
                        <div
                            class="flex flex-col justify-center items-center main-jobs__list-label"
                        >
                            <el-image
                                :src="`/images/svg/jobs/time.svg`"
                            ></el-image>
                            <div>勤務時間</div>
                        </div>
                        <div class="main-jobs__list-content">
                            {{ generateWorkingHour(job.working_hours) }}
                        </div>
                    </div>

                    <div class="flex">
                        <div
                            class="flex flex-col justify-center items-center main-jobs__list-label"
                        >
                            <el-image
                                :src="`/images/svg/jobs/calendar.svg`"
                            ></el-image>
                            <div>休暇制度</div>
                        </div>
                        <div class="main-jobs__list-content">
                            {{ generateWorkingHour(job.holidays) }}
                        </div>
                    </div>

                    <div class="flex">
                        <div
                            class="flex flex-col justify-center items-center main-jobs__list-label"
                        >
                            <el-image
                                :src="`/images/svg/Vector.svg`"
                            ></el-image>
                            <div>雇用形態</div>
                        </div>
                        <div class="main-jobs__list-content">{{ job.type_of_work_name }}</div>
                    </div>
                </div>
                <div
                    class="main-jobs__img"
                    :style="{
                        'background-image': `url(${getImage(
                            (job?.images || [])[0]?.path
                        )})`,
                    }"
                ></div>
            </div>
            <div class="lg:flex footer mt-10">
                <div class="div_button flex lg:w-1/2">
                    <a
                        @click="
                            $inertia.get(
                                route('caretaker.job_detail', job.id)
                            )
                        "
                        class="footer__button md:w-80 text-center cursor-pointer"
                        >詳細を見る</a
                    >
                    <a
                        v-if="!isJobApply && !isJobReject"
                        @click="applyJob"
                        class="footer__button footer__button--color footer__button--margin w-80 text-center cursor-pointer"
                        >応募する</a
                    >
                    <a
                        v-if="!isJobApply && isJobReject"
                        @click="applyJob"
                        class="footer__button bg-reapply footer__button--margin w-80 text-center cursor-pointer"
                        >Re Apply</a
                    >
                </div>
                <div class="div_footer__couting flex justify-end lg:w-1/2">
                    <div
                        class="flex items-center justify-center footer__couting w-1/4"
                    >
                        <span>求人番号: {{ job.id }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import { Inertia } from "@inertiajs/inertia";
import { onBefore, onFinish } from "@/Uses/request-inertia";

export default {
    props: {
        job: Object,
    },
    computed: {
        isJobApply() {
            return this.job?.isJobApply || false;
        },
        isJobReject() {
            return this.job?.isJobReject || false;
        },
        rateAverage() {
            return this.job?.rate_average || 0
        }
    },
    methods: {
        generateWorkingHour(workingHours) {
            try {
                return workingHours.join(" ");
            } catch (error) {
                return "";
            }
        },
        onFavoriteClick() {
            Inertia.put(
                route("caretaker.job.toggle-favorite"),
                {
                    job_id: this.job?.id,
                    isFavorite: this.job?.isFavorite || false,
                },
                {
                    preserveScroll: true,
                    onBefore,
                    onFinish,
                    onSuccess: (_) => {
                        this.job.isFavorite = !this.job.isFavorite;
                    },
                }
            );
        },
        applyJob() {
            Inertia.post(
                route("caretaker.job.apply"),
                {
                    job_id: this.job?.id,
                },
                {
                    preserveScroll: true,
                    onBefore,
                    onFinish,
                    onSuccess: (_) => {
                        this.job.isJobApply = true;
                    },
                }
            );
        }
    }
};
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
