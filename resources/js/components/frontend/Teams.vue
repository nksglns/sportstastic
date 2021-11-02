<template>
    <div class="container">
        <div class="mb-4">
            <h2 class="display-7 fw-bold">Teams</h2>
            <p class="col-md-8 fs-5">Please select a team below.</p>
        </div>
        <template v-if="teams.length > 0 || isLoading">
            <div class="row">
                <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 mb-4" v-for="(team, i) in teams" :key="'team' + i">
                    <router-link
                        :to="{
                            name: 'team',
                            params: {
                                sportSlug: $route.params.sportSlug,
                                leagueSlug: $route.params.leagueSlug,
                                teamSlug: team.slug,
                            },
                        }"
                        class="list-teambutton btn bg-light py-3 rounded-3 align-items-center h-100"
                    >
                        <span class="list-teamimg" :style="{ 'background-image': 'url(' + team.image + ')' }"></span>
                        {{ team.team_name }}
                    </router-link>
                </div>
            </div>
        </template>
        <template v-else>
            <div class="alert alert-danger d-flex align-items-center" role="alert">
                <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:"><use xlink:href="#exclamation-triangle-fill" /></svg>
                <div>Whoops! No teams were found for this League!</div>
            </div>
        </template>
    </div>
</template>

<script>
export default {
    data: function () {
        return {
            isLoading: true,
            teams: [],
        };
    },
    mounted() {
        let self = this;
        axios
            .get('leagues/' + self.$route.params.leagueSlug)
            .then(function (response) {
                self.teams = response.data.data;
            })
            .catch(function (err) {
                //We'll handle it as a 404, and redirect to home to pick a sport
                self.$router.push('/');
            })
            .then(function () {
                self.isLoading = false;
                NProgress.done();
            });
    },
};
</script>
