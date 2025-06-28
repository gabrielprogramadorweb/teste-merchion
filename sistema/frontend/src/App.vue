<template>
    <div style="background-color:#111827">
        <NavBar class="fixed"/>
        <router-view/>
    </div>
</template>

<script lang="ts">
import { defineComponent } from 'vue'
import NavBarView from '@/components/NavBar/NavBarView.vue'

export default defineComponent({
    name: 'App',
    components: {
        NavBar: NavBarView
    }
})
</script>
