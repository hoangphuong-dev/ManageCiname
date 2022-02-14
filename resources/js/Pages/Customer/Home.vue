<template>
    <app-layout title="Dashboard">
        <div class="py-12">
            <div class="mx-auto messenger-window__custom">
                <div class="w-full">
                    <div class="main-jobs">
                        <!-- slider -->
                        <div class="w-full">
                            <div class="w-4/5 m-auto border-white h-44" >
                                <carousel :items-to-show="1.5">
                                    <slide v-for="slide in 10" :key="slide">
                                        <div class="h-28 w-full bg-red-50">FFFFFF</div>
                                    </slide>
                                </carousel>
                            </div>
                        </div>
                        <!-- button filter  -->
                        <div class="w-full flex">
                            <div class="w-1/2">
                                <el-select
                                v-model="province"
                                clearable
                                placeholder="Chon the loai"
                            >
                                <el-option
                                    v-for="(item, index) in 10"
                                    :key="index"
                                    :label="item"
                                    :value="item"
                                ></el-option>
                            </el-select>

                            </div>
                            <div class="w-1/2">
                                <el-input
                                    ref="search"
                                    placeholder="Tim ten"
                                    clearable
                                    @keyup.enter="searchChange()"
                                />

                            </div>
                        </div>
                        <div class="flex my-6">
                            <div class="w-1/2">
                                <button class="p-4 bg-red-400">Phim dang chieu</button>
                            </div>
                            <div class="w-1/2 text-right">
                                <button class="p-4 bg-red-400">Phim sap chieu</button>
                            </div>
                        </div>
                        <!-- show phim -->
                        <div class="w-full">
                             <div class="grid grid-cols-4 gap-4 mt-5">
                                <div
                                    v-for="item in 10"
                                    :key="item"
                                    class="border rounded-md p-4 cursor-pointer"
                                >
                                    <h2 class="text-center">{{ item }}</h2>
                                    <div class="flex">
                                    <h3 class="w-1/2">Người quản lý :</h3>
                                    <div>{{ item }}</div>
                                    </div>
                                    <div class="flex">
                                    <h3 class="w-1/2">Rạp :</h3>
                                    <div>10 rạp</div>
                                    </div>
                                    <div class="flex">
                                    <h3 class="w-1/2">Phòng :</h3>
                                    <div>105 phòng</div>
                                    </div>
                                </div>
                                </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
// import Filter from "../../../Components/Job/Filter.vue";
// import Notification from "../../../Components/Job/Notification.vue";
// import JobItem from "@/Components/Job/JobItem.vue";
// import Pagination from "@/Components/Pagination.vue";
import "vue3-carousel/dist/carousel.css";
import { Carousel, Slide } from "vue3-carousel";




export default {
    components: { Slide, Carousel},
    props: {
        tags: Array,
        hospital_types: Array,
    },
    created() {
        // this.fetchData();
    },
    data: function () {
        return {
            value: 0,
            slider: [1,2,3,4,5,5],
            loading: false,
            total: "",
            perPage: "",
            filter: {
                page: 1,
                limit: 10,
            },
            settings: {
                "dots": true,
                "focusOnSelect": true,
                "infinite": true,
                "speed": 500,
                "slidesToShow": 3,
                "slidesToScroll": 3,
                "touchThreshold": 5
            },
        };
    },
    methods: {
        handleCurrentPage(value) {
            this.filter.page = value;
            this.fetchData();
        },
        async fetchData() {
            this.loading = true;
            await this.axios
                .get(`jobs`, { params: this.filter })
                .then(async (res) => {
                    this.jobs = res.data;
                    this.total = res.data.meta.total;
                    this.perPage = res.data.meta.per_page;
                })
                .catch(() => {});
            this.loading = false;
        },
    },
};
</script>
