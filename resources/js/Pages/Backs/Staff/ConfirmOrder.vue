<template>
    <admin-layout>
        <template #main>
            <div class="bg-white min-h-full sm:m-4 mb-0 p-4">
                <h2 class="mb-5 text-red-400">Đặt vé cho khách</h2>
                <ConfirmOrder :showtime="showtime" :data="data" />
            </div>
        </template>
    </admin-layout>
</template>

<script>
import AdminLayout from "@/Layouts/Admin/AdminLayout.vue";
import ConfirmOrder from "@/Components/ConfirmOrder.vue";

export default {
    components: { AdminLayout, ConfirmOrder },

    props: {
        showtime: { type: Object, required: true },
        data: { type: Object, required: true },
    },
};
</script>
