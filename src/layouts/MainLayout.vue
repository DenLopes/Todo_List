<script setup>
import axios from "axios";
import { ref, onMounted } from "vue";
import DrawerProject from "src/components/DrawerProject.vue";

const leftDrawerOpen = ref(false);
let tasks = ref([]);

function toggleLeftDrawer() {
  leftDrawerOpen.value = !leftDrawerOpen.value;
}

async function getTasks() {
  try {
    await axios.get("tasks").then(function (response) {
      tasks.value = response.data;
    });
  } catch (error) {
    console.log(error);
  }
}

function formatDate(created_at) {
  const date = new Date(created_at);
  return (
    date.toLocaleDateString("default", {
      month: "long",
      day: "numeric",
      year: "numeric",
    }) +
    " " +
    date.toLocaleTimeString("default", { hour: "numeric", minute: "numeric" })
  );
}

onMounted(() => {
  getTasks();
});
</script>

<template>
  <q-layout view="hHh lpR lfr">
    <q-header reveal elevated class="bg-grey-9 text-white">
      <q-toolbar>
        <q-btn dense flat round icon="menu" @click="toggleLeftDrawer" />

        <q-toolbar-title> To Do List </q-toolbar-title>
      </q-toolbar>
    </q-header>

    <q-drawer v-model="leftDrawerOpen" side="left" overlay bordered>
      <q-item to="/main" clickable>
        <q-item-section avatar>
          <q-icon name="home" size="40px" />
        </q-item-section>

        <q-item-section>
          <q-item-label>Pagina Inicial</q-item-label>
        </q-item-section>
      </q-item>
      <q-item to="/recent" clickable>
        <q-item-section avatar>
          <q-icon name="assignment_turned_in" size="40px" />
        </q-item-section>

        <q-item-section>
          <q-item-label>Feitas recentemente</q-item-label>
        </q-item-section>
      </q-item>

      <q-separator />
      <q-item>
        <q-item-section avatar>
          <q-icon name="archive" size="40px" />
        </q-item-section>

        <q-item-section>
          <q-item-label>Tarefas</q-item-label>
        </q-item-section>
      </q-item>

      <q-scroll-area style="height: 75%">
        <div v-for="task in tasks" :key="task" class="q-py-xs">
          <DrawerProject
            :title="task.title"
            :date="formatDate(task.created_at)"
            :id="task.id"
          ></DrawerProject>
        </div>
      </q-scroll-area>
    </q-drawer>
    <q-page-container>
      <router-view
        :key="$route.params.id || $route.params"
        @Update="getTasks"
      />
    </q-page-container>
  </q-layout>
</template>
