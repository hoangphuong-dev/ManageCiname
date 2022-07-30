<template>
    <div class="mx-auto">
        <h2 class="pb-4">Chọn ngày xem</h2>
        <div class="w-full flex">
            <div
                @click="chooseDate(item.day)"
                class="shadow-lg mb-6 border-2 rounded cursor-pointer grid w-28 p-2 mr-4 hover:border-red-200"
                :class="{ active: active_day === item.day }"
                v-for="(item, index) in twoWeeks"
                :key="index"
            >
                <div class="text-center text-xl font-bold">
                    {{ item.show }}
                </div>
                <div class="text-center">{{ item.week }}</div>
            </div>
        </div>

        <!-- Danh sach suat chieu  -->
        <h2 class="text-center my-4">Chọn suất chiếu</h2>
        <div
            v-if="show_times.length > 0"
            class="w-full mt-6 rounded px-4 border shadow-lg grid grid-cols-7 gap-4 pt-4 pb-20 mb-40"
        >
            <div
                :model="active_showtime"
                @click="chooseShowTime(item.id)"
                :class="{ active: active_showtime === item.id }"
                class="rounded hover:border-red-200 border-2 p-2 cursor-pointer"
                v-for="item in show_times"
                :key="item"
            >
                <div class="font-bold text-center mb-4">
                    {{ item.time_start }} - {{ item.time_end }}
                    <p>{{ item.name }}</p>
                </div>
                <p class="text-center">
                    Ghế trống :
                    {{ item.seat_empty }}/{{ item.sum_seat }}
                </p>
            </div>
        </div>

        <div
            v-else
            class="w-full mt-6 rounded px-4 border shadow-lg pt-4 pb-20"
        >
            <el-empty
                description="Không có suất chiếu vào ngày này . Vui lòng chọn ngày khác"
            ></el-empty>
        </div>

        <div
            v-if="show_times.length > 0"
            class="w-7 m-auto bg-red-600 rounded mt-8"
        >
            <el-button class="m-auto" @click="chooseSeat()" type="danger">
                Chọn ghế
            </el-button>
        </div>
    </div>
</template>

<script>
import { getYoutubeId } from "@/Helpers/youtube.js";
import { Inertia } from "@inertiajs/inertia";
import { onBefore, onFinish } from "@/Uses/request-inertia";
import { ElMessage, ElLoading } from "element-plus";

export default {
    props: {
        twoWeeks: { type: Array, required: true },
        filterFE: { type: Object, required: true },
        showtimes: { type: Object, required: true },
    },

    data: function () {
        return {
            active_day: this.filterFE.current_date,
            active_showtime: 0,
            loading: false,
            show_times: [],
            formData: {
                movie_id: this.filterFE.movie_id,
                province_id: this.filterFE.province_id,
                cinema_id: this.filterFE.cinema_id,
                current_date: this.filterFE.current_date,
                current_showtime: this.active_showtime,
            },
        };
    },
    created() {
        this.show_times = this.showtimes;
    },

    methods: {
        chooseSeat() {
            if (this.active_showtime > 0) {
                Inertia.get(
                    route("show_seat_by_showtime", { ...this.formData }),
                    {
                        onBefore,
                        onFinish,
                    }
                );
            } else {
                ElMessage({
                    message: "Vui lòng chọn suất chiếu !",
                    type: "warning",
                });
            }
        },

        chooseDate(item) {
            this.active_day = item;
            this.formData.current_date = item;
            const loading = ElLoading.service({
                lock: true,
            });
            setTimeout(() => {
                loading.close();
                this.viewShowTime();
            }, 500);
        },

        chooseShowTime(id) {
            console.log(id);
            this.active_showtime = id;
            this.formData.current_showtime = id;
        },

        viewShowTime() {
            Inertia.get(route("order.ticket", { ...this.formData }), {
                onBefore,
                onFinish,
            });
        },

        detail(id) {
            Inertia.get(route("movie.detail", id), { onBefore, onFinish });
        },
        videoId(row) {
            return getYoutubeId(row);
        },
    },
};
</script>

<style scoped>
.active {
    background: #ff7777;
}
</style>
