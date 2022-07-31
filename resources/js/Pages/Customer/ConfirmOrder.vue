<template>
    <app-layout>
        <div class="pb-12 pt-6">
            <ConfirmOrder :showtime="showtime" :data="data" />
        </div>
    </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout.vue";
import ConfirmOrder from "@/Components/ConfirmOrder.vue";

export default {
    components: { AppLayout, ConfirmOrder },
    props: {
        showtime: { type: Object, required: true },
        data: { type: Object, required: true },
    },
};
</script>
