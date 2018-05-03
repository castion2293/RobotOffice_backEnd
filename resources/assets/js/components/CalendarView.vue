<script>
    import calendar from './Calendar'

    export default {
        name: "CalendarView",
        props: ['year', 'month'],
        components: {
            calendar
        },
    }
</script>

<style scoped>

</style>