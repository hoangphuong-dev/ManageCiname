<template>
    <admin-layout>
        <template #main>
            <div class="bg-white min-h-full sm:m-4 mb-0 p-4">
                <h2 class="mb-5 text-red-400">Đặt vé cho khách</h2>
                <div class="text-center items-center">
                    <p>
                        Đặt vé thành công , khách hàng có thể đăng nhập tài
                        khoản bằng các thông tin đã gửi về email.
                    </p>

                    <p>Bạn có thể in vé vừa đặt tại đây</p>

                    <el-button @click="downloadPDF(billId)" type="danger">
                        In vé
                    </el-button>
                </div>
            </div>
        </template>
    </admin-layout>
</template>

<script>
import AdminLayout from "@/Layouts/Admin/AdminLayout.vue";
import ConfirmOrder from "@/Components/ConfirmOrder.vue";

export default {
    components: { AdminLayout, ConfirmOrder },

    props: {
        billId: { type: Number, required: true },
    },

    methods: {
        downloadPDF(id) {
            window.location.href = route("download_bill_pdf", id);
        },
    },
};
</script>
