<template>
    <div class="mx-auto">
        <h2 class="pb-4">Xác nhận thông tin</h2>
        <!-- Thông tin phim -->
        <div class="w-full shadow-lg p-4 my-6">
            <h2>Thông tin phim</h2>
            <div class="flex mt-6">
                <div class="w-2/3">
                    <div class="w-full flex">
                        <div
                            class="w-1/3 border-dashed border-2 p-2 border-b-0"
                        >
                            Tên phim
                        </div>
                        <div
                            class="w-2/3 border-dashed border-2 p-2 border-b-0 border-l-0"
                        >
                            {{ showtime.movie.name }}
                        </div>
                    </div>
                    <div class="w-full flex">
                        <div
                            class="w-1/3 border-dashed border-2 p-2 border-b-0"
                        >
                            Diễn viên
                        </div>
                        <div
                            class="w-2/3 border-dashed border-2 p-2 border-b-0 border-l-0"
                        >
                            {{ showtime.movie.director }}
                        </div>
                    </div>
                    <div class="w-full flex">
                        <div
                            class="w-1/3 border-dashed border-2 p-2 border-b-0"
                        >
                            Đạo diễn
                        </div>
                        <div
                            class="w-2/3 border-dashed border-2 p-2 border-b-0 border-l-0"
                        >
                            {{ showtime.movie.director }}
                        </div>
                    </div>
                    <div class="w-full flex">
                        <div
                            class="w-1/3 border-dashed border-2 p-2 border-b-0"
                        >
                            Thời lượng
                        </div>
                        <div
                            class="w-2/3 border-dashed border-2 p-2 border-b-0 border-l-0"
                        >
                            {{ showtime.movie.movie_length }} phút
                        </div>
                    </div>
                    <div class="w-full flex">
                        <div
                            class="w-1/3 border-dashed border-2 p-2 border-b-0"
                        >
                            Rated
                        </div>
                        <div
                            class="w-2/3 border-dashed border-2 p-2 border-b-0 border-l-0"
                        >
                            Cấm trẻ dưới {{ showtime.movie.rated }} tuổi
                        </div>
                    </div>
                    <div class="w-full flex">
                        <div class="w-1/3 border-dashed border-2 p-2">
                            Thể loại
                        </div>
                        <div
                            class="w-2/3 border-dashed border-2 p-2 border-l-0"
                        >
                            Hài hước , ngôn tình
                        </div>
                    </div>
                </div>
                <div class="w-1/3">
                    <img
                        class="rounded"
                        :src="
                            'https://i3.ytimg.com/vi/' +
                            videoId(showtime.movie) +
                            '/maxresdefault.jpg'
                        "
                    />
                </div>
            </div>
        </div>
        <!-- end thông tin phim  -->

        <!-- Thông tin suất chiếu  -->
        <div class="w-full shadow-lg p-4 mb-6 mt-10">
            <h2 class="mb-4">Thông tin suất chiếu</h2>

            <div class="flex">
                <!-- thông tin suất chiếu  -->
                <div class="w-1/2 mr-32">
                    <h3>Suất chiếu</h3>
                    <div class="w-full flex">
                        <div
                            class="w-1/3 border-dashed border-2 p-2 border-b-0"
                        >
                            Ngày chiếu
                        </div>
                        <div
                            class="w-2/3 border-dashed border-2 p-2 border-b-0 border-l-0"
                        >
                            <h3>
                                {{ showtime.time_start.slice(0, 10) }}
                            </h3>
                        </div>
                    </div>
                    <div class="w-full flex">
                        <div
                            class="w-1/3 border-dashed border-2 p-2 border-b-0"
                        >
                            Giờ bắt đầu
                        </div>
                        <div
                            class="w-2/3 border-dashed border-2 p-2 border-b-0 border-l-0"
                        >
                            <h3>
                                {{ showtime.time_start.slice(11, 16) }}
                            </h3>
                        </div>
                    </div>
                    <div class="w-full flex">
                        <div class="w-1/3 border-dashed border-2 p-2">
                            Giờ kết thúc
                        </div>
                        <div
                            class="w-2/3 border-dashed border-2 p-2 border-l-0"
                        >
                            <h3>
                                {{ showtime.time_end.slice(11, 16) }}
                            </h3>
                        </div>
                    </div>
                </div>
                <!-- end thông tin suất chiếu -->

                <!-- thông tin phòng chiếu  -->
                <div class="w-1/2">
                    <h3>Thông tin phòng</h3>
                    <div class="w-full flex">
                        <div
                            class="w-1/3 border-dashed border-2 p-2 border-b-0"
                        >
                            Phòng chiếu
                        </div>
                        <div
                            class="w-2/3 border-dashed border-2 p-2 border-b-0 border-l-0"
                        >
                            <h3>{{ showtime.room.name }}</h3>
                        </div>
                    </div>
                    <div class="w-full flex">
                        <div
                            class="w-1/3 border-dashed border-2 p-2 border-b-0"
                        >
                            Ghế đã chọn
                        </div>
                        <div
                            class="w-2/3 border-dashed border-2 p-2 border-b-0 border-l-0"
                        >
                            <p v-for="item in data['seat_name']" :key="item">
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
                            <h3>
                                {{
                                    Number(data["total_money"]).toLocaleString(
                                        "it-IT",
                                        {
                                            style: "currency",
                                            currency: "VND",
                                        }
                                    )
                                }}
                            </h3>
                        </div>
                    </div>
                </div>
                <!-- end thông tin phòng chiếu -->
            </div>
        </div>
        <!-- end thông tin suất chiếu  -->

        <div class="w-full shadow-lg p-4 my-6">
            <h2>Thông tin người đặt</h2>

            <el-form
                class="text-center w-full"
                ref="formData"
                :model="formData"
                label-position="top"
                :rules="rules"
            >
                <!-- Tên rạp -->
                <el-form-item label="Tên người đặt" prop="name">
                    <el-input
                        v-model="formData.name"
                        autocomplete="off"
                        placeholder="Nhập tên"
                    ></el-input>
                </el-form-item>

                <!--email -->
                <el-form-item label="Email" prop="email">
                    <el-input
                        v-model="formData.email"
                        autocomplete="off"
                        placeholder="Nhập tên"
                    ></el-input>
                </el-form-item>

                <!-- phone -->
                <el-form-item label="Số điện thoại" prop="phone">
                    <el-input
                        v-model="formData.phone"
                        autocomplete="off"
                        placeholder="Nhập tên"
                    ></el-input>
                </el-form-item>

                <!-- mã giảm giá -->
                <el-form-item v-if="user != null" label="Mã giảm giá">
                    <el-input
                        v-model="formData.voucher"
                        autocomplete="off"
                        placeholder="Nhập mã giảm giá"
                    ></el-input>
                </el-form-item>
                <div v-else class="my-4">
                    <el-alert
                        v-if="!isStaff"
                        title="Nếu có tài khoản hãy đăng nhập để sử dụng mã giảm giá trong voucher của bạn !"
                        type="warning"
                    />
                </div>

                <div class="text-center">
                    <el-button type="danger" @click="submit()">
                        <span v-if="isStaff">Đặt vé</span>
                        <span v-else>Thanh toán</span>
                    </el-button>
                </div>
            </el-form>
        </div>
    </div>
</template>

<script>
import { getYoutubeId } from "@/Helpers/youtube.js";
import { Inertia } from "@inertiajs/inertia";
import { onBefore, onFinish } from "@/Uses/request-inertia";
import { ElLoading } from "element-plus";

export default {
    props: {
        showtime: { type: Object, required: true },
        data: { type: Object, required: true },
    },

    computed: {
        user() {
            return this.$page.props.customer;
        },
        isStaff() {
            return this.$page?.props?.user?.role == 2;
        },
    },

    created() {
        if (this.user != null) {
            let user = this.$page.props.customer;
            this.formData.user_id = user?.id;
            this.formData.name = user?.name;
            this.formData.email = user?.email;
            this.formData.phone = user?.phone;
        }

        if (this.isStaff) {
            this.formData.redirect = "staff";
        }
    },

    data() {
        return {
            formData: {
                name: "",
                email: "",
                phone: "",
            },

            rules: {
                name: [
                    {
                        required: true,
                        message: "Trường này không được để trống",
                        trigger: "change",
                    },
                ],
                email: [
                    {
                        required: true,
                        message: "Trường này không được để trống",
                        trigger: "change",
                    },
                    {
                        type: "email",
                        message: "Email không đúng định dạng",
                        trigger: "blur",
                    },
                ],
                phone: [
                    {
                        required: true,
                        message: "Trường này không được để trống",
                        trigger: "change",
                    },
                    {
                        validator: function (err, value, callback) {
                            let val = value.replace(/\s+/g, " ");
                            if (
                                !(val.length >= 9 && val.length <= 12) ||
                                value.includes(" ")
                            ) {
                                return callback(
                                    "Số điện thoại không đúng định dạng"
                                );
                            }
                            callback();
                        },
                        trigger: "blur",
                    },
                ],
            },
        };
    },
    methods: {
        videoId(row) {
            return getYoutubeId(row);
        },
        submit() {
            this.$refs["formData"].validate((valid) => {
                if (valid) {
                    const loading = ElLoading.service({
                        lock: true,
                    });
                    setTimeout(() => {
                        Inertia.post(
                            route("order.authen-email", { ...this.formData }),
                            {
                                onBefore,
                                onFinish,
                            }
                        );
                        loading.close();
                    }, 1000);
                }
            });
        },
    },
};
</script>
