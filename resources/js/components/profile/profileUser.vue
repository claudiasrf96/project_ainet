<template>
    <div>
        <h1>Last Shift</h1>
        <div xs6 v-if="user.shift_active == 0">
            <div class="block" >
                <div class="digit" >{{ shiftStart.days }}</div>
                <p class="text">Days</p>
            </div>

            <div class="block" >
                <div class="digit">{{ shiftStart.hours }}</div>
                <p class="text">Hours</p>
            </div>
            <div class="block" >
                <p class="digit">{{ shiftStart.minutes }}</p>
                <p class="text">Minutes</p>
            </div>
            <div class="block" >
                <p class="digit">{{ shiftStart.seconds  }}</p>
                <p class="text">Seconds</p>
            </div>
        </div>
        <div  xs6 class="block" v-else>
            <div class="title font-weight-light  " >Working </div>
        </div>
        <h1>Time Has Passed</h1>
        <div xs6>
            <div class="block" >
                <p class="digit">{{ daysPasted }}</p>
                <p class="text">Days</p>
            </div>
            <div class="block" >
                <p class="digit">{{ hoursPasted }}</p>
                <p class="text">Hours</p>
            </div>
            <div class="block" >
                <p class="digit">{{ minutesPasted }}</p>
                <p class="text">Minutes</p>
            </div>
            <div class="block" >
                <p class="digit">{{ secondsPasted  }}</p>
                <p class="text">Seconds</p>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        data () {
            return {
                user: [],
                dateLastShift: "",
                aux: "",
                shiftStart: {
                    seconds: "",
                    minutes: "",
                    hours: "",
                    days: ""
                },
                now: Math.trunc((new Date()).getTime() / 1000),
            }
        },
        mounted() {
            this.getUserInfor();  
            this.$nextTick(function() {
                window.setInterval(() => {
                    this.now = Math.trunc((new Date()).getTime() / 1000);
                    this.updateDate();
                },1000);
            })
        },
        computed: {
            secondsPasted() {
                return (  this.now - this.dateLastShift ) % 60;
            },
            minutesPasted() {
                return Math.trunc(( this.now - this.dateLastShift) / 60) % 60;
            },
            hoursPasted() {
                return Math.trunc(( this.now - this.dateLastShift) / 60 / 60) % 24;
            },
            daysPasted() {
                return Math.trunc(( this.now - this.dateLastShift) / 60 / 60 / 24) ;
            }
        },
        methods: {
            getUserInfor() {
                this.user = this.$store.state.user;
                this.updateDate();
            },
            updateDate(){
                this.dateLastShift = Math.trunc(Date.parse(this.user.last_shift_start) / 1000);
                //data atual 
                this.aux = new Date(this.user.last_shift_start);
                this.shiftStart.seconds = this.aux.getSeconds();
                this.shiftStart.minutes = this.aux.getMinutes();
                this.shiftStart.hours = this.aux.getHours();
            }
        }
    };
</script>


<style>

@import url(https://fonts.googleapis.com/css?family=Roboto+Condensed:400|Roboto:100);

.block {
    display: inline-block;
    flex-direction: column;
    margin-top: 2.5%;
    margin-left: 2.5%;
    margin-right: 2.5%;
    margin-bottom: 5%;
}

.text {
    color: #1abc9c;
    font-size: 20px;
    font-family: 'Roboto Condensed', serif;
    font-weight: 40;
    margin-top:10px;
    margin-bottom: 10px;
    text-align: center;
}

.digit {
    color: #2b2e2d;;
    font-size: 50px;
    font-weight: 100;
    font-family: 'Roboto', serif;
    margin: 10px;
    text-align: center;
}
</style>
