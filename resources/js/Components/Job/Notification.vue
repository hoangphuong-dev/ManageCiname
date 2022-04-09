<template>
  <div class="noti w-full">
    <div class="noti-head flex justify-between items-center">
      <span>お知らせのタイトル</span>
      <p>&times;</p>
    </div>
    <div v-for="(item, indexItem) in items" :key="indexItem" class="noti-item">
      <div class="flex items-center">
        <div class="noti-item__pink-dot mr-2">
          <el-image src="/images/svg/jobs/dot.svg"></el-image>
        </div>
        <div class="noti-item__title">{{ item.title }}</div>
      </div>
      <div class="noti-item__content">{{ item.content }}</div>
      <div class="noti-item__time flex items-center">
        <el-image class="mr-2" src="/images/svg/jobs/clock.svg"></el-image
        >{{ item.time }}
      </div>
    </div>
  </div>
</template>

<script>
import { defineComponent } from "vue";

export default defineComponent({
  components: {},
  setup() {
    return {
      items: [
        {
          title: "年々需要が高まる看護師。その背景は！？",
          content:
            "「令和２年賃金構造基本統計調査」によれば看護師の平均年収は、約492万円で、そのうち年間賞与などが約86万円となっています。施設別人数のデータを見ると、10～99人の施設で働く看護師の平均年収は約456万円、100～999人の施設が約480万円、1,000人以上の施設が約522万円という結果です。同じ調査によれば、准看護師の平均年収が約413万円、理学療法士・作業療法士などの平均年収が約419万円であることから、看護師の平均年収は比較的高いといえます。",
          time: "2021年11月22日",
        },
        {
          title: "看護師の平均年収はどのくらい？",
          content:
            "日本では少子高齢化が急激に進んでおり、2025年には団塊世代が75歳以上を迎えます。生活習慣病や慢性疾患、認知症などを抱える患者さんも増えることが予想されるため、看護師の需要は急激に高まっている状況です。日本看護協会の資料によれば、約15％の看護師が、訪問看護ステーション・居宅サービス・各種老人ホームなど、介護福祉施設で勤務しています。また、日本人の平均寿命も緩やかに上昇していることから、予防医療のニーズも増している点も特徴です。",
          time: "2021年11月22日",
        },
      ],
    };
  },
});
</script>
<style scoped>
.noti {
  padding: 15px;
  padding-bottom: 0;
  background: #fbffed;
  border: 1px solid #ff7777;
  border-radius: 8px;
  margin-bottom: 30px;
}
.noti-head > span {
  font-style: normal;
  font-weight: bold;
  font-size: 24px;
  line-height: 32px;
  color: #fca442;
  margin-bottom: 14px;
}
.noti-item {
  border-bottom: 1px solid #cccccc;
  padding-bottom: 15px;
  margin-bottom: 15px;
}
.noti-item__pink-dot {
  margin-right: 8px;
}
.noti-item__title {
  font-style: normal;
  font-weight: bold;
  font-size: 16px;
  color: #3d3d3d;
}
.noti-item__content {
  font-style: normal;
  font-weight: normal;
  font-size: 14px;
  color: #5b5b5b;
  margin-bottom: 8px;
}
.noti-item__time {
  font-style: normal;
  font-weight: normal;
  font-size: 14px;
  text-transform: uppercase;
  color: #1f1f1f;
}
</style>
