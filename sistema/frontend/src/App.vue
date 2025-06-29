<template>
    <div style="background-color:#111827">
        <NavBar class="fixed" />
        <router-view />
        <SuporteChat />
    </div>
</template>

<script lang="ts">
import { defineComponent } from 'vue'
import NavBarView from '@/components/NavBar/NavBarView.vue'
import Suporte from '@/components/Suporte/Suporte.vue'

export default defineComponent({
    name: 'App',
    components: {
        NavBar: NavBarView,
        SuporteChat: Suporte,
    },
})
</script>
