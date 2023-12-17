<template>
    <div
        ref="selectWrapper"
        :class="`select__wrapper ${isError ? 'error' : ''} ${subClass}`"
    >
        <div
            v-if="multiple"
            :class="`select__input-wrapper ${valueSelected ? 'fillInput' : ''}
			${valueSelected && isOnBoarding ? 'fillInputOnBoarding' : 'noInput'}
			`"
            @click="toggleDropdown"
        >
            <div v-if="icon" class="select__input-icon-wrapper">
                <img :src="icon" alt="select-icon" class="select__input-icon" />
            </div>
            <div
                class="select__input-value d-flex"
                :class="{ valueExample: !valueSelected }"
            >
                <div
                    v-for="selectedItem in arrayValueSelected"
                    :key="selectedItem.id"
                    class="list-selected"
                >
                    {{ selectedItem.label }}
                </div>
            </div>
        </div>
        <div
            v-else
            :class="`select__input-wrapper ${valueSelected === 0 || valueSelected ? 'fillInput' : ''}
			${valueSelected && isOnBoarding ? 'fillInputOnBoarding' : 'noInput'}
			`"
            @click="toggleDropdown"
        >
            <div v-if="icon" class="select__input-icon-wrapper">
                <img :src="icon" alt="select-icon" class="select__input-icon" />
            </div>
            <div
                class="select__input-value"
                :class="{ valueExample: !(valueSelected === 0 || valueSelected) && placeHolder }"
            >
                <span v-if="options[0]?.label"> {{ mappingValueSelected(valueSelected === 0 || valueSelected) || placeHolder }}{{ placeHolder && !(valueSelected === 0 || valueSelected) ? "" : unit }} </span>
                <span v-else> {{ (valueSelected === 0 || valueSelected) ? valueSelected : placeHolder }}{{ placeHolder && !valueSelected ? "" : unit }} </span>
            </div>
        </div>

        <!-- Option single choice -->
        <div
            v-if="!multiple"
            :class="`select__dropdown-wrapper ${isOpenDropdown && !isDisabled ? 'show' : ''} ${
                upSideDownMobile ? 'upSideDownMobile' : ''
            }`"
        >
            <div
                v-for="(data, index) in options"
                :key="index"
                class="select__dropdown-option"
            >
                <button
                    class="select__dropdown-btn"
                    type="button"
                    @click="handleSelect(data, indexWorkHistory, name)"
                >
                    {{ data.label || data }}{{ unit }}
                </button>
            </div>
        </div>

        <!-- multy choice -->
        <div
            v-else
            :class="`select__dropdown-wrapper ${isOpenDropdown ? 'show' : ''} ${
                upSideDownMobile ? 'upSideDownMobile' : ''
            }`"
        >
            <button
                v-for="(data, index) in options"
                :key="index"
                type="button"
                class="select__dropdown-btn"
                :class="{ selected: checkSelected(data) }"
                @click="handleMultiSelect(data, index, name)"
            >
                {{ data.label }}{{ unit }}
            </button>
        </div>
    </div>
</template>
<script>
export default {
    props: {
        subClass: {
            type: String,
            default: "",
        },
        icon: {
            type: String,
            default: "",
        },
        name: {
            type: String,
            default: "",
        },
        valueSelected: {
            type: [String, Number],
            default: "",
        },
        arrayValueSelected: {
            type: Array,
            default: () => [],
        },
        upSideDownMobile: {
            type: Boolean,
            default: false,
        },
        unit: {
            type: String,
            default: "",
        },
        options: {
            type: [Array, Number],
            default: () => [],
        },
        isOnBoarding: {
            type: Boolean,
        },
        placeHolder: {
            type: String,
            default: "",
        },
        indexWorkHistory: {
            type: Number,
        },
        isError: {
            type: Boolean,
            default: false,
        },
        multiple: {
            type: Boolean,
            default: false,
        },
        limitSelect: {
            type: [Number, String],
        },
        isDisabled: {
            type: Boolean,
            default: false,
        },
    },
    data() {
        return {
            isOpenDropdown: false,
            arraySelected: this.multiple ? this.arrayValueSelected : [],
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
        handleSelect(value, index, field) {
            this.$emit("selectValue", value, index, field);
            this.isOpenDropdown = false;
            document.removeEventListener(
                "click",
                this.closeDropdownOnClickOutside
            );
        },
        handleMultiSelect(value, index, field) {
            const isSelected = this.checkSelected(value);

            if (isSelected) {
                this.arraySelected = this.arraySelected.filter(
                    (obj) => obj.id !== value.id
                );
            } else if (
                !this.limitSelect ||
                this.arraySelected.length < this.limitSelect
            ) {
                this.arraySelected = [...this.arraySelected, value];
            }

            this.$emit("selectValue", this.arraySelected, index, field);
        },

        checkSelected(valueCheck) {
            return this.arrayValueSelected.some(
                (item) => item.id === valueCheck.id
            );
        },
        mappingValueSelected(id) {
            if (!id) {
                return id;
            }
            return this.options.find((data) => data.id === Number(id)).label;
        }
    },
};
</script>
<style lang="scss" scoped>
@import './customselect';
</style>
