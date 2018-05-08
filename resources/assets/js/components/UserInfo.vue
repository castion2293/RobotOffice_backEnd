<template>
    <v-app>
        <v-container
                style="min-height: 0;"
                grid-list-lg
        >
            <v-layout row wrap>
                <v-flex md6 sm12 xs12>
                    <v-card color="blue-grey darken-1" class="white--text">
                        <v-card-title primary-title class="headline">
                            <strong>休假時數總覽</strong>
                        </v-card-title>
                        <v-card class="white title grey--text text--darken-2">
                            <v-container
                                    style="min-height: 0;"
                                    grid-list-lg
                            >
                                <div class="mt-5 mb-5">
                                    <span><strong>
                                        今年度特休時數: <b class="blue--text text--darken-2">{{ user.holiday_days }}</b> hr
                                    </strong></span>
                                </div>
                                <v-divider></v-divider>
                                <div class="mt-5 mb-5">
                                    <span><strong>
                                        今年度特休剩餘時數: <b class="blue--text text--darken-2">{{ user.holiday }}</b> hr
                                    </strong></span>
                                </div>
                                <v-divider></v-divider>
                                <div class="mt-5 mb-5">
                                    <span><strong>
                                        今年度補休剩餘時數: <b class="blue--text text--darken-2">{{ user.rest }}</b> hr
                                    </strong></span>
                                </div>
                                <v-divider></v-divider>
                            </v-container>
                        </v-card>
                    </v-card>
                </v-flex>
                <v-flex md6 sm12 xs12>
                    <v-card color="deep-orange darken-1" class="white--text">
                        <v-card-title primary-title class="headline">
                            <strong>出席率</strong>
                            <v-spacer></v-spacer>
                            <strong>{{ ((1 - ( holidays.count / (presents.count + holidays.count + trips.count))) * 100).toFixed(0) }}%</strong>
                        </v-card-title>
                        <v-card class="white">
                            <ratePieChart
                                :presentDays="presents.count"
                                :holidayDays="holidays.count"
                                :tripDays="trips.count"
                            ></ratePieChart>
                        </v-card>
                    </v-card>
                </v-flex>
                <v-flex md6 sm12 xs12>
                    <v-card color="light-blue lighten-2" class="white--text">
                        <v-card-title primary-title class="headline">
                            <strong>出席</strong>
                            <v-spacer></v-spacer>
                            <strong>天數: {{ presents.count }}天</strong>
                        </v-card-title>
                        <v-card class="white">
                            <UserPresentList :presents="presents.data"></UserPresentList>
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
                            <UserHolidayList :holidays="holidays.data"></UserHolidayList>
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
                            <UserTripList :trips="trips.data"></UserTripList>
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
                            <UserRestList :rests="rests.data"></UserRestList>
                        </v-card>
                    </v-card>
                </v-flex>
            </v-layout>
        </v-container>
    </v-app>
</template>

<script>
    import UserPresentList from './UserPresentList'
    import UserHolidayList from './UserHolidayList'
    import UserTripList from './UserTripList'
    import UserRestList from './UserRestList'
    import ratePieChart from './ratePieChart'

    export default {
        name: "UserInfo",
        props: ['user', 'presents', 'holidays', 'trips', 'rests'],
        components: {
            UserPresentList,
            UserHolidayList,
            UserTripList,
            UserRestList,
            ratePieChart
        },
    }
</script>

<style scoped>

</style>