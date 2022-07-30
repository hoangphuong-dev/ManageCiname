<template>
    <admin-layout>
        <template #main>
            <div class="bg-white min-h-full sm:m-4 mb-0 p-4">
                <h2 class="mb-5 text-red-400">Xem chi tiết phim</h2>
                <MovieDetail :movie="movie" :cinemaId="cinemaId" />
            </div>
        </template>
    </admin-layout>
</template>

<script>
import MovieDetail from "@/Components/MovieDetail.vue";
import AdminLayout from "@/Layouts/Admin/AdminLayout.vue";

export default {
    components: {
        AdminLayout,
        MovieDetail,
    },

    props: {
        movie: { type: Object, required: true },
        cinemaId: { type: Number, required: true },
    },
};
</script>
