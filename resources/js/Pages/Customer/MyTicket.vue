<template>
    <app-layout>
        <div class="bg-white min-h-full m-4 mb-0 p-4">
            <h2 class="mb-5">Lịch sử hóa đơn</h2>
            <view-bill :bills="bills" :filtersBE="filtersBE"></view-bill>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout.vue";
import { getYoutubeId } from "@/Helpers/youtube.js";
import { Inertia } from "@inertiajs/inertia";
import { onBefore, onFinish } from "@/Uses/request-inertia";
import ViewBill from "@/Components/ViewBill.vue";

export default {
    components: { AppLayout, ViewBill },
    props: {
        provinces: { type: Array, require: true },
        bills: { type: Object, require: true },
        filtersBE: { type: Object, require: true },
    },

    data: function () {
        return {
            loading: false,
        };
    },
    methods: {
        detail(id) {
            Inertia.get(route("movie.detail", id), { onBefore, onFinish });
        },
        videoId(row) {
            return getYoutubeId(row);
        },
    },
};
</script>
