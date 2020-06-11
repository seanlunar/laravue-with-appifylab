<template>
    <div>
        <div class="content">
			<div class="container-fluid">
                 <h1>i will show  how all these  com react to changes </h1>
               <h2>  CURRENT STATE COUNTER IS :{{counter}}</h2>
                 <comA></comA>
                 <comB></comB>
                 <comC></comC>

                   <Button type="info" @click="changeCounter" >Change state counter</Button>
			</div>    
       	</div>   
         
    </div>
</template>
<script>
import comA from './comA'
import comB from './comB'
import comC from './comC'
import {mapGetters} from 'vuex'

export default {
    methods:{
          changeCounter(){
             this.$store.commit('cchangeThecounter', 1)
          }
    },
    computed:{
         ...mapGetters({
             'counter':'getCounter'
         })
    },
    components : {
        comA,
        comB,
        comC
    }
}
</script>