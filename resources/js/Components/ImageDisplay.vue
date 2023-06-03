<template>
  <div
    id="ImageDisplay"
    class="fixed z-50 top-0 left-0 w-full h-full bg-black bg-opacity-80"
  >
    <!-- NOTE: isImageDisplay is the image url -->
    <Close
      @click="isImageDisplay = null"
      fillColor="#000000"
      :size="30"
      class="absolute right-0 p-1 m-3 bg-gray-200 rounded-full cursor-pointer"
    />
    <!-- NOTE: place-items-center: image is dead-centre on the screen -->
    <div class="grid h-screen place-items-center">
      <!-- 
        TIP: 
        "object-scale-down": scale down an image or video element to fit within its container 
        while maintaining its aspect ratio.

        - If the image or video is larger than the container, it will be scaled down proportionally 
        to fit without losing its original aspect ratio.
     -->
      <img :src="isImageDisplay" class="h-screen p-10 object-scale-down" />
    </div>
  </div>
</template>

<script setup>
import Close from "vue-material-design-icons/Close.vue";

// Pinia
import { useGeneralStore } from "@/stores/general";
import { storeToRefs } from "pinia";
const useGeneral = useGeneralStore();
const { isImageDisplay } = storeToRefs(useGeneral);
</script>
