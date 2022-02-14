<template>
  <app-layout title="Dashboard">
    <div class="w-full py-12">
      <div class="flex">
        <div class="w-2/6">
          <div class="flex relative">
            <el-input
              placeholder="Search"
              ref="search"
              v-model="searchName"
              clearable
              size="small"
              @input="searchChange()"
            />
            <button type="submit" class="button-search absolute -right-5">
              <img style="width: 65%;" src="/images/svg/button_search.svg" />
            </button>
          </div>
        </div>
        <div class="w-4/6 justify-right">
          <h3>全 {{ total }} 件 (1～{{ perPage }} 件を表示)</h3>
          <el-pagination
            @current-change="handleCurrentPage"
            :background="true"
            layout="prev, pager, next"
            :page-size="5"
            :pager-count="5"
            :total="25"
            :current-page="filter.page || 1"
          ></el-pagination>
        </div>
      </div>

      <div class="bg-white shadow-xl px-2 py-2">
        <div class="flex border-b-2 px-3 py-3 font-bold">
          <div class="w-3/12">求人名</div>
          <div class="w-6/12">応募ステータス</div>
          <div class="w-3/12">更新日時</div>
        </div>
        <div class="flex border-b-2 px-3 py-4">
          <div class="w-3/12 pr-2 md:text-sm">
            看護師／渋谷区・豊島区・新宿区／GLOWクリニック＜管理職＞
          </div>
          <div class="w-6/12">
            <ul class="steps list-none px-0 py-0">
              <li class="active inline-block mb-1">
                <span class="md:px-10 md:py-4">書類選考</span>
              </li>
              <li class="active inline-block mb-1">
                <p class="md:px-10 md:py-4">Step 02</p>
              </li>
              <li class="undone inline-block mb-1">
                <p class="md:px-10 md:py-4">最終面接</p>
              </li>
            </ul>
          </div>
          <div class="w-2/12">2021/11/19 15:53</div>
          <div class="w-1/12">
            <el-button type="warning">詳細</el-button>
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
<style src="@vueform/slider/themes/default.css"></style>
<style scoped>
.steps li p,
.steps li span {
  background: #e5f4fd;
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
@media only screen and (max-width: 425px) {
  .steps li.active p:after,
  .steps li.active span:after {
    border-left: 22px solid #a5c242;
  }
  .steps li p:before {
    border-bottom: 22px solid transparent;
    border-left: 22px solid #fff;
    border-top: 18px solid transparent;
    margin-top: -19px;
  }
  .steps li span:after,
  .steps li p:after {
    border-bottom: 14px solid transparent;
    border-top: 23px solid transparent;
    margin-top: -19px;
  }
  .steps li p,
  .steps li span {
    padding: 8px 10px;
  }
}
</style>
