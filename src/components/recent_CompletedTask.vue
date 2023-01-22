<script setup>
import { defineComponent } from "vue";

const props = defineProps({
  completedTask: Object,
});

defineComponent({
  name: "recent_CompletedTask",
});

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
</script>

<template>
  <q-card flat bordered class="my-box q-mb-xs">
    <q-card-section>
      <div class="text-h6" style="line-break: anywhere">
        {{ completedTask.parent_task_name }}
      </div>
    </q-card-section>
    <q-card-section class="flex justify-between bg-green text-white">
      <div class="flex">
        <div class="flex justify-center">
          <q-icon name="done" size="25px" class="q-mr-sm"></q-icon>
        </div>
        <div
          class="flex column justify-center"
          style="line-break: anywhere; max-width: 95%"
        >
          {{ completedTask.task_name }}
        </div>
      </div>
      <div class="text-subtitle">
        {{ formatDate(completedTask.updated_at) }}
      </div>
    </q-card-section>
  </q-card>
</template>
