<template lang="">
    <div>
        <h1>Store Page</h1>
        <hr>
        Token: {{ authStore.getToken }}
    </div>
</template>
<script>
import { useAuthStore } from '../Store/Auth';

export default {
    setup() {
        const authStore = useAuthStore();
        return { authStore };
    }
}
</script>
<style lang="">
    
</style>