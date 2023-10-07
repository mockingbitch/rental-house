<template>
    <div
        ref="selectWrapper"
        :class="`select__wrapper ${isError ? 'error' : ''}`"
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
            :class="`select__input-wrapper ${valueSelected ? 'fillInput' : ''}
			${valueSelected && isOnBoarding ? 'fillInputOnBoarding' : 'noInput'}
			`"
            @click="toggleDropdown"
        >
            <div v-if="icon" class="select__input-icon-wrapper">
                <img :src="icon" alt="select-icon" class="select__input-icon" />
            </div>
            <div
                class="select__input-value"
                :class="{ valueExample: !valueSelected && placeHolder }"
            >
                <span> {{ valueSelected || placeHolder }}{{ placeHolder && !valueSelected ? "" : unit }} </span>
            </div>
        </div>

        <!-- Option sigle choice -->
        <div
            v-if="!multiple"
            :class="`select__dropdown-wrapper ${isOpenDropdown ? 'show' : ''} ${
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
                    {{ data }}{{ unit }}
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
    },
};
</script>
<style lang="scss" scoped>
.select__wrapper {
    position: relative;
    width: 100%;

    &.error {
        .select__input-wrapper {
            border-color: #e71a41;

            span {
                color: #e71a41;
            }
        }
    }
}
.select__input-wrapper {
    display: flex;
    align-items: center;
    border-radius: 8px;
    border: 1px solid #e3e3e3;
    background-image: url(../../../../../public/img/CaretDown.svg);
    background-repeat: no-repeat;
    background-position: calc(100% - 0.75rem) center !important;
    min-height: 44px;
    padding-left: 10px;
    background-color: #fff;
    overflow: hidden;

    &:hover {
        cursor: pointer;
    }
}
.select__input-icon-wrapper {
    display: flex;
    align-items: center;
    width: fit-content;
    height: 42px;
    padding-right: 6px;
}
.select__input-icon {
    user-select: none;
}
.select__input-value {
    font-size: 16px;
    font-weight: 400;
    line-height: 19px;
    letter-spacing: -0.01em;
    text-align: left;
    color: #1b1b1b;
}
.select__dropdown-wrapper {
    position: absolute;
    left: 0;
    right: 0;
    top: 49px;
    max-height: 186px;
    display: none;
    background-color: #fff;
    box-shadow: 0px 2px 6px 2px #00000040;

    border-radius: 14px;
    overflow-y: overlay;
    z-index: 3;
    &::-webkit-scrollbar {
        width: 6px;
    }

    /* Track */
    &::-webkit-scrollbar-track {
        border-radius: 100px;
    }

    /* Handle */
    &::-webkit-scrollbar-thumb {
        background: #7f7f7f;
        border-radius: 100px;
    }

    &.show {
        display: block;
    }

    .select__dropdown-btn {
        position: relative;
        display: block;
        padding: 7px 30px;
        width: 100%;
        border: unset;
        background-color: #fff;
        font-size: 14px;
        font-weight: 400;
        line-height: 22px;
        letter-spacing: -0.01em;
        text-align: left;
        color: #1b1b1b;
        user-select: none;
        transition: all 0.2s linear;

        &:hover {
            cursor: pointer;
            background-color: #e3e3e3;
        }

        &.selected {
            background-color: #e3e3e3;

            &::before {
                position: absolute;
                content: "\2713";
                left: 6px;
                top: 50%;
                transform: translate(50%, -50%);
            }
        }
    }
    .select__dropdown-btn + .select__dropdown-btn {
        border-top: 1px solid #e3e3e3 !important;
    }

    &.upSideDownMobile {
        @media (max-width: 575px) {
            top: unset;
            bottom: 49px;
        }
    }
}

.select__dropdown-option + .select__dropdown-option {
    border-top: 1px solid #e3e3e3;
}

.fillInput {
    border-color: #1b1b1b;
    color: #1b1b1b;
}

.fillInputOnBoarding {
    border-color: #b1b1b1;
    color: #1b1b1b;
}

.noInput {
    border-color: #e3e3e3;
}

.valueExample {
	color: #B1B1B1;
}
.list-selected {
    display: flex;
    padding: 4px;
    color: #1b1b1b;
    border-radius: 4px;
    border: 1px solid #e3e3e3;

    & + & {
        margin-left: 4px;
    }
}
</style>
