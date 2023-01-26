<script setup>
import { ref } from "vue";

const props = defineProps({
  sub_task: Object,
  index: Number,
});

const state = ref(props.sub_task.state);
function onLeft() {}

function invertState() {
  state.value = !state.value;
}
</script>

<template>
  <div>
    <q-slide-item
      @left="onLeft"
      @right="$emit('delete', sub_task.id), $emit('erase', index)"
      @click.stop="$emit('changeState', sub_task.id), invertState()"
      right-color="red"
      style="
        border-top: 1px solid LightGray;
        border-bottom: 1px solid LightGray;
      "
    >
      <template v-slot:right>
        <q-icon name="delete" />
      </template>
      <q-item :class="state ? 'text-white bg-green' : ''">
        <div class="flex justify-center">
          <q-icon
            :name="state ? 'done' : 'remove'"
            size="30px"
            style="margin: auto"
          ></q-icon>
        </div>
        <q-item-section class="text-h6 q-pa-xs" style="line-break: anywhere">{{
          sub_task.task_name
        }}</q-item-section>
      </q-item>
    </q-slide-item>
  </div>
</template>
