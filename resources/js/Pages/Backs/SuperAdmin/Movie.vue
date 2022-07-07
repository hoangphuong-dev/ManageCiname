<template>
    <admin-layout v-loading="loading">
        <template #main>
            <div class="bg-white min-h-full sm:m-4 mb-0 p-4">
                <h2 class="mb-5 text-red-400">Quản lý phim</h2>
                <div class="w-full flex relative">
                    <div class="w-4/5 flex items-end">
                        <SelectFilter
                            :type="'display'"
                            :modelSelect="filter.display"
                            :listOption="pageDisplay"
                            @onchangeFilter="onFilter"
                        />
                        <SelectFilter
                            :type="'movie_genre'"
                            :modelSelect="filter.movie_genre"
                            :listOption="movieGenre"
                            @onchangeFilter="onFilter"
                        />
                        <SelectFilter
                            :type="'status'"
                            :modelSelect="filter.status"
                            :listOption="statusList"
                            @onchangeFilter="onFilter"
                        />
                        <SearchInput
                            :filter="filter"
                            v-model="filter.name"
                            label="Tìm kiếm"
                            @submit="onFilter"
                        />
                    </div>
                    <div class="w-1/5 flex items-end">
                        <button
                            class="btn-primary ml-8 mr-2 bg-gray-400"
                            @click="dialogImportCSV = !dialogImportCSV"
                        >
                            Import CSV
                        </button>
                        <button
                            class="btn-primary bg-red-400"
                            @click="createMovie()"
                        >
                            + Taọ mới phim
                        </button>
                    </div>
                </div>

                <div class="mt-5">
                    <data-table
                        :fields="fields"
                        :items="movies.data"
                        :paginate="movies.meta"
                        :current-page="filter.page || 1"
                        disable-table-info
                        footer-center
                        paginate-background
                        @page="handleCurrentPage"
                    >
                        <template #image="{ row }">
                            <img
                                :src="
                                    'https://i3.ytimg.com/vi/' +
                                    videoId(row) +
                                    '/maxresdefault.jpg'
                                "
                                alt="ảnh từ youtube"
                            />
                        </template>
                        <template #status="{ row }">
                            <div v-if="row" class="flex items-center">
                                <el-switch
                                    v-model="row.status_switch"
                                    active-color="#13ce66"
                                    inactive-color="#cccccc"
                                    :active-value="MOVIE_ACTIVE"
                                    :inactive-value="MOVIE_DEACTIVE"
                                    @click="
                                        updateStatus(row, row.status_switch)
                                    "
                                />
                            </div>
                        </template>

                        <template #actions="{ row }">
                            <div v-if="row" class="flex items-center">
                                <template v-if="!row.status">
                                    <button
                                        class="btn-warning bg-gray-200"
                                        @click="edit(row)"
                                    >
                                        <img src="/images/svg/edit.svg" />
                                    </button>
                                    &nbsp;
                                </template>

                                <button
                                    class="btn-warning"
                                    @click="detail(row)"
                                >
                                    Xem chi tiết
                                </button>

                                &nbsp;
                                <button
                                    v-if="row?.status_switch == MOVIE_DEACTIVE"
                                    class="btn-warning bg-gray-200"
                                    @click="confirmEventDelete(row)"
                                >
                                    <img src="/images/svg/trash.svg" />
                                </button>
                            </div>
                        </template>
                    </data-table>
                </div>
            </div>

            <!-- dialog import movie -->
            <div class="customer_dialog">
                <el-dialog
                    title="Hướng dẫn import file csv"
                    v-model="dialogImportCSV"
                >
                    <div class="text-bold">
                        <h3>
                            Để quá trình import không bị lỗi . Bạn phải thực
                            hiện đúng các nguyên tắc sau :
                        </h3>
                        <p>
                            - Các thứ tự cột và các thông tin của phim phải được
                            sắp xếp theo 1 thứ tự nhất định
                        </p>
                        <p>- Vui lòng không chọn file có định dạng quá lớn .</p>
                        <p>
                            - Nếu import quá nhiều bản ghi => Nên chia nhỏ file
                            để chương trình làm việc thuận lợi hơn
                        </p>
                        <p>
                            - Bạn có thể export template mẫu và trình bày theo
                            mẫu để việc import diễn ra thuận lợi
                        </p>
                    </div>
                    <div>
                        <h3 class="my-4">Chọn file import</h3>
                        <form
                            :action="route('superadmin.movie.import')"
                            method="POST"
                            enctype="multipart/form-data"
                        >
                            <input type="hidden" name="_token" :value="csrf" />
                            <input
                                type="file"
                                name="file"
                                class="form-control"
                            />
                            <br />
                            <button class="btn btn-success p-2 my-4">
                                Import Movie Data
                            </button>
                        </form>
                        <h3 class="my-4">
                            Hoặc download file excel mẫu và điền thông tin của
                            các cột giống như file mẫu
                            <a
                                class="text-red-400 hover:underline"
                                href="/uploads/movies-model.xlsx"
                                >Export Movie Data</a
                            >
                        </h3>
                    </div>
                </el-dialog>
            </div>
        </template>
    </admin-layout>
</template>

<script>
import AdminLayout from "@/Layouts/Admin/AdminLayout.vue";
import SearchInput from "@/Components/Element/SearchInput.vue";
import SelectFilter from "@/Components/Element/SelectFilter.vue";
import DataTable from "@/Components/DataTable.vue";
import { Inertia } from "@inertiajs/inertia";
import { onBefore, onFinish } from "@/Uses/request-inertia";
import xss from "@/Helpers/xss";
import { formatDate } from "@/libs/datetime";
import * as Movie from "@/store/const.js";
import { getYoutubeId } from "@/Helpers/youtube.js";
import { updateStatusMovie } from "@/API/main.js";

export default {
    name: "Movie",
    components: {
        AdminLayout,
        SearchInput,
        SelectFilter,
        DataTable,
    },
    props: {
        movies: {
            type: Object,
            required: true,
        },
        movieGenre: {
            type: Object,
            required: true,
        },
        filtersBE: {
            type: Object,
            required: true,
        },
    },

    data() {
        return {
            csrf: document
                .querySelector('meta[name="csrf-token"]')
                .getAttribute("content"),
            MOVIE_ACTIVE: Movie.MOVIE_ACTIVE,
            MOVIE_DEACTIVE: Movie.MOVIE_DEACTIVE,
            imagePreview: "",
            selectedItem: null,
            dialogImportCSV: false,
            loading: false,
            dialogVisible: false,
            dialogVisibleDetail: false,

            fields: [
                { key: "id", label: "ID" },
                { key: "image", label: "Ảnh" },
                { key: "name", label: "Tên phim", width: 350 },
                { key: "director", label: "Đạo diễn", width: 150 },
                { key: "rated", label: "Giới hạn độ tuổi", width: 150 },
                { key: "status", label: "Trạng thái", width: 200 },
                { key: "actions", label: "Thao tác", width: 250 },
            ],

            pageDisplay: [
                { name: "Tất cả", id: 0 },
                { name: "Đang công chiếu", id: Movie.MOVIE_NOW_SHOWING },
                { name: "Sắp công chiếu", id: Movie.MOVIE_COMMING_SOON },
            ],
            statusList: [
                { name: "Tất cả", id: 0 },
                { name: "Đang hoạt động", id: Movie.MOVIE_ACTIVE },
                { name: "Đã tắt", id: Movie.MOVIE_DEACTIVE },
            ],
        };
    },

    computed: {
        filter() {
            const status = this.filtersBE?.status?.toInt();
            const display = this.filtersBE?.display?.toInt();
            const movie_genre = this.filtersBE?.movie_genre?.toInt();
            return {
                page: this.filtersBE.page?.toInt() || 1,
                limit: this.filtersBE.limit?.toInt() || 12,
                name: this.filtersBE?.name || "",
                status:
                    status == null || typeof status === "undefined"
                        ? 0
                        : status,
                display:
                    display == null || typeof display === "undefined"
                        ? 0
                        : display,
                movie_genre:
                    movie_genre == null || typeof movie_genre === "undefined"
                        ? null
                        : movie_genre,
            };
        },
    },

    methods: {
        videoId(row) {
            return getYoutubeId(row);
        },
        xss,
        formatDate,
        inertia() {
            Inertia.get(
                route("superadmin.movie.index", this.filter),
                {},
                { onBefore, onFinish, preserveScroll: true }
            );
        },

        handleCurrentPage(value) {
            this.filter.page = value;
            this.inertia();
        },

        confirmEventDelete({ id }) {
            this.$confirm(
                `Bạn có chắc xóa hết tất cả dữ liệu của phim này ?`,
                "Cảnh báo",
                {
                    confirmButtonText: "Chắc chắn",
                    cancelButtonText: "Hủy",
                    type: "warning",
                }
            ).then(async () => {
                Inertia.delete(route("superadmin.movie.delete", { id }), {
                    onBefore,
                    onFinish,
                    preserveScroll: true,
                    onError: (e) => console.log(e),
                });
            });
        },
        createMovie() {
            Inertia.get(route("superadmin.movie.create_movie"));
        },

        detail({ id }) {},

        edit(row) {},

        async updateStatus(row, status) {
            this.$confirm(
                `Bạn có chắc chắn thay đổi trạng thái phim `,
                "Cảnh báo",
                {
                    confirmButtonText: "Chắc chắn",
                    cancelButtonText: "Hủy",
                    type: "warning",
                }
            )
                .then(async () => {
                    this.loading = true;
                    await updateStatusMovie(row.id, status)
                        .then(async (res) => {
                            this.inertia();
                            this.$message.success(
                                "Cập nhật trạng thái thành công !"
                            );
                        })
                        .catch(() => {
                            this.inertia();
                            this.$message.error(
                                "Có lỗi trong quá trình thực thi"
                            );
                        });
                    this.loading = false;
                })
                .catch(() => {
                    this.inertia();
                });
        },

        // filter movie
        onFilter(value, type) {
            if (type === "display") {
                this.filter.display = value;
            } else if (type === "movie_genre") {
                this.filter.movie_genre = value;
            } else if (type === "status") {
                this.filter.status = value;
            }
            this.filter.page = 1;
            this.inertia();
        },
    },
};
</script>
