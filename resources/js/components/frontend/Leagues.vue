<template>
    <div class="container">
        <div class="mb-4">
            <h2 class="display-7 fw-bold">Leagues</h2>
            <p class="col-md-8 fs-5">Please select a league below.</p>
        </div>
        <template v-if="leagues.length > 0 || isLoading">
            <div class="row">
                <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 mb-4" v-for="(league, i) in leagues" :key="'league' + i">
                    <router-link
                        :to="{
                            name: 'teams',
                            params: {
                                sportSlug: $route.params.sportSlug,
                                leagueSlug: league.slug,
                            },
                        }"
                        class="bg-light leaguebutton bg- d-flex btn py-3 rounded-3 align-items-center h-100"
                    >
                        <span class="league-acronym">{{ acronym(league.league_name) }} </span> {{ league.league_name }}
                    </router-link>
                </div>
            </div>
        </template>
        <template v-else>
            <div class="alert alert-danger d-flex align-items-center" role="alert">
                <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:"><use xlink:href="#exclamation-triangle-fill" /></svg>
                <div>Whoops! No leagues were found for this sport!</div>
            </div>
        </template>
    </div>
</template>

<script>
export default {
    data: function () {
        return {
            leagues: [],
            isLoading: true,
        };
    },
    methods: {
        acronym: function (text) {
            return text.split(/\s/).reduce(function (accumulator, word) {
                return accumulator + word.charAt(0);
            }, '');
        },
    },
    mounted() {
        let self = this;
        axios
            .get('sports/' + self.$route.params.sportSlug)
            .then(function (response) {
                self.leagues = response.data.data;
            })
            .catch(function (err) {
                //We'll handle it as a 404, and redirect to home to pick a sport
                self.$router.push('/');
            })
            .then(function () {
                NProgress.done();
                self.isLoading = false;
            });
    },
};
</script>
