<template>
    <div class="px-4 py-4" :class="{ 'lg:w-9/12 bg-white shadow-xl': !nonePadding }">
        <div class="lg:flex">
            <!-- Image primary -->
            <div class="lg:w-9/12 bg-red-200" style="height: 440px">
                <el-image
                    class="w-full h-full object-cover rounded-lg custom-el-image"
                    :src="images[imageActive].url"
                    :preview-src-list="imageUrls"
                    :initial-index="1"
                ></el-image>
            </div>
            <div class="w-3"></div>
            <!-- Slider -->
            <div class="lg:w-3/12 relative">
                <div class="image-control image-up flex items-center justify-center cursor-pointer" @click="imageUp">
                    <img src="/images/svg/jobs/arrow-up.svg" alt="" />
                </div>
                <div class="overflow-y-auto hidden-scroll" style="height: 440px" id="image-control">
                    <div class="img-parent" v-for="(item, index) in images" :key="index" @click="activeImage(index)">
                        <img
                            :src="item.url"
                            alt=""
                            class="rounded-lg image-instance min-h-64"
                            :class="{
                                'image-instance-active': index === imageActive,
                            }"
                        />
                    </div>
                </div>
                <div
                    class="image-control image-down flex items-center justify-center cursor-pointer"
                    @click="imageDown"
                >
                    <img src="/images/svg/jobs/arrow-down.svg" alt="" />
                </div>
            </div>
        </div>
        <h2 class="my-3 title font-bold">{{ jobItem.name }}</h2>
        <div class="flex pt-3 py-3">
            <div class="w-12">
                <img class="w-6 md:w-6 lg:w-8" src="/images/svg/heat.svg" />
            </div>
            <div class="w-12">
                <img class="w-6 md:w-6 lg:w-8" src="/images/svg/heat.svg" />
            </div>
            <div class="w-12">
                <img class="w-6 md:w-6 lg:w-8" src="/images/svg/heat.svg" />
            </div>
            <div class="py-3 text-right w-full">
                <span class="job_id lg:px-2 lg:py-2 rounded-md sm:px-1 sm:py-1">求人番号: {{ job.id }}</span>
            </div>
        </div>

        <!-- details job  -->
        <div class="main-jobs__detail">
            <div class="grid grid-cols-1">
                <div>
                    <div class="el-tag--border" v-if="(tags || []).length > 0">
                        <el-tag
                            v-for="(item, indexTag) in tags"
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
                            'border-top': (tags || []).length === 0 ? '1px dashed #979797' : null,
                        }"
                    >
                        <div class="flex flex-col justify-center items-center main-jobs__list-label">
                            <el-image :src="`/images/svg/jobs/building.svg`"></el-image>
                            <div>会社名</div>
                        </div>
                        <div class="main-jobs__list-content">
                            {{ jobItem.hospital_name }}
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
                            {{ jobItem.nearest_station }}
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
                            {{ jobItem.type_of_work_name }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- button ứng tuyển và đánh giá -->
        <div class="w-full flex my-10">
            <button
                @click="applyJob"
                v-if="!isJobApply && !isJobReject && !isFromAdmin"
                class="mr-1 h-11 button_apply px-3 py-3 lg:w-64 rounded-md text-white font-bold"
            >
                応募する
            </button>
            <button
                @click="applyJob"
                v-if="!isJobApply && isJobReject && !isFromAdmin"
                class="mr-1 h-11 button_apply px-3 py-3 lg:w-64 rounded-md text-white font-bold bg-reapply"
            >
                Re Apply
            </button>
            <div class="w-16" v-if="!isFromAdmin">
                <a href="javascript:void(0);">
                    <img
                        @click="onFavoriteClick"
                        class="rounded w-11 h-11"
                        :src="jobItem?.isFavorite ? '/images/svg/start_bg.svg' : '/images/svg/start.svg'"
                    />
                </a>
            </div>
            <div class="flex w-64">
                <a href=""><img class="rounded w-8 h-8 pt-3" src="/images/svg/count_rating.svg" /></a>
                <span class="py-3 text-yellow-500 text-sm font-bold">
                    {{ jobItem?.rateAverage }}({{ jobItem?.rateCount }}件のレビュー）
                </span>
            </div>

            <button class="btn-warning ml-4" @click="dialogVisibleDetail = !dialogVisibleDetail">Comment</button>
        </div>

        <!-- Form đánh giá/bình luận -->
        <comment-form
            :dialogVisibleDetail="dialogVisibleDetail"
            :jobId="job.id"
            @closeDialog="dialogVisibleDetail = !dialogVisibleDetail"
        ></comment-form>

        <!-- chi tiết job -->
        <h3 class="mb-4">求人詳細</h3>
        <div class="detail-job-tab border-r-2 border-t-2 border-l-2">
            <div class="flex border-b-2">
                <div class="w-1/6 bg-gray-100 p-3 justify-center items-center">募集業務内容</div>
                <div class="w-5/6 p-3">{{ jobItem.description }}</div>
            </div>
            <div class="flex border-b-2">
                <div class="w-1/6 bg-gray-100 p-3 justify-center items-center">資格</div>
                <div class="w-5/6 p-3">{{ jobItem.certificate }}</div>
            </div>
            <div class="flex border-b-2">
                <div class="w-1/6 bg-gray-100 p-3 justify-center items-center">応募条件</div>
                <div class="w-5/6 p-3">
                    {{ jobItem.certificate }}
                    {{ jobItem.years_experience }}
                    {{ jobItem.skills }}
                    {{ jobItem.experience_priority }}
                </div>
            </div>
            <div class="flex border-b-2">
                <div class="w-1/6 bg-gray-100 p-3 justify-center items-center">福利厚生・手当</div>
                <div class="w-5/6 p-3">{{ jobItem.benefits }}</div>
            </div>
            <div class="flex border-b-2">
                <div class="w-1/6 bg-gray-100 p-3 justify-center items-center">法人名</div>
                <div class="w-5/6 p-3">{{ jobItem.comapany_name }}</div>
            </div>
            <div class="flex border-b-2">
                <div class="w-1/6 bg-gray-100 p-3 justify-center items-center">法人紹介</div>
                <div class="w-5/6 p-3">{{ jobItem.comapany_introduce }}</div>
            </div>
            <div class="flex border-b-2">
                <div class="w-1/6 bg-gray-100 p-3 justify-center items-center">Link google map</div>
                <div class="w-5/6 p-3">{{ jobItem.map_station }}</div>
            </div>
            <div class="flex border-b-2">
                <div class="w-1/6 bg-gray-100 p-3 justify-center items-center">当院の強み</div>
                <div class="w-5/6 p-3">{{ jobItem.advantages }}</div>
            </div>
        </div>

        <!-- Đánh giá -->
        <h3 class="mb-3 mt-5">口コミ・評価</h3>
        <div class="w-full border-b-2 my-4" v-for="(each, indexEach) in comments" :key="indexEach">
            <div class="sm:flex">
                <div class="w-1/2 flex">
                    <el-avatar :size="size"></el-avatar>
                    <p class="mt-3 ml-4">{{ each.name }}</p>
                </div>
                <div class="w-1/2">
                    <div class="flex float-left md:float-right md:mt-2 my-2">
                        <el-image
                            style="height: 20px"
                            class="lg:mr-3 mr-2"
                            src="/images/svg/jobs/pink-heart.svg"
                        ></el-image>
                        <el-image
                            style="height: 20px"
                            class="lg:mr-3 mr-2"
                            src="/images/svg/jobs/pink-heart.svg"
                        ></el-image>
                        <el-image
                            style="height: 20px"
                            class="lg:mr-3 mr-2"
                            src="/images/svg/jobs/pink-heart.svg"
                        ></el-image>
                        <el-image
                            style="height: 20px"
                            class="lg:mr-3 mr-2"
                            src="/images/svg/jobs/pink-heart.svg"
                        ></el-image>
                        <el-image
                            style="height: 20px"
                            class="lg:mr-3 mr-2"
                            src="/images/svg/jobs/gray-heart.svg"
                        ></el-image>
                    </div>
                </div>
            </div>
            <div class="w-full my-10 md:my-3">{{ each.detail }}</div>
        </div>

        <!-- Phân trang  -->
        <div class="custom-paginate-box flex justify-center items-center w-full mb-8">
            <h3 class="page-size">全 100 件 1～10 件を表示)</h3>
            <pagination v-model="filter.page" :page-size="10" :total="100" :pager-count="5" />
        </div>
    </div>
</template>

<script>
import 'vue3-carousel/dist/carousel.css'
import { Carousel, Slide } from 'vue3-carousel'
import Pagination from '@/Components/Pagination.vue'
import { Inertia } from '@inertiajs/inertia'
import { onBefore, onFinish } from '@/Uses/request-inertia'
import { reactive, ref, computed } from 'vue'
import CommentForm from './CommentForm.vue'

export default {
    components: { Slide, Carousel, Pagination, CommentForm },
    props: {
        job: Object,
        isFromAdmin: {
            type: Boolean,
            default: false,
        },
        nonePadding: {
            type: Boolean,
            default: false,
        },
    },
    setup(props) {
        const jobItem = computed((_) => props.job)
        const rateAverage = ref(props.job?.rate_average || 0)
        const jobId = ref(props.job?.id)
        const isJobApply = ref(props.job?.isJobApply || false)

        const isJobReject = ref(props.job?.isJobReject || false)

        const images = reactive(jobItem.value.images.data ? jobItem.value.images.data : jobItem.value.images)

        const imageUrls = reactive(images.map((item) => item.url))

        const tags = reactive(jobItem.value.tags.data ? jobItem.value.tags.data : jobItem.value.tags)

        const generateWorkingHour = (workingHours) => {
            try {
                return workingHours.join(' ')
            } catch (error) {
                return ''
            }
        }

        const onFavoriteClick = (_) => {
            Inertia.put(
                route('caretaker.job.toggle-favorite'),
                {
                    job_id: jobId.value,
                    isFavorite: jobItem.value?.isFavorite || false,
                },
                {
                    preserveScroll: true,
                    onBefore,
                    onFinish,
                }
            )
        }

        const applyJob = (_) => {
            Inertia.post(
                route('caretaker.job.apply'),
                {
                    job_id: jobId.value,
                },
                {
                    preserveScroll: true,
                    onBefore,
                    onFinish,
                    onSuccess: (_) => {
                        isJobApply.value = true
                    },
                }
            )
        }

        const size = ref(10)

        const imageActive = ref(0)

        const activeImage = (index) => {
            imageActive.value = index
        }

        const imageDown = (_) => {
            const el = document.getElementById('image-control')
            el.scrollBy(150, 150)
        }

        const imageUp = (_) => {
            const el = document.getElementById('image-control')
            el.scrollBy(-150, -150)
        }

        const dialogVisibleDetail = ref(false)

        return {
            imageActive,
            images,
            tags,
            size,
            rateAverage,
            jobItem,
            generateWorkingHour,
            onFavoriteClick,
            applyJob,
            isJobApply,
            isJobReject,
            imageUrls,
            filter: {
                page: 1,
                limit: 10,
            },
            comments: [
                {
                    name: '森嶋通夫',
                    detail: 'テキストテキストテキストテキストテキストテキストテキストテキストテキステキストテキストテキストテキストテキストテキストテキストテキストテキステキストテキストテキストテキストテキストテキストテキストテキストテキス',
                },
                {
                    name: '森嶋通夫',
                    detail: 'テキストテキストテキストテキストテキストテキストテキストテキストテキステキストテキストテキストテキストテキス',
                },
                {
                    name: '森嶋通夫',
                    detail: 'テキストテキストテキストテキストテキストテキストテキストテキストテキステキストテキストテキストテキストテキス',
                },
            ],
            activeImage,
            imageDown,
            imageUp,
            dialogVisibleDetail,
        }
    },
}
</script>

<style scoped>
.button_view {
    background: #92c948;
}
.button_apply {
    background: #fca442;
}
.el-tag--background {
    border: none;
    color: black;
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
.el-tag--padding {
    margin-bottom: 10px;
}
.el-tag--border {
    border: 1px dashed #979797;
    padding: 11px 25px;
}
.info {
    border: 1px dashed #979797;
}
.info-top {
    border-top: 1px dashed #979797;
}
.info-label {
    border-right: 1px dashed #979797;
}
.title {
    color: #8cb012;
    font-family: Noto Sans JP;
}
.el-tag--radius {
    box-sizing: border-box;
    margin-right: 8px;
    background: #f5f5f5;
    border-radius: 16px;
}
.job_id {
    background: #f5f5f5;
}

.hidden-scroll::-webkit-scrollbar {
    display: none;
}

/* Hide scrollbar for IE, Edge and Firefox */
.hidden-scroll {
    -ms-overflow-style: none; /* IE and Edge */
    scrollbar-width: none; /* Firefox */
}

.image-control {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    background: white;
    left: 50%;
    transform: translateX(-50%);
    box-shadow: 0px 0px 4px rgb(124 124 124 / 25%);
    position: absolute;
}

.image-up {
    top: -25px;
    user-select: none;
}

.image-down {
    bottom: -25px;
    user-select: none;
}

.image-instance {
    max-height: 150px;
    width: 100%;
    object-fit: cover;
    cursor: pointer;
    min-width: 75px;
}

.image-instance-active {
    border: 2px solid #fba442;
    padding: 1px;
}

#image-control > .img-parent:not(:last-child) {
    margin-bottom: 10px;
}

#image-control {
    scroll-behavior: smooth;
}

.bg-reapply {
    background-color: #ff0000ad;
}

@media (max-width: 1024px) {
    #image-control {
        margin-top: 12px;
        display: flex;
        height: unset !important;
    }

    #image-control > .img-parent:not(:last-child) {
        margin-right: 10px;
        margin-bottom: 0;
    }

    .image-up {
        top: 50%;
        transform: translateY(-50%);
        left: -25px;
    }

    .image-down {
        top: 50%;
        transform: translateY(-50%);
        right: -25px;
        left: unset;
    }

    .image-down > img,
    .image-up > img {
        transform: rotate(-90deg);
    }
}
</style>

<style>
.custom-el-image .el-image__inner {
    object-fit: cover;
}
.dialog-evaluation .el-dialog {
    border-radius: 0.5rem;
}
.dialog-evaluation .el-dialog__header {
    background: #a5c242;
    border-radius: 0.5rem 0.5rem 0 0;
    color: #fff;
    font-size: 1.25rem;
    font-weight: 700;
    line-height: 1.25rem;
}
</style>
