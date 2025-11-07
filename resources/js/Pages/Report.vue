<template lang="">
    <div>
        <h1>Report Page</h1>
        <p>Token: {{ authStore.getToken }}</p>
    </div>
</template>
<script>
import { useAuthStore } from '../Stores/Auth';
export default {
    setup() {
        const authStore = useAuthStore();
        return { authStore };
    }
}
</script>
<style lang="">
    
</style>