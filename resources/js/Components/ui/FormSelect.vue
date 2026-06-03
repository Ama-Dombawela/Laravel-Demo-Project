<script setup>
import { onMounted, ref } from 'vue';

defineProps({
    modelValue: {
        type: [String, Number],
        required: true,
    },
    options: {
        type: Array,
        required: true,
        // Array of { value: 'val', label: 'Label' }
    },
    label: {
        type: String,
        default: '',
    },
    error: {
        type: String,
        default: '',
    },
    hint: {
        type: String,
        default: '',
    },
    id: {
        type: String,
        required: true,
    }
});

defineEmits(['update:modelValue']);
</script>

<template>
    <div class="w-full">
        <label v-if="label" :for="id" class="form-label">
            {{ label }}
        </label>
        
        <div class="relative">
            <select
                :id="id"
                :value="modelValue"
                @change="$emit('update:modelValue', $event.target.value)"
                class="form-input"
                :class="error ? 'border-rose-300 ring-rose-500/20 focus:border-rose-500 focus:ring-rose-500/20' : ''"
                v-bind="$attrs"
            >
                <option v-for="option in options" :key="option.value" :value="option.value">
                    {{ option.label }}
                </option>
            </select>
        </div>

        <p v-if="error" class="input-error animate-fade-in">{{ error }}</p>
        <p v-else-if="hint" class="input-hint">{{ hint }}</p>
    </div>
</template>
