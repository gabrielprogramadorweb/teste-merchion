<template>
    <div>
        <NavBar class="fixed"/>
        <router-view style="margin-top:70px;"/>
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
