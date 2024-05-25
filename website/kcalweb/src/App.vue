<template>
  <div>
    <Toast></Toast>
    <NavBar @settingsChanged="handleSettingsChanged" />
    <Home :key="componentKey" />
  </div>
</template>

<script setup>
import Home from "./components/Home.vue";
import NavBar from "./components/NavBar.vue";

import { ref } from "vue";

let componentKey = ref(0);

const handleSettingsChanged = () => {
  componentKey.value++;
};
</script>
