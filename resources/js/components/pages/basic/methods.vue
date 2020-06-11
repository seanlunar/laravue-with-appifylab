<template>
  <div>
      <h1> the number: {{ views }}</h1>
      <button @click="updateCounter(1)" >Increase</button>
      <button @click="updateCounter(-1)" >Decrease</button>
      <br>
      <div v-for="(blog, i) in blogs " :key="i" v-if="blogs.length ">
   <h1>{{ blog.title }}</h1>
   <p>{{ blog.post }}</p>
      </div>
      <br>
      <br>
      <br>
      <div>
          <h1 v-if="showItem">show  tis item if "showItem" is true </h1>
          <h1 v-else>show  tis item if "showItem" is false </h1>
      </div>
      <button @click="changeShowItem">Change show item</button>
  </div>
</template>

<script>
export default {
    data(){
        return {
            views : 0,
            blogs:[],
            showItem : false
        }
    },
    methods:{
        updateCounter(number){
     this.views += number
        },
        changeShowItem(){
            this.showItem = !this.showItem
        }
    },
    created(){
        this.views = 100

        //getin blog post
      let posts = [
                {title: 'this is  the  blog title1','post': 'this is th blog post1', id:1},
                {title: 'this is  the  blog title2','post': 'this is th blog post2', id:2},
                {title: 'this is  the  blog title3','post': 'this is th blog post3', id:3},
                {title: 'this is  the  blog title4','post': 'this is th blog post4', id:4},]
                this.blogs = posts

    }
}
</script>