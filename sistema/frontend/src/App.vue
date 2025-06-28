<template>
    <div>
        <NavBar class="fixed"/>
        <router-view />
    </div>
</template>

<script lang="ts">
import { defineComponent } from 'vue'
import NavBar from '@/components/NavBar/NavBar.vue'

export default defineComponent({
    name: 'App',
    components: {
        NavBar
    }
})
</script>
