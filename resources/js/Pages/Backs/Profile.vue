<template>
    <admin-layout>
        <template #main>
            <div class="bg-white min-h-full m-4 mb-0 p-4">
                <Profile :user="user" />
            </div>
        </template>
    </admin-layout>
</template>

<script>
import AdminLayout from "@/Layouts/Admin/AdminLayout.vue";
import Profile from "@/Components/Profile.vue";

export default {
    components: { AdminLayout, Profile },

    props: {
        user: { type: Object, require: true },
    },
};
</script>
