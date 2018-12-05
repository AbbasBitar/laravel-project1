<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>My tasks</title>
    <script src="https://cdn.jsdelivr.net/npm/vue@2.5.17/dist/vue.js"></script>

</head>
<body>
<style>

body {
  background-color: lightblue;
}
h1{
  font-family: 'Verdana', sans-serif;
}
button {
  font-family: 'Verdana', sans-serif;
}
.tasks {
  width: 100%;
  max-width: 720px;
  padding: 32px;
  margin: 32px auto;
  overflow: hidden;
  background-color: #fff;
  box-shadow: 0px 0.4px 16px rgba(0,0,0,0.25);
}
.tasks__list {
  clear: both;
}
.tasks__item {
  margin-bottom: 16px;
  position: relative;
}
.tasks__item__toggle {
  cursor: pointer;
  width: auto;
  text-align: left;
  padding: 16px 32px 16px 16px;
  background-color: white;
  border: 1px solid black;
}
.tasks__item__toggle:hover {
  background-color: rgba(0,0,0,0.1);
  border-color: black;
}
.tasks__item__toggle--completed {
  text-decoration: line-through;
  background-color: rgba(0,128,0,0.15);
  border-color: black;
}
.tasks__item__toggle--completed:hover {
  background-color:rgba(0,0,0,0.1);
  border-color: black;
}
.tasks__item__remove {
  position: absolute;
  height: 100%;
  top: 50%;
  right: 0;

}
.tasks__item__remove i {
  vertical-align: middle;
}
</style>
    <div id="app">
  <task-list :tasks="tasks"></task-list>
</div>

<template id="task-list">
    <section class="tasks">
      <h1>
      My To Do List
          <small v-if="incomplete">(@{{ incomplete }})</small>
        </transition>
        
      </h1>
      <div class="tasks__new input-group">
        <input type="text"
               class="input-group-field"
               v-model="newTask"
               @keyup.enter="addTask"
               placeholder="New task"
        >
        <span class="input-group-button">
          <button @click="addTask" 
                  class="button"
          >
            <i></i> Add
          </button>
        </span>
      </div>

      <div class="tasks__clear button-group pull-right">
        <button
                @click="clearCompleted"
        >
          <i></i> Clear Completed
        </button>
        <button
                @click="clearAll"
        >
          <i></i> Clear All
        </button>
      </div>
      
      <transition-group name="fade" tag="ul" class="tasks__list no-bullet">
          <task-item v-for="(task, index) in tasks"
                     @remove="removeTask(index)"
                     @complete="completeTask(task)"
                     :task="task"
                     :key="task"
          ></task-item>
      </transition-group>
    </section>
</template>

<template id="task-item">
    <li class="tasks__item">
      <button :class="className"
          @click.self="$emit('complete')"
      >
        @{{ task.title }}
      </button>
      <button class="tasks__item__remove button alert pull-right"
              @click="$emit('remove')"
      >
        <i></i> Remove
      </button>
    </li>
</template>
    
    <script>
        // javascript code here
        Vue.component('task-list', {
  template: '#task-list',
  props: {
    tasks: {default: []}
  },
  data() {
    return {
      newTask: ''
    };
  },
  computed: {
    incomplete() {
      return this.tasks.filter(this.inProgress).length;
    }
  },
  methods: {
    addTask() {
      if (this.newTask) {
        this.tasks.push({
          title: this.newTask,
          completed: false
        });
        this.newTask = '';
      }
    },
    completeTask(task) {
      task.completed = ! task.completed;
    },
    removeTask(index) {
      this.tasks.splice(index, 1);
    },
    clearCompleted() {
      this.tasks = this.tasks.filter(this.inProgress);
    },
    clearAll() {
      this.tasks = [];
    },
    
    inProgress(task) {
      return ! this.isCompleted(task);
    },
    isCompleted(task) {
      return task.completed;
    }
  }
});

Vue.component('task-item', {
  template: '#task-item',
  props: ['task'],
  computed: {
    className() {
      let classes = ['tasks__item__toggle'];
      if (this.task.completed) {
        classes.push('tasks__item__toggle--completed');
      }
      return classes.join(' ');
    }
  }
});

new Vue({
  el: '#app',
  data: {
    tasks: [
      
    ]
  }
});
    </script>
</body>
</html>
