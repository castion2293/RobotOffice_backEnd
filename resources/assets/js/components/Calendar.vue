<template>
    <v-app>
        <full-calendar :events="events" :config="config" ref="calendar"></full-calendar>
    </v-app>
</template>

<script>
    export default {
        name: "Calendar",
        props: ['schedules'],
        data () {
            return {
                events: JSON.parse(this.schedules),
                config: {
                    defaultView: 'month',
                    locale: 'zh-cn',
                    firstDay: 0,
                    header: {
                        left: '',
                        center: '',
                        right: ''
                    },
                    height: 530,
                },
            }
        }
    }
</script>

<style scoped>

</style>