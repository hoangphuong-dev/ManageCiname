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

  <div class="mt-4">
    <h3 class="my-4">Bạn cần sử dụng 500.000 điểm để lên khách hàng VIP</h3>
    <el-progress
      :text-inside="true"
      :stroke-width="30"
      :percentage="(member_card.used_point / 500000) * 100"
      status="success"
    />
  </div>
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


<style lang="css">
.el-progress-bar__innerText {
  color: black;
  font-weight: bold;
}
</style>