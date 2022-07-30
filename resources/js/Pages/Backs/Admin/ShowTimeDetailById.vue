<template>
    <admin-layout>
        <template #main>
            <div class="bg-white min-h-full m-4 mb-0 p-4">
                <div class="w-full mb-10 flex text-red-400">
                    <h2 class="">PHC {{ cinema.name }}</h2>
                    <p class="ml-32">
                        <el-icon><phone /></el-icon> {{ cinema.hotline }}
                    </p>
                    <p class="mx-32">
                        <el-icon><location-information /></el-icon>
                        {{ cinema.address }}
                    </p>
                    <p class="mr-32">
                        <el-icon><video-camera-filled /></el-icon> 115 phim công
                        chiếu
                    </p>
                    <p>
                        <el-icon><school /></el-icon> 115 phòng
                    </p>
                </div>

                <hr />

                <div>CHi tiết suất chiếu ở đây</div>
            </div>
        </template>
    </admin-layout>
</template>

<script>
import AdminLayout from "@/Layouts/Admin/AdminLayout.vue";
import {
    Phone,
    LocationInformation,
    VideoCameraFilled,
    School,
} from "@element-plus/icons-vue";
export default {
    name: "CinemaDetail",
    components: {
        AdminLayout,
        Phone,
        LocationInformation,
        VideoCameraFilled,
        School,
    },
    props: {
        cinema: { type: Object, required: true },
    },
    data() {
        return {
            loading: false,
        };
    },
    methods: {},
};
</script>
