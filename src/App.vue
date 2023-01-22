<script setup>
import { useQuasar } from "quasar";
import { defineComponent } from "vue";
import axios from "axios";
axios.defaults.baseURL = "http://localhost:8000/api";
defineComponent({
  name: "App",
});
</script>

<template>
  <router-view />
</template>
