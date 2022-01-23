import { debounce } from 'lodash';

export default {
    data() {
        return {
            isStatusSuccess: false,
            isStatusError: false,
        };
    },
    mounted() {
        this.triggerMessage();
    },
    computed: {
        success: function () {
            return this.$page.props.isSuccess;
        },
        error: function () {
            return this.$page.props.isError;
        },
        timestamp: function () {
            return this.$page.props.timestamp;
        },
    },
    methods: {
        triggerMessage: debounce(function() {
            this.error && this.error?.trim() != '' && this.$message.error(this.error);
            this.success && this.success?.trim() != '' && this.$message.success(this.success);
        }, 100)
    },
    watch: {
        timestamp: function () {
            this.triggerMessage();
        },
    },
};
