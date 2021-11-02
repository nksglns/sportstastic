<template>
    <div class="container">
        <div class="mb-4">
            <h2 class="display-7 fw-bold">Sports</h2>
            <p class="col-md-8 fs-5">Please select the sport you're interested in from the list below.</p>
        </div>
        <template v-if="sports.length > 0 || isLoading">
            <div class="row">
                <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 mb-4" v-for="(sport, i) in sports" :key="'sport' + i">
                    <router-link :to="{ name: 'leagues', params: { sportSlug: sport.slug } }" :style="{ 'background-image': 'url(' + sport.image + ')' }" class="sportsbutton btn d-block w-100 bg-light">
                        <span class="w-100 d-block py-3 text-white fs-5">{{ sport.sport_name }}</span>
                    </router-link>
                </div>
            </div>
        </template>
        <template v-else>
            <div class="alert alert-danger d-flex align-items-center" role="alert">
                <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:"><use xlink:href="#exclamation-triangle-fill" /></svg>
                <div>Whoops! No sports are currently available!</div>
            </div>
        </template>
    </div>
</template>

<script>
export default {
    data: function () {
        return {
            isLoading: true,
            sports: [],
        };
    },
    mounted() {
        let self = this;
        axios
            .get('sports')
            .then(function (response) {
                self.sports = response.data.data;
            })
            .catch(function (err) {})
            .then(function () {
                NProgress.done();
                self.isLoading = false;
            });
    },
};
</script>
