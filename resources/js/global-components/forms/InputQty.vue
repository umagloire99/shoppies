<template>
    <div class="input-group position-relative w-100">
        <a href="javascript:;" @click="value--" class="position-absolute pos-fixed-left-center pl-4 z-index-2"><i
            class="far fa-minus"></i></a>
        <input v-bind="$attrs" :id="id"  :value="value" ref="input"   name="number" type="number"
               class="form-control w-100 px-6 text-center input-quality text-secondary h-60 fs-18 font-weight-bold border-0"
               required @input="$emit('input', $event.target.value)"/>
        <a href="javascript:;" @click="value++"
           class="position-absolute pos-fixed-right-center pr-4 z-index-2"><i
            class="far fa-plus"></i>
        </a>
    </div>
</template>

<script>
export default {
    name: "InputQty",
    props: {
        id: {
            type: String,
            default: 'number'
        },
        value: {
            type: Number,
            default: 1
        },
    },
    method: {
        focus() {
            this.$refs.input.focus()
        },
    }
}
</script>

<style scoped>

</style>
