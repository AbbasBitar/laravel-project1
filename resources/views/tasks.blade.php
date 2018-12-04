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

    <div id="app">
  <task-list :tasks="tasks"></task-list>
</div>

<template id="task-list">
    <section class="tasks">
      <h1>
        Tasks 
        <transition name="fade">
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
            <i class="fa fa-plus"></i> Add
          </button>
        </span>
      </div>

      <div class="tasks__clear button-group pull-right">
        <button class="button warning small"
                @click="clearCompleted"
        >
          <i class="fa fa-check"></i> Clear Completed
        </button>
        <button class="button alert small"
                @click="clearAll"
        >
          <i class="fa fa-trash"></i> Clear All
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
        <i class="fa fa-times"></i>
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