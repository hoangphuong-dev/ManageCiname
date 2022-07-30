<template>
    <admin-layout>
        <template #main>
            <div class="bg-white min-h-full sm:m-4 mb-0 p-4">
                <h2 class="mb-5 text-red-400">Đặt vé cho khách</h2>
                <ViewRoom
                    :showtime="showtime"
                    :seat_ordered="seat_ordered"
                    :seat_types="seat_types"
                    :count_down="count_down"
                />
            </div>
        </template>
    </admin-layout>
</template>

<script>
import AdminLayout from "@/Layouts/Admin/AdminLayout.vue";
import ViewRoom from "@/Components/ViewRoom.vue";

export default {
    components: { AdminLayout, ViewRoom },

    props: {
        showtime: { type: Object, required: true },
        seat_ordered: { type: Object, required: true },
        seat_types: { type: Object, required: true },
        count_down: { type: String, required: true },
    },
};
</script>
