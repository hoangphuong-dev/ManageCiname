<template>
    <app-layout>
        <ViewShowTime
            :twoWeeks="twoWeeks"
            :filterFE="filterFE"
            :showtimes="showtimes"
        />
    </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout.vue";
import ViewShowTime from "@/Components/ViewShowTime.vue";

export default {
    components: { AppLayout, ViewShowTime },
    props: {
        twoWeeks: { type: Array, required: true },
        filterFE: { type: Object, required: true },
        showtimes: { type: Object, required: true },
    },
};
</script>
