<template>
    <button :type="type" :disabled="loading" class="btn " :class="customClass">
        <span v-if="loading">
            <svg
                width="20"
                viewBox="-2 -2 42 42"
                xmlns="http://www.w3.org/2000/svg"
                stroke="currentColor"
                class="w-6 h-6 text-white -ml-1 mr-3"
            >
                <g fill="none" fill-rule="evenodd">
                    <g transform="translate(1 1)" stroke-width="4">
                        <circle
                            stroke-opacity=".5"
                            cx="18"
                            cy="18"
                            r="18"
                        ></circle>
                        <path d="M36 18c0-9.94-8.06-18-18-18">
                            <animateTransform
                                attributeName="transform"
                                type="rotate"
                                from="0 18 18"
                                to="360 18 18"
                                dur="1s"
                                repeatCount="indefinite"
                            ></animateTransform>
                        </path>
                    </g>
                </g>
            </svg>
        </span>
        <slot/>
    </button>
</template>

<script>
export default {
    name: "UserLoadingButton",
    props: {
        type: {
            type: String,
            default: 'submit'
        },
        customClass: {
            type: String,
            default: 'px-7 mt-6 btn-primary'
        },
        loading: Boolean
    }
}
</script>

<style scoped>

</style>
