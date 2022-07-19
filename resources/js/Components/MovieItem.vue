<template>
    <div v-if="movies.data.length > 0" class="grid grid-cols-4 gap-6 mt-5">
        <div
            v-for="item in movies.data"
            :key="item.id"
            class="border rounded-md p-4"
        >
            <img
                style="width: 100%"
                :src="
                    'https://i3.ytimg.com/vi/' +
                    videoId(item) +
                    '/maxresdefault.jpg'
                "
            />

            <h2 class="text-center my-2">
                {{ item.name }}
            </h2>
            <div class="w-full text-center">
                <el-button
                    size="small"
                    @click="this.$inertia.visit(route('movie.detail', item.id))"
                    type="danger"
                >
                    Xem chi tiết
                </el-button>
            </div>
        </div>
    </div>
    <div v-else>
        <el-empty description="Không có dữ liệu"></el-empty>
    </div>
</template>

<script>
import { getYoutubeId } from "@/Helpers/youtube.js";

export default {
    props: {
        movies: {
            type: Object,
            required: true,
        },
    },

    methods: {
        videoId(row) {
            return getYoutubeId(row);
        },
    },
};
</script>
