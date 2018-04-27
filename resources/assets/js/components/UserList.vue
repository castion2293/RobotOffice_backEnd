<template>
    <v-data-table
            :headers="headers"
            :items="items"
            item-key="id"
            class="elevation-1"
    >
        <template slot="items" slot-scope="props">
            <td>{{ props.item.name }}</td>
            <td class="text-xs-left">{{ props.item.email }}</td>
            <td class="text-xs-left">{{ props.item.start_date }}</td>
            <td class="text-xs-left">{{ props.item.holidays }} hr</td>
            <td class="text-xs-left">{{ props.item.holiday }} hr</td>
            <td class="text-xs-left">{{ props.item.rest }} hr</td>
        </template>
    </v-data-table>
</template>

<script>
    export default {
        data () {
            return {
                headers: [
                    {
                        text: '姓名',
                        align: 'left',
                        sortable: false,
                    },
                    { text: '信箱', sortable: false },
                    { text: '到職日期', sortable: false },
                    { text: '特休時數', sortable: false },
                    { text: '特休剩餘時數', sortable: false },
                    { text: '補休剩餘時數', sortable: false },
                ],
                items: [
                    {
                        name: 'Nick Zhang',
                        email: 'nick@robot-tech.com.tw',
                        start_date: '2017-10-16',
                        holidays: 24,
                        holiday: 24,
                        rest: 0
                    },
                    {
                        name: 'Josh Wang',
                        email: 'nick@robot-tech.com.tw',
                        start_date: '2017-10-16',
                        holidays: 24,
                        holiday: 24,
                        rest: 0
                    },
                ]
            }
        }
    }
</script>

<style scoped>

</style>