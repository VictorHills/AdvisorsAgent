<template>
    <div class="space-y-2 group">
        <label :for="`date-picker-${id}`" class="text-sm font-medium transition-colors group-focus-within:text-primary">
            {{ label }}
            <span v-if="required" class="text-red-500">*</span>
        </label>
        <div class="relative">
            <input
                :id="`date-picker-${id}`"
                :value="modelValue"
                type="date"
                :required="required"
                :disabled="disabled"
                :min="minDate"
                :max="maxDate"
                class="w-full px-4 py-3 bg-input border border-border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-200 disabled:opacity-50 disabled:cursor-not-allowed"
                @input="$emit('update:modelValue', $event.target.value)"
            />
        </div>
    </div>
</template>

<script setup>
defineProps({
    modelValue: {
        type: String,
        default: ''
    },
    label: {
        type: String,
        required: true
    },
    required: {
        type: Boolean,
        default: false
    },
    disabled: {
        type: Boolean,
        default: false
    },
    id: {
        type: String,
        required: true
    },
    minDate: {
        type: String,
        default: ''
    },
    maxDate: {
        type: String,
        default: ''
    }
})

defineEmits(['update:modelValue'])
</script>
