<template>
    <div class="w-full" style="height: 760px">
        <el-container class="h-full">
            <el-aside class="el-aside--custom pt-6 pr-4 pl-4">
                <div class="flex relative">
                    <el-input
                        placeholder="Search"
                        ref="search"
                        v-model="searchName"
                        clearable
                        size="small"
                        @input="searchChange()"
                    />
                    <button type="submit" class="absolute right-2 top-2">
                        <img src="/images/svg/icon-search.svg" />
                    </button>
                </div>
                <div
                    v-for="(user, indexUser) in users"
                    :key="indexUser"
                    class="list-user mt-8 flex border-b-2 pb-2"
                >
                    <div
                        class="avatar mr-3"
                        :style="`background-image: url(/images/avatar/${user.avatar}.png)`"
                    ></div>
                    <div class="info">
                        <div class="name">
                            <p>{{ user.name }}</p>
                        </div>
                        <div class="latest-message">
                            <p>
                                {{
                                    user.latestMessage.length > 13
                                        ? `${user.latestMessage
                                              .replace(/(\r\n|\n|\r)/gm, "")
                                              .substring(0, 13)}...`
                                        : user.latestMessage
                                }}
                            </p>
                        </div>
                    </div>
                </div>
            </el-aside>
            <el-container>
                <el-header class="flex items-center border-b-2 py-3">
                    <div
                        class="avatar mr-3"
                        style="background-image: url(/images/avatar/avt4.png)"
                    ></div>
                    <div class="info">
                        <div class="name"><p>Abc</p></div>
                        <div class="flex items-center justify-between user-status">
                            <div class="user-status__animation w-3 h-3 mr-1 rounded-full" :style="statusOnline ? 'background-color: #68D391;' : 'background-color: gray;'"></div>
                            <div class="user-status__text">{{ statusOnline ? 'Online' : 'Offline' }}</div>
                        </div>
                    </div>
                </el-header>
                <el-main style="padding: 0px">
                    <div id="list-message">
                        <text-message :messages="messages" />
                    </div>
                </el-main>
                <el-footer class="chat-window__footer">
                    <div class="flex items-center h-full">
                        <a class="px-3" @click="submitText">
                            <img src="/images/svg/icon-send.svg" alt="" />
                        </a>
                        <el-input
                            ref="content"
                            v-model="textContent"
                            placeholder="Type a message"
                            size="small"
                            @keyup.enter="submitText"
                        />
                        <a class="px-3" @click="submitText">
                            <img src="/images/svg/icon-send.svg" alt="" />
                        </a>
                    </div>
                </el-footer>
            </el-container>
            <el-aside class="el-aside-info--custom px-4">
                <div class="hospital-info">
                    <div
                        class="
                            hospital-info__img
                            w-60
                            m-auto
                            h-40
                            my-4
                            rounded-md
                        "
                        style="
                            background-image: url(/images/avatar/hospital-avt.png);
                        "
                    ></div>
                    <div class="flex py-3">
                        <img class="pr-2" src="/images/svg/building.svg" />
                        <p>会社名: {{ this.hospital.name }}</p>
                    </div>
                    <div class="flex pb-3">
                        <img class="pr-2" src="/images/svg/location.svg" />
                        <p>住所: {{ this.hospital.address }}</p>
                    </div>
                </div>
                <div class="px-2 py-3 hospital-info-detail">
                    <h3 style="color: #fca442">求人情報</h3>
                    <p>
                        {{ this.hospital.job_title }}
                    </p>
                </div>
                <div class="flex py-3 hospital-info-detail">
                    <img class="pr-2" src="/images/svg/bag_money.svg" />
                    <p>
                        【月収】{{ this.hospital.salary.min }}万円～{{
                            this.hospital.salary.max
                        }}万円 程度
                    </p>
                </div>
                <div class="flex py-3 hospital-info-detail">
                    <img class="pr-2" src="/images/svg/hospital.svg" />
                    <p>訪問看護ステーション：{{ this.hospital.job_type }}</p>
                </div>
                <div class="flex py-3 hospital-info-detail">
                    <img class="pr-2" src="/images/svg/clock.svg" />
                    <p>{{ this.hospital.work_time }}</p>
                </div>
                <div class="flex py-3 hospital-info-detail">
                    <img class="pr-2" src="/images/svg/calender.svg" />
                    <p>{{ this.hospital.holidays }}</p>
                </div>
            </el-aside>
        </el-container>
    </div>
</template>

<script>
import TextMessage from "./TextMessage.vue";
export default {
    components: { TextMessage },
    data() {
        return {
            users: [
                {
                    name: "Đào Duy Anh",
                    avatar: "avt2",
                    latestMessage: "求人検索求人検索求人検索求人検索 11111111111",
                },
                {
                    name: "Nguyễn Thùy Trang",
                    avatar: "avt2",
                    latestMessage: "求人検索求求人検索求",
                },
                {
                    name: "Lê Trọng Hiếu",
                    avatar: "avt4",
                    latestMessage: "aloalo3",
                },
                {
                    name: "Nguyễn Văn Thắng",
                    avatar: "avt5",
                    latestMessage: "aloalo4",
                },
                {
                    name: "Lê Mai Hoa",
                    avatar: "avt5",
                    latestMessage: "aloalo5",
                },
                {
                    name: "Lê Mai Hoa",
                    avatar: "avt5",
                    latestMessage: "aloalo5",
                },
                {
                    name: "Lê Mai Hoa",
                    avatar: "avt5",
                    latestMessage: "aloalo5",
                },
                {
                    name: "Lê Mai Hoa",
                    avatar: "avt5",
                    latestMessage: "aloalo5",
                },
                {
                    name: "Lê Mai Hoa",
                    avatar: "avt5",
                    latestMessage: "aloalo5",
                },
                {
                    name: "Lê Mai Hoa",
                    avatar: "avt5",
                    latestMessage: "aloalo5",
                },
                {
                    name: "Lê Mai Hoa",
                    avatar: "avt5",
                    latestMessage: "aloalo5",
                },
                {
                    name: "Lê Mai Hoa",
                    avatar: "avt5",
                    latestMessage: "aloalo5",
                },
                {
                    name: "Lê Mai Hoa",
                    avatar: "avt5",
                    latestMessage: "aloalo5",
                },
            ],
            textContent: "",
            messages: [
                {
                    sender_id: "1",
                    content: "omg, this is amazing",
                    date: "10/12/2021",
                    time: "20:30",
                },
                {
                    sender_id: "1",
                    content: "Wow, this is really epic",
                    date: "10/12/2021",
                    time: "20:30",
                },
                {
                    sender_id: "2",
                    content: "How are you?",
                    date: "10/12/2021",
                    time: "20:30",
                },
                {
                    sender_id: "2",
                    content: "Haha that is terrifying",
                    date: "10/12/2021",
                    time: "20:30",
                },
                {
                    sender_id: "1",
                    content: "aww",
                    date: "10/12/2021",
                    time: "20:30",
                },
                {
                    sender_id: "1",
                    content: "aww",
                    date: "10/12/2021",
                    time: "20:30",
                },
                {
                    sender_id: "1",
                    content: "aww",
                    date: "10/12/2021",
                    time: "20:30",
                },
            ],
            hospital: {
                name: "HONDA",
                address: "6RJ3+38 Zentsūji, Kagawa",
                job_title:
                    "【東京都／新宿区】ゆとりある勤務形態で、充実の研修で未経験の方でも安心で す／新宿EAST支店",
                salary: {
                    min: "25.0",
                    max: "40.0",
                },
                job_type: "訪問看護",
                work_time: "08時30分～17時30分（休憩60分）※オンコール対応：有",
                holidays:
                    "	4週8休制　祝日　年末年始休暇　夏季休暇　有給休暇年間休日：125日",
            },
            params: {},
            statusOnline: true
        };
    },
    mounted() {
        this.$refs.content.focus();
    },
    methods: {
        // handleCommand() {
        //     return {
        //         // onBefore: () => {
        //         //     this.$spinner.show();
        //         // },
        //         onSuccess: () => {
        //             this.textContent = "";
        //             this.$refs.content.focus();
        //             this.gotoBottomChat();
        //         },
        //         // onFinish: () => {
        //         //     this.$spinner.hide();
        //         // },
        //         // onError: (errors) => {
        //         //     this.validateField.name = errors.name;
        //         //     this.$refs.ruleForm.validateField("name");
        //         //     this.focusInput();
        //         // },
        //     };
        // },
        submitText() {
            this.pushMessageToCurrentConversation();
            this.params = {
                ...this.params,
                messages: this.textContent,
            };
            // this.$inertia.post(
            //     this.route("api.handle.message"),
            //     this.params,
            //     this.handleCommand()
            // );
        },
        gotoBottomChat() {
            this.$nextTick(() => {
                const elMsgList = document.getElementById("list-message");
                elMsgList.scrollTop = elMsgList.scrollHeight;
            });
        },
        pushMessageToCurrentConversation() {
            if (this.textContent.trim() == "") {
                this.$refs.content.focus();
                return (this.textContent = "");
            }
            let newMessage = {
                sender_id: "1",
                content: this.textContent.replace(/\s+/g, " ").trim(),
                date: new Date()
                    .toJSON()
                    .slice(0, 10)
                    .split("-")
                    .reverse()
                    .join("/"),
                time: new Date()
                    .toJSON()
                    .slice(12, 16)
                    .split("-")
                    .reverse()
                    .join("/"),
            };
            this.messages.push(newMessage);
            this.messages = [...this.messages];
            this.textContent = "";
            this.$refs.content.focus();
            this.gotoBottomChat();
        },
    },
};
</script>
<style scoped>
.el-aside--custom {
    border-right: 1px solid #cccccc;
}
.search {
    border: 1px solid #dfdfdf;
}
.avatar {
    width: 48px;
    height: 48px;
    border-radius: 8px;
}
.name {
    font-style: normal;
    font-weight: bold;
    font-size: 16px;
    line-height: 26px;
    color: #3d3d3d;
}
.latest-message {
    font-style: normal;
    font-weight: normal;
    font-size: 14px;
    line-height: 100%;
    color: #5b5b5b;
}
.hospital-info {
    border-bottom: 1px solid #f5f5f5;
}
.el-aside-info--custom {
    border-left: 1px solid #cccccc;
}
.hospital-info-detail {
    border-bottom: 2px dashed #979797;
}
#list-message {
    padding-top: 10px;
    height: 640px;
    overflow-y: auto;
}
.chat-window__footer {
    border-top: 1px solid #cccccc;
    padding-left: 16px;
    padding-right: 0px;
}

@media (max-width: 640px) {
    .el-aside--custom {
        display: none;
    }
    .el-aside-info--custom {
        display: none;
    }
}
@media (max-width: 768px) {
    .el-aside--custom {
        width: 260px;
    }
    .el-aside-info--custom {
        display: none;
    }
}
</style>
