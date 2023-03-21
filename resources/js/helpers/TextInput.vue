<template>
    <label v-if="label">{{ label }}<h6 class="text-danger">*required</h6></label>
    <input :type="type" class="form-control" :class="error ? 'is-invalid' : ''"
           :value="modelValue"
           :required="required"  :id="id" ref="input"  :placeholder="placeholder"  @input="$emit('update:modelValue', $event.target.value)" />
    <div class="hint-info" v-if="hint">
        {{ hint }}
    </div>
    <div class="invalid-feedback" v-if="error">
        {{ error }}
    </div>
</template>

<script>
import { v4 as uuid } from 'uuid'

export default {
    inheritAttrs: false,
    name: "TextInput",
    props: {
        id: {
            type: String,
            default() {
                return `text-input-${uuid()}`
            },
        },
        type: {
            type: String,
            default: 'text'
        },
        value: String,
        required: null,
        hint: null,
        label: String,
        placeholder: String,
        error: String,
        modelValue: String,
    },
    emits: ['update:modelValue'],
    methods: {
        focus() {
            this.$refs.input.focus()
        },
        select() {
            this.$refs.input.select()
        },

    },
}
</script>

<style scoped>

</style>
