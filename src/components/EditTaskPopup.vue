<script setup>
import axios from "axios";
import { defineComponent, ref, onMounted, toRef } from "vue";

const props = defineProps({
  task: Object,
  sub_tasks: Object,
});

defineComponent({
  name: "EditTaskPopup",
});

const emit = defineEmits(["getTask"]);

const newTaskOpen = ref(false);
const task = toRef(props, "task");
const sub_tasks = toRef(props, "sub_tasks");

function addTask() {
  console.log(sub_tasks);
  sub_tasks.value.push({ task_name: "" });
}

function subTask(n) {
  if (sub_tasks.value.length > 1) {
    sub_tasks.value.splice(n, 1);
  }
}

function toggleEditTask() {
  newTaskOpen.value = !newTaskOpen.value;
}

async function accept() {
  try {
    await axios.put(`task/${task.value.id}`, {
      title: task.value.title,
      description: task.value.description,
    });
  } catch (error) {
    console.error(error);
  }
}

async function addSubTask() {
  try {
    await axios.put("/sub_tasks/all", { subTasks: sub_tasks.value });
  } catch (error) {
    console.error(error);
  }
  emit("getTask");
}

function decline() {
  emit("getTask");
}

defineExpose({
  toggleEditTask,
});

onMounted(() => {
  console.log(sub_tasks.value);
});
</script>

<template>
  <div class="q-pa-md q-gutter-sm">
    <q-dialog v-model="newTaskOpen" persistent>
      <q-card style="width: 450px; max-width: 80vw">
        <q-card-section class="flex justify-between">
          <div class="text-h6">Editar tarefas</div>
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
          <q-item
            class="flex column"
            v-for="(sub_task, index) in sub_tasks"
            :key="sub_task"
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
                  v-model="sub_tasks[index].task_name"
                  label="A ser feito"
                  :rules="[(val) => !!val || 'Escreva uma task']"
                  autogrow
                />
              </div>

              <div class="flex">
                <q-btn
                  flat
                  color="primary"
                  icon="close"
                  @click="$emit('deleteSubTask', sub_task.id), subTask(index)"
                  style="margin: auto"
                />
              </div>
            </div>
          </q-item>
        </q-card-section>

        <q-separator />

        <q-card-actions align="right">
          <q-btn
            flat
            label="Voltar"
            color="primary"
            @click="decline"
            v-close-popup
          />
          <q-btn
            flat
            label="Aceitar"
            color="primary"
            @click="accept(), addSubTask()"
            v-close-popup
          />
        </q-card-actions>
      </q-card>
    </q-dialog>
  </div>
</template>
