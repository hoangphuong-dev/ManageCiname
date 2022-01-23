<template>
    <div class="user-input">
        <el-input
            ref="content"
            v-model="textContent"
            :placeholder="$t('Please input')"
            class="sc-user-input el-input__custom"
            @keyup.enter="submitText"
        ></el-input>
        <a
            id="guest__send-button"
            class="send-button send-button__disabled"
            @click="submitText"
        >
            <el-icon><promotion /></el-icon>
        </a>
    </div>
</template>

<script>
export default {
    components: {},
    props: {
        onSubmit: {
            type: Function,
            required: true,
        },
        placeholder: {
            type: String,
            default: "Write something...",
        },
        colors: {
            type: Object,
            required: true,
        },
    },
    data() {
        return {
            textContent: "",
        };
    },
    watch: {
        textContent() {
            if (this.textContent.trim() != 0) {
                let elBtn = document.getElementById("guest__send-button");
                elBtn.classList.remove("send-button__disabled");
            } else if (this.textContent.trim() == "") {
                let elBtn = document.getElementById("guest__send-button");
                elBtn.classList.add("send-button__disabled");
            }
        },
    },
    watch: {
        textContent() {
            if (this.textContent.trim() != 0) {
                let elBtn = document.getElementById("guest__send-button");
                elBtn.classList.remove("send-button__disabled");
            } else if (this.textContent.trim() == "") {
                let elBtn = document.getElementById("guest__send-button");
                elBtn.classList.add("send-button__disabled");
            }
        },
    },
    mounted() {
        this.$root.$on("focusUserInput", () => {
            if (this.$refs.userInput) {
                this.focusUserInput();
            }
        });
    },
    methods: {
        focusUserInput() {
            this.$nextTick(() => {
                this.$refs.userInput.focus();
            });
        },
        submitText() {
            if (this.textContent.trim() == "") {
                this.$refs.content.focus();
                return (this.textContent = "");
            }
            let message = this.textContent.replace(/\s+/g, " ").trim();
            this.$eventBus.publish("click-button-send-guest-message", message);
            this.textContent = "";
            this.$refs.content.focus();
        },
    },
};
</script>

<style>
.sc-user-input {
    margin: 0px;
    position: relative;
    bottom: 0;
    display: flex;
    background-color: #f4f7f9;
    border-bottom-left-radius: 10px;
    border-bottom-right-radius: 10px;
    transition: background-color 0.2s ease, box-shadow 0.2s ease;
}

.sc-user-input--text {
    flex-grow: 1;
    outline: none;
    border-bottom-left-radius: 10px;
    box-sizing: border-box;
    padding: 18px;
    font-size: 15px;
    line-height: 1.33;
    white-space: pre-wrap;
    word-wrap: break-word;
    color: #565867;
    -webkit-font-smoothing: antialiased;
    max-height: 200px;
    overflow-x: hidden;
    overflow-y: auto;
}

.sc-user-input--text:empty:before {
    content: attr(placeholder);
    display: block; /* For Firefox */
    filter: contrast(15%);
    outline: none;
    cursor: text;
}

.sc-user-input--buttons {
    display: flex;
    align-items: center;
    padding: 0 4px;
}

.sc-user-input--button {
    margin: 0 4px;
}

.sc-user-input.active {
    box-shadow: none;
    background-color: white;
    box-shadow: 0px -5px 20px 0px rgba(150, 165, 190, 0.2);
}

.file-container {
    background-color: #f4f7f9;
    border-top-left-radius: 10px;
    padding: 5px 20px;
    color: #565867;
}

.delete-file-message {
    font-style: normal;
    float: right;
    cursor: pointer;
    color: #c8cad0;
}

.delete-file-message:hover {
    color: #5d5e6d;
}

.icon-file-message {
    margin-right: 5px;
}
.el-input-group--prepend .el-input__inner,
.el-input-group__append {
    display: flex !important;
    justify-content: center !important;
    border: none !important;
}
.user-input {
    display: flex !important;
    border-top: 1px solid #c4c8cf33;
    border-bottom-left-radius: 9px;
}
.el-input__inner {
    border: none !important;
}
.el-input__custom > input:first-child {
    border-bottom-left-radius: 9px;
}
.send-button {
    border: none !important;
    padding: 0 15px;
    font-size: 25px;
    cursor: pointer;
    color: #4e8cff;
    display: flex;
    align-items: center;
    justify-content: center;
}
.send-button__disabled {
    color: #c4c8cf;
    cursor: not-allowed;
}
</style>
