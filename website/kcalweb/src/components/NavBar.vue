<template>
  <Dialog
    v-model:visible="isSettingsDialogVisible"
    closeOnEscape
    :draggable="false"
    header="Settings"
    :style="{ width: '25rem' }"
    position="right"
  >
    <Settings
      @cancelSaveSettings="handleCancelSaveSettings"
      @saveSettings="handleSaveSettings"
    />
  </Dialog>
  <div class="right">
    <i
      class="pi pi-cog"
      style="font-size: 2.5rem"
      @click="isSettingsDialogVisible = true"
    ></i>
  </div>
</template>

<script setup>
import { ref } from "vue";
import { useToast } from "primevue/usetoast";
import Settings from "./Settings.vue";

let toast = useToast();

let emit = defineEmits(["settingsChanged"]);

const isAddMealDialogVisible = ref(false);
const isSettingsDialogVisible = ref(false);

const items = ref([
  {
    label: "Settings",
    icon: "pi pi-cog",
    command: () => {
      isSettingsDialogVisible.value = true;
    },
  },
]);

const handleSaveSettings = () => {
  isSettingsDialogVisible.value = false;
  emit("settingsChanged");
};

const handleCancelSaveSettings = () => {
  toast.add({
    severity: "warn",
    detail: "Settings not saved",
    life: 4000,
  });
  isSettingsDialogVisible.value = false;
};
</script>

<style scoped>
.right {
  float: right;
  margin-bottom: 10px;
  padding-right: 4rem;
  font-size: 4rem;
}
.right:hover {
  cursor: pointer;
  color: #a78bfa;
  transition: 0.5s;
}
</style>
