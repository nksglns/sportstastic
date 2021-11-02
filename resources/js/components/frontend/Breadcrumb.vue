<template>
    <div class="container" v-if="crumbs.length > 0">
        <nav style="--bs-breadcrumb-divider: '>'" aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item fw-bold">Navigate</li>
                <li class="breadcrumb-item" v-for="(crumb, i) in crumbs" :key="'crumb' + i">
                    <router-link :to="crumb">{{ crumb.name }}</router-link>
                </li>
            </ol>
        </nav>
    </div>
</template>

<script>
export default {
    data: function () {
        return {};
    },
    computed: {
        crumbs: function () {
            let crumbs = [];
            crumbs.push({
                name: 'sports',
            });
            if (this.$route.params.sportSlug) {
                crumbs.push({
                    name: 'leagues',
                    params: {
                        sportSlug: this.$route.params.sportSlug,
                    },
                });
            }
            if (this.$route.params.leagueSlug) {
                crumbs.push({
                    name: 'teams',
                    params: {
                        sportSlug: this.$route.params.sportSlug,
                        leagueSlug: this.$route.params.leagueSlug,
                    },
                });
            }

            //Remove the last breadcrumb - it's the current
            crumbs = crumbs.slice(0, crumbs.length - 1);
            return crumbs;
        },
    },
};
</script>
