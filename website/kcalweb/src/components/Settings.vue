<template>
  <span class="p-text-secondary block mb-5"
    >Enter maximum calories and macros</span
  >
  <div v-if="!isLoading" class="container">
    <IconField>
      <FloatLabel>
        <InputNumber id="maxKcal" v-model="maxKcal" :useGrouping="false" />
        <label for="maxKcal">Maximum kcal</label>
      </FloatLabel>
    </IconField>

    <IconField>
      <FloatLabel>
        <InputNumber
          id="maxProtein"
          v-model="maxProtein"
          :useGrouping="false"
        />
        <label for="maxProtein">Maximum protein</label>
      </FloatLabel>
    </IconField>

    <IconField>
      <FloatLabel>
        <InputText id="maxFat" v-model="maxFat" :useGrouping="false" />
        <label for="maxFat">Maximum fat</label>
      </FloatLabel>
    </IconField>

    <IconField>
      <FloatLabel>
        <InputNumber id="maxCarbs" v-model="maxCarbs" :useGrouping="false" />
        <label for="maxCarbs">Maximum carbs</label>
      </FloatLabel>
    </IconField>

    <Button
      type="button"
      label="Cancel"
      severity="secondary"
      class="mr-4"
      @click="handleCancelSaveSettings"
    ></Button>
    <Button type="button" label="Save" @click="handleSaveSettings"></Button>
  </div>
  <ProgressSpinner
    v-else
    style="width: 50px; height: 50px"
    strokeWidth="8"
    fill="var(--surface-ground)"
    animationDuration=".5s"
    aria-label="Custom ProgressSpinner"
  />
</template>

<script setup>
import { onMounted } from "vue";
import apiClient from "../apiClient";
import { ref, defineEmits } from "vue";
import { useToast } from "primevue/usetoast";

let toast = useToast();
let isLoading = ref(true);
const emit = defineEmits(["cancelSaveSettings, saveSettings"]);

const handleSaveSettings = async () => {
  try {
    await apiClient.saveSettings({
      maxKcal: maxKcal.value,
      maxProtein: maxProtein.value,
      maxFat: maxFat.value,
      maxCarbs: maxCarbs.value,
    });
    toast.add({
      severity: "success",
      summary: "Success",
      detail: "Settings saved",
      life: 3000,
    });
  } catch (error) {
    console.error(error);
    toast.add({
      severity: "error",
      summary: "Error",
      detail: "Failed to save settings",
    });
  }
  emit("saveSettings");
};

const handleCancelSaveSettings = () => {
  emit("cancelSaveSettings");
};

let maxKcal = ref(0);
let maxProtein = ref(0);
let maxFat = ref(0);
let maxCarbs = ref(0);

onMounted(async () => {
  const response = await apiClient.getSettings();
  maxKcal.value = response.maxKcal;
  maxProtein.value = response.maxProtein;
  maxFat.value = response.maxFat;
  maxCarbs.value = response.maxCarbs;
  isLoading.value = false;
});
</script>

<style scoped>
.container > * {
  margin-top: 20px; /* Adjust as needed */
}
.mr-4 {
  margin-right: 1rem; /* Adjust as needed */
}
</style>
