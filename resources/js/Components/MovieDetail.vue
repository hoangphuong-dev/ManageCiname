<template>
    <div class="w-full p-2 shadow-xl">
        <div class="flex">
            <div class="w-1/2">
                <img
                    class="rounded-md"
                    :src="
                        'https://i3.ytimg.com/vi/' +
                        videoId(movie) +
                        '/maxresdefault.jpg'
                    "
                />
            </div>
            <div class="w-1/2 pl-4">
                <h2 class="text-center">{{ movie.name }}</h2>
                <p class="pb-2">Đạo diễn : {{ movie.director }}</p>
                <p class="pb-2">Thể loại phim : Bom tấn, Hài hước</p>
                <p class="pb-2">Diễn viên : Hoàng Phi Hồng , Thanh Vân</p>
                <p class="pb-2">
                    Rated : Cấm trẻ em dưới
                    <span class="text-red-500">{{ movie.rated }}</span>
                    tuổi
                </p>
                <h3 v-if="movie.showtimes.length > 0">
                    Ngày khởi chiếu:
                    {{ formatDate(movie.showtimes[0].time_start) }}
                </h3>
                <div class="text-center mt-4">
                    <div v-if="movie.showtimes.length > 0">
                        <el-button
                            v-if="$page?.props?.user.role == 2"
                            @click="
                                this.$inertia.visit(
                                    route('staff.order', movie.id)
                                )
                            "
                            type="danger"
                        >
                            Đặt vé
                        </el-button>
                        <el-button
                            v-else
                            @click="openDialog(movie.id)"
                            type="danger"
                        >
                            Đặt vé
                        </el-button>
                    </div>
                    <div v-else class="text-red-200">
                        <el-alert
                            title="Phim đang chưa khởi chiếu !"
                            type="warning"
                        />
                    </div>
                    <el-dialog
                        title="Chọn rạp xem"
                        width="80%"
                        v-model="dialogForm"
                    >
                        <el-form
                            class="text-center w-full"
                            ref="formData"
                            :model="formData"
                            label-position="top"
                        >
                            <!-- Chọn tỉnh  -->
                            <h3 class="text-center my-4">Chọn thành phố</h3>
                            <div
                                class="w-full grid grid-cols-9 gap-4 border-b-2"
                            >
                                <div
                                    v-for="item in provinces"
                                    :key="item.id"
                                    class="shadow-lg mb-6 border-2 rounded cursor-pointer grid w-36 p-2 h-14 mr-4 hover:border-red-200"
                                    :class="{
                                        isActive: activeProvince == item.id,
                                    }"
                                    @click="getCineme(item.id)"
                                >
                                    <span class="mt-1 text-base">
                                        {{ item.name }}
                                    </span>
                                </div>
                            </div>

                            <!-- Chọn rạp  -->
                            <h3 class="text-center my-4">Chọn rạp</h3>
                            <div class="w-full grid grid-cols-6 gap-4 min-h-64">
                                <div
                                    v-for="item in cinemas"
                                    :key="item.id"
                                    @click="viewShowTime(item.id)"
                                    class="shadow-lg mb-6 border-2 rounded cursor-pointer grid w-56 p-2 h-20 mr-4"
                                >
                                    <span class="mt-2 text-base">
                                        {{ item.name }}
                                    </span>
                                </div>
                            </div>
                        </el-form>
                    </el-dialog>
                </div>
            </div>
        </div>
        <div class="mt-10">
            <el-tabs>
                <!-- Tab chi tiết -->
                <el-tab-pane class="font-bold" label="Mô tả chi tiết">
                    <div class="p-4" v-html="movie.description"></div>
                </el-tab-pane>

                <!-- Tab Phòng chiếu  -->
                <el-tab-pane label="Trailer">
                    <div class="w-full p-8">
                        <iframe
                            class="rounded"
                            width="100%"
                            height="500"
                            :src="
                                'https://www.youtube.com/embed/' +
                                videoId(movie)
                            "
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                            allowfullscreen
                        ></iframe>
                    </div>
                </el-tab-pane>
            </el-tabs>
        </div>
    </div>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout.vue";
import { getYoutubeId } from "@/Helpers/youtube.js";
import { Inertia } from "@inertiajs/inertia";
import { onBefore, onFinish } from "@/Uses/request-inertia";
import { listProvinceHasCinema, getCinemaByProvince } from "@/API/main.js";

export default {
    components: { AppLayout },
    props: {
        movie: Object,
    },

    data: function () {
        return {
            loading: false,
            dialogForm: false,
            activeProvince: "",
            province: "",
            provinces: [],
            cinemas: [],
            formData: {
                movie_id: "",
                province_id: "",
                cinema_id: "",
            },
        };
    },
    methods: {
        formatDate(day) {
            var now = new Date(day);
            return now.toLocaleDateString();
        },
        videoId(row) {
            return getYoutubeId(row);
        },

        openDialog(id) {
            this.formData.movie_id = id;
            this.dialogForm = !this.dialogForm;
            this.loading = true;
            this.fetchDataProvince();
        },

        async fetchDataProvince() {
            listProvinceHasCinema()
                .then(({ status, data }) => {
                    console.log(5555, data);
                    this.provinces = data;
                })
                .catch(() => {});
        },

        getCineme(id) {
            this.activeProvince = id;
            this.formData.province_id = id;
            this.fetchDataCinema(id);
        },

        async fetchDataCinema(id) {
            getCinemaByProvince(id)
                .then(({ status, data }) => {
                    this.cinemas = data;
                })
                .catch(() => {});
        },

        async viewShowTime(cinema_id) {
            this.formData.cinema_id = cinema_id;
            this.$refs["formData"].validate(async (valid) => {
                if (valid) {
                    Inertia.get(route("order.ticket", { ...this.formData }), {
                        onBefore,
                        onFinish,
                    });
                }
            });
        },
    },
};
</script>

<style lang="css">
.el-dialog__header {
    background: #f56c6c;
}
.el-tabs__item.is-active {
    color: #f56c6c;
    font-weight: bold;
}
.el-tabs__item:hover {
    color: #f56c6c;
}
.el-tabs__active-bar {
    background-color: #f56c6c;
}
.isActive {
    background: #f56c6c;
    color: white;
}
</style>
