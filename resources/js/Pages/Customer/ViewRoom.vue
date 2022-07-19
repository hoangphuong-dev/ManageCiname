<template>
    <app-layout>
        <div class="pb-12 pt-6">
            <div class="mx-auto">
                <h2 class="pb-4">Chọn ghế xem</h2>

                <div class="flex">
                    <div class="w-3/4 shadow-lg p-4 mr-6">
                        <div class="w-full">
                            <img
                                style="width: 100%"
                                src="/uploads/man_hinh_chieu.png"
                            />
                        </div>
                        <!-- show seat of room -->
                        <div
                            class="w-full mt-16 grid gap-4"
                            :style="{
                                'grid-template-columns':
                                    'repeat(' +
                                    showtime.room.column_number +
                                    ', minmax(0, 1fr))',
                            }"
                        >
                            <div
                                class="rounded border p-1 text-center"
                                v-for="item in showtime.room.seats"
                                :key="item"
                                :class="{
                                    active:
                                        -1 < formData.seat_id.indexOf(item.id),
                                    seat_order:
                                        -1 < seat_ordered.indexOf(item.id),
                                    cursor: !(
                                        -1 < seat_ordered.indexOf(item.id)
                                    ),
                                }"
                                @click="
                                    !(-1 < seat_ordered.indexOf(item.id))
                                        ? chooseSeat(item)
                                        : ''
                                "
                            >
                                <div class="w-full m-auto text-center">
                                    <img
                                        style="
                                            height: 50px;
                                            display: inline-block;
                                        "
                                        :src="getImage(item.seat_type.image)"
                                    />
                                </div>
                                <div class="text-base mt-2">
                                    {{ item.row_name + item.columns_number }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="w-1/4">
                        <div class="w-full shadow-lg p-4">
                            <h2 class="pb-4 text-center">Chú thích</h2>
                            <div
                                class="rounded border-b-2 mb-4 flex"
                                v-for="item in seat_types.data"
                                :key="item"
                            >
                                <div
                                    class="rounded border text-center mb-4 w-32"
                                >
                                    <div class="w-3/4 m-auto p-2">
                                        <img
                                            style="height: 40px"
                                            :src="getImage(item.image)"
                                        />
                                    </div>
                                    <div class="text-base mt-2">A1</div>
                                </div>
                                <div class="ml-3 mt-8">
                                    <h3>{{ item.name }}</h3>
                                </div>
                            </div>

                            <!-- Chú thích màu  -->
                            <div
                                class="rounded border-b-2 mb-4 flex"
                                v-for="item in notes"
                                :key="item.name"
                            >
                                <div
                                    class="rounded border text-center mb-4 w-32"
                                    :class="item.color"
                                >
                                    <div class="w-3/4 m-auto p-2">
                                        <img
                                            style="height: 40px"
                                            :src="
                                                getImage(
                                                    seat_types?.data[0]?.image
                                                )
                                            "
                                        />
                                    </div>
                                    <div class="text-base mt-2">A1</div>
                                </div>
                                <div class="ml-3 mt-8">
                                    <h3>{{ item.name }}</h3>
                                </div>
                            </div>

                            <!-- end chú thích  -->
                        </div>

                        <!-- Thông tin ghế -->
                        <div class="w-full shadow-lg p-4 mt-8">
                            <h2 class="pb-4 text-center">Thông tin vừa chọn</h2>
                            <h3 class="text-right text-lg">Phòng 202</h3>

                            <div class="w-full flex">
                                <div
                                    class="w-1/3 border-dashed border-2 p-2 border-b-0"
                                >
                                    Ghế
                                </div>
                                <div
                                    class="w-2/3 border-dashed border-2 p-2 border-b-0 border-l-0"
                                >
                                    <p
                                        v-for="item in formData.seat_name"
                                        :key="item"
                                    >
                                        {{ item }}
                                    </p>
                                </div>
                            </div>
                            <div class="w-full flex">
                                <div class="w-1/3 border-dashed border-2 p-2">
                                    Tổng tiền
                                </div>
                                <div
                                    class="w-2/3 border-dashed border-2 p-2 border-l-0"
                                >
                                    {{
                                        formData.total_money.toLocaleString(
                                            "it-IT",
                                            {
                                                style: "currency",
                                                currency: "VND",
                                            }
                                        )
                                    }}
                                </div>
                            </div>
                        </div>
                        <!-- end thông tin Ghế -->

                        <!-- Count down  -->
                        <div class="w-full shadow-lg p-4 mt-8">
                            <h2 class="pb-4 text-center">Count down</h2>

                            <div class="w-full flex">
                                <Countdown
                                    :deadline="count_down"
                                    :labels="{
                                        minutes: 'Phút',
                                        seconds: 'Giây',
                                    }"
                                    :showDays="false"
                                    :showHours="false"
                                />
                            </div>
                        </div>
                        <!-- end count down -->
                    </div>
                </div>

                <!-- submit form -->
                <div class="text-center mt-10">
                    <el-button @click="submit()" type="danger">
                        Tiếp tục
                    </el-button>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout.vue";
import { getYoutubeId } from "@/Helpers/youtube.js";
import { Inertia } from "@inertiajs/inertia";
import { onBefore, onFinish } from "@/Uses/request-inertia";
import { Countdown } from "vue3-flip-countdown";
import { ElMessage } from "element-plus";

export default {
    components: { AppLayout, Countdown },
    props: {
        showtime: Object,
        seat_ordered: Object,
        seat_types: Object,
        count_down: String,
    },

    data() {
        return {
            seat_name: [],
            formData: {
                cinema_id: this.showtime.room.cinema.id,
                showtime_id: this.showtime.id,
                seat_id: [],
                seat_name: [],
                total_money: 0,
            },
            notes: [
                {
                    name: "Ghế đã bán",
                    color: "bg-red-400",
                },
                {
                    name: "Ghế trống",
                    color: "",
                },
                {
                    name: "Ghế đang chọn",
                    color: "bg-blue-400",
                },
            ],
        };
    },
    methods: {
        submit() {
            if (this.formData.seat_id.length > 0) {
                Inertia.get(
                    route("order.get_info_customer", { ...this.formData }),
                    {
                        onBefore,
                        onFinish,
                    }
                );
            } else {
                ElMessage({
                    message: "Vui lòng chọn ít nhất 1 ghế xem !",
                    type: "error",
                });
            }
        },

        chooseSeat(item) {
            if (this.formData.seat_id.includes(item.id)) {
                const index = this.formData.seat_id.indexOf(item.id);

                if (index > -1) {
                    this.formData.seat_id.splice(index, 1);
                    this.formData.seat_name.splice(index, 1);
                    this.formData.total_money -= Number(item.seat_type.price);
                }
            } else {
                if (this.formData.seat_id.length >= 8) {
                    ElMessage({
                        message: "Chỉ chọn tối đa 8 ghế !",
                        type: "error",
                    });
                } else {
                    this.formData.seat_id.push(item.id);
                    this.formData.seat_name.push(
                        item.row_name +
                            item.columns_number +
                            " ( " +
                            item.seat_type.name +
                            " )"
                    );
                    this.formData.total_money += Number(item.seat_type.price);
                }
            }
            // console.log(`activeTag[i]: ${this.formData.seat_id}`);
        },

        videoId(row) {
            return getYoutubeId(row);
        },
    },
};
</script>

<style lang="css">
.active {
    background: #60a5fa;
}
.seat_order {
    background: #f87171;
}
.cursor {
    cursor: pointer;
}
</style>
