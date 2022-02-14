<template>
    <div
        v-for="(item, indexItem) in messages"
        :key="indexItem"
        class="flex item-message mb-3 mr-3 ml-3"
        :class="
            item.sender_id == 1 ? `item-message__admin` : `item-message__guest`
        "
    >
        <div
            v-if="item.sender_id != 1"
            class="mr-4 message-avatar"
            style="background-image: url(/images/avatar/avt3-small.png)"
        ></div>
        <el-tooltip
            class="item"
            effect="dark"
            :content="`${item.time}`"
            :placement="getPlacement(item)"
        >
            <div class="flex items-center message-content break-all">
                {{ item.content }}
            </div>
        </el-tooltip>
    </div>
</template>

<script>
export default {
    components: {},
    props: {
        messages: {
            type: Array,
            required: true,
        },
    },

    data() {
        return {};
    },
    mounted() {},
    methods: {
        getPlacement(item) {
            if (item.sender_id == 1) {
                return String("left");
            }
            return String("right");
        },
    },
};
</script>
<style scoped>
.message-avatar {
    background-color: green;
    width: 40px;
    height: 40px;
    border-radius: 8px;
}
.message-content {
    padding: 8px 16px;
    background-color: #f5f5f5;
    color: #5b5b5b;
    border-radius: 12px;
    max-width: 50%;
}
.item-message__admin {
    justify-content: end;
}
.item-message__admin > .message-content {
    background-color: #fca442;
    color: #fff;
}
</style>
