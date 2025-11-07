<template lang="">
    <div>
        <h1>Store Page</h1>
        <hr>
        Token: {{ authStore.getToken }}
    </div>
</template>
<script>
import { useAuthStore } from '../Stores/Auth';

export default {
    setup() {
        const authStore = useAuthStore();
        return { authStore };
    },
    data() {
        return {
            
        }
    },
}
</script>
<style lang="">
    
</style>