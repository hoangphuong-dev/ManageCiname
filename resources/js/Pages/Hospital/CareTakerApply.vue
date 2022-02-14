<template>
    <app-layout>
        <care-taker-detail :job="job" :caretaker="caretaker"></care-taker-detail>
    </app-layout>
</template>

<script>
import CareTakerDetail from "@/Components/CareTaker/CareTakerDetail.vue";
export default {
    props: {
        caretaker: {
            required: true
        },
        job: {
            required: true
        }
    },
    components: { CareTakerDetail },
};
</script>

<style></style>
