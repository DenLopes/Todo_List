<script setup>
import { onMounted, ref } from "vue";
import SubTask from "src/components/SubTask.vue";
import EditTaskPopup from "src/components/EditTaskPopup.vue";
import axios from "axios";

const props = defineProps(["id"]);
const fromEditTask = ref();
const task = ref([]);
const sub_tasks = ref([]);

async function getTask() {
  try {
    const response = await axios.get(`/task/${props.id}`);
    task.value = response.data;
  } catch (error) {
    console.log(error);
  }
}

async function getSubTask() {
  try {
    const response = await axios
      .get(`/sub_tasks/${props.id}`)
      .then(function (response) {
        sub_tasks.value = response.data;
      });
  } catch (error) {
    console.log(error);
  }
}

function formatDate(created_at) {
  const date = new Date(created_at);
  return date.toLocaleDateString("default", {
    month: "long",
    day: "numeric",
    year: "numeric",
  });
}

async function deleteSubTask(id) {
  await axios
    .delete(`sub_task/${id}`)
    .then((response) => {})
    .catch((error) => {
      console.log(error);
    });
  getSubTask();
}

async function changeState(id, index) {
  try {
    await axios
      .put(`/sub_task/${id}`, {
        state: true,
      })
      .then((response) => {})
      .catch((error) => {
        console.log(error);
      });
  } catch (err) {
    console.log("err->", err.response.data);
  }
}

function toggleEditTask() {
  fromEditTask.value.toggleEditTask();
}

onMounted(() => {
  getTask();
  getSubTask();
});
</script>

<template>
  <q-page class="flex column" style="max-width: 1000px; margin: auto">
    <q-card flat bordered>
      <q-card-section class="bg-primary text-white">
        <div class="flex justify-between">
          <div class="text-h6" style="line-break: anywhere; max-width: 93%">
            {{ task.title }}
          </div>
          <div>
            <q-btn
              flat
              round
              icon="edit"
              @click.prevent="toggleEditTask(), getSubTask()"
              size="20px"
            />
          </div>
        </div>
        <div class="text-subtitle">{{ formatDate(task.created_at) }}</div>
      </q-card-section>
      <q-card-section style="line-break: anywhere">{{
        task.description
      }}</q-card-section>
      <q-separator />

      <div v-for="sub_task in sub_tasks" :key="sub_task">
        <SubTask
          :sub_task="sub_task"
          @delete="deleteSubTask"
          @changeState="changeState"
        ></SubTask>
      </div>
    </q-card>
    <EditTaskPopup
      ref="fromEditTask"
      :task="task"
      :sub_tasks="sub_tasks"
      @deleteSubTask="deleteSubTask"
      @getTask="getTask(), getSubTask()"
    ></EditTaskPopup>
  </q-page>
</template>
