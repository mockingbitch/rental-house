<script>
export default {
    props: {
        icon: {
            type: String,
            default: "",
        },
        valueSelected: {
            type: String,
            default: "",
        },
        upSideDownMobile: {
            type: Boolean,
            default: false,
        },
        options: {
            type: Array,
            default: () => [],
        },
        dataDisplay: {
            type: String,
        },
        indexWorkHistory: {
            type: Number,
        },
    },
    data() {
        return {
            isOpenDropdown: false,
        };
    },
    beforeUnmount() {
        document.removeEventListener("click", this.closeDropdownOnClickOutside);
    },
    methods: {
        toggleDropdown() {
            this.isOpenDropdown = !this.isOpenDropdown;
            if (this.isOpenDropdown) {
                document.addEventListener(
                    "click",
                    this.closeDropdownOnClickOutside
                );
            } else {
                document.removeEventListener(
                    "click",
                    this.closeDropdownOnClickOutside
                );
            }
        },
        closeDropdownOnClickOutside(event) {
            const selectWrapper = this.$refs.selectWrapper;
            if (!selectWrapper.contains(event.target)) {
                this.isOpenDropdown = false;
                document.removeEventListener(
                    "click",
                    this.closeDropdownOnClickOutside
                );
            }
        },
        handleSelect(value, index) {
            this.$emit("selectValue", value, index);
            this.isOpenDropdown = false;
            document.removeEventListener(
                "click",
                this.closeDropdownOnClickOutside
            );
        },
    },
};
</script>

<template>
    <div ref="selectWrapper" class="select__wrapper">
        <div
            :class="`select__input-wrapper 
                ${ valueSelected !== 'example' ? 'fillInput' : 'NoInput'}`
            "
            @click="toggleDropdown"
        >
            <div class="select__input-icon-wrapper">
                <img
                    v-if="icon"
                    :src="icon"
                    alt="select-icon"
                    class="select__input-icon"
                />
            </div>
            <div
                class="select__input-value"
                :class="{ valueExample: valueSelected === 'example' }"
            >
                <span v-if="valueSelected">
                    {{ valueSelected }}
                </span>
            </div>
        </div>
        <div
            :class="`select__dropdown-wrapper ${isOpenDropdown ? 'show' : ''}
                ${ upSideDownMobile ? 'upSideDownMobile' : ''}`"
        >
            <div
                v-for="(data, index) in options"
                :value="data.id"
                :key="index.id"
                class="select__dropdown-option"
            >
                <button
                    class="select__dropdown-btn"
                    type="button"
                    @click="handleSelect(data.id, indexWorkHistory)"
                >
                    {{ data[dataDisplay] }}
                </button>
            </div>
        </div>
    </div>
</template>

<style lang='scss' scoped>
@import './arrayselect';
</style>
