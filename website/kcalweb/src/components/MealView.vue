<template>
  <div
    v-for="(meal, index) in props.meals.filter(
      (meal) => meal.section === props.section
    )"
    :key="index"
    class="container"
  >
    <i
      class="pi pi-times-circle delete"
      style="font-size: 1.75rem"
      @click="
        handleDeleteMeal(
          props.meals.filter((meal) => meal.section === props.section)[index].id
        )
      "
    ></i>
    <h3>
      {{ meal.name }}
    </h3>
    <Chip class="chip">Protein: {{ meal.protein }}g</Chip>
    <Chip class="chip">Fat: {{ meal.fat }}g</Chip>
    <Chip class="chip">Carbs: {{ meal.carbs }}g</Chip>
    <Chip class="chip">Kcal: {{ meal.kcal }}</Chip>
  </div>
</template>

<script setup>
import { defineProps } from "vue";
import apiClient from "../apiClient";

let emit = defineEmits(["deleteMeal"]);

const props = defineProps({
  meals: {
    type: Array,
    required: true,
  },
  section: {
    type: String,
    required: true,
  },
});

const handleDeleteMeal = async (id) => {
  try {
    await apiClient.delete(`/meals/${id}`);
    emit("deleteMeal", id);
  } catch (error) {
    console.error(error);
  }
};
</script>

<style scoped>
.container {
  margin: 1rem;
  padding: 1rem;
  border: 1px solid #ccc;
  border-radius: 5px;
}

.chip {
  margin-right: 0.5rem;
}

.delete {
  float: right;
  cursor: pointer;
  color: rgb(216, 103, 103);
}
</style>
