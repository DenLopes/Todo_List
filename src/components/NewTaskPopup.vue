<script setup>
import axios from "axios";
import { defineComponent, ref, onMounted } from "vue";

defineComponent({
  name: "NewTaskPopup",
});

const emit = defineEmits(["getTask"]);

const newTaskOpen = ref(false);
const task = ref({ title: null, description: null });
const sub_tasks = ref([null]);

function addTask() {
  sub_tasks.value.push(null);
}

function subTask(n) {
  if (sub_tasks.value.length > 1) {
    sub_tasks.value.splice(n, 1);
  }
}

function toggleNewTask() {
  task.value = { title: null, description: null };
  sub_tasks.value = [null];
  newTaskOpen.value = !newTaskOpen.value;
}

function accept() {
  if (task.value.title) {
    axios.post("/task", {
      title: task.value.title,
      description: task.value.description,
    });
    axios.post("/sub_task", {
      sub_tasks: sub_tasks.value,
    });
  }

  setTimeout(() => {
    emit("getTask");
  }, 500);
}

function decline() {}

defineExpose({
  toggleNewTask,
});

onMounted(() => {});
</script>

<template>
  <div class="q-pa-md q-gutter-sm">
    <q-dialog v-model="newTaskOpen" persistent>
      <q-card style="width: 450px; max-width: 80vw">
        <q-card-section class="flex justify-between">
          <div class="text-h6">Nova tarefa</div>
          <q-btn
            flat
            color="primary"
            label="Adicionar tarefa"
            padding="xs"
            @click="addTask"
          />
        </q-card-section>

        <q-separator />

        <q-card-section style="max-height: 70vh" class="scroll">
          <div class="flex">
            <q-input
              clearable
              v-model="task.title"
              label="Titulo"
              :rules="[(val) => !!val || 'Escreva um titulo']"
              autogrow
            />
          </div>

          <div>
            <q-input
              clearable
              v-model="task.description"
              label="Descrição"
              class="q-pb-md"
              autogrow
            />
          </div>
          <div class="flex column reverse">
            <q-item
              class="flex column"
              v-for="(task, index) in sub_tasks"
              :key="index"
            >
              <div class="flex justify-between">
                <div class="flex">
                  <div
                    class="flex justify-center"
                    style="height: 56px; width: 40px"
                  >
                    <q-icon name="lens" size="10px" style="margin: auto" />
                  </div>

                  <q-input
                    v-model="sub_tasks[index]"
                    label="A ser feito"
                    :rules="[(val) => !!val || 'Escreva uma task']"
                    autogrow
                  />
                </div>

                <div class="flex">
                  <q-btn
                    flat
                    rounded
                    color="primary"
                    icon="close"
                    @click="subTask(index)"
                    style="margin: auto"
                  />
                </div>
              </div>
            </q-item>
          </div>
        </q-card-section>

        <q-separator />

        <q-card-actions align="right">
          <q-btn
            flat
            label="Recusar"
            color="primary"
            @click="decline"
            v-close-popup
          />
          <q-btn
            flat
            label="Aceitar"
            color="primary"
            @click="accept"
            v-close-popup
          />
        </q-card-actions>
      </q-card>
    </q-dialog>
  </div>
</template>
