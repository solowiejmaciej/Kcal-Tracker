import axios from "axios";

const baseUrl = "http://127.0.0.1:8000/api/";

const apiClient = axios.create({
  baseURL: baseUrl,
});

apiClient.getSettings = async function () {
  try {
    const response = await this.get("settings");
    return response.data;
  } catch (error) {
    if (error.response && error.response.status === 404) {
      return {
        maxKcal: 2500,
        maxProtein: 100,
        maxCarbs: 234,
        maxFat: 64,
      };
    }
    console.error(error);
  }
};

apiClient.saveSettings = async function (settings) {
  try {
    const response = await this.post("settings", settings);
    return response.data;
  } catch (error) {
    console.error(error);
  }
};

apiClient.getMeals = async function (currentDate) {
  try {
    const response = await this.get("meals", {
      params: {
        searchDate: currentDate,
      },
    });
    return response.data;
  } catch (error) {
    if (error.response && error.response.status === 404) {
      return [];
    }
    console.error(error);
  }
};
apiClient.addMeal = async function (meal) {
  try {
    console.log(meal);
    const response = await this.post("meals", meal);
    return response.data;
  } catch (error) {
    console.error(error);
  }
};

apiClient.deleteMeal = async function (id) {
  try {
    const response = await this.delete(`meals/${id}`);
    return response.data;
  } catch (error) {
    console.error(error);
  }
};

export default apiClient;
