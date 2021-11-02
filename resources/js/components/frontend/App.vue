<template>
    <div>
        <div class="container py-4">
            <header>
                <router-link :to="{ name: 'sports' }" class="logotext">
                    <span>Sportstastic</span>
                </router-link>
            </header>
        </div>
        <Breadcrumb></Breadcrumb>
        <router-view></router-view>
    </div>
</template>
<script>

import Breadcrumb from './Breadcrumb.vue';

export default {
    data: {},
    components:{
        Breadcrumb
    }
};
</script>
