<template>
    <v-app>
        <v-container
                fluid
                style="min-height: 0;"
                grid-list-lg
        >
            <v-data-table
                    :headers="headers"
                    :items="items"
                    item-key="id"
                    class="elevation-1"
                    :rows-per-page-items="row_per_page"
            >
                <template slot="items" slot-scope="props">
                    <td class="text-xs-left">{{ props.item.date }}</td>
                    <td class="text-xs-left">{{ props.item.begin.substring(0, 5) }}</td>
                    <td class="text-xs-left">{{ (!!props.item.end) ? props.item.end.substring(0, 5) :　"未打卡"}}</td>
                </template>
            </v-data-table>
        </v-container>
    </v-app>
</template>

<script>
    export default {
        name: "UserPresentList",
        props: ['presents'],
        data () {
            return {
                items: [],
                headers: [
                    {
                        text: '日期',
                        align: 'left',
                        sortable: false,

                    },
                    { text: '上班時間', sortable: false },
                    { text: '下班時間', sortable: false },
                ],
                row_per_page: [10, 25, 50, { text: "All", value: -1 }],
            }
        },
        mounted () {
            this.items = this.presents
        }
    }
</script>

<style scoped>

</style>