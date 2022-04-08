<template>
  <el-card class="box-card">
    <template #header>
      <div class="text-center">
        <span class="font-bold">Thẻ thành viên</span>
      </div>
    </template>
    <div class="mb-4">Số thẻ : {{ member_card.number_card }}</div>

    <div class="mb-4">Ngày kích hoạt : {{ member_card.created_at }}</div>
    <div class="mb-4">Điểm khả dụng: {{ member_card.accumulating_point }}</div>
    <div class="mb-4">Điểm đã dùng: {{ member_card.used_point }}</div>
    <div class="mb-4">
      Hạng thẻ: Khách {{ member_card.role == 1 ? "VIP" : "phổ thông" }}
    </div>
    <div class="mb-4">
      Trạng thái:
      {{ member_card.status == 1 ? "Đang sử dụng" : "Ngừng sử dụng" }}
    </div>
  </el-card>
</template>


<script>
export default {
  components: {},
  props: {
    member_card: Object,
  },

  data() {
    return {};
  },
  methods: {},
};
</script>
