<template>
    <v-app>
        <v-data-table
                :headers="headers"
                :items="items"
                item-key="id"
                class="elevation-1"
        >
            <template slot="items" slot-scope="props">
                <td><a :href="'/admin/employee/' + props.item.name">{{ props.item.name }}</a></td>
                <td class="text-xs-left">{{ props.item.email }}</td>
                <td class="text-xs-left">{{ props.item.start_date }}</td>
                <td class="text-xs-left">{{ props.item.holidays }} hr</td>
                <td class="text-xs-left">{{ props.item.holiday }} hr</td>
                <td class="text-xs-left">{{ props.item.rest }} hr</td>
            </template>
        </v-data-table>
    </v-app>
</template>

<script>
    export default {
        props: ['users'],
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
                items: JSON.parse(this.users)
            }
        },
        // mounted () {
        //     console.log(JSON.parse(this.users))
        // }
    }
</script>

<style scoped>

</style>