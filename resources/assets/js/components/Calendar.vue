<template>
    <full-calendar :events="events" :config="config" ref="calendar"></full-calendar>
</template>

<script>
    export default {
        name: "Calendar",
        data () {
            return {
                events: [
                    {
                        title  : 'Nick 上班',
                        start  : '2018-04-27T08:30:00',
                        end    : '2018-04-27T17:30:00',
                        color  : '#F44336',
                        textColor: 'white',
                    },
                    {
                        title  : 'Edward 上班',
                        start  : '2018-04-27T08:30:00',
                        end    : '2018-04-27T17:30:00',
                        color  : '#E91E63',
                        textColor: 'white',
                    },
                    {
                        title  : 'Sylvia 請特休 ~ 17:30',
                        start  : '2018-04-27T08:30:00',
                        end    : '2018-04-27T17:30:00',
                        color  : '#2196F3',
                        textColor: 'white',
                    },
                    {
                        title  : 'Mandy 上班',
                        start  : '2018-04-27T08:30:00',
                        end    : '2018-04-27T17:30:00',
                        color  : '#4CAF50',
                        textColor: 'white',
                    },
                    {
                        title  : 'Email 上班',
                        start  : '2018-04-27T08:30:00',
                        end    : '2018-04-27T17:30:00',
                        color  : '#FFC107',
                        textColor: 'white',
                    }
                ],
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