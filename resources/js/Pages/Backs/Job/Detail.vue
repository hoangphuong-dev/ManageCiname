<template>
    <admin-layout>
        <template #main>
            <div class="bg-white min-h-full m-4 mb-0">
                <div class="p-4">
                    <h2 class="mb-3 text-lightGreen">求人詳細</h2>

                    <el-breadcrumb separator="/" class="mb-2 breadcrumb-cs">
                        <el-breadcrumb-item
                            @click="
                                onClickBreadcrumb(
                                    route('back.hospital-analytic')
                                )
                            "
                            :to="{ path: '/' }"
                            >求人管理</el-breadcrumb-item
                        >
                        <el-breadcrumb-item
                            @click="
                                onClickBreadcrumb(
                                    route('back.hospital-analytic.list', {
                                        id: hospitalId,
                                    })
                                )
                            "
                            :to="{ path: '/' }"
                            >本田クリニック</el-breadcrumb-item
                        >
                        <el-breadcrumb-item>求人名</el-breadcrumb-item>
                    </el-breadcrumb>
                </div>

                <hr />
                <div class="p-4">
                    <div class="flex items-center justify-between">
                        <div class="flex">
                            <div>
                                <span class="text-sm"> 病院名: </span>
                                <span class="text-sm font-bold">
                                    {{ user.name }}
                                </span>
                            </div>
                            <div class="w-10"></div>
                            <div>
                                <span class="text-sm"> 登録日: </span>
                                <span class="text-sm font-bold">
                                    {{
                                        (
                                            user.created_at?.split(" ") || []
                                        ).first()
                                    }}
                                </span>
                            </div>
                        </div>
                        <div class="flex">
                            <!-- <button class="btn-danger">不承認</button>
                            &nbsp; -->
                            <el-popconfirm
                                title="Are you sure to 承認 this?"
                                @confirm="allowJob"
                                v-if="isShowApprovalButton"
                            >
                                <template #reference>
                                    <button class="btn-danger bg-lightGreen">
                                        承認
                                    </button>
                                </template>
                            </el-popconfirm>
                        </div>
                    </div>
                </div>
                <hr />

                <div class="p-4">
                    <job-detail :job="job" :is-from-admin="true" :none-padding="true"/>
                </div>
            </div>
        </template>
    </admin-layout>
</template>

<script>
import AdminLayout from "@/Layouts/Admin/AdminLayout.vue";
import SearchInput from "@/Components/Element/SearchInput.vue";
import DataTable from "@/Components/DataTable.vue";
import { Inertia } from "@inertiajs/inertia";
import { onBefore, onFinish } from "@/Uses/request-inertia";
import JobDetail from "@/Components/Job/JobDetail.vue";

export default {
    name: "HospitalList",
    components: {
        AdminLayout,
        SearchInput,
        DataTable,
        JobDetail,
    },
    props: {
        data: {
            required: true,
        },
        hospitalId: {
            required: true,
        },
        isShowApprovalButton: {
            required: true,
            type: Boolean
        }
    },
    computed: {
        dataBE() {
            return this.data.data;
        },
        job() {
            return this.dataBE.job;
        },
        user() {
            return this.dataBE.user;
        },
    },
    data() {
        return {};
    },
    created() {},
    methods: {
        onClickBreadcrumb(url) {
            Inertia.get(
                url,
                {},
                {
                    onBefore,
                    onFinish,
                }
            );
        },
        allowJob() {
            Inertia.post(
                route("back.hospital.approval-job", {
                    job_id: this.job.id,
                }),
                {},
                {
                    onBefore,
                    onFinish,
                    preserveScroll: true,
                }
            );
        },
    },
};
</script>
<style>
.breadcrumb-cs .is-link {
    color: #606266 !important;
    font-weight: normal !important;
}

.breadcrumb-cs .el-breadcrumb__inner:not(.is-link) {
    font-weight: bold !important;
    color: #a5c242 !important;
}
</style>
