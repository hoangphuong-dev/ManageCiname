<template>
    <app-layout title="Dashboard">
        <div class="py-12">
            <div class="px-4 py-4 bg-white shadow-xl">
                <el-row :gutter="10">
                    <el-col :xs="24" :sm="12" :lg="10">
                        <p class="font-bold text-lg">応募中の詳細</p>
                        <step-process
                            :jobStep="jobApply.first().job_post_apply"
                            :processes="job.processes"
                        />
                    </el-col>
                    <el-col :xs="24" :sm="12" :lg="14">
                        <div class="flex justify-end">
                            <div class="xs_pt-2">
                                <div class="">
                                    更新日時:
                                    <span class="font-bold">{{jobApply.first().updated_at}}</span>
                                </div>
                                <div class="flex justify-end">
                                    <div
                                        class="w-10 h-10 p-2.5 bg-lightGreen rounded-full relative cursor-pointer"
                                    >
                                        <div class="el-image">
                                            <img
                                                class="el-image__inner"
                                                src="/images/svg/chat.svg"
                                            />
                                        </div>
                                        <span
                                            class="w-4 h-4 bg-redPrimary absolute -top-1 right-0 rounded-full"
                                        ></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </el-col>
                </el-row>
            </div>
            <div class="px-4 py-4 bg-white shadow-xl">
                <job-detail :job="job" :none-padding="true" />
            </div>
        </div>
    </app-layout>
</template>

<script>
import AdminLayout from "@/Layouts/Admin/AdminLayout.vue";
import SearchInput from "@/Components/Element/SearchInput.vue";
import DataTable from "@/Components/DataTable.vue";
import JobDetail from "@/Components/Job/JobDetail.vue";
import StepProcess from "@/Components/Job/StepProcessJobCaretaker.vue";

export default {
    name: "HospitalList",
    components: {
        AdminLayout,
        SearchInput,
        DataTable,
        JobDetail,
        StepProcess,
    },
    props: {
        data: {
            required: true,
        },
        jobApply: {
            required: true,
        },
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
    methods: {},
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

@media only screen and (max-width: 768px) {
    .xs_pt-2 {
        padding-top: 4px;
    }
}
</style>
