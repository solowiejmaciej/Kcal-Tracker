<template>
  <Dialog
    v-model:visible="isAddMealDialogVisible"
    closeOnEscape
    :draggable="false"
    :header="'Add meal to ' + selectedSection"
  >
    <AddMeal
      :section="selectedSection"
      :consumptionDate="getDate(currentDate)"
      @cancelAddMeal="handleCancelAddMeal"
      @saveMeal="handleSaveMeal"
    />
  </Dialog>
  <div class="wrapper">
    <div class="card container">
      <div class="center">
        <Calendar v-model="currentDate" showIcon :showOnFocus="false" />
      </div>
      <Accordion :activeIndex="[0, 1, 2]" :multiple="true">
        <AccordionTab>
          <template #header>
            <div style="font-size: 2rem">Breakfast</div>
            <div class="right">
              <i
                class="pi pi-plus-circle addMeal"
                @click.stop="addMeal('Breakfast')"
                style="font-size: 1.75rem"
              ></i>
            </div>
          </template>
          <MealView
            v-if="meals"
            :meals="meals"
            :section="'Breakfast'"
            @deleteMeal="handleDeleteMeal($event)"
          />
          <Skeleton v-else height="4rem" borderRadius="16px"></Skeleton>
        </AccordionTab>
        <AccordionTab>
          <template #header>
            <div style="font-size: 2rem">Lunch</div>
            <div class="right">
              <i
                class="pi pi-plus-circle addMeal"
                @click.stop="addMeal('Lunch')"
                style="font-size: 1.75rem"
              ></i>
            </div>
          </template>
          <MealView
            v-if="meals"
            :meals="meals"
            :section="'Lunch'"
            @deleteMeal="handleDeleteMeal($event)"
          />
          <Skeleton v-else height="4rem" borderRadius="16px"></Skeleton>
        </AccordionTab>
        <AccordionTab>
          <template #header>
            <div style="font-size: 2rem">Dinner</div>
            <div class="right">
              <i
                class="pi pi-plus-circle addMeal"
                @click.stop="addMeal('Dinner')"
                style="font-size: 1.75rem"
              ></i>
            </div>
          </template>
          <MealView
            v-if="meals"
            :meals="meals"
            :section="'Dinner'"
            @deleteMeal="handleDeleteMeal($event)"
          />
          <Skeleton v-else height="4rem" borderRadius="16px"></Skeleton>
        </AccordionTab>
      </Accordion>
    </div>
    <div class="dashboard" v-if="meals">
      <Dashboard :meals="meals" :key="componentKey"></Dashboard>
    </div>
  </div>
</template>

<script setup>
import { ref } from "vue";
import MealView from "./MealView.vue";
import { onMounted, watch } from "vue";
import AddMeal from "./AddMeal.vue";
import { useToast } from "primevue/usetoast";
import Dashboard from "./Dashboard.vue";
import apiClient from "../apiClient";

let toast = useToast();

let selectedSection = ref(null);
let isAddMealDialogVisible = ref(false);
let currentDate = ref(new Date());

let meals = ref(null);

let componentKey = ref(0);

onMounted(async () => {
  await getData();
});

const handleDeleteMeal = async () => {
  await getData();
};

const addMeal = (section) => {
  selectedSection.value = section;
  isAddMealDialogVisible.value = true;
};

const handleSaveMeal = async () => {
  isAddMealDialogVisible.value = false;
  toast.add({
    severity: "success",
    summary: "Success",
    detail: "Meal added",
    life: 4000,
  });
  await getData();
};

const handleCancelAddMeal = () => {
  console.log("cancel meal");
  isAddMealDialogVisible.value = false;
  toast.add({
    severity: "warn",
    detail: "Meal not added",
    life: 4000,
  });
};

const getData = async () => {
  try {
    const formattedDate = getDate(currentDate.value);
    console.log(formattedDate);
    const response = await apiClient.getMeals(formattedDate);
    meals.value = response;
    componentKey.value++;
  } catch (error) {
    console.error(error);
    toast.add({
      severity: "error",
      summary: "Error",
      detail: "Failed to get meals",
    });
  }
};

watch(currentDate, async () => {
  await getData();
});

const getDate = (date) => {
  let newDate = new Date(
    Date.UTC(date.getFullYear(), date.getMonth(), date.getDate())
  );
  newDate.setUTCDate(newDate.getUTCDate());
  return newDate.toISOString().slice(0, 10);
};
</script>

<style scoped>
.container {
  margin-top: 2rem;
  width: 40%;
}

.right {
  width: 100%;
  display: flex;
  justify-content: flex-end;
}

.addMeal {
  color: rgb(129, 233, 129);
  cursor: pointer;
}

.wrapper {
  margin-top: 1rem;
  display: flex;
  justify-content: space-between;
}

.dashboard {
  width: 60%;
  display: flex;
  justify-content: center;
}

.card {
  margin: 0;
}
.center {
  padding-bottom: 15px;
  text-align: center;
}
</style>
