<template>
    <div class="container pb-5" v-if="!isLoading">
        <h2 class="display-6 fw-bold mb-5">{{ teamDetails.team_name }}</h2>
        <div class="row mb-4">
            <div class="col-md-3 mb-2">
                <div class="teamdetail-logocontain" :style="{ 'background-image': 'url(' + teamDetails.image + ')' }"></div>
            </div>
            <div class="col-md-9">
                <h3 class="display-7 fw-bold mb-2">Team Information</h3>
                <table class="table table-striped">
                    <tbody>
                        <tr>
                            <th scope="row" class="detailtable_firstline">Stadium Name</th>
                            <td>{{ !teamDetails.stadium_name ? '-' : teamDetails.stadium_name }}</td>
                        </tr>
                        <tr>
                            <th scope="row">Website</th>
                            <td>{{ !teamDetails.website ? '-' : teamDetails.website }}</td>
                        </tr>
                    </tbody>
                </table>
                <h3 class="display-7 fw-bold mb-2 mt-4">Team Description</h3>
                <p style="white-space: pre-line">{{ !teamDetails.description ? 'There is no description.' : teamDetails.description }}</p>
            </div>
        </div>
        <div class="mb-4">
            <h3 class="display-6 fw-bold mb-4">Team Standings</h3>
            <div class="team-standings" v-if="teamDetails.standings && teamDetails.standings.length > 0">
                <div class="table-responsive">
                    <table class="table table-striped table-standings">
                        <thead>
                            <tr>
                                <th scope="col">League</th>
                                <th scope="col">Rank</th>
                                <th scope="col">Goals For</th>
                                <th scope="col">Goals Against</th>
                                <th scope="col">Goals Diff</th>
                                <th scope="col">Wins</th>
                                <th scope="col">Losses</th>
                                <th scope="col">Draws</th>
                                <th scope="col">Points</th>
                                <th scope="col">Season</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(standing, i) in teamDetails.standings" :key="'standing' + i">
                                <th scope="row">{{ standing.league.league_name }}</th>
                                <td>{{ standing.team_rank }}</td>
                                <td>{{ standing.goals_for }}</td>
                                <td>{{ standing.goals_against }}</td>
                                <td>{{ standing.goals_difference }}</td>
                                <td>{{ standing.wins }}</td>
                                <td>{{ standing.losses }}</td>
                                <td>{{ standing.draws }}</td>
                                <td>{{ standing.points }}</td>
                                <td>{{ standing.season }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="alert alert-danger d-flex align-items-center" role="alert" v-else>
                <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:"><use xlink:href="#exclamation-triangle-fill" /></svg>
                <div>There's no information about team standings.</div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data: function () {
        return {
            teamDetails: {},
            isLoading: true,
        };
    },
    mounted() {
        let self = this;
        axios
            .get('teams/' + self.$route.params.teamSlug)
            .then(function (response) {
                self.teamDetails = response.data.data;
            })
            .catch(function (err) {
                self.$router.push('/');
            })
            .then(function () {
                NProgress.done();
                self.isLoading = false;
            });
    },
};
</script>
