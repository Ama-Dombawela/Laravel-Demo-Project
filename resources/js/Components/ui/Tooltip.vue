<script setup>
import { ref, onMounted, onUnmounted } from 'vue';


defineProps({
    text: {
        type: String,
        required: true,
    },
    position: {
        type: String,
        default: 'top', // 'top', 'bottom', 'left', 'right'
    }
});

const isVisible = ref(false);

const show = () => isVisible.value = true;
const hide = () => isVisible.value = false;
</script>

<template>
    <div class="relative inline-block" @mouseenter="show" @mouseleave="hide" @focus="show" @blur="hide">
        <slot />
        
        <transition
            enter-active-class="transition ease-out duration-200"
            enter-from-class="opacity-0 translate-y-1 scale-95"
            enter-to-class="opacity-100 translate-y-0 scale-100"
            leave-active-class="transition ease-in duration-150"
            leave-from-class="opacity-100 translate-y-0 scale-100"
            leave-to-class="opacity-0 translate-y-1 scale-95"
        >
            <div 
                v-if="isVisible"
                class="absolute z-50 px-2 py-1 text-xs font-medium text-white bg-slate-900 rounded-lg shadow-lg whitespace-nowrap pointer-events-none"
                :class="[
                    position === 'top' ? 'bottom-full left-1/2 -translate-x-1/2 mb-2' : '',
                    position === 'bottom' ? 'top-full left-1/2 -translate-x-1/2 mt-2' : '',
                    position === 'left' ? 'right-full top-1/2 -translate-y-1/2 mr-2' : '',
                    position === 'right' ? 'left-full top-1/2 -translate-y-1/2 ml-2' : ''
                ]"
            >
                {{ text }}
                <div 
                    class="absolute w-2 h-2 bg-slate-900 rotate-45"
                    :class="[
                        position === 'top' ? 'bottom-[-4px] left-1/2 -translate-x-1/2' : '',
                        position === 'bottom' ? 'top-[-4px] left-1/2 -translate-x-1/2' : '',
                        position === 'left' ? 'right-[-4px] top-1/2 -translate-y-1/2' : '',
                        position === 'right' ? 'left-[-4px] top-1/2 -translate-y-1/2' : ''
                    ]"
                ></div>
            </div>
        </transition>
    </div>
</template>
