<template>
    <app-layout title="Dashboard">
        <div class="py-12">
            <div class="mx-auto messenger-window__custom">
                <div class="bg-white overflow-hidden shadow-xl">
                    <messenger />
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout.vue";
import Messenger from "./Components/Messenger";
import { useStore } from 'vuex'

export default {
    components: { Messenger, AppLayout },
    setup() {
        const store = useStore();
        console.log(store)
    }
};
</script>
