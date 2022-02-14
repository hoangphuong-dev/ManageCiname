<template>
  <app-layout title="Dashboard">
    <div class="w-full py-12">
      <div class="lg:w-3/4 bg-white shadow-xl px-3 py-3 h-fit m-auto">
        <div class="flex">
          <div class="w-3/5">
            <h3 class="">応募中の詳細</h3>
          </div>
          <div class="w-2/5 text-right">
            <span class=""
              >更新日時: <span class="font-bold">2021/11/19 15:53</span></span
            >
          </div>
        </div>
        <div class="flex py-5">
          <div class="w-1/2">
            <ul class="steps list-none px-0 py-0">
              <li class="active inline-block mb-1"><span>書類選考</span></li>
              <li class="active inline-block mb-1"><p>Step 02</p></li>
              <li class="undone inline-block mb-1"><p>最終面接</p></li>
            </ul>
          </div>
          <div class="w-1/2">
            <img class="mt-4 float-right" src="/images/svg/message.svg" />
          </div>
        </div>
      </div>

      <div class="lg:w-3/4 bg-white shadow-xl px-3 mt-5 py-3 h-fit m-auto">
        sdsdsd
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
<style src="@vueform/slider/themes/default.css"></style>
<style scoped>
.steps li p,
.steps li span {
  background: #e5f4fd;
  padding: 16px 40px;
  color: #c4c4c4;
  display: block;
  font-size: 14px;
  font-weight: bold;
  position: relative;
  text-indent: 12px;
}

.steps li p:hover {
  text-decoration: none;
}

.steps li p:before {
  border-bottom: 29px solid transparent;
  border-left: 24px solid #fff;
  border-top: 32px solid transparent;
  content: "";
  height: 0;
  position: absolute;
  left: 0;
  top: 50%;
  width: 0;
  margin-top: -31px;
}
.steps li span:after,
.steps li p:after {
  border-bottom: 24px solid transparent;
  border-left: 44px solid #e5f4fd;
  border-top: 29px solid transparent;
  content: "";
  height: 0px;
  position: absolute;
  right: -21px;
  top: 50%;
  width: 0;
  margin-top: -27px;
  z-index: 1;
}

.steps li.active p,
.steps li span {
  background: #a5c242;
  color: #fff;
}

.steps li.active p:after,
.steps li.active span:after {
  border-left: 22px solid #a5c242;
}

.steps li.undone p {
  background: #eee;
  color: #333;
}

.steps li.undone p:after {
  border-left: 22px solid #eee;
}
.steps li.undone p {
  color: #aaa;
}

</style>
