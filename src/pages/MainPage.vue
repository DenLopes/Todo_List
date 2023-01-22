<script setup>
import { defineComponent, ref, reactive, onMounted } from "vue";
import axios from "axios";
import NewTaskPopup from "src/components/NewTaskPopup.vue";
import BriefTask from "src/components/BriefTask.vue";

defineComponent({
  name: "MainPage",
});

const emit = defineEmits(["update"]);

const fromNewTask = ref();
const state = reactive({
  tasks: [],
});

async function getTasks() {
  axios
    .get("tasks")
    .then((response) => {
      state.tasks = response.data;
    })
    .catch((error) => {
      console.log(error);
    });
  emit("update");
}

async function deleteTask(id) {
  try {
    await axios.delete(`/task/${id}`);
    emit("update");
  } catch (error) {
    console.log(error);
  }
  getTasks();
}

function toggleNewTask() {
  fromNewTask.value.toggleNewTask();
}

onMounted(() => {
  getTasks();
});
</script>

<template>
  <q-page class="flex column" style="max-width: 1000px; margin: auto">
    <q-item class="flex row justify-between">
      <q-item-label class="text-h4">Tarefas</q-item-label>
      <q-item-section side>
        <q-btn outline color="primary" icon="add" @click="toggleNewTask()" />
      </q-item-section>
    </q-item>
    <q-separator class="q-mb-xs" />
    <BriefTask
      v-for="task in state.tasks"
      :key="task"
      :task="task"
      @delete="deleteTask"
    ></BriefTask>
    <NewTaskPopup ref="fromNewTask" @getTask="getTasks"></NewTaskPopup>
  </q-page>
</template>
