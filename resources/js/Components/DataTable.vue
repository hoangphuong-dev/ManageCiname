<template>
  <div class="data-table">
    <div class="scroll-wrapper"></div>
    <el-table
      ref="table"
      border
      :data="items"
      :default-sort="defaultSort || {}"
      empty-text="Không có dữ liệu"
      @sort-change="sortChange"
      @selection-change="handleSelectionChange"
      @row-click="rowClick"
    >
      <el-table-column v-if="enableSelectBox" type="selection" width="55" />
      <el-table-column v-if="enableIndex" type="index" fixed width="100" :label="label" />
      <el-table-column
        v-for="(field, index) in fields"
        :key="index"
        :fixed="field.fixed"
        :prop="field.key"
        :sortable="field.sortable || false"
        :label="field.label"
        :align="field.align || `left`"
        :width="field.width || 'auto'"
      >
        <!-- Pass on all scoped slots -->
        <template #default="scope">
          <slot :name="field.key" v-bind="scope">
            {{ scope.row[field.key] }}
          </slot>
        </template>
      </el-table-column>

      <!-- Pass on all named slots -->
      <slot v-for="slot in Object.keys($slots)" :slot-scope="slot" :name="slot" />
      <template #empty>
        <i class="el-icon-folder-opened"></i>
        Không có dữ liệu
      </template>
    </el-table>
    <slot v-if="paginate" name="after">
      <div class="card-footer" :class="{ 'card-footer--center': footerCenter }">
        <div v-if="!disableTableInfo" class="table-showing">
          <span>
            {{ tableInfo }}
          </span>
        </div>
        <div class="table-paginattion text-right mt-4">
          <el-pagination
            :page-size="Number(paginate.per_page)"
            :pager-count="5"
            layout="prev, pager, next"
            :total="paginate.total"
            :current-page="currentPage || 1"
            :background="paginateBackground"
            @current-change="handleCurrentChange"
          />
        </div>
      </div>
    </slot>
  </div>
</template>

<script>
export default {
  props: {
    fields: {
      type: Array,
      default: () => [],
    },
    items: {
      type: Array,
      default: () => [],
    },
    paginate: {
      type: Object,
      default: () => {},
    },
    enableIndex: {
      type: Boolean,
      default: false,
    },
    enableSelectBox: {
      type: Boolean,
      default: false,
    },
    currentPage: {
      type: Number,
      default: 1,
    },
    disableTableInfo: {
      type: Boolean,
      default: false,
    },
    headerCenter: {
      type: Boolean,
      default: false,
    },
    footerCenter: {
      type: Boolean,
      default: false,
    },
    paginateBackground: {
      type: Boolean,
      default: false,
    },
    defaultSort: {
      type: Object,
      default: () => {},
    },
  },
  emits: ["row-selected", "page", "sort-change", "row-click"],
  computed: {
    tableInfo() {
      return this.items.length > 0 ? this.$t("table.table_info", this.paginate) : "";
    },
  },
  mounted() {
    let triggerScroll = null;
    this.$nextTick(() => {
      const tableEl = this.$el.querySelector(".el-table__body-wrapper");
      const element = this.$el.querySelector(".el-table__body");

      if (this.$el.querySelector(".is-scrolling-none") == null) {
        const table = this.$el.querySelector(".el-table");

        const tableWidth = table.offsetWidth
          ? table.offsetWidth + "px"
          : table.style.width;
        this.$el.querySelector(".scroll-wrapper").style.width = tableWidth;

        this.$el.querySelector(".scroll-wrapper").addEventListener("scroll", (event) => {
          // prevent infinite trigger scroll
          if (triggerScroll !== "table") {
            triggerScroll = "top";
            this.scrollTable(event.currentTarget.scrollLeft);
          } else {
            triggerScroll = null;
          }
        });

        tableEl.addEventListener("scroll", (event) => {
          // prevent infinite trigger scroll
          if (triggerScroll !== "top") {
            triggerScroll = "table";
            this.scrollTop(event.currentTarget.scrollLeft);
          } else {
            triggerScroll = null;
          }
        });
      }
      let isDown = false;
      let startX;
      let scrollLeft = 0;
      let startY;
      let scrollTop = 0;
      element.addEventListener("mousedown", (e) => {
        isDown = true;
        element.classList.add("active");
        startX = e.pageX - element.offsetLeft;
        startY = e.pageY - element.offsetTop;
        scrollLeft = tableEl.scrollLeft;
        scrollTop = tableEl.scrollTop;
      });
      const moveListener = (e) => {
        if (!isDown) return;
        e.preventDefault();
        const x = e.pageX - element.offsetLeft;
        const y = e.pageY - element.offsetTop;
        const walkX = (x - startX) * 3;
        const walkY = (y - startY) * 3;
        if (walkX !== 0) {
          tableEl.scrollLeft = scrollLeft - walkX;
        }
        if (walkY !== 0) {
          tableEl.scrollTop = scrollTop - walkY;
        }
      };
      element.addEventListener("mousemove", moveListener);
      const upListener = () => {
        isDown = false;
        element.classList.remove("active");
      };
      element.addEventListener("mouseup", upListener);
      element.addEventListener("mouseleave", upListener);
    });
  },
  methods: {
    toggleSelection(rows) {
      if (rows) {
        rows.forEach((row) => {
          this.$refs.table.toggleRowSelection(row);
        });
      } else {
        this.$refs.table.clearSelection();
      }
    },
    handleSelectionChange(selectedItems) {
      this.$emit("row-selected", selectedItems);
    },
    rowClick(row) {
      this.$emit("row-click", row);
    },
    handleCurrentChange(value) {
      this.$emit("page", value);
    },
    scrollTop(val) {
      this.$el.querySelector(".scroll-wrapper").scrollLeft = val;
    },
    scrollTable(val) {
      this.$el.querySelector(".el-table__body-wrapper").scrollLeft = val;
    },
    sortChange(column) {
      this.$emit("sort-change", column);
    },
  },
};
</script>
<style>
.data-table .el-table__header th.el-table__cell {
  background-color: #f0f0f0;
}
.data-table .table-paginattion .el-icon {
  display: flex;
  justify-content: center;
  align-items: center;
}
.data-table .table-paginattion .el-pager {
  display: inline-flex;
}
.data-table .table-paginattion .el-pager .active {
  color: #fca442 !important;
  background-color: white !important;
  border: 1px solid #fca442;
  border-radius: 4px;
}
</style>
