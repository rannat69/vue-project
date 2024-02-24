<template>
  <div>
    <p>Enter minimum life expectancy to filter the chart</p>
    <input
      type="number"
      v-model="filterValue"
      placeholder="Enter minimum life expectancy"
    />
    <v-chart class="chart" :option="filteredOption" autoresize />
  </div>
</template>

<script setup>
import { use } from "echarts/core";
import { CanvasRenderer } from "echarts/renderers";
import { PieChart, LineChart, BarChart } from "echarts/charts";
import {
  TitleComponent,
  TooltipComponent,
  LegendComponent,
  GridComponent,
} from "echarts/components";
import VChart, { THEME_KEY } from "vue-echarts";
import { ref, provide, toRaw, computed } from "vue";

import config from "../config.json";

use([
  CanvasRenderer,
  PieChart,
  LineChart,
  BarChart,
  GridComponent,
  TitleComponent,
  TooltipComponent,
  LegendComponent,
]);

provide(THEME_KEY, "dark");

const itemsX = ref([]);
const items = ref([]);

// Get url to php API from config.json
const url = config.apiPHPUrl + config.apiPHPLifeExpectancy;

fetch(url)
  .then((response) => response.json())
  .then((data) => {
    for (let i = 0; i < data.length; i++) {
      let item = {
        value: data[i]["2020"],
        name: data[i].Country_Name,
      };

      let itemX = data[i].Country_Name;
      itemsX.value.push(itemX);

      items.value.push(item);
    }
  })
  .catch((error) => console.error(error));

const filterValue = ref(0);

// Filter items based on filterValue
const filteredItems = computed(() => {
  return items.value.filter((item) => item.value > filterValue.value);
});

const filteredItemsX = computed(() => {
  const filteredIndexes = items.value
    .map((item) => item.value > filterValue.value)
    .map((value, index) => (value ? index : -1))
    .filter((index) => index !== -1);

  return itemsX.value.filter((_, index) => filteredIndexes.includes(index));
});

const option = ref({
  title: {
    text: "Life expectancy 2020 per country",
    left: "center",
  },
  tooltip: {
    trigger: "item",
    formatter: "{a} <br/>{b} : {c} ({d}%)",
  },
  xAxis: {
    type: "category",
    boundaryGap: false,
    data: filteredItemsX.value,
  },
  yAxis: {
    type: "value",
  },
  series: [
    {
      name: "Life expectancy",
      type: "bar",
      stack: "Total",
      data: filteredItems.value,
      emphasis: {
        itemStyle: {
          shadowBlur: 10,
          shadowOffsetX: 0,
          shadowColor: "rgba(0, 0, 0, 0.5)",
        },
      },
    },
  ],
});

const filteredOption = computed(() => {
  const filteredOptionValue = { ...option.value };
  filteredOptionValue.xAxis.data = filteredItemsX.value;
  filteredOptionValue.series[0].data = filteredItems.value;
  return filteredOptionValue;
});
</script>

<style scoped>
.chart {
  height: 100vh;
}
</style>
