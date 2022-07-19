<template>
    <app-layout>
        <div class="pb-12 pt-6">
            <h2 class="mb-10">Quản lý Voucher</h2>
            <div class="flex">
                <div class="w-1/5 mr-4 my-6">
                    <member-card :member_card="member_card"></member-card>
                </div>
                <div class="w-4/5 shadow-lg p-4 my-6 rounded border-2">
                    <div class="w-11/12 m-auto">
                        <h3 class="mb-6">Voucher của tôi</h3>
                        <view-voucher
                            :member_card="member_card"
                            :vouchers="vouchers"
                            :filterBE="filterBE"
                        ></view-voucher>
                    </div>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout.vue";
import ViewVoucher from "@/Components/ViewVoucher.vue";
import MemberCard from "@/Components/MemberCard.vue";

export default {
    components: { AppLayout, ViewVoucher, MemberCard },
    props: {
        vouchers: Object,
        member_card: Object,
        filterBE: Object,
    },
};
</script>
