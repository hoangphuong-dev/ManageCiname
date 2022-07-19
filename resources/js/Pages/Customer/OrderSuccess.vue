<template>
    <app-layout>
        <div class="pb-12 pt-6">
            <div class="mx-auto">
                <h2 class="mt-4 mb-10">Đặt vé thành công</h2>
                <div style="height: 29rem" class="w-full shadow-lg p-4">
                    <p class="text-center">
                        Cảm ơn bạn đã tin tưởng và sử dụng các dịch vụ xem phim
                        của PHC . Bạn có thể xem thông tin chi tiết vé vừa đặt
                        trong Email hoặc tải bản PDF để xem chi tiết vé vừa đặt
                    </p>
                    <div class="text-center my-10">
                        <el-button @click="downloadPDF(bill_id)" type="danger">
                            PDF Ticket
                        </el-button>
                    </div>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout.vue";

export default {
    components: { AppLayout },
    props: {
        bill_id: Number,
    },
    methods: {
        downloadPDF(id) {
            window.location.href = route("download_bill_pdf", id);
        },
    },
};
</script>
