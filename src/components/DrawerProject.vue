<script setup>
import { defineComponent } from "vue";

const props = defineProps({
  title: String,
  date: String,
  id: Number,
});

defineComponent({
  name: "DrawerTask",
});
</script>

<template>
  <q-item
    :to="$route.path === `/task/${id}` ? '#' : `/task/${id}`"
    clickable
    v-ripple
  >
    <q-item-section avatar top>
      <q-avatar icon="article" color="grey" text-color="white" />
    </q-item-section>

    <q-item-section>
      <q-item-label style="line-break: anywhere">{{ title }}</q-item-label>
      <q-item-label caption>{{ date }}</q-item-label>
    </q-item-section>
  </q-item>
</template>
