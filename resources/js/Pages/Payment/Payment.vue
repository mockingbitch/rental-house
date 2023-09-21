<script setup>
import { ref, onMounted } from "vue";
import { router, Link } from "@inertiajs/vue3";
import Layout from "../../Layouts/Layout.vue";

const props = defineProps({
    lessonId: String,               // to return lession detail page
    applicationId: String,          // to call route to payment.complete
    courseId: String,             // to return payment confirm page
    // oldApplyForm: Object,           
    clientSecret: String,           // to retrieve payment intent
    publicKey: String,              // to retrieve payment intent
    totalPrice: Number,             // to display in pay button
    symbol: String,                 // to display in pay button
});

const stripe = ref(Stripe(props.publicKey));
const elements = ref(null)
// const disableButton = ref(false);

onMounted(() => {
    //create an element object
    elements.value = stripe.value.elements({
        clientSecret: props.clientSecret, 
        appearance: {
            theme: 'flat',
            variables: { colorPrimaryText: '#262626' }
        },
    });


    //create a payment element and mount it to DOM
    const paymentElementOptions = {
        layout: {
            type: 'tabs',
            defaultCollapsed: false,
        },
    };
    const paymentElement = elements.value.create("payment", paymentElementOptions);
    paymentElement.mount("#payment-element");
})

const handleSubmit = async (e) => {
    e.preventDefault();
    // disableButton.value = true;
    setLoading(true);

    const { error } = await stripe.value.confirmPayment({
        elements: elements.value,
        redirect: "if_required"
    });

    if (error === undefined) {
        console.log('success');

        router.post(route('payment.complete'), {
            application_id: props.applicationId,
        });

    } else {
        console.log(error);

        showMessage(error.message);
        // if (error.type === "card_error" || error.type === "validation_error") {
        //     showMessage(error.message);
        // } else {
        //     showMessage("An unexpected error occurred.");
        // }

        setLoading(false);
        // disableButton.value = true;
    }
}


// ------- UI helpers -------
function showMessage(messageText) {
    const messageContainer = document.querySelector("#payment-message");

    messageContainer.classList.remove("hidden");
    messageContainer.textContent = messageText;

    setTimeout(function () {
        messageContainer.classList.add("hidden");
        messageContainer.textContent = "";
    }, 4000);
}

// Show a spinner on payment submission
function setLoading(isLoading) {
    if (isLoading) {
        // Disable the button and show a spinner
        document.querySelector("#submit").disabled = true;
        document.querySelector("#spinner").classList.remove("hidden");
        document.querySelector("#button-text").classList.add("hidden");
    } else {
        document.querySelector("#submit").disabled = false;
        document.querySelector("#spinner").classList.add("hidden");
        document.querySelector("#button-text").classList.remove("hidden");
    }
}
</script>

<template>
    <Layout>
        <div class="container">
            <div class="form" style="margin-top: 50px;">
                <div class="form__wrap">
                    <Link class="button_cancel" :href="route('lesson.detail', props.lessonId)">
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32" fill="none">
                            <path d="M25.7076 24.2921C25.8005 24.385 25.8742 24.4953 25.9245 24.6167C25.9747 24.7381 26.0006 24.8682 26.0006 24.9996C26.0006 25.131 25.9747 25.2611 25.9245 25.3825C25.8742 25.5039 25.8005 25.6142 25.7076 25.7071C25.6147 25.8 25.5044 25.8737 25.383 25.924C25.2616 25.9743 25.1315 26.0001 25.0001 26.0001C24.8687 26.0001 24.7386 25.9743 24.6172 25.924C24.4958 25.8737 24.3855 25.8 24.2926 25.7071L16.0001 17.4133L7.70757 25.7071C7.51993 25.8947 7.26543 26.0001 7.00007 26.0001C6.7347 26.0001 6.48021 25.8947 6.29257 25.7071C6.10493 25.5194 5.99951 25.2649 5.99951 24.9996C5.99951 24.7342 6.10493 24.4797 6.29257 24.2921L14.5863 15.9996L6.29257 7.70708C6.10493 7.51944 5.99951 7.26494 5.99951 6.99958C5.99951 6.73422 6.10493 6.47972 6.29257 6.29208C6.48021 6.10444 6.7347 5.99902 7.00007 5.99902C7.26543 5.99902 7.51993 6.10444 7.70757 6.29208L16.0001 14.5858L24.2926 6.29208C24.4802 6.10444 24.7347 5.99902 25.0001 5.99902C25.2654 5.99902 25.5199 6.10444 25.7076 6.29208C25.8952 6.47972 26.0006 6.73422 26.0006 6.99958C26.0006 7.26494 25.8952 7.51944 25.7076 7.70708L17.4138 15.9996L25.7076 24.2921Z" fill="#1B1B1B"/>
                        </svg>
                    </Link>

                    <form id="payment-form" >
                        <div id="payment-element">
                            <!-- Stripe will create form elements here -->
                        </div>
                        <button id="submit" @click="handleSubmit" >
                            <div class="spinner hidden" id="spinner"></div>
                            <span id="button-text">Pay {{ props.totalPrice }}{{ props.symbol }} now</span>
                        </button>
                        <div id="payment-message" class="hidden"></div>
                    </form>

                    <Link class="button_return" :href="route('course.apply', props.courseId)">戻ってくる</Link>
                    <!-- <Link 
                        class="button_return" 
                        :href="route('schedule.apply', props.scheduleId)"
                        method="POST"
                        as="button"
                        :data="props.oldApplyForm"
                    >
                    戻ってくる
                    </Link> -->
                </div>
            </div>
        </div>
    </Layout>
</template>

<style lang="scss" scoped>
    @import "./_payment.scss";
</style>