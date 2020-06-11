<template >
    <div>
        <h1>
            hooks tutorial
        </h1>
        <h2>My  name is {{ name }}</h2>
    </div>
</template>

<script>
export default {
    data(){
        return{
            name: 'lunar'
        }
    },
    beforeCreate(){
   console.log(this.name)
    },

    created(){
        //call mostly initial data from it ...
        console.log('data and another function i available but  not html', this.name)
    },
    mounted(){
        console.log(this.$refs.myref)
    }
}
</script>