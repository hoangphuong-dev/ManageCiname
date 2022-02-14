<template>
    <div class="heart-rating">
        <label
            class="heart-rating__heart"
            v-for="(rating, index) in ratings"
            :key="index"
            :class="{ 'is-selected': value >= rating && value != null, 'is-disabled': disabled }"
            @click="setValue(rating)"
            @mouseover="heartOver(rating)"
            @mouseout="heartOut"
        >
            <input
                class="heart-rating heart-rating__checkbox"
                type="radio"
                :value="rating"
                v-model="value"
                :disabled="disabled"
            />
            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="24" viewBox="0 0 28 24" fill="currentcolor">
                <path
                    d="M13.5025 23.8021C5.80024 17.0625 0.375977 13.4925 0.375977 7.81414C0.375977 3.52011 3.43731 0 7.62931 0C10.5383 0 12.6969 1.78651 14.0293 4.3208C15.3616 1.78667 17.5202 0 20.4293 0C24.6218 0 27.6826 3.5208 27.6826 7.81414C27.6826 13.4918 22.2655 17.0563 14.5561 23.802C14.2544 24.066 13.8041 24.066 13.5025 23.8021Z"
                    fill="currentcolor"
                />
            </svg>
        </label>
    </div>
</template>

<script>
export default {
    name: 'Rating',
    props: {
        evaluate: Number,
        disabled: {
            type: Boolean,
            default: false,
        },
    },
    data() {
        return {
            value: this.evaluate,
            temp_value: null,
            ratings: [1, 2, 3, 4, 5],
        }
    },
    methods: {
        heartOver(index) {
            if (!this.disabled) {
                this.temp_value = this.value
                return (this.value = index)
            }
        },

        heartOut() {
            if (!this.disabled) {
                return (this.value = this.temp_value)
            }
        },

        setValue(value) {
            if (!this.disabled) {
                this.temp_value = value
                this.$emit('onEvaluate', value)
                return (this.value = value)
            }
        },
    },
}
</script>

<style>
.heart-rating__checkbox {
    position: absolute;
    overflow: hidden;
    clip: rect(0 0 0 0);
    height: 1px;
    width: 1px;
    margin: -1px;
    padding: 0;
    border: 0;
}

.heart-rating__heart {
    display: inline-block;
    padding: 3px;
    vertical-align: middle;
    line-height: 1;
    font-size: 1.5em;
    color: #ababab;
    transition: color 0.2s ease-out;
}
.heart-rating__heart:hover {
    cursor: pointer;
}
.heart-rating__heart.is-selected {
    color: #f4a0c6;
}
.heart-rating__heart.is-disabled:hover {
    cursor: default;
}
</style>
