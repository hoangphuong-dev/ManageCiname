<template>
    <div class="grid grid-cols-3" :class="classCustom">
        <div class="col-span-1">
            <div class="w-full h-full">
                <el-image
                    class="w-full h-full"
                    :src="caretaker?.avatar_url"
                ></el-image>
            </div>
        </div>
        <div class="col-span-2 grid border-gray-dashed">
            <div class="flex items-center px-6 py-2.5 border-b-gray-dashed" v-if="tags.length > 0">
                <div
                    v-for="(item, index) in tags"
                    :key="index"
                    class="rounded-2xl py-1.5 px-4 mr-2 bg-grayPrimary text-sm"
                >
                    {{item.name}}
                </div>
            </div>

            <div class="flex">
                <div
                    class="w-1/6 py-2 border-b-gray-dashed border-r-gray-dashed"
                >
                    <div class="flex justify-center">
                        <el-image src="/images/svg/jobs/address.svg"></el-image>
                    </div>
                    <div class="mt-1 text-center text-sm leading-3.5">住所</div>
                </div>
                <div class="w-5/6 py-2 pl-7 border-b-gray-dashed">
                    {{caretaker?.user_info?.address}}
                </div>
            </div>
            <div class="flex">
                <div
                    class="w-1/6 py-2 border-b-gray-dashed border-r-gray-dashed"
                >
                    <div class="flex justify-center">
                        <el-image src="/images/svg/jobs/time.svg"></el-image>
                    </div>
                    <div class="mt-1 text-center text-sm leading-3.5">
                        作業形態
                    </div>
                </div>
                <div class="w-5/6 py-2 pl-7 border-b-gray-dashed">
                    {{caretaker?.user_info?.type_of_work}}
                </div>
            </div>
            <div class="flex">
                <div
                    class="w-1/6 py-2 border-b-gray-dashed border-r-gray-dashed"
                >
                    <div class="flex justify-center">
                        <el-image
                            src="/images/svg/jobs/salary-2.svg"
                        ></el-image>
                    </div>
                    <div class="mt-1 text-center text-sm leading-3.5">賃金</div>
                </div>
                <div class="w-5/6 py-2 pl-7 border-b-gray-dashed">
                    {{caretaker?.user_info?.type_of_work}}
                </div>
            </div>
            <div class="flex">
                <div
                    class="w-1/6 py-2 border-b-gray-dashed border-r-gray-dashed"
                >
                    <div class="flex justify-center">
                        <el-image
                            src="/images/svg/jobs/experience.svg"
                        ></el-image>
                    </div>
                    <div class="mt-1 text-center text-sm leading-3.5">経験</div>
                </div>
                <div class="w-5/6 py-2 pl-7 border-b-gray-dashed">
                    Full time
                </div>
            </div>
            <div class="flex">
                <div class="w-1/6 py-2 border-r-gray-dashed">
                    <div class="flex justify-center">
                        <el-image
                            src="/images/svg/jobs/education.svg"
                        ></el-image>
                    </div>
                    <div class="mt-1 text-center text-sm leading-3.5">学歴</div>
                </div>
                <div class="w-5/6 py-2 pl-7">Full time</div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "CareTakerInfoTable",
    props: {
        classCustom: String,
        caretaker: {
            required: true,
        },
    },
    computed: {
        tags() {
            return this.caretaker?.tags || [];
        },
    },
};
</script>
