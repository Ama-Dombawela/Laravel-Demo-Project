<script setup>
import { onMounted, ref } from 'vue';

defineProps({
    modelValue: {
        type: [String, Number],
        required: true,
    },
    type: {
        type: String,
        default: 'text',
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
    placeholder: {
        type: String,
        default: '',
    },
    id: {
        type: String,
        required: true,
    }
});

defineEmits(['update:modelValue']);

const input = ref(null);

onMounted(() => {
    if (input.value && input.value.hasAttribute('autofocus')) {
        input.value.focus();
    }
});

defineExpose({ focus: () => input.value.focus() });
</script>

<template>
    <div class="w-full">
        <label v-if="label" :for="id" class="form-label">
            {{ label }}
        </label>
        
        <div class="relative">
            <slot name="icon">
                <!-- Optional icon slot -->
            </slot>
            <input
                :id="id"
                :type="type"
                :value="modelValue"
                @input="$emit('update:modelValue', $event.target.value)"
                ref="input"
                :placeholder="placeholder"
                class="form-input"
                :class="[
                    $slots.icon ? 'pl-10' : '',
                    error ? 'border-rose-300 ring-rose-500/20 focus:border-rose-500 focus:ring-rose-500/20' : ''
                ]"
                v-bind="$attrs"
            />
        </div>

        <p v-if="error" class="input-error animate-fade-in">{{ error }}</p>
        <p v-else-if="hint" class="input-hint">{{ hint }}</p>
    </div>
</template>
