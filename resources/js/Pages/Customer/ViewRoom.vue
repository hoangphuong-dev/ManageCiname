<template>
    <app-layout>
        <div class="pb-12 pt-6">
            <ViewRoom
                :showtime="showtime"
                :seat_ordered="seat_ordered"
                :seat_types="seat_types"
                :count_down="count_down"
            />
        </div>
    </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout.vue";
import ViewRoom from "@/Components/ViewRoom.vue";

export default {
    components: { AppLayout, ViewRoom },

    props: {
        showtime: { type: Object, required: true },
        seat_ordered: { type: Object, required: true },
        seat_types: { type: Object, required: true },
        count_down: { type: String, required: true },
    },
};
</script>
