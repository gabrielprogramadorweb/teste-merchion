<template>
    <div class="mb-3">
        <label class="form-label">Avatar</label>
        <div v-if="preview" class="mb-2">
            <img :src="preview" class="rounded-circle" width="100" alt="Preview" />
        </div>
        <input type="file" @change="onFileChange" class="form-control" />
    </div>
</template>

<script lang="ts" setup>
import { ref } from 'vue';

const emit = defineEmits(['update:avatar']);
const preview = ref<string | null>(null);

function onFileChange(e: Event) {
    const file = (e.target as HTMLInputElement).files?.[0];
    if (file) {
        preview.value = URL.createObjectURL(file);
        emit('update:avatar', file);
    }
}
</script>
