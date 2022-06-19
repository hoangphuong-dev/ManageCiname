<template>
    <div>
        <h3 class="text-center pb-6">Bình luận về phim</h3>
        <!-- list comment  -->
        <div v-for="item in comments" :key="item.id">
            <div v-if="item.parent_id === 0">
                <div class="flex">
                    <el-avatar
                        shape="square"
                        :size="30"
                        :src="
                            getImage(item?.user.image) ||
                            '/uploads/customer.png'
                        "
                    />
                    <h4 class="mt-2 ml-2">{{ item?.user.name }}</h4>
                </div>
                <div class="w-full my-1 border p-2 rounded">
                    {{ item.content }}
                </div>
                <div class="w-full flex mb-6">
                    <div class="w-8/10">
                        <span
                            class="cursor-pointer mx-2 font-bold hover:text-blue-500"
                        >
                            Yêu thích
                        </span>
                        <span
                            @click="reply(item.id)"
                            class="cursor-pointer mx-2 font-bold hover:text-blue-500"
                            >Trả lời
                        </span>
                        <span class="mx-2 text-sm">
                            {{ showTime(item.created_at) }}
                        </span>
                    </div>

                    <div style="width: 17.6%" class="text-right">
                        <span
                            class="cursor-pointer mx-2 font-bold hover:text-blue-500"
                        >
                            <el-badge
                                :value="item.amount_feel"
                                :max="2000"
                                class="-mr-4"
                            >
                                <el-image
                                    style="width: 20px; height: 20px"
                                    src="/images/favorite.svg"
                                    fit="fill"
                                />
                            </el-badge>
                        </span>
                    </div>
                </div>
            </div>

            <!-- show comment children  -->
            <div class="ml-20" v-for="each in comments" :key="each.id">
                <div v-if="each.parent_id === item.id">
                    <div class="flex">
                        <el-avatar
                            shape="square"
                            :size="30"
                            :src="
                                getImage(each?.user.image) ||
                                '/uploads/customer.png'
                            "
                        />
                        <h4 class="mt-2 ml-2">{{ each?.user.name }}</h4>
                    </div>
                    <div class="w-full my-1 border p-2 rounded">
                        {{ each.content }}
                    </div>
                    <div class="w-full mb-6 flex mt-2">
                        <div class="w-8/10">
                            <span
                                class="cursor-pointer mx-2 font-bold hover:text-blue-500"
                            >
                                Yêu thích
                            </span>
                            <span
                                @click="reply(item.id)"
                                class="cursor-pointer mx-2 font-bold hover:text-blue-500"
                                >Trả lời
                            </span>
                            <span class="mx-2 text-xs">
                                {{ showTime(each.created_at) }}
                            </span>
                        </div>

                        <div class="w-2/12 text-right mt-2">
                            <el-badge :value="item.amount_feel" class="-mr-4">
                                <el-image
                                    style="width: 20px; height: 20px"
                                    src="/images/favorite.svg"
                                    fit="fill"
                                />
                            </el-badge>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end show comment children -->
            <!-- rep comment  -->
            <div
                v-if="showFormReply === item.id"
                style="width: calc(100% - 5rem)"
                class="mb-6 ml-20"
            >
                <div>
                    <div class="flex">
                        <el-avatar
                            shape="square"
                            :size="30"
                            :src="
                                getImage(user?.image) || '/uploads/customer.png'
                            "
                        />
                        <h4 class="mt-2 ml-2">{{ user?.name }}</h4>
                    </div>
                    <div class="w-full mt-2">
                        <el-form
                            ref="formReply"
                            :model="formReply"
                            :rules="ruleReply"
                        >
                            <el-form-item prop="content">
                                <el-input
                                    v-model="formReply.content"
                                    :rows="2"
                                    type="textarea"
                                    placeholder="Viết bình luận ..."
                                    @keyup.ctrl.enter="submitReply()"
                                />
                            </el-form-item>
                        </el-form>
                        <div class="text-center mt-4">
                            <el-button
                                @click="submitReply()"
                                type="success"
                                plain
                                >Trả lời</el-button
                            >
                        </div>
                    </div>
                </div>
            </div>
            <!-- end rep comment  -->
        </div>
        <!-- end list comment  -->

        <!-- form comment  -->
        <div>
            <div class="flex">
                <el-avatar
                    shape="square"
                    :size="30"
                    :src="getImage(user?.image) || '/uploads/customer.png'"
                />
                <h4 class="mt-2 ml-2">{{ user?.name }}</h4>
            </div>
            <div class="w-full mt-2">
                <el-form ref="form" :model="form" :rules="rules">
                    <el-form-item prop="content">
                        <el-input
                            v-model="form.content"
                            :rows="2"
                            type="textarea"
                            placeholder="Viết bình luận ..."
                            @keyup.ctrl.enter="submitComment()"
                        />
                    </el-form-item>
                </el-form>
            </div>

            <div class="text-center mt-4">
                <el-button @click="submitComment()" type="success" plain>
                    Bình luận
                </el-button>
            </div>
        </div>
        <!-- end form comment  -->
    </div>
</template>

<script>
import { Inertia } from "@inertiajs/inertia";
import { getCommentMovie } from "@/API/main.js";
import { showTime } from "@/libs/datetime.js";

export default {
    props: {
        user: {
            type: Object,
            require: true,
        },
        movie: {
            type: Object,
            require: true,
        },
    },

    data() {
        return {
            showFormReply: 0,
            comments: [],
            form: {
                movie_id: "",
                user_id: "",
                content: "",
                parent_id: 0,
            },
            formReply: {
                movie_id: "",
                user_id: "",
                content: "",
                parent_id: "",
            },
            rules: {
                content: [
                    {
                        required: true,
                        message: "Nội dung bình luận không được để trống !",
                        triger: "change",
                    },
                ],
            },
            ruleReply: {
                content: [
                    {
                        required: true,
                        message: "Nội dung bình luận không được để trống !",
                        triger: "change",
                    },
                ],
            },
        };
    },

    created() {
        this.fetchData();
    },

    methods: {
        showTime,
        reply(id) {
            this.showFormReply = id;
            this.formReply.parent_id = id;
        },

        submitReply() {
            this.checkLogin;
            this.formReply.user_id = this.user?.id;
            this.formReply.movie_id = this.movie?.id;
            this.$refs["formReply"][0].validate((valid) => {
                if (valid) {
                    Inertia.post(route("comments.store", this.formReply));
                }
            });
            this.formReply.content = "";
            this.showFormReply = "";
            this.fetchData();
        },

        submitComment() {
            this.checkLogin;
            this.form.user_id = this.user?.id;
            this.form.movie_id = this.movie?.id;
            this.$refs["form"].validate((valid) => {
                if (valid) {
                    Inertia.post(route("comments.store", this.form));
                }
            });
            this.form.content = "";
            this.fetchData();
        },

        checkLogin() {
            if (this.user === null) {
                Inertia.get(route("customer.login"));
                return true;
            }
        },

        async fetchData() {
            getCommentMovie(this.movie?.id)
                .then((res) => {
                    this.comments = res.data;
                })
                .catch(() => {});
        },

        isValidHttpUrl(string) {
            let url;
            try {
                url = new URL(string);
            } catch (_) {
                return false;
            }
            return url.protocol === "http:" || url.protocol === "https:";
        },

        getImage(file) {
            if (!file) return;
            if (this.isValidHttpUrl(file)) return file;
            return `/uploads/${file}`;
        },
    },
};
</script>
