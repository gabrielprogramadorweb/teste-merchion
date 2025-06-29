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
import SuporteChat from '@/components/Suporte/SuporteChat.vue'

export default defineComponent({
    name: 'App',
    components: {
        NavBar: NavBarView,
        SuporteChat,
    },
})
</script>
