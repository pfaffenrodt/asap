<template>
    <div class="relative inline-block w-full text-gray-700">
        <select class="w-full h-10 pl-3 pr-6 text-base placeholder-gray-600 border border-gray-300 rounded-lg appearance-none focus:shadow-outline" :value="modelValue" @input="$emit('update:modelValue', $event.target.value)">
            <option v-for="(option, index)  in options" :value="option.value+''">{{ option.label }} </option>
        </select>
    </div>
</template>

<script>
export default {
    props: ['modelValue','options'],

    emits: ['update:modelValue'],

    methods: {
        focus() {
            this.$refs.select.focus()
        }
    }
}
</script>
