<template>
    <div>
        <v-parallax :src="'storage/banners/meals.jpg'" height="250"> 
        </v-parallax>
        <list-meals :new_meal="newMeal" :creating_meal="true" ></list-meals>
        <list-tables @selected_table="setTable"></list-tables>
         <template>
            <v-layout  v-show="selectedTable.table_number != undefined " align-start justify-end row fill-height class="layoutSpace" >
                <v-flex class="insertCard">
                    <v-slide-y-transition >
                        <v-card >
                            <form >
                                <v-flex xs12 sm12 md12>
                                    <v-text-field v-model="user.id" disabled solo label="Id responsavel" required></v-text-field>
                                </v-flex>
                                <v-flex xs12 sm12 md12>
                                    <v-text-field  v-model="selectedTable.table_number" disabled solo label="Mesa"  required ></v-text-field>
                                </v-flex>
                                <v-flex >
                                    <v-btn block  round color="primary" dark @click="createMeal">Criar order</v-btn>
                                </v-flex>
                            </form>
                        </v-card>
                    </v-slide-y-transition>
                    </v-flex>
            </v-layout>
        </template>
    </div>
</template>

<script>
  export default {
    data () {
        return{
            isActive: false,
            newMeal: "",
            selectedTable: {},
            user: [],
            select: "",
            meal:  {}
        }
    }, 
    mounted () {
        this.getUserInfor();  
    },
    methods: {
        getNewMeal (e){
            this.newMeal = e;
        },
        getUserInfor() {
            this.user = this.$store.state.user;
        },
        createMeal() {
            this.meal.responsible_waiter_id = this.user.id; 
            this.meal.table_number = this.selectedTable.table_number; 
            axios.post('/api/meal/createMeal', this.meal).then(response => {
                this.newMeal = response.data.data;

                this.$socket.emit('meal_created', response.data.data, "Created");
            })
            .catch(function (error) {
                console.log(error);
            });
        },
        setTable(e){
            this.selectedTable = e;
        },
    }
}
</script>