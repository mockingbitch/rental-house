<template>
    <div ref="selectWrapper" class="select__wrapper">
        <div
            :class="`select__input-wrapper ${
                valueSelected !== 'example' ? 'fillInput' : 'NoInput'
            }`"
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
            :class="`select__dropdown-wrapper ${isOpenDropdown ? 'show' : ''} ${
                upSideDownMobile ? 'upSideDownMobile' : ''
            }`"
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
<style lang="scss" scoped>
.select__wrapper {
    position: relative;
    width: 100%;
}
.select__input-wrapper {
    display: flex;
    align-items: center;
    border-radius: 5px;
    border: 1px solid #e3e3e3;
    background-image: url(../../../../../public/img/CaretDown.svg);
    background-repeat: no-repeat;
    background-position: calc(100% - 0.75rem) center !important;
    min-height: 44px;
    padding-left: 10px;
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

.valueExample {
    color: #b1b1b1;
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

        & + & {
            border-top: 1px solid #e3e3e3 !important;
        }
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
    border-color: rgb(227, 227, 227);
    color: #1b1b1b;
}
.NoInput {
    border-color: #e3e3e3;
}
</style>
