<script setup>
import { ref } from "vue";
const props = defineProps({
  task: Object,
});

const confirm = ref(false);

function formatDate(created_at) {
  const date = new Date(created_at);
  return date.toLocaleDateString("default", {
    month: "long",
    day: "numeric",
    year: "numeric",
  });
}
</script>

<template>
  <router-link
    :to="`task/${task.id}`"
    style="text-decoration: none; color: inherit"
  >
    <q-card flat bordered class="my-box cursor-pointer q-hoverable q-mb-xs">
      <span class="q-focus-helper"></span>
      <q-card-section class="bg-primary text-white">
        <div class="flex justify-between">
          <div class="text-h6" style="line-break: anywhere; max-width: 80%">
            {{ task.title }}
          </div>
          <div>
            <q-btn
              flat
              round
              icon="delete_outline"
              @click.prevent="confirm = true"
              size="20px"
            />
          </div>
        </div>
        <div class="text-subtitle">{{ formatDate(task.created_at) }}</div>
        <q-dialog v-model="confirm" persistent>
          <q-card>
            <q-card-section class="row items-center">
              <q-avatar color="red" icon="delete" text-color="white" />
              <span class="q-ml-sm"
                >Você tem certeza que deseja excluir a Tarefa ?</span
              >
            </q-card-section>

            <q-card-actions align="right">
              <q-btn flat label="Cancelar" color="primary" v-close-popup />
              <q-btn
                flat
                label="Deletar"
                color="red"
                v-close-popup
                @click="$emit('delete', task.id)"
              />
            </q-card-actions>
          </q-card>
        </q-dialog>
      </q-card-section>
      <q-card-section style="line-break: anywhere">{{
        task.description
      }}</q-card-section>
    </q-card>
  </router-link>
</template>
