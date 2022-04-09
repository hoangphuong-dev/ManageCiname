<template>
  <div class="flex relative h-14">
    <div
      v-for="(item, index) in data"
      :key="index"
      class="py-1 pr-2 border-left progress"
      :style="renderStyle(item, index)"
      :class="renderClass(item, index)"
    >
      <div class="long-text st-title">{{ item.title }}</div>
      <div class="long-text st-des">{{ item.description }}</div>
    </div>
  </div>
</template>

<script>
import { reactive } from "vue";

export default {
  name: "ProgressTest",
  props: {
    processes: {
      type: Array,
      required: true,
    },
    jobStep: {
      type: Array,
      required: true,
    },
  },
  setup(props) {
    const rec = props.processes.map((item) => {
      const jobStep = props.jobStep.find((i) => i.job_process_id === item.id);
      let status = 3;

      if (typeof jobStep !== "undefined") {
        status = jobStep.status;
      }

      return {
        title: item.content,
        description: "合格",
        status,
      };
    });

    const data = reactive(rec);

    const length = data.length;

    const renderClassType = (status) => {
      if (status === 0) return "current";
      if (status === 1) return "pending";
      if (status === 2) return "active";
      if (status === 3) return "un-process";
      if (status === 4) return "reject";
    };

    const renderClass = (item, index) => {
      let class1 = {
        [renderClassType(item.status)]: true,
        [index === 0 ? "pl-2" : "pl-8"]: true,
      };

      return class1;
    };

    const horizontalSpacer = 24;
    const renderStyle = (_, index) => {
      let style = {
        "z-index": length - index,
        width: `calc( ${(1 / length) * 100}% + ${horizontalSpacer * index}px )`,
      };

      if (index > 0) {
        style = {
          ...style,
          left: `${(index / length) * 100}%`,
          "margin-left": `-${horizontalSpacer * index}px`,
          "padding-left": `${
            horizontalSpacer * (index - 1) + horizontalSpacer + 6
          }px`,
        };
      }
      return style;
    };
    return {
      data,
      renderClass,
      renderStyle,
    };
  },
};
</script>

<style scoped>
.border-left {
  border-radius: 0px 100px 100px 0px;
  border: 1px solid #ff7777;
  position: absolute;
}

.long-text {
  overflow: hidden;
  white-space: nowrap;
  text-overflow: ellipsis;
}
.active {
  background-color: #ff7777;
  border-color: white;
  height: calc(100% + 1px);
  top: -1px;
}

.pending,
.reject {
  background-color: #fca442;
  border-color: white;
  height: calc(100% + 1px);
  top: -1px;
}

.reject {
  background-color: red;
}

.current {
  background-color: white;
  border-color: #ff7777;
}

.current .st-title {
  color: #ff7777;
}

.current .st-des {
  color: #979797;
}

.active .st-title,
.active .st-des,
.pending .st-title,
.pending .st-des,
.reject .st-title,
.reject .st-des {
  color: white;
}

.un-process {
  background-color: white;
  border-color: #979797;
}

.un-process .st-title,
.un-process .st-des {
  color: #979797;
}

.st-title {
  font-size: 16px;
  font-weight: bold;
}

.st-des {
  font-size: 14px;
}
</style>
