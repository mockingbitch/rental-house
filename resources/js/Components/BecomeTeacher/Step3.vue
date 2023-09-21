<template>
    <LayoutOnBoarding
        :step="3"
        :title="'学歴・経歴登録'"
        @handle-click="handleCancel"
    >
        <BreadcrumbVue
            :items="breadcrumbItems"
            @handleClick="handleBreadcrumbClick"
        />
        <div class="step-container">
            <div
                class="step-container-header d-flex align-items-center justify-content-center"
            >
                <img @click="handleCancel" src="/img/icon/close.svg" alt="" />
                <span class="step-container-header-content"
                    >学歴・経歴登録</span
                >
            </div>
            <div class="step-container-title">
                <div style="height: 26px">Final Education Background</div>
            </div>

            <!-- School -->
            <div class="form__wrap-item">
                <label for="Title"
                    >学校
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        width="16"
                        height="16"
                        viewBox="0 0 16 16"
                        fill="none"
                    >
                        <path
                            d="M8 1.5C6.71442 1.5 5.45772 1.88122 4.3888 2.59545C3.31988 3.30968 2.48676 4.32484 1.99479 5.51256C1.50282 6.70028 1.37409 8.00721 1.6249 9.26809C1.8757 10.529 2.49477 11.6872 3.40381 12.5962C4.31285 13.5052 5.47104 14.1243 6.73192 14.3751C7.99279 14.6259 9.29973 14.4972 10.4874 14.0052C11.6752 13.5132 12.6903 12.6801 13.4046 11.6112C14.1188 10.5423 14.5 9.28558 14.5 8C14.4982 6.27665 13.8128 4.62441 12.5942 3.40582C11.3756 2.18722 9.72335 1.50182 8 1.5ZM8 12C7.85167 12 7.70666 11.956 7.58333 11.8736C7.45999 11.7912 7.36386 11.6741 7.30709 11.537C7.25033 11.4 7.23548 11.2492 7.26441 11.1037C7.29335 10.9582 7.36478 10.8246 7.46967 10.7197C7.57456 10.6148 7.7082 10.5434 7.85368 10.5144C7.99917 10.4855 8.14997 10.5003 8.28701 10.5571C8.42406 10.6139 8.54119 10.71 8.6236 10.8333C8.70602 10.9567 8.75 11.1017 8.75 11.25C8.75 11.4489 8.67098 11.6397 8.53033 11.7803C8.38968 11.921 8.19892 12 8 12ZM8.5 8.955V9C8.5 9.13261 8.44732 9.25979 8.35356 9.35355C8.25979 9.44732 8.13261 9.5 8 9.5C7.86739 9.5 7.74022 9.44732 7.64645 9.35355C7.55268 9.25979 7.5 9.13261 7.5 9V8.5C7.5 8.36739 7.55268 8.24021 7.64645 8.14645C7.74022 8.05268 7.86739 8 8 8C8.82688 8 9.5 7.4375 9.5 6.75C9.5 6.0625 8.82688 5.5 8 5.5C7.17313 5.5 6.5 6.0625 6.5 6.75V7C6.5 7.13261 6.44732 7.25979 6.35356 7.35355C6.25979 7.44732 6.13261 7.5 6 7.5C5.86739 7.5 5.74022 7.44732 5.64645 7.35355C5.55268 7.25979 5.5 7.13261 5.5 7V6.75C5.5 5.50938 6.62125 4.5 8 4.5C9.37875 4.5 10.5 5.50938 10.5 6.75C10.5 7.83625 9.64 8.74563 8.5 8.955Z"
                            fill="#B1B1B1"
                        />
                    </svg>
                </label>
                <input placeholder="example" v-model="form.school" />
            </div>

            <!-- Major -->
            <div class="form__wrap-item">
                <label for="Title">学位および学部 </label>
                <input placeholder="example" v-model="form.major" />
            </div>

            <!-- Maijor specialize -->
            <div class="form__wrap-item">
                <label for="Title">専攻または学科 </label>
                <input placeholder="example" v-model="form.major_specialize" />
            </div>

            <!-- Addminssioj time -->
            <div class="form__wrap-item from-select-input">
                <label for="Title">開始日 </label>
                <div class="from-select-input-select d-flex">
                    <CustomSelect
                        :value-selected="form.admission_month"
                        :options="filteredStartMonths"
                        :place-holder="'月'"
                        up-side-down-mobile
                        :isOnBoarding="true"
                        @selectValue="updateAdmissionMonth"
                    />
                    <CustomSelect
                        :value-selected="form.admission_year"
                        :options="filteredStartYears"
                        :place-holder="'年'"
                        up-side-down-mobile
                        :isOnBoarding="true"
                        @selectValue="updateAdmissionYear"
                    />
                </div>
            </div>

            <!-- Graduation time -->
            <div class="form__wrap-item from-select-input">
                <label for="Title">終了日（卒業予定） </label>
                <div class="from-select-input-select d-flex">
                    <CustomSelect
                        :value-selected="form.graduation_month"
                        :options="filteredEndMonths"
                        :place-holder="'月'"
                        up-side-down-mobile
                        :isOnBoarding="true"
                        @selectValue="updateGraduationMonth"
                    />
                    <CustomSelect
                        :value-selected="form.graduation_year"
                        :options="filteredEndYears"
                        :place-holder="'年'"
                        up-side-down-mobile
                        :isOnBoarding="true"
                        @selectValue="updateGraduationYear"
                    />
                </div>
                <UlError :message="graduation_error" />
            </div>

            <!-- Certificate -->
            <div class="form__wrap-item">
                <label for="Title"
                    >Academic Certificate
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        width="16"
                        height="16"
                        viewBox="0 0 16 16"
                        fill="none"
                    >
                        <path
                            d="M8 1.5C6.71442 1.5 5.45772 1.88122 4.3888 2.59545C3.31988 3.30968 2.48676 4.32484 1.99479 5.51256C1.50282 6.70028 1.37409 8.00721 1.6249 9.26809C1.8757 10.529 2.49477 11.6872 3.40381 12.5962C4.31285 13.5052 5.47104 14.1243 6.73192 14.3751C7.99279 14.6259 9.29973 14.4972 10.4874 14.0052C11.6752 13.5132 12.6903 12.6801 13.4046 11.6112C14.1188 10.5423 14.5 9.28558 14.5 8C14.4982 6.27665 13.8128 4.62441 12.5942 3.40582C11.3756 2.18722 9.72335 1.50182 8 1.5ZM8 12C7.85167 12 7.70666 11.956 7.58333 11.8736C7.45999 11.7912 7.36386 11.6741 7.30709 11.537C7.25033 11.4 7.23548 11.2492 7.26441 11.1037C7.29335 10.9582 7.36478 10.8246 7.46967 10.7197C7.57456 10.6148 7.7082 10.5434 7.85368 10.5144C7.99917 10.4855 8.14997 10.5003 8.28701 10.5571C8.42406 10.6139 8.54119 10.71 8.6236 10.8333C8.70602 10.9567 8.75 11.1017 8.75 11.25C8.75 11.4489 8.67098 11.6397 8.53033 11.7803C8.38968 11.921 8.19892 12 8 12ZM8.5 8.955V9C8.5 9.13261 8.44732 9.25979 8.35356 9.35355C8.25979 9.44732 8.13261 9.5 8 9.5C7.86739 9.5 7.74022 9.44732 7.64645 9.35355C7.55268 9.25979 7.5 9.13261 7.5 9V8.5C7.5 8.36739 7.55268 8.24021 7.64645 8.14645C7.74022 8.05268 7.86739 8 8 8C8.82688 8 9.5 7.4375 9.5 6.75C9.5 6.0625 8.82688 5.5 8 5.5C7.17313 5.5 6.5 6.0625 6.5 6.75V7C6.5 7.13261 6.44732 7.25979 6.35356 7.35355C6.25979 7.44732 6.13261 7.5 6 7.5C5.86739 7.5 5.74022 7.44732 5.64645 7.35355C5.55268 7.25979 5.5 7.13261 5.5 7V6.75C5.5 5.50938 6.62125 4.5 8 4.5C9.37875 4.5 10.5 5.50938 10.5 6.75C10.5 7.83625 9.64 8.74563 8.5 8.955Z"
                            fill="#B1B1B1"
                        /></svg
                    ><span class="required-input">*</span></label
                >
                <div>
                    <ImagePreview
                        :formLesson="formLesson"
                        :message="formLesson.errors.cover_image"
                    />
                    <UlError :message="required_image_error" />
                </div>
                <ul class="video-note">
                    <li>※ 画像のサイズ制限</li>
                    <li>※ 画像の容量制限</li>
                </ul>
            </div>

            <div
                class="step-container-title"
                style="margin-top: 48px, padding-bottom: 16px"
            >
                <div style="height: 26px">Work History</div>
            </div>

            <div v-for="(history, index) in form.work_histories" :key="index">
                <!-- Work position -->
                <div class="form__wrap-item">
                    <label for="Title"
                        >役職/ポジション/担当業務
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            width="16"
                            height="16"
                            viewBox="0 0 16 16"
                            fill="none"
                        >
                            <path
                                d="M8 1.5C6.71442 1.5 5.45772 1.88122 4.3888 2.59545C3.31988 3.30968 2.48676 4.32484 1.99479 5.51256C1.50282 6.70028 1.37409 8.00721 1.6249 9.26809C1.8757 10.529 2.49477 11.6872 3.40381 12.5962C4.31285 13.5052 5.47104 14.1243 6.73192 14.3751C7.99279 14.6259 9.29973 14.4972 10.4874 14.0052C11.6752 13.5132 12.6903 12.6801 13.4046 11.6112C14.1188 10.5423 14.5 9.28558 14.5 8C14.4982 6.27665 13.8128 4.62441 12.5942 3.40582C11.3756 2.18722 9.72335 1.50182 8 1.5ZM8 12C7.85167 12 7.70666 11.956 7.58333 11.8736C7.45999 11.7912 7.36386 11.6741 7.30709 11.537C7.25033 11.4 7.23548 11.2492 7.26441 11.1037C7.29335 10.9582 7.36478 10.8246 7.46967 10.7197C7.57456 10.6148 7.7082 10.5434 7.85368 10.5144C7.99917 10.4855 8.14997 10.5003 8.28701 10.5571C8.42406 10.6139 8.54119 10.71 8.6236 10.8333C8.70602 10.9567 8.75 11.1017 8.75 11.25C8.75 11.4489 8.67098 11.6397 8.53033 11.7803C8.38968 11.921 8.19892 12 8 12ZM8.5 8.955V9C8.5 9.13261 8.44732 9.25979 8.35356 9.35355C8.25979 9.44732 8.13261 9.5 8 9.5C7.86739 9.5 7.74022 9.44732 7.64645 9.35355C7.55268 9.25979 7.5 9.13261 7.5 9V8.5C7.5 8.36739 7.55268 8.24021 7.64645 8.14645C7.74022 8.05268 7.86739 8 8 8C8.82688 8 9.5 7.4375 9.5 6.75C9.5 6.0625 8.82688 5.5 8 5.5C7.17313 5.5 6.5 6.0625 6.5 6.75V7C6.5 7.13261 6.44732 7.25979 6.35356 7.35355C6.25979 7.44732 6.13261 7.5 6 7.5C5.86739 7.5 5.74022 7.44732 5.64645 7.35355C5.55268 7.25979 5.5 7.13261 5.5 7V6.75C5.5 5.50938 6.62125 4.5 8 4.5C9.37875 4.5 10.5 5.50938 10.5 6.75C10.5 7.83625 9.64 8.74563 8.5 8.955Z"
                                fill="#B1B1B1"
                            />
                        </svg>
                        <span class="required-input">*</span>
                    </label>
                    <input
                        placeholder="example"
                        v-model="history.work_position"
                    />
                    <UlError
                        :message="
                            form.errors[
                                'work_histories.' + index + '.work_position'
                            ]
                        "
                    />
                </div>
                <!-- Recruitment -->
                <div class="form__wrap-item">
                    <label for="Title"
                        >雇用形態 <span class="required-input">*</span></label
                    >
                    <ArraySelect
                        :value-selected="
                            recruitmentForm[
                                form.work_histories[index].recruitment_form - 1
                            ]?.name_jp || 'example'
                        "
                        :options="recruitmentForm"
                        :data-display="'name_jp'"
                        :indexWorkHistory="index"
                        up-side-down-mobile
                        @selectValue="updateRecruitmentForm"
                    />
                    <UlError
                        :message="
                            form.errors[
                                'work_histories.' + index + '.recruitment_form'
                            ]
                        "
                    />
                    <ul class="note">
                        <li>
                            ※ 雇用形態の詳細は、<a
                                href="#"
                                style="
                                    text-decoration: underline;
                                    color: #418997;
                                "
                                >こちら</a
                            >
                            をご覧ください。
                        </li>
                    </ul>
                </div>
                <div class="form__wrap-item">
                    <label for="Title"
                        >会社名
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            width="16"
                            height="16"
                            viewBox="0 0 16 16"
                            fill="none"
                        >
                            <path
                                d="M8 1.5C6.71442 1.5 5.45772 1.88122 4.3888 2.59545C3.31988 3.30968 2.48676 4.32484 1.99479 5.51256C1.50282 6.70028 1.37409 8.00721 1.6249 9.26809C1.8757 10.529 2.49477 11.6872 3.40381 12.5962C4.31285 13.5052 5.47104 14.1243 6.73192 14.3751C7.99279 14.6259 9.29973 14.4972 10.4874 14.0052C11.6752 13.5132 12.6903 12.6801 13.4046 11.6112C14.1188 10.5423 14.5 9.28558 14.5 8C14.4982 6.27665 13.8128 4.62441 12.5942 3.40582C11.3756 2.18722 9.72335 1.50182 8 1.5ZM8 12C7.85167 12 7.70666 11.956 7.58333 11.8736C7.45999 11.7912 7.36386 11.6741 7.30709 11.537C7.25033 11.4 7.23548 11.2492 7.26441 11.1037C7.29335 10.9582 7.36478 10.8246 7.46967 10.7197C7.57456 10.6148 7.7082 10.5434 7.85368 10.5144C7.99917 10.4855 8.14997 10.5003 8.28701 10.5571C8.42406 10.6139 8.54119 10.71 8.6236 10.8333C8.70602 10.9567 8.75 11.1017 8.75 11.25C8.75 11.4489 8.67098 11.6397 8.53033 11.7803C8.38968 11.921 8.19892 12 8 12ZM8.5 8.955V9C8.5 9.13261 8.44732 9.25979 8.35356 9.35355C8.25979 9.44732 8.13261 9.5 8 9.5C7.86739 9.5 7.74022 9.44732 7.64645 9.35355C7.55268 9.25979 7.5 9.13261 7.5 9V8.5C7.5 8.36739 7.55268 8.24021 7.64645 8.14645C7.74022 8.05268 7.86739 8 8 8C8.82688 8 9.5 7.4375 9.5 6.75C9.5 6.0625 8.82688 5.5 8 5.5C7.17313 5.5 6.5 6.0625 6.5 6.75V7C6.5 7.13261 6.44732 7.25979 6.35356 7.35355C6.25979 7.44732 6.13261 7.5 6 7.5C5.86739 7.5 5.74022 7.44732 5.64645 7.35355C5.55268 7.25979 5.5 7.13261 5.5 7V6.75C5.5 5.50938 6.62125 4.5 8 4.5C9.37875 4.5 10.5 5.50938 10.5 6.75C10.5 7.83625 9.64 8.74563 8.5 8.955Z"
                                fill="#B1B1B1"
                            />
                        </svg>
                        <span class="required-input">*</span>
                    </label>
                    <input placeholder="example" v-model="history.company" />
                    <UlError
                        :message="
                            form.errors['work_histories.' + index + '.company']
                        "
                    />
                </div>
                <div class="form__wrap-item from-select-input">
                    <label for="Title"
                        >開始日 <span class="required-input">*</span></label
                    >
                    <div class="from-select-input-select d-flex">
                        <div style="flex: 1">
                            <CustomSelect
                                :value-selected="history.work_start_month"
                                :options="
                                    filterStartMonths(
                                        maxMonth,
                                        history.work_end_month,
                                        (month) => parseInt(month) - 1,
                                        history.work_start_year,
                                        history.work_end_year
                                    )
                                "
                                :place-holder="'月'"
                                up-side-down-mobile
                                :isOnBoarding="true"
                                :indexWorkHistory="index"
                                @selectValue="updateWorkHistoryStartMonth"
                            />
                            <UlError
                                :message="
                                    form.errors[
                                        'work_histories.' +
                                            index +
                                            '.work_start_month'
                                    ]
                                "
                            />
                        </div>
                        <div style="flex: 1">
                            <CustomSelect
                                :value-selected="history.work_start_year"
                                :options="
                                    filterYearOptions(
                                        arrayYears,
                                        history.work_end_year,
                                        (year, comparisonYear) =>
                                            year <= comparisonYear
                                    )
                                "
                                :place-holder="'年'"
                                up-side-down-mobile
                                :isOnBoarding="true"
                                :indexWorkHistory="index"
                                @selectValue="updateWorkHistoryStartYear"
                            />
                            <UlError
                                :message="
                                    form.errors[
                                        'work_histories.' +
                                            index +
                                            '.work_start_year'
                                    ]
                                "
                            />
                        </div>
                    </div>
                </div>
                <div class="form__wrap-item flex-row">
                    <ul class="list-days">
                        <li
                            class="item d-flex"
                            :class="{ checked: history.is_still_working }"
                            @click="toggleChangeCheckbox(history)"
                        >
                            <span class="checkbox">
                                <i class="fa-solid fa-check check-icon"></i>
                            </span>
                            <span
                                class="item-text"
                                :class="{ checked: history.is_still_working }"
                                >{{
                                    "現在、このポジションで働いています。"
                                }}</span
                            >
                        </li>
                    </ul>
                </div>
                <div
                    class="form__wrap-item from-select-input"
                    :class="{ isDisable: history.is_still_working }"
                >
                    <label
                        for="Title"
                        :style="{
                            color: history.is_still_working ? '#b1b1b1' : '',
                        }"
                        >終了日
                        <span
                            class="required-input"
                            :style="{
                                display: history.is_still_working ? 'none' : '',
                            }"
                            >*</span
                        >
                    </label>
                    <div class="from-select-input-select d-flex">
                        <CustomSelect
                            :value-selected="history.work_end_month"
                            :options="
                                filterEndMonths(
                                    maxMonth,
                                    history.work_start_month,
                                    (month) => parseInt(month) - 1,
                                    history.work_start_year,
                                    history.work_end_year,
                                    history.work_end_month
                                )
                            "
                            :place-holder="'月'"
                            up-side-down-mobile
                            :isOnBoarding="true"
                            :indexWorkHistory="index"
                            @selectValue="updateWorkHistoryEndMonth"
                        />
                        <CustomSelect
                            :value-selected="history.work_end_year"
                            :options="
                                filterYearOptions(
                                    arrayYears,
                                    history.work_start_year,
                                    (year, comparisonYear) =>
                                        year >= comparisonYear
                                )
                            "
                            :place-holder="'月'"
                            up-side-down-mobile
                            :isOnBoarding="true"
                            :indexWorkHistory="index"
                            @selectValue="updateWorkHistoryEndYear"
                        />
                    </div>
                    <UlError :message="work_date_error[index]" />
                </div>
            </div>
            <div class="form__wrap-item from-select-input" @click="addHistory">
                <div
                    class="d-flex justify-content-center align-item-center another-company-button"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        width="24"
                        height="24"
                        viewBox="0 0 24 24"
                        fill="none"
                    >
                        <path
                            d="M21 12C21 12.1989 20.921 12.3897 20.7803 12.5303C20.6397 12.671 20.4489 12.75 20.25 12.75H12.75V20.25C12.75 20.4489 12.671 20.6397 12.5303 20.7803C12.3897 20.921 12.1989 21 12 21C11.8011 21 11.6103 20.921 11.4697 20.7803C11.329 20.6397 11.25 20.4489 11.25 20.25V12.75H3.75C3.55109 12.75 3.36032 12.671 3.21967 12.5303C3.07902 12.3897 3 12.1989 3 12C3 11.8011 3.07902 11.6103 3.21967 11.4697C3.36032 11.329 3.55109 11.25 3.75 11.25H11.25V3.75C11.25 3.55109 11.329 3.36032 11.4697 3.21967C11.6103 3.07902 11.8011 3 12 3C12.1989 3 12.3897 3.07902 12.5303 3.21967C12.671 3.36032 12.75 3.55109 12.75 3.75V11.25H20.25C20.4489 11.25 20.6397 11.329 20.7803 11.4697C20.921 11.6103 21 11.8011 21 12Z"
                            fill="#1B1B1B"
                        />
                    </svg>
                    Another Company
                </div>
            </div>
            <div class="button-container">
                <div class="create__request-button">
                    <div class="lineFull"></div>
                    <ButtonRequest
                        :label="'キャンセル'"
                        :submit-button="false"
                        class="create__request-button-left"
                        @click="handleCancel"
                    />
                    <ButtonRequest
                        :label="'申請する'"
                        :submit-button="true"
                        class="create__request-button-right"
                        @click="handleSubmitForm"
                        :class="{
                            btn_disabled: !isActiveSubmit,
                        }"
                    />
                </div>
            </div>
        </div>
    </LayoutOnBoarding>
</template>

<script setup>
import { defineEmits, defineProps, ref, watch, computed } from "vue";
import LayoutOnBoarding from "../../Layouts/LayoutOnBoarding.vue";
import ImagePreview from "@/Components/ImagePreview/ImagePreview.vue";
import ButtonRequest from "@/Components/Request/ButtonRequest.vue";
import { useForm } from "@inertiajs/vue3";
import UlError from "@/Components/UlError.vue";
import ArraySelect from "@/Components/BecomeTeacher/Common/ArraySelect.vue";
import CustomSelect from "../Request/Common/CustomSelect.vue";
import BreadcrumbVue from "../Breadcrumb.vue";

const breadcrumbItems = [
    { text: "Dashboard", isLink: true },
    { text: "学歴・経歴登録", isLink: false },
];

const formLesson = useForm({
    imagePreview:
        props.dataImage?.imagePreview ||
        props.dataTeacher?.academic_certificate ||
        "",
    imageName: props.dataImage?.imageName || "",
    short_video_for_learner_thumbnail: "",
    cover_image: props.dataImage?.cover_image || "",
});
let isActiveSubmit = ref(false);
const recruitmentForm = [
    {
        id: 1,
        name_jp: "正社員",
    },
    {
        id: 2,
        name_jp: "契約社員",
    },
    {
        id: 3,
        name_jp: "パート・アルバイト",
    },
    {
        id: 4,
        name_jp: "派遣社員",
    },
    {
        id: 5,
        name_jp: "業務委託",
    },
];
let graduation_error = ref("");
let work_date_error = ref([""]);
let required_image_error = ref("");
let arrayYears = ref([]);
let maxMonth = ref([
    "01",
    "02",
    "03",
    "04",
    "05",
    "06",
    "07",
    "08",
    "09",
    "10",
    "11",
    "12",
]);
let newestYear = new Date().getFullYear();
for (let i = newestYear; i >= 1950; i--) {
    arrayYears.value.push(i);
}
const props = defineProps({
    dataStep3: Array,
    dataTeacher: Object,
    dataImage: Object,
});
const form = useForm({
    school: props.dataTeacher?.school || props.dataStep3?.school || "",
    major: props.dataTeacher?.major || props.dataStep3?.major || "",
    major_specialize:
        props.dataTeacher?.major_specialize ||
        props.dataStep3?.major_specialize ||
        "",
    admission_year:
        props.dataStep3?.admission_year ||
        props.dataTeacher?.admission_year ||
        "",
    admission_month:
        props.dataStep3?.admission_month ||
        props.dataTeacher?.admission_month ||
        "",
    graduation_year:
        props.dataStep3?.graduation_year ||
        props.dataTeacher?.graduation_year ||
        "",
    graduation_month:
        props.dataStep3?.graduation_month ||
        props.dataTeacher?.graduation_month ||
        "",
    academic_certificate: props.dataTeacher?.academic_certificate || "",
    work_histories: props.dataTeacher?.work_histories ||
        props.dataStep3?.work_histories || [
            {
                work_position: "",
                recruitment_form: "",
                company: "",
                work_start_year: "",
                work_start_month: "",
                work_end_year: "",
                work_end_month: "",
                is_still_working: true,
            },
        ],
});

const filterYearOptions = (sourceArray, yearComparison, filterFunction) => {
    if (yearComparison) {
        return sourceArray.filter((year) =>
            filterFunction(year, yearComparison)
        );
    } else {
        return sourceArray;
    }
};

const updateRecruitmentForm = (data, index) => {
    form.work_histories[index].recruitment_form = data;
};

const updateWorkHistoryStartMonth = (data, index) => {
    form.work_histories[index].work_start_month = data;
};

const updateWorkHistoryStartYear = (data, index) => {
    form.work_histories[index].work_start_year = data;
};

const updateWorkHistoryEndMonth = (data, index) => {
    form.work_histories[index].work_end_month = data;
};

const updateWorkHistoryEndYear = (data, index) => {
    form.work_histories[index].work_end_year = data;
};

const filterStartMonths = (
    sourceArray,
    endMonth,
    filterFunction,
    startYear,
    endYear,
    startMonth
) => {
    if (endMonth && startYear === endYear) {
        return sourceArray.slice(0, filterFunction(endMonth) + 1);
    } else {
        return sourceArray;
    }
};

const filterEndMonths = (
    sourceArray,
    startMonth,
    filterFunction,
    startYear,
    endYear,
    endMonth
) => {
    if (startMonth && endMonth && startYear === endYear) {
        if (startMonth <= endMonth) {
            const startIndex = filterFunction(startMonth);
            return sourceArray.slice(startIndex, 12);
        } else if (startMonth > endMonth) {
            const endIndex = filterFunction(endMonth);
            return sourceArray.slice(endIndex);
        }
    } else {
        return sourceArray;
    }
};

const filteredStartMonths = computed(() => {
    return filterStartMonths(
        maxMonth.value,
        form.graduation_month,
        (month) => parseInt(month) - 1,
        form.admission_year,
        form.graduation_year
    );
});

const filteredEndMonths = computed(() => {
    return filterEndMonths(
        maxMonth.value,
        form.admission_month,
        (month) => parseInt(month) - 1,
        form.admission_year,
        form.graduation_year,
        form.graduation_month
    );
});

const filteredStartYears = computed(() => {
    return filterYearOptions(
        arrayYears.value,
        form.graduation_year,
        (year, comparisonYear) => year <= comparisonYear
    );
});

const filteredEndYears = computed(() => {
    return filterYearOptions(
        arrayYears.value,
        form.admission_year,
        (year, comparisonYear) => year >= comparisonYear
    );
});

const emits = defineEmits();
const toggleChangeCheckbox = (history) => {
    history.is_still_working = !history.is_still_working;
    if (history.is_still_working === true) {
        history.work_end_month = "";
        history.work_end_year = "";
    }
};

const handleSubmitForm = () => {
    if (
        graduation_error.value === "" ||
        work_date_error.value.every((i) => i == "")
    ) {
        form.post(route("onboarding.create.step3"), {
            onSuccess: () => {
                if (
                    Object.keys(form.errors).length === 0 &&
                    form.errors.constructor === Object
                ) {
                    emits("back-to-default", form);
                    emits("save-image-step3", formLesson);
                }
            },
            onError: console.log("error"),
        });
    }
};

//update dữ liệu form từ select
const updateAdmissionMonth = (data) => {
    form.admission_month = data;
};

const updateAdmissionYear = (data) => {
    form.admission_year = data;
};

const updateGraduationMonth = (data) => {
    form.graduation_month = data;
};

const updateGraduationYear = (data) => {
    form.graduation_year = data;
};

watch(
    form,
    (value) => {
        if (
            form.admission_month &&
            form.admission_year &&
            form.graduation_month &&
            form.graduation_year
        ) {
            if (
                parseInt(form.graduation_year + form.graduation_month) <=
                parseInt(form.admission_year + form.admission_month)
            ) {
                graduation_error.value =
                    "終了日は開始日より未来にしてください。";
            } else {
                graduation_error.value = "";
            }
        }
        if (form.work_histories) {
            for (let i = 0; i < form.work_histories.length; i++) {
                if (
                    form.work_histories[i].work_start_month &&
                    form.work_histories[i].work_start_year &&
                    form.work_histories[i].work_end_month &&
                    form.work_histories[i].work_end_year
                ) {
                    if (
                        parseInt(
                            form.work_histories[i].work_end_year +
                                form.work_histories[i].work_end_month
                        ) <=
                        parseInt(
                            form.work_histories[i].work_start_year +
                                form.work_histories[i].work_start_month
                        )
                    ) {
                        work_date_error.value[i] =
                            "終了日は開始日より未来にしてください。";
                    } else {
                        work_date_error.value[i] = "";
                    }
                }
            }
        }
        const workHistories = form.work_histories;
        for (let i = 0; i < workHistories.length; i++) {
            const workHistory = workHistories[i];
            if (
                workHistory.work_position === "" ||
                workHistory.recruitment_form === "" ||
                workHistory.company === "" ||
                workHistory.work_start_year === "" ||
                workHistory.work_start_month === "" ||
                graduation_error.value !== "" ||
                work_date_error.value.every((i) => i != "")
            ) {
                isActiveSubmit.value = false;
                break;
            } else if (workHistory.is_still_working === false) {
                if (
                    workHistory.work_end_year === "" ||
                    workHistory.work_end_month === ""
                ) {
                    isActiveSubmit.value = false;
                    break;
                } else {
                    isActiveSubmit.value = true;
                }
            } else {
                isActiveSubmit.value = true;
            }
        }
    },
    { immediate: true }
);

watch(
    formLesson,
    (value) => {
        form.academic_certificate = formLesson.cover_image;
    },
    { immediate: true }
);

const handleClearForm = () => {
    form.school = "";
    form.major = "";
    form.major_specialize = "";
    form.admission_year = "";
    form.admission_month = "";
    form.graduation_year = "";
    form.graduation_month = "";
    form.academic_certificate = "";
    form.work_histories = [
        {
            work_position: "",
            recruitment_form: "",
            company: "",
            work_start_year: "",
            work_start_month: "",
            work_end_year: "",
            work_end_month: "",
            is_still_working: true,
        },
    ];
};

const handleBreadcrumbClick = (item) => {
    if (item.isLink === true) {
        if (item.text === "Dashboard") {
            handleCancel();
        }
    }
};

const handleCancel = () => {
    emits("handle-cancel");
    handleClearForm();
};

const addHistory = () => {
    form.work_histories.push({
        work_position: "",
        recruitment_form: "",
        company: "",
        work_start_year: "",
        work_start_month: "",
        work_end_year: "",
        work_end_month: "",
        is_still_working: true,
    });
    work_date_error.value.push("");
};
</script>

<style lang="scss" scoped>
@import "../BecomeTeacher/Step";
.select-form {
    width: 100% !important;
}

.checked {
    color: #418997;
}

.isDisable {
    pointer-events: none;
}

.btn_disabled {
    background-color: #cacaca !important;
    cursor: pointer;
    color: #989898 !important;
    background-image: url(../../../../public/img/icon/CaretDownDisabled.svg);
    pointer-events: none;
}
</style>
