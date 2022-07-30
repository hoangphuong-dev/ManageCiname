<template>
    <admin-layout>
        <template #main>
            <div class="bg-white min-h-full sm:m-4 mb-0 p-4">
                <h2 class="mb-5 text-red-400">Chọn suất chiếu</h2>
            </div>
        </template>
    </admin-layout>
</template>

<script>
import AdminLayout from "@/Layouts/Admin/AdminLayout.vue";

export default {
    components: {
        AdminLayout,
    },

    props: {
        // movie: { type: Object, required: true },
    },
};
</script>
