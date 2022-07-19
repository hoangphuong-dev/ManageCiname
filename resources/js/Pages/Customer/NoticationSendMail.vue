<template>
    <app-layout>
        <div class="pb-12 pt-6">
            <div class="mx-auto">
                <h2 class="mb-16">Đặt vé</h2>
                <div style="height: 29rem" class="w-full shadow-lg p-4 my-6">
                    <div class="w-11/12 m-auto">
                        <p class="text-xl">
                            Chúng tôi đã gửi một email đặt vé . Để xác thực bạn
                            là chủ sở hữu email. Vui lòng click vào link đã được
                            gửi đến email để tiếp tục quy trình đặt vé .
                        </p>
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
};
</script>
