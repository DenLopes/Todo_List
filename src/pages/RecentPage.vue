<script setup>
import { defineComponent, ref, onMounted } from "vue";
import recent_CompletedTask from "src/components/recent_CompletedTask.vue";
import axios from "axios";

defineComponent({
  name: "RecentPage",
});

const completedSubTasks = ref();

async function getCompletedTasks() {
  axios
    .get("sub_tasks")
    .then((response) => {
      completedSubTasks.value = response.data;
    })
    .catch((error) => {
      console.log(error);
    });
}

onMounted(() => {
  getCompletedTasks();
});
</script>

<template>
  <q-page class="flex column" style="max-width: 1000px; margin: auto">
    <q-item class="flex row justify-center">
      <q-item-label class="text-h4">Feitas recentemente</q-item-label>
    </q-item>
    <q-separator class="q-mb-xs" />
    <recent_CompletedTask
      v-for="completedTask in completedSubTasks"
      :key="completedTask"
      :completedTask="completedTask"
    ></recent_CompletedTask>
  </q-page>
</template>
