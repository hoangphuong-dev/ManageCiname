<template>
    <component :is="isAdmin ? AdminLayout : AppLayout">
        <template #main v-if="isAdmin">
            <slot></slot>
        </template>
        <slot v-if="!isAdmin">

        </slot>
    </component>
</template>

<script setup>
import AdminLayout from '@/Layouts/Admin/AdminLayout.vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import { Inertia } from '@inertiajs/inertia';
import { computed } from 'vue';

const isAdmin = computed(_ => Inertia?.page?.props?.user?.role != 3);
</script>
