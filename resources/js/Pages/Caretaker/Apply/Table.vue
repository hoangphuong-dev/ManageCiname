<template>
    <div class="tab-body overflow-x-auto">
        <!-- <step-proccess /> -->
        <table class="table-custom w-full min-width-1000">
            <tr class="border-solid border-gray-500 border-b-1">
                <th
                    class="header text-lightGreen font-bold text-2xl pb-3 w-3/12 text-left"
                >
                    求人名
                </th>
                <th
                    class="header text-lightGreen font-bold text-2xl pb-3 w-6/12 text-left"
                >
                    応募ステータス
                </th>
                <th
                    class="header text-lightGreen font-bold text-2xl pb-3 w-2/12 text-left pl-3"
                >
                    更新日時
                </th>
                <th
                    class="header text-lightGreen font-bold text-2xl pb-3 w-1/12"
                ></th>
            </tr>
            <template v-if="jobReactive.length > 0">
                <tr
                    class="border-solid border-gray-500 border-b-1"
                    v-for="(item, index) in jobReactive"
                    :key="index"
                >
                    <td class="py-6 font-bold text-lg pr-2 line-break-anywhere">
                        {{ item.name }}
                    </td>
                    <td class="py-6">
                        <div class="max-width-500">
                            <step-process
                                :processes="item.processes"
                                :job-step="
                                    item?.job_apply?.job_post_apply || []
                                "
                            />
                        </div>
                    </td>
                    <td class="py-6">
                        {{ item.last_update }}
                    </td>
                    <td class="py-6">
                        <button
                            class="btn-warning"
                            @click="
                                $inertia.get(
                                    route('caretaker.get.job.apply.detail', {job_id: item.id, job_apply_id: item?.job_apply?.id})
                                )
                            "
                        >
                            詳細
                        </button>
                    </td>
                </tr>
            </template>
            <template v-else>
                <tr>
                    <td colspan="4">
                        <el-empty description="No Data"></el-empty>
                    </td>
                </tr>
            </template>
        </table>
    </div>
</template>

<script>
import StepProcess from '@/Components/Job/StepProcessJobCaretaker.vue'

export default {
    name: "TableItem",
    components: {
        StepProcess,
    },
    props: {
        jobReactive: {
            require: true,
        },
    },
};
</script>
<style scoped>
.line-break-anywhere {
    line-break: anywhere;
}
</style>
