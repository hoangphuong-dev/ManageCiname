<template>
    <admin-layout>
        <template #main>
            <div class="bg-white min-h-full sm:m-4 mb-0 p-4">
                <h2 class="mb-5 text-red-400">Chọn suất chiếu</h2>
                <ViewShowTime
                    :twoWeeks="twoWeeks"
                    :filterFE="filterFE"
                    :showtimes="showtimes"
                />
            </div>
        </template>
    </admin-layout>
</template>

<script>
import AdminLayout from "@/Layouts/Admin/AdminLayout.vue";
import ViewShowTime from "@/Components/ViewShowTime.vue";

export default {
    components: {
        AdminLayout,
        ViewShowTime,
    },

    props: {
        twoWeeks: { type: Array, required: true },
        filterFE: { type: Object, required: true },
        showtimes: { type: Object, required: true },
    },
};
</script>
