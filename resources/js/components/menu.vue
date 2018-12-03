<template>
    <div id="app">
    <v-app id="inspire">
        <v-data-table
        :headers="headers"
        :items="desserts"
        class="elevation-1"
        >
        <template slot="headerCell" slot-scope="props">
            <v-tooltip bottom>
            <span slot="activator">
                {{ props.header.text }}
            </span>
            <span>
                {{ props.header.text }}
            </span>
            </v-tooltip>
        </template>
        <template slot="items" slot-scope="props">
            <td>{{ props.item.name }}</td>
            <td class="text-xs-right">{{ props.item.calories }}</td>
            <td class="text-xs-right">{{ props.item.fat }}</td>
            <td class="text-xs-right">{{ props.item.carbs }}</td>
            <td class="text-xs-right">{{ props.item.protein }}</td>
            <td class="text-xs-right">{{ props.item.iron }}</td>
        </template>
        </v-data-table>
    </v-app>
    </div>
</template>

<script type="text/javascript">    
    export default {
        data () {
            return {
            headers: [
                {
                text: 'Dessert (100g serving)',
                align: 'left',
                sortable: false,
                value: 'name'
                },
                { text: 'Calories', value: 'calories' },
                { text: 'Fat (g)', value: 'fat' },
                { text: 'Carbs (g)', value: 'carbs' },
                { text: 'Protein (g)', value: 'protein' },
                { text: 'Iron (%)', value: 'iron' }
            ],
            desserts: [
                {
                value: false,
                name: 'Frozen Yogurt',
                calories: 159,
                fat: 6.0,
                carbs: 24,
                protein: 4.0,
                iron: '1%'
                }
            ]
            }
        },mounted () {
            axios.get('/api/menu').then(response =>(
                this.info = response
            ))
        }
    }
</script>