<template>
  <span class="p-text-secondary block mb-5"
    >Enter macro information about your meal</span
  >
  <div class="container">
    <IconField>
      <FloatLabel>
        <InputText id="name" v-model="name" />
        <label for="name">Name</label>
      </FloatLabel>
    </IconField>

    <IconField>
      <FloatLabel>
        <InputNumber id="protein" v-model="protein" :useGrouping="false" />
        <label for="protein">Protein</label>
      </FloatLabel>
    </IconField>

    <IconField>
      <FloatLabel>
        <InputNumber id="fat" v-model="fat" :useGrouping="false" />
        <label for="fat">Fat</label>
      </FloatLabel>
    </IconField>

    <IconField>
      <FloatLabel>
        <InputNumber id="carbs" v-model="carbs" :useGrouping="false" />
        <label for="carbs">Carbs</label>
      </FloatLabel>
    </IconField>

    <IconField>
      <FloatLabel>
        <InputNumber id="kcal" v-model="kcal" :useGrouping="false" />
        <label for="kcal">Kcal</label>
      </FloatLabel>
    </IconField>

    <Button
      type="button"
      label="Cancel"
      severity="secondary"
      class="mr-4"
      @click="handleCancelAddMeal"
    ></Button>
    <Button type="button" label="Save" @click="handleSaveMeal"></Button>
  </div>
</template>

<script setup>
import { defineProps, ref } from "vue";
import apiClient from "../apiClient";

const name = ref("");
const protein = ref(0);
const fat = ref(0);
const carbs = ref(0);
const kcal = ref(0);

const props = defineProps({
  section: {
    type: String,
    required: true,
  },
  consumptionDate: {
    type: String,
    required: true,
  },
});

const emit = defineEmits(["cancelAddMeal, saveMeal"]);

const handleSaveMeal = async () => {
  if (name.value.trim() === "") {
    alert("Name cannot be empty");
    return;
  }

  if (protein.value < 0 || fat.value < 0 || carbs.value < 0 || kcal.value < 0) {
    alert("Values cannot be negative");
    return;
  }

  const meal = {
    name: name.value,
    protein: protein.value,
    fat: fat.value,
    carbs: carbs.value,
    kcal: kcal.value,
    section: props.section,
    consumptionDate: props.consumptionDate,
  };

  try {
    await apiClient.addMeal(meal);
    emit("saveMeal");
  } catch (error) {
    console.error(error);
  }
};

const handleCancelAddMeal = () => {
  emit("cancelAddMeal");
};
</script>

<style scoped>
.container > * {
  margin-top: 20px; /* Adjust as needed */
}
.mr-4 {
  margin-right: 1rem; /* Adjust as needed */
}
</style>
