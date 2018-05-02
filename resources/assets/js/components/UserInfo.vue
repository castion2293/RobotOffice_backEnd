<template>
    <v-app>
        <v-container
                style="min-height: 0;"
                grid-list-lg
        >
            <v-layout row wrap>
                <v-flex md6 sm12 xs12>
                    <v-card color="light-blue lighten-2" class="white--text">
                        <v-card-title primary-title class="headline">
                            <strong>出席</strong>
                            <v-spacer></v-spacer>
                            <strong>天數: {{ presents.count }}天</strong>
                        </v-card-title>
                        <v-card class="white">
                            <!--<user-present-list :present="user_data.schedules"></user-present-list>-->
                        </v-card>
                    </v-card>
                </v-flex>
                <v-flex md6 sm12 xs12>
                    <v-card color="green lighten-2" class="white--text">
                        <v-card-title primary-title class="headline">
                            <strong>請假</strong>
                            <v-spacer></v-spacer>
                            <strong>總時數: {{ holidays.hours_count }}小時</strong>
                        </v-card-title>
                        <v-card class="white">
                            <!--<holidayList></holidayList>-->
                        </v-card>
                    </v-card>
                </v-flex>
                <v-flex md6 sm12 xs12>
                    <v-card color="orange lighten-1" class="white--text">
                        <v-card-title primary-title class="headline">
                            <strong>出差</strong>
                            <v-spacer></v-spacer>
                            <strong>總時數: {{ trips.hours_count }}小時</strong>
                        </v-card-title>
                        <v-card class="white">
                            <!--<tripList></tripList>-->
                        </v-card>
                    </v-card>
                </v-flex>
                <v-flex md6 sm12 xs12>
                    <v-card color="red lighten-1" class="white--text">
                        <v-card-title primary-title class="headline">
                            <strong>補休</strong>
                            <v-spacer></v-spacer>
                            <strong>總時數: {{ rests.hours_count }}小時</strong>
                        </v-card-title>
                        <v-card class="white">
                            <!--<restList></restList>-->
                        </v-card>
                    </v-card>
                </v-flex>
            </v-layout>
        </v-container>
    </v-app>
</template>

<script>
    export default {
        name: "UserInfo",
        props: ['presents', 'holidays', 'trips', 'rests'],
        data () {
            return {
                user_data: this.user
            }
        },
    }
</script>

<style scoped>

</style>