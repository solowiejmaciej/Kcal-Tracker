<template>
  <div class="container">
    <div>
      <div class="wrapper">
        <div class="kcal" v-if="isLoaded">
          <Knob
            v-model="kcal"
            :min="0"
            :max="maxKcalForKnob"
            readonly
            :valueColor="kcalColor"
            size="250"
          />
          <h2>Kcal: {{ kcal }} / {{ maxKcal }}</h2>
        </div>
        <Skeleton v-else shape="circle" size="12rem" class="kcal"></Skeleton>
        <div class="macors">
          <div class="macroItem" v-if="isLoaded">
            <Knob
              v-model="protein"
              :max="maxProteinForKnob"
              :valueColor="proteinColor"
              readonly
              size="150"
            />
            <h3>Protein: {{ protein }} / {{ maxProtein }}</h3>
          </div>
          <Skeleton
            v-else
            shape="circle"
            size="10rem"
            class="macroItem"
          ></Skeleton>

          <div class="macroItem" v-if="isLoaded">
            <Knob
              v-model="fat"
              :min="0"
              :max="maxFatForKnob"
              :valueColor="fatColor"
              readonly
              size="150"
            />
            <h3>Fat: {{ fat }} / {{ maxFat }}</h3>
          </div>
          <Skeleton
            v-else
            shape="circle"
            size="10rem"
            class="macroItem"
          ></Skeleton>

          <div class="macroItem" v-if="isLoaded">
            <Knob
              v-model="carbs"
              :min="0"
              :max="maxCarbsForKnob"
              :valueColor="carbsColor"
              readonly
              size="150"
            />
            <h3>Carbs: {{ carbs }} / {{ maxCarbs }}</h3>
          </div>
          <Skeleton
            v-else
            shape="circle"
            size="10rem"
            class="macroItem"
          ></Skeleton>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import apiClient from "../apiClient";

const props = defineProps({
  meals: {
    type: Array,
    required: true,
  },
});

let isLoaded = ref(false);

let protein = ref(0);
let fat = ref(0);
let kcal = ref(0);
let carbs = ref(0);

let maxProteinForKnob = ref(0);
let maxFatForKnob = ref(0);
let maxKcalForKnob = ref(0);
let maxCarbsForKnob = ref(0);

let maxProtein = ref(0);
let maxFat = ref(0);
let maxKcal = ref(0);
let maxCarbs = ref(0);

let proteinColor = ref("cornflowerblue");
let fatColor = ref("khaki");
let kcalColor = ref("indigo");
let carbsColor = ref("LightGreen");

onMounted(async () => {
  protein.value = props.meals.reduce(
    (total, meal) =>
      total + (typeof meal.protein === "number" ? meal.protein : 0),
    0
  );
  fat.value = props.meals.reduce(
    (total, meal) => total + (typeof meal.fat === "number" ? meal.fat : 0),
    0
  );
  kcal.value = props.meals.reduce(
    (total, meal) => total + (typeof meal.kcal === "number" ? meal.kcal : 0),
    0
  );
  carbs.value = props.meals.reduce(
    (total, meal) => total + (typeof meal.carbs === "number" ? meal.carbs : 0),
    0
  );

  await apiClient.getSettings().then((response) => {
    maxProtein.value = response.maxProtein;
    maxFat.value = response.maxFat;
    maxKcal.value = response.maxKcal;
    maxCarbs.value = response.maxCarbs;
  });

  if (protein.value > maxProtein.value) {
    maxProteinForKnob.value = protein.value;
    proteinColor.value = "red";
  } else {
    maxProteinForKnob.value = maxProtein.value;
  }

  if (fat.value > maxFat.value) {
    maxFatForKnob.value = fat.value;
    fatColor.value = "red";
  } else {
    maxFatForKnob.value = maxFat.value;
  }

  if (kcal.value > maxKcal.value) {
    maxKcalForKnob.value = kcal.value;
    kcalColor.value = "red";
  } else {
    maxKcalForKnob.value = maxKcal.value;
  }

  if (carbs.value > maxCarbs.value) {
    maxCarbsForKnob.value = carbs.value;
    carbsColor.value = "red";
  } else {
    maxCarbsForKnob.value = maxCarbs.value;
  }

  isLoaded.value = true;
});
</script>

<style scoped>
.kcal {
  display: flex;
  flex-direction: column;
  align-items: center;
}

.macors {
  display: flex;
  margin-top: 2rem;
}
.wrapper {
  margin-top: 30%;
  display: grid;
  text-align: center;
}
</style>
