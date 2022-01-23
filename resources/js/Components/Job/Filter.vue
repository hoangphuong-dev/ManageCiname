<template>
  <div class="w-full">
    <div class="main-filter my-10 p-10 rounded-md">
      <div class="grid grid-cols-2 gap-4 pb-5 mb-4 main-filter__item--border">
        <div class="flex">
          <h3 class="label_fitter xl:w-1/6 lg:w-28 sm:w-28">資格</h3>
          <div class="flex w-4/5 flex-wrap gap-2">
            <div
              v-for="(item, index) in checkList1"
              :key="index"
              class="
                ck-button
                lg:px-1 lg:py-1
                md:py-0.5
                flex
                justify-center
                h-max
              "
            >
              <label>
                <span @click="filterByHospitalType(item.id)">
                  {{ item.value }}
                </span>
              </label>
            </div>
          </div>
        </div>
        <div class="flex">
          <h3 class="label_fitter xl:w-1/6 lg:w-28 sm:w-28">勤務地</h3>
          <el-input
            ref="search"
            v-model="address"
            @keyup.enter="searchAddress()"
          />
        </div>
      </div>

      <div class="grid grid-cols-2 gap-4 pb-5 mb-4 main-filter__item--border">
        <!-- hospital type -->
        <div class="flex">
          <h3 class="label_fitter xl:w-1/6 lg:w-28 sm:w-28">施設形態</h3>
          <div class="flex w-4/5 flex-wrap gap-2">
            <div
              v-for="(item, indexHospitalType) in hospital_types"
              :key="indexHospitalType"
              class="
                ck-button
                lg:px-1 lg:py-1
                md:px-1 md:py-0.5
                cursor-pointer
                h-max
              "
              :class="{ active_tag: hospitalTypeActive === item.id }"
              @click="filterByHospitalType(item.id)"
            >
              <label>
                <span class="cursor-pointer">{{ item.name }}</span>
              </label>
            </div>
          </div>
        </div>
        <!-- working_hours -->
        <div class="flex">
          <h3 class="label_fitter xl:w-1/6 lg:w-28 sm:w-28">雇用形態</h3>
          <div class="flex w-4/5 flex-wrap gap-2">
            <div
              v-for="(item, index) in workingHourList"
              :key="index"
              class="
                ck-button
                lg:px-1 lg:py-1
                md:py-0.5
                flex
                justify-center
                h-max
                cursor-pointer
              "
              :class="{ active_tag: workingHourActive === item }"
              @click="filterByWorkingHour(item)"
            >
              <span class="cursor-pointer">{{ item }}</span>
            </div>
          </div>
        </div>
      </div>

      <div class="grid grid-cols-2 gap-4 pb-5 mb-4 main-filter__item--border">
        <div class="grid grid-flow-row-dense grid-cols-6">
          <h3 class="label_fitter lg:w-28">年収</h3>
          <div class="slider-salary h-15 pt-5 w-4/5 col-span-5">
            <Slider
              v-model="valueSlider"
              :format="format"
              tooltipPosition="bottom"
              @update="filterByAnnualIncome(valueSlider)"
            />
          </div>
        </div>
        <!-- Sở y tế -->
        <div class="flex">
          <h3 class="label_fitter xl:w-1/6 lg:w-28 sm:w-28">診療科目</h3>
          <div class="flex flex-wrap gap-2">
            <div
              v-for="(item, index) in checkList1"
              :key="index"
              class="hospital-type lg:px-2 lg:py-2 md:px-1 md:py-0.5"
            >
              <span class="text-sm" @click="filterByHospitalType(item.id)">
                {{ item.value }}
              </span>
            </div>
          </div>
        </div>
      </div>

      <div class="flex my-6">
        <h3 class="label_fitter mt-3 mr-8">キーワード</h3>
        <div class="w-11/12 relative">
          <el-input
            ref="search"
            clearable
            v-model="keyword"
            @keyup.enter="searchChange()"
          />
          <img class="absolute top-3 left-4" src="/images/svg/jobs/search.svg" alt="" />
        </div>
      </div>

      <!-- tag -->
      <div class="main-filter__tag">
        <span class="tag-group__title">最近の検索</span>
        <span
          v-for="item in tags"
          :key="item.id"
          :type="item.type"
          effect="info"
          class="
            p-2
            rounded-100
            bg-white
            border
            mr-3
            cursor-pointer
            ck-button__tag
          "
          :class="{ active_tag: tagActive === item.id }"
          @click="filterByTag(item.id)"
        >
          {{ item.name }}
        </span>
      </div>
      <!-- Button search -->
      <div class="flex justify-center" @click.prevent="searchChange(); searchAddress()">
        <el-button class="main-filter__btn--style">
          <div class="flex items-center justify-center">
            <el-image class="mr-3" src="/images/svg/search.svg"></el-image>
            <div class="text-white">検索</div>
          </div>
        </el-button>
      </div>
    </div>
  </div>
</template>

<script>
import Slider from "@vueform/slider";
import { defineComponent, reactive, toRefs, ref } from "vue";

export default defineComponent({
  props: {
    tags: Array,
    hospital_types: Array,
    filter: Object,
  },
  methods: {
    filterByTag(tag_id) {
      this.tagActive = tag_id;
      this.filter.tag = tag_id;
      this.$emit("handleFilter");
    },
    filterByHospitalType(hospital_type_id) {
      this.hospitalTypeActive = hospital_type_id;
      this.filter.hospital_type = hospital_type_id;
      this.$emit("handleFilter");
    },
    filterByWorkingHour(working_hours) {
      this.workingHourActive = working_hours;
      this.filter.working_hours = working_hours;
      this.$emit("handleFilter");
    },
    filterByAnnualIncome(valueSlider) {
      this.filter.annual_income_min = valueSlider[0] * 50;
      this.filter.annual_income_max = valueSlider[1] * 50;
      this.$emit("handleFilter");
    },
    searchChange() {
      this.filter.name = this.keyword;
      this.$emit("handleFilter");
    },
    searchAddress() {
      this.filter.address = this.address;
      this.$emit("handleFilter");
    },
  },
  components: { Slider },
  setup() {
    const searchName = ref("");
    return {
      searchName,
      options: ref([
        {
          value: "Option1",
          label: "Option1",
        },
        {
          value: "Option2",
          label: "Option2",
        },
      ]),
      checkList1: ref([
        { value: "看護師" },
        { value: "准看護師" },
        { value: "助産師" },
        { value: "ケアマネージャー" },
      ]),
      format: function (value) {
        return `${value * 50}万`;
      },
      valueSlider: [0, 1000],
      value: ref(""),
      keyword: ref(""),
      address: ref(""),
      tagActive: ref(""),
      hospitalTypeActive: ref(""),
      workingHourActive: ref(""),
      workingHourList: ref(["日勤", "準夜", "深夜", "夜勤", "パート "]),
    };
  },
});
</script>
<style src="@vueform/slider/themes/default.css"></style>

<style>
.el-input--suffix .el-input__inner {
    padding-left: 40px;
}
.hospital-type {
  background-color: #fff;
  border-radius: 23px;
  border: 1px solid #cccccc;
  color: #5b5b5b;
}
.main-filter {
  background: #fceae6;
  border: 1px solid #cccccc;
}
.main-filter__item--border {
  border-bottom: 1px dashed #979797;
}
.main-filter__btn--style {
  background: #f4a0c6;
  border-radius: 8px;
  width: 293px;
  height: 48px;
}
.main-filter__tag {
  margin-bottom: 40px;
}
.tag-group__title {
  font-style: normal;
  font-weight: bold;
  font-size: 16px;
  line-height: 26px;
  color: #5b5b5b;
  margin-right: 31px;
}
.el-tag--radius {
  border: 1px solid #cccccc;
  box-sizing: border-box;
  border-radius: 100px;
  margin-right: 8px;
  margin-bottom: 10px;
}
.main-paginate {
  margin-bottom: 35px;
  margin-top: 35px;
}

.ck-button {
  background-color: #fff;
  border-radius: 4px;
  border: 1px solid #cccccc;
  color: #5b5b5b;
}
.active_tag {
  border: 1px solid #a5c242;
  color: #a5c242;
}
.ck-button:hover {
  border: 1px solid #a5c242;
  color: #a5c242;
}
.ck-button__tag:hover {
  border: 1px solid #a5c242;
  color: #a5c242;
}
.ck-button label {
  float: left;
}

.ck-button label span {
  text-align: center;
  padding: 3px 0px;
  display: block;
}

.ck-button label input {
  position: absolute;
  top: -20px;
}

.ck-button input:checked + span {
  color: #a5c242;
}

/* Reponsive */
@media (max-width: 1024px) {
  .ck-button label span {
    font-size: 13px;
  }
  .grid-cols-2 {
    grid-template-columns: repeat(1, minmax(0, 1fr));
  }
}
@media (max-width: 425px) {
  .ck-button {
    font-size: 12px;
    margin-right: 7px;
  }
  .label_fitter {
    margin-right: 24px;
    font-size: 12px;
  }
}
</style>
