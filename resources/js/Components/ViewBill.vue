<template>
    <div class="w-full flex relative">
        <div class="w-3/4 flex items-end">
            <SelectFilter
                v-if="!isCustomer"
                :type="'status'"
                :modelSelect="filter.status"
                :listOption="statusList"
                @onchangeFilter="onFilter"
            />
            <SelectFilter
                :type="'voucher'"
                :modelSelect="filter.voucher"
                :listOption="typeVoucher"
                @onchangeFilter="onFilter"
            />
            <SearchInput
                :filter="filter"
                v-model="filter.name"
                label="Tìm kiếm"
                @submit="onFilter"
            />
        </div>
        <div class="w-1/4">
            <DateFilter
                :title="'Ngày tạo'"
                :type="'created_at'"
                :modelSelect="filter.range"
                :typeDate="'daterange'"
                @onchangeFilter="onFilter"
            />
        </div>
    </div>

    <div class="mt-5" style="min-height: 500px">
        <data-table
            :fields="fields"
            :items="bills.data"
            :paginate="bills.meta"
            :current-page="filter.page || 1"
            disable-table-info
            footer-center
            paginate-background
            @page="handleCurrentPage"
        >
            <template #created_at="{ row }">
                {{ formatDateTime(row?.created_at) }}
            </template>
            <template #name="{ row }">
                <div>{{ row?.user.name }}</div>
            </template>
            <template #phone="{ row }">
                <div>{{ row?.user.phone }}</div>
            </template>
            <template #email="{ row }">
                <div>{{ row?.user.email }}</div>
            </template>
            <template #total_money="{ row }">
                <div>{{ row?.total_money.toLocaleString() }} VNĐ</div>
            </template>
            <template #voucher="{ row }">
                <div
                    @click="viewVoucher(row?.voucher?.code)"
                    class="cursor-pointer hover:text-red-300"
                >
                    {{ row?.voucher?.code }}
                </div>
            </template>

            <template #action="{ row }">
                <div>
                    <el-button
                        size="small"
                        @click="detailBill(row?.id)"
                        type="danger"
                    >
                        Xem chi tiết
                    </el-button>
                </div>
            </template>

            <template #status="{ row }">
                <div
                    :class="{
                        'bg-green-600 text-white': row?.status === 1,
                        'text-red-500 font-bold': row?.status === 2,
                    }"
                    class="p-2 text-center rounded-md"
                >
                    {{ row?.status == 1 ? "Đã thanh toán" : "Chưa thanh toán" }}
                </div>
            </template>
        </data-table>
    </div>

    <!-- chi tiết hóa đơn  -->
    <el-dialog title="Chi tiết hóa đơn" v-model="dialogForm">
        <!-- Thông tin phim -->
        <div class="w-full shadow-lg p-4 my-6">
            <h2>Thông tin phim</h2>
            <div class="flex mt-6">
                <div class="w-2/3">
                    <div class="w-full flex">
                        <div
                            class="w-1/3 border-dashed border-2 p-1 border-b-0"
                        >
                            Tên phim
                        </div>
                        <div
                            class="w-2/3 border-dashed border-2 p-1 border-b-0 border-l-0"
                        >
                            {{ bill_detail.bill?.showtime?.movie.name }}
                        </div>
                    </div>
                    <div class="w-full flex">
                        <div
                            class="w-1/3 border-dashed border-2 p-1 border-b-0"
                        >
                            Đạo diễn
                        </div>
                        <div
                            class="w-2/3 border-dashed border-2 p-1 border-b-0 border-l-0"
                        >
                            {{ bill_detail.bill?.showtime?.movie.director }}
                        </div>
                    </div>
                    <div class="w-full flex">
                        <div
                            class="w-1/3 border-dashed border-2 p-1 border-b-0"
                        >
                            Thời lượng
                        </div>
                        <div
                            class="w-2/3 border-dashed border-2 p-1 border-b-0 border-l-0"
                        >
                            {{ bill_detail.bill?.showtime?.movie.movie_length }}
                            phút
                        </div>
                    </div>
                    <div class="w-full flex">
                        <div
                            class="w-1/3 border-dashed border-2 p-1 border-b-0"
                        >
                            Rated
                        </div>
                        <div
                            class="w-2/3 border-dashed border-2 p-1 border-b-0 border-l-0"
                        >
                            Cấm trẻ dưới
                            {{ bill_detail.bill?.showtime?.movie.rated }} tuổi
                        </div>
                    </div>
                    <div class="w-full flex">
                        <div class="w-1/3 border-dashed border-2 p-1">
                            Thể loại
                        </div>
                        <div
                            class="w-2/3 border-dashed border-2 p-1 border-l-0"
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
                            videoId(bill_detail.bill?.showtime?.movie) +
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
                                {{
                                    bill_detail.bill?.showtime?.time_start.substr(
                                        0,
                                        10
                                    )
                                }}
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
                                {{
                                    bill_detail.bill?.showtime?.time_start.substr(
                                        10,
                                        6
                                    )
                                }}
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
                                {{
                                    bill_detail.bill?.showtime?.time_end.substr(
                                        10,
                                        6
                                    )
                                }}
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
                            <h3>{{ bill_detail.bill?.showtime?.room.name }}</h3>
                        </div>
                    </div>

                    <div class="w-full flex">
                        <div class="w-1/3 border-dashed border-2 p-2">
                            Ghế đã chọn
                        </div>
                        <div
                            class="w-2/3 border-dashed border-2 p-2 border-l-0"
                        >
                            <p
                                v-for="item in bill_detail?.tickets"
                                :key="item.id"
                            >
                                {{
                                    item?.seat?.row_name +
                                    item?.seat?.columns_number
                                }}
                                <span>({{ item?.seat?.seat_type.name }} )</span>
                            </p>
                        </div>
                    </div>
                </div>
                <!-- end thông tin phòng chiếu -->
            </div>
        </div>
        <!-- end thông tin suất chiếu  -->
    </el-dialog>
</template>

<script>
import SelectFilter from "@/Components/Element/SelectFilter.vue";
import SearchInput from "@/Components/Element/SearchInput.vue";
import { getYoutubeId } from "@/Helpers/youtube.js";
import DataTable from "@/Components/DataTable.vue";
import { formatDateTime } from "@/libs/datetime.js";
import { Inertia } from "@inertiajs/inertia";
import { onBefore, onFinish } from "@/Uses/request-inertia";
import { detailBill } from "@/API/main.js";
import DateFilter from "@/Components/Element/DateFilter.vue";

export default {
    name: "ViewBillComponent",

    components: { SearchInput, DataTable, SelectFilter, DateFilter },

    props: {
        bills: { type: Object, required: true },
        filtersBE: { type: Object, required: true, default: {} },
    },

    computed: {
        filter() {
            const status = this.filtersBE?.status?.toInt();
            const voucher = this.filtersBE?.voucher?.toInt();
            return {
                page: this.filtersBE.page?.toInt() || 1,
                limit: this.filtersBE.limit?.toInt() || 12,
                name: this.filtersBE?.name || "",
                range: this.filtersBE?.range || [],
                status:
                    status == null || typeof status === "undefined"
                        ? null
                        : status,
                voucher:
                    voucher == null || typeof voucher === "undefined"
                        ? null
                        : voucher,
            };
        },
        isCustomer() {
            return Inertia?.page?.props?.user?.role == 3;
        },
    },

    data() {
        return {
            statusList: [
                { id: 1, name: "Đã thanh toán" },
                { id: 2, name: "Chưa thanh toán" },
            ],
            typeVoucher: [
                { id: 1, name: "Có voucher" },
                { id: 2, name: "Không có voucher" },
            ],

            filterVoucher: {
                keyword: "",
            },

            dialogForm: false,
            bill_detail: "",
            fields: [
                { key: "created_at", label: "Ngày tạo" },
                { key: "name", label: "Tên người đặt" },
                { key: "phone", label: "Số điện thoại" },
                { key: "email", label: "Email" },
                { key: "total_money", label: "Tổng tiền" },
                { key: "voucher", label: "Voucher đã dùng" },
                { key: "status", label: "Trạng thái hóa đơn" },
                { key: "action", label: "Thao tác" },
            ],
        };
    },
    methods: {
        formatDateTime,

        inertia() {
            Inertia.get(
                route("admin.bill.index", this.filter),
                {},
                { onBefore, onFinish, preserveScroll: true }
            );
        },

        handleCurrentPage(value) {
            this.filter.page = value;
            this.inertia();
        },
        viewVoucher(code) {
            this.filterVoucher.keyword = code;
            Inertia.get(
                route("voucher", this.filterVoucher),
                {},
                { onBefore, onFinish, preserveScroll: true }
            );
        },

        videoId(row) {
            return getYoutubeId(row);
        },

        async detailBill(id) {
            this.dialogForm = true;

            detailBill(id)
                .then(({ data }) => {
                    this.bill_detail = data;
                })
                .catch(() => {});
            this.loading = false;
        },

        onFilter(value, type) {
            if (type === "voucher") {
                this.filter.voucher = value;
            } else if (type === "status") {
                this.filter.status = value;
            } else if (type === "created_at") {
                this.filter.range = value;
            }
            this.filter.page = 1;
            this.inertia();
        },
    },
};
</script>
