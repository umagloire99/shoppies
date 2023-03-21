<template>
    <label v-if="label">{{ label }} </label>
    <v-select ref="select" :placeholder="$t('select-your-city')" v-select v-model="selected" v-bind="$attrs"
              :label="label_option" :options="options">
        <template #search="{attributes, events}">
            <input
                class="vs__search"
                :required="!selected"
                v-bind="attributes"
                v-on="events"
            />
        </template>
    </v-select>
    <div class="hint-info" v-if="helper">
        {{helper}}
    </div>
    <div class="invalid-feedback" v-if="error">
        {{ error }}
    </div>
</template>

<script>

export default {
    inheritAttrs: false,
    directives: {
        select: {
            inserted(el, binding, vnode) {
                vnode.context.setValue(el, binding, vnode);
                vnode.context.init(el, binding, vnode);
            },
            update(el, binding, vnode) {
                vnode.context.setValue(el, binding, vnode);
                vnode.context.reInit(el, binding, vnode);
            }
        }
    },
    props: {
        label: String,
        error: String,
        label_option: String,
        options: Array,
        hint: null,
        value: {
            type: [Number, String, Array],
        }
    },
    data() {
        return {
            helper: this.hint,
            selected: this.value
        }
    },
    watch: {
        selected(selected) {
            this.$emit('select', selected)
        },
        hint(value) {
            this.helper = value
        },
    },
}
</script>
