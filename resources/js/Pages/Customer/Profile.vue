<template>
    <app-layout>
        <div class="bg-white min-h-full m-4 mb-0 p-4">
            <Profile :user="user" />
        </div>
    </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout.vue";
import Profile from "@/Components/Profile.vue";

export default {
    components: { AppLayout, Profile },
    props: {
        user: { type: Object, require: true },
    },
};
</script>
